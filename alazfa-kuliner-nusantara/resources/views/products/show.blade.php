@extends('layouts.app')

@section('content')
<div class="container-fluid px-lg-5 py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb fw-medium">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted hover-primary">Beranda</a></li>
            <li class="breadcrumb-item"><a href="/menu" class="text-decoration-none text-muted hover-primary">Katalog</a></li>
            <li class="breadcrumb-item active text-primary-custom" aria-current="page">{{ $product->nama_produk }}</li>
        </ol>
    </nav>

    <div class="row g-5 mb-5">
        <!-- Left: Sticky Product Image -->
        <div class="col-lg-6">
            <div class="split-sticky premium-card p-2">
                <div class="w-100 h-100 bg-light rounded-4 overflow-hidden position-relative">
                    @if($product->gambar)
                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="img-fluid w-100 h-100 object-fit-cover">
                    @else
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <i class="bi bi-image display-1 text-muted opacity-25"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Scrollable Content -->
        <div class="col-lg-6">
            <div class="pe-lg-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <span class="badge bg-primary-custom rounded-pill px-4 py-2 fs-6 shadow-sm">{{ $product->category->nama_kategori ?? 'Kategori' }}</span>
                        
                        @php
                            $isFav = false;
                            if (auth()->check()) {
                                $isFav = \App\Models\Favorite::where('id_user', auth()->id())->where('id_produk', $product->id_produk)->exists();
                            }
                        @endphp

                        @if(auth()->check() && auth()->user()->role == 'pelanggan')
                            @if($isFav)
                                <form action="{{ route('favorites.destroy', \App\Models\Favorite::where('id_user', auth()->id())->where('id_produk', $product->id_produk)->first()->id_favorit) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0 text-danger fs-4"><i class="bi bi-heart-fill"></i></button>
                                </form>
                            @else
                                <form action="{{ route('favorites.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_produk" value="{{ $product->id_produk }}">
                                    <button type="submit" class="btn btn-link p-0 text-danger fs-4"><i class="bi bi-heart"></i></button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
                
                <h1 class="brand-font display-4 mb-2 text-dark">{{ $product->nama_produk }}</h1>
                <p class="text-muted fs-5 mb-4 d-flex align-items-center gap-2">
                    <i class="bi bi-shop text-primary-custom"></i>
                    {{ $product->store->nama_toko ?? 'Toko Tidak Diketahui' }}
                </p>
                
                <div class="d-flex align-items-center gap-3 mb-5 pb-4 border-bottom">
                    <h2 class="brand-font text-primary-custom m-0">Rp {{ number_format($product->harga, 0, ',', '.') }}</h2>
                    <div class="vr bg-secondary opacity-25" style="width: 2px; height: 30px;"></div>
                    <div class="d-flex align-items-center gap-1 text-warning bg-light px-3 py-1 rounded-pill">
                        <i class="bi bi-star-fill"></i>
                        <span class="text-dark fw-bold">{{ $product->reviews_avg_rating ? number_format($product->reviews_avg_rating, 1) : '0.0' }}</span>
                        <span class="text-muted small ms-1">({{ $product->reviews_count }} Ulasan)</span>
                    </div>
                </div>
                
                <div class="mb-5">
                    <h5 class="brand-font mb-3">Deskripsi Produk</h5>
                    <p class="text-muted fs-6" style="line-height: 1.8;">{{ $product->deskripsi ?: 'Tidak ada deskripsi untuk produk ini.' }}</p>
                </div>

                @if($product->resep)
                <div class="mb-5 p-4 premium-card border-start border-4" style="border-left-color: var(--secondary) !important;">
                    <h5 class="brand-font text-dark mb-3"><i class="bi bi-journal-text me-2 text-secondary-custom"></i>Resep & Cerita Kuliner</h5>
                    <p class="text-muted m-0" style="line-height: 1.8; white-space: pre-wrap;">{{ $product->resep }}</p>
                </div>
                @endif
                
                <div class="sticky-bottom bg-white p-3 rounded-4 shadow-lg border" style="bottom: 20px;">
                    <form method="POST" action="{{ route('cart.store') }}" class="d-flex gap-3 align-items-center">
                        @csrf
                        <input type="hidden" name="id_produk" value="{{ $product->id_produk }}">
                        
                        <div class="input-group bg-light rounded-pill p-1" style="width: 140px;">
                            <button class="btn rounded-circle text-dark hover-primary" type="button" id="btn-minus" onclick="document.getElementById('qty').value = Math.max(1, parseInt(document.getElementById('qty').value) - 1)">
                                <i class="bi bi-dash-lg"></i>
                            </button>
                            <input type="number" name="jumlah" id="qty" class="form-control text-center bg-transparent border-0 fw-bold fs-5" value="1" min="1" readonly>
                            <button class="btn rounded-circle text-dark hover-primary" type="button" id="btn-plus" onclick="document.getElementById('qty').value = parseInt(document.getElementById('qty').value) + 1">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>

                        <button type="submit" class="btn btn-primary-custom flex-grow-1 py-3 fs-5">
                            <i class="bi bi-cart-plus me-2"></i> Tambah ke Keranjang
                        </button>
                    </form>
                </div>
                
                <!-- Report Button -->
                @if(auth()->check() && auth()->user()->role == 'pelanggan')
                <div class="text-end mt-4">
                    <button type="button" class="btn btn-link text-danger text-decoration-none small" data-bs-toggle="modal" data-bs-target="#reportModal">
                        <i class="bi bi-flag me-1"></i> Laporkan Informasi Menu
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Review Section -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
            <h5 class="fw-bold m-0"><i class="bi bi-star-fill text-warning me-2"></i> Ulasan Pelanggan</h5>
        </div>
        <div class="card-body p-4">
            @if($product->reviews->count() > 0)
                <div class="row g-4">
                    @foreach($product->reviews as $review)
                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 bg-light h-100">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold"><i class="bi bi-person-circle me-2 text-secondary"></i>{{ $review->user->name ?? 'Pengguna' }}</span>
                                    <span class="text-muted small">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="mb-2 text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p class="text-muted m-0 small" style="line-height: 1.5;">"{{ $review->komentar }}"</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-chat-square-text display-4 text-muted opacity-25 d-block mb-3"></i>
                    <p class="text-muted m-0">Belum ada ulasan untuk produk ini. Jadilah yang pertama memberikan ulasan setelah membeli!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Report Button & Modal (Only for pelanggan) -->
    @if(auth()->check() && auth()->user()->role == 'pelanggan')
    <div class="text-end mb-5">
        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#reportModal">
            <i class="bi bi-flag me-1"></i> Laporkan Menu Ini
        </button>
    </div>

    <!-- Modal Report -->
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="reportModalLabel"><i class="bi bi-flag text-danger me-2"></i>Laporkan Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('reports.store') }}" method="POST">
                    @csrf
                    <div class="modal-body py-4">
                        <input type="hidden" name="jenis_laporan" value="produk">
                        <input type="hidden" name="id_referensi" value="{{ $product->id_produk }}">
                        
                        <p class="text-muted small mb-3">Apakah ada masalah dengan menu <strong>{{ $product->nama_produk }}</strong>? Beritahu admin dengan menjelaskan alasannya di bawah ini.</p>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Alasan Laporan</label>
                            <textarea name="alasan" class="form-control rounded-3 bg-light" rows="4" placeholder="Misal: Foto tidak pantas, deskripsi menipu, makanan tidak halal tapi tidak diberi label, dll..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-4">Kirim Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection