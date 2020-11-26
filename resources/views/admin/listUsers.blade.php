@extends('Template')
@extends('admin/navbar')
@section('Title')
    List Users
@endsection

@section('Content')
<main role="main" class="col-md-10 ml-sm-auto col-lg-11 px-md-4">
    @php
        Use App\Model\Users;
    @endphp
<div id="MainContainer">
<h2>List Users</h2>
<table class="display" id='listUsers'>
    <thead>
        <td>Nama</td>
        <td>Jenis Kelamin</td>
        <td>Email</td>
        <td>Alamat</td>
        <td>Nomor Handphone</td>
        <td>Action</td>
    </thead>
    <tbody>
        @foreach (Users::where("jabatan","Member")->get() as $item)
        <tr>
            <td>{{$item->nama_user}}</td>
            @if ($item->jk == "L")
                <td>Laki - Laki</td>
            @else
            <td>Perempuan</td>
            @endif
            <td>{{$item->email}}</td>
            <td>{{$item->alamat}}</td>
            <td>{{$item->no_telp}}</td>
            <td align='center'>
                <button class="btn btn-danger deleteUsers" value="{{$item->id_user}}" temp="{{$item->nama_user}}">Delete User</button>
                @if ($item->status == "Aktif")
                    <button class="btn btn-dark statChange" tipe="blacklist" temp="{{$item->nama_user}}" value="{{$item->id_user}}">Blacklist User</button>
                @elseif($item->status=="Blacklist")
                    <button class="btn btn-secondary statChange" tipe="unblacklist" temp="{{$item->nama_user}}" value="{{$item->id_user}}">Unblacklist User</button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
<script>
    $(document).ready(function(){
        $("#listUsers").DataTable();
        $(document).on('click',".deleteUsers",function(e){
            var id = $(this).val();
            var nama = $(this).attr("temp");
            Swal.fire({
                title: 'Apakah anda ingin menghapus user '+nama+' ?',
                showDenyButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.get('{{ url("admin/listUsers/DeleteUser") }}',{id : id}, function(response) {
                        if(response == "Success"){
                            Swal.fire({
                                text: "User Deleted",
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
        $(document).on("click",".statChange",function(e){
            var id = $(this).val();
            var nama = $(this).attr("temp");
            if($(this).attr('tipe') == "blacklist"){
                Swal.fire({
                title: 'Apakah anda ingin blacklist user '+nama+'?',
                showDenyButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
                }).then((result) => {
                if (result.isConfirmed) {
                    $.get('{{ url("admin/listUsers/statusChange") }}',{id : id,type:"blacklist"}, function(response) {
                        if(response == "Success"){
                            Swal.fire({
                                text: "User Status Change",
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
            }else if($(this).attr('tipe') == "unblacklist"){
                Swal.fire({
                title: 'Apakah anda ingin unblacklist user '+nama+'?',
                showDenyButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
                }).then((result) => {
                if (result.isConfirmed) {
                    $.get('{{ url("admin/listUsers/statusChange") }}',{id : id,type:"unblacklist"}, function(response) {
                        if(response == "Success"){
                            Swal.fire({
                                text: "User Status Change",
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
            }
        });
    });
</script>
@endsection
