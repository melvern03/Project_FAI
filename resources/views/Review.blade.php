@extends('Template')

@section('Title')
Review
@endsection

@section('Content')
@include('Navbar')
@php
    Use App\Model\h_transaksi;
    Use App\Model\Users;
    Use App\Model\Review;
@endphp
<div class="jumbotron" style="border: 1px solid black;width:90%;margin:auto;margin-top:1%">
@if (!Session("data"))
<script>
    window.location = "{!! url('/') !!}";
</script>
@else
<form action="/addReview" method="POST">
    @csrf
@foreach (Session("data") as $item)
    <h3>{{DB::table('d_baju')->where('id_dbaju',$item->id_baju)->value('NAMA_BAJU')}}</h3>
    <input type='hidden' name='idOrder[]' value='{{$item->id_order}}'>
    <input type='hidden' name='idBaju[]' value='{{$item->id_baju}}'>
    <div class="form-group">
        <label for="formControlRange">Rating</label>
        <input type="range" class="rating" name="ratingStar[]" min="1" max="5" value='1' tempid="{{$item->id_baju}}">
        <span id='text{{$item->id_baju}}'>1</span><i class="fa fa-star" aria-hidden="true" style="margin-left:3px;color:gold"></i>
    </div>
    <div class="form-group">
        <label for="exampleFormControlTextarea1">Your Review</label>
        <textarea class="form-control" name="reviewOrang[]" rows="3" required></textarea>
    </div>
    <hr>
    @endforeach
    <button type="submit" class='btn btn-success' style="float: right">Give Review</button>
</form>
@endif
</div>
<script>
    $(document).ready(function(){
        $(document).on('change','.rating',function(e){
            document.getElementById("text"+$(this).attr("tempid")).innerHTML = $(this).val();
        })
    })
</script>
@endsection
