@extends('Template')

@section('Title')
History
@endsection

@section('Content')
@include('Navbar')
@php
    Use App\Model\h_transaksi;
    Use App\Model\Users;
    Use App\Model\Review;
@endphp
<div style="background-color:white;background-size:100%;">
    <div style="text-align: center;" id='historyMainContainer'>
        <img src="{{url('Logo/Logo(title).png')}}" style="width: 10%;height: 10%;">
        <br>
        <h1 class="display-3">Your Transaction History</h1><br><br>
        <div class="container">
            <table class="table display" id="listHistoryTrans">
                <thead class="thead-dark">
                    <td>ID Order</td>
                    <td>Tanggal Transaksi</td>
                    <td>Grand Total</td>
                    <td>Status</td>
                    <td>Action</td>
                </thead>
                <tbody>
                    @foreach (h_transaksi::where('id_user',Auth::User()->id_user)->get() as $item)
                    <tr>
                        <td>{{$item->id_hjual}}</td>
                        <td>{{$item->tgl_jual}}</td>
                        <td>{{"Rp " . number_format($item->grand_total,0,',','.')}}</td>
                        @if ($item->status=="0")
                            <td class='bg-secondary text-white'>Menunggu Verifikasi</td>
                        @elseif($item->status == "1")
                            <td class="bg-success text-white">Order In Process</td>
                        @elseif($item->status=="2")
                            <td class="bg-primary text-white">Order Finish</td>
                        @elseif($item->status == "3")
                            <td class="bg-danger text-white">Pembayaran Tidak Valid</td>
                        @elseif($item->status=="4")
                            <td class="bg-info text-white">Order Sent</td>
                        @endif
                        <td>
                            <form action="/getDataDetail" method="POST" style="display: inline-block">
                                @csrf
                                <button class='btn btn-success' name="detailTrans" value='{{$item->id_hjual}}'>Show Detail</button>
                            </form>
                            @if ($item->status == "3")
                            <button class='btn btn-info uploadNew' value="{{$item->id_hjual}}">Upload Bukti Transfer Baru</button>
                            @elseif($item->status == "4")
                                <button class="btn btn-info confirmOrder" value="{{$item->id_hjual}}">Order Recieve</button>
                            @elseif($item->status=="2" && Review::where('id_user',Auth::user()->id_user)->where('id_order',$item->id_hjual)->where('status_pesan','0')->count() > 0)
                                <form action="/getDataForReview" method="POST" style="display: inline-block">
                                    @csrf
                                    <button class="btn btn-info text-white" name="idReview" value="{{$item->id_hjual}}">Give Review</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<form action="/uploadNewFile" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal" tabindex="-1" role="dialog" id="empModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
@if (Session("succes"))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Upload Success',
            text: 'Berhasil mengupload bukti baru silahkan menunggu verifikasi'
        })
    </script>
@endif
@if (Session("reviewDone"))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Review Done',
        text: 'Terima kasih sudah memberikan kami review'
    })
</script>
@endif
<script>
    $(document).ready(function () {
        $("#listHistoryTrans").DataTable();
        $(document).on('click', ".uploadNew", function (e) {
            var id = $(this).val();
            var dom = `
            <input type="file" name='newTransfer' class="form-group" required>
            <input type='hidden' name='idTrans' value='`+id+`'>
            `;
            $(".modal-body").html(dom);
            $('#empModal').modal('show');
        })
        $(document).on('click',".confirmOrder",function(e){
            Swal.fire({
                title: 'Apakah order anda sudah sampai?',
                showDenyButton: true,
                icon: 'question',
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
                }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).val();
                    $.get('{{ url("/OrderFinishUser") }}',{id : id}, function(response) {
                        if (response == 'success') {
                            Swal.fire({
                                text: 'Barang sudah diterima, Jangan lupa untuk memberikan review',
                                icon: 'success',
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            })
                        }
                    });
                }
            })
        })
    })
</script>
<br><br><br>
@include('footer')
@endsection
