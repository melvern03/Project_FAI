@extends('Template')

@section('Title')
    Payment Page
@endsection

@section('Content')
@include('Navbar')
@php
    $cek = "";
    use App\Model\Promo;
@endphp
<div style="background-color:white;background-size:100%;;text-align: center;">
<br>
<img src="{{url('Logo/Logo(title).png')}}" style="width: 10%;height: 10%;">
<br>
<div style="text-align: left">
    <p class="h1">Transaction</p><br>
    <h3>
        Your Items<small class="text-muted"> Cart</small>
    </h3>
    <hr>
</div>
    <div style="width: 90%;margin:auto">
        @if (Session::has('cart'))
        <table class='table-striped display' id='listCart' align='center'>
            <thead>
                <td>Gambar</td>
                <td>Nama</td>
                <td>Kategori</td>
                <td>Warna</td>
                <td>Size</td>
                <td>Harga</td>
                <td>Jumlah</td>
                <td>Sub Total</td>
            </thead>
            <tbody>
                @foreach (Session::get('cart') as $key => $item)
                    @if ($key == Auth::user()->nama_user)
                        @php
                            $cek = "ada";
                        @endphp
                        @foreach ($item as $databaju)
                            <tr>
                                <td><img src="{{url('baju/'.DB::table('h_baju')->where('ID_HBAJU',$databaju['id_hbaju'])->value('gambar'))}}" class="card-img-top" alt="..." style="width:150px;height:150px"></td>
                                <td>{{DB::table('d_baju')->where('id_dbaju',$databaju['id_dbaju'])->value('NAMA_BAJU')}}</td>
                                <td>{{DB::table('kategori')->where("ID_KATEGORI",DB::table('d_baju')->where('id_dbaju',$databaju['id_dbaju'])->value('ID_KATEGORI'))->value('NAMA_KATEGORI')}}</td>
                                <td><div style="background-color: {{DB::table('d_baju')->where('id_dbaju',$databaju['id_dbaju'])->value('WARNA')}};border:3px solid black;width:50px;height:50px;margin:auto"></div></td>
                                <td>{{DB::table('d_baju')->where('id_dbaju',$databaju['id_dbaju'])->value('UKURAN')}}</td>
                                <td>{{"Rp. ".number_format(DB::table('h_baju')->where('ID_HBAJU',$databaju['id_hbaju'])->value('harga'),0,',','.')}}</td>
                                <td>
                                <button class='btn btn-danger KurangiItem' id='remove{{$databaju['id_dbaju']}}' temp="{{DB::table('h_baju')->where('ID_HBAJU',$databaju['id_hbaju'])->value('harga')}}" style="margin-right:10px" value='{{$databaju['id_dbaju']}}'><i class="fas fa-minus"></i></button>
                                    <span id="jumlah{{$databaju['id_dbaju']}}">{{$databaju['qty']}}</span>
                                    <button class='btn btn-success addMoreItem' id='add{{$databaju['id_dbaju']}}' style="margin-left:10px" temp="{{DB::table('h_baju')->where('ID_HBAJU',$databaju['id_hbaju'])->value('harga')}}" value='{{$databaju['id_dbaju']}}'><i class="fas fa-plus"></i></button>
                                </td>
                                <td><span id='subtotal{{$databaju['id_dbaju']}}'>{{"Rp. ".number_format($databaju['qty'] * DB::table('h_baju')->where('ID_HBAJU',$databaju['id_hbaju'])->value('harga'),0,',','.')}}</span></td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>

        @endif
    </div>
    @if ($cek == "")
    <script>
        $("#listCart").hide();
    </script>
    <br>
        <h2 align='center'>Cart Anda Masih Kosong</h2>
    @else
<div class='form-group' style="margin:auto;width:50%">
    <label for="exampleFormControlSelect1" style="font-size: 18pt">Promo</label>
    <select id='promoPicker' class="form-control">
        @if (Session::has('promo'))
            @php
                echo "<option>No Promo</option>";
                $promo = Session::get('promo');
                if(array_key_exists(Auth::user()->nama_user,$promo)){
                    foreach (Promo::where("tgl_start","<=",date("Y/m/d"))->where('tgl_end',">=",date("Y/m/d"))->get() as $key => $value) {
                        if($promo[Auth::user()->nama_user] == $value->id_promo){
                            echo "<option value='$value->id_promo' selected>$value->nama_promo - Discount $value->diskon_promo%</option>";
                        }else{
                            echo "<option value='$value->id_promo'>$value->nama_promo - Discount $value->diskon_promo%</option>";
                        }

                    }
                }else{
                    foreach (Promo::where("tgl_start","<=",date("Y/m/d"))->where('tgl_end',">=",date("Y/m/d"))->get() as $key => $value) {
                        echo "<option value='$value->id_promo'>$value->nama_promo - Discount $value->diskon_promo%</option>";
                    }
                }
            @endphp
        @else
            @php
                 echo "<option disabled hidden selected>No Promo</option>";
                    foreach (Promo::where("tgl_start","<=",date("Y/m/d"))->where('tgl_end',">=",date("Y/m/d"))->get() as $key => $value) {
                        echo "<option value='$value->id_promo'>$value->nama_promo - Discount $value->diskon_promo%</option>";
                    }
            @endphp
        @endif
    </select>
</div>
<br>
<script>
    $(document).ready(function(){
        $("#listCart").DataTable({searching:false});
    })
</script>
    <div style="background-color: cornsilk;text-align:center;">
        <br>
        <h1 class="display-3">Shipping Method</h1><br>
        <div class="container">
            <div class="card-deck mb-3 text-center">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">Instant</h4>
                    </div>
                    <div class="card-body">
                        <img src="{{url('/AssetCart/Instant.png')}}" style="height: 150px;width:325px">
                        <h1 class="card-title pricing-card-title">Rp. 5.000</h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>4-5 hours Work days</li>
                            <li>Avalaible Only For Surabaya Region</li>
                            <li><small class="text-muted">Order above 14.00 pm will be delivered tomorow</small></li>
                        </ul>
                        <a href="/pilih/GRAB/5000" class="btn btn-lg btn-block btn-primary">Choose</a>
                    </div>
                </div>
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">Normal Shipment</h4>
                    </div>
                    <div class="card-body">
                        <img src="{{url('/AssetCart/Normal.png')}}" style="height: 150px;width:325px">
                        <h1 class="card-title pricing-card-title">Rp. 10.000</h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>4-5 Shipment Work days</li>
                            <li>Avalaible for All region</li>
                        </ul>
                        <a href="/pilih/JNE/10000" class="btn btn-lg btn-block btn-primary">Choose</a>
                    </div>
                </div>
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">One Day Delivery</h4>
                    </div>
                    <div class="card-body">
                        <img src="{{url('/AssetCart/SameDay.png')}}" style="height: 150px;width:325px">
                        <h1 class="card-title pricing-card-title">Rp. 15.000</h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>1 Shipment Work days</li>
                            <li>Avalaible for All region</li>
                        </ul>
                        <a href="/pilih/Si Cepat/15000" class="btn btn-lg btn-block btn-primary">Choose</a>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
    </div>
    @endif
</div>
<br><br>
@include('footer')
<script>
    $(document).ready(function(){
        $(document).on('click','.addMoreItem',function(){
            var id = $(this).val();
            var harga = $(this).attr('temp');
            $.get('{{ url("/addJumlahCart") }}',{id : id}, function(response) {
                $("#jumlah"+id).text(response);
                $("#subtotal"+id).text("Rp. "+new Intl.NumberFormat('ID').format(response * harga));
            });
        })

        $(document).on('click', '.KurangiItem', function () {
            var id = $(this).val();
            var harga = $(this).attr('temp');
            if ($("#jumlah" + $(this).val()).text() == "1") {
                Swal.fire({
                    title: 'Anda ingin yakin menghapus barang tersebut dari Cart?',
                    showDenyButton: true,
                    confirmButtonText: `Yes`,
                    denyButtonText: `No`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Saved!', '', 'success')
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })
            }else{
                $.get('{{ url("/minusJumlahCart") }}',{id : id}, function(response) {
                    $("#jumlah"+id).text(response);
                    $("#subtotal"+id).text("Rp. "+new Intl.NumberFormat('ID').format(response * harga));
                });

            }
        })

        $(document).on("change","#promoPicker",function(){
            var id = $(this).val();
            $.get('{{ url("/addPromoCode") }}',{id : id}, function(response) {

            });
        })
    })
</script>
@endsection
