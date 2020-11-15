<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse"
        data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav ml-auto ml-md-0">
        <a href="/admin/home"><img src="{{url('Logo/Logo(no title invert).png')}}" style="width: 75px;height:75px"></a>
    </ul>
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow mx-1">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user-circle fa-lg"></i> <span style="margin-left: 5px" class="text-white">Welcome {{Auth::user()->nama_user}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/admin/">Logout</a>
            </div>
        </li>
        </li>
    </ul>

</nav>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-2 col-lg-1 d-md-block bg-light sidebar collapse">
            <div class="sidebar-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link actived" href="/admin/home">
                            <span data-feather="file"></span>
                            Baju
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link actived" href="/admin/ListTransaksi">
                            <span data-feather="file"></span>
                            List Transaksi
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link actived" href="/admin/promo">
                            <span data-feather="file"></span>
                            Promo
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link actived" href="/admin/listUsers">
                            <span data-feather="file"></span>
                            Users
                        </a>
                    </li>
                </ul>
                <hr>
                @if (Auth::check())
                @if (Auth::user()->jabatan == "Owner")
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link actived" href="/admin/list">
                            <span data-feather="file"></span>
                            Admin
                        </a>
                    </li>
                </ul>
                <hr>
                @endif
                @endif

            </div>
        </nav>
