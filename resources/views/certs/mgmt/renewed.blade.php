@extends('layouts.app')

@section('content')

<div class="container">

    <H2>Certificate Renewal for: <strong class="text-success">{{ $subjectCommonName }}</strong> </H2>
 
    <div class="container">
        {{ Form::open(['url' => 'certs/mgmt/getRenewed', 'files' => 'true', 'method' => 'post']) }}
        <input type="hidden" name="subjectCommonName" value="{{ $subjectCommonName }}">
        {{ Form::label('Validity Period: ', 'Validity Period: ', ['class' => '']) }}
        {{ Form::select('validityPeriod', ['365' => '1 Year', '730' => '2 Years', '1095' => '3 Years', '1460' => '4 Years', '1825' => '5 Years'], null, ['placeholder' => '-- Select Validity Period --', 'class' => 'form-control' ]) }}
            @if($errors->has('validityPeriod'))
            {{ $errors->first('validityPeriod') }} 
        @endif 
        <br />
        {{-- {{ Form::label('password', 'Password', ['class' => '']) }} --}}
        {{ Form::password('password', ['placeholder' => 'CA Password', 'class' => 'form-control']) }}
            @if($errors->has('password'))
            {{ $errors->first('password') }}
            @endif
        <br />  
        <div class="btn-toolbar mb-3" role="toolbar">
            <div class="btn-group mr-2" role="group">
                <td>
                    {{ Form::token() }}
                    {{ Form::button('<i class="fa fa-refresh" aria-hidden="true"></i> Renew Certificate', ['class' => 'btn btn-primary', 'type' => 'submit']) }}
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
</div>
@endsection