@extends('layouts.app')

@section('content')

<div class="container">
    <H2>Root & Intermediate certificates</H2>
<!--    	{{ Form::open(['url' => 'rootcrl/getRoot', 'method' => 'POST', 'class' => 'form']) }}
    	<div class="form-group">
       	{{ Form::submit('TRAGSA CA G2 Root certificate', ['class' => 'btn btn-primary btn-lg']) }}
        </div>
        {{ Form::close() }}
    	
    	{{ Form::open(['url' => 'https://knowledge.symantec.com/support/ssl-certificates-support/index?page=content&id=SO4785', 'method' => 'GET', 'target' => '_blank', 'class' => 'form']) }}
    	<div class="form-group">
       	{{ Form::submit('Symantec Root / Intermediate certificates', ['class' => 'btn btn-primary btn-lg']) }}
        </div>
        {{ Form::close() }}
    	
    	{{ Form::open(['url' => '', 'method' => 'POST', 'target' => '_blank', 'class' => 'form']) }}
    	<div class="form-group">
       	{{ Form::submit('FirmaProfesional Root Intermediate certificates', ['class' => 'btn btn-primary btn-lg']) }}
        </div>
        {{ Form::close() }}
-->

<div class="container">
  <div class="panel-group" id="accordion">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
          <i class="fa fa-chevron-down" aria-hidden="true"></i>
			TRAGSA CA G2</a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse">
        <div class="panel-body">{{ Form::open(['url' => 'rootcrl/getRootTRAGSA', 'method' => 'POST', 'class' => 'form']) }}
    	<div class="form-group">
       	{{ Form::submit('Download TRAGSA CA G2 Root certificate', ['class' => 'btn btn-primary btn-md']) }}
        </div>
        {{ Form::close() }}</div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
          <i class="fa fa-chevron-down" aria-hidden="true"></i>
			DIGICERT / SYMANTEC</a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body"><H3 class="">DigiCert Trusted Root Authority Certificates</H3>
        	<p class=""><i class="fa fa-info-circle" aria-hidden="true"></i> Download DigiCert Root and Intermediate Certificate</p>

        	<H4>Root Certificates</H4>
           	<p><a href="https://www.digicert.com/digicert-root-certificates.htm#roots"><i class="fa fa-link" aria-hidden="true"></i> Go to Download Site</a></p>

        	<H4>Intermediate Certificates</H4>
           	<p><a href="https://www.digicert.com/digicert-root-certificates.htm#intermediates"><i class="fa fa-link" aria-hidden="true"></i> Go to Download Site</a></p>

        	<H4>Cross Signed Certificates</H4>
           	<p><a href="https://www.digicert.com/digicert-root-certificates.htm#cross-signed"><i class="fa fa-link" aria-hidden="true"></i> Go to Download Site</a></p>

        </div>

        <div class="panel-body"><H3 class="">SSL for Symantec Trust Center - RSA SHA-2</H3>
        	<p class=""><i class="fa fa-info-circle" aria-hidden="true"></i> Use if you have purchased an SSL certificate directly from a Symantec Trust Center (STC or STCE) account or from our retail web site at Symantec.com</p>

        	<H4>Under SHA-1 Root</H4>

           	<p><a href="https://www.websecurity.symantec.com/content/dam/websitesecurity/support/ica/retail-ssl/02_SHA2SHA1-SSWPro-Root.cer"><i class="fa fa-download" aria-hidden="true"></i> Secure Site, Secure Site Wildcard & Secure Site Pro RSA SHA-2 (under SHA-1 Root) Root CA</a></p>

        	<p><a href="https://www.websecurity.symantec.com/content/dam/websitesecurity/support/ica/retail-ssl/01_SHA2SHA1-SSWPro-ICA.cer"><i class="fa fa-download" aria-hidden="true"></i> Secure Site, Secure Site Wildcard & Secure Site Pro RSA SHA-2 (under SHA-1 Root) Intermediate CA</a></p>

        	<p><a href="https://www.websecurity.symantec.com/content/dam/websitesecurity/support/ica/retail-ssl/04_SHA2SHA1-SSEVProEV-Root.cer"><i class="fa fa-download" aria-hidden="true"></i> Secure Site with Extended Validation (EV) & Secure Site Pro with Extended Validation (EV) RSA SHA-2 (under SHA-1 Root) Root CA</a></p>

        	<p><a href="https://www.websecurity.symantec.com/content/dam/websitesecurity/support/ica/retail-ssl/03_SHA2SHA1-SSEVProEV-ICA.cer"><i class="fa fa-download" aria-hidden="true"></i> Secure Site with Extended Validation (EV) & Secure Site Pro with Extended Validation (EV) RSA SHA-2 (under SHA-1 Root) Intermediate CA</a></p>

        	<H4>Under SHA-2 Root</H4>

           	<p><a href="https://www.websecurity.symantec.com/content/dam/websitesecurity/support/ica/retail-ssl/06_SHA2SHA2-SSWPro-Root.cer"><i class="fa fa-download" aria-hidden="true"></i> Secure Site, Secure Site Wildcard & Secure Site Pro RSA SHA-2 (under SHA-2 Root) Root CA</a></p>

        	<p><a href="https://www.websecurity.symantec.com/content/dam/websitesecurity/support/ica/retail-ssl/05_SHA2SHA2-SSWPro-ICA.cer"><i class="fa fa-download" aria-hidden="true"></i> Secure Site, Secure Site Wildcard & Secure Site Pro RSA SHA-2 (under SHA-2 Root) Intermediate CA</a></p>

        	<p><a href="https://www.websecurity.symantec.com/content/dam/websitesecurity/support/ica/retail-ssl/08_SHA2SHA2-SSEVProEV-Root.cer"><i class="fa fa-download" aria-hidden="true"></i> Secure Site with Extended Validation (EV) & Secure Site Pro with Extended Validation (EV) RSA SHA-2 (under SHA-2 Root) Root CA</a></p>

        	<p><a href="https://www.websecurity.symantec.com/content/dam/websitesecurity/support/ica/retail-ssl/07_SHA2SHA2-SSEVProEV-ICA.cer"><i class="fa fa-download" aria-hidden="true"></i> Secure Site with Extended Validation (EV) & Secure Site Pro with Extended Validation (EV) RSA SHA-2 (under SHA-2 Root) Intermediate CA</a></p>


        </div>
        <div class="panel-body"><H3 class="">Code Signing for Symantec Trust Center - RSA SHA-2</H3>
        	<p class=""><i class="fa fa-info-circle" aria-hidden="true"></i> Use if you have purcahsed a Code Signing certificate from a Symantec Trust Center (STC or STCE) account or from our retail web site at Symantec.com.</p>

        	<H4>Under SHA-1 Root</H4>

           	<p><a href="https://www.websecurity.symantec.com/content/dam/websitesecurity/support/ica/retail-code-signing/02_SHA2SHA1-AJOAcs-Root.cer"><i class="fa fa-download" aria-hidden="true"></i> Microsoft Authenticode, Oracle Java, Microsoft Office & VBA, Adobe Air RSA SHA-2 (under SHA-1 Root) Root CA</a></p>

        	<p><a href="https://www.websecurity.symantec.com/content/dam/websitesecurity/support/ica/retail-code-signing/01_SHA2SHA1-AJOAcs-ICA.cer"><i class="fa fa-download" aria-hidden="true"></i> Microsoft Authenticode, Oracle Java, Microsoft Office & VBA, Adobe Air RSA SHA-2 (under SHA-1 Root) Intermediate CA</a></p>

        	<p><a href="https://www.websecurity.symantec.com/content/dam/websitesecurity/support/ica/retail-code-signing/03_SHA2SHA1-EVcs-ICA.cer"><i class="fa fa-download" aria-hidden="true"></i> Extended Validation (EV) Code Signing RSA SHA-2 (under SHA-1 Root) Root CA</a></p>

        	<p><a href="https://www.websecurity.symantec.com/content/dam/websitesecurity/support/ica/retail-code-signing/03_SHA2SHA1-EVcs-ICA.cer"><i class="fa fa-download" aria-hidden="true"></i> Extended Validation (EV) Code Signing RSA SHA-2 (under SHA-1 Root) Intermediate CA</a></p>

        	<H4>Under SHA-2 Root</H4>

           	<p><a href="https://www.websecurity.symantec.com/content/dam/websitesecurity/support/ica/retail-code-signing/06_SHA2SHA2-AJOAcs-Root.cer"><i class="fa fa-download" aria-hidden="true"></i> Microsoft Authenticode, Oracle Java, Microsoft Office & VBA, Adobe Air RSA SHA-2 (under SHA-2 Root) Root CA</a></p>

        	<p><a href="https://www.websecurity.symantec.com/content/dam/websitesecurity/support/ica/retail-code-signing/05_SHA2SHA2-AJOAcs-ICA.cer"><i class="fa fa-download" aria-hidden="true"></i> Microsoft Authenticode, Oracle Java, Microsoft Office & VBA, Adobe Air RSA SHA-2 (under SHA-2 Root) Intermediate CA</a></p>

        	<p><a href="https://www.websecurity.symantec.com/content/dam/websitesecurity/support/ica/retail-code-signing/08_SHA2SHA2-EVcs-Root.cer"><i class="fa fa-download" aria-hidden="true"></i> Extended Validation (EV) Code Signing RSA SHA-2 (under SHA-2 Root) Root CA</a></p>

        	<p><a href="https://www.websecurity.symantec.com/content/dam/websitesecurity/support/ica/retail-code-signing/07_SHA2SHA2-EVcs-ICA.cer"><i class="fa fa-download" aria-hidden="true"></i> Extended Validation (EV) Code Signing RSA SHA-2 (under SHA-2 Root) Intermediate CA</a></p>


        </div>

      </div>
    </div>  
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
          <i class="fa fa-chevron-down" aria-hidden="true"></i>
			FIRMAPROFESIONAL</a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body"><H3 class="">Firmaprofesinal</H3>

           	<!--<p><a href="http://crl.firmaprofesional.com/caroot.crt"><i class="fa fa-download" aria-hidden="true"></i> Autoridad de Certificacion Firmaprofesional CIF A62634068 (Vigente hasta 2030)</a></p> -->

           	<p><a href="http://crl.firmaprofesional.com/caroot256.crt"><i class="fa fa-download" aria-hidden="true"></i> Autoridad de Certificacion Firmaprofesional CIF A62634068 SHA-256 (Vigente hasta 2036)</a></p>

           	<p><a href="http://crl.firmaprofesional.com/ca1.crt"><i class="fa fa-download" aria-hidden="true"></i> AC Firmaprofesional - CA1 (vigente hasta 2030)</a></p>

           	<p><a href="http://crl.firmaprofesional.com/infraestructura.crt"><i class="fa fa-download" aria-hidden="true"></i> AC Firmaprofesional - INFRAESTRUCTURA</a></p>

           	<p><a href="http://crl.firmaprofesional.com/infraestructura_256.crt"><i class="fa fa-download" aria-hidden="true"></i> AC Firmaprofesional - INFRAESTRUCTURA (SHA-256)</a></p>

           	<p><a href="http://crl.firmaprofesional.com/cualificados.crt"><i class="fa fa-download" aria-hidden="true"></i> AC Firmaprofesional - CUALIFICADOS (SHA-256)</a></p>


    </div>
  </div> 
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class="panel-title">
      <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
      <i class="fa fa-chevron-down" aria-hidden="true"></i>
  LET´S ENCRYPT</a>
    </h4>
  </div>
  <div id="collapse4" class="panel-collapse collapse">
    <div class="panel-body">{{ Form::open(['url' => 'rootcrl/getRootLE', 'method' => 'POST', 'class' => 'form']) }}
  <div class="form-group">
    {{ Form::submit('Download Let´s Encrypt Root / Intermediate certificates', ['class' => 'btn btn-primary btn-md']) }}
    </div>
    {{ Form::close() }}</div>
  </div>
</div>

@endsection