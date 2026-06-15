@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Katalog Menu Toko</h2>
        <a href="/penjual/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Form Tambah Produk -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold border-bottom pb-3 mb-4">Tambah Menu Baru</h5>
                    <form method="POST" action="{{ route('penjual.products.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-medium">Kategori</label>
                            <select name="id_kategori" class="form-select rounded-3 @error('id_kategori') is-invalid @enderror" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $kat)
                                    <option value="{{ $kat->id_kategori }}" {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('id_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-medium">Nama Menu</label>
                            <input type="text" name="nama_produk" class="form-control rounded-3 @error('nama_produk') is-invalid @enderror" value="{{ old('nama_produk') }}" required>
                            @error('nama_produk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label text-muted small fw-medium">Harga (Rp)</label>
                                <input type="number" name="harga" class="form-control rounded-3 @error('harga') is-invalid @enderror" value="{{ old('harga') }}" required>
                                @error('harga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label text-muted small fw-medium">Stok</label>
                                <input type="number" name="stok" class="form-control rounded-3 @error('stok') is-invalid @enderror" value="{{ old('stok') }}" required>
                                @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-medium">Deskripsi Menu</label>
                            <textarea name="deskripsi_produk" class="form-control rounded-3 @error('deskripsi_produk') is-invalid @enderror" rows="2">{{ old('deskripsi_produk') }}</textarea>
                            @error('deskripsi_produk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-medium">Resep / Detail Singkat</label>
                            <textarea name="resep" class="form-control rounded-3 @error('resep') is-invalid @enderror" rows="2">{{ old('resep') }}</textarea>
                            @error('resep') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-medium">Foto Menu</label>
                            <input type="file" name="foto_produk" class="form-control rounded-3 @error('foto_produk') is-invalid @enderror">
                            @error('foto_produk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-bold"><i class="bi bi-save me-2"></i>Simpan Produk</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Produk -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4">Menu</th>
                                    <th class="py-3 px-4">Kategori</th>
                                    <th class="py-3 px-4">Harga</th>
                                    <th class="py-3 px-4">Stok</th>
                                    <th class="py-3 px-4 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $p)
                                <tr>
                                    <td class="py-3 px-4 fw-bold">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center me-3 overflow-hidden" style="width: 48px; height: 48px;">
                                                @if($p->foto_produk)
                                                    <img src="{{ asset('storage/'.$p->foto_produk) }}" class="w-100 h-100 object-fit-cover">
                                                @else
                                                    <i class="bi bi-image text-muted opacity-50"></i>
                                                @endif
                                            </div>
                                            {{ $p->nama_produk }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-muted small">{{ $p->category->nama_kategori ?? '-' }}</td>
                                    <td class="py-3 px-4 text-dark fw-medium">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4">
                                        <span class="badge {{ $p->stok > 10 ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill px-2">
                                            {{ $p->stok }} tersisa
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-end">
                                        <form method="POST" action="{{ route('penjual.products.destroy', $p->id_produk) }}" onsubmit="return confirm('Hapus menu ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger p-0 border-0 shadow-none text-decoration-none">
                                                <i class="bi bi-trash3 fs-5"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Belum ada menu yang ditambahkan.</td>
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
