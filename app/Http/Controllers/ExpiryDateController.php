<?php

namespace App\Http\Controllers;

use Request;
use App\Cert;
use File;
use DateTime;


class ExpiryDateController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function run()
    {
        $certs = Cert::all();
        foreach ($certs as $cert) {
            $subjectCommonName = $cert->subjectCommonName;
      
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
        }
        return ('ExpiryDateController Script executed!!');
    }
}
