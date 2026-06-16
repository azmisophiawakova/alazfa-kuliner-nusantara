@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Verifikasi Toko</h2>
        <div class="d-flex gap-2">
            <form action="{{ route('admin.stores.index') }}" method="GET" class="d-flex gap-2">
                <select name="status" class="form-select rounded-3" onchange="this.form.submit()">
                    <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="menunggu konfirmasi" {{ request('status') == 'menunggu konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </form>
            <a href="/admin/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
        </div>
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
                            <th class="py-3 px-4">Nama Toko</th>
                            <th class="py-3 px-4">Pemilik</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-end">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stores as $s)
                        <tr>
                            <td class="py-3 px-4 fw-bold">{{ $s->nama_toko }}</td>
                            <td class="py-3 px-4 text-muted">{{ $s->user->name ?? '-' }}</td>
                            <td class="py-3 px-4">
                                @if($s->status_verifikasi == 'menunggu konfirmasi')
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2"><i class="bi bi-hourglass-split me-1"></i> Menunggu Konfirmasi</span>
                                @elseif($s->status_verifikasi == 'disetujui')
                                    <span class="badge bg-success rounded-pill px-3 py-2"><i class="bi bi-check-circle me-1"></i> Disetujui</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3 py-2"><i class="bi bi-x-circle me-1"></i> Ditolak</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-end">
                                @if($s->status_verifikasi == 'menunggu konfirmasi')
                                    <div class="d-flex gap-2 justify-content-end">
                                        <form method="POST" action="{{ route('admin.stores.verify', $s->id_toko) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="disetujui">
                                            <button type="submit" class="btn btn-sm btn-success rounded-3 px-3"><i class="bi bi-check2"></i> Setujui</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.stores.verify', $s->id_toko) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-3"><i class="bi bi-x"></i> Tolak</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted small">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Belum ada pengajuan toko.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
