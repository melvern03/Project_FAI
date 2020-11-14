@extends('Template')
@extends('admin/navbar')
@section('title')
    Add Variant
@endsection

@section('Content')
<title>Add Variant</title>
<main role="main" class="col-md-10 ml-sm-auto col-lg-11 px-md-4">
    <div class="wrapper" style="width: 100%;">
        <form id='addBaju' method="POST" action="/admin/home/addMoreVariant">
            @csrf
            <h1>Tambah Variant</h1><br>
            <div class="form-group col-md-6">
                <label for="inputCity">Nama Model</label>
                <input type="text" class="form-control" value="{{DB::table('h_baju')->where('id_hbaju',$id)->value('NAMA_BAJU')}}" readonly>
            </div>
            <div class="form-group col-md-6">
                <label for="Harga">Harga</label>
                <input type="number" name="Harga" class="form-control" id="Harga" value="{{DB::table('h_baju')->where('id_hbaju',$id)->value('HARGA')}}" readonly>
            </div>
            <b>Gambar Model : </b>
            <img id="image-preview" alt="image preview" style="width:400px;height:400px" src="{{url('/baju/'.DB::table('h_baju')->where('id_hbaju',$id)->value('gambar'))}}"/>
            <hr>
            <br>
            <h1>Tambah Variant</h1>
            <table class="table table-bordered" id="dynamic_field">
                <tr>
                    <th>Nama</th>
                    <th>Warna</th>
                    <th>Stock</th>
                    <th>Ukuran</th>
                    <th>Kategori</th>
                </tr>
                <tr>
                    <td><input type='text' name='namaVariasi[]' placeholder='Nama Baju' class='form-control name_list'
                            required /></td>
                    <td><input type='color' name='color[]' placeholder='Warna Baju' class='form-control color_list'
                            required></td>
                    <td><input type='number' name='stock[]' placeholder='Stock' class='form-control stock_list'
                            required></td>
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
            <button type="submit" id="btnAddModel" name='btnAddNewVariant' class="btn btn-success" value="{{$id}}">+ Add</button>
        </form>
    </div>
</main>

<script>
    $(document).ready(function(){
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

</script>
@endsection
