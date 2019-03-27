@extends('layouts.app')

@section('content')

<div class="container">

    <h2></h2>
    <h2 class="">Request New Certificate</h2>
    <h5 class="text-primary"><strong> Generates a new CSR/Certificate/Private Key with the data provided in the form.</strong></h5> 
    <p class="text-primary"><i class="far fa-eye"></i> Separate domain names with <span class="badge badge-dark">SPACES</span>. <strong class="text-secondary"><a target="_blank" href="https://datatracker.ietf.org/wg/pkix/charter/"/> [PKIX guidelines compatibility]</strong></a></p>
    <div class="bs-callout bs-callout-primary">

    {{ Form::open(['url' => 'certs/created', 'method' => 'post']) }}
    {{ Form::label('certificate CN[+]SANs: ', 'Certificate CN[+]SANs: ', ['class' => '']) }}
    <input type="text" class="form-control input-sm" name="subjectCommonName" value="{{ (isset($input['subjectCommonName'])) ? e($input['subjectCommonName']) : '' }}" placeholder="  Example: cn.domain.com cn2domain.com cn3.domain.com.....">
    @if($errors->has('subjectCommonName'))
        {{ $errors->first('subjectCommonName') }} 
    @endif
    <br />
    {{ Form::label('organizationName: ', 'Organization Name: [Not implemented yet]', ['class' => 'text-danger']) }}
    {{ Form::select('organizationName', ['LIQUABit' => 'LIQUABit', 'Prototypes' => 'Prototypes'], null, ['placeholder' => '-- Select an Organization Name --', 'class' => 'form-control' ]) }}
        @if($errors->has('organizationName'))
        {{ $errors->first('organizationName') }} 
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
    {{ Form::label('Key Length: ', 'Key Length: ', ['class' => '']) }}
    {{ Form::select('keyLength', ['2048' => '2048', '4096' => '4096 - Not implemented'], null, ['placeholder' => '-- Select Key Length --', 'class' => 'form-control' ]) }}
        @if($errors->has('keyLength'))
        {{ $errors->first('keyLength') }} 
    @endif     
    <br />
    {{ Form::label('Validity Period: ', 'Validity Period: ', ['class' => '']) }}
    {{ Form::select('validityPeriod', ['365' => '1 Year', '730' => '2 Years', '1095' => '3 Years', '1460' => '4 Years', '1825' => '5 Years'], null, ['placeholder' => '-- Select Validity Period --', 'class' => 'form-control' ]) }}
        @if($errors->has('validityPeriod'))
        {{ $errors->first('validityPeriod') }} 
    @endif 
    <br />
    {{ Form::label('password: ', 'CA Password: ', ['class' => '']) }}
    {{ Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control' ]) }} 
        @if($errors->has('password'))
        {{ $errors->first('password') }} 
    @endif     
    <br />
    {{ Form::label('email: ', 'E-mail (Optional): [Not implemented yet]. Certificate Keypair will be send to this e-mail. Keep Private Key save.', ['class' => 'text-danger']) }}
    {{ Form::email('email', '', ['placeholder' => 'Example: alias@domain.tld', 'class' => 'form-control' ] ) }}
    @if($errors->has('email'))
        {{ $errors->first('email') }} 
    @endif
    <br />
    {{ Form::label('certMonitor: ', 'Certificate Monitor (Optional): [Not implemented yet]', ['class' => 'text-danger']) }}
    {{ Form::select('certMonitor', ['local' => 'Local Monitoring (certificate expiry notifications will be send by this CA)', 'online' => 'Online Monitoring (certificate expiry notifications will be handled by LIQUABit Online Service)'], null, ['class' => 'form-control' ]) }}
    @if($errors->has('certMonitor'))
        {{ $errors->first('certMonitor') }} 
    @endif
    <br />
    {{ Form::label('comments: ', 'Comments (Optional): ', ['class' => '']) }}
    {{ Form::textarea('comments', null, array('placeholder' => '', 'class' => 'form-control')) }}
    @if($errors->has('comments'))
        {{ $errors->first('comments') }}
    @endif
    <br />
    {{ Form::token() }}
    {{ Form::button('<i class="fa fa-cogs" aria-hidden="true"></i> Create New Certificate', ['class' => 'btn btn-success', 'type' => 'submit']) }}
    {{ Form::close() }} 
    <br />
</div>
</div>
@endsection
