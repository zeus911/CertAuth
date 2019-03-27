@extends('layouts.app')

@section('content') 

<div class="container">

	  <h2>Request New CSR</h2>      
		
	<h5 class="text-primary"><strong>Generate a new CSR/Private Key. This is used for signing certificates with an external CA.</strong></h5>
    <p class="text-primary"><i class="far fa-eye"></i> Separate domain names with <span class="badge badge-dark">Spaces</span>. <strong><a target="_blank" href="https://datatracker.ietf.org/wg/pkix/charter/"/> [PKIX guidelines compatibility]</strong></a></p>

    <div class="bs-callout bs-callout-primary">
        {{ Form::open(['url' => 'csr/created', 'method' => 'post']) }}
        {{ Form::label('certificate CN: ', 'Certificate CN(s): ', ['class' => '']) }}
        <input type="text" class="form-control input-md" name="subjectCommonName" value="{{ (isset($input['subjectCommonName'])) ? e($input['subjectCommonName']) : '' }}" placeholder="  Example: cn.domain.com cn2domain.com cn3.domain.com.....">
        @if($errors->has('subjectCommonName'))
            {{ $errors->first('subjectCommonName') }} 
        @endif
        <br />
        {{ Form::label('subjectOrganization: ', 'Organization Name: ', ['class' => '']) }}
        {{ Form::select('subjectOrganization', ['LIQUABit' => 'LIQUABit', 'Prototypes' => 'Prototypes'], null, ['placeholder' => '-- Select an Organization Name --', 'class' => 'form-control' ]) }}
            @if($errors->has('subjectOrganization'))
            {{ $errors->first('subjectOrganization') }} 
        @endif
        <br />
        {{ Form::label('certificate type: ', 'Certificate Type: ', ['class' => '']) }}
        {{ Form::select('extensionsExtendedKeyUsage', ['serverAuth_clientAuth' => 'TLS Web Server & Client Authentication', 'serverAuth' => 'TLS Web Server Authentication', 'clientAuth' => 'TLS Web Client Authentication', 'codeSigning' => 'Code Signing'], null, ['placeholder' => '-- Select Extended Key Usage --', 'class' => 'form-control' ]) }}
            @if($errors->has('extensionsExtendedKeyUsage'))
            {{ $errors->first('extensionsExtendedKeyUsage') }} 
        @endif
        <br />
        {{ Form::label('signatureTypeSN: ', 'Signature Algorithm: ', ['class' => '']) }}
        {{ Form::select('signatureTypeSN', ['RSA-SHA256' => 'RSA-SHA256', 'sha384' => 'RSA-SHA384 - Not implemented', 'RSA-SHA521' => 'RSA-SHA521 - Not implemented'], null, ['placeholder' => '-- Select Hash Algorithm --', 'class' => 'form-control' ]) }}
            @if($errors->has('signatureTypeSN'))
            {{ $errors->first('signatureTypeSN') }} 
        @endif     
        <br />
        {{ Form::label('emailAddress: ', 'E-mail (Optional): [Not implemented yet]. Certificate Keypair will be send to this e-mail. Keep Private Key save.', ['class' => 'text-danger']) }}
        {{ Form::email('emailAddress', '', ['placeholder' => 'Example: alias@domain.tld', 'class' => 'form-control' ] ) }}
        @if($errors->has('emailAddress'))
            {{ $errors->first('emailAddress') }} 
        @endif
        <br />
        {{ Form::token() }}
        {{ Form::button('<i class="fa fa-cogs" aria-hidden="true"></i> Generate CSR', ['class' => 'btn btn-success', 'type' => 'submit']) }}
        {{ Form::close() }}
    </div>
</div>
@endsection
