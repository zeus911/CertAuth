<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cert;

class CertStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	public function certStatus(){
	// Grab all certs from DB.
	$certs = Cert::all();

        foreach ($certs as $cert) {
         $id = $cert->id;
         $certprint = $cert->certprint;
         //print_r($id);
 		 //print_r($certprint);
 		 $cert = openssl_x509_parse($certprint);
 		 $cert_expiry_date = $cert['validTo_time_t'];
 		 print_r($id);
 		 print_r($cert_expiry_date);
        }

        $certstatus = 'Valid';

        return view ('certs.mgmt.certstatus', array(
          'id' => $id,
          'certstatus' => $certstatus,
          ));

	}
    // // Certificate expiry status and days left
    // $cert = openssl_x509_parse($certgen);
    // $cert_expiry_date = $cert['validTo_time_t']; // unixtime in sec.
    // $today = strtotime(date("Y-m-d")); // unixtime in sec.
    // $result = array();

    // // Translate Status to Valid/Expired/Left days
    // if ($today < $cert_expiry_date) {
    //     $result['cert_expired'] = false;
    //     $status = 'Valid';
    // } else {
    //     $result['cert_expired'] = true; 
    //     $result['cert_time_expired'] = $today - $cert_expiry_date;
    //     $status = 'Expired';
    // }
    // if ($result['cert_expired'] == false) {
    //     $cert_expiry_days = ($cert_expiry_date - $today) / 86400;
    //     $cert_expiry_days = number_format($cert_expiry_days, 0); // remove decimals.
    // }
}
