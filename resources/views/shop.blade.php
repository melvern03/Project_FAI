@extends('Template')

@section('Title')
    Men
@endsection

@section('Content')
<div style="background-color:white;background-size:100%;;text-align: center;">
    @include('Navbar')
    {{-- ================================================================================================================================= --}}
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-4" style="text-align: left"><div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Sort By
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                      <button class="dropdown-item" type="button">Action</button>
                      <button class="dropdown-item" type="button">Another action</button>
                      <button class="dropdown-item" type="button">Something else here</button>
                    </div>
                  </div>
            </div>
            <div class="col-md-4" style="text-align: center">Men</div>
            <div class="col-md-4" style="text-align: right">+filter</div>
        </div>
    </div>
    <hr>
    <br><br>
        <div style=" display: flex;flex-wrap: wrap;flex-direction: row;justify-content: space-evenly;">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="foto"><img src="{{asset('Product/Baju1.jpg')}}" class="card-img-top" alt="..." ></div>
                <br>
                <div class="body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6" style="text-align: left">
                                <img src="{{url('Logo/Logo(no title).png')}}" alt="ada" width="8%"><span style="font-weight: bold;font-size: 10pt">Cassy</span>
                            </div>
                            <div class="col-md-6" style="text-align: right">S M XL XLL</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" style="text-align: left">
                                <h4>nama baju</h4>
                             </div>
                             <div class="col-md-6" style="text-align: right">
                                warna - warna baju
                             </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" style="text-align: left">
                               <h6>price : </h6>
                             </div>
                             <div class="col-md-6" style="text-align: right">
                                <h5><a href="" class="btn btn-primary">Shop now</a></h5>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="foto"><img src="{{asset('Product/Baju2.jpg')}}" class="card-img-top" alt="..."></div>
                <br>
                <div class="body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6" style="text-align: left">
                                <img src="{{url('Logo/Logo(no title).png')}}" alt="ada" width="8%"><span style="font-weight: bold;font-size: 10pt">Cassy</span>
                            </div>
                            <div class="col-md-6" style="text-align: right">S M XL XLL</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" style="text-align: left">
                                <h4>nama baju</h4>
                             </div>
                             <div class="col-md-6" style="text-align: right">
                                warna - warna baju
                             </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" style="text-align: left">
                               <h6>price : </h6>
                             </div>
                             <div class="col-md-6" style="text-align: right">
                                <h5><a href="" class="btn btn-primary">Shop now</a></h5>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="foto"><img src="{{asset('Product/Baju3.jpg')}}" class="card-img-top" alt="..."></div>
                <br>
                <div class="body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6" style="text-align: left">
                                <img src="{{url('Logo/Logo(no title).png')}}" alt="ada" width="8%"><span style="font-weight: bold;font-size: 10pt">Cassy</span>
                            </div>
                            <div class="col-md-6" style="text-align: right">S M XL XLL</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" style="text-align: left">
                                <h4>nama baju</h4>
                             </div>
                             <div class="col-md-6" style="text-align: right">
                                warna - warna baju
                             </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" style="text-align: left">
                               <h6>price : </h6>
                             </div>
                             <div class="col-md-6" style="text-align: right">
                                <h5><a href="" class="btn btn-primary">Shop now</a></h5>
                             </div>
                        </div>
                    </div>
                </div>
            </div>


        {{-- <div class="card" style="width: 30rem;">
            <img src="{{asset('Product/Baju1.jpg')}}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Black Tees</h5>
                <hr>
                <br>
                Rp. 25.000 &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#" class="btn btn-primary">Shop Now</a>
            </div>
            </div>
            <div class="card" style="width: 30rem;">
            <img src="{{asset('Product/Baju2.jpg')}}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Upload Your Image - Edition</h5>
                <hr>
                <br>
                Rp. 45.000 &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#" class="btn btn-primary">Shop Now</a>
            </div>
            </div>
            <div class="card" style="width: 30rem;">
            <img src="{{asset('Product/Baju3.jpg')}}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Red World - Edition</h5>
                <hr>
                <br>
                Rp. 145.000 &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#" class="btn btn-primary">Shop Now</a>
            </div>
            </div> --}}
        </div>
    <br><br><br>
    {{-- ================================================================================================================================= --}}
    <br><br><br><br><br>
    @include('footer')
</div>
@endsection
