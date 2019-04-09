<?php

namespace App\Http\Controllers;

use Request;
use Zipper;
use File;
use Response;
use App\Cert;
use Storage;

class ConverterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function p12()
    {
        return view('converter.p12');
    }

    public function createP12()
    {
    	if (isset($_POST['subjectCommonName']) &&

    		!empty($_POST['subjectCommonName']) );
        {
            $subjectCommonName = $_POST['subjectCommonName'];

            // if cert or key don´t exist, return ooops.blade.php
            $cert = Cert::where('subjectCommonName', $subjectCommonName)->get()->first();
            if($cert->publicKey == null OR $cert->privateKey == 'We do not have the key becouse it has been generated in another device.' ){
                return view('errors.ooops', array(
                    'status' => 'Can´t create P12 archive. No Certificate or PrivateKey available.'));
            } else {
                return view('converter.createP12', array(
                      'subjectCommonName' => $subjectCommonName) );
            }
        }
    }

    public function storeP12()
    {
    	if (isset($_POST['subjectCommonName']) &&
    		isset($_POST['password']) &&

    		!empty($_POST['subjectCommonName']) &&
    		!empty($_POST['password']) );
        {
            $subjectCommonName = $_POST['subjectCommonName'];
            $password = $_POST['password'];

            // Get Certificate CN and Key.
            $cert = Cert::where('subjectCommonName', '=', Request::get('subjectCommonName'))->first();
            $publicKey = $cert->publicKey;
            $privateKey = $cert->privateKey;

            // // Check if Cert/Key is available.
            // if($privateKey == 'We do not have the key becouse it has been generated in another device.' OR $publicKey == 'Do not apply'){
            //    return view('errors.ooops', array(
            //    'subjectCommonName' => $subjectCommonName,
            //    'status' => 'Can´t create P12 archive. No Certificate or PrivateKey available.'));
            // }

            // // Certificate parser (SubjectName...)
            // $subject = openssl_x509_parse($publicKey, true);
            // $subjectCommonName = $subject['subject']['CN'];
            $subjectCommonName = $cert->subjectCommonName;

            // P12 storage path.
            $p12 = storage_path(archives/$subjectCommonName . '.p12');

            // CACert storage path.
            //$cacert = file(storage_path('cert.ca.cer'));
            $cacert = array('-----BEGIN CERTIFICATE-----
MIID+jCCAuKgAwIBAgIDAnEAMA0GCSqGSIb3DQEBCwUAMG0xCzAJBgNVBAYTAkVT
MQ8wDQYDVQQIDAZNYWRyaWQxDzANBgNVBAcMBk1hZHJpZDEPMA0GA1UECgwGVFJB
R1NBMRQwEgYDVQQLDAtUUkFHU0EgQ0EgMTEVMBMGA1UEAwwMVFJBR1NBIENBIEcy
MB4XDTE2MDIwOTE1NTMxN1oXDTQxMDIwMjE1NTMxN1owbTELMAkGA1UEBhMCRVMx
DzANBgNVBAgMBk1hZHJpZDEPMA0GA1UEBwwGTWFkcmlkMQ8wDQYDVQQKDAZUUkFH
U0ExFDASBgNVBAsMC1RSQUdTQSBDQSAxMRUwEwYDVQQDDAxUUkFHU0EgQ0EgRzIw
ggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQChNJLS56VTKsXuOriEe4m8
2Wwc2PMZQ+tLlKbajZerqpXsziXZxsere18XqUEldeWyzZM68WWB0PbNPji5EgnL
69leMpeCX5imB3Bsh/wVxdhQBJFUOlANGAkq5fG9MxzLBTAz/UjBMhMtr0XU00fd
vSir3iWxl2v3ztW0/TZqR1S27Fivqp9ihq7XV4SXYOqyBsZtEuPSqtPQf8i0FP8j
mzmGzO5tzsGsi5UFhrFPFFV537AuTFgzlylIQdWRMFSkrC3UEKsl5ubkcA3rv79G
DYxzP/Brw84nFGzuS/LqGxOs+S45dsthW6wp7x11iLdtFbbmDBUqZFC/CqJdNjSJ
AgMBAAGjgaIwgZ8wHQYDVR0OBBYEFK5n9AgxrpbXgOPNbQZfZbftBKH8MB8GA1Ud
IwQYMBaAFK5n9AgxrpbXgOPNbQZfZbftBKH8MAwGA1UdEwQFMAMBAf8wCwYDVR0P
BAQDAgEGMBEGCWCGSAGG+EIBAQQEAwIBBjAvBgNVHR8EKDAmMCSgIqAghh5odHRw
Oi8vd3d3LnRyYWdzYS5lcy9jYS1nMi5jcmwwDQYJKoZIhvcNAQELBQADggEBACvi
tBYsdkV9lWNygKOn1cCsg+KLjU7/BTszhZ6KvQLBmwOMc8mU/MpWtolCMxyPp4nu
2B5qZfq1F8zVvs+j23XHE2a5HWZLob3msrbT0o4njh7oPk3i1iqwD4UVX7NQf7l9
uyVtOECgjy0WypPGv7/LLcSDhyNvCCRd1lYC4HWemomQip4nwxmMFYVCyomqHotq
XVAH0WcZMUGzQkYSCGlQUVJM8FcfDoZjB11jJPUIM+Kz0hwAaabUrPQVieJLAooc
XlRXg40mdjehEK9dwNMnD2YGGP4vpeyY3/72FJ+RxWwr1yF3p5cmLdY1LIdGBiIf
TXoKcfB8UFRI5KBGbyw=
-----END CERTIFICATE-----
');

            // Arguments to pass to the P12 archive.
            $p12args = array (
              'extracerts' => $cacert,
              'friendly_name' => $subjectCommonName
            );

            // Export p12 to string to insert in DB.
            $p12export = openssl_pkcs12_export($publicKey, $p12string, $privateKey, $password, $p12args);

            $p12export_to_file = openssl_pkcs12_export_to_file($publicKey, $p12, $privateKey, $password, $p12args);

            // Update field 'p12' in DB.
            Cert::where('subjectCommonName', $subjectCommonName)->update(['p12' => $p12string]);

            $headers = array('Content_Type: application/x-download',);

           return Response::download(storage_path(archives/$subjectCommonName . '.p12'), $subjectCommonName . '.p12', $headers);
      	}

    }

    public function getP12()
    {
        if (isset($_POST['publicKey']) &&
            isset($_POST['privateKey']) &&
            isset($_POST['password']) &&

            !empty($_POST['publicKey']) &&
            !empty($_POST['privateKey']) &&
            !empty($_POST['password']) );
        {
            $publicKey = $_POST['publicKey'];
            $privateKey = $_POST['privateKey'];
            $password = $_POST['password'];

            // Certificate parser (SubjectName...)
            $subject = openssl_x509_parse($publicKey, true);
            $subjectCommonName = $subject['subject']['CN'];

            // P12 storage path.
            $p12 = storage_path(archives/$subjectCommonName . '.p12');

            // Arguments to pass to the P12 archive.
            $p12args = array (
                'friendly_name' => $subjectCommonName,
                'extracerts' => storage_path('cert.ca.cer')
            );

            // Export p12 to string to insert in DB.
            $p12export = openssl_pkcs12_export($publicKey, $p12string, $privateKey, $password);

            $p12export_to_file = openssl_pkcs12_export_to_file($publicKey, $p12, $privateKey, $password, $p12args);


            // Update field 'p12' in DB.
            Cert::where('subjectCommonName', $subjectCommonName)->update(['p12' => $p12string]);

            $headers = array('Content_Type: application/x-download',);

           //return Response::download(storage_path(archives/$subjectCommonName . '.p12'), $subjectCommonName . '.p12', $headers)->deleteFileAfterSend(true);
           return Response::download(storage_path(archives/$subjectCommonName . '.p12'), $subjectCommonName . '.p12', $headers);

      	}
   }

   public function keystore()
   {
       return view ('converter.keystore');
   }

   public function createKeystore(Request $request)
   {

   	if ($request::hasFile('p12'))
   	{
   		$storagePath = storage_path();

   		$srcstoretype = $request::input('srcstoretype');
   		$password = $request::input('password');
   		$dstalias = $request::input('dstalias');
   		$p12 = $request::file('p12');
   		$p12storage = $p12->move($storagePath . '/tmp', $p12 . '.p12');
   	}

        // JKS storage path.
        $jksstorage = storage_path($dstalias . '.jks');

          // Update field 'keystore' in DB.
          //Cert::where('dstalias', $dstalias)->update(['keystore' => $dstalias]);

        $keystore = shell_exec("keytool -importkeystore -deststorepass $password -destkeystore $jksstorage -srckeystore $p12storage -srcstorepass $password -srcstoretype $srcstoretype -noprompt -v 2>&1");


        return view('converter.createKeystore', array(
          'dstalias' => $dstalias,
          'result' => $keystore )
        );
   }

   public function getKeystore()
   {
      if (isset($_POST['dstalias']) && !empty($_POST['dstalias']) );

          $dstalias = $_POST['dstalias'];

          // Update field 'keystore' in DB.
          //Cert::where('dstalias', $dstalias)->update(['keystore' => $dstalias]);

          $headers = array('Content_Type: application/x-download',);

        return Response::download(storage_path($dstalias . '.jks'), $dstalias . '.jks', $headers)->deleteFileAfterSend(true);

   }

   public function pem2der()
   {
       return view ('converter.pem2der');
   }

   public function derCert()
   {
   	if(isset($_POST['pemCert']) && !empty($_POST['pemCert']) );
   		$pemCert = $_POST['pemCert'];

   		// Put PEM certificate in file for openssl command.
        $tmp_storage = '/tmp/';
        $pemCert = file_put_contents($tmp_storage . 'pemCert.pem', $pemCert);

   		$derCert = shell_exec('openssl x509 -inform PEM -outform DER -text -in /tmp/pemCert.pem -out certificate.crt');
      File::delete('/tmp/pemCert.pem');
   		$derCert = 'certificate.crt';

      return view('converter.derCert', array(
          'derCert' => $derCert ));

      // $headers = array('Content_Type: application/x-download');
      // return Response::download($derCert, $derCert, $headers)->deleteFileAfterSend(true);
   }

   public function getDer()
   {
    $derCert = 'certificate.crt';
      $headers = array('Content_Type: application/x-download');
      return Response::download($derCert, $derCert, $headers)->deleteFileAfterSend(true);
   }

   public function der2pem()
   {
       return view ('converter.der2pem');
   }

   public function pemCert()
   {
    if(isset($_POST['derCert']) && !empty($_POST['derCert']) );
      $derCert = $_POST['derCert'];

      // Put DER certificate in file for openssl command.
        $tmp_storage = '/tmp/';
        $derCert = file_put_contents($tmp_storage . 'derCert.crt', $derCert);

      $pemCert = shell_exec('openssl x509 -inform der -in /tmp/derCert.crt -outform pem -out /tmp/certificate.pem');
dd($pemCert);
      File::delete('/tmp/derCert.crt');
      $pemCert = 'certificate.pem';
dd($pemCert);
      return view('converter.pemCert', array(
          'pemCert' => $pemCert ));

      // $headers = array('Content_Type: application/x-download');
      // return Response::download($derCert, $derCert, $headers)->deleteFileAfterSend(true);
   }

   public function getPEM()
   {
    $pemCert = 'certificate.pem';
      $headers = array('Content_Type: application/x-download');
      return Response::download($pemCert, $pemCert, $headers)->deleteFileAfterSend(true);
   }

}
