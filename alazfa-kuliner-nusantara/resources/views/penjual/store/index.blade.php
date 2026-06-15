@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Profil Toko</h2>
        <a href="/penjual/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
    </div>

    @if(!$store)
        <div class="alert alert-warning rounded-3 shadow-sm border-0 p-4">
            <h4 class="alert-heading fw-bold"><i class="bi bi-exclamation-triangle me-2"></i> Toko Belum Dibuat!</h4>
            <p class="mb-3">Sepertinya Anda belum menyelesaikan pengaturan profil toko.</p>
            <a href="{{ route('penjual.store.edit') }}" class="btn btn-warning fw-bold">Buat Profil Toko Sekarang</a>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <!-- Store Cover Banner -->
            <div class="bg-dark position-relative" style="height: 180px; background: linear-gradient(45deg, #1a1a1a, #4a4a4a);">
                <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                    <div class="d-flex align-items-end">
                        <div class="bg-white rounded-circle shadow p-1 me-4" style="width: 100px; height: 100px; margin-bottom: -30px;">
                            <div class="w-100 h-100 bg-light rounded-circle d-flex align-items-center justify-content-center text-muted">
                                <i class="bi bi-shop display-4"></i>
                            </div>
                        </div>
                        <div class="text-white pb-2">
                            <h3 class="fw-bold m-0">{{ $store->nama_toko }}</h3>
                            <p class="m-0 opacity-75 small"><i class="bi bi-geo-alt me-1"></i> {{ $store->alamat_toko ?? 'Alamat belum diatur' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-5 mt-3">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="fw-bold border-bottom pb-2 mb-4">Informasi Detail</h5>
                        
                        <div class="mb-4">
                            <h6 class="text-muted small fw-semibold text-uppercase mb-2">Deskripsi Toko</h6>
                            <p class="text-dark">{{ $store->deskripsi_toko ?: 'Toko ini belum menambahkan deskripsi.' }}</p>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <h6 class="text-muted small fw-semibold text-uppercase mb-2">Status Verifikasi Admin</h6>
                                @if($store->status_verifikasi == 'disetujui')
                                    <span class="badge bg-success rounded-pill px-3 py-2"><i class="bi bi-check-circle me-1"></i> Terverifikasi (Resmi)</span>
                                @elseif($store->status_verifikasi == 'menunggu konfirmasi')
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2"><i class="bi bi-hourglass-split me-1"></i> Menunggu Verifikasi Admin</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3 py-2"><i class="bi bi-x-circle me-1"></i> Ditolak</span>
                                @endif
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-muted small fw-semibold text-uppercase mb-2">Tanggal Pendaftaran</h6>
                                <p class="text-dark fw-medium"><i class="bi bi-calendar3 me-2"></i>{{ $store->created_at->format('d F Y') }}</p>
                            </div>
                        </div>
                        
                        <a href="{{ route('penjual.store.edit') }}" class="btn btn-dark rounded-3 px-4"><i class="bi bi-pencil-square me-2"></i> Edit Profil Toko</a>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="bg-light rounded-4 p-4 mt-4 mt-md-0">
                            <h6 class="fw-bold mb-3">Statistik Singkat</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total Rating:</span>
                                <span class="fw-bold"><i class="bi bi-star-fill text-warning"></i> 4.8/5</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Produk Aktif:</span>
                                <span class="fw-bold">{{ $store->products ? $store->products->count() : 0 }} Menu</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection