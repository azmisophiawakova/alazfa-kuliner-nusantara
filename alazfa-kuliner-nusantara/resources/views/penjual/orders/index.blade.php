@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Pesanan Masuk</h2>
        <a href="/penjual/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
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
                            <th class="py-3 px-4">Pelanggan</th>
                            <th class="py-3 px-4">Total Bayar</th>
                            <th class="py-3 px-4">Status Saat Ini</th>
                            <th class="py-3 px-4 text-end">Ubah Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $o)
                        <tr>
                            <td class="py-3 px-4 fw-bold">#{{ $o->id_pesanan }}</td>
                            <td class="py-3 px-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    {{ $o->user->name ?? 'User Hapus' }}
                                </div>
                            </td>
                            <td class="py-3 px-4 fw-medium text-dark">Rp {{ number_format($o->total_harga, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                @if($o->status_pesanan == 'menunggu')
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Menunggu</span>
                                @elseif($o->status_pesanan == 'diproses')
                                    <span class="badge bg-info text-dark rounded-pill px-3 py-2">Diproses</span>
                                @elseif($o->status_pesanan == 'dikirim')
                                    <span class="badge bg-primary rounded-pill px-3 py-2">Diantar Kurir</span>
                                @elseif($o->status_pesanan == 'selesai')
                                    <span class="badge bg-success rounded-pill px-3 py-2">Selesai</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3 py-2">Dibatalkan</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('penjual.orders.show', $o->id_pesanan) }}" class="btn btn-outline-primary btn-sm rounded-3 px-3">Detail & Bukti Bayar</a>
                                    <form method="POST" action="{{ route('penjual.orders.status', $o->id_pesanan) }}" class="d-flex justify-content-end gap-2">
                                        @csrf
                                        <select name="status_pesanan" class="form-select form-select-sm rounded-3" style="width: 130px;">
                                            <option value="menunggu" {{ $o->status_pesanan == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                            <option value="diproses" {{ $o->status_pesanan == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="dikirim" {{ $o->status_pesanan == 'dikirim' ? 'selected' : '' }}>Kirim (Kurir)</option>
                                            <option value="dibatalkan" {{ $o->status_pesanan == 'dibatalkan' ? 'selected' : '' }}>Batalkan</option>
                                        </select>
                                        <button type="submit" class="btn btn-dark btn-sm rounded-3 px-3">Update</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada pesanan masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
