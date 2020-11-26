@extends('Template')
@extends('admin/navbar')
@section('Title')
    Home
@endsection

@section('Content')
<main role="main" class="col-md-10 ml-sm-auto col-lg-11 px-md-4">
    @if (Session("errors"))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Errors',
                text: 'Terjadi Kesalahan Silahkan Coba Lagi'
            })
        </script>
    @endif
    @if (Session("variantDone"))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Berhasil Menambah Variant Baju',
                showConfirmButton: false,
                timer: 2000
            })
        </script>
    @endif
<div id="containerModel">
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
</div>
    <br>
    <div id="containerVariant">

    </div>

    {{-- Modal --}}
    <div class="modal fade " id="empModal" role="dialog">
        <div class="modal-dialog modal-lg">
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
                    <button type="submit" class='btn btn-info' id="btnConfirmEdit">Edit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    {{-- 2nd Modal --}}
    <div class="modal fade" id="deleteModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form>
                    <div class="modal-body" id="isiDeleteModal">
                        Apakah anda yakin ingin menghapus variant baju ?
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="submit" class='btn btn-info' id="btnDeleteModal">Delete</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Confirm Edit --}}
    <div class="modal fade" id="editConfirmModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm Edit</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form>
                    <div class="modal-body" id="isiConfrimEdit">
                        Apakah anda yakin ingin menghapus variant baju ?
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="submit" class='btn btn-info' id='confirmVariantEdit'>Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id='backEditModal'>No</button>
                </div>
            </div>
        </div>
    </div>
<input type="hidden" value='' id='tempKategoriData'>
</main>
<script>
    $(document).ready(function () {
        $('#table_id').DataTable();
        $("#containerVariant").hide();
        $(".showDetail").submit(function (e) {
            e.preventDefault();
            var tempId = "";
            var nama = $(this).find(".detailBtn").val();
            $.get('{{ url("admin/home/variant") }}',{nama : nama}, function(response) {
                $("#containerVariant").hide();
                var dom=`<h3>Model Variant</h3>
                <span>
                <button type='submit' id='backToListModel' class='btn btn-primary'>Back</button>
                <form action='home/AddVariant' method='POST'>
                    @csrf
                    <button type='submit' id='addVariantBaju' class='btn btn-success' name='idBtn'>Add New Variant</button>
                </form>
                </span><br><br>
                <table class='table display' id='variantTable'>
            <thead>
                <tr>
                    <th>Nama Variant</th>
                    <th>Ukuran</th>
                    <th>Warna</th>
                    <th>Stock</th>
                    <th>Kategori</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>`;
            var data = JSON.parse(response)
            for(var k in data) {
                tempId = data[k]['ID_HBAJU'];
                var n_match = ntc.name(data[k]["WARNA"]);
                var Kategori = data[k]["NAMA_KATEGORI"];
                dom+= `<tr>
                        <td>`+data[k]["NAMA_BAJU"]+`</td>
                        <td>`+data[k]["UKURAN"]+`</td>
                        <td style='background-color:`+n_match[0]+`;border:2px solid black'></td>
                        <td>`+data[k]["STOK"]+`</td>
                        <td>`+Kategori+`</td>
                        <td>
                            <button type='submit' class='btn btn-danger hapusData' value=`+data[k]["id_dbaju"]+` data='`+data[k]["NAMA_BAJU"]+`'>Delete</button>
                            <button type='submit' class='btn btn-warning editModel' value=`+data[k]["id_dbaju"]+`>Edit</button>
                        </td>
                    </tr>`
                }
                if (JSON.parse(response).length <= 0) {
                    dom += "<tr><td>Tidak ada data ditemukan</td></tr>";
                }
                dom += `</tbody></table>`;
                $("#containerModel").hide();
                $("#containerVariant").show('slow');
                $("#containerVariant").html(dom);
                $("#addVariantBaju").attr("value",tempId);
                $("#variantTable").DataTable();
            });
        });

        $(document).on('click',"#backToListModel",function(e){
            e.preventDefault();
            $("#containerModel").show('slow');
            $("#containerVariant").hide();

        })

        // Edit Model Function
        $(document).on('click', '.editModel', function (e) {
            var id = $(this).val();
            $.get('{{ url("admin/home/getDataBaju") }}',{nama : id}, function(response) {
                var dom = "";
                var ukuran = "";
                var Kategori = "";
                response.data.forEach(el => {
                    $("#btnConfirmEdit").attr("value",el.id_dbaju);
                    ukuran = el.UKURAN;
                    Kategori = el.ID_KATEGORI;
                    dom += `
                    <div class="form-group col-md-6">
                        <label for="inputCity">Nama Variasi</label>
                        <input type="text" id="namaVar" class="form-control" value="`+el.NAMA_BAJU+`">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputCity">Ukuran</label>
                        <select class='form-control' id='ukuranVar' style='width: 200px;' readonly>
                            <option value='XS' id="XS">XS</option>
                            <option value='S' id="S">S</option>
                            <option value='M' id="M">M</option>
                            <option value='L' id="L">L</option>
                            <option value='XL' id="XL">XL</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputCity">Warna</label>
                        <input type='color' id='colorVar' placeholder='Warna Baju' class='form-control color_list' value='`+el.WARNA+`'>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputCity">Stock</label>
                        <input type="number" id="stokVar" class="form-control" value="`+el.STOK+`">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputCity">Kategori</label>
                        <select class='form-control' id='kategoriVar' style='width: 200px;' readonly>
                            <option value='1' id="kat1">Man T-Shirt</option>
                            <option value='2' id="kat2">Woman T-Shirt</option>
                            <option value='3' id="kat3">Man Jacket & Sweater</option>
                            <option value='4' id="kat4">Woman Jacket & Sweater</option>
                        </select>
                    </div>
                    `;
                });
                $("#editModalBody").html(dom);
                $("#"+ukuran).attr("selected",true);
                $("#kat"+Kategori).attr("selected",true);
                $('#empModal').modal('show');

            });
        });
        $("#btnConfirmEdit").click(function(){
            var id = $(this).val();
            $.get('{{ url("admin/home/getDataBaju") }}',{nama : id}, function(response) {
                var dom = "";
                response.data.forEach(el => {
                $("#confirmVariantEdit").attr('value',el.id_dbaju);
                    dom += `Apakah anda yakin ingin menyimpan perubahan variant baju `+el.NAMA_BAJU+` ?`;
                });
                $("#isiConfrimEdit").html(dom);
                $('#editConfirmModal').modal('show');
                $("#empModal").modal("hide");
            });
        });

        $("#confirmVariantEdit").click(function(){
            var id = $(this).val();
            var nama = $("#namaVar").val();
            var warna = $("#colorVar").val();
            var stok = $("#stokVar").val();
            var ukuran = $("#ukuranVar").val();
            var kategori = $("#kategoriVar").val();
            $.get('{{ url("admin/home/editVariant") }}',{id : id,nama:nama,warna:warna,stok:stok,ukuran:ukuran, kategori:kategori}, function(response) {
                if(response == "succes"){
                    swal.fire({title: "Edit Successfull", text: "Berhasil Edit Variant Baju", type:
                        "success"}).then(function(){
                            location.reload();
                        }
                    );
                }
            });
        });
        $("#backEditModal").click(function(){
            $('#editConfirmModal').modal('hide');
            $("#empModal").modal("show");
        });

        // End Edit Model Function

        //Delete Model Function
        $(document).on('click', '.hapusData', function (e) {
            var id = $(this).val();
            $.get('{{ url("admin/home/getDataBaju") }}',{nama : id}, function(response) {
                var dom = "";
                response.data.forEach(el => {
                $("#btnDeleteModal").attr("value",el.id_dbaju);
                    dom += `Apakah anda yakin ingin menghapus variant baju `+el.NAMA_BAJU+` ?`;
                });
                $("#isiDeleteModal").html(dom);
                $('#deleteModal').modal('show');

            });
        });

        $("#btnDeleteModal").click(function(){
            var id = $(this).val();
            $.get('{{ url("admin/home/deleteVariant") }}',{nama : id}, function(response) {
                if(response == "succes"){
                    swal.fire({title: "Delete Successfull", text: "Berhasil Menghapus Variant Baju", type:
                        "success"}).then(function(){
                            location.reload();
                        }
                    );
                }

            });
        });
        //End Model Function
    });
</script>
@endsection
