@extends('Template')
@section('Title')
    Admin
@endsection

@section('Content')

<body class="bg-dark">
    <div class="container">
        <div class="card mx-auto mt-5">
            <div class="card-header">Login</div>
            <div class="card-body">
                <form action="/logAdmin" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" placeholder="Username" name="username">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" placeholder="Password" name="password">
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">Login</button>
                </form><br>
                <form action="/logAuthAdmin">
                    <button class="btn btn-primary btn-block" type="submit" style="width:50%;margin:auto">Back to Main Site</button>
                </form>
            </div>
        </div>
    </div>
</body>
@if (Session("gagal"))
<script>
    let timerInterval
Swal.fire({
  title: 'Login Failed',
  html: 'Akun anda telah di disable oleh owner',
  willOpen: () => {
    timerInterval = setInterval(() => {
      const content = Swal.getContent()
      if (content) {
        const b = content.querySelector('b')
        if (b) {
          b.textContent = Swal.getTimerLeft()
        }
      }
    }, 100)
  },
  onClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
})
</script>
@endif
@if (Session("errors"))
<script>
    Swal.fire({
  icon: 'error',
  title: 'Login Fail',
  text: 'Username / Password Salah',
})
</script>
@endif
@if (Session("NotAdmin"))
<script>
    Swal.fire({
  icon: 'error',
  title: 'Login Fail',
  text: 'Anda tidak mempunyai akses untuk halaman ini',
})
</script>
@endif

@endsection
