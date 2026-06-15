@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="rounded-4 mb-5 position-relative overflow-hidden shadow-lg" style="background: linear-gradient(135deg, var(--dark) 0%, #3a3a3a 100%); min-height: 500px; display: flex; align-items: center; border-radius: var(--radius-lg) !important;">
    <!-- Abstract pattern overlay -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.05; background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
    
    <div class="container position-relative z-index-1 text-white text-center px-4">
        <span class="badge bg-primary-custom mb-4 px-3 py-2 rounded-pill shadow">Aplikasi Kuliner #1 di Nusantara</span>
        <h1 class="display-2 fw-bolder mb-3 text-shadow brand-font" style="letter-spacing: -2px; text-shadow: 0 4px 20px rgba(0,0,0,0.5);">WARISAN KULINER<br><span class="text-secondary-custom">TERBAIK NUSANTARA</span></h1>
        <p class="fs-5 mb-5 opacity-75 fw-light mx-auto" style="max-width: 600px;">Temukan, pesan, dan nikmati cita rasa otentik dari seluruh pelosok Indonesia langsung ke meja makan Anda.</p>
        
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <form action="{{ route('menu.search') }}" method="GET" class="d-flex flex-column flex-md-row bg-white rounded-4 rounded-md-pill p-3 p-md-2 shadow-lg align-items-stretch align-items-md-center gap-2 gap-md-0" style="transform: translateY(20px);">
                    <i class="bi bi-search text-muted ms-4 fs-5 d-none d-md-block"></i>
                    <input type="text" name="q" class="form-control form-control-lg border-0 rounded-pill shadow-none px-4" placeholder="Cari Nasi Padang, Gudeg, Sate Lilit..." style="font-size: 1.1rem;">
                    <button type="submit" class="btn btn-primary-custom rounded-pill px-5 py-3 fs-5 mt-2 mt-md-0 w-100" style="max-width: 200px; margin: 0 auto;">Cari Menu</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Sidebar Filters -->
    <div class="col-lg-3 col-md-4 mb-5">
        <div class="sticky-top" style="top: 100px;">
            <div class="d-flex align-items-center mb-4">
                <h4 class="brand-font m-0 me-3">Kategori</h4>
                <div class="flex-grow-1 border-top" style="opacity: 0.1; border-color: var(--dark) !important;"></div>
            </div>
            
            <form action="{{ route('menu.index') }}" method="GET" class="bento-box p-4" style="border-radius: var(--radius-md);">
                <div class="mb-4">
                    <div class="form-check custom-radio mb-3">
                        <input class="form-check-input" type="radio" name="kategori" id="kat_semua" value="" checked>
                        <label class="form-check-label fw-medium ms-2" for="kat_semua">Semua Menu</label>
                    </div>
                    @foreach($categories as $kat)
                    <div class="form-check custom-radio mb-3">
                        <input class="form-check-input" type="radio" name="kategori" id="kat_{{ $kat->id_kategori }}" value="{{ $kat->id_kategori }}">
                        <label class="form-check-label fw-medium ms-2" for="kat_{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</label>
                    </div>
                    @endforeach
                </div>
                
                <button type="submit" class="btn btn-outline-custom w-100 py-2">Terapkan Filter</button>
            </form>
        </div>
    </div>

    <!-- Main Content (Rekomendasi) -->
    <div class="col-lg-9 col-md-8">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-end mb-4 pb-3 border-bottom gap-3">
            <div>
                <span class="text-primary-custom fw-bold text-uppercase tracking-wide small">Pilihan Kurator</span>
                <h2 class="brand-font m-0 mt-1">Rekomendasi Terbaik</h2>
            </div>
            <a href="/menu" class="btn btn-outline-dark rounded-pill px-4 w-100 w-md-auto" style="max-width: max-content;">Lihat Semua Menu</a>
        </div>

        @if(session('success')) 
            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert" style="background: #E8F5E9; color: #2E7D32;">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            @forelse($featured_products as $p)
                <div class="col-xl-4 col-md-6">
                    <div class="premium-card h-100 d-flex flex-column">
                        <div class="position-relative" style="height: 220px;">
                            <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="{{ $p->nama_produk }}" class="w-100 h-100 object-fit-cover">
                            
                            <!-- Badges -->
                            <div class="position-absolute top-0 start-0 p-3">
                                <span class="badge bg-white text-dark rounded-pill shadow-sm px-3 py-2 fw-bold">
                                    {{ $p->category->nama_kategori ?? 'Umum' }}
                                </span>
                            </div>
                            <div class="position-absolute top-0 end-0 p-3">
                                <span class="badge bg-white text-dark rounded-pill shadow-sm px-3 py-2 fw-bold d-flex align-items-center gap-1">
                                    <i class="bi bi-star-fill text-warning"></i> 
                                    {{ $p->reviews_count > 0 ? number_format($p->reviews_avg_rating, 1) : '0.0' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="mb-3">
                                <h5 class="brand-font mb-1"><a href="{{ route('menu.show', $p->id_produk) }}" class="text-dark text-decoration-none">{{ $p->nama_produk }}</a></h5>
                                <p class="text-muted small mb-0 d-flex align-items-center gap-1"><i class="bi bi-shop"></i> {{ $p->store->nama_toko ?? 'Toko' }}</p>
                            </div>
                            
                            <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                <h4 class="fw-bold m-0 text-primary-custom">Rp {{ number_format($p->harga, 0, ',', '.') }}</h4>
                                <form method="POST" action="{{ route('cart.store') }}">
                                    @csrf
                                    <input type="hidden" name="id_produk" value="{{ $p->id_produk }}">
                                    <input type="hidden" name="jumlah" value="1">
                                    <button type="submit" class="btn btn-primary-custom rounded-circle p-0 d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px;">
                                        <i class="bi bi-cart-plus fs-5"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="bento-box text-center py-5">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                            <i class="bi bi-search display-4 text-muted"></i>
                        </div>
                        <h4 class="brand-font">Belum ada menu</h4>
                        <p class="text-muted">Coba ubah filter atau pencarian Anda.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
