@extends('layouts.app')

@section('content')

<div class="container">
    <H2>You have successfully generated the Certificate.</H2>
    
    <h5 class="text-primary"><strong>Now, You should download the certificate &amp his Private Key archive.</strong></h5>

    <div class="container">
        <h4>Certificate Summary:</h4>   
	       <div class="container">
               <!-- cert summary -->
               <table class="table table-striped table-bordered" cellspacing="0" nowrap>
                    <thead>
                    <tr>
                          <th><i class="fas fa-certificate"></i> Common Name</th>
                            <td><strong class="text-primary"> {{ $subjectCommonName }} </strong></td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-file-signature"></i> Subject Alternative Names</th>
                            <td><strong class="text-primary"> {{ $extensionsSubjectAltName }} </strong></td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-file-signature"></i> Organization Name</th>
                            <td><strong class="text-primary"> {{ $organizationName }} </strong></td>
                    </tr>

                    <tr>
                          <th><i class="fas fa-file-signature"></i> Certificate Type</th>
                            <td><strong class="text-primary"> {{ $extensionsExtendedKeyUsage }} </strong></td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-signature"></i> Signature Algorithm</th>
                          <td><strong class="text-primary"> {{ $signatureTypeSN }} </strong></td>
                    </tr>
                        <th><i class="fas fa-key"></i> Key Length</th>
                          <td><strong class="text-primary"> {{ $keyLength }} </strong></td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-sort-numeric-up"></i> Serial Number</th>
                          <td><strong class="text-primary"> {{ $serialNumber }} </strong></td>
                    </tr>
                    <tr>
                        <th><i class="fas fa-sort-numeric-up"></i> Validity Period</th>
                           <td><strong class="text-primary"> {{ $validityPeriod }} </strong></td>
                        </tr>
                    <tr>
                        <th><i class="fas fa-envelope"></i> E-mail</th>
                          <td><strong class="text-primary"> {{ $email }} </strong></td>
                    </tr>
                    <tr>
                          <th><i class="fas fa-comment"></i> Comments</th>
                            <td><strong class="text-primary"> {{ $comments }} </strong></td> 
                    </tr>
                        <th><i class="fa fa-cogs"></i> Certificate &amp Private Key</th>
                            <td>
                                    {{ Form::open(['url' => 'certs/getCert', 'method' => 'post']) }}
                                    <input type="hidden" name="subjectCommonName" value="{{ $subjectCommonName }}">
                                    <input type="hidden" name="extensionsExtendedKeyUsage" value="{{ $extensionsExtendedKeyUsage }}">
                                    <input type="hidden" name="signatureTypeSN" value="{{ $signatureTypeSN }}">
                                    <input type="hidden" name="serialNumber" value="{{ $serialNumber }}">
                                    <input type="hidden" name="certificateServerRequest" value="{{ $certificateServerRequest }}">
                                    <input type="hidden" name="publicKey" value="{{ $publicKey }}">
                                    <input type="hidden" name="privateKey" value="{{ $privateKey }}">
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    <input type="hidden" name="comments" value="{{ $comments }}">
                                    <input type="hidden" name="p12" value="PFX archive not generated. You have to re-generate it again if you renewed the certificate.">
                                    <!-- <input type="hidden" name="status" value="Valid"> -->              
                                    {{ form::token() }}
                                    {{ Form::button('<i class="fa fa-download"></i> Create & Get Keypair ', ['class' =>'btn btn-success', 'type' => 'submit']) }}
                                    {{ Form::close() }}
                            </td> 
                    </tr>


                    </thead>
                </table>
            </div>
          <br />
            <!-- end cert summary -->
        <h4>Convert to PFX (P12)</h4>
        <h5 class="text-primary"><strong>To convert it to PFX (P12), click <strong class="text-success">Create & Get Keypair</strong> button first and then type the passphrase and click <strong class="text-success">Convert to PFX (P12)</strong> button.</strong></h5>

       <div class="container-fuid">	  
        {{ Form::open(['url' => 'certs/getP12', 'method' => 'post']) }}
        <input type="hidden" name="subjectCommonName" value="{{ $subjectCommonName }}">
        <!-- <input type="hidden" name="extensionsExtendedKeyUsage" value="{{ $extensionsExtendedKeyUsage }}">
        <input type="hidden" name="signatureTypeSN" value="{{ $signatureTypeSN }}">
        <input type="hidden" name="certificateServerRequest" value="{{ $certificateServerRequest }}"> -->
        <input type="hidden" name="publicKey" value="{{ $publicKey }}">
        <input type="hidden" name="privateKey" value="{{ $privateKey }}">
        
        {{ Form::label('password: ', 'Passphrase: ', ['class' => '']) }}
        {{ Form::password('password', ['placeholder' => 'PFX Passphrase', 'class' => 'form-control' ]) }}
            @if($errors->has('password'))
            {{ $errors->first('password') }} 
        @endif     
        <br />
        {{ form::token() }}
        {{ Form::button('<i class="fa fa-cogs"></i> Convert to PFX (P12)', ['class' =>'btn btn-success', 'type' => 'submit']) }}
        {{ Form::close() }}
        <br />
        {{ Form::open(['url' => 'certs/mgmt', 'files' => 'true', 'method' => 'get']) }}
        {{ Form::token() }}
        {{ Form::submit('Go back to Managemnet', ['class' => 'btn btn-secondary']) }}
        {{ Form::close() }}
        <br />
    </div>
</div>

@endsection