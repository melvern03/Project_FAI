
@extends('Template')
@extends('admin/navbar')
@section('Title')
    Admin Register
@endsection

@section('Content')
<main role="main" class="col-md-10 ml-sm-auto col-lg-11 px-md-4">
    <h2>Register New Admin</h2>
    <form action="/admin/list">
        <button class='btn btn-primary'>Back</button>
    </form>
    <form action="/admin/addNewAdmin" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputCity">Name</label>
                <input type="text" name="Nama" class="form-control" id="inputName" value="{{old('Nama')}}">
            </div>
            <div class="form-group col-md-6">
                <label for="inputTelp">Phone Number</label>
                <input type="text" name="NoHp" class="form-control" id="inputTelp" value="{{old('NoHp')}}">
            </div>
            <div class="form-group col-md-6">
                <label for="inputUser">Username</label>
                <input type="text" name="Username" class="form-control" id="inputUser" value="{{old('Username')}}">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">Email</label>
                <input type="email" name="Email" class="form-control" id="inputEmail" value="{{old('Email')}}">
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail">Password</label>
                <input type="password" name="Password" class="form-control" id="inputPassword">
            </div>
            <div class="form-group col-md-6">
                <label for="inputConpas">Confirm Password</label>
                <input type="password" name="ConPass" class="form-control" id="inputConpas">
            </div>
        </div>
        <div class="form-group">
            <label>Jenis Kelamin</label><br>
            <input type="radio" id="male" name="gender" value="L">
            <label for="male">Laki Laki</label><br>
            <input type="radio" id="female" name="gender" value="F">
            <label for="female">Perempuan</label><br>
        </div>
        <div class="form-group">
            <label for="inputAddress">Address</label>
            <input type="text" name="Alamat" class="form-control" id="inputAddress" placeholder="Alamat"
                value="{{old('Alamat')}}">
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</main>
@endsection
