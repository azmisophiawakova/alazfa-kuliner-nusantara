@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Pantau Seluruh Transaksi</h2>
        <a href="/admin/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Dashboard Admin</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4">Order ID</th>
                            <th class="py-3 px-4">Toko</th>
                            <th class="py-3 px-4">Pelanggan</th>
                            <th class="py-3 px-4">Total</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $o)
                        <tr>
                            <td class="py-3 px-4 fw-bold text-muted">#{{ $o->id_pesanan }}</td>
                            <td class="py-3 px-4 fw-medium">{{ $o->store->nama_toko ?? '-' }}</td>
                            <td class="py-3 px-4 text-muted">{{ $o->user->name ?? '-' }}</td>
                            <td class="py-3 px-4 fw-bold">Rp {{ number_format($o->total_harga, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                @if($o->status_pesanan == 'menunggu')
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Menunggu</span>
                                @elseif($o->status_pesanan == 'diproses')
                                    <span class="badge bg-info text-dark rounded-pill px-3 py-2">Diproses</span>
                                @elseif($o->status_pesanan == 'dikirim')
                                    <span class="badge bg-primary rounded-pill px-3 py-2">Dikirim</span>
                                @elseif($o->status_pesanan == 'selesai')
                                    <span class="badge bg-success rounded-pill px-3 py-2">Selesai</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3 py-2">Batal</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-end">
                                <a href="{{ route('admin.orders.show', $o->id_pesanan) }}" class="btn btn-sm btn-dark rounded-3 px-3">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada transaksi di sistem.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection