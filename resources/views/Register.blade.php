@extends('Template')
@section('Title')
Register
@endsection
@section('Content')
<div style="width: 100%; height: 100%;background-size:cover;">
    @include('Navbar')
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h4 align="center">Errors</h4>
        <ul>
        @foreach ($errors->all() as $item)
            <li>{{ $item }}</li>
        @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div style="text-align: center;">
        <main role="main" class="container">
            <div class="jumbotron" style="opacity: 77%;margin-top:5%">
                <img src="{{url('Logo/Logo(title).png')}}" style="width:10%;height:10%;">
                <br>
                <h1 class="display-1">Register</h1><br>
                <form action="/regCheck" method="POST">
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
                        <input type="text" name="Alamat" class="form-control" id="inputAddress" placeholder="Alamat" value="{{old('Alamat')}}">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" name="Terms" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Accept All Terms and Condition
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
                <hr>
                Already had an account? <a href="/login">click here for Log In.</a><br>
                <br>
            </div>
        </main>
    </div>
@endsection

