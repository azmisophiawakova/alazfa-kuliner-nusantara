@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold m-0"><i class="bi bi-wallet2 me-2"></i> Tarik Dana</h2>
                <a href="{{ Auth::user()->role == 'penjual' ? route('penjual.dashboard') : route('kurir.dashboard') }}" class="btn btn-outline-dark">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row g-4 mb-5">
                <div class="col-md-5">
                    <!-- Kartu Saldo -->
                    <div class="card bg-primary-custom text-white border-0 shadow rounded-4 h-100 overflow-hidden position-relative">
                        <div class="position-absolute top-0 end-0 p-3 opacity-25">
                            <i class="bi bi-wallet2" style="font-size: 5rem;"></i>
                        </div>
                        <div class="card-body p-4 position-relative z-1 d-flex flex-column justify-content-center">
                            <h6 class="text-white-50 text-uppercase fw-bold tracking-wide mb-1">Total Saldo Aktif</h6>
                            <h2 class="display-6 fw-bold mb-0">Rp {{ number_format(Auth::user()->saldo, 0, ',', '.') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <!-- Form Penarikan -->
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Formulir Pencairan</h5>
                            <form method="POST" action="{{ Auth::user()->role == 'penjual' ? route('penjual.withdraw.store') : route('kurir.withdraw.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-medium text-muted small">Jumlah Penarikan (Min. Rp 10.000)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0 fw-bold">Rp</span>
                                        <input type="number" name="jumlah" class="form-control bg-light border-0 py-2 @error('jumlah') is-invalid @enderror" min="10000" max="{{ Auth::user()->saldo }}" value="{{ old('jumlah') }}" required>
                                    </div>
                                    @error('jumlah') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-sm-6">
                                        <label class="form-label fw-medium text-muted small">Bank / E-Wallet</label>
                                        <input type="text" name="bank_tujuan" class="form-control bg-light border-0 py-2 @error('bank_tujuan') is-invalid @enderror" placeholder="BCA / Dana / GoPay" value="{{ old('bank_tujuan') }}" required>
                                        @error('bank_tujuan') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label fw-medium text-muted small">Nomor Rekening</label>
                                        <input type="text" name="nomor_rekening" class="form-control bg-light border-0 py-2 @error('nomor_rekening') is-invalid @enderror" value="{{ old('nomor_rekening') }}" required>
                                        @error('nomor_rekening') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-medium text-muted small">Atas Nama</label>
                                        <input type="text" name="atas_nama" class="form-control bg-light border-0 py-2 @error('atas_nama') is-invalid @enderror" value="{{ old('atas_nama') }}" required>
                                        @error('atas_nama') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-dark w-100 py-2 fw-bold rounded-3" {{ Auth::user()->saldo < 10000 ? 'disabled' : '' }}>
                                    Kirim Permintaan Tarik Dana
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Penarikan -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Riwayat Penarikan</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Rekening Tujuan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($withdrawals as $w)
                                <tr>
                                    <td>
                                        <div class="fw-medium">{{ $w->created_at->format('d M Y') }}</div>
                                        <div class="text-muted small">{{ $w->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="fw-bold">Rp {{ number_format($w->jumlah, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="fw-medium">{{ $w->bank_tujuan }} - {{ $w->nomor_rekening }}</div>
                                        <div class="text-muted small">A.n. {{ $w->atas_nama }}</div>
                                    </td>
                                    <td>
                                        @if($w->status == 'menunggu')
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Menunggu</span>
                                        @elseif($w->status == 'disetujui')
                                            <span class="badge bg-success px-3 py-2 rounded-pill">Berhasil</span>
                                        @else
                                            <span class="badge bg-danger px-3 py-2 rounded-pill">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada riwayat penarikan dana.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
