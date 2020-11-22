@extends('Template')

@section('Title')
    Men
@endsection

@section('Content')
<div style="background-color:white;background-size:100%;;text-align: center;">
    @php
        Use App\Model\Review;
        Use App\Model\Users;
        $count = "0";
    @endphp
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
                    <h6 id='namaVariasiBaju'>{{$Dbaju[0]->NAMA_BAJU}} - {{$kategori[0]->NAMA_KATEGORI}}</h6>
                    <input id="idDbaju" type="hidden" value="{{$Dbaju[0]->id_dbaju}}">
                    <div class="d-flex flex-row">
                        <div id="warna" style="width: 30px; height: 25px; border-style: solid" class="mr-1"></div>
                        <div id="textWarna"></div>
                        <div id="tempUkuran">
                            - {{$Dbaju[0]->UKURAN}}</div>
                    </div>
                    <script>
                        var n_match = ntc.name('<?php echo $Dbaju[0]->WARNA ?>');
                        n_rgb = n_match[0];
                        n_name = n_match[1];
                        $('#textWarna').html(n_name);
                        $('#warna').css('background-color', n_rgb);
                    </script>
                    <span style="font-size: 18pt">Price: {{"Rp " . number_format($Hbaju[0]->harga,0,',','.')}}</span>
                    <select class="form-control mb-3" style="width: 50%" name="selectVarition" id="variationDetail">
                        @foreach ($allDbaju as $item)
                    <option id="{{$item->id_dbaju}}" value="{{$item->id_dbaju}}" deskripsi="{{$item->NAMA_BAJU}} - {{DB::table('kategori')->where('ID_KATEGORI',$item->ID_KATEGORI)->value('NAMA_KATEGORI')}}" ukuran="{{$item->UKURAN}}" warna="{{$item->WARNA}}">y</option>
                            <script>
                                var n_match = ntc.name('<?php echo $item->WARNA ?>');
                                n_rgb = n_match[0];
                                n_name = n_match[1];
                                n_exactmatch = n_match[2];
                                var string = "<?php echo $item->id_dbaju ?>";
                                $('#{!!$item->id_dbaju!!}').html("<?php echo $item->UKURAN ?>" + " - " + n_match[1]);
                            </script>
                        @endforeach
                    </select>
                    <button value={{$Hbaju[0]->ID_HBAJU}} type="submit" class="btn btn-primary tambahCart mr-1">Add To Cart</button>
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

    {{-- Review Section --}}


    @if (Auth::check())
    @if (Review::where('id_user',Auth::user()->id_user)->where('id_hbaju',$Hbaju[0]->ID_HBAJU)->count()>0)
    <br>
    <h2>Your Review</h2>
    <div>
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach (Review::where('id_user',Auth::user()->id_user)->where('id_hbaju',$Hbaju[0]->ID_HBAJU)->get() as $key => $item)
            <div class="carousel-item {{$key == 0 ? 'active' : '' }} bg-dark">
                <div class='text-white'>
                    <img src="{{url('/AssetReview/star'.$item->rating.'.png')}}" style="width: 25%;">
                    <p>Nama Variant : {{DB::table('d_baju')->where('id_dbaju',$item->id_baju)->value("NAMA_BAJU")}}<br>
                    {{$item->pesan}}</p>
                    <br>
                </div>
              </div>
            @endforeach

        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
    @endif
    <br>
    @if (Review::where('id_user',"!=",Auth::user()->id_user)->where('id_hbaju',$Hbaju[0]->ID_HBAJU)->count()>0)
        <h3>Reviews</h3>
        <div id="reviewOrang" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach (Review::orderBy('id','desc')->where('id_user',"!=",Auth::user()->id_user)->where('id_hbaju',$Hbaju[0]->ID_HBAJU)->take(10)->get() as $key => $item)
                <div class="carousel-item {{$key == 0 ? 'active' : '' }} bg-dark">
                    <div class='text-white'>
                        <img src="{{url('/AssetReview/star'.$item->rating.'.png')}}" style="width: 25%;">
                        <p>By : {{Users::where('id_user',$item->id_user)->value('nama_user')}}<br>
                        Nama Variant : {{DB::table('d_baju')->where('id_dbaju',$item->id_baju)->value("NAMA_BAJU")}}<br>
                        {{$item->pesan}}</p>
                        <br>
                    </div>
                </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#reviewOrang" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#reviewOrang" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
    @endif
    @else
    <h3>Reviews</h3>
    <div id="reviewOrang" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach (Review::orderBy('id','desc')->where('status_pesan','1')->where('id_hbaju',$Hbaju[0]->ID_HBAJU)->take(10)->get() as $key => $item)
            <div class="carousel-item {{$key == 0 ? 'active' : '' }} bg-dark">
                <div class='text-white'>
                    <img src="{{url('/AssetReview/star'.$item->rating.'.png')}}" style="width: 25%;">
                    <p>By : {{Users::where('id_user',$item->id_user)->value('nama_user')}}<br>
                    Nama Variant : {{DB::table('d_baju')->where('id_dbaju',$item->id_baju)->value("NAMA_BAJU")}}<br>
                    {{$item->pesan}}</p>
                    <br>
                </div>
            </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#reviewOrang" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#reviewOrang" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
    @endif


    {{-- End Review Section --}}

    <br><br><br><br><br>
    @include('footer')
</div>

<script>
    $(document).ready(function() {
        $(document).on('click', '.tambahCart', function (e) {
            var id = $(this).val();
            var idDbaju = $('#idDbaju').val();
            $.get('{{ url("/addToCart") }}',{idDbaju : idDbaju, idHbaju : id}, function(response) {
                if (response == 'sukses') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Barang berhasil di tambah',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }else if(response == 'error'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Harap login terlebih dahulu',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        });
        $(document).on('change',"#variationDetail",function(e){
            var desc = ($('option:selected', this).attr('deskripsi'));
            var ukuran = ($('option:selected', this).attr('ukuran'));
            var warna = ($('option:selected', this).attr('warna'));
            var id = ($('option:selected', this).attr('value'));
            var n_match = ntc.name(warna);
            $("#namaVariasiBaju").html(desc);
            $("#warna").css('background-color', warna);
            $("#textWarna").html(n_match[1]+" - "+ukuran)
            $("#tempUkuran").html("");
            $("#idDbaju").val(id);
        });
    });
</script>
@endsection
