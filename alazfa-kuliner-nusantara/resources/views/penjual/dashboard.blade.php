@extends('layouts.app')

@section('content')
<div class="container-fluid px-lg-5 py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 border-bottom pb-4 gap-4">
        <div>
            <span class="text-primary-custom fw-bold text-uppercase tracking-wide small mb-1 d-block">Ruang Mitra</span>
            <h2 class="brand-font display-6 m-0 text-dark">Dashboard Penjual</h2>
            <p class="text-muted fs-5 mt-2 mb-0">Kelola toko, pesanan, dan menu Anda di sini.</p>
        </div>
        <div class="d-flex gap-2 w-100 w-md-auto overflow-auto pb-2 pb-md-0" style="white-space: nowrap;">
            <a href="/penjual/products" class="btn btn-outline-custom rounded-pill px-4"><i class="bi bi-box-seam me-2"></i>Kelola Menu</a>
            <a href="/penjual/orders" class="btn btn-outline-custom rounded-pill px-4"><i class="bi bi-receipt me-2"></i>Pesanan Masuk</a>
            <a href="/penjual/store" class="btn btn-primary-custom rounded-pill px-4"><i class="bi bi-shop me-2"></i>Profil Toko</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($data['store'] && $data['store']->status_verifikasi === 'menunggu konfirmasi')
        <div class="alert alert-info rounded-3 shadow-sm border-0 p-4 mb-4">
            <h5 class="alert-heading fw-bold mb-2"><i class="bi bi-info-circle me-2"></i> Menunggu Persetujuan Admin</h5>
            <p class="mb-0">Profil toko Anda sedang direview oleh Admin. Fitur penambahan menu (Kelola Menu) akan terbuka setelah profil Anda disetujui.</p>
        </div>
    @elseif($data['store'] && $data['store']->status_verifikasi === 'ditolak')
        <div class="alert alert-danger rounded-3 shadow-sm border-0 p-4 mb-4">
            <h5 class="alert-heading fw-bold mb-2"><i class="bi bi-x-circle me-2"></i> Toko Ditolak</h5>
            <p class="mb-0">Maaf, pendaftaran toko Anda ditolak oleh Admin. Silakan perbarui profil toko Anda untuk ditinjau kembali.</p>
        </div>
    @endif

    <div class="row g-4 mb-5">
        <!-- Main Bento Box -->
        <div class="col-lg-8">
            <div class="bento-box text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--dark) 0%, #3a3a3a 100%);">
                <div class="position-absolute rounded-circle" style="width: 300px; height: 300px; background: rgba(255,255,255,0.05); top: -100px; right: -50px;"></div>
                
                <div class="position-relative z-1 d-flex justify-content-between align-items-center h-100">
                    <div>
                        <span class="badge bg-secondary text-dark px-3 py-2 rounded-pill mb-3 shadow-sm">Pahlawan Rasa Nusantara</span>
                        <h5 class="fw-light mb-1">Selamat datang di Toko Anda,</h5>
                        <h1 class="brand-font fw-bolder mb-2" style="font-size: 2.5rem;">{{ $data['store']->nama_toko ?? 'Belum ada nama toko' }}</h1>
                    </div>
                    <i class="bi bi-shop opacity-25" style="font-size: 6rem;"></i>
                </div>
            </div>
        </div>

        <!-- Stats Bento Boxes -->
        <div class="col-lg-4">
            <div class="row g-4 h-100">
                <div class="col-sm-6 col-lg-12 h-50">
                    <div class="bento-box d-flex align-items-center gap-3 p-4 bg-white border border-light">
                        <div class="bg-primary-custom text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>
                        <div>
                            <h5 class="brand-font text-dark m-0">Total Menu</h5>
                            <h3 class="fw-bold text-primary-custom m-0 mt-1">{{ $data['total_products'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-12 h-50">
                    <div class="bento-box d-flex align-items-center gap-3 p-4 bg-white border border-light">
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                            <i class="bi bi-receipt fs-4"></i>
                        </div>
                        <div>
                            <h5 class="brand-font text-dark m-0">Pesanan Masuk</h5>
                            <h3 class="fw-bold text-dark m-0 mt-1">{{ $data['total_orders'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-12">
            <div class="bento-box d-flex flex-column flex-md-row align-items-center justify-content-between p-4 gap-4 text-center text-md-start" style="background: rgba(212, 175, 55, 0.1); border: 1px solid var(--secondary);">
                <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                    <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center shadow-sm flex-shrink-0" style="width: 64px; height: 64px;">
                        <i class="bi bi-hourglass-split fs-3"></i>
                    </div>
                    <div>
                        <h4 class="brand-font text-dark m-0">Pesanan Menunggu Diproses</h4>
                        <p class="text-muted m-0 mt-1">Segera proses pesanan pelanggan Anda agar mereka tidak menunggu lama.</p>
                    </div>
                </div>
                <h1 class="display-4 fw-bold text-warning m-0">{{ $data['pending_orders'] }}</h1>
            </div>
        </div>
    </div>
</div>
@endsection
