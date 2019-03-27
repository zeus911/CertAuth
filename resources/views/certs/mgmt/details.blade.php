@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Certificate Details</h2>
    <p>
    <div class="btn-toolbar mb-3" role="toolbar">
      <div class="btn-group mr-2" role="group">
      <td><!-- Complete Certificate Info -->
                        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#RawModal"><strong><i class="far fa-eye"></i> View Raw Certificate Information</strong></button>
                        <!-- View Modal -->
                        <div class="modal fade" id="RawModal" tabindex="-1" role="dialog" aria-labelledby="RawModalLabel" aria-hidden="true">
                          <div class="modal-dialog  modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="RawModalLabel">Raw Certificate Information. id: {{ $certs->id }} </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <pre>
subjectCommonName:<strong class="text-primary"> {{ $subjectCommonName }}</strong>
subjectContry:<strong class="text-primary"> {{ $certs->subjectContry }}</strong>
subjectState:<strong class="text-primary"> {{ $certs->subjectState }}</strong>
subjectLocality:<strong class="text-primary"> {{ $certs->subjectLocality }}</strong>
subjectOrganization:<strong class="text-primary"> {{ $certs->subjectOrganization }}</strong>
subjectOrganizationUnit:<strong class="text-primary"> {{ $certs->subjectOrganizationUnit }}</strong>
hash:<strong class="text-primary"> {{ $certs->hash }}</strong>
issuerCN:<strong class="text-primary"> {{ $certs->issuerCN }}</strong>
issuerContry:<strong class="text-primary"> {{ $certs->issuerContry }}</strong>
issuerState:<strong class="text-primary"> {{ $certs->issuerState }}</strong>
issuerLocality:<strong class="text-primary"> {{ $certs->issuerLocality }}</strong>
issuerOrganization:<strong class="text-primary"> {{ $certs->issuerOrganization }}</strong>
issuerOrganizationUnit:<strong class="text-primary"> {{ $certs->issuerOrganizationUnit }}</strong>
version:<strong class="text-primary"> {{ $certs->version }}</strong>
serialNumber:<strong class="text-primary"> {{ $certs->serialNumber }}</strong>
serialNumberHex:<strong class="text-primary"> {{ $certs->serialNumberHex }}</strong>
validFrom:<strong class="text-primary"> {{ $certs->validFrom }}</strong>
validTo:<strong class="text-primary"> {{ $certs->validTo }}</strong>
validFrom_time_t:<strong class="text-primary"> {{ $certs->validFrom_time_t }}</strong>
validTo_time_t:<strong class="text-primary"> {{ $certs->validTo_time_t }}</strong>
signatureTypeSN:<strong class="text-primary"> {{ $certs->signatureTypeSN }}</strong>
signatureTypeLN:<strong class="text-primary"> {{ $certs->signatureTypeLN }}</strong>
signatureTypeNID:<strong class="text-primary"> {{ $certs->signatureTypeNID }}</strong>
purposes:<strong class="text-primary"> {{ $certs->purposes[0] }}</strong>
extensionsBasicConstraints:<strong class="text-primary"> {{ $certs->extensionsBasicConstraints }}</strong>
extensionsNsCertType:<strong class="text-primary"> {{ $certs->extensionsNsCertType }}</strong>
extensionsKeyUsage:<strong class="text-primary"> {{ $certs->extensionsKeyUsage }}</strong>
extensionsExtendedKeyUsage:<strong class="text-primary"> {{ $certs->extensionsExtendedKeyUsage }}</strong>
extensionsSubjectKeyIdentifier:<strong class="text-primary"> {{ $certs->extensionsSubjectKeyIdentifier }}</strong>
extensionsAuthorityKeyIdentifier:<strong class="text-primary"> {{ $certs->extensionsAuthorityKeyIdentifier }}</strong>
extensionsSubjectAltName:<strong class="text-primary"> {{ $certs->extensionsSubjectAltName }}</strong>
extensionsCrlDistributionPoints:<strong class="text-primary"> {{ $certs->extensionsCrlDistributionPoints }}</strong>
certificateServerRequest:<strong class="text-primary"> {{ $certs->certificateServerRequest }}</strong>
publicKey:<strong class="text-primary"> {{ $certs->publicKey }}</strong>
privateKey:<strong class="text-primary"> {{ $certs->privateKey }}</strong>
status:<strong class="text-primary"> {{ $certs->status }}</strong>
expiryDate:<strong class="text-primary"> {{ $certs->expiryDate }}</strong>
comments:<strong class="text-primary"> {{ $certs->comments }}</strong>
timestamps:<strong class="text-primary"> {{ $certs->timestamps }}</strong>
                            </pre>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
               <!-- end certificate info -->
              </td>
        </div>
    <br />
    <br />
  <!-- end certificate info -->
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
                  <th><i class="fas fa-signature"></i> Issued by</th>
                    <td><strong class="text-primary"> {{ $issuerCN }} </strong></td> 
            </tr>
            <tr>
                  <th><i class="fas fa-calendar-alt"></i> Valid from</th>
                    <td><strong class="text-primary"> {{ $validFrom }} </strong></td>
            </tr>
            <tr>
                  <th><i class="fas fa-calendar-alt"></i> Expires on</th>
                    <td><strong class="text-primary"> {{ $validTo }}</strong><strong class="text-danger"> ( {{ $daysLeftToExpire }} days )</strong></td>
            </tr>

            <tr>
                  <th><i class="fas fa-calendar-alt"></i> Updated on</th>
                    <td><strong class="text-primary"> {{ $updated_at }}</strong></td>
            </tr>
            <tr>
                  <th><i class="fas fa-check-square"></i> Status</th>
                    <td><strong class="text-primary"> {{ $status }}</strong></td>
            </tr>

            <tr>
                  <th><i class="fas fa-signature"></i> Signature</th>
                   <td><strong class="text-primary">{{ $signatureTypeSN }}</strong></td>
            </tr>
            <tr>
                  <th><i class="fas fa-sort-numeric-up"></i> Serial</th>
                   <td><strong class="text-primary">{{ $serialNumber }} ( {{ $serialNumberHex }} )</strong></td>
            </tr>
            <tr>     
                  <th><i class="fas fa-key"></i> Key Usage</th>
                   <td><strong class="text-primary">{{ $extensionsKeyUsage }}</strong></td>
            </tr>
            <tr>
                  <th><i class="fas fa-key"></i> Extended Key Usage</th>
                   <td><strong class="text-primary">{{ $extensionsExtendedKeyUsage }}</strong></td>
            </tr>
            <tr>
                  <th><i class="fas fa-file-alt"></i> Certificate Server Request (CSR)</th>
                    <td><!-- CSR More Actions -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#CSRModal"><i class="far fa-eye"></i> View</button>
                        <!-- View Modal -->
                        <div class="modal fade" id="CSRModal" tabindex="-1" role="dialog" aria-labelledby="CSRModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="CSRModalLabel">Certicate Server Request (CSR)</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p>Copy & Paste</p>
                                  <pre>{{ $certificateServerRequest }}</pre>
                              </div>
                              <div class="modal-footer">
                              <!-- Button to Update CSR in DB -->
                                {{ Form::open(['url' => 'certs/mgmt/update', 'method' => 'post']) }}
                                {{csrf_field()}}
                                <input class="sr-only" type="text" name="subjectCommonName" value="{{ $subjectCommonName }}"> 
                                @if($errors->has('subjectCommonName'))
                                    {{ $errors->first('subjectCommonName') }} 
                                @endif
                              <!-- <br /> -->
                                {{ Form::token() }}
                                {{ Form::button('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update', ['class' => 'btn btn-outline-primary', 'type' => 'submit']) }}
                                {{ Form::close() }}
                              <!-- End Button to Update CSR in DB. -->
                              <!-- Button to download CSR to a file. -->
                                {{ Form::open(['url' => 'certs/mgmt/getCSR', 'method' => 'post']) }}
                                {{csrf_field()}}
                                <input class="sr-only" type="text" name="subjectCommonName" value="{{ $subjectCommonName }}"> 
                                @if($errors->has('subjectCommonName'))
                                    {{ $errors->first('subjectCommonName') }} 
                                @endif
                                {{ Form::token() }}
                                {{ Form::button('<i class="fa fa-download" aria-hidden="true"></i> Download', ['class' => 'btn btn-outline-primary', 'type' => 'submit']) }}
                                {{ Form::close() }}
                              <!-- End Button to download CSR to a file. -->
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- End View Modal -->
                  </div>
                </div>
              </td>
              </tr>
              <tr>
                  <th><i class="fas fa-certificate"></i> Certificate (Public Key)</th>
                  <td><!-- View Certificate -->
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#CERTModal"><i class="far fa-eye"></i> View</button>
                        <!-- View Modal -->
                        <div class="modal fade" id="CERTModal" tabindex="-1" role="dialog" aria-labelledby="CERTModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="CERTModalLabel">Certificate (Public Key)</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p>Copy & Paste</p>
                                  <pre>{{ $publicKey }}</pre>
                              </div>
                              <div class="modal-footer">
                              <!-- Button to Update PublicKey in DB -->
                                {{ Form::open(['url' => 'certs/mgmt/update', 'method' => 'post']) }}
                                {{csrf_field()}}
                                <input class="sr-only" type="text" name="subjectCommonName" value="{{ $subjectCommonName }}"> 
                                @if($errors->has('subjectCommonName'))
                                    {{ $errors->first('subjectCommonName') }} 
                                @endif
                              <!-- <br /> -->
                                {{ Form::token() }}
                                {{ Form::button('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update', ['class' => 'btn btn-outline-primary', 'type' => 'submit']) }}
                                {{ Form::close() }}
                              <!-- End Button to Update PublicKey in DB. -->
                              <!-- Button to download PublicKey to a file. -->
                                {{ Form::open(['url' => 'certs/mgmt/getPublicKey', 'method' => 'post']) }}
                                {{csrf_field()}}
                                <input class="sr-only" type="text" name="subjectCommonName" value="{{ $subjectCommonName }}"> 
                                @if($errors->has('subjectCommonName'))
                                    {{ $errors->first('subjectCommonName') }} 
                                @endif
                                {{ Form::token() }}
                                {{ Form::button('<i class="fa fa-download" aria-hidden="true"></i> Download', ['class' => 'btn btn-outline-primary', 'type' => 'submit']) }}
                                {{ Form::close() }}
                              <!-- End Button to download PublicKey to a file. -->
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- End View Modal -->
                  </div>
                </div>
              </td>
              </tr> 
              <tr>    
                  <th><i class="fas fa-key"></i> Private Key (.key)</th>
                  <td><!-- View Private Key -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#KEYModal"><i class="far fa-eye"></i> View</button>
                        <!-- View Modal -->
                        <div class="modal fade" id="KEYModal" tabindex="-1" role="dialog" aria-labelledby="KEYModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="KEYModalLabel">Certificate (Private Key)</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p>Copy & Paste</p>
                                  <pre>{{ $privateKey }}</pre>
                              </div>
                              <div class="modal-footer">
                              <!-- Button to Update PrivateKey in DB -->
                                {{ Form::open(['url' => 'certs/mgmt/update', 'method' => 'post']) }}
                                {{csrf_field()}}
                                <input class="sr-only" type="text" name="subjectCommonName" value="{{ $subjectCommonName }}"> 
                                @if($errors->has('subjectCommonName'))
                                    {{ $errors->first('subjectCommonName') }} 
                                @endif
                              <!-- <br /> -->
                                {{ Form::token() }}
                                {{ Form::button('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update', ['class' => 'btn btn-outline-primary', 'type' => 'submit']) }}
                                {{ Form::close() }}
                              <!-- End Button to Update PrivateKey in DB. -->
                              <!-- Button to download PrivateKey to a file. -->
                                {{ Form::open(['url' => 'certs/mgmt/getPrivateKey', 'method' => 'post']) }}
                                {{csrf_field()}}
                                <input class="sr-only" type="text" name="subjectCommonName" value="{{ $subjectCommonName }}"> 
                                @if($errors->has('subjectCommonName'))
                                    {{ $errors->first('subjectCommonName') }} 
                                @endif
                                {{ Form::token() }}
                                {{ Form::button('<i class="fa fa-download" aria-hidden="true"></i> Download', ['class' => 'btn btn-outline-primary', 'type' => 'submit']) }}
                                {{ Form::close() }}
                              <!-- End Button to download PrivateKey to a file. -->
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- End View Modal -->
                  </div>
                </div>
              </td>
              </tr>    
              <tr>  
                <th><i class="fas fa-archive"></i> Personal Information Exchange (P12/PFX)</th>
                <td><!-- View Personal Information Exchange -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#PFXModal"><i class="far fa-eye"></i> View</button>
                        <!-- View Modal -->
                        <div class="modal fade" id="PFXModal" tabindex="-1" role="dialog" aria-labelledby="PFXModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="PFXModalLabel">Personal Information Exchange(PFX)</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                  <pre><strong class="text-primary">{{ $hasPFX }}</strong></pre>
                              </div>
                              <div class="modal-footer">
                              <!-- Button to create new PFX. -->
                              {{ Form::open(['url' => 'converter/createP12', 'method' => 'post']) }}
                              {{csrf_field()}}
                              <input class="sr-only" type="text" name="subjectCommonName" value="{{ $subjectCommonName }}">
                              <input class="sr-only" type="text" name="publicKey" value="{{ $publicKey }}">
                              <input class="sr-only" type="text" name="privateKey" value="{{ $privateKey }}">
                              @if($errors->has('subjectCommonName'))
                                  {{ $errors->first('subjectCommonName') }} 
                              @endif
                              {{ Form::token() }}
                              {{ Form::button('<i class="fa fa-cogs" aria-hidden="true"></i> Create New', ['class' => 'btn btn-outline-primary', 'type' => 'submit']) }}
                              {{ Form::close() }}
                              <!-- Button to download PFX to a file. -->
                              {{ Form::open(['url' => 'certs/mgmt/getP12', 'method' => 'post']) }}
                              {{csrf_field()}}
                              <input class="sr-only" type="text" name="subjectCommonName" value="{{ $subjectCommonName }}"> 
                              @if($errors->has('subjectCommonName'))
                                  {{ $errors->first('subjectCommonName') }} 
                              @endif
                              {{ Form::token() }}
                              {{ Form::button('<i class="fa fa-download" aria-hidden="true"></i> Download', ['class' => 'btn btn-outline-primary', 'type' => 'submit']) }}
                              {{ Form::close() }}
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- End View Modal -->
                  </div>
                </div>
                </td>
                </tr>
             </thead>
            <tbody>
        </table>
        <div class="btn-toolbar mb-3" role="toolbar">
      <div class="btn-group mr-2" role="group">
              <td><!-- Key Matcher -->
                  {{ Form::open(['url' => 'certs/mgmt/keymatcher', 'method' => 'post']) }}
                  {{csrf_field()}}
                  <!--{{ Form::label('Common Name: ', 'Common Name: ', ['class' => '']) }}-->
                  <input type="hidden" name="subjectCommonName" value="{{ $subjectCommonName }}">
                  <input type="hidden" name="certificateServerRequest" value="{{ $certificateServerRequest }}">
                  <input type="hidden" name="publicKey" value="{{ $publicKey }}">
                  <input type="hidden" name="privateKey" value="{{ $privateKey }}">

                  @if($errors->has('subjectCommonName'))
                      {{ $errors->first('subjectCommonName') }} 
                  @endif
                  {{ Form::token() }}
                  {{ Form::button('<i class="fa fa-handshake-o" aria-hidden="true"></i> Key Matcher', ['class' => 'btn btn-primary', 'type' => 'submit']) }}
                  {{ Form::close() }}
              </td>
            </div>
            <div class="btn-group mr-2" role="group">
              <td><!-- Renew Certificate -->
                  {{ Form::open(['url' => 'certs/mgmt/renew', 'method' => 'post']) }}
                  {{csrf_field()}}
                  <!--{{ Form::label('Common Name: ', 'Common Name: ', ['class' => '']) }}-->
                  <input type="hidden" name="subjectCommonName" value="{{ $subjectCommonName }}">
                  @if($errors->has('subjectCommonName'))
                      {{ $errors->first('subjectCommonName') }} 
                  @endif
                  {{ Form::token() }}
                  {{ Form::button('<i class="fa fa-refresh" aria-hidden="true"></i> Renew Certificate', ['class' => 'btn btn-success', 'type' => 'submit']) }}
                  {{ Form::close() }}
                </td>
            </div>
            <div class="btn-group mr-2" role="group">
                <td><!-- Revoke Certificate -->
                  {{ Form::open(['url' => 'certs/mgmt/revoke', 'method' => 'post']) }}
                  {{csrf_field()}}
                  <!--{{ Form::label('Common Name: ', 'Common Name: ', ['class' => '']) }}-->
                  <input type="hidden" name="subjectCommonName" value="{{ $subjectCommonName }}">
                  @if($errors->has('subjectCommonName'))
                      {{ $errors->first('subjectCommonName') }} 
                  @endif
                  {{ Form::token() }}
                  {{ Form::button('<i class="fa fa-ban" aria-hidden="true"></i> Revoke Certificate', ['class' => 'btn btn-danger', 'type' => 'submit']) }}
                  {{ Form::close() }}
                </td>
            </div>
            <div class="btn-group mr-2" role="group">
                <td><!-- Delete table -->
                  {{ Form::open(['url' => 'certs/mgmt/delete', 'method' => 'post']) }}
                  {{csrf_field()}}
                  <!--{{ Form::label('Common Name: ', 'Common Name: ', ['class' => '']) }}-->
                  <input type="hidden" name="subjectCommonName" value="{{ $subjectCommonName }}">
                  @if($errors->has('subjectCommonName'))
                      {{ $errors->first('subjectCommonName') }} 
                  @endif
                  {{ Form::token() }}
                  {{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> Delete Certificate', ['class' => 'btn btn-danger', 'type' => 'submit']) }}
                  {{ Form::close() }}
                </td>
            </div>
          </div>
    <br />
    <br />
  <!-- end certificate info -->

      </div>
@endsection