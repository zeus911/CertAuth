@extends('layouts.app')

@section('content')

<div class="container">
    <H2>CRL Updated. {{ $result }}</H2> // Debug output message...
</div>
<div class="container">
    {{ Form::open(['url' => 'rootcrl/getCRL', 'method' => 'POST', 'class' => 'form']) }}
        <div class="form-group">
            {{ Form::submit('Get CRL', ['class' => 'btn btn-primary']) }}
        </div>
        {{ Form::close() }}
    </div>

</div>

@endsection
