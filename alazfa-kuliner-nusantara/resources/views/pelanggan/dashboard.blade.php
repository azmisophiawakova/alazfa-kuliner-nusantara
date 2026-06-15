@extends('layouts.app')

@section('content')
<div class="container-fluid px-lg-5 py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-4">
        <div>
            <span class="text-primary-custom fw-bold text-uppercase tracking-wide small mb-1 d-block">Ruang Personal</span>
            <h2 class="brand-font display-6 m-0 text-dark">Dashboard Pelanggan</h2>
            <p class="text-muted fs-5 mt-2 mb-0">Kelola pesanan dan temukan kuliner favorit Anda.</p>
        </div>
        <div class="d-flex gap-2 w-100 w-md-auto overflow-auto pb-2 pb-md-0" style="white-space: nowrap;">
            <a href="/cart" class="btn btn-outline-custom rounded-pill px-4"><i class="bi bi-cart me-2"></i>Keranjang</a>
            <a href="/orders" class="btn btn-outline-custom rounded-pill px-4"><i class="bi bi-receipt me-2"></i>Pesanan</a>
            <a href="/menu" class="btn btn-primary-custom rounded-pill px-4"><i class="bi bi-search me-2"></i>Eksplor</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4 mb-5">
        <!-- Main Bento Box -->
        <div class="col-lg-8">
            <div class="bento-box text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);">
                <!-- Decorative Elements -->
                <div class="position-absolute rounded-circle" style="width: 300px; height: 300px; background: rgba(255,255,255,0.05); top: -100px; right: -50px;"></div>
                <div class="position-absolute rounded-circle" style="width: 200px; height: 200px; background: rgba(255,255,255,0.05); bottom: -50px; right: 150px;"></div>
                
                <div class="position-relative z-1 d-flex justify-content-between align-items-center h-100">
                    <div>
                        <span class="badge bg-white text-primary px-3 py-2 rounded-pill mb-3 shadow-sm">Selamat Datang Kembali</span>
                        <h1 class="brand-font fw-bolder mb-2" style="font-size: 2.5rem;">Halo, {{ Auth::user()->name }}</h1>
                        <p class="fs-5 opacity-75 mb-0">Siap berburu warisan kuliner hari ini?</p>
                    </div>
                    <i class="bi bi-person-heart opacity-25" style="font-size: 6rem;"></i>
                </div>
            </div>
        </div>

        <!-- Secondary Bento Boxes -->
        <div class="col-lg-4">
            <div class="row g-4 h-100">
                <div class="col-sm-6 col-lg-12 h-50">
                    <a href="/cart" class="bento-box d-flex align-items-center gap-3 text-decoration-none p-4" style="background: var(--surface);">
                        <div class="bg-primary-custom text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                            <i class="bi bi-cart3 fs-4"></i>
                        </div>
                        <div>
                            <h5 class="brand-font text-dark m-0">Keranjang</h5>
                            <span class="text-muted small">Cek belanjaan Anda</span>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-12 h-50">
                    <a href="/orders" class="bento-box d-flex align-items-center gap-3 text-decoration-none p-4" style="background: var(--surface);">
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                            <i class="bi bi-receipt fs-4"></i>
                        </div>
                        <div>
                            <h5 class="brand-font text-dark m-0">Pesanan</h5>
                            <span class="text-muted small">Lacak pesanan aktif</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center mb-4">
        <h3 class="brand-font m-0 me-3">Menu Unggulan Rekomendasi</h3>
        <div class="flex-grow-1 border-top" style="opacity: 0.1; border-color: var(--dark) !important;"></div>
    </div>

    <div class="row g-4">
        @forelse($featured_products as $p)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="premium-card h-100 d-flex flex-column">
                <div class="position-relative" style="height: 220px;">
                    <span class="badge bg-primary-custom position-absolute top-0 start-0 m-3 rounded-pill px-3 py-2 z-1 shadow-sm">
                        {{ $p->category->nama_kategori ?? 'Umum' }}
                    </span>
                    
                    <a href="{{ route('menu.show', $p->id_produk) }}" class="d-block w-100 h-100 overflow-hidden">
                        @if($p->foto_produk)
                            <img src="{{ asset('storage/'.$p->foto_produk) }}" class="w-100 h-100 object-fit-cover" style="transition: transform 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                        @else
                            <div class="w-100 h-100 bg-light d-flex justify-content-center align-items-center">
                                <i class="bi bi-image display-1 text-muted opacity-25"></i>
                            </div>
                        @endif
                    </a>
                </div>
                
                <div class="card-body p-4 d-flex flex-column">
                    <div class="mb-3">
                        <h5 class="brand-font mb-1">
                            <a href="{{ route('menu.show', $p->id_produk) }}" class="text-dark text-decoration-none">{{ $p->nama_produk }}</a>
                        </h5>
                        <p class="text-muted small mb-0 d-flex align-items-center gap-1">
                            <i class="bi bi-shop text-primary-custom"></i> {{ $p->store->nama_toko ?? 'Toko' }}
                        </p>
                    </div>
                    
                    <div class="mb-4 d-flex align-items-center bg-light p-2 rounded-3">
                        <div class="text-warning small me-2 d-flex align-items-center gap-1">
                            <i class="bi bi-star-fill"></i> <span class="fw-bold text-dark">{{ $p->reviews_count > 0 ? number_format($p->reviews_avg_rating, 1) : '0.0' }}</span>
                        </div>
                        <span class="text-muted small">({{ $p->reviews_count }} ulasan)</span>
                    </div>
                    
                    <div class="mt-auto d-flex justify-content-between align-items-center pt-3 border-top">
                        <h4 class="fw-bold text-primary-custom m-0">Rp {{ number_format($p->harga, 0, ',', '.') }}</h4>
                        
                        <div class="d-flex gap-2">
                            <form method="POST" action="{{ route('cart.store') }}">
                                @csrf
                                <input type="hidden" name="id_produk" value="{{ $p->id_produk }}">
                                <input type="hidden" name="jumlah" value="1">
                                <button type="submit" class="btn btn-primary-custom rounded-circle p-0 d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;" data-bs-toggle="tooltip" title="Beli Langsung">
                                    <i class="bi bi-cart-plus fs-5"></i>
                                </button>
                            </form>
                            <a href="{{ route('menu.show', $p->id_produk) }}" class="btn btn-outline-custom rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-eye fs-5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="bento-box text-center py-5">
                <i class="bi bi-inbox display-3 text-muted mb-3 opacity-25"></i>
                <h4 class="brand-font text-dark">Belum ada menu rekomendasi</h4>
                <p class="text-muted mt-2">Para penjual kami sedang menyiapkan hidangan unggulan.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
