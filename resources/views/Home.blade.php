@extends('Template')

@section('Title')
    Home Page
@endsection

@section('Content')
<div style="background-color:white;background-size:100%;;text-align: center;">
    @include('Navbar')

    <section>
        {{-- Start Toast --}}
    <div class="toast" id="myToast" style="top: 0;right:0;margin:10px">
        <div class="toast-header">
            <strong class="mr-auto"><i class="fa fa-grav"></i>Sucess Login</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body" id='welcomeBody'>
            <div>Berhasil Login Welcome</div>
        </div>
    </div>
    {{-- End Toast --}}
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel" style="margin-bottom: 100px;">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
              <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="{{url('Promo/Promo1.jpg')}}" class="d-block w-100 " focusable="false" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <a class="btn btn-light" href="{{ route('shop') }}">Shop Now</a>
                    <br>
                </div>
              </div>
              <div class="carousel-item">
                <img src="{{url('Promo/Promo2.jpg')}}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <a class="btn btn-light" href="{{ route('shop') }}">Shop Now</a>
                    <br>
                </div>
              </div>
              <div class="carousel-item">
                <img src="{{url('Promo/Promo3.jpg')}}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <a class="btn btn-light" href="{{ route('shop') }}">Shop Now</a>
                    <br>
                </div>
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </section>
    {{-- ================================================================================================================================= --}}
    <div class="container">
        <h1 class="display-4" style="color:grey">New Arrival</h1>
        <hr>
        <section class="text-center">
            <div style=" display: flex;flex-wrap: nowrap;flex-direction: row;justify-content: space-evenly;">
                @php
                    $countNew = 1
                @endphp
                @if (count($newArrival) > 0)
                @foreach ($newArrival as $item)
                    @if ($countNew <= 3)
                    <div class="card" style="width: 30rem;">
                    <img src="{{url('baju/'.$item->gambar)}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{$item->nama}}</h5>
                            <hr><br>
                            <div class="row">
                                <div class="col-6">
                                    {{"Rp " . number_format($item->harga,0,',','.')}}
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-primary">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $countNew++
                    @endphp
                    @endif
                @endforeach
                @endif

            </div>
        </section>
        </div>
    </div>
    <br><br><br>
    {{-- ================================================================================================================================= --}}
    <div class="row" tyle="height: 100px;">
        <div class="col-6 mh-100" style="background-image: url('Promo/Layout1.jpg');background-size:100%;text-align: center;width: 100px; height: 760px;">
            <h1 class="display-3 align-bottom" style="color: white">Men</h1>
        </div>
        <div class="col-6 mh-100" style="background-image: url('Promo/Layout2.jpg');background-size:100%;text-align: center;width: 100px; height: 760px;">
            <h1 class="display-3 align-bottom" style="color: white">Woman</h1>
        </div>
    </div>
    {{-- ================================================================================================================================= --}}
    <br><br><br><br><br>
    @include('footer')
    <script>
        function notif(){
        $("#myToast").toast({ delay: 2000 });
        $("#myToast").toast('show');
    }
    </script>
</div>
@if (Session("success"))
<script type='text/javascript'>
    document.getElementById("welcomeBody").innerHTML = "Welcome {{Session('success')}}"
    notif()
</script>
@endif
@endsection
