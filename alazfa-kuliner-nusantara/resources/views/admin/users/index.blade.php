@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Manajemen User</h2>
        <a href="/admin/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4">Nama Lengkap</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Peran</th>
                            <th class="py-3 px-4">Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="py-3 px-4 fw-medium">{{ $user->name }}</td>
                            <td class="py-3 px-4 text-muted">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : ($user->role == 'penjual' ? 'bg-success' : ($user->role == 'kurir' ? 'bg-warning text-dark' : 'bg-primary')) }} rounded-pill px-3 py-2">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-muted small">{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Belum ada data user.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection