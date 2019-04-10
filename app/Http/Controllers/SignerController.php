<?php

namespace App\Http\Controllers;

use Request;
use App\Csr; // Makes the model available to the Controller.
use App\Cert;
use Input;
use Zipper;
use File;
use Response;


class SignerController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }


  	public function jar()
   	{
        return view ('signer.jar');

    }

    public function signJAR(Request $request)
    {
        if ($request::hasFile('jar'))
      {
        $storagePath = storage_path();
        $jar = $request::file('jar');
        $password = $request::input('password');
        $jarName = $request::file('jar')->getClientOriginalName();
        $jarUploaded = $jar->move($storagePath . '/tmp', $jar . '.jar');
      }

        // Variables for jarsigner.
		$keystore = "/opt/keystore/codesign.jks";
		$keystorealias = "liquabitcs";
		$tsaurl = "http://sha256timestamp.ws.symantec.com/sha256/timestamp"; // Timestamp Server used by Symantec.

        $jarsigner = shell_exec("jarsigner -tsa $tsaurl -keystore $keystore -storepass $password -signedjar $storagePath/archives/$jarName.signed $jarUploaded $keystorealias 2>&1");

        File::delete($jarUploaded);

        return view ('signer.signJAR', array(
            'jarName' => $jarName,
            'result' => $jarsigner )
        );

    }

    public function getJAR()
   {
      if (isset($_POST['jarName']) && !empty($_POST['jarName']) );

          $jarName = $_POST['jarName'];

          // Update field 'JAR in DB.
          //Cert::where('dstalias', $dstalias)->update(['keystore' => $dstalias]);

          $headers = array('Content_Type: application/x-download',);

        return Response::download(storage_path('archives/' . $jarName . '.signed'), $jarName . '.signed', $headers)->deleteFileAfterSend(true);

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
		$keystore = "/opt/keystore/codesign.p12";
		$keystorealias = "liquabitcs";
        //$tsaurl = "http://timestamp.verisign.com/scripts/timstamp.dll"; // Timestamp Server used by Symantec (Authenticode).
        $tsaurl = "http://timestamp.digicert.com";

        $osslsigncode = shell_exec("osslsigncode sign -pkcs12 $keystore -pass $password -h sha2 -t $tsaurl -in $archive_uploaded -out $storagePath/archives/$archive_name.signed 2>&1");

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

        return Response::download(storage_path('archives/' . $archive_name . '.signed'), $archive_name . $archive_type, $headers)->deleteFileAfterSend(true);

   }

   public function search()
   {

    $archives = File::files(storage_path());

      return View('signer.search', array(
        'archives' => $archives ));
   }

   public function results(Request $request)
   {

   	$name = $request::input('name');

    return view('signer.results', array('name' => $name));
   }
}
