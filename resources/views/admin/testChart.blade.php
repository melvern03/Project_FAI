@extends('Template')

@section('Content')
<?php
use Illuminate\Support\Carbon;
Use App\Model\h_transaksi;

$dataPoints = [];
$number = cal_days_in_month(CAL_GREGORIAN,Carbon::now()->month,Carbon::now()->year);


for ($i=1; $i <= $number; $i++) {
    $data = array(
        "y"=>0,
        "label"=>$i."/".Carbon::now()->month."/".Carbon::now()->year
    );
    $dataPoints[] = $data;
}
foreach (h_transaksi::all() as $key => $value) {
    $dataPoints[Carbon::parse($value->tgl_jual)->format('d') - 1]["y"] = $dataPoints[Carbon::parse($value->tgl_jual)->format('d') - 1]["y"] + $value->grand_total;
}
?>
<!DOCTYPE HTML>
<html>
<head>
<script>
$(document).ready(function(){

var d = new Date();
var d = new Date();
var month = new Array();
month[0] = "January";
month[1] = "February";
month[2] = "March";
month[3] = "April";
month[4] = "May";
month[5] = "June";
month[6] = "July";
month[7] = "August";
month[8] = "September";
month[9] = "October";
month[10] = "November";
month[11] = "December";
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "Penjulan Bulan "+month[d.getMonth()]
	},
	axisY: {
		title: "Jumlah Penjualan (Rp)"
	},
	data: [{
		type: "column",
		yValueFormatString: "Rp #,##0.##",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

})
</script>
</head>
<body>
<div id="chartContainer" style="height: 10%; width: 80%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</body>
</html>
@endsection
