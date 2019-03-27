@extends('layouts.app')

	@section('content')
<div class="container">

	<h2><i class="fa fa-list-alt" aria-hidden="true"></i> To Do´s</h2>
	<div class="content">

	<h3><i class="fa fa-cogs" aria-hidden="true"></i> Features:</h3>

	<ul class="text-info">
		<li class="text-danger">"Request New CSR/Key": Add Code signing option in Certificate Type".
		<li class="text-danger">"Request New CSR/Key": ClientID option not getting correct section params from config.
		<li class="text-danger">Let´s Encrypt App.
		<li class="text-success">Generate certificates with <strong>SubjectAltNames</strong> by default (CommonName will be added as SAN together with the rest of SAN Names).
	</ul>

	<h3><i class="fa fa-cogs" aria-hidden="true"></i> Backend:</h3>

	<ul class="text-info">
		<li class="text-success">In all Controller: When password incorrect (Ex. Renew, Revoked...), doesn´t clean SAN from config file".
		<li class="text-success">Reestructured custom and framework error pages.
		<li class="text-danger">Use Cards for templates.
		<li class="text-danger">Automate Database backup.
	</ul>


	<!-- END CONTENT -->

	</div>
</div>
@endsection
