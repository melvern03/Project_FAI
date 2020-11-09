@extends('Template')
@section('Title')
    Verifikasi
@endsection

@section('Content')
<body class="bg-dark">
    <div class="toast" id="myToast" style="top: 0;right:0;margin:10px">
        <div class="toast-header">
            <strong class="mr-auto"><i class="fa fa-grav"></i>Code Not Valid</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body" id='welcomeBody'>
            <div>Code Tidak Valid Silahkan Lihat Email Anda</div>
        </div>
    </div>

    <div class="container">
        <div class="card mx-auto mt-5">
            <div class="card-header">Verikasi Account</div>
            <div class="card-body">
                <form action="/verifikasiData" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="code">Code Verifikasi</label>
                            <input type="text" class="form-control" placeholder="Code Verifikasi" name="code">
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">Verifikasi</button>
                </form><br>
                <form action="/logAuthAdmin">
                    <button class="btn btn-primary btn-block" type="submit" style="width:50%;margin:auto">Back to Main
                        Site</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function notif(){
        $("#myToast").toast({ delay: 2000 });
        $("#myToast").toast('show');
    }
    </script>
    @if (Session("errors"))
    <script>
        document.getElementById("welcomeBody").innerHTML = "Code Tidak Valid Silahkan cek email anda lagi";
        notif();
    </script>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $item)
        <script>
            document.getElementById("welcomeBody").innerHTML = "{!! $item !!}";
            notif();
        </script>
        @endforeach
    </div>
    @endif
</body>
@endsection
