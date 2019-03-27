<?php

namespace App\Http\Controllers;

use Request;
use App\Csr; // Makes the model available to the Controller.
use App\Cert;
use Input;
use Zipper;
use File;
use Response;


class LEController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }


  public function index()
   	{
        return view ('le.index');     
    }
}