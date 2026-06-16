@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Detail Pesanan <span class="text-muted">#{{ $order->id_pesanan }}</span></h2>
        <a href="/orders" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat</a>
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
                                    <td class="py-3 px-4 fw-bold">
                                        {{ $d->product->nama_produk }}
                                        @if($order->status_pesanan == 'selesai')
                                            <div class="mt-1">
                                                <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3 py-1" style="font-size: 0.75rem;" onclick="openReviewModal('{{ $d->product->id_produk }}', '{{ $d->product->nama_produk }}')">
                                                    <i class="bi bi-star-fill me-1"></i> Beri Ulasan
                                                </button>
                                            </div>
                                        @endif
                                    </td>
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
                    <h5 class="fw-bold mb-4">Ringkasan Order</h5>
                    
                    <div class="mb-4">
                        <p class="text-muted small mb-1 text-uppercase fw-semibold">Status Pesanan</p>
                        @if($order->status_pesanan == 'menunggu')
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fs-6">Menunggu Konfirmasi</span>
                        @elseif($order->status_pesanan == 'diproses')
                            <span class="badge bg-info text-dark rounded-pill px-3 py-2 fs-6">Sedang Diproses</span>
                        @elseif($order->status_pesanan == 'dikirim')
                            <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">Diantar Kurir</span>
                        @elseif($order->status_pesanan == 'selesai')
                            <span class="badge bg-success rounded-pill px-3 py-2 fs-6">Selesai</span>
                        @else
                            <span class="badge bg-danger rounded-pill px-3 py-2 fs-6">Dibatalkan</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <p class="text-muted small mb-1 text-uppercase fw-semibold">Informasi Toko</p>
                        <p class="fw-bold m-0"><i class="bi bi-shop me-2 text-primary"></i>{{ $order->store->nama_toko ?? '-' }}</p>
                    </div>

                    <div class="mb-4">
                        <p class="text-muted small mb-1 text-uppercase fw-semibold">Kurir Pengantar</p>
                        <p class="fw-bold m-0"><i class="bi bi-truck me-2 text-success"></i>{{ $order->kurir->name ?? 'Belum dialokasikan' }}</p>
                        @if($order->foto_bukti_pengantaran)
                        <div class="mt-3">
                            <p class="text-muted small mb-1 text-uppercase fw-semibold">Bukti Pengantaran</p>
                            <a href="{{ asset('storage/' . $order->foto_bukti_pengantaran) }}" target="_blank" class="d-inline-block border rounded overflow-hidden">
                                <img src="{{ asset('storage/' . $order->foto_bukti_pengantaran) }}" alt="Bukti Pengantaran" style="max-width: 100%; height: 120px; object-fit: cover;">
                            </a>
                        </div>
                        @endif
                    </div>
                    
                    <hr class="my-4">
                    
                    @if($order->payment && $order->payment->metode_pembayaran == 'QRIS')
                    <div class="mb-4 text-center p-3 border rounded-3 bg-light">
                        <p class="text-muted small mb-2 text-uppercase fw-semibold">Silakan Pindai QRIS Berikut</p>
                        @if(\Illuminate\Support\Facades\Storage::disk('public')->exists('qris.jpg'))
                            <img src="{{ asset('storage/qris.jpg') . '?t=' . time() }}" alt="QRIS Pusat" class="img-fluid rounded mb-2" style="max-height: 250px;">
                        @else
                            <i class="bi bi-qr-code-scan text-dark" style="font-size: 5rem;"></i>
                        @endif
                        <p class="small text-muted mt-2 mb-3">Atas Nama: <strong>Alazfa Kuliner Nusantara</strong></p>
                        
                        @if(!$order->payment->bukti_pembayaran || $order->payment->status_pembayaran == 'gagal')
                            <div class="bg-white p-3 rounded border text-start">
                                <form method="POST" action="{{ route('orders.payment', $order->id_pesanan) }}" enctype="multipart/form-data">
                                    @csrf
                                    <label class="form-label small fw-bold">Unggah Bukti Transfer</label>
                                    <input type="file" name="bukti_pembayaran" class="form-control form-control-sm mb-2" required accept="image/*">
                                    <button type="submit" class="btn btn-dark btn-sm w-100">Kirim Bukti Pembayaran</button>
                                </form>
                            </div>
                        @else
                            <div class="alert alert-success py-2 mb-0 mt-2 small text-start">
                                <i class="bi bi-check-circle-fill me-1"></i> Bukti transfer terkirim. Menunggu verifikasi penjual.
                            </div>
                        @endif
                    </div>
                    @else
                    <div class="mb-4">
                        <p class="text-muted small mb-1 text-uppercase fw-semibold">Metode Pembayaran</p>
                        <p class="fw-bold m-0"><i class="bi bi-cash-coin me-2 text-warning"></i>{{ $order->payment->metode_pembayaran ?? 'COD' }}</p>
                    </div>
                    @endif
                    
                    <hr class="my-4">
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal Produk</span>
                        <span class="fw-bold text-dark">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                        <span class="text-muted">Ongkos Kirim</span>
                        <span class="fw-bold text-dark">Rp {{ number_format($order->ongkos_kirim ?? 0, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                        <span class="text-muted">Biaya Aplikasi</span>
                        <span class="fw-bold text-dark">Rp {{ number_format($order->biaya_admin ?? 0, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="text-muted fw-bold">Total Tagihan</span>
                        <h3 class="fw-bold text-primary m-0">Rp {{ number_format($order->total_harga + ($order->ongkos_kirim ?? 0) + ($order->biaya_admin ?? 0), 0, ',', '.') }}</h3>
                    </div>

                    <button type="button" class="btn btn-outline-danger w-100 mt-2 rounded-pill fw-bold" onclick="openReportModal()">
                        <i class="bi bi-exclamation-triangle me-1"></i> Laporkan Pesanan Ini
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-danger text-white border-bottom-0 pb-3 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="reportModalTitle"><i class="bi bi-shield-exclamation me-2"></i>Laporkan Pesanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="reportForm" method="POST" action="{{ route('reports.store') }}">
                    @csrf
                    <input type="hidden" name="jenis_laporan" value="pesanan">
                    <input type="hidden" name="id_referensi" value="{{ $order->id_pesanan }}">
                    
                    <div class="mb-3">
                        <p class="text-muted small mb-3">Pesanan <strong>#{{ $order->id_pesanan }}</strong> akan dilaporkan. Admin kami akan segera meninjau laporan Anda.</p>
                        <label for="alasan" class="form-label text-dark fw-bold">Alasan Melapor</label>
                        <textarea class="form-control rounded-3" name="alasan" id="alasan" rows="4" placeholder="Jelaskan masalah Anda secara detail (misal: produk rusak, kurir tidak sopan, pesanan tidak sesuai)..." required></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger px-4 rounded-pill fw-bold">Kirim Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="reviewModalTitle">Beri Ulasan Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="reviewForm" method="POST" action="{{ route('reviews.store') }}">
                    @csrf
                    <input type="hidden" name="id_produk" id="review_id_produk">
                    
                    <div class="text-center mb-4">
                        <p class="text-muted small mb-2 text-uppercase fw-semibold">Rating</p>
                        <div class="d-flex justify-content-center gap-2 flex-row-reverse" id="star-rating-container">
                            <input type="radio" name="rating" id="star5" value="5" class="d-none" required>
                            <label for="star5" class="bi bi-star fs-2 text-warning cursor-pointer" onclick="updateStars(5)"></label>
                            
                            <input type="radio" name="rating" id="star4" value="4" class="d-none">
                            <label for="star4" class="bi bi-star fs-2 text-warning cursor-pointer" onclick="updateStars(4)"></label>
                            
                            <input type="radio" name="rating" id="star3" value="3" class="d-none">
                            <label for="star3" class="bi bi-star fs-2 text-warning cursor-pointer" onclick="updateStars(3)"></label>
                            
                            <input type="radio" name="rating" id="star2" value="2" class="d-none">
                            <label for="star2" class="bi bi-star fs-2 text-warning cursor-pointer" onclick="updateStars(2)"></label>
                            
                            <input type="radio" name="rating" id="star1" value="1" class="d-none">
                            <label for="star1" class="bi bi-star fs-2 text-warning cursor-pointer" onclick="updateStars(1)"></label>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="komentar" class="form-label text-muted small text-uppercase fw-semibold">Ulasan Anda</label>
                        <textarea class="form-control rounded-3" name="komentar" id="komentar" rows="3" placeholder="Ceritakan bagaimana rasa makanannya..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-bold">Kirim Ulasan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openReviewModal(id_produk, nama_produk) {
        document.getElementById('review_id_produk').value = id_produk;
        document.getElementById('reviewModalTitle').innerText = 'Beri Ulasan: ' + nama_produk;
        // Reset stars
        updateStars(0);
        document.getElementById('komentar').value = '';
        var reviewModal = new bootstrap.Modal(document.getElementById('reviewModal'));
        reviewModal.show();
    }

    function updateStars(rating) {
        for (let i = 1; i <= 5; i++) {
            let label = document.querySelector('label[for="star' + i + '"]');
            if (i <= rating) {
                label.classList.remove('bi-star');
                label.classList.add('bi-star-fill');
            } else {
                label.classList.remove('bi-star-fill');
                label.classList.add('bi-star');
            }
        }
    }
    function openReportModal() {
        var reportModal = new bootstrap.Modal(document.getElementById('reportModal'));
        reportModal.show();
    }
</script>
<style>
    .cursor-pointer { cursor: pointer; }
    #star-rating-container label:hover,
    #star-rating-container label:hover ~ label {
        content: "\F586"; /* bi-star-fill */
    }
</style>
@endsection
