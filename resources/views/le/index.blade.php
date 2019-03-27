@extends('layouts.app')

@section('content') 

<div class="container">

	  <h2 class="text-info">Let´s Encrypt CSR Signer</h2>      
      <h3 class="text-danger">Work in progress</h3>      
		
	 <p class="text-info">This will return a certificate signed by Let´s Encrypt.</p>
    </br>
    {{ Form::open(['url' => 'le/verification', 'files' => 'true', 'method' => 'post']) }}
    {{ Form::label('email', 'LE Registered e-mail address', ['class' => '']) }}
    <input class="form-control" type="text" name="email" value="{{ (isset($input['email'])) ? e($input['email']) : '' }}" placeholder="LE Registered e-mail address">
    <br />
    <p><strong>Copy &amp Paste your LE Account Private Key</strong></p>
    {{ Form::textarea('accountkey', null, array('placeholder' => '-----BEGIN PRIVATE KEY-----
MIICxDCCAawCAQAwYzELMAkGA1UEBhMCRVMxDzANBgNVBAgTBk1hZHJpZDEPMA0G
A1UEBxMGTWFkcmlkMRUwEwYDVQQKEwxHUlVQTyBUUkFHU0ExGzAZBgNVBAMTEmVm
YWN0dXJhLnRyYWdzYS5lczCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEB
ALh6+mATYMZoFetFaaL6lFDGoLSblVyhee2mE5hjGJtTQNEtxIX8KjxNj8xdOozy
MIICxDCCAawCAQAwYzELMAkGA1UEBhMCRVMxDzANBgNVBAgTBk1hZHJpZDEPMA0G
-----END PRIVATE KEY-----', 'class' => 'form-control')) }}
    
    <br />
    </br>

    <p><strong>Copy &amp Paste your CSR content</strong></p>
    {{ Form::textarea('csr', null, array('placeholder' => '-----BEGIN CERTIFICATE REQUEST-----
MIICxDCCAawCAQAwYzELMAkGA1UEBhMCRVMxDzANBgNVBAgTBk1hZHJpZDEPMA0G
A1UEBxMGTWFkcmlkMRUwEwYDVQQKEwxHUlVQTyBUUkFHU0ExGzAZBgNVBAMTEmVm
YWN0dXJhLnRyYWdzYS5lczCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEB
ALh6+mATYMZoFetFaaL6lFDGoLSblVyhee2mE5hjGJtTQNEtxIX8KjxNj8xdOozy
MIICxDCCAawCAQAwYzELMAkGA1UEBhMCRVMxDzANBgNVBAgTBk1hZHJpZDEPMA0G
-----END CERTIFICATE REQUEST-----', 'class' => 'form-control')) }}
    
    <br />
    </br>
    {{ Form::label('verification: ', 'Verification Method: ', ['class' => '']) }}
    {{ Form::select('verification', ['http_verification' => 'HTTP Verification - Not implemented', 'dns_verification' => 'DNS Verification - Not implemented'], null, ['placeholder' => 'Select Verification method', 'class' => 'form-control' ]) }}
        @if($errors->has('key_length'))
        {{ $errors->first('key_length') }} 
    @endif     
    <br />
    </br>
    {{ Form::token() }}
    {{ Form::submit('Submit Data', ['class' => 'btn btn-success btn-md']) }}
    {{ Form::close() }}
<br />
</div>
@endsection
