@extends('layouts.app')

@section('content')

<div class="container">

    <H2>Certificate Revocation Details</H2>
    <h5>Common Name: <strong class="text-primary">{{ $subjectCommonName}}</strong></h5>
    <h5>Issuer: <strong class="text-primary">{{ $issuerCN }}</strong></h4>
    <h5>Status: <strong class="text-danger">{{ $status2 }}</strong></h5>

            <div class="container">
                    <!-- cert summary -->
                    <table class="table table-striped table-bordered" cellspacing="0" nowrap>
                         <thead>
                            <tr>
                                <th><i class="fas fa-certificate"></i> Serial Number</th>
                                    <td><strong class="text-primary"> {{ $serialNumber }} </strong></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-file-signature"></i> Date Issued</th>
                                    <td><strong class="text-primary"> {{ $validFrom }} </strong></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-file-signature"></i> Expiration date</th>
                                    <td><strong class="text-primary"> {{ $validTo }} </strong></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-signature"></i> Revoked date (UTC)</th>
                                <td><strong class="text-primary"> {{ $updated_at }} </strong></td>
                            </tr>
                                <th><i class="fas fa-database"></i> DB Status</th>
                                <td><strong class="text-success"> {{ $status }} </strong></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-sort-numeric-up"></i> Reason</th>
                                <td><strong class="text-primary"> {{ $reason }} </strong></td>
                            </tr>
                         </thead>
                     </table>
                 </div>
               <br />
                 <!-- end cert summary -->
                 <div class="btn-toolbar mb-3" role="toolbar">
                        <div class="btn-group mr-2" role="group">
                            <td>
                                {{ Form::open(['url' => 'certs/mgmt/', 'files' => 'true', 'method' => 'get']) }}
                                {{ Form::token() }}
                                {{ Form::submit('Go back to management', ['class' => 'btn btn-secondary']) }}
                                {{ Form::close() }}
                            </td>
                        </div>
                 </div>
            </div>

        </div>
</div>
@endsection
