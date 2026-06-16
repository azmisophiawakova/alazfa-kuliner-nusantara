@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold m-0">Laporan Sistem Keseluruhan</h2>
            <p class="text-muted mb-0">Rangkuman aktivitas dan performa platform Alazfa Kuliner Nusantara.</p>
        </div>
        <a href="/admin/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Dashboard Admin</a>
    </div>

    <!-- Pendapatan & Pesanan -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-primary text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold m-0 opacity-75">Total Transaksi Platform</h6>
                        <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold m-0">Rp {{ number_format($data['total_revenue'], 0, ',', '.') }}</h3>
                    <p class="small opacity-75 mt-2 mb-0">Seluruh pesanan berstatus selesai</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-info text-dark">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold m-0 opacity-75">Penjualan 7 Hari Terakhir</h6>
                        <div class="bg-white text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold m-0">Rp {{ number_format($data['weekly_sales'], 0, ',', '.') }}</h3>
                    <p class="small opacity-75 mt-2 mb-0">Tren penjualan platform terbaru</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-success text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold m-0 opacity-75">Pesanan Selesai</h6>
                        <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold m-0">{{ $data['completed_orders'] }} <span class="fs-6 fw-normal">dari {{ $data['total_orders'] }} pesanan</span></h3>
                    <p class="small opacity-75 mt-2 mb-0">Pesanan berhasil diantarkan</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-danger text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold m-0 opacity-75">Pesanan Dibatalkan</h6>
                        <div class="bg-white text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-x-circle"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold m-0">{{ $data['canceled_orders'] }} <span class="fs-6 fw-normal">pesanan</span></h3>
                    <p class="small opacity-75 mt-2 mb-0">Pesanan gagal atau dibatalkan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Pengguna -->
    <h5 class="fw-bold mb-3 mt-5">Demografi Pengguna & Ekosistem</h5>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="row text-center h-100 align-items-center">
                        <div class="col-sm-3 border-end border-light">
                            <i class="bi bi-people display-4 text-primary mb-2"></i>
                            <h3 class="fw-bold text-dark m-0">{{ $data['total_users'] }}</h3>
                            <p class="text-muted small m-0">Total Pengguna Aktif</p>
                        </div>
                        <div class="col-sm-3 border-end border-light">
                            <i class="bi bi-person-heart display-4 text-success mb-2"></i>
                            <h3 class="fw-bold text-dark m-0">{{ $data['total_pelanggan'] }}</h3>
                            <p class="text-muted small m-0">Pelanggan</p>
                        </div>
                        <div class="col-sm-3 border-end border-light">
                            <i class="bi bi-shop display-4 text-warning mb-2"></i>
                            <h3 class="fw-bold text-dark m-0">{{ $data['total_penjual'] }}</h3>
                            <p class="text-muted small m-0">Mitra UMKM</p>
                        </div>
                        <div class="col-sm-3">
                            <i class="bi bi-scooter display-4 text-info mb-2"></i>
                            <h3 class="fw-bold text-dark m-0">{{ $data['total_kurir'] }}</h3>
                            <p class="text-muted small m-0">Kurir Pengantar</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-light">
                <div class="card-body p-4 text-center d-flex flex-column justify-content-center">
                    <i class="bi bi-storefront display-3 text-secondary mb-3"></i>
                    <h2 class="fw-bold text-dark m-0">{{ $data['approved_stores'] }} <span class="fs-5 text-muted fw-normal">/ {{ $data['total_stores'] }}</span></h2>
                    <p class="text-muted m-0 mt-2">Toko Terverifikasi dari Total Pendaftar</p>
                    <a href="{{ route('admin.stores.index') }}" class="btn btn-outline-secondary mt-3 rounded-pill btn-sm mx-auto" style="max-width: 150px;">Kelola Toko</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
