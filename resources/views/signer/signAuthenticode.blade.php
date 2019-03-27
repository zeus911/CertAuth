@extends('layouts.app')

@section('content')

<div class="container">
    <H2>Signature for {{ $archive_name }} has {{ $result }}.</H2>
    <div class="container">
        {{ Form::open(['url' => 'signer/getAuthenticode', 'method' => 'post']) }}
        <input type="hidden" name="archive_name" value="{{ $archive_name }}">
        {{ Form::token() }}
        {{ Form::submit('Get Signed Archive', ['class' => 'btn btn-primary btn-md']) }}
        {{ Form::close() }}
            
    </div>

@endsection