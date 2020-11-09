@extends('Template')

@section('Title')
    Men
@endsection

@section('Content')
<div style="background-color:white;background-size:100%;;text-align: center;">
    @include('Navbar')
    {{-- ================================================================================================================================= --}}
    <br>
    <br><br>
    <form action="" method="post">
        @csrf
        <div class="container">
            <div class="row">
                <div class="col-md-6" style="text-align: left">
                    <img src="{{url('product/baju1.jpg')}}" alt="">
                </div>
                <div class="col-md-6" style="text-align: left">
                    <img src="{{url('Logo/Logo(no title).png')}}" alt="ada" width="8%">
                    <h3>Nama Baju</h3>
                    <span style="font-size: 18pt">Price: </span>
                    <br>
                     Pilih warna
                    <br>
                    <span style="font-size: 11pt">size International</span>
                    <br>

                    <select name="ukuran" id="" >
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="XL">XL</option>
                        <option value="XLL">XLL</option>
                    </select>
                    <br><br>
                    <button class="btn btn-success">Add to cart</button>
                </div>
            </div>
        </div>
    </form>
    <br><br>
    <div class="container" style="text-align: center">
        <div class="row">
            <div class="col-md-4" style="text-align: left">
                <h6>Description</h6>
                <ul>
                    <li>Crew neck</li>
                    <li>Branding details</li>
                    <li>Straight hem</li>
                    <li>Manufacturer: China</li>
                    <li>Material: Shell 100% cotton</li>
                    <li>Care: Machine wash in warm water carefully. Do not bleach and tumble dry. Use a warm iron. Line dry in the shade.</li>
                </ul>
            </div>
            <div class="col-md-4" style="text-align: left">
                <h6>Delivery</h6>
                <p>Standard Delivery: Orders are delivered by DHL within <br>
                    4-6 business days, not inclusive of Public Holidays. <br>
                    More Info <br><br>

                    Returns & Exchange <br>
                    All sales are final. BAPEONLINE does not accept requests for cancellation of orders or the return of items. <br>
                    More Info</p>
            </div>
            <div class="col-md-4" style="text-align: left">
                <h6>share</h6>
                <img src="{{url('logo/fb_logo.png')}}" alt="tidak ada" width="8%">
                <img src="{{url('logo/ig_logo.png')}}" alt="tidak ada" width="8%">
                <br>
                <h6>View More</h6>
                <br>
                <p style="line-height: 3">
                    <a href="" class="btn btn-secondary" style="border-radius: 15px">Men</a> <br>
                    <a href="" class="btn btn-secondary" style="border-radius: 15px">Woman</a> <br>
                    <a href="" class="btn btn-secondary" style="border-radius: 15px">Jacket & Sweater</a> <br>
                    <a href="" class="btn btn-secondary" style="border-radius: 15px">T-Shirt</a> <br>
                </p>

            </div>
        </div>
    </div>
    {{-- ================================================================================================================================= --}}
    <br><br><br><br><br>
    @include('footer')
</div>
@endsection
