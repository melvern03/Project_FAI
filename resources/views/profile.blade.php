@extends('Template')

@section('Title')
    Profile
@endsection

@section('Content')
@include('Navbar')
<div style="background-color:white;background-size:100%;;text-align: center;">
<div style="text-align: center;">
    <br><img src="{{url('Logo/Logo(title).png')}}" style="width: 15%;height: 15%;">
        <br>
        <h1 class="display-3">Profile</h1><br>
        <div class="container mb-5">
           <h5>{{$user[0]->email}}</h5>
           <br>
            {{-- nama --}}
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: end">Name :</label>
              <div class="col-sm-9">
                <input type="text" value="{{$user[0]->nama_user}}" name="" class="form-control" readonly>
              </div>
              <button type="button" class="btn btn-primary col-sm-1" data-toggle="modal" data-target="#nameModal">Change</button>
            </div>
            <fieldset class="form-group">
              <div class="row">
                <legend class="col-form-label col-sm-2 pt-0" style="text-align: end">Gender :</legend>
                <div class="col-sm-10" style="text-align: start">
                    @if ($user[0]->jk == 'L')
                        <p>Male</p>
                    @else
                        <p>Female</p>
                    @endif
                </div>
              </div>
            </fieldset>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: end">Address : </label>
                <div class="col-sm-9">
                    <input type="text" value="{{$user[0]->alamat}}" name="" class="form-control" readonly>
                </div>
                <button type="button" class="btn btn-primary col-sm-1" data-toggle="modal" data-target="#alamatModal">Change</button>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label" style="text-align: end">Phone number : </label>
                <div class="col-sm-9">
                    <input type="text" value="{{$user[0]->no_telp}}" name="" class="form-control" readonly>
                </div>
                <button type="button" class="btn btn-primary col-sm-1" data-toggle="modal" data-target="#nomorModal">Change</button>
            </div>
            <button type="button" class="btn btn-primary col-sm-3" data-toggle="modal" data-target="#passModal">Change Password</button>
        </div>
</div>
<form method="POST" action="/profile/nama_user">
    @csrf
    <div class="modal fade" id="nameModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Change Name</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" style="text-align: end">Name :</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{$user[0]->nama_user}}" name="namaUser" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="btnUbah" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </div>
    </div>
</form>
<form method="POST" action="/profile/alamat">
    @csrf
    <div class="modal fade" id="alamatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Change Address</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" style="text-align: end">Address :</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{$user[0]->alamat}}" name="alamatUser" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="btnUbah" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </div>
    </div>
</form>
<form method="POST" action="/profile/no_telp">
    @csrf
    <div class="modal fade" id="nomorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Change Phone Number</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" style="text-align: end">Phone Number :</label>
                    <div class="col-sm-8">
                      <input type="text" value="{{$user[0]->no_telp}}" name="telpUser" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="btnUbah" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </div>
    </div>
</form>
<form method="POST" action="/profile/password">
    @csrf
    <div class="modal fade" id="passModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Change Phone Number</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label" style="text-align: end">Old Password :</label>
                    <div class="col-sm-7">
                      <input type="password" name="oldPass" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label" style="text-align: end">New Password :</label>
                    <div class="col-sm-7">
                      <input type="password" name="newPass" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label" style="text-align: end">Confirm Password :</label>
                    <div class="col-sm-7">
                      <input type="password" name="cPass" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="btnUbah" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </div>
    </div>
</form>

</div>
@include('footer')
@if (Session("success"))
<script>
    Swal.fire({
        icon: 'success',
        title: '{!!Session("success")!!}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@elseif(Session("err"))
<script>
    Swal.fire({
        icon: 'error',
        title: '{!!Session("err")!!}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

@endsection
