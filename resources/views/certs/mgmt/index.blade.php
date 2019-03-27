@extends('layouts.app')
@section('content') 

<div class="container">

    <h2>Certificates Management</h2>
    <h5 class="text-primary"><strong>Total Nº of Certificates:</strong> <strong class="text-success">{{ $certsNumber }} </strong></h5>

        <table width="100%" class="table table-striped table-bordered" id="dashboard" cellspacing="0" nowrap>
                <thead>
                    <tr>
                    <!-- <th>ID</th> -->
                    <th>Common Name</th>
                    <th>Certificate Type</th>
                    <th>Expires in (Days)</th>
                    <th>Status</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
            @foreach ($certs as $cert)
                    <tr class="text-primary">
                    <!-- <td><strong>{{ $cert->id }}</strong></td> -->
                    <td><strong>{{ $cert->subjectCommonName }}</strong></td>
                    <td><strong>{{ $cert->extensionsExtendedKeyUsage }}</strong></td>
                    <td><strong>{{ $cert->expiryDate }}</strong></td>
                    <td><strong>{{ $cert->status }}</strong></td>
                    <td>
                        {{ Form::open(['url' => 'certs/mgmt/details/', 'method' => 'post']) }}
                        {{csrf_field()}}
                        <input class="sr-only" type="text" name="subjectCommonName" value="{{ $cert->subjectCommonName }}"> 
                        @if($errors->has('subjectCommonName'))
                            {{ $errors->first('subjectCommonName') }} 
                        @endif
                        {{ Form::token() }}
                        {{ Form::button('<i class="fa fa-plus" aria-hidden="true"></i> More Details', ['class' => 'btn btn-primary', 'type' => 'submit']) }}
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach

                </tbody>
        </table>
        <br />
        <div class="btn-toolbar mb-3" role="toolbar">
            <div class="btn-group mr-2" role="group">
            <td>
            {{ Form::open(['url' => 'certs/mgmt/exportCSV/', 'method' => 'post']) }}
            {{ Form::token() }}
            {{ Form::submit('Export to CSV', ['class' => 'btn btn-primary']) }}
            {{ Form::close() }}
            </td>
            </div>
        <br />
            <div class="btn-group mr-2" role="group">
            <td>
            {{ Form::open(['url' => 'certs/mgmt/import/', 'method' => 'post']) }}
            {{csrf_field()}}
            {{ Form::token() }}
            {{ Form::submit('Import Certificate', ['class' => 'btn btn-secondary', 'type' => 'submit']) }}
            {{ Form::close() }}
            </td>
        <br />
        </div>
    </div>
</div>
@endsection
