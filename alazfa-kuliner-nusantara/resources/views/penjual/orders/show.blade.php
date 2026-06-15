@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <h2 class="fw-bold m-0">Detail Pesanan Masuk <span class="text-muted">#{{ $order->id_pesanan }}</span></h2>
        <a href="/penjual/orders" class="btn btn-outline-dark w-100 w-md-auto"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
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
                    @if($order->payment && $order->payment->metode_pembayaran == 'QRIS')
                        <div class="mb-4 p-3 border rounded-3 bg-light">
                            <h6 class="fw-bold mb-3">Status Pembayaran QRIS</h6>
                            @if($order->payment->status_pembayaran == 'berhasil')
                                <span class="badge bg-success w-100 py-2 fs-6 mb-3">Pembayaran Tervalidasi</span>
                            @elseif($order->payment->bukti_pembayaran)
                                <div class="mb-3 text-center">
                                    <p class="small text-muted mb-2">Pelanggan telah mengunggah bukti transfer:</p>
                                    <a href="{{ asset('storage/' . $order->payment->bukti_pembayaran) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $order->payment->bukti_pembayaran) }}" alt="Bukti Transfer" class="img-fluid rounded border mb-3" style="max-height: 200px;">
                                    </a>
                                </div>
                                @if($order->payment->status_pembayaran == 'pending')
                                <form method="POST" action="{{ route('penjual.orders.payment', $order->id_pesanan) }}" class="d-flex gap-2">
                                    @csrf
                                    <button type="submit" name="status_pembayaran" value="gagal" class="btn btn-outline-danger w-50 btn-sm">Tolak</button>
                                    <button type="submit" name="status_pembayaran" value="berhasil" class="btn btn-success w-50 btn-sm">Terima</button>
                                </form>
                                @endif
                            @else
                                <div class="alert alert-warning small py-2 mb-0">Menunggu pelanggan mengunggah bukti transfer.</div>
                            @endif
                        </div>
                    @endif

                    @if(!$order->payment || $order->payment->metode_pembayaran == 'COD' || $order->payment->status_pembayaran == 'berhasil')
                        <form method="POST" action="{{ route('penjual.orders.status', $order->id_pesanan) }}" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-muted small text-uppercase fw-semibold">Ubah Status Pesanan</label>
                                <select name="status_pesanan" class="form-select rounded-3 border-2">
                                    <option value="menunggu" {{ $order->status_pesanan == 'menunggu' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                    <option value="diproses" {{ $order->status_pesanan == 'diproses' ? 'selected' : '' }}>Diproses (Memasak)</option>
                                    <option value="dikirim" {{ $order->status_pesanan == 'dikirim' ? 'selected' : '' }}>Kirim (Serahkan Kurir)</option>
                                    <option value="dibatalkan" {{ $order->status_pesanan == 'dibatalkan' ? 'selected' : '' }}>Batalkan Pesanan</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-bold">Simpan Perubahan</button>
                        </form>
                    @else
                        <div class="alert alert-secondary small py-2 text-center mb-4">
                            <i class="bi bi-lock-fill me-1"></i> Verifikasi pembayaran untuk memproses pesanan.
                        </div>
                    @endif

                    <div class="mb-3">
                        <h6 class="text-muted small text-uppercase fw-semibold mb-1">Pelanggan</h6>
                        <p class="fw-bold m-0"><i class="bi bi-person me-2 text-primary"></i>{{ $order->user->name ?? '-' }}</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted small text-uppercase fw-semibold mb-1">Kurir Penjemput</h6>
                        <p class="fw-bold m-0"><i class="bi bi-truck me-2 text-success"></i>{{ $order->kurir->name ?? 'Belum dialokasikan' }}</p>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted fw-semibold">Subtotal Menu (Pendapatan Toko)</span>
                        <span class="fw-bold text-dark">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                        <span class="text-muted">Ongkos Kirim (Bagian Kurir)</span>
                        <span class="fw-bold text-dark">Rp {{ number_format($order->ongkos_kirim ?? 0, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted fw-bold">Total Pembayaran Pelanggan</span>
                        <h4 class="fw-bold text-primary m-0">Rp {{ number_format($order->total_harga + ($order->ongkos_kirim ?? 0), 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection