@extends('layouts.app')

@section('content')

<div class="container">
      
    <h2><i class="fas fa-file-import"></i> Import / Replace CA Keypair</h2>
    <br />
    <p><strong class="text-primary">CA Common Name.</strong></p>
    {{ Form::open(['url' => 'certs/mgmt/importReplaceCAKeyPair', 'method' => 'post']) }}
    <input type="text" class="form-control" name="subjectCommonName" value="{{ (isset($input['subjectCommonName'])) ? e($input['subjectCommonName']) : '' }}" placeholder="  Name of the certificate to import.....">
    @if($errors->has('subjectCommonName'))
        {{ $errors->first('subjectCommonName') }} 
    @endif
    <br />
    <br />
    <p><strong class="text-primary">Paste your CA Public Key content.</strong></p>
    {{ Form::open(['url' => 'certs/mgmt/importReplaceCAKeyPair', 'files' => 'true', 'method' => 'post']) }}
    {{ Form::textarea('publicKey', null, array('placeholder' => '-----BEGIN CERTIFICATE-----
A1UEBxMGTWFkcmlkMRUwEwYDVQQKEwxHUlVQTyBUUkFHU0ExGzAZBgNVBAMTEmVm
YWN0dXJhLnRyYWdzYS5lczCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEB
ALh6+mATYMZoFetFaaL6lFDGoLSblVyhee2mE5hjGJtTQNEtxIX8KjxNj8xdOozy
MIICxDCCAawCAQAwYzELMAkGA1UEBhMCRVMxDzANBgNVBAgTBk1hZHJpZDEPMA0G
A1UEBxMGTWFkcmlkMRUwEwYDVQQKEwxHUlVQTyBUUkFHU0ExGzAZBgNVBAMTEmVm
YWN0dXJhLnRyYWdzYS5lczCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEB
-----END CERTIFICATE-----', 'class' => 'form-control')) }}
    <br />
    <br />
    <p><strong class="text-primary">Paste your CA Private Key content.</strong></p>
    {{ Form::open(['url' => 'certs/mgmt/importReplaceCAKeyPair', 'files' => 'true', 'method' => 'post']) }}
    {{ Form::textarea('privateKey', null, array('placeholder' => '-----BEGIN PRIVATE KEY-----
MIICxDCCAawCAQAwYzELMAkGA1UEBhMCRVMxDzANBgNVBAgTBk1hZHJpZDEPMA0G
A1UEBxMGTWFkcmlkMRUwEwYDVQQKEwxHUlVQTyBUUkFHU0ExGzAZBgNVBAMTEmVm
YWN0dXJhLnRyYWdzYS5lczCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEB
ALh6+mATYMZoFetFaaL6lFDGoLSblVyhee2mE5hjGJtTQNEtxIX8KjxNj8xdOozy
MIICxDCCAawCAQAwYzELMAkGA1UEBhMCRVMxDzANBgNVBAgTBk1hZHJpZDEPMA0G
A1UEBxMGTWFkcmlkMRUwEwYDVQQKEwxHUlVQTyBUUkFHU0ExGzAZBgNVBAMTEmVm
YWN0dXJhLnRyYWdzYS5lczCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEB
-----END PRIVATE KEY-----', 'class' => 'form-control')) }}
    <br />
    <br />
    <p><strong class="text-primary">Comments (Optional).</strong></p>
    {{ Form::open(['url' => 'certs/mgmt/importReplaceCAKeyPair', 'method' => 'post']) }}
    {{ Form::textarea('comments', null, array('placeholder' => 'Give some information here', 'class' => 'form-control')) }}
    <br />
    <br />
    {{ Form::token() }}
    {{ Form::button('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Import / Replace', ['class' => 'btn btn-success', 'type' => 'submit']) }}
    {{ Form::close() }}
    </div>
    <br />
</div>
@endsection
