@extends('layouts.app')

@section('content')

<div class="container">
    <H2>Certificate Key Matcher</H2>
    <H5 class='text-primary'><strong>Check whether a private key matches a certificate and/or whether a certificate matches a certificate signing request (CSR).</strong></H5>
    <br />
    <div class="container">
        <table class="table table-striped table-bordered" cellspacing="0" nowrap>
            <thead>
            <tr>
                  <th><i class="fa fa-handshake-o" aria-hidden="true"></i> Private Key Matches Certificate</th>
                    <td><strong class="text-primary"> {{ $keyMatchesCert }} </strong></td>
            </tr>
            <tr>
                  <th><i class="fa fa-handshake-o" aria-hidden="true"></i> Certificate Matches CSR</th>
                    <td><strong class="text-primary"> {{ $certMatchesCSR }} </strong></td>
            </tr>
            <tr>
                <th><i class="fas fa-file-alt"></i> CSR</th>
                  <td><strong class="text-primary"> {{ $csr_status }} </strong></td>
            </tr>
            <tr>
                <th><i class="fas fa-certificate"></i> Certificate</th>
                  <td><strong class="text-primary"> {{ $cert_status }} </strong></td>
            </tr>
            <tr>
                <th><i class="fas fa-key"></i> PrivateKey</th>
                  <td><strong class="text-primary"> {{ $key_status }} </strong></td>
            </tr>
            </thead>
        </table>
    </div>
    <br />
    {{ Form::open(['url' => 'certs/mgmt', 'files' => 'true', 'method' => 'GET']) }}
    {{ Form::token() }}
    {{ Form::submit('Go back to Managemnet', ['class' => 'btn btn-secondary']) }}
    {{ Form::close() }}
    <br />
</div>
@endsection