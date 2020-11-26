@extends('Template')
@extends('admin/navbar')
@section('Title')
    List Kategori
@endsection

@section('Content')
<main role="main" class="col-md-10 ml-sm-auto col-lg-11 px-md-4">
    <div id='mainContainer'>
        <h2>List Kategori</h2>
        <form action="/admin/Kategori/Add">
            <button class='btn btn-info'>Add New Kategori</button>
        </form>
        <table class="display" id='listKategory'>
            <thead>
                <td>Nama</td>
            </thead>
            <tbody>
                @foreach (DB::table('kategori')->get() as $item)
                <tr>
                    <td>{{$item->NAMA_KATEGORI}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
<script>
    $(document).ready(function(){
        $("#listKategory").DataTable();
    })
</script>
@endsection
