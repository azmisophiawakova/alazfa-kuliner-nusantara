<nav class="navbar navbar-expand-lg floating-nav py-2">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <i class="bi bi-shop fs-3"></i>
            <span>Alazfakuliner</span>
        </a>

        <!-- Hamburger for mobile -->
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 fw-medium">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('sellers.index') ? 'active' : '' }}" href="{{ route('sellers.index') }}">Penjual</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('menu.diskon') ? 'active' : '' }}" href="{{ route('menu.diskon') }}">Diskon</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('menu.populer') ? 'active' : '' }}" href="{{ route('menu.populer') }}">Populer</a>
                </li>
            </ul>

            <!-- Right elements -->
            <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0 pb-3 pb-lg-0">
                <!-- Search -->
                <form action="{{ route('menu.search') }}" method="GET" class="position-relative d-none d-lg-block">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input class="form-control rounded-pill ps-5 bg-light border-0 shadow-none" type="search" name="q" placeholder="Search" aria-label="Search">
                </form>

                @auth
                    <!-- Favorite -->
                    <a href="{{ route('favorites.index') }}" class="text-dark fs-5"><i class="bi bi-heart"></i></a>
                    
                    <!-- Notification -->
                    <a href="{{ route('notifications.index') }}" class="text-dark fs-5 position-relative">
                        <i class="bi bi-bell"></i>
                        @php $notifCount = \App\Models\Notification::where('id_user', Auth::id())->where('status_baca', false)->count(); @endphp
                        @if($notifCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.55rem;">
                                {{ $notifCount > 99 ? '99+' : $notifCount }}
                            </span>
                        @endif
                    </a>
                    
                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="text-dark fs-5 position-relative">
                        <i class="bi bi-cart3"></i>
                        @php $cartCount = \App\Models\Cart::where('id_user', Auth::id())->count(); @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.55rem;">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                            </span>
                        @endif
                    </a>
                    
                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <a href="#" class="text-dark fs-5 dropdown-toggle text-decoration-none d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown">
                            <li><h6 class="dropdown-header">{{ Auth::user()->name }}</h6></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Log Out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-dark text-decoration-none fw-medium">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
