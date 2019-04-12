@extends('layouts.app')

@section('content')

<div class="container">
    <H2>Sign a Microsoft Archive.</H2>
    <div class="container">
    <br />
    {{ Form::open(['url' => 'signer/signAuthenticode', 'method' => 'POST', 'class' => 'form', 'files' => true]) }}
		<div class="form-group">
		    {{--  {{ Form::label('Select Microsoft Archive') }}  --}}
		    {{ Form::file('archive', null) }}
		</div>
		<div class="form-group">
			{{--  {{ Form::label('Archive Type: ', 'Archive Type: ', ['class' => '']) }}  --}}
        	{{ Form::select('archive_type', ['.msi' => 'MSI', '.exe' => 'EXE', '.dll' => 'DLL', '.cab' => 'CAB'], null, ['placeholder' => 'Microsoft Archive Type', 'class' => 'form-control' ]) }}
        	@if($errors->has('archive_type'))
            {{ $errors->first('archive_type') }}
        	@endif
        <div>
        <div class="form-group">
            {{--  {{ Form::label('Password') }}  --}}
            {{ Form::password('password', ['placeholder' => 'Keystore Password', 'class' => 'form-control' ]) }}
        </div>

		<div class="form-group">
	        {{ Form::token() }}
		    {{ Form::submit('Sign MS Archive', ['class' => 'btn btn-primary btn-md']) }}
		</div>
	{{ Form::close() }}
		</div>

    </div>

@endsection
