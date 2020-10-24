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
              <h1 class="display-1">Register</h1><br>
              <form action="">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputUser">Username</label>
                      <input type="text" name="UserBaru" class="form-control" id="inputUser">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputPassword4">Email</label>
                      <input type="email" name="EmailBaru" class="form-control" id="inputEmail">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputConpas">Confirm Password</label>
                      <input type="password" name="ConPass" class="form-control" id="inputConpas">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputEmail">Password</label>
                      <input type="password" name="PassBaru" class="form-control" id="inputPassword4">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputTelp">Phone Number</label>
                      <input type="text" name="TelpBaru" class="form-control" id="inputTelp">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputAddress">Address</label>
                    <input type="text" name="AlamatBaru" class="form-control" id="inputAddress" placeholder="1234 Main St">
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputCity">Name</label>
                      <input type="text" name="NamaBaru" class="form-control" id="inputCity">
                    </div>
                    <div class="form-group col-md-2">
                      <label for="inputAge">Age</label>
                      <input type="text" name="UmurBaru" class="form-control" id="inputAge">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-check">
                      <input class="form-check-input" name="Terms" type="checkbox" id="gridCheck">
                      <label class="form-check-label" for="gridCheck">
                          Accept All Terms and Condition
                      </label>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Sign in</button>
              </form>
              <br>
              <hr>
              <br>
              Already had an account? <a href="">click here for Log In.</a><br>
            <br>
            </div>
          </main>
          <br>
          <br>
          <br>
  </div>
@endsection
