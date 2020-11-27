@extends('Template')
@extends('admin/navbar')
@section('Title')
    List Promo
@endsection

@section('Content')
<main role="main" class="col-md-10 ml-sm-auto col-lg-11 px-md-4">
    @php
        Use App\Model\Promo;
    @endphp
    <h2>List Promo</h2>
    <form action='/admin/Promo/Add'>
        <button class='btn btn-info'>Add New Promo</button>
    </form>
    <table class="table-striped display" id='listPromo'>
        <thead>
            <td>Nama Promo</td>
            <td>Diskon Promo</td>
            <td>Maximal Diskon</td>
            <td>Tanggal Promo Start</td>
            <td>Tanggal Promo End</td>
            <td>Action</td>
        </thead>
        <tbody>
            @foreach (Promo::all() as $item)
                <tr>
                    <td>{{$item->nama_promo}}</td>
                    <td>{{$item->diskon_promo}}%</td>
                    <td>{{"Rp. ".number_format($item->maximal_diskon,0,',','.')}}</td>
                    <td>{{$item->tgl_start}}</td>
                    <td>{{$item->tgl_end}}</td>
                    <td>
                        <button class='btn btn-info editPromo'>Edit</button>
                        <button class='btn btn-danger promoDelete' value='{{$item->id_promo}}'>Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</main>
<script>
    $(document).ready(function(){
        $("#listPromo").DataTable();
    })
</script>
@endsection
