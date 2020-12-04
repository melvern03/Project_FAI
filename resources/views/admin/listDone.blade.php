@extends('Template')
@extends('admin/navbar')
@section('Title')
    History
@endsection

@section('Content')
<main role="main" class="col-md-10 ml-sm-auto col-lg-11 px-md-4">
    @php
        Use App\Model\Users;
        Use App\Model\h_transaksi;
        Use App\Model\d_jual;
    @endphp
<div id="MainContainer">
<h2>List Finish Order</h2>
<form action="/admin/ListTransaksi">
<button class="btn btn-info">Back To Ongoing Transaksi</button>
</form>
<table class="display" id='listDone'>
    <thead>
        <td>Nama User</td>
        <td>Total Pembelian</td>
        <td>Tanggal Transaksi</td>
        <td>Action</td>
    </thead>
    <tbody>
        @foreach (h_transaksi::where("status","2")->get() as $item)
            <tr>
                <td>{{Users::where('id_user',$item->id_user)->value('nama_user')}}</td>
                <td>{{"Rp. ".number_format($item->grand_total)}}</td>
                <td>{{$item->tgl_jual}}</td>
                <td><button class="btn btn-success showDetail" value='{{$item->id_hjual}}' ongkir='{{$item->grand_total - d_jual::where('id_hjual',$item->id_hjual)->sum('subtotal') + $item->diskon}}'>Show Detail</button></td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
<div id='historyDetail'>

</div>
</main>
<script>
    $(document).ready(function(){
        $("#listDone").DataTable();
        $(document).on('click',".showDetail",function(e){
            var ongkir = $(this).attr('ongkir');
            var id = $(this).val();
            $.get('{{ url("admin/ListTransaksi/getDetail") }}',{id : id}, function(response) {
                var hasil = JSON.parse(response);
                var grand = ongkir;
                var diskon = 0;
                var dom=` <h2>Detail Order</h2>
                <button class="btn btn-primary" id='backToMainDone'>Back</button>
                <h3></h3>
                <table class='display' id='listDetail'>
                <thead>
                    <td>Nama Baju</td>
                    <td>Harga</td>
                    <td>Jumlah</td>
                    <td>Subtotal</td>
                </thead>
                <tbody>`;
                for(var i = 0; i < hasil.length; i++) {
                    var obj = hasil[i];
                    dom+=`
                    <tr>
                        <td>`+obj.nama_baju+`</td>
                        <td>Rp. `+new Intl.NumberFormat("ID").format(obj.harga)+`</td>
                        <td>`+obj.jumlah+`</td>
                        <td>Rp. `+new Intl.NumberFormat("ID").format(obj.subtotal)+`</td>
                    </tr>
                    `;
                    grand = parseInt(grand)+parseInt(obj.subtotal);
                    diskon = obj.diskon;
                }
                grand = grand - diskon;
                dom+=`</tbody></table>
                <h3 style='margin-right:10%'>Sub Total : Rp. `+new Intl.NumberFormat('ID').format(grand-ongkir)+`</h3>
                <h3 style='margin-right:10%'>Biaya Ongkir : Rp. `+new Intl.NumberFormat('ID').format(ongkir)+`</h3>
                <h3 style='margin-right:10%'>Discount : Rp. `+new Intl.NumberFormat('ID').format(diskon)+`</h3>
                <h3 style='margin-right:10%'>Grand Total : Rp. `+new Intl.NumberFormat('ID').format(grand)+`</h3>`;
                $("#historyDetail").html(dom);
                $("#historyDetail").show();
                $("#MainContainer").hide();
                $("#listDetail").DataTable();
            });
        })
        $(document).on('click',"#backToMainDone",function(e){
            $("#MainContainer").show('slow');
            $("#historyDetail").hide('slow');
        })
    });
</script>
@endsection
