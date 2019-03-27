@extends('layouts.app')
@section('content') 
<div class="container">

      	<h2>CSR Details</h2>
        <h5 class="text-primary"><strong>Check summary before generating Keypair</strong></h5>
          <div class="container">
              <table class="table table-striped table-bordered" cellspacing="0" nowrap>
                  <thead>
                  <tr>
                        <th><i class="fas fa-certificate"></i> Common Name</th>
                          <td><strong class="text-primary"> {{ $subjectCommonName }} </strong></td>
                  </tr>
                  <tr>
                        <th><i class="fas fa-file-signature"></i> Subject Alternative Name</th>
                          <td><strong class="text-primary"> {{ $extensionsSubjectAltName }} </strong></td>
                  </tr>
                  <tr>
                      <th><i class="fas fa-file-signature"></i> Organization</th>
                        <td><strong class="text-primary"> {{ $subjectOrganization }} </strong></td>
                  </tr>
                  <tr>
                      <th><i class="fas fa-file-signature"></i> Key Usage</th>
                        <td><strong class="text-primary"> {{ $extensionsExtendedKeyUsage }} </strong></td>
                  </tr>
                  <tr>
                      <th><i class="fas fa-file-signature"></i> Signature Type</th>
                        <td><strong class="text-primary"> {{ $signatureTypeSN }} </strong></td>
                  </tr>
                  <tr>
                        <th><i class="fas fa-signature"></i> E-Mail</th>
                          <td><strong class="text-primary"> {{ $emailAddress }} </strong></td> 
                  </tr>
                  </thead>
              </table>
          </div>
        <br />
    <div class="container">
        <div class="btn-toolbar mb-3" role="toolbar">
          <div class="btn-group mr-2" role="group">
            <td>
        {{ Form::open(['url' => 'csr/getCSR', 'method' => 'post']) }}
        <input type="hidden" name="subjectCommonName" value="{{ $subjectCommonName }}">
        <input type="hidden" name="certificateServerRequest" value="{{ $certificateServerRequest }}">
        <input type="hidden" name="extensionsSubjectAltName" value="{{ $extensionsSubjectAltName }}">
        <input type="hidden" name="subjectOrganization" value="{{ $subjectOrganization }}">
        <input type="hidden" name="extensionsExtendedKeyUsage" value="{{ $extensionsExtendedKeyUsage }}">
        <input type="hidden" name="signatureTypeSN" value="{{ $signatureTypeSN }}">
        <input type="hidden" name="privateKey" value="{{ $privateKey }}">
        <input type="hidden" name="emailAddress" value="{{ $emailAddress }}">

        
        {{ form::token() }}
        {{ Form::button('<i class="fa fa-download" aria-hidden="true"></i> Donwload CSR & Key', ['class' =>'btn btn-primary', 'type' => 'submit']) }}
        {{ Form::close() }}
            </td>
          </div>
          <div class="btn-group mr-2" role="group">
            <td>
                <button type="submit" class="btn btn-link"><a href="https://ssldecoder.liquabit.com/" target="_blank"><strong><i class="fa fa-external-link-alt" aria-hidden="true"></i> Prototypes SSL Decoder Tools</strong></a></button>
            </td>
          </div>
          <div class="btn-group mr-2" role="group">
            <td>
                <button type="submit" class="btn btn-link"><a href="https://ssltools.digicert.com/checker/views/csrCheck.jsp" target="_blank"><strong><i class="fa fa-external-link-alt" aria-hidden="true"></i> DigiCert Check CSR</strong></a></button>
            </td>
         </div>
      </div>
   </div>
</div>
@endsection    

