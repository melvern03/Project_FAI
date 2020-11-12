@extends('Template')
@extends('admin/navbar')
@section('Title')
    Admin List
@endsection

@section('Content')
<main role="main" class="col-md-10 ml-sm-auto col-lg-11 px-md-4">
    @if (Session('SuccessAdd'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Berhasil Add Admin Baru',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
<h1 style="margin:10px">Admin List</h1>
<form action="/admin/RegAdmin">
    <button class='btn btn-success'>Add New Admin</button>
</form>
    @php
        Use App\Model\Users;
    @endphp
    <table class="table display" id='listAdmin'>
        <thead>
            <td>Nama</td>
            <td>Jenis Kelamin</td>
            <td>Email</td>
            <td>Alamat</td>
            <td>No Hp</td>
            <td>Action</td>
        </thead>
        <tbody>
            @foreach (Users::where('jabatan','Admin')->get() as $item)
                <tr>
                    <td>{{$item->nama_user}}</td>
                    @if ($item->jk == "L")
                    <td>Laki Laki</td>
                    @else
                    <td>Perempuan</td>
                    @endif
                    <td>{{$item->email}}</td>
                    <td>{{$item->alamat}}</td>
                    <td>{{$item->no_telp}}</td>
                    <td>
                        <button class='btn btn-danger'>Delete</button>
                        @if ($item->status == "Aktif")
                            <button class="btn btn-secondary">Disable Account</button>
                        @else
                            <button class="btn btn-primary">Enable Account</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</main>
<script>
    $(document).ready(function(){
        $("#listAdmin").DataTable();
    });
</script>
@endsection
