@extends('Template')

@section('Title')
Detail Transaksi
@endsection

@section('Content')
@include('Navbar')
@if (Session("dataDetail"))
<div class="jumbotron" style="border: 1px solid black;width:90%;margin:auto;margin-top:1%;background-color:white">
    <h2 align='center'>Detail Order</h2>
    <form action="/History">
        <button class="btn btn-info">Back To History Transaksi</button>
    </form><br>
    <table class='table display' id='displayDetail'>
        <thead class=''>
            <td>Nama Baju</td>
            <td>Harga</td>
            <td>Jumlah</td>
            <td>Subtotal</td>
        </thead>
        <tbody>
            @foreach (Session("dataDetail") as $item)
                <tr>
                    <td>{{DB::table('d_baju')->where('id_dbaju',$item->id_barang)->value('NAMA_BAJU')}}</td>
                    <td>{{"Rp. ".number_format($item->harga,0,',','.')}}</td>
                    <td>{{$item->qty}}</td>
                    <td>{{"Rp. ".number_format($item->subtotal,0,',','.')}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h4>Biaya Ongkir : {{"Rp. " . number_format(DB::table('h_jual')->where('id_hjual',Session("dataDetail")[0]->id_hjual)->value('grand_total') - DB::table('d_jual')->where("id_hjual",Session("dataDetail")[0]->id_hjual)->sum('subtotal'),0,',','.')}}</h3>
    <h3>Grand Total : {{"Rp. ".number_format(DB::table('h_jual')->where('id_hjual',Session("dataDetail")[0]->id_hjual)->value('grand_total'),0,',','.')}}</h4>
</div>
@else
<script>
    window.location = "{!! url('/') !!}";
</script>
@endif
<script>
    $(document).ready(function(){
        $("#displayDetail").DataTable();
    })
</script>
@endsection
