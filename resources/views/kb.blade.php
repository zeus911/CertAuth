@extends('layouts.app')

	@section('content')
<div class="container">

	<h2><i class="fa fa-list-alt" aria-hidden="true"></i> Knowledge Base</h2>
	<div class="content">

	<h3><i class="fa fa-cogs" aria-hidden="true"></i> ErrorExceptions:</h3>

	<ul class="text-info">
		<img src="/img/kb/ErrorException1.png"><br />
		Este error se ha detectado cuando el fichero de configuración "openssl_serv.cnf" está corrupto. Ej. Cuando algún error ha borrado o no ha limpiado bien la entrada SAN. Comprueba que todas las entradas SAN(4) aparecen así: subjectAltName = DNS:.

    	<br /><br />
    	<img src="/img/kb/ErrorException2.png"><br />
    	Este error sale con cuaquier operación con certificados y/o CSR que no tienen la extensión SAN. Para poder generar otro con el mismo CN hay que Revocar el certificado.

	</ul>

	<!-- END CONTENT -->

	</div>
</div>
@endsection
 