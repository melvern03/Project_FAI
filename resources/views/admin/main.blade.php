@extends('Template')
@extends('admin/navbar')
@section('Title')
    Home
@endsection

@section('Content')
<main role="main" class="col-md-10 ml-sm-auto col-lg-11 px-md-4">
    {{-- Start Toast --}}
    <div class="toast" id="myToast" style="position: absolute; top: 0;right:0;margin:10px">
        <div class="toast-header">
            <strong class="mr-auto"><i class="fa fa-grav"></i>Sucess</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            <div>Berhasil menambahkan Baju</div>
        </div>
    </div>

    <div class="toast" id="toastFail" style="position: absolute; top: 0;right:0;margin:10px">
        <div class="toast-header">
            <strong class="mr-auto"><i class="fa fa-grav"></i>Fail</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            <div>
                Gagal menambahkan Baju
            </div>
        </div>
    </div>
    {{-- End Toast --}}

    <div class="wrapper" style="width: 100%;">
        <form id='addBaju' method="POST" action="/admin/addBaju"  enctype="multipart/form-data">
            @csrf
          <h1>Tambah Baju</h1><br><br>
          <div class="form-group col-md-6">
            <label for="inputCity">Nama Model</label>
            <input type="text" name="NamaModel" class="form-control" value="{{old('NamaModel')}}">
        </div>
        <div class="form-group col-md-6">
            <label for="inputTelp">Harga</label>
            <input type="number" name="Harga" class="form-control" id="inputTelp" value="{{old('Harga')}}">
        </div>
          <b>Gambar Model : </b> <input type="file" name="gambarModel" id="image-source" onchange="previewImage();" required>
          <br>
          <img id="image-preview" alt="image preview" style="width:400px;height:400px"/>
          <hr>
          <br>
          <h1>Tambah Variasi</h1>
          <table class="table table-bordered" id="dynamic_field">
            <tr>
              <th>Nama</th>
              <th>Warna</th>
              <th>Stock</th>
              <th>Ukuran</th>
              <th>Kategori</th>
            </tr>
            <tr>
              <td><input type='text' name='namaVariasi[]' placeholder='Nama Baju' class='form-control name_list' required/></td>
              <td><input type='color' name='color[]' placeholder='Warna Baju' class='form-control color_list' required></td>
              <td><input type='number' name='stock[]' placeholder='Stock' class='form-control stock_list' required></td>
              <td><select class='form-control' name='ukuran[]' style='width: 200px;' readonly>
                <option selected disabled hidden>Ukuran</option>
                  <option value='XS'>XS</option>
                  <option value='S'>S</option>
                  <option value='M'>M</option>
                  <option value='L'>L</option>
                  <option value='XL'>XL</option>
                </select></td>
              <td><select class='form-control' name='category[]' style='width: 200px;' readonly>
                <option selected disabled hidden>Kategori</option>
                    @php
                        $data = DB::table('kategori')->get();
                        foreach ($data as $key => $value) {
                            echo "<option value='$value->ID_KATEGORI'>$value->NAMA_KATEGORI</option>";
                        }
                    @endphp
                </select></td>
              <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
            </tr>
          </table>
          <button type="submit" id="btnAddModel" name='btnAddModel' class="btn btn-success">+ Add</button>
        </form>
        <script>
        </script>
</main>
<script>
    $(document).ready(function () {
        $(document).on('click', '.btn_remove', function () {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
      });

      var i = 1;
        $('#add').click(function () {
        i++;
        $('#dynamic_field').append(`<tr id=row` + i + `>
        <td><input type='text' name='namaVariasi[]' placeholder='Nama Baju' class='form-control name_list' required/></td>
        <td><input type='color' name='color[]' placeholder='Warna Baju' class='form-control color_list' required></td>
        <td><input type='number' name='stock[]' placeholder='Stock' class='form-control stock_list' required></td>
        <td><select class='form-control' name='ukuran[]' style='width: 200px;' readonly>
                <option selected disabled hidden>Ukuran</option>
                <option value='XS'>XS</option>
                <option value='S'>S</option>
                <option value='M'>M</option>
                <option value='L'>L</option>
                <option value='XL'>XL</option>
        </select></td>
        <td><select class='form-control' name='category[]' style='width: 200px;' readonly>
                <option selected disabled hidden>Kategori</option>
            <?php
                    $data = DB::table('kategori')->get();
                    foreach ($data as $key => $value) {
                        echo "<option value='$value->ID_KATEGORI'>$value->NAMA_KATEGORI</option>";
                    }
                ?>
          </select></td>
          <td><button type='button' name='remove' id=` + i + ` class='btn btn-danger btn_remove'>X</button></td>
        </tr>`);
      });
    });
    function previewImage() {
        document.getElementById("image-preview").style.display = "block";
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("image-source").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("image-preview").src = oFREvent.target.result;
        };
    };

    function notif(){
        $("#myToast").toast({ delay: 3000 });
        $("#myToast").toast('show');
    }
    function notifError(){
        $("#toastFail").toast({ delay: 3000 });
        $("#toastFail").toast('show');
    }
</script>

@if (Session("Sucess"))
    @php
        echo "<script type='text/javascript'>notif()</script>";
    @endphp
@elseif(Session("Errors"))
    @php
        echo "<script type='text/javascript'>notifError()</script>";
    @endphp
@endif

{{-- Hexa to RGB --}}
{{-- <script type="text/javascript">

    var n_match = ntc.name("#6195ED");
    n_rgb = n_match[0]; // RGB value of closest match
    n_name = n_match[1]; // Text string: Color name
    n_exactmatch = n_match[2]; // True if exact color match

    alert(n_match);

  </script> --}}

@endsection
