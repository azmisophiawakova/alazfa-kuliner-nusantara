@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold m-0">Laporan Penjualan</h2>
            <p class="text-muted mb-0">Rangkuman pendapatan toko Anda.</p>
        </div>
        <div class="d-flex gap-2">
            <form action="{{ route('penjual.reports.index') }}" method="GET" class="d-flex gap-2">
                <select name="filter" class="form-select" onchange="this.form.submit()">
                    <option value="semua" {{ $data['filter'] == 'semua' ? 'selected' : '' }}>Sepanjang Waktu</option>
                    <option value="mingguan" {{ $data['filter'] == 'mingguan' ? 'selected' : '' }}>7 Hari Terakhir</option>
                    <option value="bulanan" {{ $data['filter'] == 'bulanan' ? 'selected' : '' }}>Bulan Ini</option>
                </select>
            </form>
            <a href="/penjual/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
        </div>
    </div>

    <!-- Statistik Card -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-medium m-0 opacity-75">Total Pendapatan Bersih</h6>
                        <i class="bi bi-wallet2 fs-4 opacity-50"></i>
                    </div>
                    <h3 class="fw-bold m-0">Rp {{ number_format($data['total_sales'], 0, ',', '.') }}</h3>
                    <p class="small opacity-75 mb-0 mt-2">Berdasarkan filter: {{ ucfirst($data['filter']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-medium m-0 opacity-75">Pesanan Sukses</h6>
                        <i class="bi bi-check-circle fs-4 opacity-50"></i>
                    </div>
                    <h3 class="fw-bold m-0">{{ $data['orders_completed'] }} <span class="fs-6 fw-normal">Transaksi</span></h3>
                    <p class="small opacity-75 mb-0 mt-2">Berdasarkan filter: {{ ucfirst($data['filter']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
            <h5 class="fw-bold m-0">Rincian Transaksi Selesai</h5>
        </div>
        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4">Order ID</th>
                            <th class="py-3 px-4">Pelanggan</th>
                            <th class="py-3 px-4">Total Pendapatan</th>
                            <th class="py-3 px-4 text-end">Tanggal Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['orders_list'] as $o)
                        <tr>
                            <td class="py-3 px-4 fw-bold text-muted">#{{ $o->id_pesanan }}</td>
                            <td class="py-3 px-4">{{ $o->user->name ?? '-' }}</td>
                            <td class="py-3 px-4 fw-bold text-success">Rp {{ number_format($o->total_harga, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-end text-muted small">{{ $o->updated_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Belum ada data transaksi untuk rentang waktu ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection