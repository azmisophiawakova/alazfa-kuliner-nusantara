@extends('layouts.app')

@section('content')
<div class="container-fluid px-lg-5 py-4">
    <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-4">
        <div>
            <span class="text-primary-custom fw-bold text-uppercase tracking-wide small mb-1 d-block">Manajemen Finansial</span>
            <h2 class="brand-font display-6 m-0 text-dark">Penarikan Dana (Withdrawal)</h2>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="alert alert-info rounded-3 shadow-sm border-0 p-4 mb-5">
        <h5 class="alert-heading fw-bold mb-2"><i class="bi bi-info-circle me-2"></i> Instruksi Admin</h5>
        <p class="mb-0">
            Aplikasi ini tidak terhubung dengan API Bank secara otomatis. 
            Jika ada status <span class="badge bg-warning text-dark px-2">Menunggu</span>, Anda <strong>wajib mentransfer manual</strong> jumlah tersebut ke rekening tujuan. 
            Setelah transfer berhasil, klik tombol <span class="text-success fw-bold"><i class="bi bi-check-circle"></i> Setujui</span> agar statusnya selesai.
        </p>
    </div>

    <div class="bento-box bg-white p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal Request</th>
                        <th>User (Role)</th>
                        <th>Jumlah Penarikan</th>
                        <th>Rekening Tujuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($withdrawals as $w)
                    <tr>
                        <td>
                            <div class="fw-medium">{{ $w->created_at->format('d M Y') }}</div>
                            <div class="text-muted small">{{ $w->created_at->format('H:i') }}</div>
                        </td>
                        <td>
                            <div class="fw-bold">{{ $w->user->name ?? 'User Dihapus' }}</div>
                            <span class="badge bg-secondary text-capitalize">{{ $w->user->role ?? '-' }}</span>
                        </td>
                        <td>
                            <h5 class="fw-bold text-primary-custom m-0">Rp {{ number_format($w->jumlah, 0, ',', '.') }}</h5>
                        </td>
                        <td>
                            <div class="fw-bold">{{ $w->bank_tujuan }}</div>
                            <div class="text-muted">{{ $w->nomor_rekening }}</div>
                            <div class="small">A.n. {{ $w->atas_nama }}</div>
                        </td>
                        <td>
                            @if($w->status == 'menunggu')
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="bi bi-clock me-1"></i> Menunggu</span>
                            @elseif($w->status == 'disetujui')
                                <span class="badge bg-success px-3 py-2 rounded-pill"><i class="bi bi-check-all me-1"></i> Disetujui</span>
                            @else
                                <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="bi bi-x me-1"></i> Ditolak</span>
                            @endif
                        </td>
                        <td>
                            @if($w->status == 'menunggu')
                            <div class="d-flex gap-2">
                                <form action="{{ route('admin.withdrawals.update', $w->id) }}" method="POST" onsubmit="return confirm('Apakah Anda YAKIN SUDAH MENTRANSFER uang ini? Status akan diubah menjadi Disetujui.')">
                                    @csrf
                                    <input type="hidden" name="status" value="disetujui">
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3" title="Sudah Ditransfer">
                                        <i class="bi bi-check-lg me-1"></i> Setujui
                                    </button>
                                </form>
                                <form action="{{ route('admin.withdrawals.update', $w->id) }}" method="POST" onsubmit="return confirm('Tolak penarikan dana ini? Saldo akan dikembalikan ke user.')">
                                    @csrf
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        <i class="bi bi-x-lg me-1"></i> Tolak
                                    </button>
                                </form>
                            </div>
                            @else
                                <span class="text-muted small"><i class="bi bi-lock-fill me-1"></i> Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted mb-2"><i class="bi bi-wallet2" style="font-size: 3rem;"></i></div>
                            <h5 class="fw-bold">Belum Ada Permintaan Penarikan</h5>
                            <p>Daftar penarikan dana dari Penjual atau Kurir akan muncul di sini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
