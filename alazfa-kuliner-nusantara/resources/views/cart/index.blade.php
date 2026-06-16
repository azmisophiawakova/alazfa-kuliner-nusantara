@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <h2 class="fw-bold m-0">Keranjang Belanja</h2>
        <a href="/menu" class="text-decoration-none text-muted fw-medium"><i class="bi bi-arrow-left me-1"></i> Lanjut Belanja</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Cart Items -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    @php 
                        $grandTotal = 0; 
                        $storeIds = [];
                    @endphp
                    @forelse($carts as $c)
                        @php 
                            $total = $c->product->harga * $c->jumlah; 
                            $grandTotal += $total; 
                            $storeIds[] = $c->product->id_toko;
                        @endphp
                        <div class="d-flex align-items-center p-4 border-bottom position-relative">
                            <!-- Product Image -->
                            <div class="bg-light rounded-3 me-4 overflow-hidden flex-shrink-0" style="width: 100px; height: 100px;">
                                @if($c->product->foto_produk)
                                    <img src="{{ asset('storage/' . $c->product->foto_produk) }}" alt="{{ $c->product->nama_produk }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-image text-muted opacity-50 fs-3"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Info -->
                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-1">{{ $c->product->nama_produk }}</h5>
                                <p class="text-muted small mb-2"><i class="bi bi-shop me-1"></i>{{ $c->product->store->nama_toko ?? '-' }}</p>
                                <h6 class="fw-bold m-0 text-dark">Rp {{ number_format($c->product->harga, 0, ',', '.') }}</h6>
                            </div>

                            <!-- Quantity & Actions -->
                            <div class="d-flex flex-column align-items-end justify-content-between h-100" style="min-width: 120px;">
                                <!-- Delete Button -->
                                <form method="POST" action="{{ route('cart.destroy', $c->id_keranjang) }}" class="mb-3">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-0 border-0 shadow-none text-decoration-none small">
                                        <i class="bi bi-trash3 me-1"></i> Hapus
                                    </button>
                                </form>

                                <!-- Quantity Update -->
                                <form method="POST" action="{{ route('cart.update', $c->id_keranjang) }}">
                                    @csrf @method('PUT')
                                    <div class="input-group input-group-sm">
                                        <button class="btn btn-outline-secondary" type="button" onclick="this.nextElementSibling.stepDown(); this.form.submit();">-</button>
                                        <input type="number" name="jumlah" class="form-control text-center px-1" value="{{ $c->jumlah }}" min="1" style="max-width: 50px;" onchange="this.form.submit()">
                                        <button class="btn btn-outline-secondary" type="button" onclick="this.previousElementSibling.stepUp(); this.form.submit();">+</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-cart-x display-1 text-muted opacity-25"></i>
                            <h5 class="text-muted mt-3">Keranjang Anda kosong.</h5>
                            <a href="/menu" class="btn btn-dark rounded-pill mt-3 px-4">Mulai Belanja</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>
                    
                    @php
                        $uniqueStores = count(array_unique($storeIds));
                        $totalOngkir = $uniqueStores * 10000;
                        $totalBiayaAdmin = $uniqueStores * 3000;
                    @endphp
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal Produk</span>
                        <span class="fw-bold text-dark">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Ongkos Kirim ({{ $uniqueStores }} Toko)</span>
                        <span class="fw-bold text-dark">Rp {{ number_format($totalOngkir, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                        <span class="text-muted">Biaya Aplikasi ({{ $uniqueStores }}x)</span>
                        <span class="fw-bold text-dark">Rp {{ number_format($totalBiayaAdmin, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted fw-bold">Total Tagihan</span>
                        <span class="fw-bold text-dark fs-4 text-primary">Rp {{ number_format($grandTotal + $totalOngkir + $totalBiayaAdmin, 0, ',', '.') }}</span>
                    </div>
                    
                    <hr class="my-4">

                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="metode_pembayaran" class="form-label fw-bold small text-muted text-uppercase mb-2">Metode Pembayaran</label>
                            <select name="metode_pembayaran" id="metode_pembayaran" class="form-select rounded-3 py-2" required>
                                <option value="" disabled selected>Pilih Pembayaran...</option>
                                <option value="COD">Cash On Delivery (Bayar di Tempat)</option>
                                <option value="QRIS">Scan QRIS (OVO/Dana/GoPay/M-Banking)</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-dark w-100 py-3 rounded-3 fw-bold fs-6 shadow-sm" {{ $grandTotal == 0 ? 'disabled' : '' }}>
                            Checkout Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
