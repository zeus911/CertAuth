@extends('layouts.app')
@section('content') 

<div class="container">

	<h2>Certificates Status</h2>      		
    </br>
<div class="bs-callout bs-callout-primary">
    <table width="100%" class="table dt-responsive nowrap" id="dashboard" cellspacing="0">
	    <!--<table id="dashboard" class="table table-bordered table-condensed table-responsive" cellspacing="0" width="100%"> -->
	        <thead>
	            <tr>
                <th>ID</th>
                <th>Status</th>
	            </tr>
	        </thead>
	        <tbody>
          @foreach ($certs as $cert)
	            <tr class="text-info">
                <td>{{ $cn }}</td>
	              <td>{{ $certstatus }}</td>               
              </tr> 
	        @endforeach

	        </tbody>
	   </table>
</div>

@endsection
