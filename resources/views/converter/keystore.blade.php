@extends('layouts.app')

@section('content')

<div class="container">
    <h2>You are going to create a Java Keystore (JKS).</h2>
    <p class="text-primary"><i class="far fa-eye"></i> Creating a Keystore requires a PFX(P12) archive.
    <a href="p12" class="btn btn-primary"><i class="fa fa-cogs" aria-hidden="true"></i> Create PFX(P12)</a></p>

    <div class="container">
        {{ Form::open(['url' => 'converter/createKeystore', 'method' => 'post', 'files' => true]) }}

        {{ Form::label('Select PFX(P12): ', 'Select PFX(P12): ') }}
        {{ Form::file('p12', null, ['class' => 'image']) }}
        @if($errors->has('p12'))
            {{ $errors->first('p12') }}
        @endif
        <br />
        </br>
        <!-- {{ Form::label('Source Archive Type: ', 'Source Archive Type: ') }} -->
        {{ Form::select('srcstoretype', ['PKCS12' => 'PKCS12', 'none' => 'More coming...'], null, ['placeholder' => 'Source Archive Type', 'class' => 'form-control' ]) }}
        @if($errors->has('srcstoretype'))
            {{ $errors->first('srcstoretype') }}
        @endif
        </br>
        <!-- {{ Form::label('PFX(P12) Passphrase: ', 'PFX(P12) Passphrase: ', ['class' => '']) }} -->
        <input type="password" class="form-control input-md" name="password" value="{{ (isset($input['password'])) ? e($input['password']) : '' }}" placeholder="  PFX(P12) Passphrase (Keystore will also have this Passphrase.)">
        @if($errors->has('password'))
            {{ $errors->first('password') }}
        @endif
        </br>
        <!-- {{ Form::label('Keystore Alias: ', 'Keystore Alias: ', ['class' => '']) }} -->
        <input type="text" class="form-control input-md" name="dstalias" value="{{ (isset($input['dstalias'])) ? e($input['dstalias']) : '' }}" placeholder="  Keystore Name (example: keystore)">
        @if($errors->has('dstalias'))
            {{ $errors->first('dstalias') }}
        @endif
        </br>
        {{ Form::button('<i class="fa fa-cogs" aria-hidden="true"></i> Create Keystore', ['class' => 'btn btn-success']) }}
        {{ Form::close() }}

    </div>

@endsection
