@extends('Template')

@section('Title')
    Home Page
@endsection

@section('Content')
@php
    Use App\Model\Promo;
    use Illuminate\Support\Carbon;
@endphp
<div style="background-color:white;background-size:100%;;text-align: center;">
    @include('Navbar')
    <section>
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel" style="margin-bottom: 100px;">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{url('Promo/default1.jpg')}}" class="d-block w-100 " focusable="false" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <a class="btn btn-light" href="{{ route('shop') }}">Shop Now</a>
                        <br>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{url('Promo/default2.jpg')}}" class="d-block w-100 " focusable="false" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <a class="btn btn-light" href="{{ route('shop') }}">Shop Now</a>
                        <br>
                    </div>
                </div>
                @foreach (Promo::where("tgl_start","<=",date("Y/m/d"))->where('tgl_end',">=",date("Y/m/d"))->get() as $item)
                    <div class="carousel-item">
                        <img src="{{url($item->gambar)}}" class="d-block w-100 " focusable="false" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <a class="btn btn-light" href="{{ route('shop') }}">Shop Now</a>
                            <br>
                        </div>
                    </div>
                @endforeach
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
                    <div class="card" style="width: 30rem;margin:0 5px">
                    <img src="{{url('baju/'.$item->gambar)}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{$item->nama}}</h5>
                            <hr><br>
                            <div class="row">
                                <div class="col-6">
                                    {{"Rp " . number_format($item->harga,0,',','.')}}
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('shop') }}" class="btn btn-primary">Shop Now</a>
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
    <br><br><br>
    @include('footer')
    <script>
        function notif(){
        $("#myToast").toast({ delay: 2000 });
        $("#myToast").toast('show');
    }
    </script>
</div>
@if (Session("success"))
<script>
    let timerInterval
Swal.fire({
  title: 'Login Success',
  html: 'Welcome {!! Auth::User()->nama_user !!}',
  timer: 1500,
  willOpen: () => {
    timerInterval = setInterval(() => {
      const content = Swal.getContent()
      if (content) {
        const b = content.querySelector('b')
        if (b) {
          b.textContent = Swal.getTimerLeft()
        }
      }
    }, 100)
  },
  onClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
})
</script>
@endif
@endsection
