@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Certificate successfully converted to PEM</h2>

    <p class="text-info">This certificate has been converted from DER format to PEM formats (*.pem).</p>
    </br>
    {{ Form::open(['url' => 'converter/getPEM', 'files' => 'true', 'method' => 'post']) }}
    {{ Form::token() }}
    {{ Form::submit('Download Certificate', ['class' => 'btn btn-success btn-md']) }}
    {{ Form::close() }}
    <br />
</div>
@endsection
