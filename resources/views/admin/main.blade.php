@extends('Template')
@extends('admin/navbar')
@section('Title')
    Home
@endsection

@section('Content')
<main role="main" class="col-md-10 ml-sm-auto col-lg-11 px-md-4">
    <h2>List Baju</h2>
    <form action="/admin/addBaju">
        <button type="submit" class="btn btn-success">Add New Model Baju</button>
    </form>
    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>Nama Model</th>
                <th>Harga</th>
                <th>Tanggal Keluar</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if (DB::table("h_baju")->get()->count() > 0)
            @foreach (DB::table("h_baju")->get() as $item)
            <tr>
                <td>{{$item->NAMA_BAJU}}</td>
                <td>{{"Rp " . number_format($item->harga,0,',','.')}}</td>
                <td>{{$item->time_added}}</td>
                <td>
                    <form method="GET" class="showDetail">
                        <button class="btn btn-info detailBtn" name='id_model' value="{{$item->ID_HBAJU}}"
                            type="submit">Show Variant</button>
                    </form>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td>Data Kosong</td>
            </tr>
            @endif
        </tbody>
    </table>
    <br>
    <div class="tableVariant">
        <h3>Model Variant</h3>
        <table class='table display' id='variantTable'>
            <thead>
                <tr>
                    <th>Nama Variant</th>
                    <th>Ukuran</th>
                    <th>Warna</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="variant_body">

            </tbody>
        </table>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="empModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Data Baju</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id='isiModal'>
                    <div class="modal-body" id='editModalBody'>

                    </div>
                </form>
                <div class="modal-footer">
                    <button type="submit" class='btn btn-info btnEdit'>Edit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    {{-- 2nd Modal --}}
    <div class="modal fade" id="deleteModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id='isiDeleteModal'>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus variant baju ?
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="submit" class='btn btn-info btnEdit'>Delete</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function () {
        $('#table_id').DataTable();
        $(".tableVariant").hide();
        $(".showDetail").submit(function (e) {
            e.preventDefault();
            var nama = $(this).find(".detailBtn").val();
            $.get('{{ url("admin/home/variant") }}',{nama : nama}, function(response) {
                $(".tableVariant").hide();
                var dom = "";
                response.data.forEach(el => {
                    var n_match = ntc.name(el.WARNA);
                    dom += `<tr>
                        <td>`+el.NAMA_BAJU+`</td>
                        <td>`+el.UKURAN+`</td>
                        <td style='background-color:`+n_match[0]+`;border:2px solid black'></td>
                        <td>`+el.STOK+`</td>
                        <td>
                            <button type='submit' class='btn btn-danger hapusData' value=`+el.id_dbaju+` data='`+el.NAMA_BAJU+`'>Delete</button>
                            <button type='submit' class='btn btn-warning editModel' value=`+el.id_dbaju+`>Edit</button>
                        </td>
                    </tr>`;
                });
                if (response.data.length <= 0) {
                    dom += "<tr><td>Tidak ada data ditemukan</td></tr>";
                }
                $(".tableVariant").show('slow');
                $("#variant_body").html(dom);
            });
        });
        $(document).on('click', '.editModel', function (e) {
            var id = $(this).val();
            $.get('{{ url("admin/home/getDataBaju") }}',{nama : id}, function(response) {
                // $(".tableVariant").hide();
                // $('#variant_table').DataTable().ajax.reload();
                // var dom = "";
                // response.data.forEach(el => {
                //     var n_match = ntc.name(el.WARNA);
                //     dom += ``;
                // });
                // $("#editModalBody").html(dom);
                // $('#empModal').modal('show');

            });
        });
        $(document).on('click', '.hapusData', function (e) {
            var id = $(this).val();
            var nama= $(this).attr("data");
            $('#deleteModal').modal('show');
        });
    });
</script>
@endsection
