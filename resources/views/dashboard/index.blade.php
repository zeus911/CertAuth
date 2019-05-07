@extends('layouts.app')
@section('content') 

<div class="container">

  <h1>Certificates Dashboard</h1>
  <h4 class="text-info">Total Nº of Certificates: <strong class="text-success"> {{ $certsNumber }}</strong></h4>
     
  <!-- // Number of Certificates By CA -->
  <div class="container-fuid">
  	<div class="row">
  		<div class="col-md-12 col-sm-12">
  			{{ $certs_issued_by->container() }} 
  		</div>
  		<div class="col-md-12 col-sm-12">
			{!! $certs_status->container() !!} 
		</div>
		  <div class="col-md-6 col-sm-6">
			  {!! $certs_number_issued->container() !!}
		  </div>
  		<div class="col-md-6 col-sm-6">
  			{!! $certs_type->container() !!} 
  		</div>
  	</div>
  </div>	

</div> 
@endsection
