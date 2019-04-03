<?php

namespace App\Http\Controllers;

use Request;
use App\Csr; // Makes the model available to the Controller.
use App\Cert;
use Input;
use Zipper;
use File;
use Response;


class RootCRLController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

  	public function root()
   	{
        return view ('rootcrl.root');
    }

    public function getRootTRAGSA()
    {
      $headers = array('Content_Type: application/x-download',);
      //return Response::download(storage_path('cert.ca.cer'), 'cert.ca.cer', $headers)->deleteFileAfterSend(true);
      return Response::download(storage_path('root.cert.cer'), 'root.cert.cer', $headers);
    }

    public function getRootLE()
    {
      $headers = array('Content_Type: application/x-download',);
      return Response::download(storage_path('le.ca.cer'), 'le.ca.cer', $headers);
    }

    public function crl()
    {
        return view ('rootcrl.crl');
    }

    public function updateCRL(Request $request)
    {

        $password = $request::input('password');
        //$crlPath = storage_path('root.ca.crl');
        $crlPath = "/opt/ca/root/crl/root.ca.crl";
        $updateCRL = shell_exec("sudo openssl ca -config /etc/ssl/openssl.cnf -gencrl -out $crlPath -key $password -batch 2>&1");

        return view ('rootcrl.updateCRL', array(
            'result' => $updateCRL, )
        );
    }

    public function getCRL()
    {
      $headers = array('Content_Type: application/x-download',);
      return Response::download(storage_path('root.ca.crl'), 'root.ca.crl', $headers);
    }

    public function authenticode()
   	{

            return view ('signer.authenticode');
    }

        public function signAuthenticode(Request $request)
    {
        if ($request::hasFile('archive'))
    	{
        $storagePath = storage_path();
        $archive = $request::file('archive');
        $archive_type = $request::input('archive_type');
        $password = $request::input('password');
        $archive_name = $request::file('archive')->getClientOriginalName();
        $archive_uploaded = $archive->move($storagePath . '/tmp', $archive . $archive_type);
    	}

        // Variables to exec jarsigner.
		$keystore = "/opt/keystore/symantec_cs.p12";
		$keystorealias = "grupotragsacs";
		$tsaurl = "http://sha256timestamp.ws.symantec.com/sha256/timestamp"; // Timestamp Server used by Symantec.

        $osslsigncode = shell_exec("osslsigncode sign -pkcs12 $keystore -pass $password -h sha2 -in $archive_uploaded -out $storagePath/$archive_name.signed 2>&1");

        File::delete($archive_uploaded);

        return view ('signer.signAuthenticode', array(
            'archive_name' => $archive_name,
            'archive_type' => $archive_type,
            'result' => $osslsigncode )
        );

    }

    public function getAuthenticode(Request $request)
   {

          $archive_name = $request::input('archive_name');
          $archive_type = $request::input('archive_type');

          // Update field 'JAR in DB.
          //Cert::where('dstalias', $dstalias)->update(['keystore' => $dstalias]);

          $headers = array('Content_Type: application/x-download',);

        return Response::download(storage_path($archive_name . '.signed'), $archive_name . $archive_type, $headers)->deleteFileAfterSend(true);

   }
}
