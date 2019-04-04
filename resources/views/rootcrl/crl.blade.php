@extends('layouts.app')

@section('content')

<div class="container">
    <H2>Certificate Revocation List (CRL).</H2>
    <div class="container">
            <div class="btn-toolbar mb-3" role="toolbar">
                    <div class="btn-group mr-2" role="group">
                        <br />
                    <h5 class="">Update CRL</h5>
                    <td>
                            <br />
                    {{ Form::open(['url' => 'rootcrl/updateCRL', 'method' => 'post', 'class' => 'form']) }}
                    {{ Form::password('password', ['placeholder' => 'CA Password', 'class' => 'form-control' ]) }}
                    {{ Form::token() }}
                    {{ Form::submit('Update CRL', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                    </td>
                    </div>
                <br />
                    <div class="btn-group mr-2" role="group">
                    <h5 class="">Download CRL</h5>
                    <td>
                    {{ Form::open(['url' => 'rootcrl/getCRL', 'method' => 'post', 'class' => 'form']) }}
                    {{csrf_field()}}
                    {{ Form::token() }}
                    {{ Form::submit('Get CRL', ['class' => 'btn btn-secondary', 'type' => 'submit']) }}
                    {{ Form::close() }}
                    </td>
                <br />
                    </div>
                </div>
    <H3>Update CRL</H3>
    {{ Form::open(['url' => 'rootcrl/updateCRL', 'method' => 'POST', 'class' => 'form']) }}
        <div class="form-group">
            {{ Form::password('password', ['placeholder' => 'CA Password', 'class' => 'form-control' ]) }}
        </div>

        <div class="form-group">
            {{ Form::submit('Update CRL', ['class' => 'btn btn-primary']) }}
        </div>
        {{ Form::close() }}
    <H3>Download CRL</H3>
    {{ Form::open(['url' => 'rootcrl/getCRL', 'method' => 'POST', 'class' => 'form']) }}
        <div class="form-group">
            {{ Form::submit('Get CRL', ['class' => 'btn btn-primary']) }}
        </div>
        {{ Form::close() }}
    </div>

</div>

@endsection
