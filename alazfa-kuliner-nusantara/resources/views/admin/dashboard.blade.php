@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-3 border-bottom gap-3">
        <div>
            <h2 class="fw-bold m-0 brand-font">Dashboard Admin</h2>
            <p class="text-muted mb-0">Pusat kendali utama Alazfa Kuliner Nusantara.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.reports.index') }}" class="btn btn-danger rounded-pill px-3"><i class="bi bi-shield-exclamation me-1"></i> Laporan Pengguna</a>
            <a href="{{ route('admin.system-reports.index') }}" class="btn btn-dark rounded-pill px-3"><i class="bi bi-bar-chart-fill me-1"></i> Laporan Sistem</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4 mb-4">
        <!-- Main Panel: Revenue & Stats -->
        <div class="col-lg-8">
            <!-- Revenue Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, #1e3c1a 0%, #2d5a27 100%);">
                <div class="position-absolute end-0 bottom-0 opacity-25" style="transform: translate(20%, 20%);">
                    <i class="bi bi-wallet2" style="font-size: 12rem; color: white;"></i>
                </div>
                <div class="card-body p-4 p-md-5 position-relative z-1 d-flex flex-column justify-content-center h-100">
                    <h5 class="text-white-50 fw-medium mb-2">Total Pendapatan Bersih Platform</h5>
                    <h1 class="fw-bolder m-0 text-white display-4 brand-font">Rp {{ number_format($data['total_revenue'], 0, ',', '.') }}</h1>
                    <p class="text-white-50 mt-2 mb-0"><i class="bi bi-info-circle me-1"></i> Pendapatan dari biaya aplikasi per transaksi selesai.</p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="row g-4">
                <div class="col-sm-6">
                    <div class="bento-box bg-white d-flex align-items-center p-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 56px; height: 56px;">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted fw-semibold mb-1 small text-uppercase">Total Pengguna</h6>
                            <h3 class="fw-bold m-0 text-dark">{{ $data['total_users'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="bento-box bg-white d-flex align-items-center p-4">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 56px; height: 56px;">
                            <i class="bi bi-shop fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted fw-semibold mb-1 small text-uppercase">Mitra UMKM</h6>
                            <h3 class="fw-bold m-0 text-dark">{{ $data['total_stores'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="bento-box bg-white d-flex align-items-center p-4">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 56px; height: 56px;">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted fw-semibold mb-1 small text-uppercase">Total Menu</h6>
                            <h3 class="fw-bold m-0 text-dark">{{ $data['total_products'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="bento-box bg-white d-flex align-items-center p-4">
                        <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 56px; height: 56px;">
                            <i class="bi bi-receipt fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted fw-semibold mb-1 small text-uppercase">Total Transaksi</h6>
                            <h3 class="fw-bold m-0 text-dark">{{ $data['total_orders'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Panel: Quick Actions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-light">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2 px-4">
                    <h5 class="fw-bold m-0"><i class="bi bi-grid-fill me-2 text-primary-custom"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body p-4 pt-2">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-white text-start p-3 shadow-sm rounded-3 d-flex align-items-center border">
                            <div class="bg-success text-white rounded p-2 me-3"><i class="bi bi-wallet2 fs-5"></i></div>
                            <div>
                                <h6 class="fw-bold m-0 text-dark">Pencairan Dana</h6>
                                <span class="small text-muted">Kelola request penarikan penjual & kurir</span>
                            </div>
                        </a>
                        
                        <a href="/admin/stores" class="btn btn-white text-start p-3 shadow-sm rounded-3 d-flex align-items-center border">
                            <div class="bg-primary text-white rounded p-2 me-3"><i class="bi bi-shop-window fs-5"></i></div>
                            <div>
                                <h6 class="fw-bold m-0 text-dark">Verifikasi Toko</h6>
                                <span class="small text-muted">Tinjau dan setujui pendaftaran mitra</span>
                            </div>
                        </a>

                        <a href="/admin/users" class="btn btn-white text-start p-3 shadow-sm rounded-3 d-flex align-items-center border">
                            <div class="bg-secondary text-white rounded p-2 me-3"><i class="bi bi-people-fill fs-5"></i></div>
                            <div>
                                <h6 class="fw-bold m-0 text-dark">Manajemen Pengguna</h6>
                                <span class="small text-muted">Kelola akun dan role pengguna</span>
                            </div>
                        </a>

                        <a href="/admin/categories" class="btn btn-white text-start p-3 shadow-sm rounded-3 d-flex align-items-center border">
                            <div class="bg-warning text-dark rounded p-2 me-3"><i class="bi bi-tags-fill fs-5"></i></div>
                            <div>
                                <h6 class="fw-bold m-0 text-dark">Kategori Menu</h6>
                                <span class="small text-muted">Kelola kategori makanan dan minuman</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings QRIS Card -->
    <div class="card border-0 shadow-sm rounded-4 mt-2">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
            <h5 class="fw-bold m-0"><i class="bi bi-gear-fill me-2 text-muted"></i>Pengaturan Sistem</h5>
        </div>
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8 mb-4 mb-md-0">
                    <h6 class="fw-bold">Upload QRIS Pembayaran Pusat</h6>
                    <p class="text-muted small mb-3">QRIS ini akan ditampilkan di halaman detail pesanan milik pelanggan untuk keperluan pembayaran pesanan secara manual yang akan diverifikasi oleh penjual.</p>
                    <form action="{{ route('admin.settings.qris') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column flex-sm-row gap-2 align-items-sm-end">
                        @csrf
                        <div class="flex-grow-1">
                            <label class="form-label small fw-bold mb-1">Pilih File Gambar QRIS</label>
                            <input type="file" name="qris_image" class="form-control" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-upload me-1"></i> Upload</button>
                    </form>
                </div>
                <div class="col-md-4 text-center border-start-md">
                    <p class="small fw-bold text-muted text-uppercase mb-2">QRIS Saat Ini</p>
                    @if(\Illuminate\Support\Facades\Storage::disk('public')->exists('qris.jpg'))
                        <div class="p-2 border rounded-3 bg-light d-inline-block shadow-sm">
                            <img src="{{ asset('storage/qris.jpg') . '?t=' . time() }}" alt="QRIS Pusat" class="img-fluid rounded" style="max-height: 140px;">
                        </div>
                    @else
                        <div class="bg-light mx-auto d-flex justify-content-center align-items-center rounded-3 border border-dashed" style="width: 140px; height: 140px;">
                            <i class="bi bi-qr-code-scan display-4 text-muted opacity-25"></i>
                        </div>
                        <span class="d-block small text-muted mt-2">Belum ada QRIS</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
