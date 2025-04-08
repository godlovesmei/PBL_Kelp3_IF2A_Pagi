<!DOCTYPE html>
gvftvftg
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HOME | Skincare Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Belleza&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}" />
</head>

<body>
    <div class="top-bar d-flex justify-content-between align-items-center p-3">
        <h2 class="site-name">PureBeauty</h2>
        <h3 class="tagline text-center mx-auto">Skin Protection</h3>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light p-2">
        <div class="container-fluid">
            <div class="search-container d-flex align-items-center">
                <form action="{{ route('shop') }}" method="GET" class="d-flex align-items-center w-100">
                    <i class="bi bi-search"></i>
                    <input class="form-control me-2 border-0" type="search" name="keyword" placeholder="Search..." aria-label="Search" value="{{ request('keyword') }}" />
                </form>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('shop') }}">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
                </ul>

                <div class="d-flex align-items-center ms-auto">
                    @auth
                        <div class="user-menu position-relative">
                            <i class="bi bi-person me-2 user-icon"></i>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('profile') }}">My Account</a></li>
                                <li><a href="{{ route('history') }}">History Order</a></li>
                                <li><a href="{{ route('logout') }}">Logout</a></li>
                            </ul>
                        </div>
                    @else
                        <i class="bi bi-person me-2"></i>
                        <a href="{{ route('login') }}" class="me-4">Log In</a>
                    @endauth
                    <a href="{{ route('cart') }}"><i class="bi bi-bag"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <div class="banner-container">
        <img src="{{ asset('assets/img/banner.jpeg') }}" class="banner-img" alt="Banner Image" />
        <div class="banner-text">
            <p>TEMUKAN KEINDAHANMU YANG SESUNGGUHNYA</p>
            <h1>“We Repair Your Skin Barrier”</h1>
            <a href="{{ route('shop') }}" class="shop-now-btn">SHOP NOW ></a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<footer>
    <div class="footer-container">
        <div class="footer-left">
            <h2>THANK YOU</h2>
            <p>For Visiting Our Website</p>
            <div class="copyright">
                <span>&copy;2024 by PureBeauty</span>
            </div>
        </div>

        <div class="footer-middle">
            <ul>
                <li><a href="{{ route('about') }}">ABOUT</a></li>
                <li><a href="{{ route('history') }}">SHIPPING & RETURNS</a></li>
                <li><a href="{{ route('contact') }}">CONTACT</a></li>
            </ul>
        </div>

        <div class="footer-right">
            <ul>
                <li><a href="https://www.instagram.com/purebeautys_id" target="_blank">INSTAGRAM</a></li>
                <li><a href="https://x.com/purebeautyid" target="_blank">TWITTER</a></li>
                <li><a href="#">EMAIL</a></li>
            </ul>
        </div>
    </div>
</footer>

</html>
