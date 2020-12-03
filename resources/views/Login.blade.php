@extends('Template')
@section('Title')
Log In
@endsection
@section('Content')
<div style="background-image: url(Bg-2.jpg);width: 100%; height: 100%;background-size:cover;">
    @include('Navbar')
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h4 align="center">Errors</h4>
        <ul>
        @foreach ($errors->all() as $item)
            <li>{{ $item }}</li>
        @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div style="text-align: center;">
        <br>
        <br>
        <main role="main" class="container">
            <div class="jumbotron" style="opacity: 77%;">
              <img src="{{url('Logo/Logo(title).png')}}" style="width:10%;height:10%;">
              <br>
              <h1 class="display-1">Log In</h1><br>
              <form action="/logCheck" method="POST">
                @csrf
                    <div class="form-group">
                      <label for="Username">Username</label>
                      <input type="text" name="username" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="Password">Password</label>
                      <input type="password" name="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Log In</button>
              </form>
              <br>
              <hr>
              Havent had an account? <a href="/register">click here for Register.</a><br>
            <br>
            </div>
          </main>
          <br>
          <br>
          <br>
  </div>
  @if (Session("blacklisted"))
      <script>
        Swal.fire({
            icon: 'error',
            text: 'Akun anda telah di blacklist'
        })
      </script>
  @endif
  @if (Session("success"))
  <script>
      Swal.fire({
          icon: 'success',
          title: '{!!Session("success")!!}',
          showConfirmButton: false,
          timer: 1500
      })
  </script>
  @endif
  @if (Session("verifyGagal"))
    <script>
        Swal.fire({
            icon: 'error',
            title:'Verify Gagal',
            text: 'Silahkan Cek Kode verikasi dan melakukan verifikasi manual dengan cara login terlebih dahulu'
        })
    </script>
  @endif

  @if (Session("verifySucces"))
    <script>
        Swal.fire({
          icon: 'success',
          title: 'Email Berhasil Di Verifikasi Silahkan melakukan login',
          showConfirmButton: false,
          timer: 1500
      })
    </script>
  @endif
  @if (Session("error"))
  <script>
    Swal.fire({
        icon: 'error',
        text: 'Username / Password Salah'
    })
  </script>
  @endif
@endsection
