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
            <div class="col-md-4" style="text-align: left">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenu2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort By
                    </button>
                    @php
                    if(isset($kategori)){
                    echo "<form method='POST' action='/shop/sortBy/{$kategori}'>";
                        }else{
                        echo "<form method='POST' action='/shop/sortBy'>";
                            }
                            @endphp
                            @csrf
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <button class="dropdown-item" type="submit" name="btnSort" value="tertinggi">Harga
                                    Tertinggi</button>
                                <button class="dropdown-item" type="submit" name="btnSort" value="terendah">Harga
                                    Terendah</button>
                                <button class="dropdown-item" type="submit" name="btnSort"
                                    value="terbaru">Terbaru</button>
                                <button class="dropdown-item" type="submit" name="btnSort"
                                    value="terlama">Terlama</button>
                            </div>
                        </form>
                </div>
            </div>
            <div class="col-md-4" style="text-align: center">Men</div>
        </div>
    </div>
    <hr>
    <br><br>
    <div style=" display: flex;flex-wrap: wrap;flex-direction: row;justify-content: space-evenly;">
        @foreach ($baju as $item)
        <div class="col-lg-4 col-md-6 col-12">
            <div class="foto"><img src="{{url('baju/'.$item->gambar)}}" class="card-img-top" alt="..."></div>
            <br>
            <div class="body">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-6" style="text-align: left">
                            <img src="{{url('Logo/Logo(no title).png')}}" alt="ada" width="8%"><span
                                style="font-weight: bold;font-size: 10pt">Cassy</span>
                        </div>
                        <div class="col-md-6" style="text-align: right">{{$item->ukuran}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="text-align: left">
                            <h4>{{$item->nama}}</h4>
                        </div>
                        <div class="col-md-6" style="text-align: right" id="{{$item->ID_DBAJU}}">
                            <script type="text/javascript">
                                var n_match = ntc.name('<?php echo $item->warna ?>');
                                n_rgb = n_match[0]; // RGB value of closest match
                                n_name = n_match[1]; // Text string: Color name
                                n_exactmatch = n_match[2]; // True if exact color match
                                document.getElementById("<?php echo $item->ID_DBAJU ?>").innerHTML = n_match[1];
                            </script><br>
                            <div id="kotak {{$item->ID_DBAJU}}" style="width: 35px;height:25px;float:right;margin:10px;border:3px solid black">
                                <script type="text/javascript">
                                    var n_match = ntc.name('<?php echo $item->warna ?>');
                                    var string = "kotak <?php echo $item->ID_DBAJU ?>";
                                    document.getElementById(string).style.backgroundColor = n_match[0];
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6" style="text-align: left">
                            <h6>Price : {{"Rp " . number_format($item->harga,0,',','.')}}</h6>
                        </div>
                        <div class="col-md-6" style="text-align: right">
                            <h5><a href="" class="btn btn-primary">Shop now</a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <br><br><br>
    {{-- ================================================================================================================================= --}}
    <br><br><br><br><br>
    @include('footer')
</div>
@endsection
