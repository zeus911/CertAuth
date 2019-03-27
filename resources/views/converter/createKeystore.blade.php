@extends('layouts.app')

@section('content')

<div class="container">
    <H2>You have created a Java Keystore ({{ $dstalias }}).</H2>
    <H3 class="text-info">{{ $result }}</H3>
    <div class="container">
        {{ Form::open(['url' => 'converter/getKeystore', 'method' => 'post']) }}
        <input type="hidden" name="dstalias" value="{{ $dstalias }}">
        {{ Form::token() }}
        {{ Form::submit('Get Keystore', ['class' => 'btn btn-primary btn-md']) }}
        {{ Form::close() }}
            
    </div>

@endsection