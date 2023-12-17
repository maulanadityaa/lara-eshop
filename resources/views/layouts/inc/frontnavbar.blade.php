<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Toko Sandal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
            <div class="container-fluid justify-content-center justify-content-md-between px-5">
                <div class="d-flex my-2 my-sm-0">
                    <a class="navbar-brand me-2 mb-1 d-flex justify-content-center" href="{{ route('home') }}">
                        <img src="{{ url('assets/logo.png') }}" height="30" alt="" loading="lazy" />
                        {{-- <span class="text-dark"> Byboot.id</span> --}}
                    </a>

                    <!-- Search form -->

                    <div class="search-bar">
                        <form action="{{ url('search-product') }}" method="post">
                            @csrf
                            <div class="d-flex input-group w-auto">
                                <input type="search" class="form-control rounded" placeholder="Cari produk..."
                                    id="search" name="keyword" required>
                                <button type="submit" class="input-group-text border-0 d-none d-md-flex"><i
                                        class="fas fa-search text-dark"></i></button>
                            </div>
                        </form>
                    </div>
                </div>

                <ul class="navbar-nav flex-row">
                    <li class="nav-item me-3 me-lg-0">
                        <a class="nav-link" href="{{ url('category') }}">
                            <i class="fas fa-bars" style="color:#313131;"></i>
                            <span class="text-dark">Categories</span>
                        </a>
                    </li>
                    <!-- Badge -->
                    <li class="nav-item me-3 me-lg-0 text-dark">
                        <a class="nav-link {{ Request::is('cart') ? 'active' : '' }}" href="{{ url('cart') }}">
                            <span><i class="fas fa-shopping-cart" style="color:#313131;"></i></span>
                            @php
                                if (Auth::user()) {
                                    $cart = \App\Models\Cart::where('user_id', Auth::user()->id)->count();
                                    $orders = \App\Models\Order::where('user_id', Auth::user()->id)
                                        ->where('status', '!=', '5')
                                        ->count();
                                } else {
                                    $cart = 0;
                                    $orders = 0;
                                }
                            @endphp
                            @if ($cart != 0)
                                <span class="badge rounded-pill badge-notification bg-danger">{{ $cart }}</span>
                            @endif
                        </a>
                    </li>
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="btn btn-info text-white ms-2"
                                    href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="btn btn-outline-success ms-2"
                                    href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-dark" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true" v-pre>
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarDropdown">
                                @if (Auth::user()->role_as == 1)
                                    <a class="dropdown-item" href="{{ url('/dashboard') }}">
                                        Dashboard
                                    </a>
                                    <hr class="dropdown-divider">
                                @else
                                    <a class="dropdown-item" href="{{ url('/user-profile') }}">
                                        <i class="fas fa-address-card"></i> Profil Saya
                                    </a>
                                    @if ($orders != 0)
                                        <a class="dropdown-item" href="{{ url('/my-orders') }}">
                                            <i class="fas fa-receipt"></i> Pesanan Saya <span
                                                class="badge rounded-pill badge-notification bg-success">{{ $orders }}</span>
                                        </a>
                                    @else
                                        <a class="dropdown-item" href="{{ url('/my-orders') }}">
                                            <i class="fas fa-receipt"></i> Pesanan Saya
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ url('/wishlist') }}">
                                        <i class="fas fa-heart"></i> Wishlist
                                    </a>
                                    <hr class="dropdown-divider">
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
    </div>
</nav>
