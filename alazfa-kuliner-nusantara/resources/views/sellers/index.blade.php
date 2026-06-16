@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="rounded-4 mb-5 position-relative overflow-hidden shadow" style="background: linear-gradient(135deg, #2b2b2b 0%, #111111 100%); min-height: 250px; display: flex; align-items: center;">
    <div class="container position-relative z-index-1 text-white text-center px-4">
        <h1 class="display-5 fw-bolder mb-2" style="letter-spacing: -1px;">DAFTAR PENJUAL TERBAIK</h1>
        <p class="lead fw-light">Temukan berbagai hidangan Nusantara dari penjual terpercaya kami.</p>
    </div>
</div>

<div class="row">
    <!-- Sidebar Filters -->
    <div class="col-md-3 mb-4">
        <form action="{{ route('sellers.index') }}" method="GET" class="card p-4 rounded-4 sticky-top" style="top: 20px;">
            <h5 class="fw-bold mb-4">Urutkan</h5>
            
            <div class="mb-4">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="sort" id="sort_terbaru" value="terbaru" {{ request('sort') == 'terbaru' || !request('sort') ? 'checked' : '' }}>
                    <label class="form-check-label" for="sort_terbaru">Terbaru</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="sort" id="sort_terpopuler" value="terpopuler" {{ request('sort') == 'terpopuler' ? 'checked' : '' }}>
                    <label class="form-check-label" for="sort_terpopuler">Terpopuler</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="sort" id="sort_rating" value="rating" {{ request('sort') == 'rating' ? 'checked' : '' }}>
                    <label class="form-check-label" for="sort_rating">Rating Tertinggi</label>
                </div>
            </div>
            
            <button type="submit" class="btn btn-dark w-100 rounded-3 fw-medium">Terapkan Filter</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="col-md-9">
        <div class="row g-4">
            @forelse($sellers as $seller)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 bg-white shadow-sm" style="border-radius: 16px; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <!-- Image Placeholder -->
                        <div class="bg-light position-relative text-center d-flex align-items-center justify-content-center" style="height: 150px; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                            @if($seller->foto_profil)
                                <img src="{{ asset('storage/' . $seller->foto_profil) }}" alt="{{ $seller->name }}" class="w-100 h-100 object-fit-cover" style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                            @else
                                <i class="bi bi-shop display-1 text-muted opacity-50"></i>
                            @endif
                        </div>
                        
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bold mb-1">{{ $seller->name }}</h5>
                            <p class="text-muted small mb-3">Terdaftar sejak {{ $seller->created_at->format('Y') }}</p>
                            
                            <a href="{{ route('sellers.show', $seller->id_toko) }}" class="btn btn-dark w-100 rounded-pill fw-medium">Kunjungi</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-shop fs-1 text-muted"></i>
                    <p class="text-muted mt-3">Belum ada penjual yang terdaftar.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection