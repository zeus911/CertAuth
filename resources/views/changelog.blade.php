@extends('layouts.app')

	@section('content')
<div class="container">

	<h2><i class="fa fa-bullhorn" aria-hidden="true"></i> ChangeLog</h2>
	<div class="content">

	<h3>Version 2.0.0</h3>
	<p><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Release Date: 27/4/2017</p>
	<p><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Code Update: 22/5/2018</p>

	<ul class="text-info">
		<li>DB Table ordered, filter and live search in Certificate Management page.

		<li>Number of subjectAltName limit removed. Now you can type as much DNS Names as needed.

		<li>SubjectAltName available when generating certs and csr. Now the CN is copied into the subjectAltName. Use: type all the DNS Names needed in the certificate in the "CN" field separated by <kbd>SPACE</kbd>.

		<li>Created a script <dfn>/opt/subjectAltNameRemove.sh</dfn> to clean DNS Names from config file ones it is generated.

		<li>Let´s Encrypt Root CA and Intermediate included in <dfn>Root & CRLs -> Download Root Certificate</dfn>.

		<li>Created a script <dfn>/opt/certmon/offline-cert-check.sh</dfn> to monitor expiry dates from certificates.

		<li>Created "Delete Certificate" button in More Details view.

	</ul>

	<!-- END CONTENT -->

	</div>
</div>
@endsection
