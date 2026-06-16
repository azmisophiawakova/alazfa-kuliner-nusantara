@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0"><i class="bi bi-heart-fill text-danger me-2"></i> Menu Favorit</h2>
        <a href="/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($favorites as $fav)
        <div class="col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <div class="bg-light d-flex justify-content-center align-items-center position-relative" style="height: 180px;">
                    @if(isset($fav->product) && $fav->product->foto_produk)
                        <img src="{{ asset('storage/'.$fav->product->foto_produk) }}" class="w-100 h-100 object-fit-cover">
                    @else
                        <i class="bi bi-image display-1 text-muted opacity-25"></i>
                    @endif
                    <form method="POST" action="{{ route('favorites.destroy', $fav->id_favorit) }}" class="position-absolute top-0 end-0 m-3">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-light bg-white rounded-circle shadow-sm p-2 text-danger border-0 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-heart-fill fs-5"></i>
                        </button>
                    </form>
                </div>
                
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold mb-1">{{ $fav->product->nama_produk ?? 'Produk Tidak Diketahui' }}</h5>
                    <p class="text-muted small mb-3"><i class="bi bi-shop me-1"></i>{{ $fav->product->store->nama_toko ?? 'Toko' }}</p>
                    <h5 class="fw-bold text-dark mb-4 mt-auto">Rp {{ isset($fav->product) ? number_format($fav->product->harga, 0, ',', '.') : '0' }}</h5>
                    
                    @if(isset($fav->product))
                    <div class="d-flex gap-2">
                        <form method="POST" action="{{ route('cart.store') }}" class="flex-grow-1">
                            @csrf
                            <input type="hidden" name="id_produk" value="{{ $fav->product->id_produk }}">
                            <input type="hidden" name="jumlah" value="1">
                            <button type="submit" class="btn btn-dark w-100 rounded-3"><i class="bi bi-cart-plus me-2"></i>Beli</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 bg-light rounded-4 text-center py-5">
                <div class="card-body">
                    <i class="bi bi-heart-break display-1 text-muted opacity-25 d-block mb-3"></i>
                    <h5 class="fw-bold text-muted">Belum ada menu favorit</h5>
                    <p class="text-muted mb-4">Tambahkan menu kesukaan Anda agar mudah ditemukan nanti.</p>
                    <a href="/menu" class="btn btn-dark rounded-3 px-4 py-2">Eksplor Menu</a>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection