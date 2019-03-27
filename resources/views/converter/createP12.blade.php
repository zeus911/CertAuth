@extends('layouts.app')

@section('content')

<div class="container">

      <h2>You are going to create a PFX Archive for: {{ $subjectCommonName }}</h2>

    {{ Form::open(['url' => 'converter/storeP12', 'method' => 'post']) }}
    <input type="hidden" name="subjectCommonName" value="{{ $subjectCommonName }}">
    {{ Form::label('password: ', 'Passphrase: ', ['class' => '']) }}
    {{ Form::password('password', ['placeholder' => 'Passphrase', 'class' => 'form-control' ]) }}
        @if($errors->has('password'))
        {{ $errors->first('password') }} 
    @endif     
    <br />
    {{ Form::token() }}
    {{ Form::button('<i class="fa fa-cogs" aria-hidden="true"></i> Create & Get PFX(P12)', ['class' => 'btn btn-primary btn-md', 'type' => 'submit']) }}
    {{ Form::close() }}


</div>
@endsection
