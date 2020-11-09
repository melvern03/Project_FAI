@extends('Template')

@section('Title')
    Payment Page
@endsection

@section('Content')
@include('Navbar')
@php
    $cek = "";
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

    <div style=" display: flex;flex-wrap: nowrap;flex-direction: row;justify-content: space-evenly;">
        @if (Session::has('cart'))
            @foreach (Session::get('cart') as $key => $item)
                @if ($key == Auth::user()->nama_user)
                @php
                    $cek = "ada";
                @endphp
                    @foreach ($item as $databaju)
                    <div class="card" style="width: 20rem;">
                        <img src="{{url('baju/'.DB::table('h_baju')->where('ID_HBAJU',$databaju['id_hbaju'])->value('gambar'))}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{DB::table('d_baju')->where('id_dbaju',$databaju['id_dbaju'])->value('NAMA_BAJU')}}</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    Detail :
                                </div>
                                <div class="col-md-6">
                                    {{"Rp. ".number_format(DB::table('h_baju')->where('ID_HBAJU',$databaju['id_hbaju'])->value('harga'))}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">Color :</div>
                                <div class="col-md-6" ><div class="kotak" style="width: 40px;height: auto ;background-color: {{DB::table('d_baju')->where('id_dbaju',$databaju['id_dbaju'])->value('WARNA')}};"><br></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">Size : </div>
                                <div class="col-md-6">{{DB::table('d_baju')->where('id_dbaju',$databaju['id_dbaju'])->value('UKURAN')}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">Quantity</div>
                                <div class="col-md-6">{{$databaju['qty']}}</div>
                            </div>

                            <a href="#" class="btn btn-danger">Remove</a>
                        </div>
                    </div>
                    @endforeach
                @endif
            @endforeach
        @endif

    </div>
    @if ($cek == "")
    <br>
        <h2 align='center'>Cart Anda Masih Kosong</h2>
    @else
    <div style="background-color: cornsilk;text-align:center;">
        <br>
        <h1 class="display-3">Shipping Method</h1><br>
        <div class="container">
            <div class="card-deck mb-3 text-center">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">Grab</h4>
                    </div>
                    <div class="card-body">
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
                        <h4 class="my-0 font-weight-normal">Jne Express</h4>
                    </div>
                    <div class="card-body">
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
                        <h4 class="my-0 font-weight-normal">Si Cepat</h4>
                    </div>
                    <div class="card-body">
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
@endsection
