<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Request;
use App\Cert;
use DB;
use Zipper;
use File;
use Response;

class CertsController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {

        return view('certs.create');
    }

    public function created()
    {
        if(isset($_POST['subjectCommonName']) &&
            isset($_POST['organizationName']) &&
            isset($_POST['extensionsExtendedKeyUsage']) &&
            isset($_POST['signatureTypeSN']) &&
            isset($_POST['keyLength']) &&
            isset($_POST['validityPeriod']) &&
            isset($_POST['password']) &&
            isset($_POST['email']) &&
            isset($_POST['comments']) &&

            !empty($_POST['subjectCommonName']) &&
            !empty($_POST['organizationName']) &&
            !empty($_POST['extensionsExtendedKeyUsage']) &&
            !empty($_POST['signatureTypeSN']) &&
            !empty($_POST['keyLength']) &&
            !empty($_POST['validityPeriod']) &&
            !empty($_POST['password']) )
        {
            $subjectCommonName = $_POST['subjectCommonName'];
            $organizationName = $_POST['organizationName'];
            // Separate CN and SANs.
            $commonName = explode(" ", $subjectCommonName);
			$subjectCommonName = $commonName[0]; //separated cn
            $extensionsSubjectAltName = explode(",", ("DNS:".implode(",DNS:", $commonName)));
            $extensionsSubjectAltName = implode(",", $extensionsSubjectAltName); // Separated SANs
            //
            $extensionsExtendedKeyUsage = $_POST['extensionsExtendedKeyUsage'];
            $signatureTypeSN = $_POST['signatureTypeSN'];
            $keyLength = $_POST['keyLength'];
            $validityPeriod = $_POST['validityPeriod'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $comments = $_POST['comments'];
            $config = '/etc/ssl/openssl.cnf';

            // Check if CN already exists.
            $cn_exists = Cert::where('subjectCommonName', '=', Request::get('subjectCommonName'))->first();
            if (isset($cn_exists)){
                   return view ('errors.ooops', array(
                       'status' => 'subjectCommonName already exist in DB'
                       ));
               }

        // Data needed to populate the certificate signed by this CA. email can´t be empty so if it is empty "emailAddress" is not included.
        if($email != ''){
            $dn = array(
                "countryName" => 'ES',
                "stateOrProvinceName" => 'Madrid',
                "localityName" => 'Madrid',
                "organizationName" => $organizationName,
                "organizationalUnitName" => 'LIQUABit PoC',
                "commonName" => $subjectCommonName,
                "emailAddress" => $email
                );
        } else {
            $dn = array(
                "countryName" => 'ES',
                "stateOrProvinceName" => 'Madrid',
                "localityName" => 'Madrid',
                "organizationName" => $organizationName,
                "organizationalUnitName" => 'LIQUABit PoC',
                "commonName" => $subjectCommonName,
                //"emailAddress" => $defaultEmail
                );
        }

        // Clean DNS entries.
        shell_exec("sudo /opt/subjectAltNameRemoval.sh 2>&1");

		// Open config file.
		$configFile = file_get_contents($config);

		// Do replacements.
		$configFile = str_replace("DNS:", $extensionsSubjectAltName, $configFile);

		//Save it back.
		file_put_contents($config, $configFile);
		unset($configFile);

        // Arguments to be passed to the CSR.
        $configArgs = array(
                'config' => $config,
                'encrypt_key' => false,
                'private_key_type' => OPENSSL_KEYTYPE_RSA,
                'subjectAltName' => $extensionsSubjectAltName,
                'digest_alg' => $signatureTypeSN );

        // Generate CSR and his corresponding Private Key.
        $keygen = openssl_pkey_new();
        $csrgen = openssl_csr_new($dn, $keygen, $configArgs);

        // Export Private Key to string.
        openssl_pkey_export($keygen, $privateKey);

        // Export CSR to string.
        openssl_csr_export($csrgen, $certificateServerRequest);

        // Signing CSR. Location of CA/Key certificates.
        $cacert = file_get_contents('/opt/ca/root/certs/root.cert.pem');
        $pkeyid = array(file_get_contents('/opt/ca/root/private/root.key.pem'), $password );
        $configArgs = array(
                'config' => $config,
                'encrypt_key' => false,
                'private_key_bits' => (int)$keyLength,
                'private_key_type' => OPENSSL_KEYTYPE_RSA,
                'digest_alg' => $signatureTypeSN,
                'x509_extensions' => $extensionsExtendedKeyUsage);

        // Function by itself does not generate the serial so it is inserted by this function.
        $serialNumber = random_int(160000000001, 170000000001);

        // Sign certificate function.
        $certgen = openssl_csr_sign($certificateServerRequest , $cacert, $pkeyid, $validityPeriod, $configArgs, $serialNumber);

        // Export signed certificate to string variable.
        openssl_x509_export($certgen, $publicKey);

        // Clean SAN DNS entries.
        shell_exec("sudo /opt/subjectAltNameRemoval.sh 2>&1");

            return view('certs.created', array(
                'subjectCommonName' => $subjectCommonName,
                'extensionsSubjectAltName' => $extensionsSubjectAltName,
                'organizationName' => $organizationName,
                'extensionsExtendedKeyUsage' => $extensionsExtendedKeyUsage,
                'signatureTypeSN' => $signatureTypeSN,
                'keyLength' => $keyLength,
                'serialNumber' => $serialNumber,
                'validityPeriod' => $validityPeriod,
                'certificateServerRequest' => $certificateServerRequest,
                'publicKey' => $publicKey,
                'privateKey' => $privateKey,
                'email' => $email,
                'comments' => $comments
                ));

        } else {
            return view ('errors.ooops', array(
                'status' => 'No information has been supplied. Fill in all the fields in the form'
                ));
        }

    }

    public function getCert()
   {
       if  (isset($_POST['certificateServerRequest']) &&
            isset($_POST['publicKey']) &&
            isset($_POST['privateKey']) &&
            isset($_POST['email']) &&
            isset($_POST['comments']) &&

            !empty($_POST['certificateServerRequest']) &&
            !empty($_POST['publicKey']) &&
            !empty($_POST['privateKey']) )
        {

            $certificateServerRequest = $_POST['certificateServerRequest'];
            $publicKey = $_POST['publicKey'];
            $privateKey = $_POST['privateKey'];
            $email = $_POST['email'];
            $comments = $_POST['comments'];

            // Make CSR and Cert File to include Blob in DB
            file_put_contents(storage_path('cert.cer'), $publicKey);
            file_put_contents(storage_path('cert.key'), $privateKey);

            // Parse Certificate Info.
            $certParser = openssl_x509_parse($publicKey);
            $name = $certParser['name'];
            $subject = $certParser['subject'];
                $subjectCommonName = $certParser['subject']['CN'];
                //$subjectEmail = $certParser['subject']['emailAddress'];
                $subjectContry = $certParser['subject']['C'];
                $subjectState = $certParser['subject']['ST'];
                //$subjectLocality = $certParser['subject']['L'];
                $subjectOrganization = $certParser['subject']['O'];
                $subjectOrganizationUnit = $certParser['subject']['OU'];
            $hash = $certParser['hash'];
            $issuer = $certParser['issuer'];
                $issuerCN = $certParser['issuer']['CN'];
                //$issuerContry = $certParser['issuer']['C'];
                //$issuerState = $certParser['issuer']['ST'];
                //$issuerLocality = $certParser['issuer']['L'];
                $issuerOrganization = $certParser['issuer']['O'];
                $issuerOrganizationUnit = $certParser['issuer']['OU'];
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
                //$extensionsNsCertType = $certParser['extensions']['extendedKeyUsage'];
                $extensionsKeyUsage = $certParser['extensions']['keyUsage'];
                $extensionsExtendedKeyUsage = $certParser['extensions']['extendedKeyUsage'];
                $extensionsSubjectKeyIdentifier = $certParser['extensions']['subjectKeyIdentifier'];
                $extensionsAuthorityKeyIdentifier = $certParser['extensions']['authorityKeyIdentifier'];
                $extensionsSubjectAltName = $certParser['extensions']['subjectAltName'];
                $extensionsCrlDistributionPoints = $certParser['extensions']['crlDistributionPoints'];
            // End Certificate Info
            $expiryDate = round((time() - $validTo_time_t) / (60*60*24)); // In days
            $status = 'Valid';

            // for testing purposes
            $p12 = '';

            // Create records in DB.
            Cert::updateOrCreate([
               'subjectCommonName' => $subjectCommonName,
               //'subjectEmail' => $subjectEmail,
               'subjectContry' => $subjectContry,
               'subjectState' => $subjectState,
               //'subjectLocality' => $subjectLocality,
               'subjectOrganization' => $subjectOrganization,
               'subjectOrganizationUnit' => $subjectOrganizationUnit,
               'hash' => $hash,
               'issuerCN' => $issuerCN,
               //'issuerContry' => $issuerContry,
               //'issuerState' => $issuerState,
               //'issuerLocality' => $issuerLocality,
               'issuerOrganization' => $issuerOrganization,
               'issuerOrganizationUnit' => $issuerOrganizationUnit,
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
               'extensionsSubjectKeyIdentifier' => $extensionsSubjectKeyIdentifier,
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

           // ZIP the certificate, key and CA. Saved in storage folder.
           //$zip = glob(storage_path('{root.ca.,cert.}.*', GLOB_BRACE));
           $zip = glob(storage_path('cert.*'));
           Zipper::make(storage_path('archives/' . $subjectCommonName . '.zip'))->add($zip);
           Zipper::close();

           // Delete *.cer files
           File::delete(storage_path('cert.cer'));
           File::delete(storage_path('cert.key'));

           // Save certificate public key for expiry monitoring.
           openssl_x509_export_to_file($publicKey, storage_path('public-keys/' . $subjectCommonName . '.crt'));

           $headers = array('Content-Type: application/x-download');

           return Response::download(storage_path('archives/' . $subjectCommonName . '.zip'), $subjectCommonName . '.zip', $headers)->deleteFileAfterSend(true);

       } else {

           return view ('errors.ooops', array(
           	'status' => 'can´t download archive'));
       }
    }

    public function getP12()
    {
        if (isset($_POST['subjectCommonName']) &&
            //isset($_POST['certificateServerRequest']) &&
            isset($_POST['publicKey']) &&
            isset($_POST['privateKey']) &&
            isset($_POST['password']) );
        {
            $subjectCommonName = $_POST['subjectCommonName'];
            //$certificateServerRequest = $_POST['certificateServerRequest'];
            $publicKey = $_POST['publicKey'];
            $privateKey = $_POST['privateKey'];
            $password = $_POST['password'];

            $storage_path = storage_path();
            $p12 = storage_path('archives/' . $subjectCommonName . '.p12');

            // CACert storage path.
            //$cacert = file(storage_path('cert.ca.cer'));
            $cacert = array('-----BEGIN CERTIFICATE-----
            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
            7AHtyArogm14oLG2OkpA/sLNJm28elremKY=
            -----END CERTIFICATE-----');
            $p12args = array (
                'friendly_name' => $subjectCommonName,
                'extracerts' => $cacert
            );

            // Export p12 to string to insert in DB.
            $p12export = openssl_pkcs12_export( $publicKey, $p12string, $privateKey, $password );

            $p12export_to_file = openssl_pkcs12_export_to_file( $publicKey, $p12, $privateKey, $password, $p12args );

            // Update field 'p12' in DB with output from the file itself.
            Cert::where('subjectCommonName', $subjectCommonName)->update(['p12' => $p12string]);

            $headers = array('Content-Type: application/x-download');

           // return Response::download(storage_path(archives/$subjectCommonName . '.p12'), $subjectCommonName . '.p12', $headers)->deleteFileAfterSend(true);
           return Response::download(storage_path('archives/' . $subjectCommonName . '.p12'), $subjectCommonName . '.p12', $headers);

      }
   }

}
