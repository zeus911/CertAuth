@extends('layouts.app')

@section('content')

<div class="container">
      
      <h2><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update DB for <strong class="text-success">{{ $subjectCommonName }}</strong></h2>
    </br>
    <p><strong class="text-primary">Paste your CSR content.</strong></p>
    {{ Form::open(['url' => 'certs/mgmt/updated', 'files' => 'true', 'method' => 'post']) }}
    <input class="sr-only" type="text" name="subjectCommonName" value="{{ $subjectCommonName }}">
    {{ Form::textarea('certificateServerRequest', null, array('placeholder' => '------BEGIN CERTIFICATE REQUEST------
A1UEBxMGTWFkcmlkMRUwEwYDVQQKEwxHUlVQTyBUUkFHU0ExGzAZBgNVBAMTEmVm
YWN0dXJhLnRyYWdzYS5lczCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEB
ALh6+mATYMZoFetFaaL6lFDGoLSblVyhee2mE5hjGJtTQNEtxIX8KjxNj8xdOozy
MIICxDCCAawCAQAwYzELMAkGA1UEBhMCRVMxDzANBgNVBAgTBk1hZHJpZDEPMA0G
A1UEBxMGTWFkcmlkMRUwEwYDVQQKEwxHUlVQTyBUUkFHU0ExGzAZBgNVBAMTEmVm
YWN0dXJhLnRyYWdzYS5lczCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEB
-----END CERTIFICATE REQUEST-----', 'class' => 'form-control')) }}
    </br>
    <br />
    <p><strong class="text-primary">Paste your Certificate content.</strong></p>
    {{ Form::open(['url' => 'certs/mgmt/updated', 'files' => 'true', 'method' => 'post']) }}
    {{ Form::textarea('publicKey', null, array('placeholder' => '-----BEGIN CERTIFICATE-----
A1UEBxMGTWFkcmlkMRUwEwYDVQQKEwxHUlVQTyBUUkFHU0ExGzAZBgNVBAMTEmVm
YWN0dXJhLnRyYWdzYS5lczCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEB
ALh6+mATYMZoFetFaaL6lFDGoLSblVyhee2mE5hjGJtTQNEtxIX8KjxNj8xdOozy
MIICxDCCAawCAQAwYzELMAkGA1UEBhMCRVMxDzANBgNVBAgTBk1hZHJpZDEPMA0G
A1UEBxMGTWFkcmlkMRUwEwYDVQQKEwxHUlVQTyBUUkFHU0ExGzAZBgNVBAMTEmVm
YWN0dXJhLnRyYWdzYS5lczCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEB
-----END CERTIFICATE-----', 'class' => 'form-control')) }}
    </br>
    <br />
    <p><strong class="text-primary">Paste your Private Key content.</strong></p>
    {{ Form::open(['url' => 'certs/mgmt/updated', 'files' => 'true', 'method' => 'post']) }}
    {{ Form::textarea('privateKey', null, array('placeholder' => '-----BEGIN PRIVATE KEY-----
MIICxDCCAawCAQAwYzELMAkGA1UEBhMCRVMxDzANBgNVBAgTBk1hZHJpZDEPMA0G
A1UEBxMGTWFkcmlkMRUwEwYDVQQKEwxHUlVQTyBUUkFHU0ExGzAZBgNVBAMTEmVm
YWN0dXJhLnRyYWdzYS5lczCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEB
ALh6+mATYMZoFetFaaL6lFDGoLSblVyhee2mE5hjGJtTQNEtxIX8KjxNj8xdOozy
MIICxDCCAawCAQAwYzELMAkGA1UEBhMCRVMxDzANBgNVBAgTBk1hZHJpZDEPMA0G
A1UEBxMGTWFkcmlkMRUwEwYDVQQKEwxHUlVQTyBUUkFHU0ExGzAZBgNVBAMTEmVm
YWN0dXJhLnRyYWdzYS5lczCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEB
-----END PRIVATE KEY-----', 'class' => 'form-control')) }}
    </br>
    <br />
    <p><strong class="text-primary">Comments (Optional).</strong></p>
    {{ Form::open(['url' => 'certs/mgmt/updated', 'method' => 'post']) }}
    {{ Form::textarea('comments', null, array('placeholder' => 'Give some information here', 'class' => 'form-control')) }}
    </br>
    <br />

    {{ Form::token() }}
    {{ Form::button('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update', ['class' => 'btn btn-outline-primary btn-md', 'type' => 'submit']) }}
    {{ Form::close() }}
    </div>
    <br />
</div>
@endsection
