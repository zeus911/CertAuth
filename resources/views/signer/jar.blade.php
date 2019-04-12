@extends('layouts.app')

@section('content')

<div class="container">
    <H2>Sign a Java Archive (JAR)</H2>
    <div class="container">

    {{ Form::open(['url' => 'signer/signJAR', 'method' => 'POST', 'class' => 'form', 'files' => true]) }}
        <div class="form-group">
            {{ Form::label('Select JAR Archive') }}
            {{ Form::file('jar', null, ['class' => 'form-control']) }}
      {{--  {{ Form::file('jar[]', null, ["class"=>"required","multiple"=>true]) }}  --}}
        </div>

        <div class="form-group">
            {{ Form::label('Password') }}
            {{ Form::password('password', ['placeholder' => 'Keystore Password', 'class' => 'form-control' ]) }}
        </div>


        <div class="form-group">
            {{ Form::token() }}
            {{ Form::submit('Sign JAR Archive', ['class' => 'btn btn-primary']) }}
        </div>
    {{ Form::close() }}
        </div>

    </div>

@endsection
