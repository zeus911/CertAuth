@extends('layouts.app')
@section('content') 

<div class="container">

  <h2>Dashboard</h2>          

    </br> 
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	title:{
		text: "Certificate Isued by:"
	},
	subtitles: [{
		text: "Name of the CA that has signed certifcates" 
	}],
	data: [{
		type: "pie",
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 16,
		indexLabel: "{label} - #percent%",
		yValueFormatString: "฿#,##0",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>

<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->

    <br />

    </br>
   </div>
</div>
@endsection
