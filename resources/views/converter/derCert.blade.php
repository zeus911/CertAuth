@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Certificate successfully converted to DER</h2>

    <p class="text-info">This certificate has been converted from PEM format to DER formats (*.crt, *.cer, *.der).</p>
    </br>
    {{ Form::open(['url' => 'converter/getDer', 'files' => 'true', 'method' => 'post']) }}
    {{ Form::token() }}
    {{ Form::submit('Download Certificate', ['class' => 'btn btn-success btn-md']) }}
    {{ Form::close() }}
	<br />
</div>
@endsection
