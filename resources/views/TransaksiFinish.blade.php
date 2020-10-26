@extends('Template')

@section('Title')
    Finish Payment Page
@endsection

@section('Content')
@include('Navbar')
<div style="background-color:white;background-size:100%;;text-align: center;">
<div style="text-align: center;">
    <main role="main" class="container">
        <div class="jumbotron" style="opacity: 77%;margin-top:5%">
            <img src="{{url('Logo/Logo(title).png')}}" style="width: 10%;height: 10%;">
            <br>
            <h1 class="display-3">Thank You for Shopping with Us</h1><br>
            Please Kindly put your review about our services. <br><br>
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Your Review</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div><br>
              <button class="btn btn-primary">Submit</button><br><br>
              <button class="btn btn-danger">Close</button>
        </div>
    </main>
</div>


</div>
@include('footer')
@endsection
