<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ARTKUNO | Seni Adalah Ledakan</title>
    <!-- Inline SVG favicon (dark green tile with 'A') -->
    <link rel="icon" href="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' fill='%230f5132'/><text x='50' y='65' font-size='55' text-anchor='middle' fill='%23ffffff' font-family='Arial' font-weight='700'>A</text></svg>">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://startbootstrap.github.io/startbootstrap-sb-admin-2/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <div class="sidebar-brand-icon">
                    <img src="{{ asset('images/logo-a.svg') }}" alt="A" style="width:40px;height:40px;">
                </div>
                <div class="sidebar-brand-text mx-3">ARTKUNO</div>
            </a>

            <hr class="sidebar-divider my-0">

            @if(Auth::user()->role == 'admin')
            <div class="sidebar-heading mt-3">Admin Core</div>
            <li class="nav-item {{ request()->routeIs('admin.support.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.support.index') }}">
        <i class="fas fa-fw fa-headset"></i>
        <span>Inbox Support</span>
    </a>
</li>
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard & Laporan</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.wallet.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.wallet.index') }}">
                    <i class="fas fa-fw fa-money-bill-wave"></i><span>Approval Dompet</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.wallet.history') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.wallet.history') }}">
                    <i class="fas fa-fw fa-history"></i><span>History Transaksi</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-fw fa-users-cog"></i><span>Kelola Pengguna</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.items.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.items.index') }}">
                    <i class="fas fa-fw fa-shield-alt"></i><span>Pengawasan Barang</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.news.index') }}">
                    <i class="fas fa-fw fa-newspaper"></i><span>Kelola Berita</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            @endif

            @if(Auth::user()->role == 'seller')
            <li class="nav-item {{ request()->routeIs('support.my') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('support.my') }}">
                    <i class="fas fa-fw fa-headset"></i><span>CS / Support</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('seller.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('seller.items.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('seller.items.index') }}">
                    <i class="fas fa-fw fa-box-open"></i><span>Kelola Barang</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('messages.index') }}">
                    <i class="fas fa-fw fa-envelope"></i><span>Pesan Masuk</span>
                    <span class="badge badge-danger badge-counter">{{ Auth::user()->receivedMessages()->count() }}</span>
                </a>
            </li>
            @endif

            @if(Auth::user()->role == 'bidder')
            <li class="nav-item {{ request()->routeIs('bidder.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('bidder.dashboard') }}">
                    <i class="fas fa-fw fa-home"></i><span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('bidder.wallet.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('bidder.wallet.index') }}">
                    <i class="fas fa-fw fa-wallet"></i><span>Dompet Saya</span>
                    <span class="badge badge-success ml-1">Rp {{ number_format(Auth::user()->balance ?? 0) }}</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('bidder.auction.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('bidder.auction.index') }}">
                    <i class="fas fa-fw fa-search-dollar"></i><span>Cari Barang</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('bidder.wishlist.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('bidder.wishlist.index') }}">
                    <i class="fas fa-fw fa-heart"></i><span>Favorit Saya</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('bidder.wins.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('bidder.wins.index') }}">
                    <i class="fas fa-fw fa-trophy"></i><span>Pemenang / Invoice</span>
                </a>
            </li>
            @endif

            <hr class="sidebar-divider d-none d-md-block">

            <div class="sidebar-heading">Akun</div>
            <li class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('profile.edit') }}">
                    <i class="fas fa-fw fa-cog"></i><span>Pengaturan Akun</span>
                </a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" id="logoutSidebarForm">
                    @csrf
                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logoutSidebarForm').submit();">
                        <i class="fas fa-fw fa-sign-out-alt"></i><span>Log Out</span>
                    </a>
                </form>
            </li>

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                
                                @if(Auth::user()->avatar)
                                    <img class="img-profile rounded-circle" src="{{ asset('storage/' . Auth::user()->avatar) }}" style="object-fit: cover;">
                                @else
                                    <img class="img-profile rounded-circle" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random">
                                @endif
                                </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </form>
                            </div>
                        </li>
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

    {{-- live chat widget removed; use Support/Inbox from sidebar instead --}}

</body>
</html>
