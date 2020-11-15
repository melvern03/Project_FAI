@extends('Template')

@section('Title')
    Shop
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
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Sort By
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        @if (isset($kategori))
                            <form method="POST" action="/shop/{{$kategori}}/sort">
                        @else
                            <form method="POST" action="/shop/sort">
                        @endif
                        <form method="POST" action="/shop/sort">
                            @csrf
                            <button class="dropdown-item sortItem" type="submit" name="btnSort" value="tertinggi">Harga Tertinggi</button>
                            <button class="dropdown-item sortItem" type="submit" name="btnSort" value="terendah">Harga Terendah</button>
                            <button class="dropdown-item sortItem" type="submit" name="btnSort" value="terbaru">Terbaru</button>
                            <button class="dropdown-item sortItem" type="submit" name="btnSort" value="terlama">Terlama</button>
                        </form>
                    </div>
                </div>
            </div>
            @if (isset($kategori))
                <div class="col-md-4" style="text-align: center">{{$kategori}}</div>
            @else
                <div class="col-md-4" style="text-align: center">Shop</div>
            @endif
        </div>
    </div>
    <hr>
    <br><br>

    <div id="itemBarang" style=" display: flex;flex-wrap: wrap;flex-direction: row;justify-content: space-evenly;">
        @foreach ($Hbaju as $item)
        <div class="col-lg-4 col-md-6 col-12">
            <div class='card mb-3'>
                <div class="foto"><img src="{{url('baju/'.$item->gambar)}}" class="card-img-top" alt="..."></div>
                <br>
                <div class="body">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-6" style="text-align: left">
                                <img src="{{url('Logo/Logo(no title).png')}}" alt="ada" width="8%"><span
                                    style="font-weight: bold;font-size: 10pt">Cassy</span>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6" style="text-align: left">
                                <form method="POST" action="/detail/{{$item->NAMA_BAJU}}">
                                    @csrf
                                    <button type="submit" class="btn" value="{{$item->ID_HBAJU}}" name='btnDetail'><h4>{{$item->NAMA_BAJU}}</h4></button>
                                </form>
                            </div>
                            <div class="col-md-6" style="text-align: right">
                                <h4>{{"Rp " . number_format($item->harga,0,',','.')}}</h4>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-7" style="text-align: left">
                                <select class="form-control" id='dBaju{{$item->ID_HBAJU}}' class='variasiOption'>
                                    @foreach ($baju as $itemBaju)
                                        @if ($itemBaju->ID_HBAJU == $item->ID_HBAJU)
                                            <option id={{$itemBaju->id_dbaju}} value={{$itemBaju->id_dbaju}}></option>
                                        @endif
                                            <script>
                                                var n_match = ntc.name('<?php echo $itemBaju->WARNA ?>');
                                                n_rgb = n_match[0];
                                                n_name = n_match[1];
                                                n_exactmatch = n_match[2];
                                                var string = "<?php echo $itemBaju->id_dbaju ?>";
                                                $('#{!!$itemBaju->id_dbaju!!}').html("<?php echo $itemBaju->UKURAN ?>" + " - " +
                                                    n_match[1]);
                                            </script><br>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5" style="text-align: right">
                                <button value={{$item->ID_HBAJU}} type="submit" class="btn btn-primary tambahCart mr-1">Add To Cart</button>
                            </div>
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

