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
            <label>Name</label><br>
            <label>Address</label><br>
            <label>Email</label><br>
            <label>Phone</label><br>
            <label>Shipping Method</label><br>
            <label>Your Items : </label><br>
            <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                  </tr>
                </tbody>
              </table>
              <br>
              <h3>Grand Total : </h3>
              <br>Please kindly transfer <br>
               in this Number : 10111101010111
              <br><hr>
              <h6>Please Kindly Upload Your Transaction Proof</h6><br>
              <br>
              <button class="btn btn-primary">Choose</button> Choose your file...
              <br><br><br>
              <button class="btn btn-danger">Cancel</button>&nbsp;&nbsp;&nbsp;<button class="btn btn-success">Proceed <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-truck" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
              </svg></button>
              <br><br><br>
              <h5><small class="text-muted">If you already proceed, you cannot cancel your transaction.</small></h5>
        </div>
    </main>
</div>


</div>
@include('footer')
@endsection
