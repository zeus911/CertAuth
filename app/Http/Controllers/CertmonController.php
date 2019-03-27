<?php

namespace App\Http\Controllers;

use Request;
use App\Cert;
use Input;
use Zipper;
use File;
use Response;


class CertmonController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }


  	public function index()
   	{
        return view ('certmon.index');     

    }

}