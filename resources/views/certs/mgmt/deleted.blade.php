@extends('layouts.app')

@section('content')

<div class="container">
      
      <h2><strong class="text-primary">{{ $subjectCommonName }}</strong><strong class="text-success"> successfully deleted</strong></h2>
      <br />
      {{ Form::open(['url' => 'certs/mgmt', 'files' => 'true', 'method' => 'get']) }}
      {{ Form::token() }}
      {{ Form::submit('Go back to Managemnet', ['class' => 'btn btn-secondary']) }}
      {{ Form::close() }}
      <br />
</div>
@endsection
