@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Detail Transaksi <span class="text-muted">#{{ $order->id_pesanan }}</span></h2>
        <a href="/admin/orders" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Transaksi</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold m-0">Informasi Pemesanan</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <h6 class="text-muted small text-uppercase fw-semibold mb-1">Pelanggan</h6>
                            <p class="fw-bold m-0">{{ $order->user->name ?? '-' }} <br><span class="text-muted fw-normal small">{{ $order->user->email ?? '-' }}</span></p>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="text-muted small text-uppercase fw-semibold mb-1">Toko Penyedia</h6>
                            <p class="fw-bold m-0">{{ $order->store->nama_toko ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <h6 class="text-muted small text-uppercase fw-semibold mb-1">Kurir Pengantar</h6>
                            <p class="fw-bold m-0">{{ $order->kurir->name ?? 'Belum ada kurir' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="text-muted small text-uppercase fw-semibold mb-1">Waktu Transaksi</h6>
                            <p class="fw-bold m-0">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold m-0">Item Pesanan</h5>
                </div>
                <div class="card-body p-0 mt-3">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4">Menu</th>
                                    <th class="py-3 px-4">Harga Satuan</th>
                                    <th class="py-3 px-4 text-center">Jumlah</th>
                                    <th class="py-3 px-4 text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $d)
                                <tr>
                                    <td class="py-3 px-4 fw-bold">{{ $d->product->nama_produk }}</td>
                                    <td class="py-3 px-4 text-muted">Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-center fw-medium">{{ $d->jumlah }}</td>
                                    <td class="py-3 px-4 text-end fw-bold">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Status & Total</h5>
                    <div class="mb-4">
                        <p class="text-muted small mb-1 text-uppercase fw-semibold">Status Transaksi</p>
                        @if($order->status_pesanan == 'selesai')
                            <span class="badge bg-success rounded-pill px-3 py-2 fs-6 w-100">Selesai</span>
                        @elseif($order->status_pesanan == 'dibatalkan')
                            <span class="badge bg-danger rounded-pill px-3 py-2 fs-6 w-100">Dibatalkan</span>
                        @else
                            <span class="badge bg-secondary rounded-pill px-3 py-2 fs-6 w-100">{{ strtoupper($order->status_pesanan) }}</span>
                        @endif
                    </div>
                    <hr class="my-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted fw-bold">Total Pembayaran</span>
                        <h3 class="fw-bold text-dark m-0">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection