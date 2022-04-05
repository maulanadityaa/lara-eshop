<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Toko Sandal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
            <div class="container-fluid justify-content-center justify-content-md-between">
              <div class="d-flex my-2 my-sm-0">
                <a class="navbar-brand me-2 mb-1 d-flex justify-content-center" href="{{ route('home') }}">
                  <img src="https://mdbootstrap.com/img/logo/mdb-transaprent-noshadows.png" height="20" alt=""
                    loading="lazy" />
                </a>
        
                <!-- Search form -->
                <form class="d-flex input-group w-auto my-auto">
                  <input autocomplete="off" type="search" class="form-control rounded" placeholder="Search"
                    style="min-width: 125px" />
                  <span class="input-group-text border-0 d-none d-md-flex"><i class="fas fa-search text-dark"></i></span>
                </form>
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
                    <span class="badge rounded-pill badge-notification bg-danger">1</span>
                  </a>
                </li>
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @if (Auth::user()->role_as == 1)
                                <a class="dropdown-item" href="{{ url('/dashboard') }}">
                                    Dashboard
                                </a>
                                <hr class="dropdown-divider">
                            @else
                                <a class="dropdown-item" href="{{ url('/my-orders') }}">
                                    Pesanan Saya
                                </a>
                                <hr class="dropdown-divider">
                            @endif
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
                <!-- Avatar -->
                {{-- <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownMenuLink"
                    role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                    <img src="https://mdbootstrap.com/img/Photos/Avatars/img (31).jpg" class="rounded-circle" height="22"
                      alt="" loading="lazy" />
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="#">My profile</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Logout</a></li>
                  </ul>
                </li> --}}
              </ul>
            </div>
          </nav>
    </div>
</nav>
