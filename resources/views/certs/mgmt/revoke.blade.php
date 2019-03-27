@extends('layouts.app')

@section('content')

<div class="container">
    <H2>You are about to revoke this certificate: <strong class="text-info">{{ $subjectCommonName }}</strong>.</H2>
    <div class="container">
        <h3>Reason (Optional):</h3> 
                {{ Form::open(['url' => 'certs/mgmt/revoked', 'method' => 'post']) }}
                <input type="hidden" name="subjectCommonName" value="{{ $subjectCommonName }}">
                  @if($errors->has('subjectCommonName'))
                  {{ $errors->first('subjectCommonName') }} 
                  @endif
                <input type="text" class="form-control input-md" name="reason" value="{{ (isset($input['reason'])) ? e($input['reason']) : '' }}" placeholder="Give a reason why you want to revoke this certificate. (Ex. Key compromise)">
                  @if($errors->has('reason'))
                  {{ $errors->first('reason') }} 
                  @endif
                  <br />
                <input type="password" class="form-control input-md" name="password" value="{{ (isset($input['password'])) ? e($input['password']) : '' }}" placeholder="Password">
                   @if($errors->has('password'))
                  {{ $errors->first('password') }} 
                  @endif 
                  <br />
                  <div class="btn-toolbar mb-3" role="toolbar">
                    <div class="btn-group mr-2" role="group">
                        <td>
                            {{ Form::token() }}
                            {{ Form::button('<i class="fa fa-ban" aria-hidden="true"></i> Revoke Certificate', ['class' => 'btn btn-danger', 'type' => 'submit']) }}
                            {{ Form::close() }}          
                        </td>
                    </div>
                    <br />
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