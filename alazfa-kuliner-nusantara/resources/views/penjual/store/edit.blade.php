@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">{{ $store ? 'Edit Profil Toko' : 'Buat Profil Toko' }}</h2>
        <a href="/penjual/store" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Batal</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('penjual.store.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label fw-bold">Nama Toko <span class="text-danger">*</span></label>
                        <input type="text" name="nama_toko" class="form-control rounded-3 @error('nama_toko') is-invalid @enderror" value="{{ old('nama_toko', $store->nama_toko ?? '') }}" required placeholder="Contoh: Sate Khas Senayan">
                        @error('nama_toko') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Alamat Lengkap Toko <span class="text-danger">*</span></label>
                    <textarea name="alamat_toko" rows="3" class="form-control rounded-3 @error('alamat_toko') is-invalid @enderror" required placeholder="Jalan, Nomor, RT/RW, Kelurahan, Kecamatan">{{ old('alamat_toko', $store->alamat_toko ?? '') }}</textarea>
                    @error('alamat_toko') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label fw-bold">Provinsi <span class="text-danger">*</span></label>
                        <select name="provinsi" class="form-select rounded-3 @error('provinsi') is-invalid @enderror" required>
                            <option value="" disabled {{ old('provinsi', $store->provinsi ?? '') == '' ? 'selected' : '' }}>Pilih Provinsi Lokasi Toko</option>
                            @php
                                $provinsis = [
                                    'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Jambi', 'Sumatera Selatan', 'Bengkulu', 'Lampung', 'Kepulauan Bangka Belitung', 'Kepulauan Riau',
                                    'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'DI Yogyakarta', 'Jawa Timur', 'Banten',
                                    'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
                                    'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara',
                                    'Sulawesi Utara', 'Sulawesi Tengah', 'Sulawesi Selatan', 'Sulawesi Tenggara', 'Gorontalo', 'Sulawesi Barat',
                                    'Maluku', 'Maluku Utara',
                                    'Papua', 'Papua Barat', 'Papua Selatan', 'Papua Tengah', 'Papua Pegunungan', 'Papua Barat Daya'
                                ];
                            @endphp
                            @foreach($provinsis as $prov)
                                <option value="{{ $prov }}" {{ old('provinsi', $store->provinsi ?? '') == $prov ? 'selected' : '' }}>{{ $prov }}</option>
                            @endforeach
                        </select>
                        <div class="form-text small">Lokasi provinsi penting agar kurir di daerah yang sama dapat mengambil pesanan Anda.</div>
                        @error('provinsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Kota/Kabupaten <span class="text-danger">*</span></label>
                        <input type="text" name="kota" class="form-control rounded-3 @error('kota') is-invalid @enderror" value="{{ old('kota', $store->kota ?? '') }}" required placeholder="Contoh: Bandung">
                        <div class="form-text small">Ketik nama kota lokasi toko secara persis.</div>
                        @error('kota') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Deskripsi Toko</label>
                    <textarea name="deskripsi_toko" rows="4" class="form-control rounded-3 @error('deskripsi_toko') is-invalid @enderror" placeholder="Ceritakan sedikit tentang toko Anda, keunggulan, atau sejarahnya...">{{ old('deskripsi_toko', $store->deskripsi_toko ?? '') }}</textarea>
                    @error('deskripsi_toko') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4 border-top pt-4 text-end">
                    <button type="submit" class="btn btn-dark rounded-3 px-5 py-2 fw-bold">
                        <i class="bi bi-save me-2"></i> {{ $store ? 'Simpan Perubahan' : 'Buat Toko' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
