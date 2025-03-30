<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap"
        rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Belleza&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="\PBL_OKE\assets\css\home.css" />
    <title>HOME | Skincare Store</title>
</head>

<body>
    <!-- Nama toko -->
    <div class="top-bar d-flex justify-content-between align-items-center p-3">
        <h2 class="site-name">PureBeauty</h2>
        <h3 class="tagline text-center mx-auto">Skin Protection</h3>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light p-2">
        <div class="container-fluid">

            <!-- Search bar (Tetap di kiri, dan di luar navbar-toggler) -->
            <div class="search-container d-flex align-items-center">
                <form action="shop.php" method="GET" class="d-flex align-items-center w-100">
                    <i class="bi bi-search"></i>
                    <input class="form-control me-2 border-0" type="search" name="keyword" placeholder="Search..." aria-label="Search" value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>" />
                </form>
            </div>

            <!-- Navbar Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Collapse -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Navigasi -->
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                </ul>

                <div class="d-flex align-items-center ms-auto">
                    <!-- Icon User login -->
                    <?php if (isset($_SESSION['username'])): ?>
                        <!-- Pas pengguna sudah login -->
                        <div class="user-menu position-relative">
                            <i class="bi bi-person me-2 user-icon"></i>
                            <ul class="dropdown-menu">
                                <li><a href="profile.php">My Account</a></li>
                                <li><a href="history_ord.php">History Order</a></li>
                                <li><a href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- Pas pengguna belum login -->
                        <i class="bi bi-person me-2"></i>
                        <a href="login.php" class="me-4">Log In</a>
                    <?php endif; ?>

                    <!-- Icon keranjang -->
                    <a href="cart.php"><i class="bi bi-bag"></i></a>
                </div>

            </div>
        </div>
    </nav>

    <!-- Banner -->
    <div class="banner-container">
        <img
            src="\PBL_OKE\assets\img/SPA natural cosmetic on marble.jpeg"
            class="banner-img"
            alt="Banner Image" />
        <div class="banner-text">
            <p>TEMUKAN KEINDAHANMU YANG SESUNGGUHNYA</p>
            <h1>“We Repair Your Skin Barrier”</h1>
            <a href="shop.php" class="shop-now-btn">SHOP NOW ></a>
        </div>
    </div>

    <!-- New Arrivals Section -->
    <section class="new-arrivals py-5">
        <div class="container">
            <h2 class="text-center mb-5">New Arrivals</h2>

            <div id="newArrivalsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php if (count($products) > 0): ?>
                        <?php foreach (array_chunk($products, 3) as $index => $chunk): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <div class="row justify-content-center">
                                    <?php foreach ($chunk as $product): ?>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div class="card">
                                                <?php
                                                $file_path = htmlspecialchars($product['gambar_produk']); // Path langsung dari database
                                                $absolute_path = $_SERVER['DOCUMENT_ROOT'] . $file_path;
                                                if (!file_exists($absolute_path)) {
                                                    echo "<p class='text-danger'>Gambar tidak ditemukan: " . htmlspecialchars($file_path) . "</p>";
                                                } else {
                                                    echo '<img src="' . $file_path . '" class="card-img-top" alt="' . htmlspecialchars($product['nama_produk']) . '" />';
                                                }
                                                ?>
                                                <div class="card-body text-center">
                                                    <a href="detail_produk.php?id=<?= $product['id_produk'] ?>" class="btn btn-primary">Shop Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center">Produk belum tersedia.</p>
                    <?php endif; ?>
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#newArrivalsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#newArrivalsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>


    <!-- Import Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<footer>
    <div class="footer-container">
        <div class="footer-left">
            <h2>THANK YOU</h2>
            <p>For Visiting Our Website</p>
            <div class="copyright">
                <span>©2024 by PureBeauty</span>
            </div>
        </div>

        <div class="footer-middle">
            <ul>
                <li><a href="about.php">ABOUT</a></li>
                <li><a href="history_ord.php">SHIPPING & RETURNS</a></li>
                <li><a href="contact.php">CONTACT</a></li>
            </ul>
        </div>

        <div class="footer-right">
            <ul>
                <li><a href="https://www.instagram.com/purebeautys_id?igsh=MTAybzdrZmQ3aW5jYQ==" target="_blank">INSTAGRAM</a></li>
                <li><a href="https://x.com/purebeautyid?t=wcEwXx9N9U5m4DQhaAGrRQ&s=09" target="_blank">TWITTER</a></li>
                <li><a href="#">EMAIL</a></li>
            </ul>
        </div>
    </div>
</footer>

</html>