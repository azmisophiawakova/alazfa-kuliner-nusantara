@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Tugas Pengantaran</h2>
        <a href="/kurir/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Available Tasks -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold m-0"><i class="bi bi-inbox text-primary me-2"></i> Tersedia (Menunggu Kurir)</h5>
                </div>
                <div class="card-body p-4">
                    @forelse($available_orders as $o)
                        <div class="border rounded-4 p-3 mb-3 hover-shadow transition-all bg-light">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-warning text-dark rounded-pill">Order #{{ $o->id_pesanan }}</span>
                            </div>
                            <h6 class="fw-bold mb-1"><i class="bi bi-shop me-2 text-muted"></i>{{ $o->store->nama_toko ?? 'Toko' }}</h6>
                            <p class="text-muted small mb-3"><i class="bi bi-person me-2"></i>{{ $o->user->name ?? 'Pelanggan' }}</p>
                            
                            <form method="POST" action="{{ route('kurir.deliveries.accept', $o->id_pesanan) }}" class="d-grid">
                                @csrf
                                <button type="submit" class="btn btn-dark rounded-3 fw-medium py-2">Ambil Tugas Ini</button>
                            </form>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-emoji-smile fs-1 opacity-50 d-block mb-2"></i>
                            Belum ada tugas baru tersedia.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- My Active Deliveries -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold m-0"><i class="bi bi-truck text-success me-2"></i> Tugas Saya (Sedang Diantar)</h5>
                </div>
                <div class="card-body p-0 mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4">Order ID</th>
                                    <th class="py-3 px-4">Toko / Pelanggan</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-3 px-4 text-end">Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($my_deliveries as $o)
                                <tr>
                                    <td class="py-3 px-4 fw-bold text-muted">#{{ $o->id_pesanan }}</td>
                                    <td class="py-3 px-4">
                                        <div class="fw-bold">{{ $o->store->nama_toko ?? '-' }}</div>
                                        <div class="text-muted small"><i class="bi bi-arrow-return-right me-1"></i>{{ $o->user->name ?? '-' }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="badge bg-primary rounded-pill px-3 py-2">Di Perjalanan</span>
                                    </td>
                                    <td class="py-3 px-4 text-end">
                                        <form method="POST" action="{{ route('kurir.deliveries.status', $o->id_pesanan) }}" enctype="multipart/form-data" class="d-flex flex-column align-items-end gap-2">
                                            @csrf
                                            <div class="d-flex justify-content-end gap-2 w-100">
                                                <select name="status_pesanan" class="form-select form-select-sm rounded-3 status-select" style="width: 140px;" data-id="{{ $o->id_pesanan }}">
                                                    <option value="dikirim" selected>Sedang Dikirim</option>
                                                    <option value="selesai">Selesai / Sampai</option>
                                                </select>
                                                <button type="submit" class="btn btn-dark btn-sm rounded-3 px-3">Update</button>
                                            </div>
                                            <div class="file-upload-container d-none w-100" id="upload-{{ $o->id_pesanan }}">
                                                <input type="file" name="foto_bukti_pengantaran" class="form-control form-control-sm" accept="image/*">
                                                <small class="text-muted" style="font-size: 0.7rem;">Wajib foto bukti jika selesai</small>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">Anda tidak memiliki tugas yang sedang berjalan.</td>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.status-select').forEach(function(select) {
            select.addEventListener('change', function() {
                const id = this.getAttribute('data-id');
                const uploadContainer = document.getElementById('upload-' + id);
                if (this.value === 'selesai') {
                    uploadContainer.classList.remove('d-none');
                    uploadContainer.querySelector('input').setAttribute('required', 'required');
                } else {
                    uploadContainer.classList.add('d-none');
                    uploadContainer.querySelector('input').removeAttribute('required');
                }
            });
        });
    });
</script>
@endsection
