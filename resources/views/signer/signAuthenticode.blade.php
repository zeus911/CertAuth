@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Signature for {{ $archive_name }} has:<h2>
        <div class="alert alert-light" role="alert">
            {{ $result }}
        </div>
                <div class="container">
        {{ Form::open(['url' => 'signer/getAuthenticode', 'method' => 'post']) }}
        <input type="hidden" name="archive_name" value="{{ $archive_name }}">
        {{ Form::token() }}
        {{ Form::submit('Get Signed Archive', ['class' => 'btn btn-primary btn-md']) }}
        {{ Form::close() }}

    </div>

@endsection
