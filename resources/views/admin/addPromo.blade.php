@extends('Template')
@extends('admin/navbar')
@section('Title')
    Add New Promo
@endsection

@section('Content')
<main role="main" class="col-md-10 ml-sm-auto col-lg-11 px-md-4">
    @if ($errors->any())
    <div class="modal" tabindex="-1" role="dialog" id='errorModal'>
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Errors</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <ul>
                    @foreach ($errors->all() as $item)
                        <li>{{$item}}</li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
        <script>
            $(document).ready(function(){
                $("#errorModal").modal();
            })
        </script>
    @endif
    <h2>Add New Promo</h2>
    <form action="/admin/Promo"><button class='btn btn-info'>Back To List Promo</button></form>
    <form method="POST" action="/admin/Promo/Add/AddPromo" enctype="multipart/form-data">
        @csrf
        <div class="form-row" style="width: 80%">
            <div class="form-group col-md-6">
                <label for="NamaPromo">Nama Promo</label>
                <input type="text" name="NamaPromo" class="form-control" value="{{old('NamaPromo')}}">
            </div>
            <div class="form-group col-md-6">
                <label for="DiskonPromo">Diskon (%)</label>
                <input type="number" name="DiskonPromo" class="form-control" min='1' max='100' value="{{old('DiskonPromo')}}">
            </div>
            <div class="form-group col-md-6">
                <label for="tgl_start">Tanggal Promo Start</label>
                <input class="form-control" type="date" name='tgl_start' value="<?= date('Y-m-d'); ?>" id="example-date-input">
            </div>

            <div class="form-group col-md-6">
                <label for="tgl_end">Tanggal Promo End</label>
                <input class="form-control" type="date" name='tgl_end' value="<?= date('Y-m-d'); ?>" id="example-date-input">
            </div>

            <div class="form-group col-md-6">
                <label for="MaxDiskon">Maximal Diskon</label>
                <input type="number" name="MaxDiskon" class="form-control" min='0' value="{{old('MaxDiskon')}}">
            </div>
            <div class="form-group col-md-6">
                <label for="MaxDiskon">Banner Promo</label>
                <input type="file" name="gambarPromo" class="form-control" id="image-source" onchange="previewImage();">
            </div>
            <div class='col-md-12'>
                <img id="image-preview" alt="image preview" class='col s12'/>
            </div>
            <br>
            <button class='btn btn-success col s12'>Add Promo</button>
        </div>
    </form>
</main>
<script>
    $(document).ready(function(){
        $("#image-preview").hide();
    })
    function previewImage() {
        document.getElementById("image-preview").style.display = "block";
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("image-source").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("image-preview").src = oFREvent.target.result;
            $("#image-preview").show('slow');
        };
    };
</script>
@endsection
