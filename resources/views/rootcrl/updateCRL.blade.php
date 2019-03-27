@extends('layouts.app')

@section('content')

<div class="container">
    <H2>CRL Updated. {{ $result }}</H2>
</div>
<div class="container">
    {{ Form::open(['url' => 'rootcrl/getCRL', 'method' => 'POST', 'class' => 'form']) }}
        <div class="form-group">
            {{ Form::submit('Get TRAGSA CA G2 CRL', ['class' => 'btn btn-primary btn-md']) }}
        </div>
        {{ Form::close() }}
    </div>

</div>

@endsection