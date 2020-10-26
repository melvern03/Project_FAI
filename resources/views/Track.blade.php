@extends('Template')

@section('Title')
    Payment Page
@endsection

@section('Content')
@include('Navbar')
<div style="background-color:white;background-size:100%;;text-align: center;">
<div style="text-align: center;">
    <main role="main" class="container">
        <div class="jumbotron" style="opacity: 77%;margin-top:5%">
            <img src="{{url('Logo/Logo(title).png')}}" style="width: 10%;height: 10%;">
            <br>
            <h1 class="display-3">Thank You for Your Order</h1><br>
            Your Order will be proceed soon. Thank you for choosing
            <br>us for your personal style of fashion.
        </div>
    </main>
</div>


</div>
@include('footer')
@endsection
