@extends('Template')

@section('Title')
    Payment Page
@endsection

@section('Content')
@include('Navbar')
<div style="background-color:white;background-size:100%;;text-align: center;">
<div style="text-align: center;">
    <main role="main" class="container">
        <div class="jumbotron" style="opacity: 77%;margin-top:5%">
            <img src="{{url('Logo/Logo(title).png')}}" style="width: 10%;height: 10%;">
            <br>
            <h1 class="display-3">Your Order</h1><br>
            <small class="text-muted">Please Finish Your Transaction</small><br>
            @if (Auth::check())
             <label>{{Auth::User()->nama_user}}</label> <br>
            <label>{{DB::table('user')->where('nama_user',Auth::User()->nama_user)->value('alamat')}}</label> <br>
            <label>{{DB::table('user')->where('nama_user',Auth::User()->nama_user)->value('email')}}</label> <br>
            <label>{{DB::table('user')->where('nama_user',Auth::User()->nama_user)->value('no_telp')}}</label><br>
            @endif
            @if (Session::has('kirim'))
                <label>Shipping Method : {{Session::get('kirim')}}</label><br>
            @endif
            <br>
            <label>Your Items : </label><br>
            <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Nama Baju</th>
                    <th scope="col">qty</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Total</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                       $subtotal = 0;
                    @endphp
                    @if (Session::has('cart'))
                        @foreach (Session::get('cart') as $key => $item)
                            @if ($key==Auth::User()->nama_user)
                                @foreach ($item as $databaju)
                                <tr>
                                    <td scope="row">{{DB::table('d_baju')->where('id_dbaju',$databaju['id_dbaju'])->value('NAMA_BAJU')}}</td>
                                    <td>{{$databaju['qty']}}</td>
                                    <td> {{"Rp. ".number_format(DB::table('h_baju')->where('ID_HBAJU',$databaju['id_hbaju'])->value('harga'))}}</td>
                                    <td>
                                       {{"Rp. ".number_format(($databaju['qty'] * DB::table('h_baju')->where('ID_HBAJU',$databaju['id_hbaju'])->value('harga')))}}
                                    </td>
                                    @php
                                        $subtotal += ($databaju['qty'] * DB::table('h_baju')->where('ID_HBAJU',$databaju['id_hbaju'])->value('harga'));
                                    @endphp
                                </tr>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                </tbody>
              </table>
              <br>
              @php
                   if (Session::get('kirim')=="GRAB")
                    {
                        $subtotal += 5000;
                    }
                    else if (Session::get('kirim')=="JNE")
                    {
                        $subtotal += 10000;
                    }
                    else{
                        $subtotal += 15000;
                    }
              @endphp
              <h2>Biaya Ongkir : {{"Rp. ".number_format(Session::get('harga'))}}</h2>
            <h3>Grand Total : {{"Rp. ".number_format($subtotal)}}</h3>
              <br>Please kindly transfer <br>
               in this Number : 10111101010111
              <br><hr>
              <h6>Please Kindly Upload Your Transaction Proof</h6><br>
              <br>
              <form action="/checkout" method="post">
                @csrf
                <input type="file" class="btn btn-primary" name="file">
                <br>
                @error('file')
                    <span class="invalid-input-mess" style="color: red">{{$message}}</span>
                @enderror
              <br><br><br>
              <div class="row">
                  <div class="col-md-6" style="text-align: right"><a href="/cart" class="btn btn-danger">Cancel</a></div>
                  <div class="col-md-6" style="text-align: left"><button type="submit" class="btn btn-success">Proced</button></div>
              </div>
            </form>
              <br><br><br>
              <h5><small class="text-muted">If you already proceed, you cannot cancel your transaction.</small></h5>
        </div>
    </main>
</div>


</div>
@include('footer')
@endsection
