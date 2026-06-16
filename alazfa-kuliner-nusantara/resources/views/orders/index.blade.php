@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Riwayat Pesanan</h2>
        <a href="/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4">Order ID</th>
                            <th class="py-3 px-4">Toko Pengirim</th>
                            <th class="py-3 px-4">Total Harga</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Tanggal Order</th>
                            <th class="py-3 px-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $o)
                        <tr>
                            <td class="py-3 px-4 fw-bold text-muted">#{{ $o->id_pesanan }}</td>
                            <td class="py-3 px-4 fw-medium"><i class="bi bi-shop me-2 text-muted"></i>{{ $o->store->nama_toko ?? '-' }}</td>
                            <td class="py-3 px-4 fw-bold text-dark">Rp {{ number_format($o->total_harga, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                @if($o->status_pesanan == 'menunggu')
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Menunggu</span>
                                @elseif($o->status_pesanan == 'diproses')
                                    <span class="badge bg-info text-dark rounded-pill px-3 py-2">Diproses</span>
                                @elseif($o->status_pesanan == 'dikirim')
                                    <span class="badge bg-primary rounded-pill px-3 py-2">Sedang Diantar</span>
                                @elseif($o->status_pesanan == 'selesai')
                                    <span class="badge bg-success rounded-pill px-3 py-2">Selesai</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3 py-2">Dibatalkan</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-muted small">{{ $o->created_at->format('d M Y, H:i') }}</td>
                            <td class="py-3 px-4 text-end">
                                <a href="{{ route('orders.show', $o->id_pesanan) }}" class="btn btn-sm btn-dark rounded-3 px-3">Lihat Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada riwayat pesanan. Mari mulai berbelanja!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
