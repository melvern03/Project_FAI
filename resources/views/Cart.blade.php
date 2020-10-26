@extends('Template')

@section('Title')
    Payment Page
@endsection

@section('Content')
@include('Navbar')
<div style="background-color:white;background-size:100%;;text-align: center;">
<br>
<img src="{{url('Logo/Logo(title).png')}}" style="width: 10%;height: 10%;">
<br>
<div style="text-align: left">
    <p class="h1">Transaction</p><br>
    <h3>
        Your Items<small class="text-muted"> Cart</small>
    </h3>
</div>
    <hr>
    {{-- ==============================Jdul======================================================= --}}
    <div style=" display: flex;flex-wrap: nowrap;flex-direction: row;justify-content: space-evenly;">
        <div class="card" style="width: 10rem;">
            <img src="{{asset('Product/Baju1.jpg')}}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Black Tees</h5>
                <hr>
                Detail : <br>
                $45.00 <br>
                White <br>
                M - 1 <br>
                <a href="#" class="btn btn-danger">Remove</a>
            </div>
            </div>
            <div class="card" style="width: 10rem;">
            <img src="{{asset('Product/Baju2.jpg')}}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Upload Your Image - Edition</h5>
                <hr>
                Detail : <br>
                $15.00 <br>
                Black <br>
                L - 2 <br>
                <a href="#" class="btn btn-danger">Remove</a>
            </div>
            </div>
            <div class="card" style="width: 10rem;">
            <img src="{{asset('Product/Baju3.jpg')}}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Red World - Edition</h5>
                <hr>
                Detail : <br>
                $45.00 <br>
                Red <br>
                XL - 1 <br>
                <a href="#" class="btn btn-danger">Remove</a>
            </div>
        </div>
    </div>
    <br><br>
    <div style="background-color: cornsilk;text-align:center;">
        <br>
        <h1 class="display-3">Shipping Method</h1><br>
    <div class="container" >
        <div class="card-deck mb-3 text-center">
            <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Grab</h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title">$1</h1>
                <ul class="list-unstyled mt-3 mb-4">
                <li>4-5 hours Work days</li>
                <li>Avalaible Only For Surabaya Region</li>
                <li><small class="text-muted">Order above 14.00 pm will be delivered tomorow</small></li>
                </ul>
                <button type="button" class="btn btn-lg btn-block btn-primary">Choose</button>
            </div>
            </div>
            <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Jne Express</h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title">$5</h1>
                <ul class="list-unstyled mt-3 mb-4">
                <li>4-5 Shipment Work days</li>
                <li>Avalaible for All region</li>
                </ul>
                <button type="button" class="btn btn-lg btn-block btn-primary">Choose</button>
            </div>
            </div>
            <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Si Cepat</h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title">$10</h1>
                <ul class="list-unstyled mt-3 mb-4">
                    <li>1 Shipment Work days</li>
                    <li>Avalaible for All region</li>
                </ul>
                <button type="button" class="btn btn-lg btn-block btn-primary">Choose</button>
            </div>
            </div>
        </div>
    </div>
    <br><br>
</div>
<div style="text-align: center;">
    <main role="main" class="container">
        <div class="jumbotron" style="opacity: 77%;margin-top:5%">
            <br>
            <h1 class="display-3">Your Data</h1><br>
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
                        <label for="inputPassword4">Email</label>
                        <input type="email" name="Email" class="form-control" id="inputEmail" value="{{old('Email')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin : Laki Laki</label><br>
                </div>
                <div class="form-group">
                    <label for="inputAddress">Address</label>
                    <input type="text" name="Alamat" class="form-control" id="inputAddress" placeholder="Alamat" value="{{old('Alamat')}}">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCity">Kode Pos</label>
                        <input type="text" name="Nama" class="form-control" id="inputName" value="{{old('Nama')}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputTelp">Region</label>
                        <input type="text" name="NoHp" class="form-control" id="inputTelp" value="{{old('NoHp')}}">
                    </div>

                </div>


                <div class="form-row">
                    {{-- <div class="form-group col-md-4">
                        <label>Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tgl_lahir">
                    </div> --}}
                </div>
                <button type="submit" class="btn btn-success">Proceed</button>
            </form>
        </div>
    </main>
</div>


</div>
@include('footer')
@endsection
