@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Convert Certificates to P12/PFX</h2>

    <p class="text-info">Generates a PFX(P12) archive from a certificate and his private key.</p>
    </br>
<!--
    {{ Form::open(['url' => 'converter/getP12', 'method' => 'post']) }}
    
    {{ Form::label('Select a certifiate file: ', 'Select a Certificate File: ', ['class' => '']) }}
    {{ Form::File('cert', ['placeholder' => 'Select a Certificate...', 'class'=>'' ]) }}
        @if($errors->has('cert'))
        {{ $errors->first('cert') }} 
    @endif
    </br> -->
    <p><strong>Copy &amp Paste your certificate content.</strong></p>
    {{ Form::open(['url' => 'converter/getP12', 'files' => 'true', 'method' => 'post']) }}
    {{ Form::textarea('certprint', null, array('placeholder' => '-----BEGIN CERTIFICATE-----
A1UEBxMGTWFkcmlkMRUwEwYDVQQKEwxHUlVQTyBUUkFHU0ExGzAZBgNVBAMTEmVm
YWN0dXJhLnRyYWdzYS5lczCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEB
ALh6+mATYMZoFetFaaL6lFDGoLSblVyhee2mE5hjGJtTQNEtxIX8KjxNj8xdOozy
MIICxDCCAawCAQAwYzELMAkGA1UEBhMCRVMxDzANBgNVBAgTBk1hZHJpZDEPMA0G
A1UEBxMGTWFkcmlkMRUwEwYDVQQKEwxHUlVQTyBUUkFHU0ExGzAZBgNVBAMTEmVm
-----END CERTIFICATE-----', 'class' => 'form-control')) }}
    </br>
    <br />
    <p><strong>Copy &amp Paste your Private Key content.</strong></p>
    {{ Form::open(['url' => 'converter/getp12', 'files' => 'true', 'method' => 'post']) }}
    {{ Form::textarea('keyprint', null, array('placeholder' => '-----BEGIN PRIVATE KEY-----
MIICxDCCAawCAQAwYzELMAkGA1UEBhMCRVMxDzANBgNVBAgTBk1hZHJpZDEPMA0G
A1UEBxMGTWFkcmlkMRUwEwYDVQQKEwxHUlVQTyBUUkFHU0ExGzAZBgNVBAMTEmVm
YWN0dXJhLnRyYWdzYS5lczCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEB
ALh6+mATYMZoFetFaaL6lFDGoLSblVyhee2mE5hjGJtTQNEtxIX8KjxNj8xdOozy
MIICxDCCAawCAQAwYzELMAkGA1UEBhMCRVMxDzANBgNVBAgTBk1hZHJpZDEPMA0G
-----END PRIVATE KEY-----', 'class' => 'form-control')) }}
    </br>
    <br />
    {{ Form::label('password: ', 'Passphrase: ', ['class' => '']) }}
    {{ Form::password('password', ['placeholder' => 'Passphrase', 'class' => 'form-control' ]) }}
        @if($errors->has('password'))
        {{ $errors->first('password') }} 
    @endif     
    <br />
    {{ Form::token() }}
    {{ Form::submit('Convert & Get PFX(P12)', ['class' => 'btn btn-success btn-md']) }}
    {{ Form::close() }}
	<br />
</div>
@endsection
