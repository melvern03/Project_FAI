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
    <table class="table display" id='listTrans'>
        <thead>
            <td>Nama User</td>
            <td>Grand Total</td>
            <td>Tanggal Transaksi</td>
            <td>Action</td>
        </thead>
        <tbody>
            @foreach (h_transaksi::where("status","0")->get() as $item)
                <tr>
                    <td>{{Users::where('id_user',$item->id_user)->value('nama_user')}}</td>
                    <td>{{"Rp. ".number_format($item->grand_total)}}</td>
                    <td>{{$item->tgl_jual}}</td>
                    <td>
                        <button class="btn btn-info">Show Bukti</button>
                        <button class="btn btn-success">Show Detail</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</main>
<script>
    $(document).ready(function(){
        $("#listTrans").DataTable();
    });
</script>
@endsection
