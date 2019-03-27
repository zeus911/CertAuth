<?php

namespace App\Http\Controllers;

use Request;
use App\Csr;
use App\Cert;
use Input;
use Zipper;
use File;
use Response;

class CsrController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        	return view('csr.create');
    }

    public function created()
    {
        if(isset($_POST['subjectCommonName']) &&
            isset($_POST['subjectOrganization']) &&
            isset($_POST['extensionsExtendedKeyUsage']) && 
            isset($_POST['signatureTypeSN']) &&
            isset($_POST['emailAddress']) &&

            !empty($_POST['subjectCommonName']) &&
            !empty($_POST['subjectOrganization']) &&
            !empty($_POST['extensionsExtendedKeyUsage']) &&
            !empty($_POST['signatureTypeSN']))
        {
            $subjectCommonName = $_POST['subjectCommonName'];
            // Separate CN and SANs.
            $commonName = explode(" ", $subjectCommonName);
			$subjectCommonName = $commonName[0]; //separated cn
            $extensionsSubjectAltName = explode(",", ("DNS:".implode(",DNS:", $commonName)));
            $extensionsSubjectAltName = implode(",", $extensionsSubjectAltName); // separated sans
            //
            $subjectOrganization = $_POST['subjectOrganization'];
            $extensionsExtendedKeyUsage = $_POST['extensionsExtendedKeyUsage'];
            $signatureTypeSN = $_POST['signatureTypeSN'];
            $emailAddress = $_POST['emailAddress'];
            $config = '/etc/ssl/openssl.cnf';

            // Check if CN already exists.
            $cn_exists = Cert::where('subjectCommonName', '=', Request::get('subjectCommonName'))->first();
                if (isset($cn_exists))
                {
                    return view ('errors.ooops', array(
                        'status' => 'Already signed and not revoked'
                        ));
                }
  
        // Data needed to populate the certificate. This should be provided through the 'create' Form.
        $dn = array(
        "countryName" => 'ES',
        "stateOrProvinceName" => 'Madrid',
        "localityName" => 'Madrid',
        "organizationName" => $subjectOrganization,
        "organizationalUnitName" => 'LIQUABit Private CA',
        "commonName" => $subjectCommonName
        //"emailAddress" => $emailAddress
        );

        // Clean DNS entries.
        shell_exec("sudo /opt/subjectAltNameRemoval.sh 2>&1"); 

        // Open Config file.
        $configFile = file_get_contents($config);

        // Do replacements.
        $configFile = str_replace("DNS:",$extensionsSubjectAltName, $configFile);

        //Save it back.
        file_put_contents($config, $configFile);
        unset($configFile);
    
        // Arguments to be passed to the CSR.
        $configArgs = array(
                'config' => $config,
                'encrypt_key' => false,
                'private_key_type' => OPENSSL_KEYTYPE_RSA,
                'subjectAltName' => $extensionsSubjectAltName,
                'signatureTypeSN' => $signatureTypeSN );

        // Generate CSR and his corresponding Private Key.
        $keygen = openssl_pkey_new();
        $csrgen = openssl_csr_new($dn, $keygen, $configArgs);

        // Export Private Key to string.
        openssl_pkey_export($keygen, $privateKey);
        //openssl_pkey_export_to_file($keygen, $keystore);

        // Export CSR to string.
        openssl_csr_export($csrgen, $certificateServerRequest);
        //openssl_csr_export_to_file($csrgen, $csrstore);

        // Clean DNS entries.
        shell_exec("sudo /opt/subjectAltNameRemoval.sh 2>&1");

        return view('csr.created', array(
            'subjectCommonName' => $subjectCommonName,
            'extensionsSubjectAltName' => $extensionsSubjectAltName,
            'subjectOrganization' => $subjectOrganization,
            'extensionsExtendedKeyUsage' => $extensionsExtendedKeyUsage,
            'signatureTypeSN' => $signatureTypeSN,
            //'serial' => 'N/A',
            'certificateServerRequest' => $certificateServerRequest,
            //'certprint' => 'N/A',
            'privateKey' => $privateKey,
            'emailAddress' => $emailAddress
             ));
        } else {
            return view('errors.ooops', array(
                'status' => 'Error in CSR'
            ));
        }
        
    }

    public function getCSR()
   {
       if  (isset($_POST['subjectCommonName']) &&
            isset($_POST['extensionsSubjectAltName']) && 
            isset($_POST['subjectOrganization']) &&
            isset($_POST['extensionsExtendedKeyUsage']) &&
            isset($_POST['signatureTypeSN']) &&
            isset($_POST['certificateServerRequest']) &&
            isset($_POST['privateKey']) &&

            !empty($_POST['subjectCommonName']) &&
            !empty($_POST['extensionsSubjectAltName']) &&
            !empty($_POST['subjectOrganization']) &&
            !empty($_POST['extensionsExtendedKeyUsage']) &&
            !empty($_POST['signatureTypeSN']) &&
            !empty($_POST['certificateServerRequest']) &&
            !empty($_POST['privateKey']) )
        {
            $subjectCommonName = $_POST['subjectCommonName'];
            $extensionsSubjectAltName = $_POST['extensionsSubjectAltName'];
            $subjectOrganization = $_POST['subjectOrganization'];
            $extensionsExtendedKeyUsage = $_POST['extensionsExtendedKeyUsage'];
            $signatureTypeSN = $_POST['signatureTypeSN'];
            $certificateServerRequest = $_POST['certificateServerRequest'];
            $privateKey = $_POST['privateKey'];

            // Check if CN already exists.
            $cn_exists = Cert::where('subjectCommonName', '=', Request::get('subjectCommonName'))->first();

            if (isset($cn_exists))
            {
            	return view ('errors.ooops', array(
                    'status' => 'Already signed and not revoked.'
            		));
            }

            // Make CSR and Cert File to include Blob in DB//
            file_put_contents(storage_path('cert.csr'), $certificateServerRequest);
            file_put_contents(storage_path('cert.key'), $privateKey);
 
           // ZIP the certificate, key and CA. Saved in storage folder.
           $zip = glob(storage_path('cert.*'));
           Zipper::make(storage_path($subjectCommonName . '.zip'))->add($zip);
           Zipper::close();

           // Delete *.cer files
           File::delete(storage_path('cert.csr'));
           File::delete(storage_path('cert.key'));
           
            // Create records in DB.
            Cert::updateOrCreate([
                'subjectCommonName' => $subjectCommonName,
                'subjectOrganization' => $subjectOrganization,
                'extensionsExtendedKeyUsage' => $extensionsExtendedKeyUsage,
                'signatureTypeSN' => $signatureTypeSN,
                'extensionsSubjectAltName' => $extensionsSubjectAltName,
                'certificateServerRequest' => $certificateServerRequest,
                'privateKey' => $privateKey,
                ]);
 

           $headers = array('Content_Type: application/x-download',);
          
           return Response::download(storage_path($subjectCommonName . '.zip'), $subjectCommonName . '.zip', $headers)->deleteFileAfterSend(true);

       } else {

           return view ('errors.ooops', array(
           	'subjectCommonName' => $subjectCommonName,
           	'status' => 'Last error getCSR'));
       }
        
    }


    public function sign()
    {
        return view('csr.sign');
    }


    public function signed()
    {
        if (isset($_POST['certificateServerRequest']) &&
            isset($_POST['caCertificate']) &&
            isset($_POST['validityPeriod']) &&
            isset($_POST['extensionsExtendedKeyUsage']) &&
            isset($_POST['signatureTypeSN']) &&
            isset($_POST['password']) &&
            
            !empty($_POST['certificateServerRequest']) &&
            !empty($_POST['caCertificate']) &&
            !empty($_POST['validityPeriod']) &&
            !empty($_POST['extensionsExtendedKeyUsage']) &&
            !empty($_POST['signatureTypeSN']) &&
            !empty($_POST['password']))
        {
            $certificateServerRequest = $_POST['certificateServerRequest'];
            $caCertificate = $_POST['caCertificate'];
            $validityPeriod = $_POST['validityPeriod'];
            $extensionsExtendedKeyUsage = $_POST['extensionsExtendedKeyUsage'];
            $signatureTypeSN = $_POST['signatureTypeSN'];
            $password = $_POST['password'];
            $subjectCommonName = openssl_csr_get_subject($certificateServerRequest, true);
            //$csrPublicKey = openssl_csr_get_public_key($certificateServerRequest); // Intended to extract more details like: KeyUsage.
            //$info = openssl_pkey_get_details($csrPublicKey);
            //$signatureTypeSN = 'sha256';
            //$publicKey = 'N/A';
            $privateKey = 'We do not have the key becouse it has been generated in another device.';

            // Check if CN already exists.
            $cn_exists = Cert::where('subjectCommonName', '=', Request::get('subjectCommonName'))->first();

            if (isset($cn_exists))
            {
            	return view ('errors.ooops', array(
                    'status' => 'Already signed and not revoked.'
            	));
        
            } elseif ($cn_exists = 'null') {    

                return view ('csr.signed', array(
                    'subjectCommonName' => $subjectCommonName['CN'],
                    'caCertificate' => $caCertificate,
                    'validityPeriod' => $validityPeriod,
                    'extensionsExtendedKeyUsage' => $extensionsExtendedKeyUsage,
                    'signatureTypeSN' => $signatureTypeSN,
                    'certificateServerRequest' => $certificateServerRequest,
                    'privateKey' => $privateKey,
                    'p12' => 'PFX archive not generated. You have to re-generate it again if you renewed/signed the certificate.',
                    'password' => $password
                    ));

        	} else {
            	return view ('errors.signError');
            }
        }
    } 

    public function getExtCert()
    {
        if (isset($_POST['subjectCommonName']) && 
            isset($_POST['caCertificate']) &&
            isset($_POST['validityPeriod']) &&
            isset($_POST['extensionsExtendedKeyUsage']) &&
            isset($_POST['signatureTypeSN']) &&
            // isset($_POST['serial']) &&
            isset($_POST['certificateServerRequest']) &&
            // isset($_POST['publicKey']) &&
            isset($_POST['privateKey']) &&
            isset($_POST['p12']) &&
            isset($_POST['password']) &&

            !empty($_POST['subjectCommonName'])&&
            !empty($_POST['certificateServerRequest']) &&
            !empty($_POST['password']))
        {
            $subjectCommonName = $_POST['subjectCommonName'];
            $caCertificate = $_POST['caCertificate'];
            $validityPeriod = $_POST['validityPeriod'];
            $extensionsExtendedKeyUsage = $_POST['extensionsExtendedKeyUsage'];
            $signatureTypeSN = $_POST['signatureTypeSN'];
            // $serial = $_POST['serial'];
            $certificateServerRequest = $_POST['certificateServerRequest'];
            // $cert = $_POST['publicKey'];
            $privateKey = $_POST['privateKey'];
            $p12 = $_POST['p12'];
            $status = 'Valid'; // but no key
            $password = $_POST['password'];
            $cacert = file_get_contents('/opt/ca/root/certs/root.cert.pem');
            $pkeyid = array(file_get_contents('/opt/ca/root/private/root.key.pem'), $password );
            $serial = random_int(260001, 270001); // serial for external CSR

            // Clear SAN DNS entries if previous error.
            shell_exec("sudo /opt/subjectAltNameRemoval.sh 2>&1");
            
            // Extracting SAN fron CSR.
			$random_blurp = rand(1000,99999); 
			//openssl_csr_get_subject doesn't support SAN names.
			$tempCSR = "/tmp/csr-" . $random_blurp . ".csr.pem";
			$write_csr = file_put_contents($tempCSR, $certificateServerRequest);
			if($write_csr !== FALSE) {
			  $san = trim(shell_exec("openssl req -noout -text -in " . $tempCSR . " | grep -e 'DNS:' -e 'IP:' -e 'email:'")); // Not sure if 'email:' works.
			}
			unlink($tempCSR); // Completely deletes the file.

			// In case the CSR file doesn´t include SAN.
			if($san == ""){
			 $san = 'DNS:' . $subjectCommonName;
			}
            // Include subjectAltName in conf.
            $data = file_get_contents("/etc/ssl/openssl.cnf");

            // do replacements for SAN in openssl.cnf.
            $data = str_replace("DNS:",$san, $data);

            // save it back.
            file_put_contents("/etc/ssl/openssl.cnf", $data);
            unset($data); // Clears the content of the file.

            $configArgs = array(
                //'config' => '/usr/lib/ssl/openssl.cnf',
                'config' => '/etc/ssl/openssl.cnf',
                'encrypt_key' => false,
                'private_key_type' => OPENSSL_KEYTYPE_RSA,
                'digest_alg' => $signatureTypeSN,
                'x509_extensions' => $extensionsExtendedKeyUsage );

            // Check if CN already exists.
            $cn_exists = Cert::where('subjectCommonName', '=', Request::get('subjectCommonName'))->first();

            if (isset($cn_exists)){
            	
            	// Clean SAN DNS entries.
            	shell_exec("sudo /opt/subjectAltNameRemoval.sh 2>&1");
                
                return view ('errors.ooops', array(
                    'status' => 'Already signed and not revoked.'
                ));
            } elseif ($cn_exists = 'null') {

            // Sign certificate function.
            $cert = openssl_csr_sign($certificateServerRequest , $cacert, $pkeyid, $validityPeriod, $configArgs, $serial);         

            // Export signed certificate to string variable.
            openssl_x509_export($cert, $publicKey);

            // Put CSR and Cert in Files //
            file_put_contents(storage_path('cert.csr'), $certificateServerRequest);
            file_put_contents(storage_path('cert.cer'), $publicKey);

            // ZIP the certificate, key and CA. Saved in storage folder.
            $zip = glob(storage_path('cert.*'));
            Zipper::make(storage_path($subjectCommonName . '.zip'))->add($zip);
            Zipper::close();

            // Delete *.cer files
            File::delete(storage_path('cert.csr'));
            File::delete(storage_path('cert.cer'));

            // Clean SAN DNS entries.
            shell_exec("sudo /opt/subjectAltNameRemoval.sh 2>&1");

            // Parse Certificate Info.
            $cert_parse = openssl_x509_parse($publicKey);
            $name = $cert_parse['name'];
            $subject = $cert_parse['subject'];
                $subjectCommonName = $cert_parse['subject']['CN'];
                $subjectContry = $cert_parse['subject']['C'];
                $subjectState = $cert_parse['subject']['ST'];
                $subjectLocality = $cert_parse['subject']['L'];
                $subjectOrganization = $cert_parse['subject']['O'];
                $subjectOrganizationUnit = $cert_parse['subject']['OU'];
            $hash = $cert_parse['hash'];
            $issuer = $cert_parse['issuer'];
                $issuerCN = $cert_parse['issuer']['CN'];
                $issuerContry = $cert_parse['issuer']['C'];
                $issuerState = $cert_parse['issuer']['ST'];
                //$issuerLocality = $cert_parse['issuer']['L'];
                $issuerOrganization = $cert_parse['issuer']['O'];
                $issuerOrganizationUnit = $cert_parse['issuer']['OU'];
            $version = $cert_parse['version'];
            $serialNumber = $cert_parse['serialNumber'];
            $serialNumberHex = $cert_parse['serialNumberHex'];
            $validFrom = $cert_parse['validFrom'];
            $validTo = $cert_parse['validTo'];
            $validFrom_time_t = $cert_parse['validFrom_time_t'];
            $validTo_time_t = $cert_parse['validTo_time_t'];
            $signatureTypeSN = $cert_parse['signatureTypeSN'];
            $signatureTypeLN = $cert_parse['signatureTypeLN'];
            $signatureTypeNID = $cert_parse['signatureTypeNID'];
            //$purposes = $cert_parse['purposes']['1']['2']; dd($purposes);
            $purposes = 'Not Implemented';
            $extensions = $cert_parse['extensions'];
                $extensionsBasicConstraints = $cert_parse['extensions']['basicConstraints'];
                //$extensionsExtendedKeyUsage = $cert_parse['extensions']['nsCertType'];
                $extensionsKeyUsage = $cert_parse['extensions']['keyUsage'];
                $extensionsExtendedKeyUsage = $cert_parse['extensions']['extendedKeyUsage'];
                $extensionsSubjectKeyIdentifier = $cert_parse['extensions']['subjectKeyIdentifier'];
                $extensionsAuthorityKeyIdentifier = $cert_parse['extensions']['authorityKeyIdentifier'];
                $extensionsSubjectAltName = $cert_parse['extensions']['subjectAltName'];
                $extensionsCrlDistributionPoints = $cert_parse['extensions']['crlDistributionPoints'];
            // End Certificate Info
            $expiryDate = round((time() - $validTo_time_t) / (60*60*24)); // In days
            $status = 'Valid';
            // for testing purposes
            $p12 = '';
            $comment = '';


            // Create records in DB.
            Cert::updateOrCreate([
                'subjectCommonName' => $subjectCommonName,
                'subjectContry' => $subjectContry,
                'subjectState' => $subjectState,
                'subjectLocality' => $subjectLocality,
                'subjectOrganization' => $subjectOrganization,
                'subjectOrganizationUnit' => $subjectOrganizationUnit,
                'hash' => $hash,
                'issuerCN' => $issuerCN,
                'issuerContry' => $issuerContry,
                'issuerState' => $issuerState,
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
                //'extensionsExtendedKeyUsage' => $extensionsExtendedKeyUsage,
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
                'comments' => $comment
 
                ]);
 
            // Updates de table with the 'cert' generated above.
            Cert::where('subjectCommonName', $subjectCommonName)->update(['publicKey' => $publicKey]);

            $headers = array('Content_Type: application/x-download',);
          
            return Response::download(storage_path($subjectCommonName . '.zip'), $subjectCommonName . '.zip', $headers)->deleteFileAfterSend(true);

            } else {
                return view ('errors.getExtCertError', array (
                    'subjectCommonName' => $subjectCommonName,
                    'san' => $san,
                    'extensionsExtendedKeyUsage' => $extensionsExtendedKeyUsage,
                    'signatureTypeSN' => $signatureTypeSN,
                    'serial' => $serial,
                    'cn_exists' => $cn_exists,
                    'certificateServerRequest' => $certificateServerRequest,
                    'cert' => $cert,
                    'key' => $key,
                    ));
            }
        }
    } 
}
 