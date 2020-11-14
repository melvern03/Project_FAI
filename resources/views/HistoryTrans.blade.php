@extends('Template')

@section('Title')
History Page
@endsection

@section('Content')
@include('Navbar')
<div style="background-color:white;background-size:100%;;text-align: center;">
<div style="text-align: center;">
    <img src="{{url('Logo/Logo(title).png')}}" style="width: 10%;height: 10%;">
    <br>
    <h1 class="display-3">Your Transaction History</h1><br><br>
    <div class="container">
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
            {{-- Your Content --}}
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
          </tr>
        </tbody>
      </table>
    </div>
</div>
</div>
<br><br><br>
@include('footer')
@endsection
