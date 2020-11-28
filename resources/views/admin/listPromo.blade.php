@extends('Template')
@extends('admin/navbar')
@section('Title')
    List Promo
@endsection

@section('Content')
<main role="main" class="col-md-10 ml-sm-auto col-lg-11 px-md-4">
    @if (Session("SuccessAddPromo"))
        <script>
            Swal.fire(
                'Add Successfull',
                'Berhasil Menambahkan Promo Baru',
                'success'
            )
        </script>
    @endif
    @php
        Use App\Model\Promo;
    @endphp
    <h2>List Promo</h2>
    <form action='/admin/Promo/Add'>
        <button class='btn btn-info'>Add New Promo</button>
    </form>
    <table class="table-striped display" id='listPromo'>
        <thead>
            <td>Nama Promo</td>
            <td>Diskon Promo</td>
            <td>Maximal Diskon</td>
            <td>Tanggal Promo Start</td>
            <td>Tanggal Promo End</td>
            <td>Action</td>
        </thead>
        <tbody>
            @foreach (Promo::all() as $item)
                <tr>
                    <td>{{$item->nama_promo}}</td>
                    <td>{{$item->diskon_promo}}%</td>
                    <td>{{"Rp. ".number_format($item->maximal_diskon,0,',','.')}}</td>
                    <td>{{$item->tgl_start}}</td>
                    <td>{{$item->tgl_end}}</td>
                    <td>
                        <button class='btn btn-info editPromo' value='{{$item->id_promo}}'>Edit</button>
                        <button class='btn btn-danger promoDelete' value='{{$item->id_promo}}' temp='{{$item->nama_promo}}'>Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Modal Edit --}}
    <div class="modal fade " id="empModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Promo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id='isiModal'>
                    <div class="modal-body" id='editModalBody'>

                    </div>
                </form>
                <div class="modal-footer">
                    <button type="submit" class='btn btn-info' id="btnConfirmEdit">Edit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function(){
        $("#listPromo").DataTable();
        //Function Edit Prom
        $(document).on("click",'.editPromo',function(){
            var id = $(this).val();
            var dom="";
            $.get('{{ url("admin/Promo/GetdataPromo") }}',{id: id}, function(response) {
                var data = JSON.parse(response);
                for(var i = 0; i < data.length; i++) {
                    var obj = data[i];
                    $("#btnConfirmEdit").attr("value",obj.id);
                    dom+=`
                    <div class="form-group col-md-6">
                        <label for="NamaPromo">Nama Promo</label>
                        <input type="text" name="NamaPromo" class="form-control" value='`+obj.nama+`' id='NewNama'>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="DiskonPromo">Diskon (%)</label>
                        <input type="number" name="DiskonPromo" class="form-control" min='1' max='100' value="`+obj.diskon+`" id='NewDiskon'>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tgl_start">Tanggal Promo Start</label>
                        <input class="form-control" type="date" name='tgl_start' value="`+obj.tgl_start+`" id='new_tgl_start'>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="tgl_end">Tanggal Promo End</label>
                        <input class="form-control" type="date" name='tgl_end' value="`+obj.tgl_end+`"id='new_tgl_end'>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="MaxDiskon">Maximal Diskon</label>
                        <input type="number" name="MaxDiskon" class="form-control" min='0' value="`+obj.max+`" id='NewMax'>
                    </div>
                    `;
                }
                $("#editModalBody").html(dom);
                $('#empModal').modal('show');
            });
        })
        $("#btnConfirmEdit").click(function () {
            var id = $(this).val();
            Swal.fire({
                title: 'Apakah anda yakin ingin menyimpan perubahan promo?',
                showDenyButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
            }).then((result) => {
                if (result.isConfirmed) {
                    var tglStart = $("#new_tgl_start").val();
                    var tglEnd = $("#new_tgl_end").val();
                    var nama = $("#NewNama").val();
                    var diskon = $("#NewDiskon").val();
                    var max = $("#NewMax").val();
                    console.log(tglStart+"-"+tglEnd)
                    if(tglEnd <= tglStart){
                        Swal.fire('Edit Errors', 'Tanggal Promo selesai Harus lebih besar dari Tanggal Promo mulai', 'error')
                    }else if(diskon > 100){
                        Swal.fire('Edit Errors', 'Maximal Diskon 100%', 'error')
                    }
                    else{
                        alert(diskon);
                        $.get('{{ url("admin/Promo/editPromo") }}', {
                            id: id,
                            nama: nama,
                            tglStart: tglStart,
                            tglEnd: tglEnd,
                            diskon: diskon,
                            max: max
                        }, function (response) {
                            if (response == "success") {
                                swal.fire({
                                    title: "Edit Successfull",
                                    text: "Berhasil Edit Promo",
                                    icon: "success"
                                }).then(function () {
                                    location.reload();
                                });
                            }
                        });
                    }
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
        });
        //End Function Edit Promo

        $(document).on('click', ".promoDelete", function () {
            var id = $(this).val();
            var nama = $(this).attr('temp');
            Swal.fire({
                title: 'Apakah anda ingin menghapus Promo '+nama+'?',
                showDenyButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.get('{{ url("admin/Promo/DeletePromo") }}', {
                        id: id
                    }, function (response) {
                        if (response == "success") {
                            swal.fire({
                                title: "Delete Successfull",
                                text: "Berhasil Mengahpus Promo",
                                type: "success"
                            }).then(function () {
                                location.reload();
                            });
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
        })
    })
</script>
@endsection
