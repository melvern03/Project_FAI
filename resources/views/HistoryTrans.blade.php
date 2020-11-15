@extends('Template')

@section('Title')
History
@endsection

@section('Content')
@include('Navbar')
@php
    Use App\Model\h_transaksi;
    Use App\Model\Users;
@endphp
<div style="background-color:white;background-size:100%;;text-align: center;">
<div style="text-align: center;">
    <img src="{{url('Logo/Logo(title).png')}}" style="width: 10%;height: 10%;">
    <br>
    <h1 class="display-3">Your Transaction History</h1><br><br>
    <div class="container">
    <table class="table display" id="listHistoryTrans">
        <thead class="thead-dark">
            <td>Tanggal Transaksi</td>
            <td>Grand Total</td>
            <td>Status</td>
            <td>Action</td>
        </thead>
        <tbody>
            @foreach (h_transaksi::where('id_user',Auth::User()->id_user)->get() as $item)
                <tr>
                    <td>{{$item->tgl_jual}}</td>
                    <td>{{"Rp " . number_format($item->grand_total,0,',','.')}}</td>
                    @if ($item->status=="0")
                        <td class='bg-secondary text-white'>Menunggu Verifikasi</td>
                    @elseif($item->status == "1")
                        <td class="bg-success text-white">Order In Process</td>
                    @elseif($item->status == "3")
                        <td class="bg-danger text-white">Pembayaran Tidak Valid</td>
                    @endif
                    <td>
                    <button class='btn btn-success'>Show Detail</button>
                        @if ($item->status == "3")
                            <button class='btn btn-info uploadNew' value="{{$item->id_hjual}}">Upload Bukti Transfer Baru</button>
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
    })
</script>
<br><br><br>
@include('footer')
@endsection
