@extends('Template')
@extends('admin/navbar')
@section('Title')
    List Transaksi
@endsection

@section('Content')
<main role="main" class="col-md-10 ml-sm-auto col-lg-11 px-md-4">
<h1 style="margin:10px">List Transaksi</h1>
    @php
        Use App\Model\Users;
        Use App\Model\h_transaksi;
    @endphp
    <form action="#">
    <button class="btn btn-info">History</button>
    </form>
    <table class="table table-striped display" id='listTrans'>
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
                    @endif
                    <td align="center" style="">
                        <button class="btn btn-info showBukti" value="{{url($item->gambar)}}">Bukti Transfer</button>
                        <button class="btn btn-success showDetail" value='{{$item->id_hjual}}'>Show Detail</button>
                        @if ($item->status == "0")
                            <button class='btn btn-primary processOrder' value='{{$item->id_hjual}}'>Process Order</button>
                            <button class="btn btn-danger invalidPayment" value='{{$item->id_hjual}}'>Payment Invalid</button>
                        @elseif($item->status == "1")
                            <button class="btn btn-primary finishOrder" value='{{$item->id_hjual}}'>Finish Order</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</main>
<script>
    $(document).ready(function(){
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
                    $.get('{{ url("admin/home/processOrder") }}',{id : id}, function(response) {
                        if(response == "Success"){

                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
        })
        $(document).on('click',".invalidPayment",function(e){
            Swal.fire({
                title: 'Apakah Pembayaraan Customer tidak valid?',
                showDenyButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
                }).then((result) => {
                if (result.isConfirmed) {

                }
            })
        })
    });
</script>
@endsection
