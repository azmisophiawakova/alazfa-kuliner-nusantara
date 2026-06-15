@extends('layouts.app')

@section('content')
<div class="container-fluid px-lg-5 py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 border-bottom pb-4 gap-4">
        <div>
            <span class="text-primary-custom fw-bold text-uppercase tracking-wide small mb-1 d-block">Ruang Kurir</span>
            <h2 class="brand-font display-6 m-0 text-dark">Dashboard Kurir</h2>
            <p class="text-muted fs-5 mt-2 mb-0">Antar pesanan tepat waktu dan pastikan pelanggan puas.</p>
        </div>
        <div class="w-100 w-md-auto">
            <a href="/kurir/deliveries" class="btn btn-primary-custom rounded-pill px-4 w-100"><i class="bi bi-truck me-2"></i>Tugas Pengantaran</a>
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
        <div class="col-lg-12">
            <div class="bento-box text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--dark) 0%, #3a3a3a 100%);">
                <div class="position-absolute rounded-circle" style="width: 300px; height: 300px; background: rgba(255,255,255,0.05); top: -100px; right: -50px;"></div>
                
                <div class="position-relative z-1 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge bg-secondary text-dark px-3 py-2 rounded-pill mb-3 shadow-sm">Ujung Tombak Layanan</span>
                        <h5 class="fw-light mb-1">Semangat Bertugas,</h5>
                        <h1 class="brand-font fw-bolder mb-2" style="font-size: 2.5rem;">{{ Auth::user()->name }}</h1>
                    </div>
                    <i class="bi bi-person-badge opacity-25" style="font-size: 6rem;"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="bento-box d-flex align-items-center gap-4 p-4 border border-light" style="background: var(--surface);">
                <div class="bg-primary-custom text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 64px; height: 64px;">
                    <i class="bi bi-box-seam fs-3"></i>
                </div>
                <div>
                    <h5 class="text-muted fw-semibold mb-1">Tugas Baru</h5>
                    <h2 class="brand-font text-dark m-0">{{ $data['new_tasks'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="bento-box d-flex align-items-center gap-4 p-4 border border-light" style="background: rgba(212, 175, 55, 0.1);">
                <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 64px; height: 64px;">
                    <i class="bi bi-truck fs-3"></i>
                </div>
                <div>
                    <h5 class="text-muted fw-semibold mb-1">Sedang Diantar</h5>
                    <h2 class="brand-font text-warning m-0">{{ $data['active_deliveries'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="bento-box d-flex align-items-center gap-4 p-4 border border-light" style="background: #E8F5E9;">
                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 64px; height: 64px;">
                    <i class="bi bi-check2-circle fs-3"></i>
                </div>
                <div>
                    <h5 class="text-muted fw-semibold mb-1">Selesai Diantar</h5>
                    <h2 class="brand-font text-success m-0">{{ $data['completed_deliveries'] }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
