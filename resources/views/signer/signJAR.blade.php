@extends('layouts.app')

@section('content')

<div class="container">
    <H2>Your archive {{ $jarName }} has been:</H2>
    <H3 class="">{{ $result }}</H3>
    <div class="container">
        {{ Form::open(['url' => 'signer/getJAR', 'method' => 'post']) }}
        <input type="hidden" name="jarName" value="{{ $jarName }}">
        {{ Form::token() }}
        {{ Form::submit('Get Signed JAR', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}

    </div>

@endsection
