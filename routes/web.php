<?php

Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});

// Self-Service
Route::get('home', 'HomeController@index')->name('home');

// Changelog and To Do´s
Route::get('changelog', 'HomeController@changelog');
Route::get('todo', 'HomeController@todo');
Route::get('kb', 'HomeController@kb');

// Certs
Route::get('certs/create', 'CertsController@create');
Route::post('certs/created', 'CertsController@created');
Route::post('certs/getP12', 'CertsController@getP12');
Route::post('certs/getCert', 'CertsController@getCert');
Route::post('certs/revokeCert', 'CertsController@revokeCert');

// Certs - Mgmt
Route::get('certs/mgmt', 'MgmtController@index');
Route::post('certs/mgmt/details/', 'MgmtController@details');
Route::post('certs/mgmt/viewCSR', [ 'as' => 'viewCSR', 'uses' => 'MgmtController@viewCSR']);
Route::post('certs/mgmt/update', 'MgmtController@update');
Route::any('certs/mgmt/import', 'MgmtController@import');
//Route::post('certs/mgmt/updateCSR', 'MgmtController@updateCSR');
//Route::post('certs/mgmt/updatePublicKey', 'MgmtController@updatePublicKey');
//Route::post('certs/mgmt/updatePrivateKey', 'MgmtController@updatePrivateKey');

Route::post('certs/mgmt/updated', 'MgmtController@updated');
Route::post('certs/mgmt/delete', 'MgmtController@delete');
Route::post('certs/mgmt/deleted', 'MgmtController@deleted');
Route::post('certs/mgmt/keymatcher', 'MgmtController@keymatcher');
// 
Route::post('certs/mgmt/getCSR', 'GetController@getCSR');
Route::post('certs/mgmt/getPublicKey', 'GetController@getPublicKey');
Route::post('certs/mgmt/getPrivateKey', 'GetController@getPrivateKey');
Route::post('certs/mgmt/getP12', 'GetController@getP12');
//
Route::post('certs/mgmt/renew', 'RenewRevokeController@renew');
Route::post('certs/mgmt/getRenewed', 'RenewRevokeController@getRenewed');
Route::post('certs/mgmt/revoke', 'RenewRevokeController@revoke');
Route::post('certs/mgmt/revoked', 'RenewRevokeController@revoked');

// Status - Test page!:...Delete ones tested.
Route::get('certs/mgmt/certstatus', 'CertStatusController@certStatus');

// Generate CSR and Keys.
Route::get('csr/create', 'CsrController@create');
Route::post('csr/created', 'CsrController@created');
Route::post('csr/getCSR', 'CsrController@getCSR');

// Sign external CSRs
Route::get('csr/sign', 'CsrController@sign');
Route::post('csr/signed', 'CsrController@signed');
Route::post('csr/getExtCert', 'CsrController@getExtCert');

// Convert certificates to PFX/P12 or Keystore.
Route::get('converter/p12', 'ConverterController@p12');
Route::post('converter/createP12', 'ConverterController@createP12');
Route::post('converter/storeP12', 'ConverterController@storeP12');
Route::post('converter/getP12', 'ConverterController@getP12');
Route::get('converter/keystore', 'ConverterController@keystore');
Route::post('converter/createKeystore', 'ConverterController@createKeystore');
Route::post('converter/getKeystore', 'ConverterController@getKeystore');
Route::get('converter/pem2der', 'ConverterController@pem2der');
Route::get('converter/der2pem', 'ConverterController@der2pem');
Route::post('converter/derCert', 'ConverterController@derCert');
Route::post('converter/pemCert', 'ConverterController@pemCert');
Route::post('converter/getDer', 'ConverterController@getDer');


// Dashboard
Route::get('dashboard', 'DashboardController@index');


// JavaARchive signer.
Route::get('signer/jar','SignerController@jar');
Route::post('signer/signJAR','SignerController@signJAR');
Route::post('signer/getJAR','SignerController@getJAR');

// Microsoft Authenticode signer.
Route::get('signer/authenticode','SignerController@authenticode');
Route::post('signer/signAuthenticode','SignerController@signAuthenticode');
Route::post('signer/getAuthenticode','SignerController@getAuthenticode');

// Signer Search/List (JAR/Authenticode).
Route::get('signer/search','SignerController@search');
Route::post('signer/results','SignerController@results');


// Donwload Roots and Update/download CRLs.
Route::get('rootcrl/root','RootCRLController@root');
Route::post('rootcrl/getRootTRAGSA','RootCRLController@getRootTRAGSA');
Route::post('rootcrl/getRootLE','RootCRLController@getRootLE');
Route::get('rootcrl/crl','RootCRLController@crl');
Route::post('rootcrl/updateCRL','RootCRLController@updateCRL');
Route::post('rootcrl/getCRL','RootCRLController@getCRL');

// Let´s Encrypt WebApp.
Route::get('le/index','LEController@index');
Route::post('le/getCert','LEController@getCert');

