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
        <div class="container">
           <h5>jokoExample@gmail.com</h5>
           <br>
           <form style="text-align: left;">
            {{-- nama --}}
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Name </label>
              <div class="col-sm-10">
                <input type="text" name="" placeholder="Example Joko" class="form-control">
              </div>
            </div>
            <fieldset class="form-group">
              <div class="row">
                <legend class="col-form-label col-sm-2 pt-0">Gender</legend>
                <div class="col-sm-10">
                  <p>Gender</p>
              </div>
            </fieldset>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Alamat : </label>
                <div class="col-sm-10">
                  <input type="text" name="" placeholder="Example Joko" class="form-control">
                </div>
              </div><br>
            <div class="form-group row">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Change</button>
              </div>
            </div>
          </form>
        </div>
</div>


</div>
@include('footer')
@endsection
