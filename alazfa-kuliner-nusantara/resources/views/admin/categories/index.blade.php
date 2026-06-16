@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Manajemen Kategori</h2>
        <a href="/admin/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Dashboard Admin</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Add Category Form -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Tambah Kategori Baru</h5>
                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-medium text-muted small">Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control rounded-3" required autofocus>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium text-muted small">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" class="form-control rounded-3" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-bold"><i class="bi bi-plus-lg me-2"></i>Tambah Kategori</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Categories List -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4">Kategori</th>
                                    <th class="py-3 px-4">Deskripsi</th>
                                    <th class="py-3 px-4 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $c)
                                <tr>
                                    <td class="py-3 px-4 fw-bold">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="bi bi-tag text-dark"></i>
                                            </div>
                                            {{ $c->nama_kategori }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-muted small">{{ $c->deskripsi ?: '-' }}</td>
                                    <td class="py-3 px-4 text-end">
                                        <form method="POST" action="{{ route('admin.categories.destroy', $c->id_kategori) }}" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger p-0 border-0 shadow-none text-decoration-none">
                                                <i class="bi bi-trash3 fs-5"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">Belum ada kategori terdaftar.</td>
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
