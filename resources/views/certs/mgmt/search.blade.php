@extends('layouts.app')

@section('content')

<div class="container">
    <H2>Certificate Details for: <strong>{{ $cn }}</strong></H2>
    <H4 class="text-info"><strong>Subject Alternative Name(s): {{ $san }}</strong></H4>

    <H3> Issued by: <strong>{{ $issuerCN }}</strong></H3>
    <p class="text-info"><strong><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Valid from: {{ $validFrom }}</strong></p>
    <p class="text-info"><strong><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Expires on: {{ $validTo }}</strong>
    <p class="text-info"><strong><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Updated on: {{ $updated_at }}</strong></p>
    <p class="text-info"><strong><i class="fa fa-check" aria-hidden="true"></i> Status: {{ $status }}</strong></p>

  <div class="bs-callout bs-callout-primary">   
    <div class="container-fluid">
        <table class="table">
            <thead>
            <tr>
                  <th>Signature</th>
                  <th>Serial</th>
                  <th>Key Usage</th>
                  <th>Extended Key Usage</th>
                  <th>Request</th>
                  <th>Certificate</th>
                  <th>Private Key</th>
                  <th>PFX</th>
            </tr>
            </thead>
            <tbody>
            <tr class="text-info">

                  <td><strong>{{ $signatureTypeSN }}</strong></td>
                  <td><strong>{{ $serialNumber }} ( {{ $serialNumberHex }} )</strong></td>
                  <td><strong>{{ $keyUsage }}</strong></td>
                  <td><strong>{{ $extendedKeyUsage }}</strong></td>
                  <td><!-- View CSR -->
                  <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal1"><i class="fa fa-eye" aria-hidden="true"></i> View</button>

                    <div id="myModal1" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Certicate Server Request (CSR)</h4>
                          </div>
                          <div class="modal-body">
                            <p>Copy &amp Paste.</p>
                            <pre>{{ $csrprint }}</pre>
                          </div>
                          <div class="modal-footer button-group">
  
                              <!-- // Button to Update CSR in DB. // -->
                              {{ Form::open(['url' => 'certs/mgmt/update', 'method' => 'post']) }}
                              {{csrf_field()}}
                              <input class="hidden" type="text" name="cn" value="{{ $cn }}"> 
                              @if($errors->has('cn'))
                                  {{ $errors->first('cn') }} 
                              @endif
                              <br />
                              {{ Form::token() }}
                              {{ Form::button('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update CSR', ['class' => 'btn btn-primary btn-md', 'type' => 'submit']) }}
                              {{ Form::close() }}
                              <!-- // End Button to Update in DB. // -->
  
                              <!-- // Button to download CSR to a file. // -->
                              {{ Form::open(['url' => 'certs/mgmt/getCSR', 'method' => 'post']) }}
                              {{csrf_field()}}
                              <input class="hidden" type="text" name="cn" value="{{ $cn }}"> 
                              @if($errors->has('cn'))
                                  {{ $errors->first('cn') }} 
                              @endif
                              <br />
                              {{ Form::token() }}
                              {{ Form::button('<i class="fa fa-download" aria-hidden="true"></i> Get CSR', ['class' => 'btn btn-primary btn-md', 'type' => 'submit']) }}
                              {{ Form::close() }}
                              </br>
                              <!-- // End Button to download CSR to a file. // -->
                            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                          </div>
                        </div>

                      </div>
                    </div>
                  </td>
                  <td><!-- View Certificate -->
                  <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal2"><i class="fa fa-eye" aria-hidden="true"></i> View</button>

                    <div id="myModal2" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Certificate (Public Key)</h4>
                          </div>
                          <div class="modal-body">
                            <p>Copy &amp Paste.</p>
                            <pre>{{ $certprint }}</pre>
                          </div>
                          <div class="modal-footer">
                              <!-- // Button to Update CSR in DB. // -->
                              {{ Form::open(['url' => 'certs/mgmt/update', 'method' => 'post']) }}
                              {{csrf_field()}}
                              <input class="hidden" type="text" name="cn" value="{{ $cn }}"> 
                              @if($errors->has('cn'))
                                  {{ $errors->first('cn') }} 
                              @endif
                              <br />
                              {{ Form::token() }}
                              {{ Form::button('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update PublicKey', ['class' => 'btn btn-primary btn-md', 'type' => 'submit']) }}
                              {{ Form::close() }}
                              <!-- // End Button to Update in DB. // -->
  
                              <!-- // Button to download CSR to a file. // -->
                              {{ Form::open(['url' => 'certs/mgmt/getPublicKey', 'method' => 'post']) }}
                              {{csrf_field()}}
                              <input class="hidden" type="text" name="cn" value="{{ $cn }}"> 
                              @if($errors->has('cn'))
                                  {{ $errors->first('cn') }} 
                              @endif
                              <br />
                              {{ Form::token() }}
                              {{ Form::button('<i class="fa fa-download" aria-hidden="true"></i> Get Public Key', ['class' => 'btn btn-primary btn-md', 'type' => 'submit']) }}
                              {{ Form::close() }}
                              </br>
                              <!-- // End Button to download CSR to a file. // -->

                            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                          </div>
                        </div>

                      </div>
                    </div>
                  </td>
                  <td><!-- View Private Key -->
                  <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal3"><i class="fa fa-eye" aria-hidden="true"></i> View</button>

                    <div id="myModal3" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Certificate (Private Key)</h4>
                          </div>
                          <div class="modal-body">
                            <p>Copy &amp Paste.</p>
                            <pre>{{ $keyprint }}</pre>
                          </div>
                          <div class="modal-footer">
                              <!-- // Button to Update CSR in DB. // -->
                              {{ Form::open(['url' => 'certs/mgmt/update', 'method' => 'post']) }}
                              {{csrf_field()}}
                              <input class="hidden" type="text" name="cn" value="{{ $cn }}"> 
                              @if($errors->has('cn'))
                                  {{ $errors->first('cn') }} 
                              @endif
                              <br />
                              {{ Form::token() }}
                              {{ Form::button('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update Private Key', ['class' => 'btn btn-primary btn-md', 'type' => 'submit']) }}
                              {{ Form::close() }}
                              <!-- // End Button to Update in DB. // -->
  
                              <!-- // Button to download CSR to a file. // -->
                              {{ Form::open(['url' => 'certs/mgmt/getPrivateKey', 'method' => 'post']) }}
                              {{csrf_field()}}
                              <input class="hidden" type="text" name="cn" value="{{ $cn }}"> 
                              @if($errors->has('cn'))
                                  {{ $errors->first('cn') }} 
                              @endif
                              <br />
                              {{ Form::token() }}
                              {{ Form::button('<i class="fa fa-download" aria-hidden="true"></i> Get Private Key', ['class' => 'btn btn-primary btn-md', 'type' => 'submit']) }}
                              {{ Form::close() }}
                              </br>
                              <!-- // End Button to download CSR to a file. // -->

                            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                          </div>
                        </div>

                      </div>
                    </div>
                  </td>
                  <td><!-- Show if PFX archive has been generated -->
                  <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal4"><i class="fa fa-eye" aria-hidden="true"></i> View</button>
                    <div id="myModal4" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Personal Information Exchange(PFX)</h4>
                          </div>
                          <div class="modal-body">
                            <p class='text-primary'><strong>{{ $hasPFX }}</strong></p>
                          </div>
                          <div class="modal-footer">
                              <!-- // Button to crete new PFX. // -->
                              {{ Form::open(['url' => 'converter/createP12', 'method' => 'post']) }}
                              {{csrf_field()}}
                              <input class="hidden" type="text" name="cn" value="{{ $cn }}">
                              <input class="hidden" type="text" name="certprint" value="{{ $certprint }}">
                              <input class="hidden" type="text" name="keyprint" value="{{ $keyprint }}">
                              @if($errors->has('certprint'))
                                  {{ $errors->first('certprint') }} 
                              @endif
                              <br />
                              {{ Form::token() }}
                              {{ Form::button('<i class="fa fa-cogs" aria-hidden="true"></i> Create PFX(P12)', ['class' => 'btn btn-primary btn-md', 'type' => 'submit']) }}
                              {{ Form::close() }}
                              <!-- // End Button to Update in DB. // --> 
  
                              <!-- // Button to download PFX to a file. // -->
                              {{ Form::open(['url' => 'certs/mgmt/getP12', 'method' => 'post']) }}
                              {{csrf_field()}}
                              <input class="hidden" type="text" name="cn" value="{{ $cn }}"> 
                              @if($errors->has('cn'))
                                  {{ $errors->first('cn') }} 
                              @endif
                              <br />
                              {{ Form::token() }}
                              {{ Form::button('<i class="fa fa-download" aria-hidden="true"></i> Get PFX(P12)', ['class' => 'btn btn-primary btn-md', 'type' => 'submit']) }}
                              {{ Form::close() }}
                              </br>
                              <!-- // End Button to download CSR to a file. // -->

                            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                          </div>
                        </div>

                      </div>
                    </div>
                  </td>
</td>
            </tr>
            
            </tbody>
        </table>
      </div>
      <div class="container-fluid">
        <table class="table">
            <thead>
            <tr>
                  <th></th>
                  <th></th>
                  <th></th>
              </tr>
             </thead>
            <tbody>
            <tr>
                 <td><!-- Get Archive PFX(P12) -->
                  {{ Form::open(['url' => 'certs/mgmt/getP12', 'method' => 'post']) }}
                  {{csrf_field()}}
                  <!--{{ Form::label('Common Name: ', 'Common Name: ', ['class' => '']) }}-->
                  <input type="hidden" name="cn" value="{{ $cn }}">
                  @if($errors->has('cn'))
                      {{ $errors->first('cn') }} 
                  @endif
                  {{ Form::token() }}
                  {{ Form::button('<i class="fa fa-download" aria-hidden="true"></i> Get PFX(P12)', ['class' => 'btn btn-primary btn-md', 'type' => 'submit']) }}
                  {{ Form::close() }}
                </td>
                <td><!-- Create Archive PFX(P12) -->
                  {{ Form::open(['url' => 'converter/createP12', 'method' => 'post']) }}
                  {{csrf_field()}}
                  <!--{{ Form::label('Common Name: ', 'Common Name: ', ['class' => '']) }}-->
                  <input type="hidden" name="cn" value="{{ $cn }}">
                  @if($errors->has('cn'))
                      {{ $errors->first('cn') }} 
                  @endif
                  {{ Form::token() }}
                  {{ Form::button('<i class="fa fa-cogs" aria-hidden="true"></i> Create PFX(P12)', ['class' => 'btn btn-primary btn-md', 'type' => 'submit']) }}
                  {{ Form::close() }}
                </td>

                <td><!-- Key Matcher -->
                  {{ Form::open(['url' => 'certs/mgmt/keymatcher', 'method' => 'post']) }}
                  {{csrf_field()}}
                  <!--{{ Form::label('Common Name: ', 'Common Name: ', ['class' => '']) }}-->
                  <input type="hidden" name="cn" value="{{ $cn }}">
                  <input type="hidden" name="csrprint" value="{{ $csrprint }}">
                  <input type="hidden" name="certprint" value="{{ $certprint }}">
                  <input type="hidden" name="keyprint" value="{{ $keyprint }}">

                  @if($errors->has('cn'))
                      {{ $errors->first('cn') }} 
                  @endif
                  {{ Form::token() }}
                  {{ Form::button('<i class="fa fa-handshake-o" aria-hidden="true"></i> Key Matcher', ['class' => 'btn btn-primary btn-md', 'type' => 'submit']) }}
                  {{ Form::close() }}
                </td>


                <td><!-- Renew Certificate -->
                  {{ Form::open(['url' => 'certs/mgmt/renew', 'method' => 'post']) }}
                  {{csrf_field()}}
                  <!--{{ Form::label('Common Name: ', 'Common Name: ', ['class' => '']) }}-->
                  <input type="hidden" name="cn" value="{{ $cn }}">
                  <input type="hidden" name="csrprint" value="{{ $csrprint }}">
                  @if($errors->has('cn'))
                      {{ $errors->first('cn') }} 
                  @endif
                  {{ Form::token() }}
                  {{ Form::button('<i class="fa fa-refresh" aria-hidden="true"></i> Renew Certificate', ['class' => 'btn btn-success btn-md', 'type' => 'submit']) }}
                  {{ Form::close() }}
                </td>
                <td><!-- Revoke Certificate -->
                  {{ Form::open(['url' => 'certs/mgmt/revoke', 'method' => 'post']) }}
                  {{csrf_field()}}
                  <!--{{ Form::label('Common Name: ', 'Common Name: ', ['class' => '']) }}-->
                  <input type="hidden" name="cn" value="{{ $cn }}">
                  @if($errors->has('cn'))
                      {{ $errors->first('cn') }} 
                  @endif
                  {{ Form::token() }}
                  {{ Form::button('<i class="fa fa-ban" aria-hidden="true"></i> Revoke Certificate', ['class' => 'btn btn-danger btn-md', 'type' => 'submit']) }}
                  {{ Form::close() }}
                </td>
                <td><!-- Update table -->
                  {{ Form::open(['url' => 'certs/mgmt/update', 'method' => 'post']) }}
                  {{csrf_field()}}
                  <!--{{ Form::label('Common Name: ', 'Common Name: ', ['class' => '']) }}-->
                  <input type="hidden" name="cn" value="{{ $cn }}">
                  @if($errors->has('cn'))
                      {{ $errors->first('cn') }} 
                  @endif
                  {{ Form::token() }}
                  {{ Form::button('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update', ['class' => 'btn btn-success btn-md', 'type' => 'submit']) }}
                  {{ Form::close() }}
                </td>
                <td><!-- Delete table -->
                  {{ Form::open(['url' => 'certs/mgmt/delete', 'method' => 'post']) }}
                  {{csrf_field()}}
                  <!--{{ Form::label('Common Name: ', 'Common Name: ', ['class' => '']) }}-->
                  <input type="hidden" name="cn" value="{{ $cn }}">
                  @if($errors->has('cn'))
                      {{ $errors->first('cn') }} 
                  @endif
                  {{ Form::token() }}
                  {{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i> Delete Certificate', ['class' => 'btn btn-danger btn-md', 'type' => 'submit']) }}
                  {{ Form::close() }}
                </td>


              </tr>
             </tbody>
          </table>
        </div>
      </div>

@endsection