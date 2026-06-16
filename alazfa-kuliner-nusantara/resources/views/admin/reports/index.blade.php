@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Laporan Pengguna</h2>
        <a href="/admin/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Dashboard Admin</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4">ID Laporan</th>
                            <th class="py-3 px-4">Pelapor</th>
                            <th class="py-3 px-4">Tipe & Referensi</th>
                            <th class="py-3 px-4 w-50">Isi Laporan</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $r)
                        <tr>
                            <td class="py-3 px-4 fw-bold text-muted">#{{ $r->id_report }}</td>
                            <td class="py-3 px-4 fw-medium">{{ $r->user->name ?? '-' }}</td>
                            <td class="py-3 px-4 text-muted">
                                <span class="badge bg-secondary">{{ ucfirst($r->jenis_laporan) }} #{{ $r->id_referensi }}</span>
                            </td>
                            <td class="py-3 px-4 text-dark">{{ $r->alasan }}</td>
                            <td class="py-3 px-4 text-muted small">{{ $r->created_at->format('d M Y') }}</td>
                            <td class="py-3 px-4">
                                @if($r->status == 'selesai')
                                    <span class="badge bg-success rounded-pill px-3">Selesai</span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-pill px-3">{{ ucfirst($r->status) }}</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-end">
                                @if($r->status != 'selesai')
                                    <form method="POST" action="{{ route('admin.reports.resolve', $r->id_report) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-3"><i class="bi bi-check2 me-1"></i>Selesaikan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada laporan dari pengguna.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection