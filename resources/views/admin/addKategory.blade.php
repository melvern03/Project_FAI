@extends('Template')
@extends('admin/navbar')
@section('Title')
    Add New
@endsection

@section('Content')
<main role="main" class="col-md-10 ml-sm-auto col-lg-11 px-md-4">
    @if ($errors->any())
        <script>
            Swal.fire(
                'Input Error',
                'Nama Kategori tidak boleh mengandung angka',
                'error'
            )
        </script>
    @endif
    @if (Session("errorDup"))
        <script>
            Swal.fire(
                'Input Error',
                'Nama Kategori Sudah Terdaftar',
                'error'
            )
        </script>
    @endif
    @if (Session("Success"))
        <script>
            Swal.fire(
                'Add Success',
                'Berhasil menambahkan kategori baru',
                'success'
            )
        </script>
    @endif
    <div id='mainContainer'>
        <h2>Add New Kategori</h2>
        <form action="/admin/Kategori">
            <button class='btn btn-info'>Back To List Kategori</button>
        </form>
        <form method="POST" action="/admin/Kategori/Add/AddNew">
            @csrf
            <div class="form-group" style="width: 50%">
                <label for="NamaKategori">Nama Kategori</label>
                <input type="text" name="NamaKategori" class="form-control" id="inputName" value="{{old('NamaKategori')}}" required>
            </div>
            <button class='btn btn-success'>Add New Kategori</button>
        </form>
    </div>
</main>
@endsection
