@extends('layouts.app')
@section('content') 

<div class="container">

	  <h2>Search</h2>      		
    {{ Form::open(['url' => 'signer/results/', 'method' => 'post']) }}
    {{csrf_field()}}
    <!--{{ Form::label('Common Name: ', 'Common Name: ', ['class' => '']) }}-->
    <input class="form-control" type="text" name="name" value="{{ (isset($input['name'])) ? e($input['name']) : '' }}" placeholder="Search by full name, including extension.">
    @if($errors->has('name'))
        {{ $errors->first('name') }} 
    @endif
    <br />
    {{ Form::token() }}
    {{ Form::submit('Search', ['class' => 'btn btn-primary btn-md']) }}
    {{ Form::close() }}

    </br>
            <table id="dashboard" class="table table-bordered table-condensed table-responsive" cellspacing="0" width="100%">
            <thead>
                <tr>
                  <th>Archive Name</th>
                  <th>Signed by</th>
                  <th>TimeStamp Autority</th>
                  <th>Created on</th>
                  <th>Updated</th>
                  <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                  <td>{{ $archives }}</td>
                  <td>signed_by</td>
                  <td>timestamp</td>
                  <td>$cert->created_at</td>
                  <td>$cert->updated_at</td>
                  <td>
                    {{ Form::open(['url' => 'signed/result/', 'method' => 'post']) }}
                    {{csrf_field()}}
                    <input class="hidden" type="text" name="name" value="$name"> 
                    @if($errors->has('name'))
                        {{ $errors->first('name') }} 
                    @endif
                    <br />
                    {{ Form::token() }}
                    {{ Form::submit('Get Archive', ['class' => 'btn btn-success btn-md']) }}
                    {{ Form::close() }}
                  </td>             
              </tr>
            </tbody>
        </table>
    </br>

</div>

@endsection
