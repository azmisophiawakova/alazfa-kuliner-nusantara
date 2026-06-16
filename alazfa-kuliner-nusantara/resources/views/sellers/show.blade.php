@extends('layouts.app')

@section('content')
<!-- Seller Hero Banner -->
<div class="rounded-4 mb-5 position-relative overflow-hidden shadow-sm" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 200px;">
    <div class="container h-100 position-relative z-index-1 p-4 p-md-5 d-flex align-items-center">
        <div class="row align-items-center w-100">
            <div class="col-md-8 d-flex align-items-center gap-4">
                <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center p-1" style="width: 120px; height: 120px; flex-shrink: 0;">
                    @if($seller->foto_profil)
                        <img src="{{ asset('storage/' . $seller->foto_profil) }}" alt="{{ $seller->name }}" class="w-100 h-100 rounded-circle object-fit-cover">
                    @else
                        <i class="bi bi-shop display-4 text-muted"></i>
                    @endif
                </div>
                <div>
                    <h2 class="fw-bolder mb-1 text-dark">{{ $seller->nama_toko ?? $seller->user->name }}</h2>
                    <p class="text-muted mb-2"><i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $seller->alamat ?? 'Alamat belum diatur' }}</p>
                    <span class="badge bg-dark rounded-pill px-3 py-2"><i class="bi bi-check-circle-fill text-success me-1"></i> Terverifikasi</span>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-4 mt-md-0">
                <div class="bg-white rounded-4 p-3 shadow-sm d-inline-block text-start">
                    <p class="text-muted small mb-1">Bergabung sejak</p>
                    <h5 class="fw-bold mb-0 text-dark">{{ $seller->created_at->format('d F Y') }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deskripsi Toko -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Tentang Toko</h5>
                <p class="text-muted m-0">{{ $seller->deskripsi ?? 'Toko ini belum menambahkan deskripsi.' }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Etalase Produk -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><i class="bi bi-bag-check me-2"></i>Menu yang Dijual</h4>
</div>

<div class="row g-4">
    @forelse($seller->products as $p)
        <div class="col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="bg-light d-flex justify-content-center align-items-center position-relative overflow-hidden group" style="height: 200px;">
                    @if($p->foto_produk)
                        <img src="{{ asset('storage/'.$p->foto_produk) }}" class="w-100 h-100 object-fit-cover transition-transform duration-300" style="transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    @else
                        <i class="bi bi-image display-1 text-muted opacity-25"></i>
                    @endif
                </div>
                
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold mb-3">{{ $p->nama_produk }}</h5>
                    <h4 class="fw-bold text-dark mb-4 mt-auto">Rp {{ number_format($p->harga, 0, ',', '.') }}</h4>
                    
                    <div class="d-flex gap-2 mt-auto">
                        <form method="POST" action="{{ route('cart.store') }}" class="flex-grow-1">
                            @csrf
                            <input type="hidden" name="id_produk" value="{{ $p->id_produk }}">
                            <input type="hidden" name="jumlah" value="1">
                            <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-medium"><i class="bi bi-cart-plus me-2"></i> Beli</button>
                        </form>
                        <a href="{{ route('menu.show', $p->id_produk) }}" class="btn btn-outline-dark rounded-3 px-3 d-flex align-items-center justify-content-center">
                            <i class="bi bi-info-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-box-seam display-1 text-muted opacity-25 d-block mb-3"></i>
            <h5 class="fw-bold text-dark">Belum ada menu</h5>
            <p class="text-muted">Toko ini belum menambahkan menu apapun ke dalam etalase.</p>
        </div>
    @endforelse
</div>
@endsection
