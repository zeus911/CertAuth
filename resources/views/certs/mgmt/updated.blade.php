@extends('layouts.app')

@section('content')

<div class="container">

      <h2 class="">You have updated the CSR/Certificate OR Private Key of:<strong class="text-success"> {{ $subjectCommonName }}</strong>.</h2>
      <br />
      {{ Form::open(['url' => 'certs/mgmt', 'files' => 'true', 'method' => 'get']) }}
      {{ Form::token() }}
      {{ Form::submit('Go back to Managemnet', ['class' => 'btn btn-secondary']) }}
      {{ Form::close() }}
      <br />
</div>
@endsection

