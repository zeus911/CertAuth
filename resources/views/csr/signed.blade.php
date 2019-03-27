@extends('layouts.app')

@section('content') 

<div class="container">

    <h2>You are about to generate a new certificate for: <strong class="text-success">{{ $subjectCommonName }}</strong>.</h2>      
    <h5 class="text-primary"><strong> This is used for signing CSR files generated externally.</strong></h5>

    {{ Form::open(['url' => 'csr/getExtCert', 'files' => 'true', 'method' => 'post']) }}
    <input type="hidden" name="subjectCommonName" value="{{ $subjectCommonName }}">
    <input type="hidden" name="certificateServerRequest" value="{{ $certificateServerRequest }}"> 
    <input type="hidden" name="caCertificate" value="{{ $caCertificate }}">
    <input type="hidden" name="validityPeriod" value="{{ $validityPeriod }}">
    <input type="hidden" name="extensionsExtendedKeyUsage" value="{{ $extensionsExtendedKeyUsage }}">
    <input type="hidden" name="signatureTypeSN" value="{{ $signatureTypeSN }}"> 
    <input type="hidden" name="privateKey" value="{{ $privateKey }}">
    <input type="hidden" name="p12" value="{{ $p12 }}">
    <input type="hidden" name="password" value="{{ $password }}">
    {{ Form::token() }}
    {{ Form::button('<i class="fa fa-download" aria-hidden="true"></i> Sign & Get Certificate', ['class' => 'btn btn-primary', 'type' => 'submit']) }}
    {{ Form::close() }}
</div>
@endsection

