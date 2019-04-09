<?php

namespace App\Http\Controllers;

use App\Cert;
use DB;
use App\Charts\CertsStatus;
use App\Charts\CertsCreated;
use App\Charts\CertsIssuedBy;
use App\Charts\CertsTypes;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // All Certs collections.
        $certsAll = Cert::all();

        // Total Nº of certificates in DB.
        $certsNumber = Cert::all()->count();

        // Charts Certificates created Monthly, Yearly
        $certs_month = Cert::whereMonth('created_at', date('m'))->count();
        $certs_year = Cert::whereYear('created_at', date('Y'))->count();
        $certs_number_issued = new CertsCreated;
        $certs_number_issued->labels(['This Year', 'This Month']);
        $certs_number_issued->dataset('Nº of Certificates Created In', 'bar', [$certs_year, $certs_month])->color(['#0080ff', '#00bfff']);

        // Chart - Certificates status.
        $certs_status_blank = Cert::where('status', '=', '')->count();
        $certs_status_valid = Cert::where('status', '=', 'Valid')->count();
        $certs_status_expiring = Cert::where('status', '=', 'Expiring')->count();
        $certs_status_expired = Cert::where('status', '=', 'Expired')->count();
        $certs_status_revoked = Cert::where('status', '=', 'Revoked')->count();
        $certs_status = new CertsStatus;
        $certs_status->labels(['N/A', 'Valid', 'Expiring', 'Expired', 'Revoked']);
        $certs_status->dataset('Certificates Status', 'bar', [$certs_status_blank, $certs_status_valid, $certs_status_expiring, $certs_status_expired, $certs_status_revoked])
        ->color(['#3333ff', '#33cc33', '#ff8000', '#ff0000', '#ff0000']);
        //$certs_status->container($certs_status->lebels = null);

        // Charts Issued by CA
        $IssuerCNLB = Cert::where('issuerCN', 'like', '%LIQUAB%')->count();
        $IssuerCNFP = Cert::where('issuerCN', 'like', '%FIRMAPROFESIONAL%')->count();
        $IssuerCNDC = Cert::where('issuerCN', 'like', '%DigiCert%')->count();
        $IssuerCNSY = Cert::where('issuerCN', 'like', '%Symantec%')->count();
        $IssuerCNVE = Cert::where('issuerCN', 'like', '%Verisign%')->count();
        $IssuerCNLE1 = Cert::where('issuerCN', 'like', '%Let´s Encrypt%')->count();
        $IssuerCNLE2 = Cert::where('issuerCN', 'like', '%DST%')->count();

        $certs_issued_by = new CertsIssuedBy;
        $certs_issued_by->labels(['TRAGSA CA G2', 'Firma Profesional', 'DigiCert', 'Symantec', 'Verisign', "Let's Encrypt", "DST Root CA X3"]);
        $certs_issued_by->dataset('Nº of Issued By each CA', 'bar', [$IssuerCNLB, $IssuerCNFP, $IssuerCNDC, $IssuerCNSY, $IssuerCNVE, $IssuerCNLE1, $IssuerCNLE2 ])
        ->color(['#ff8000', '#3333ff', '#ff8000', '#3333ff', '#ff8000', '#3333ff']);

        // Charts - Certificate types.
        $certs_tls_web_server = Cert::where('extensionsExtendedKeyUsage', 'like', '%SSL Server%')->orWhere('extensionsExtendedKeyUsage', 'like', '%TLS Web Server%')->count();
        $certs_cliencerts_tls_web_client = Cert::where('extensionsExtendedKeyUsage', 'like', '%SSL Client%')->orWhere('extensionsExtendedKeyUsage', 'like', '%TLS Web Client%')->count();

        $certs_code_signing = Cert::where('extensionsExtendedKeyUsage', 'like', '%Signing%')->count();

        $certs_type = new CertsTypes;
        $certs_type->labels(['TLS Web Server Authentication', 'TLS Web Client Authentication', 'Code Signing']);
        $certs_type->dataset('extensionsExtendedKeyUsage', 'bar', [$certs_tls_web_server, $certs_cliencerts_tls_web_client, $certs_code_signing])->color('#3333ff');
//dd($certs_tls_web_server, $certs_cliencerts_tls_web_client, $certs_code_signing);
        return view ('dashboard.index', [
          'certsNumber' => $certsNumber,
          'certs_number_issued' => $certs_number_issued,
          'certs_status' => $certs_status,
          'certs_issued_by' => $certs_issued_by,
          'certs_type' => $certs_type ]);
       }
    }

