@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Convert PEM to DER</h2>

    <p class="text-info">Converts certificate in PEM format to DER format (*.crt, *cer, *.der).</p>
    </br>
<!--
    {{ Form::open(['url' => 'converter/getP12', 'method' => 'post']) }}
    
    {{ Form::label('Select a certifiate file: ', 'Select a Certificate File: ', ['class' => '']) }}
    {{ Form::File('cert', ['placeholder' => 'Select a Certificate...', 'class'=>'' ]) }}
        @if($errors->has('cert'))
        {{ $errors->first('cert') }} 
    @endif
    </br> -->
    <p><strong>Paste your PEM certificate content.</strong></p>
    {{ Form::open(['url' => 'converter/derCert', 'files' => 'true', 'method' => 'post']) }}
    {{ Form::textarea('pemCert', null, array('placeholder' => '-----BEGIN CERTIFICATE-----
A1UEBxMGTWFkcmlkMRUwEwYDVQQKEwxHUlVQTyBUUkFHU0ExGzAZBgNVBAMTEmVm
YWN0dXJhLnRyYWdzYS5lczCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEB
ALh6+mATYMZoFetFaaL6lFDGoLSblVyhee2mE5hjGJtTQNEtxIX8KjxNj8xdOozy
MIICxDCCAawCAQAwYzELMAkGA1UEBhMCRVMxDzANBgNVBAgTBk1hZHJpZDEPMA0G
A1UEBxMGTWFkcmlkMRUwEwYDVQQKEwxHUlVQTyBUUkFHU0ExGzAZBgNVBAMTEmVm
-----END CERTIFICATE-----', 'class' => 'form-control')) }}
    </br>
    <br />
    {{ Form::token() }}
    {{ Form::submit('Convert to DER Certificate', ['class' => 'btn btn-success btn-md']) }}
    {{ Form::close() }}
	<br />
</div>
@endsection
