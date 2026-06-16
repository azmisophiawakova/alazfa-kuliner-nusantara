@extends('layouts.app')

@section('content')
<div class="container-fluid px-lg-5 py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-end mb-5 border-bottom pb-4 gap-4">
        <div>
            <span class="text-primary-custom fw-bold text-uppercase tracking-wide small mb-2 d-block">Eksplorasi Rasa</span>
            <h1 class="brand-font display-5 m-0 text-dark">{{ $page_title ?? 'Katalog Menu Nusantara' }}</h1>
            <p class="text-muted fs-5 mt-2 mb-0" style="max-width: 600px;">{{ $page_desc ?? 'Jelajahi ragam kuliner otentik dari seluruh penjuru Indonesia yang siap memanjakan lidah Anda.' }}</p>
        </div>
        <div class="d-flex gap-3 w-100 w-md-auto">
            <a href="/" class="btn btn-outline-custom rounded-pill px-4 flex-grow-1 flex-md-grow-0"><i class="bi bi-house me-2"></i>Beranda</a>
            <a href="/cart" class="btn btn-primary-custom rounded-pill px-4 flex-grow-1 flex-md-grow-0"><i class="bi bi-cart me-2"></i>Keranjang</a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="mb-5 bg-white p-3 rounded-pill shadow-sm border">
        <form method="GET" action="{{ route('menu.index') }}" class="d-flex flex-column flex-md-row gap-2 w-100">
            <select name="provinsi" class="form-select rounded-pill border-0 bg-light px-4" onchange="this.form.submit()">
                <option value="">Semua Daerah Nusantara</option>
                @php
                    $provinsis = [
                        'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Jambi', 'Sumatera Selatan', 'Bengkulu', 'Lampung', 'Kepulauan Bangka Belitung', 'Kepulauan Riau',
                        'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'DI Yogyakarta', 'Jawa Timur', 'Banten',
                        'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
                        'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara',
                        'Sulawesi Utara', 'Sulawesi Tengah', 'Sulawesi Selatan', 'Sulawesi Tenggara', 'Gorontalo', 'Sulawesi Barat',
                        'Maluku', 'Maluku Utara',
                        'Papua', 'Papua Barat', 'Papua Selatan', 'Papua Tengah', 'Papua Pegunungan', 'Papua Barat Daya'
                    ];
                @endphp
                @foreach($provinsis as $prov)
                    <option value="{{ $prov }}" {{ request('provinsi') == $prov ? 'selected' : '' }}>Khasiat {{ $prov }}</option>
                @endforeach
            </select>
            
            <div class="input-group">
                <input type="text" name="kota" class="form-control rounded-start-pill border-0 bg-light px-4" placeholder="Ketik nama Kota/Kabupaten..." value="{{ request('kota') }}">
                <button type="submit" class="btn btn-dark rounded-end-pill px-4">Cari</button>
            </div>

            @if(request('provinsi') || request('kota'))
                <a href="{{ route('menu.index') }}" class="btn btn-outline-danger rounded-pill px-4" data-bs-toggle="tooltip" title="Reset Filter"><i class="bi bi-x-lg"></i></a>
            @endif
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($products as $p)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="premium-card h-100 d-flex flex-column">
                <div class="position-relative" style="height: 250px;">
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
                        <h4 class="brand-font mb-2">
                            <a href="{{ route('menu.show', $p->id_produk) }}" class="text-dark text-decoration-none">{{ $p->nama_produk }}</a>
                        </h4>
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
                        <h3 class="fw-bold text-primary-custom m-0">Rp {{ number_format($p->harga, 0, ',', '.') }}</h3>
                        
                        <div class="d-flex gap-2">
                            <form method="POST" action="{{ route('cart.store') }}">
                                @csrf
                                <input type="hidden" name="id_produk" value="{{ $p->id_produk }}">
                                <input type="hidden" name="jumlah" value="1">
                                <button type="submit" class="btn btn-primary-custom rounded-circle p-0 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;" data-bs-toggle="tooltip" title="Beli Langsung">
                                    <i class="bi bi-cart-plus fs-5"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 my-5 bento-box">
            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 120px; height: 120px;">
                <i class="bi bi-search display-3 text-muted"></i>
            </div>
            <h2 class="brand-font fw-bold text-dark mb-3">Belum ada menu yang tersedia</h2>
            <p class="text-muted fs-5">Para penjual kami sedang menyiapkan hidangan terbaik mereka. Silakan periksa kembali nanti.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
