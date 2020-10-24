@extends('Template')
@section('Title')
Log In Page
@endsection
@section('Content')
<div style="background-image: url(Bg-2.jpg);width: 100%; height: 100%;background-size:cover;">
    @include('Navbar')
    <div style="text-align: center;">
        <br>
        <br>
        <main role="main" class="container">
            <div class="jumbotron" style="opacity: 77%;">
              <img src="{{url('Logo/Logo(title).png')}}" style="width:10%;height:10%;">
              <br>
              <h1 class="display-1">Log In</h1><br>
              <form action="">
                @csrf
                    <div class="form-group">
                      <label for="exampleInputEmail1">Username</label>
                      <input type="email" name="" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Password</label>
                      <input type="password" name="" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="form-group form-check">
                      <input type="checkbox" class="form-check-input" id="exampleCheck1">
                      <label class="form-check-label" for="exampleCheck1">Remember Me</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Log In</button>
              </form>
              <br>
              <hr>
              <br>
              Havent had an account? <a href="">click here for Register.</a><br>
              <a href="">Forget Password</a>
            <br>
            </div>
          </main>
          <br>
          <br>
          <br>
  </div>
@endsection
