@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Laporan Penjualan</h2>
        <a href="/penjual/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
    </div>

    <!-- Statistik Card -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-medium m-0 opacity-75">Total Pendapatan</h6>
                        <i class="bi bi-wallet2 fs-4 opacity-50"></i>
                    </div>
                    <h3 class="fw-bold m-0">Rp {{ number_format(collect($data)->where('status_pesanan', 'selesai')->sum('total_harga'), 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-medium m-0 opacity-75">Pesanan Sukses</h6>
                        <i class="bi bi-check-circle fs-4 opacity-50"></i>
                    </div>
                    <h3 class="fw-bold m-0">{{ collect($data)->where('status_pesanan', 'selesai')->count() }} <span class="fs-6 fw-normal">Transkasi</span></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-danger text-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-medium m-0 opacity-75">Pesanan Batal</h6>
                        <i class="bi bi-x-circle fs-4 opacity-50"></i>
                    </div>
                    <h3 class="fw-bold m-0">{{ collect($data)->where('status_pesanan', 'dibatalkan')->count() }} <span class="fs-6 fw-normal">Transaksi</span></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
            <h5 class="fw-bold m-0">Rincian Transaksi Selesai & Batal</h5>
        </div>
        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4">Order ID</th>
                            <th class="py-3 px-4">Pelanggan</th>
                            <th class="py-3 px-4">Total</th>
                            <th class="py-3 px-4">Status Akhir</th>
                            <th class="py-3 px-4 text-end">Tanggal Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(collect($data)->whereIn('status_pesanan', ['selesai', 'dibatalkan']) as $o)
                        <tr>
                            <td class="py-3 px-4 fw-bold text-muted">#{{ $o->id_pesanan }}</td>
                            <td class="py-3 px-4">{{ $o->user->name ?? '-' }}</td>
                            <td class="py-3 px-4 fw-bold">Rp {{ number_format($o->total_harga, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                @if($o->status_pesanan == 'selesai')
                                    <span class="badge bg-success rounded-pill px-3 py-2"><i class="bi bi-check me-1"></i> Selesai</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3 py-2"><i class="bi bi-x me-1"></i> Batal</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-end text-muted small">{{ $o->updated_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada data transaksi yang diselesaikan atau dibatalkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection