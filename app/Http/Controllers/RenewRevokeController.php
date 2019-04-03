<?php

namespace App\Http\Controllers;

use Request;
use App\Csr;
use App\Cert;
use Input;
use Zipper;
use File;
use Response;


class RenewRevokeController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth');
    }

    public function renew()
    {
       if (isset($_POST['subjectCommonName']) && !empty($_POST['subjectCommonName']))
       {
            $subjectCommonName = $_POST['subjectCommonName'];

            // Getting Collection from Certs.
            $certs = Cert::where('subjectCommonName', $subjectCommonName)->get()->first();

            if($certs->status == 'Revoked')
             {
               return view('errors.ooops', array(
                 'status' => 'certificate is already revoked.'));
             }

            // Check if CN and CSR already exists.
            $cn_exists = Cert::where('subjectCommonName', '=', Request::get('subjectCommonName'))->first();
            $csr_exists = Cert::where('certificateServerRequest', '=', Request::get('certificateServerRequest'))->first();

            // return error page if there is no certificate in DB.
            if ($certs->publicKey == null OR $certs->certificateServerRequest == null)
            {
              return view ('errors.ooops', array(
                'status' => 'certificate request or publickey not found.'));
            }

            // Check if certificate has been signed by this CA. Otherwise, can´t be renewed.
            $publicKey = $certs->publicKey;
            $issuerCN = $certs->issuerCN;

            if($issuerCN != 'LIQUABIT PoC Private CA'){
              return view ('errors.ooops', array(
                'status' => 'certificate hasn´t been issued by this CA so it can´t be renewed here'));
            }

            if (!isset($cn_exists) && !isset($csr_exists))
            {
              $certificateServerRequest = file_put_contents($subjectCommonName . '.csr', $cn_exists->certificateServerRequest);

              return view('errors.ooops', array(
                'status' => 'either CN not CSR exist in DB.'));

             } else {

              return view ('certs.mgmt.renewed', array(
                'subjectCommonName' => $subjectCommonName,
                ));
           }
        }
    }

    public function getRenewed()
    {
        if (isset($_POST['subjectCommonName']) &&
            isset($_POST['validityPeriod']) &&
            isset($_POST['password']) &&

            !empty($_POST['subjectCommonName'])&&
            !empty($_POST['validityPeriod'])&&
            !empty($_POST['password']))
        {
          $subjectCommonName = $_POST['subjectCommonName'];
          $validityPeriod = $_POST['validityPeriod'];

          // Separate CN and include it as SubjectAltName.
          $commonName = explode(" ", $subjectCommonName);
          $subjectCommonName = $commonName[0]; // Separate CN from SANs.
          $extensionsSubjectAltName = explode(",", ("DNS:".implode(",DNS:", $commonName)));
          $extensionsSubjectAltName = implode(",", $extensionsSubjectAltName); // Separated SANs
          $password = $_POST['password'];
          $config = '/etc/ssl/openssl.cnf';

          // Getting Collection from Certs.
          $certs = Cert::where('subjectCommonName', $subjectCommonName)->get()->first();
          $certificateServerRequest = $certs->certificateServerRequest;
          $extensionsExtendedKeyUsage = $certs->extensionsExtendedKeyUsage;

          // Translate certificate ExtendedKeyUsage to openssl section names
          if($extensionsExtendedKeyUsage == 'TLS Web Server Authentication, TLS Web Client Authentication'){
            $keyUsage = 'serverAuth_clientAuth';
          } elseif (extensionsExtendedKeyUsage == 'TLS Web Server Authentication') {
            $keyUsage = 'serverAuth';
          } elseif (extensionsExtendedKeyUsage == 'TLS Web Client Authentication') {
            $keyUsage = 'clientAuth';
          } else {
            $keyUsage = 'Other';
          }

        // Clean DNS entries.
        shell_exec("sudo /opt/subjectAltNameRemoval.sh 2>&1");

          // Open Config file.
        $data = file_get_contents($config);

        // Do replacements.
        $data = str_replace("DNS:", $extensionsSubjectAltName, $data);

        // Save it back.
        file_put_contents($config, $data);
        unset($data);

        // Arguments to be passed to the CSR.
        $configArgs = array(
            'config' => $config,
            'encrypt_key' => false,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
            'subjectAltName' => $extensionsSubjectAltName, // Not needed since it is hardcoded (above) in config file.
            'digest_alg' => 'sha256',
            'x509_extensions' => $keyUsage
          );

            $digest_alg = 'sha256';
            $serialNumber = random_int(160000000001, 170000000001); // serial for external CSR in Decimal format.
            $serialNumberHex = dechex($serialNumber); // serial for external CSR in Hexadecimal format.
            $password = $_POST['password'];
            $cacert = file_get_contents('/opt/ca/root/certs/root.cert.pem');
            $pkeyid = array(file_get_contents('/opt/ca/root/private/root.key.pem'), $password );

            // Check if CN already exists.
            $cn_exists = Cert::where('subjectCommonName', '=', Request::get('subjectCommonName'))->first();

            if (isset($cn_exists))
            {
              // Sign csr from DB.
              $cert = openssl_csr_sign($certificateServerRequest , $cacert, $pkeyid, $validityPeriod, $configArgs, $serialNumber);

              // Export signed certificate to string variable.
              openssl_x509_export($cert, $publicKey);

              // Put CSR and Cert in files.
              file_put_contents(storage_path('cert.csr'), $certificateServerRequest);
              file_put_contents(storage_path('cert.cer'), $publicKey);

              // ZIP the certificate, key and CA. Saved in storage folder.
              $zip = glob(storage_path('cert.*'));
              Zipper::make(storage_path('archives/' . $subjectCommonName . '.zip'))->add($zip);
              Zipper::close();

              // Clean DNS entries.
              shell_exec("sudo /opt/subjectAltNameRemoval.sh 2>&1");

              // Delete *.cer files
              File::delete(storage_path('cert.csr'));
              File::delete(storage_path('cert.cer'));

              // After renewing, delete the .cer from storage and monitoring. *.crt exstension gets updated
              File::delete(storage_path('public-keys/' . $subjectCommonName . '.cer')); // In case it existed with .cer extension.


              // Save renewed certificate public key for expiry monitoring.
              openssl_x509_export_to_file($publicKey, storage_path('public-keys/' . $subjectCommonName . '.crt'));


              // DB Updates.
              Cert::where('subjectCommonName', $subjectCommonName)->update(['expiryDate' => $validityPeriod]);
              Cert::where('subjectCommonName', $subjectCommonName)->update(['serialNumber' => $serialNumber]);
              Cert::where('subjectCommonName', $subjectCommonName)->update(['serialNumberHex' => $serialNumberHex]);
              Cert::where('subjectCommonName', $subjectCommonName)->update(['publicKey' => $publicKey]);
              Cert::where('subjectCommonName', $subjectCommonName)->update(['p12' => 'PFX archive not generated. You have to re-generate it again if you renewed the certificate.']);

              $headers = array('Content_Type: application/x-download',);
                return Response::download(storage_path('archives/' . $subjectCommonName . '.zip'), $subjectCommonName . '.zip', $headers)->deleteFileAfterSend(true);

            }
        }
    }

    public function revoke()
    {
       if  (isset($_POST['subjectCommonName']) && !empty($_POST['subjectCommonName']))
       {
            $subjectCommonName = $_POST['subjectCommonName'];
            $certs = Cert::where('subjectCommonName', $subjectCommonName)->get()->first();
            // Return error if the certificate has already been revoked.
            $checkStatus = $certs->status;

          if($checkStatus == 'Revoked')
            {
              return view('errors.ooops', array(
                'status' => 'certificate is already revoked'));

            } elseif ($checkStatus == 'Expired')
            {
              return view('errors.ooops', array(
                'status' => 'certificate is expired'));

            } elseif ($certs->publicKey == null) {

              return view ('errors.ooops', array(
                'status' => 'certificate not found'));
          } else {
                return view('certs.mgmt.revoke', array(
                'subjectCommonName' => $subjectCommonName,
                ));
        }
      }
    }

    public function revoked()
    {
       if  (isset($_POST['subjectCommonName']) &&
             isset($_POST['reason']) &&
             isset($_POST['password']) &&

             !empty($_POST['subjectCommonName']) &&
             !empty($_POST['password']))
            {
            $subjectCommonName = $_POST['subjectCommonName'];
            $reason = $_POST['reason'];
            $password = $_POST['password'];
            $config = '/etc/ssl/openssl.cnf';

            // Getting Collection from Certs.//
            $certs = Cert::where('subjectCommonName', $subjectCommonName)->get()->first();
            $publicKey = $certs->publicKey;
            $extensionsSubjectAltName = $certs->extensionsSubjectAltName;
            $serialNumber = $certs->serialNumber;
            $updated_at = $certs->updated_at;
            $certfile = storage_path($serialNumber . '.cer');
            $crlFile = storage_path('root.ca.crl');

            // Return error if there is no certificate in DB.
            if ($certs->publicKey == null)
            {
              return view ('errors.ooops', array(
                'status' => 'certificate not found.'));
            }

            if ($certs->publicKey !== null){

            // Create cert file to revoke it.
            file_put_contents(storage_path($serialNumber . '.cer'), $publicKey);

            // Command to revoke certificate.
            $revoke = shell_exec("sudo openssl ca -config $config -revoke $certfile -key $password -batch 2>&1");
            File::delete(storage_path($serialNumber . '.cer'));

            // Filter $revoke command output.
            $revoke_bad_password = substr($revoke, 45, 30);
            $revoke_already_revoked = substr($revoke, 52, 15);
            $revoke_ok = substr($revoke, -18, 17);

            if($revoke_bad_password == 'unable to load CA private key'){
              return view('errors.ooops', array(
                'status' => "password is not correct"
               ));

            } elseif ($revoke_already_revoked == 'Already revoked'){

              return view('errors.ooops', array(
                'status' => 'certificate is already revoked'
                ));

            } elseif ($revoke_ok != 'Data Base Updated') {

              return view('errors.ooops', array(
                'status' => 'error updating the DB. Check your password and try again.'
                ));

            } elseif ($revoke_ok == 'Data Base Updated') {
              $status = 'Data Base Updated';
              $status2 = 'Revoked';
            }
            // After revocation, delete the .cer from storage and monitoring (still remains in DB).
            File::delete(storage_path('public-keys/' . $subjectCommonName . '.crt'));
            File::delete(storage_path('public-keys/' . $subjectCommonName . '.cer')); // In case it existed with .cer extension due to Import/migration.

            // Update DB. It includes the update date.
            //Cert::where('subjectCommonName', $subjectCommonName)->update(['subjectCommonName' => '(R)' . $subjectCommonName . ' ' . $updated_at]);
            Cert::where('subjectCommonName', $subjectCommonName)->update(['status' => $status2]);

            // Update CRL.
            $updateCRL = shell_exec('sudo openssl ca -gencrl -config $config -key $password -out $crlFile -batch 2>&1');

            // Parsing x509 attributes.
            $parse_cert = openssl_x509_parse($publicKey);
            $issuer = $parse_cert['issuer'];
            $issuerCN = $issuer['CN'];
            $validFrom = date_create( '@' .  $parse_cert['validFrom_time_t'])->format('c');
            $validTo = date_create( '@' .  $parse_cert['validTo_time_t'])->format('c');

            return view ('certs.mgmt.revoked', array(
              'subjectCommonName' => $subjectCommonName,
              'extensionsSubjectAltName' => $extensionsSubjectAltName,
              'serialNumber' => $serialNumber,
              'issuerCN' => $issuerCN,
              'validFrom' => $validFrom,
              'validTo' => $validTo,
              'updated_at' => $updated_at,
              'reason' => $reason,
              'password' => $password,
              'status' => $status,
              'status2' => $status2
              ));

              } else {
              return view ('errors.ooops', array(
                'status' => $revoke));
            }

        }

      }
    }
