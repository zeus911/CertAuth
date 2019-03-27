<?php

namespace App\Http\Controllers;

use Request;
use App\Csr;
use App\Cert;
use Input;
use Zipper;
use File;
use Response;


class GetController extends Controller
{
	  public function __construct()
    {
        $this->middleware('auth');
    }


  	public function getCSR()
   	{
       if  (isset($_POST['subjectCommonName']) && !empty($_POST['subjectCommonName'])) 
       {
            $subjectCommonName = $_POST['subjectCommonName'];

            // Check if CN already exists.
            $cn_exists = Cert::where('subjectCommonName', '=', Request::get('subjectCommonName'))->first();

            if (isset($cn_exists))
            {
              file_put_contents($subjectCommonName . '.csr', $cn_exists->certificateServerRequest);

              $headers = array('Content_Type: application/x-download');
              return Response::download($subjectCommonName . '.csr', $subjectCommonName . '.csr', $headers)->deleteFileAfterSend(true);

             } else {

              return view('errors.ooops', array(
              	'subjectCommonName' => $subjectCommonName,
              	'status' => 'Can´t download CSR.'));
           }
        
        }

    }

    public function getPublicKey()
   	{
       if  (isset($_POST['subjectCommonName']) && !empty($_POST['subjectCommonName'])) 
       {

            $subjectCommonName = $_POST['subjectCommonName'];

            // Getting Collection from Certs.
            $certs = Cert::where('subjectCommonName', $subjectCommonName)->get()->first();

            // Check if CN already exists.
            $cn_exists = Cert::where('subjectCommonName', '=', Request::get('subjectCommonName'))->first();

            // return error page if there is no certificate in DB.
            if ($certs->certprint == 'Do not apply')
            {
              return view('errors.ooops', array(
              	'subjectCommonName' => $subjectCommonName,
              	'status' => 'Can´t find PublicKey. Do not apply'));
            }

            if (isset($cn_exists))
            {
              file_put_contents($subjectCommonName . '.cer', $cn_exists->publicKey);

              $headers = array('Content_Type: application/x-download');
              return Response::download($subjectCommonName . '.cer', $subjectCommonName . '.cer', $headers)->deleteFileAfterSend(true);

             } else {

              return view('errors.ooops', array(
              	'subjectCommonName' => $subjectCommonName,
              	'status' => 'Can´t download PublicKey.'));
           }
        
        }

    }

    public function getPrivateKey()
   	{
       if  (isset($_POST['subjectCommonName']) && !empty($_POST['subjectCommonName'])) 
       {

            $subjectCommonName = $_POST['subjectCommonName'];

            // Check if CN already exists.
            $cn_exists = Cert::where('subjectCommonName', '=', Request::get('subjectCommonName'))->first();

            // Getting Collection from Certs.
            $certs = Cert::where('subjectCommonName', $subjectCommonName)->get()->first();

            // return error page if there is no certificate in DB.
            if ($certs->privateKey == 'We do not have the key becouse it has been generated in another device.')
            {
              return view('errors.ooops', array(
              	'subjectCommonName' => $subjectCommonName,
              	'status' => 'Can´t find PrivateKey becouse it has been generated in another device.'));
            }

            if (isset($cn_exists))
            {
              file_put_contents($subjectCommonName . '.key', $cn_exists->privateKey);

              $headers = array('Content_Type: application/x-download');
              return Response::download($subjectCommonName . '.key', $subjectCommonName . '.key', $headers)->deleteFileAfterSend(true);

             } else {

              return view('errors.ooops', array(
              	'subjectCommonName' => $subjectCommonName,
              	'status' => 'Can´t download PrivateKey.'));
           }
        
        }
    }

    public function getP12()
   	{
  		  if  (isset($_POST['subjectCommonName']) && !empty($_POST['subjectCommonName'])) 
       	{

            $subjectCommonName = $_POST['subjectCommonName'];

            // Check if CN already exists.
            $cn_exists = Cert::where('subjectCommonName', '=', Request::get('subjectCommonName'))->first();
            $p12 = $cn_exists->p12;
            if($p12 == 'PFX archive not generated. You have to re-generate it again if you renewed the certificate.')
            {
              return view('errors.ooops', array(
              	'subjectCommonName' => $subjectCommonName,
              	'status' => 'Can´t find PFX archive.'));

            } elseif (isset($cn_exists)) {

              file_put_contents($subjectCommonName . '.p12', $cn_exists->p12);

              $headers = array('Content_Type: application/x-download');
              return Response::download($subjectCommonName . '.p12', $subjectCommonName . '.p12', $headers)->deleteFileAfterSend(true);

             } else {

              return view('errors.ooops', array(
              	'subjectCommonName' => $subjectCommonName,
              	'status' => 'Buffff, No idea what happent now!.'));
           }
        
        }

    }
}