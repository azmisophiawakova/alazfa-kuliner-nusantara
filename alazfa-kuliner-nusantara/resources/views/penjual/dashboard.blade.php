@extends('layouts.app')

@section('content')
<div class="container-fluid px-lg-5 py-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 pb-3 border-bottom gap-3">
        <div>
            <span class="text-primary-custom fw-bold text-uppercase tracking-wide small mb-1 d-block">Ruang Mitra</span>
            <h2 class="brand-font display-6 m-0 text-dark">Dashboard Penjual</h2>
            <p class="text-muted mt-2 mb-0">Kelola toko, pesanan, dan menu Anda di sini.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('penjual.reports.index') }}" class="btn btn-dark rounded-pill px-4"><i class="bi bi-bar-chart-fill me-2"></i>Laporan Penjualan</a>
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
        <div class="alert alert-info rounded-3 shadow-sm border-0 p-4 mb-4 d-flex align-items-center">
            <i class="bi bi-info-circle-fill fs-3 text-info me-3"></i>
            <div>
                <h5 class="alert-heading fw-bold mb-1">Menunggu Persetujuan Admin</h5>
                <p class="mb-0 small">Profil toko Anda sedang direview oleh Admin. Fitur penambahan menu akan terbuka setelah profil disetujui.</p>
            </div>
        </div>
    @elseif($data['store'] && $data['store']->status_verifikasi === 'ditolak')
        <div class="alert alert-danger rounded-3 shadow-sm border-0 p-4 mb-4 d-flex align-items-center">
            <i class="bi bi-x-circle-fill fs-3 text-danger me-3"></i>
            <div>
                <h5 class="alert-heading fw-bold mb-1">Toko Ditolak</h5>
                <p class="mb-0 small">Pendaftaran toko Anda ditolak oleh Admin. Silakan perbarui profil toko Anda untuk ditinjau kembali.</p>
            </div>
        </div>
    @endif

    <div class="row g-4 mb-5">
        <!-- Main Panel: Info & Stats -->
        <div class="col-lg-8">
            <!-- Welcome Banner -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--dark) 0%, #3a3a3a 100%);">
                <div class="position-absolute rounded-circle" style="width: 300px; height: 300px; background: rgba(255,255,255,0.05); top: -100px; right: -50px;"></div>
                <div class="card-body p-4 p-md-5 position-relative z-1 d-flex justify-content-between align-items-center h-100">
                    <div>
                        <span class="badge bg-secondary text-dark px-3 py-2 rounded-pill mb-3 shadow-sm">Pahlawan Rasa Nusantara</span>
                        <h5 class="fw-light mb-1">Selamat datang di Toko Anda,</h5>
                        <h1 class="brand-font fw-bolder m-0" style="font-size: 2.5rem;">{{ $data['store']->nama_toko ?? 'Belum ada nama toko' }}</h1>
                    </div>
                    <i class="bi bi-shop opacity-25 d-none d-md-block" style="font-size: 6rem;"></i>
                </div>
            </div>

            <!-- Pending Orders Alert Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: rgba(212, 175, 55, 0.1); border: 1px solid var(--secondary) !important;">
                <div class="card-body p-4 d-flex flex-column flex-md-row align-items-center justify-content-between gap-4 text-center text-md-start">
                    <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                        <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center shadow-sm flex-shrink-0" style="width: 64px; height: 64px;">
                            <i class="bi bi-hourglass-split fs-3"></i>
                        </div>
                        <div>
                            <h4 class="brand-font text-dark m-0">Pesanan Menunggu Diproses</h4>
                            <p class="text-muted m-0 mt-1 small">Segera proses pesanan pelanggan Anda agar mereka tidak menunggu lama.</p>
                        </div>
                    </div>
                    <h1 class="display-4 fw-bold text-warning m-0">{{ $data['pending_orders'] }}</h1>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="row g-4">
                <div class="col-sm-6">
                    <div class="bento-box bg-white d-flex align-items-center p-4 border border-light">
                        <div class="bg-primary-custom text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 56px; height: 56px;">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted fw-semibold mb-1 small text-uppercase">Total Menu</h6>
                            <h3 class="fw-bold m-0 text-dark">{{ $data['total_products'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="bento-box bg-white d-flex align-items-center p-4 border border-light">
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 56px; height: 56px;">
                            <i class="bi bi-receipt fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted fw-semibold mb-1 small text-uppercase">Pesanan Masuk</h6>
                            <h3 class="fw-bold m-0 text-dark">{{ $data['total_orders'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Panel: Quick Actions & Saldo -->
        <div class="col-lg-4">
            <!-- Saldo Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 text-white overflow-hidden" style="background: linear-gradient(135deg, #2d5a27 0%, #1e3c1a 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-medium m-0 text-white-50">Total Penghasilan</h6>
                        <i class="bi bi-wallet2 fs-4 opacity-50"></i>
                    </div>
                    <h1 class="brand-font fw-bolder mb-4" style="font-size: 2.2rem;">Rp {{ number_format(Auth::user()->saldo, 0, ',', '.') }}</h1>
                    <a href="/penjual/withdraw" class="btn btn-light w-100 rounded-pill fw-bold shadow-sm">Tarik Saldo</a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-light">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2 px-4">
                    <h5 class="fw-bold m-0"><i class="bi bi-grid-fill me-2 text-primary-custom"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body p-4 pt-2">
                    <div class="d-grid gap-3">
                        <a href="/penjual/products" class="btn btn-white text-start p-3 shadow-sm rounded-3 d-flex align-items-center border">
                            <div class="bg-primary-custom text-white rounded p-2 me-3"><i class="bi bi-box-seam fs-5"></i></div>
                            <div>
                                <h6 class="fw-bold m-0 text-dark">Kelola Menu</h6>
                                <span class="small text-muted">Tambah, edit, atau hapus hidangan</span>
                            </div>
                        </a>
                        
                        <a href="/penjual/orders" class="btn btn-white text-start p-3 shadow-sm rounded-3 d-flex align-items-center border">
                            <div class="bg-success text-white rounded p-2 me-3"><i class="bi bi-receipt fs-5"></i></div>
                            <div>
                                <h6 class="fw-bold m-0 text-dark">Pesanan Masuk</h6>
                                <span class="small text-muted">Cek & proses pesanan pelanggan</span>
                            </div>
                        </a>

                        <a href="/penjual/store" class="btn btn-white text-start p-3 shadow-sm rounded-3 d-flex align-items-center border">
                            <div class="bg-secondary text-white rounded p-2 me-3"><i class="bi bi-shop fs-5"></i></div>
                            <div>
                                <h6 class="fw-bold m-0 text-dark">Profil Toko</h6>
                                <span class="small text-muted">Atur jam buka dan informasi toko</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
