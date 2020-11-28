@extends('Template')
@extends('admin/navbar')
@section('Title')
    Report Bulanan
@endsection

@section('Content')
<main role="main" class="col-md-10 ml-sm-auto col-lg-11 px-md-4">
<div id="penjualanChart" style="height: 60%; width: 90%;margin-top:25px"></div>

<div id="bajuSellerChart" style="height: 60%; width: 90%;margin-top:25px"></div>
</main>
<script>
$(document).ready(function () {
    //Get Data Jualan Bulan
    $.get('{{ url("admin/Report/GetData") }}', {}, function (response) {
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
        var chart = new CanvasJS.Chart("penjualanChart", {
            animationEnabled: true,
            theme: "light1",
            title: {
                text: "Penjulan Bulan " + month[d.getMonth()]
            },
            axisY: {
                title: "Jumlah Penjualan (Rp)"
            },
            data: [{
                type: "column",
                yValueFormatString: "Rp #,##0.##",
                dataPoints: JSON.parse(response)
            }]
        });
        chart.render();
    });

    $.get('{{ url("admin/Report/GetDataBaju") }}', {}, function (response) {
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
        var a = new CanvasJS.Chart("bajuSellerChart", {
            animationEnabled: true,
            theme: "light1",
            title: {
                text: "Laporan Jumlah Penjualan Baju, Bulan " + month[d.getMonth()]
            },
            axisY: {
                title: "Jumlah / Pcs"
            },
            data: [{
                type: "column",
                yValueFormatString: "# pcs",
                dataPoints: JSON.parse(response)
            }]
        });
        a.render();
    });
});
</script>
@endsection
