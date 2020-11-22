@extends('Template')
@extends('admin/navbar')
@section('Title')
    List Transaksi
@endsection

@section('Content')
<main role="main" class="col-md-10 ml-sm-auto col-lg-11 px-md-4">
    @php
        Use App\Model\Users;
        Use App\Model\h_transaksi;
        Use App\Model\d_jual;
    @endphp
    <div id='mainTrans'>
        <h1 style="margin:10px">List On Going Order</h1>
    <form action="ListTransaski/History">
    <button class="btn btn-info">History</button>
    </form>
    <table class="display" id='listTrans'>
        <thead>
            <td>Nama User</td>
            <td>Total Pembelian</td>
            <td>Tanggal Transaksi</td>
            <td>Status</td>
            <td>Action</td>
        </thead>
        <tbody>
            @foreach (h_transaksi::where("status","!=","2")->get() as $item)
                <tr>
                    <td>{{Users::where('id_user',$item->id_user)->value('nama_user')}}</td>
                    <td>{{"Rp. ".number_format($item->grand_total)}}</td>
                    <td>{{$item->tgl_jual}}</td>
                    @if ($item->status == "0")
                        <td class='bg-secondary text-white'>Menunggu Verifikasi</td>
                    @elseif($item->status == "1")
                        <td class="bg-success text-white">Order In Process</td>
                    @elseif($item->status == "3")
                        <td class="bg-warning">Menunggu Bukti Transfer Baru</td>
                    @elseif($item->status == "4")
                        <td class="bg-info text-white">Order Sent To Customer</td>
                    @endif
                    <td align="center">
                        <button class="btn btn-success showDetail" value='{{$item->id_hjual}}' ongkir='{{$item->grand_total - d_jual::where('id_hjual',$item->id_hjual)->sum('subtotal')}}'>Show Detail</button>
                        @if ($item->status == "0")
                            <button class="btn btn-info showBukti" value="{{url($item->gambar)}}">Bukti Transfer</button>
                            <button class='btn btn-primary processOrder' value='{{$item->id_hjual}}'>Process Order</button>
                            <button class="btn btn-danger invalidPayment" value='{{$item->id_hjual}}'>Payment Invalid</button>
                        @elseif($item->status == "1")
                            <button class="btn btn-primary finishOrder" value='{{$item->id_hjual}}'>Send Order</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
    <div id="detailOrder">

    </div>
</main>
<script>
    $(document).ready(function(){
        $("#detailOrder").hide();
        $("#listTrans").DataTable();
        $(document).on('click',".showBukti",function(e){
            Swal.fire({
                title: 'Bukti Tranfer',
                imageUrl: $(this).val(),
                imageAlt: 'Custom image',
            })
        });
        $(document).on('click',".processOrder",function(e){
            var id = $(this).val();
            Swal.fire({
                title: 'Apakah anda ingin memproses Order?',
                showDenyButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
                }).then((result) => {
                if (result.isConfirmed) {
                    $.get('{{ url("admin/ListTransaksi/ProcessOrder") }}',{id : id}, function(response) {
                        console.log(response);
                        if(response == "Success"){
                            Swal.fire({
                                text: "Order Status Change",
                                icon: 'success',
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            })
                        }
                        else if(response == "Stock"){
                            Swal.fire('Stock Barang Kurang', '', 'error')
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
        })

        $(document).on('click',".invalidPayment",function(e){
            var id = $(this).val();
            Swal.fire({
                title: 'Apakah anda ingin meminta bukti transfer baru?',
                showDenyButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
                }).then((result) => {
                if (result.isConfirmed) {
                    $.get('{{ url("admin/ListTransaksi/InvalidPayment") }}',{id : id}, function(response) {
                        alert(response);
                        if(response == "Success"){
                            Swal.fire({
                                text: "Order Status Change",
                                icon: 'success',
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            })
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
        })

        $(document).on('click',".finishOrder",function(e){
            var id = $(this).val();
            Swal.fire({
                title: 'Apakah order sudah selesai di process?',
                showDenyButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
                }).then((result) => {
                if (result.isConfirmed) {
                    $.get('{{ url("admin/ListTransaksi/FinishOrder") }}',{id : id}, function(response) {
                        if(response == "Success"){
                            Swal.fire({
                                text: "Order Status Change",
                                icon: 'success',
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            })
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
        })

        $(document).on('click',".showDetail",function(e){
            var ongkir = $(this).attr('ongkir');
            var id = $(this).val();
            $.get('{{ url("admin/ListTransaksi/getDetail") }}',{id : id}, function(response) {
                var hasil = JSON.parse(response);
                var grand = ongkir;
                var dom=` <h2>Detail Order</h2>
                <button class="btn btn-primary" id='backToMainTrans'>Back</button>
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
                }
                dom+=`</tbody></table>
                <h3 style='margin-right:10%'>Biaya Ongkir : Rp. `+new Intl.NumberFormat('ID').format(ongkir)+`</h3>
                <h3 style='margin-right:10%'>Grand Total : Rp. `+new Intl.NumberFormat('ID').format(grand)+`</h3>`;
                $("#detailOrder").html(dom);
                $("#detailOrder").show();
                $("#mainTrans").hide();
                $("#listDetail").DataTable();
            });
        })

        $(document).on('click',"#backToMainTrans",function(e){
            $("#mainTrans").show('slow');
            $("#detailOrder").hide('slow');
        })
    });
</script>
@endsection
