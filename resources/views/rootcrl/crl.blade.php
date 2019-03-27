@extends('layouts.app')

@section('content')

<div class="container">
    <H2>Certificate Revocation List (CRL).</H2>
    <div class="container">
    <H3>Update CRL</H3>
    {{ Form::open(['url' => 'rootcrl/updateCRL', 'method' => 'POST', 'class' => 'form']) }}
        <div class="form-group">
            {{ Form::password('password', ['placeholder' => 'CA Password', 'class' => 'form-control' ]) }}
        </div>

        <div class="form-group">
            {{ Form::submit('Update TRAGSA CA G2 CRL', ['class' => 'btn btn-primary btn-md']) }}
        </div>
        {{ Form::close() }}
    <H3>Download CRL</H3>
    {{ Form::open(['url' => 'rootcrl/getCRL', 'method' => 'POST', 'class' => 'form']) }}
        <div class="form-group">
            {{ Form::submit('Get TRAGSA CA G2 CRL', ['class' => 'btn btn-primary btn-md']) }}
        </div>
        {{ Form::close() }}
    </div>

</div>

@endsection