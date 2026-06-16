@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Moderasi Produk / Menu</h2>
        <a href="/admin/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Dashboard Admin</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4">ID</th>
                            <th class="py-3 px-4">Nama Produk</th>
                            <th class="py-3 px-4">Toko</th>
                            <th class="py-3 px-4">Harga</th>
                            <th class="py-3 px-4">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $p)
                        <tr>
                            <td class="py-3 px-4 fw-bold text-muted">#{{ $p->id_produk }}</td>
                            <td class="py-3 px-4 fw-bold">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center me-3 overflow-hidden" style="width: 40px; height: 40px;">
                                        @if($p->foto_produk)
                                            <img src="{{ asset('storage/'.$p->foto_produk) }}" class="w-100 h-100 object-fit-cover">
                                        @else
                                            <i class="bi bi-image text-muted opacity-50"></i>
                                        @endif
                                    </div>
                                    {{ $p->nama_produk }}
                                </div>
                            </td>
                            <td class="py-3 px-4 text-muted">{{ $p->store->nama_toko ?? '-' }}</td>
                            <td class="py-3 px-4 text-dark fw-medium">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                <span class="badge {{ $p->stok > 0 ? 'bg-success' : 'bg-danger' }} rounded-pill px-2">
                                    {{ $p->stok }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada produk yang didaftarkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection