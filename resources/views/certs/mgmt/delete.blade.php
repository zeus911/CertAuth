@extends('layouts.app')

@section('content')


<div class="container">  
    <h2 class=""><strong>Do you really want to delete</strong><strong class="text-primary"> {{ $subjectCommonName }}</strong><strong> certificate?</strong></h2>
    <br />
    <div class="btn-toolbar mb-3" role="toolbar">
        <div class="btn-group mr-2" role="group">
            <td>
                {{ Form::open(['url' => 'certs/mgmt/deleted', 'files' => 'true', 'method' => 'post']) }}
                <input class="d-sm-none" type="text" name="subjectCommonName" value="{{ $subjectCommonName }}">
                {{ Form::token() }}
                {{ Form::submit('Yes, delete certificate', ['class' => 'btn btn-danger']) }}
                {{ Form::close() }}
            </td>
        </div>
        <div class="btn-group mr-2" role="group">
            <td>
                {{ Form::open(['url' => 'certs/mgmt/', 'files' => 'true', 'method' => 'get']) }}
                {{ Form::token() }}
                {{ Form::submit('No, go back to management', ['class' => 'btn btn-secondary']) }}
                {{ Form::close() }}
            </td>
        </div>
    </div>
</div>
@endsection
