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
                        <button class='btn btn-danger deleteAdmin' value="{{$item->id_user}}" temp="{{$item->nama_user}}">Delete</button>
                        @if ($item->status == "Aktif")
                            <button class="btn btn-secondary disableAdmin" value="{{$item->id_user}}" temp="{{$item->nama_user}}">Disable Account</button>
                        @else
                            <button class="btn btn-primary enableAdmin" value="{{$item->id_user}}" temp="{{$item->nama_user}}">Enable Account</button>
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
        $(document).on('click','.deleteAdmin',function(e){
            var id = $(this).val();
            var namaAdmin = $(this).attr("temp");
            Swal.fire({
                title: 'Apakah anda yakin ingin menghapus '+namaAdmin+'?',
                showDenyButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
                }).then((result) => {
                if (result.isConfirmed) {
                    $.get('{{ url("admin/DeleteAdmin") }}',{id : id}, function(response) {
                        if(response == "Success"){
                            Swal.fire({
                                text: "Admin Berhasil di hapus",
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
        });
        $(document).on('click','.disableAdmin',function(e){
            var id = $(this).val();
            var namaAdmin = $(this).attr("temp");
            Swal.fire({
                title: 'Apakah anda yakin ingin disable '+namaAdmin+'?',
                showDenyButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
                }).then((result) => {
                if (result.isConfirmed) {
                    $.get('{{ url("admin/ChangeStatus") }}',{id : id,type:"Disable"}, function(response) {
                        if(response == "Success"){
                            Swal.fire({
                                text: "Status Admin Berhasil Diganti",
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
        });

        $(document).on('click','.enableAdmin',function(e){
            var id = $(this).val();
            var namaAdmin = $(this).attr("temp");
            Swal.fire({
                title: 'Apakah anda yakin ingin enable '+namaAdmin+'?',
                showDenyButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
                }).then((result) => {
                if (result.isConfirmed) {
                    $.get('{{ url("admin/ChangeStatus") }}',{id : id, type:"enable"}, function(response) {
                        if(response == "Success"){
                            Swal.fire({
                                text: "Status Admin Berhasil Diganti",
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
        });
    });
</script>
@endsection
