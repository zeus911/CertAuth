@extends('layouts.app')

@section('content')

<div class="container">
    <H2>Certificate Revocation List (CRL).</H2>
    <div class="container">
    <h5 class="text-primary">Update CRL</h5>
    {{ Form::open(['url' => 'rootcrl/updateCRL', 'method' => 'POST', 'class' => 'form']) }}
        <div class="form-group">
            {{ Form::password('password', ['placeholder' => 'CA Password', 'class' => 'form-control' ]) }}
        </div>

        <div class="form-group">
            {{ Form::submit('Update CRL', ['class' => 'btn btn-primary']) }}
        </div>
        {{ Form::close() }}
    <h5 class="text-primary">Download CRL</h5>
    {{ Form::open(['url' => 'rootcrl/getCRL', 'method' => 'POST', 'class' => 'form']) }}
        <div class="form-group">
            {{ Form::submit('Get CRL', ['class' => 'btn btn-primary']) }}
        </div>
        {{ Form::close() }}
    </div>

</div>

@endsection
