<nav class="navbar navbar-expand-md navbar-light sticky-top bg-light" style="opacity: 100%;padding:0px">
    <a class="nav-link" href="/"><img src="{{url('Logo/Logo(no title).png')}}"  style="width: 8%;height:8%;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="/">Home</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Category
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                @php
                    $kategori = DB::table('kategori')->get();
                @endphp
                @foreach ($kategori as $item)
                <form method="POST" action="/shop/{{$item->NAMA_KATEGORI}}">
                    @csrf
                    <button class="dropdown-item" type="submit" name='btnKategori' value={{$item->ID_KATEGORI}}>{{$item->NAMA_KATEGORI}}</a>
                </form>
                @endforeach

            </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>
        {{-- @if (Auth::check())
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{Session::get("userLog")}}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#">Profile</a>
            </div>
          </li>
        @else
        <li class="nav-item">
            <a class="nav-link" href="/login">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/register">Register</a>
          </li>
        @endif --}}

        @if (Session::has("userLog"))
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{Session::get("userLog")}}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#">Profile</a>
              <a class="dropdown-item" href="/logout">Log Out</a>
            </div>
        </li>
            </li>
        @else
        <li class="nav-item">
            <a class="nav-link" href="/login">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/register">Register</a>
          </li>
        @endif

      </ul>
    </div>
  </nav>
