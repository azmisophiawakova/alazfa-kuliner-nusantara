@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Riwayat Pengantaran</h2>
        <a href="/kurir/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4">Order ID</th>
                            <th class="py-3 px-4">Toko Pengirim</th>
                            <th class="py-3 px-4">Penerima</th>
                            <th class="py-3 px-4">Total Tagihan</th>
                            <th class="py-3 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deliveries as $o)
                        <tr>
                            <td class="py-3 px-4 fw-bold text-muted">#{{ $o->id_pesanan }}</td>
                            <td class="py-3 px-4 fw-medium">{{ $o->store->nama_toko ?? '-' }}</td>
                            <td class="py-3 px-4 text-muted">{{ $o->user->name ?? '-' }}</td>
                            <td class="py-3 px-4 text-dark fw-bold">Rp {{ number_format($o->total_harga, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                @if($o->status_pesanan == 'selesai')
                                    <span class="badge bg-success rounded-pill px-3 py-2"><i class="bi bi-check-circle me-1"></i> Selesai</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3 py-2">{{ strtoupper($o->status_pesanan) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada riwayat pengantaran yang diselesaikan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection