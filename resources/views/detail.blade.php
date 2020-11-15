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
        <div class="container">
            <div class="row">
                <div class="col-md-6" style="text-align: left">
                    <img src="{{url('baju/'.$Hbaju[0]->gambar)}}" alt="">
                </div>
                <div class="col-md-6" style="text-align: left">
                    <img src="{{url('Logo/Logo(no title).png')}}" alt="ada" width="8%">
                    <h2>{{$Hbaju[0]->NAMA_BAJU}}</h2>
                    <h6>{{$Dbaju[0]->NAMA_BAJU}} - {{$kategori[0]->NAMA_KATEGORI}}</h6>
                    <span style="font-size: 18pt">Price: {{"Rp " . number_format($Hbaju[0]->harga,0,',','.')}}</span>
                    <form method="post" action="/detail/{{$Hbaju[0]->NAMA_BAJU}}/{dbaju}" name="variationForm">
                        @csrf
                        <select class="form-control" name="selectVarition" onchange="variationForm.submit();">
                            @foreach ($allDbaju as $item)
                                <option id="{{$item->id_dbaju}}" value="{{$item->id_dbaju}}">y</option>
                                <script>
                                    var n_match = ntc.name('<?php echo $item->WARNA ?>');
                                    n_rgb = n_match[0];
                                    n_name = n_match[1];
                                    n_exactmatch = n_match[2];
                                    var string = "<?php echo $item->id_dbaju ?>";
                                    $('#{!!$item->id_dbaju!!}').html("<?php echo $item->UKURAN ?>" + " - " +
                                        n_match[1]);
                                </script>
                            @endforeach
                        </select>
                    </form>
                    <br><br>
                    <button class="btn btn-success">Add to cart</button>
                </div>
            </div>
        </div>
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

<script>
    $(document).ready(function() {
        $(document).on('click', '.tambahCart', function (e) {
            var id = $(this).val();
            var idDbaju = $('#dBaju'+id).val();
            $.get('{{ url("/addToCart") }}',{idDbaju : idDbaju, idHbaju : id}, function(response) {
                alert("Berhasil Menambah barang ke cart");
            });
        });
    });
</script>
@endsection
