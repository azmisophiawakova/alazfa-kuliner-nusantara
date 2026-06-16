@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Moderasi Ulasan</h2>
        <a href="/admin/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Dashboard Admin</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4">Menu</th>
                            <th class="py-3 px-4">Pengguna</th>
                            <th class="py-3 px-4">Rating</th>
                            <th class="py-3 px-4 w-50">Ulasan</th>
                            <th class="py-3 px-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $r)
                        <tr>
                            <td class="py-3 px-4 fw-bold">{{ $r->product->nama_produk ?? '-' }}</td>
                            <td class="py-3 px-4 text-muted">{{ $r->user->name ?? '-' }}</td>
                            <td class="py-3 px-4 text-warning fw-bold"><i class="bi bi-star-fill me-1"></i>{{ $r->rating }}</td>
                            <td class="py-3 px-4 text-dark">{{ $r->komentar }}</td>
                            <td class="py-3 px-4 text-end">
                                <form method="POST" action="{{ route('admin.reviews.destroy', $r->id_ulasan) }}" onsubmit="return confirm('Hapus ulasan ini secara paksa?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3"><i class="bi bi-trash3"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada ulasan yang masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection