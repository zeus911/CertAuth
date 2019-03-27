@extends('layouts.app')

@section('content') 

<div class="container">

	<h2>Certificate Signing Request</h2>      
		
	<h5 class="text-primary"><strong>Generate a new certificate from a given CSR. This is used for signing CSR files generated externally.</strong></h5>
    <div class="bs-callout bs-callout-primary">
    <br />
    <p>Paste your CSR content.</p>
    {{ Form::open(['url' => 'csr/signed', 'files' => 'true', 'method' => 'post']) }}
    {{ Form::textarea('certificateServerRequest', null, array('placeholder' => '-----BEGIN CERTIFICATE REQUEST-----
MIICxDCCAawCAQAwYzELMAkGA1UEBhMCRVMxDzANBgNVBAgTBk1hZHJpZDEPMA0G
A1UEBxMGTWFkcmlkMRUwEwYDVQQKEwxHUlVQTyBUUkFHU0ExGzAZBgNVBAMTEmVm
YWN0dXJhLnRyYS5lczCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEB
ALh6+mATYMZoFetFaaL6lFDGoLSblVyhee2mE5hjGJtTQNEtxIX8KjxNj8xdOozy
MIICxDCCAawCAQAwYzELMAkGA1UEBhMCRVMxDzANBgNVBAgTBk1hZHJpZDEPMA0G
-----END CERTIFICATE REQUEST-----', 'class' => 'form-control')) }}
    <br />
    {{ Form::label('caCertificate: ', 'CA Certificate: ', ['class' => '']) }}
    {{ Form::select('caCertificate', ['LIQUABit Private Root CA.' => 'LIQUABit Private Root CA.', 'Prototypes Private Intermediate CA.' => 'Prototypes Private Intermediate CA.'], null, ['placeholder' => '-- Select the CA Certificate --', 'class' => 'form-control' ]) }}
        @if($errors->has('caCertificate'))
        {{ $errors->first('caCertificate') }} 
    @endif
    <br />
    {{ Form::label('Validity Period: ', 'Validity Period: ', ['class' => '']) }}
    {{ Form::select('validityPeriod', ['365' => '1 Year', '730' => '2 Years', '1095' => '3 Years', '1460' => '4 Years', '1825' => '5 Years'], null, ['placeholder' => '-- Select Validity Period --', 'class' => 'form-control' ]) }}
        @if($errors->has('validityPeriod'))
        {{ $errors->first('validityPeriod') }} 
    @endif 
    <br />
    {{ Form::label('certificate type: ', 'Certificate Type: ', ['class' => '']) }}
    {{ Form::select('extensionsExtendedKeyUsage', ['serverAuth_clientAuth' => 'TLS Web Server & Client Authentication', 'serverAuth' => 'TLS Web Server Authentication', 'clientAuth' => 'TLS Web Client Authentication', 'codeSigning' => 'Code Signing'], null, ['placeholder' => '-- Select Extended Key Usage --', 'class' => 'form-control' ]) }}
        @if($errors->has('extensionsExtendedKeyUsage'))
        {{ $errors->first('extensionsExtendedKeyUsage') }} 
    @endif
    <br />
    {{ Form::label('signature algorithm: ', 'Signature Algorithm: ', ['class' => '']) }}
    {{ Form::select('signatureTypeSN', ['RSA-SHA256' => 'RSA-SHA256', 'RSA-SHA384' => 'RSA-SHA384 - Not implemented', 'RSA-SHA521' => 'RSA-SHA521 - Not implemented'], null, ['placeholder' => '-- Select Hash Algorithm --', 'class' => 'form-control' ]) }}
        @if($errors->has('signatureTypeSN'))
        {{ $errors->first('signatureTypeSN') }} 
    @endif     
    <br />
    {{ Form::label('email: ', 'E-mail (Optional): [Not implemented yet]. Certificate Keypair will be send to this e-mail. Keep Private Key save.', ['class' => 'text-danger']) }}
    {{ Form::email('email', '', ['placeholder' => 'Example: alias@domain.tld', 'class' => 'form-control' ] ) }}
    @if($errors->has('email'))
        {{ $errors->first('email') }} 
    @endif
    <br />
    {{ Form::label('password', 'CA Password', ['class' => '']) }}
    {{ Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) }}
        @if($errors->has('password'))
        {{ $errors->first('password') }}
        @endif
    <br />
    {{ Form::token() }}
    <!-- {{ Form::submit('Sign CSR', ['class' => 'btn btn-success btn-md']) }} -->
    {{ Form::button('<i class="fa fa-cogs" aria-hidden="true"></i> Sign CSR', ['class' => 'btn btn-outline-success btn-md', 'type' => 'submit']) }}
    {{ Form::close() }}
    </div>
</div>
@endsection