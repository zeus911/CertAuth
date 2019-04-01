<?php

namespace App\Http\Controllers;

use Request;
use App\Cert;
use File;
use DateTime;

class MgmtController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $certs = Cert::all();
        $certsNumber = Cert::all()->count();

        $searchCerts = \Request::get('details');

        $certs =  Cert::where('subjectCommonName','like','%'.$searchCerts.'%')
        ->orderBy('id')
        ->paginate('200');

        foreach ($certs as $cert) {
         $id = $cert->id;
         $subjectCommonName = $cert->subjectCommonName;

         $parse_cert = $cert->publicKey;
         dd($parse_cert);
         $validTo = date_create( '@' .  $parse_cert['validTo_time_t'])->format('c');
         $today = new DateTime(today());
         $validToDate = new DateTime($validTo);
         $daysLeftToExpire = (string)$validToDate->diff($today)->days;
         Cert::where('subjectCommonName', $subjectCommonName)->update(['expiryDate' => $daysLeftToExpire]);

         // calculate days left to expire and update DB.
         $validTo_time_t = $cert->validTo_time_t;
         if ($validTo_time_t != null){
         $validTo_time_t = $cert->validTo_time_t;
         $validTo = date_create( '@' .  $validTo_time_t)->format('c');
         $today = new DateTime(today());
         $validToDate = new DateTime($validTo);
         $daysLeftToExpire = (string)$validToDate->diff($today)->days;
          Cert::where('subjectCommonName', $subjectCommonName)->update(['expiryDate' => $daysLeftToExpire]);
         }
         if (empty($cert->publicKey)){
            $status = null;
            Cert::where('subjectCommonName', $subjectCommonName)->update(['status' => $status]);
         } elseif ($cert->status == 'Revoked'){
            $status = 'Revoked';
         } elseif ($validToDate > $today){
            $status = 'Valid';
            Cert::where('subjectCommonName', $subjectCommonName)->update(['status' => $status]);
         } elseif ($validToDate < $today){
            $status = 'Expired';
            Cert::where('subjectCommonName', $subjectCommonName)->update(['status' => $status]);
         } elseif ($daysLeftToExpire <= 30) {
            $status = 'Expiring';
            Cert::where('subjectCommonName', $subjectCommonName)->update(['status' => $status]);
         } else {
            $status = $cert->status;
         }
        }
         return view ('certs.mgmt.index', array(
          'certs' => $certs,
          'certsNumber' => $certsNumber
          ));
    }

    public function details()
    {
      if(isset($_POST['subjectCommonName']) && !empty($_POST['subjectCommonName'])) {

      $subjectCommonName = $_POST['subjectCommonName'];

      // Getting Collection from Certs.
      $certs = Cert::where('subjectCommonName', $subjectCommonName)->get()->first();

      // Getting data from DB.
      $id = $certs->id;
      $certificateServerRequest = $certs->certificateServerRequest;
      $publicKey = $certs->publicKey;
      $privateKey = $certs->privateKey;
      $p12 = $certs->p12;
      $status = $certs->status;

      // Posible values from $status.
      if (empty($certs->publicKey)){
        $status = null;
        $daysLeftToExpire = null;
      } else {
          $status = $certs->status;
      }
      //$email = $certs->email;
      $created_at = $certs->created_at;
      $updated_at = $certs->updated_at;

      // Getting x509 Attributes from certificate.
      $parse_cert = openssl_x509_parse($publicKey);
      $issuer = $parse_cert['issuer'];
      $issuerCN = $issuer['CN'];
      $signatureTypeSN = $parse_cert['signatureTypeSN'];
      $serialNumber = $parse_cert['serialNumber']; // Decimal format by default
      $serialNumberHex = dechex($parse_cert['serialNumber']); // Hexadecimal format
      $extensions = $parse_cert['extensions'];
      if(!isset($parse_cert['subject']['emailAddress'])){
        $email = '';
      } else {
        $email = $parse_cert['subject']['emailAddress'];

      }
      // For $extensionsSubjectAltName variable: checks if subjectAltName property is present, otherwise print N/A.
      if (empty($extensions['subjectAltName']))
      {
        $extensionsSubjectAltName = null;

      } else {

        $extensionsSubjectAltName = $extensions['subjectAltName'];
      }

      $extensionsKeyUsage = $extensions['keyUsage'];

      // Do not show if certificate do not have extendedKeyUsage.
      if (empty($extensions['extendedKeyUsage']))
      {
        $extensionsExtendedKeyUsage = null;

      } else {

        $extensionsExtendedKeyUsage = $extensions['extendedKeyUsage'];
      }
      // When just CSR/privateKey is created to be signed by an external CA, there is no certificate so I can´t get the data from it.
      if(empty($publicKey)) {
          return view('certs.mgmt.details', array(
            'subjectCommonName' => $subjectCommonName,
            'extensionsSubjectAltName' => $extensionsSubjectAltName,
            'issuerCN' => 'Only CSR/Key available. Certificate signed by an external CA',
            //'nsCertType' => $certs->certificate_type,
            'signatureTypeSN' => $certs->signatureTypeSN,
            //'key_length' => $cert->key_length,
            'serialNumber' => 'No Serial',
            'serialNumberHex' => 'No Serial',
            'extensions' => 'No Extensions',
            'extensionsKeyUsage' => 'No Key Usage',
            'extensionsExtendedKeyUsage' => 'No Extended Key Usage',
            'certificateServerRequest' => $certificateServerRequest,
            'publicKey' => null,
            'privateKey' => $privateKey,
            'status' => $status,
            'hasPFX' => $p12,
            'validFrom' => 'No Certificate Available',
            'updated_at' => $updated_at,
            'validTo' => 'No Certificate Available',
            'daysLeftToExpire' => 'N/A',
            'certs' => $certs
            ));

      } else {
        // Check if PFX archive and certificate exist.
        if ($p12 == 'PFX archive not generated. You have to re-generate it again if you renewed the certificate.')
        {
          $hasPFX = $p12;
          $validFrom = date_create( '@' .  $parse_cert['validFrom_time_t'])->format('c');
          $validTo = date_create( '@' .  $parse_cert['validTo_time_t'])->format('c');

        } else {
          $hasPFX = 'There is a PFX(P12) archive  for: ' . $subjectCommonName . '. Now you can download it or generate a new one.';
          $validFrom = date_create( '@' .  $parse_cert['validFrom_time_t'])->format('c');
          $validTo = date_create( '@' .  $parse_cert['validTo_time_t'])->format('c');
        }
      }
      // If cert exist calculate days left to expire and update expiryDate in DB.
      $today = new DateTime(today());
      $validToDate = new DateTime($validTo);
      $daysLeftToExpire = (string)$validToDate->diff($today)->days;
      //Cert::where('subjectCommonName', $subjectCommonName)->update(['expiryDate' => $daysLeftToExpire]);

      return view('certs.mgmt.details', array(
          'id' => $id,
          'subjectCommonName' => $subjectCommonName,
          'extensionsSubjectAltName' => $extensionsSubjectAltName,
          'issuerCN' => $issuerCN,
          'signatureTypeSN' => $signatureTypeSN,
          //'key_length' => $key_length,
          'serialNumber' => $serialNumber,
          'serialNumberHex' => $serialNumberHex,
          //'nsCertType' => $nsCertType,
          'extensionsKeyUsage' => $extensionsKeyUsage,
          'extensionsExtendedKeyUsage' => $extensionsExtendedKeyUsage,
          'certificateServerRequest' => $certificateServerRequest,
          'publicKey' => $publicKey,
          'privateKey' => $privateKey,
          'p12' => $p12,
          'status' => $status,
          'hasPFX' => $hasPFX,
          'created_at' => $created_at,
          'updated_at' => $updated_at,
          'validFrom' => $validFrom,
          'validTo' => $validTo,
          'daysLeftToExpire' => $daysLeftToExpire,
          'certs' => $certs
          ));
      }
    }

    public function update()
    {
      if(isset($_POST['subjectCommonName']) && !empty($_POST['subjectCommonName'])){

          return view('certs.mgmt.update', array(
          'subjectCommonName' => $_POST['subjectCommonName']));
      }
    }

    public function updated()
    {
      if(isset($_POST['subjectCommonName']) && isset($_POST['certificateServerRequest']) OR isset($_POST['publicKey']) OR isset($_POST['privateKey']) OR isset($_POST['comments']) &&
        !empty($_POST['subjectCommonName']) && !empty($_POST['certificateServerRequest']) OR !empty($_POST['publicKey']) OR !empty($_POST['privateKey'])) {

        $subjectCommonName = $_POST['subjectCommonName'];
        $certificateServerRequest = $_POST['certificateServerRequest'];
        $publicKey = $_POST['publicKey'];
        $privateKey = $_POST['privateKey'];
        $comments = $_POST['comments'];

        // if "certificateServerRequest" updated.
        if(isset($_POST['certificateServerRequest'])){
          Cert::where('subjectCommonName', $subjectCommonName)->update(['certificateServerRequest' => $certificateServerRequest]);
        }

        // If "publicKey" updated, get certificate data to update DB.
        if($publicKey != '') {
          $certParser = openssl_x509_parse($publicKey);
          //dd($certParser);
          $name = $certParser['name'];
          $subject = $certParser['subject'];
              $subjectCommonName = $certParser['subject']['CN'];
              //$subjectEmail = $certParser['subject']['emailAddress'];
              $subjectContry = $certParser['subject']['C'];
              //$subjectState = $certParser['subject']['ST'];
              //$subjectLocality = $certParser['subject']['L'];
              $subjectOrganization = $certParser['subject']['O'];
              //$subjectOrganizationUnit = $certParser['subject']['OU'];
          $hash = $certParser['hash'];
          $issuer = $certParser['issuer'];
              $issuerCN = $certParser['issuer']['CN'];
              $issuerContry = $certParser['issuer']['C'];
              //$issuerState = $certParser['issuer']['ST'];
              //$issuerLocality = $certParser['issuer']['L'];
              $issuerOrganization = $certParser['issuer']['O'];
              //$issuerOrganizationUnit = $certParser['issuer']['OU'];
          $version = $certParser['version'];
          $serialNumber = $certParser['serialNumber'];
          $serialNumberHex = $certParser['serialNumberHex'];
          $validFrom = $certParser['validFrom'];
          $validTo = $certParser['validTo'];
          $validFrom_time_t = $certParser['validFrom_time_t'];
          $validTo_time_t = $certParser['validTo_time_t'];
          $signatureTypeSN = $certParser['signatureTypeSN'];
          $signatureTypeLN = $certParser['signatureTypeLN'];
          $signatureTypeNID = $certParser['signatureTypeNID'];
          //$purposes = $certParser['purposes']['1']['2']; dd($purposes);
          $purposes = 'Not Implemented';
          $extensions = $certParser['extensions'];
              $extensionsBasicConstraints = $certParser['extensions']['basicConstraints'];
              //$extensionsNsCertType = $certParser['extensions']['nsCertType'];
              $extensionsKeyUsage = $certParser['extensions']['keyUsage'];
              $extensionsExtendedKeyUsage = $certParser['extensions']['extendedKeyUsage'];
              //$extensionsSubjectKeyIdentifier = $certParser['extensions']['subjectKeyIdentifier'];
              $extensionsAuthorityKeyIdentifier = $certParser['extensions']['authorityKeyIdentifier'];
              $extensionsSubjectAltName = $certParser['extensions']['subjectAltName'];
              $extensionsCrlDistributionPoints = $certParser['extensions']['crlDistributionPoints'];
          // End Certificate Info
          $expiryDate = round((time() - $validTo_time_t) / (60*60*24)); // In days
          $status = 'Valid';
          // for testing purposes
          $p12 = '';

         // Place the certificate publickey in public-keys to be monitored.
          openssl_x509_export_to_file($publicKey, storage_path('public-keys/' . $subjectCommonName . '.crt'));

          // Insert new PublicKey
          Cert::where('subjectCommonName', $subjectCommonName)->update(['publicKey' => $publicKey]);
          //Cert::where('subjectCommonName', $subjectCommonName)->update(['serialNumber' => $serialNumber]);
          //Cert::where('subjectCommonName', $subjectCommonName)->update(['serialNumberHex' => $serialNumberHex]);
          // Create records in DB.
          Cert::updateOrCreate([
            'subjectCommonName' => $subjectCommonName,
            //'subjectEmail' => $subjectEmail,
            'subjectContry' => $subjectContry,
            //'subjectState' => $subjectState,
            //'subjectLocality' => $subjectLocality,
            'subjectOrganization' => $subjectOrganization,
            //'subjectOrganizationUnit' => $subjectOrganizationUnit,
            'hash' => $hash,
            'issuerCN' => $issuerCN,
            'issuerContry' => $issuerContry,
            //'issuerState' => $issuerState,
            //'issuerLocality' => $issuerLocality,
            'issuerOrganization' => $issuerOrganization,
            //'issuerOrganizationUnit' => $issuerOrganizationUnit,
            'version' => $version,
            'serialNumber' => $serialNumber,
            'serialNumberHex' => $serialNumberHex,
            'validFrom' => $validFrom,
            'validTo' => $validTo,
            'validFrom_time_t' => $validFrom_time_t,
            'validTo_time_t' => $validTo_time_t,
            'signatureTypeSN' => $signatureTypeSN,
            'signatureTypeLN' => $signatureTypeLN,
            'signatureTypeNID' => $signatureTypeNID,
            'purposes' => $purposes,
            'extensionsBasicConstraints' => $extensionsBasicConstraints,
            //'extensionsNsCertType' => $extensionsNsCertType,
            'extensionsKeyUsage' => $extensionsKeyUsage,
            'extensionsExtendedKeyUsage' => $extensionsExtendedKeyUsage,
            //'extensionsSubjectKeyIdentifier' => $extensionsSubjectKeyIdentifier,
            'extensionsAuthorityKeyIdentifier' => $extensionsAuthorityKeyIdentifier,
            'extensionsSubjectAltName' => $extensionsSubjectAltName,
            'extensionsCrlDistributionPoints' => $extensionsCrlDistributionPoints,
            'certificateServerRequest' => $certificateServerRequest,
            'publicKey' => $publicKey,
            'privateKey' => $privateKey,
            'p12' => $p12,
            'status' => $status,
            'expiryDate' => $expiryDate,
            //'email' => $email,
            'comments' => $comments
            ]);

        }
        if($privateKey != ''){
          Cert::where('subjectCommonName', $subjectCommonName)->update(['privateKey' => $privateKey]);
          }

        return view('certs.mgmt.updated', array('subjectCommonName' => $subjectCommonName));
        }
      }

    public function delete()
    {
       if(isset($_POST['subjectCommonName']) &&
         !empty($_POST['subjectCommonName'])) {

        $subjectCommonName = $_POST['subjectCommonName'];

        return view('certs.mgmt.delete', array('subjectCommonName' => $subjectCommonName));
      }
    }

    public function deleted()
    {
       if(isset($_POST['subjectCommonName']) &&
         !empty($_POST['subjectCommonName'])) {

        $subjectCommonName = $_POST['subjectCommonName'];

        // When cert is DELETED has to be DELETED in public-keys  as well.
        FILE::delete(storage_path('public-keys/' . $subjectCommonName . '.crt'));
        FILE::delete(storage_path('public-keys/' . $subjectCommonName . '.cer'));

        // Delete DB table.
        Cert::where('subjectCommonName', $subjectCommonName)->delete();
        }
        return view('certs.mgmt.deleted', array('subjectCommonName' => $subjectCommonName));
      }

    public function keymatcher()
    {
        if(isset($_POST['subjectCommonName']) && isset($_POST['certificateServerRequest']) && isset($_POST['publicKey']) && isset($_POST['privateKey']) && !empty($_POST['subjectCommonName']) && !empty($_POST['privateKey'])) {

        $subjectCommonName = $_POST['subjectCommonName'];
        $certificateServerRequest = $_POST['certificateServerRequest'];
        $publicKey = $_POST['publicKey'];
        $privateKey = $_POST['privateKey'];

        // Check if csr/cert/key are in DB.
        if($certificateServerRequest != null){
          $csr_status = 'Found';
        } else {
          $csr_status = 'Not found';
        }
        if($publicKey != null){
          $cert_status = 'Found';
        } else {
          $cert_status = 'Not found';
        }
        if($privateKey != null){
          $key_status = 'Found';
        } else {
          $key_status = 'Not found';
        }

        // Checks if a private key matches certificate.
        $keyMatchesCert = openssl_x509_check_private_key($publicKey, $privateKey);

        if($keyMatchesCert === true){
          $keyMatchesCert = 'YES';
        } else {
          $keyMatchesCert = 'NO';
        }
          $tmp_storage = '/tmp/';
          $_tempcsr = file_put_contents($tmp_storage . 'temp.csr', $certificateServerRequest);
          $_tempcer = file_put_contents($tmp_storage . 'temp.cer', $publicKey);
          $certSHA2sum = shell_exec("openssl x509 -in /tmp/temp.cer -pubkey -noout -outform pem | sha256sum 2>&1");
          $csrSHA2sum = shell_exec("openssl req -in /tmp/temp.csr -pubkey -noout -outform pem | sha256sum 2>&1");

        if($certSHA2sum === $csrSHA2sum){
          $certMatchesCSR = 'YES';
        } else {
          $certMatchesCSR = 'NO';
        }
        return view('certs.mgmt.keymatcher', array(
          'subjectCommonName' => $subjectCommonName,
          'csr_status' => $csr_status,
          'cert_status' => $cert_status,
          'key_status' => $key_status,
          'keyMatchesCert' => $keyMatchesCert,
          'certMatchesCSR' => $certMatchesCSR ));
      }
    }

    public function import()
    {
          return view('certs.mgmt.import');
    }

}
