@extends('layouts.guest')

@section('content')
<div class="card shadow-sm border-0 rounded-4 my-5">
    <div class="card-body p-5 text-center">
        <h3 class="fw-bold mb-3">Pilih Jenis Akun</h3>
        <p class="text-muted mb-5">Silakan pilih peran Anda untuk bergabung dengan Alazfakuliner Nusantara.</p>

        <div class="d-grid gap-3">
            <a href="{{ route('register.pelanggan') }}" class="btn btn-outline-dark rounded-3 py-3 d-flex align-items-center justify-content-center fw-bold fs-5">
                <i class="bi bi-person me-3 fs-3"></i> Mendaftar sebagai Pelanggan
            </a>
            
            <a href="{{ route('register.penjual') }}" class="btn btn-outline-dark rounded-3 py-3 d-flex align-items-center justify-content-center fw-bold fs-5">
                <i class="bi bi-shop me-3 fs-3"></i> Mendaftar sebagai Penjual
            </a>

            <a href="{{ route('register.kurir') }}" class="btn btn-outline-dark rounded-3 py-3 d-flex align-items-center justify-content-center fw-bold fs-5">
                <i class="bi bi-truck me-3 fs-3"></i> Mendaftar sebagai Kurir
            </a>
        </div>
        
        <div class="mt-5 small">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Login sekarang</a>
        </div>
    </div>
</div>
@endsection
