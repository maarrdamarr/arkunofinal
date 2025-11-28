<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="https://startbootstrap.github.io/startbootstrap-sb-admin-2/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-gavel"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Lelang v12</div>
    </a>

    <hr class="sidebar-divider my-0">

    @if(Auth::user()->role == 'admin')
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-chart-line"></i>
            <span>Laporan Transaksi</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.news.index') }}">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Kelola Berita</span>
        </a>
    </li>
    @endif

    @if(Auth::user()->role == 'seller')
    <li class="nav-item {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('seller.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('seller.items.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('seller.items.index') }}">
            <i class="fas fa-fw fa-box-open"></i>
            <span>Kelola Barang</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('messages.index') }}">
            <i class="fas fa-fw fa-envelope"></i>
            <span>Pesan Masuk</span>
            <span class="badge badge-danger badge-counter">{{ Auth::user()->receivedMessages()->count() }}</span>
        </a>
    </li>
    @endif

    @if(Auth::user()->role == 'bidder')
    <li class="nav-item {{ request()->routeIs('bidder.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('bidder.dashboard') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('bidder.auction.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('bidder.auction.index') }}">
            <i class="fas fa-fw fa-search-dollar"></i>
            <span>Cari Barang</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('bidder.wishlist.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('bidder.wishlist.index') }}">
            <i class="fas fa-fw fa-heart"></i>
            <span>Favorit Saya</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('bidder.wins.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('bidder.wins.index') }}">
            <i class="fas fa-fw fa-trophy"></i>
            <span>Pemenang / Invoice</span>
        </a>
    </li>
    @endif

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
                </nav>
                <div class="container-fluid">
                    {{ $slot }}
                </div>
                </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Lelang Antik 2025</span>
                    </div>
                </div>
            </footer>
            </div>
        </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://startbootstrap.github.io/startbootstrap-sb-admin-2/js/sb-admin-2.min.js"></script>

</body>
</html>