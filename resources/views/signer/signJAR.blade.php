@extends('layouts.app')

@section('content')

<div class="container">
    <H2>Your archive {{ $jar_name }} has been:</H2>
    <H3 class="text-info">{{ $result }}</H3>
    <div class="container">
        {{ Form::open(['url' => 'signer/getJAR', 'method' => 'post']) }}
        <input type="hidden" name="jar_name" value="{{ $jar_name }}">
        {{ Form::token() }}
        {{ Form::submit('Get Signed JAR', ['class' => 'btn btn-primary btn-md']) }}
        {{ Form::close() }}
            
    </div>

@endsection