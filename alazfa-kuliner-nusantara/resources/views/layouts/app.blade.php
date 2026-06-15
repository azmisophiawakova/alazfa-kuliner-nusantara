<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AlazfaKuliner Nusantara') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #9B1B30; /* Maroon Nusantara */
            --primary-light: #C2223D;
            --secondary: #D4AF37; /* Saffron Gold */
            --dark: #1A1A1D;
            --light: #F9F9F9;
            --surface: #FFFFFF;
            --text-main: #2C2C2C;
            --text-muted: #8E8E8E;
            --radius-sm: 12px;
            --radius-md: 20px;
            --radius-lg: 32px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--light);
            color: var(--text-main);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        /* Floating Nav */
        .floating-nav {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 95%;
            max-width: 1200px;
            z-index: 1040;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 100px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            padding: 8px 24px;
            transition: all 0.3s ease;
        }

        .nav-link {
            font-weight: 600;
            color: var(--text-muted) !important;
            padding: 10px 20px !important;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary) !important;
            background: rgba(155, 27, 48, 0.05);
        }

        /* Buttons */
        .btn {
            border-radius: 50px;
            font-weight: 600;
            padding: 12px 28px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            box-shadow: 0 8px 20px rgba(155, 27, 48, 0.25);
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(155, 27, 48, 0.35);
            color: white;
        }

        .btn-outline-custom {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline-custom:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(155, 27, 48, 0.2);
        }

        /* Cards & Polaroids */
        .premium-card {
            background: var(--surface);
            border-radius: var(--radius-md);
            border: 1px solid rgba(0,0,0,0.03);
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            overflow: hidden;
        }

        .premium-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }

        /* Utilities */
        .text-primary-custom { color: var(--primary) !important; }
        .bg-primary-custom { background-color: var(--primary) !important; }
        .text-secondary-custom { color: var(--secondary) !important; }

        /* Bento Grid */
        .bento-box {
            background: white;
            border-radius: var(--radius-lg);
            padding: 32px;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            transition: transform 0.3s ease;
        }
        .bento-box:hover {
            transform: translateY(-5px);
        }

        /* Split Screen */
        @media (min-width: 992px) {
            .split-sticky {
                position: sticky;
                top: 100px;
                height: calc(100vh - 120px);
                border-radius: var(--radius-lg);
                overflow: hidden;
            }
        }
        @media (max-width: 991.98px) {
            .split-sticky {
                height: 350px;
                border-radius: var(--radius-md);
                overflow: hidden;
            }
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: var(--light); }
        ::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #bbb; }

        main {
            min-height: calc(100vh - 300px);
            padding-top: 100px; /* Offset for floating nav */
        }
    </style>
</head>
<body>
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white shadow-sm py-3 mb-4">
            <div class="container">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Page Content -->
    <main class="container-fluid px-4 px-lg-5">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-white py-5 mt-5" style="background: var(--dark); border-top-left-radius: 40px; border-top-right-radius: 40px;">
        <div class="container py-4">
            <div class="row g-5">
                <div class="col-lg-5 mb-4">
                    <a class="d-flex align-items-center gap-2 mb-4 text-white text-decoration-none" href="#">
                        <div class="bg-white text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-shop fs-4"></i>
                        </div>
                        <span class="brand-font fs-3">AlazfaKuliner</span>
                    </a>
                    <p class="text-white-50" style="line-height: 1.8;">Melestarikan kekayaan kuliner nusantara dengan menghubungkan para pahlawan rasa langsung ke meja makan Anda. Jelajahi cita rasa otentik dari seluruh Indonesia.</p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#" class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1 col-md-4 mb-4">
                    <h6 class="fw-bold mb-4 text-uppercase tracking-wide text-white-50">Layanan</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3"><a href="#" class="text-white text-decoration-none opacity-75 hover-opacity-100 transition-all">Pesan Makanan</a></li>
                        <li class="mb-3"><a href="#" class="text-white text-decoration-none opacity-75 hover-opacity-100 transition-all">Daftar Mitra Toko</a></li>
                        <li class="mb-3"><a href="#" class="text-white text-decoration-none opacity-75 hover-opacity-100 transition-all">Daftar Kurir</a></li>
                        <li class="mb-3"><a href="#" class="text-white text-decoration-none opacity-75 hover-opacity-100 transition-all">Bantuan</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-8 mb-4">
                    <h6 class="fw-bold mb-4 text-uppercase tracking-wide text-white-50">Berlangganan Promo</h6>
                    <p class="small text-white-50 mb-4">Dapatkan info diskon dan rekomendasi kuliner terbaik mingguan langsung ke email Anda.</p>
                    <form class="d-flex bg-white rounded-pill p-1">
                        <input class="form-control border-0 rounded-pill shadow-none px-4" type="email" placeholder="Alamat Email Anda">
                        <button class="btn btn-primary-custom rounded-pill fw-bold" type="submit">Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
