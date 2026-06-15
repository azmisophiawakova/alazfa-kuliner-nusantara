@extends('layouts.guest')

@section('content')
<div class="card shadow-sm border-0 rounded-4 my-5">
    <div class="card-body p-5">
        <h3 class="text-center fw-bold mb-4">Register</h3>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label fw-medium">Name</label>
                <input id="name" type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label fw-medium">Email</label>
                <input id="email" type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Nomor Hp -->
            <div class="mb-3">
                <label for="no_hp" class="form-label fw-medium">Nomor Hp</label>
                <input id="no_hp" type="text" class="form-control rounded-3 @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp') }}">
                @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label fw-medium">Alamat Lengkap</label>
                <textarea id="alamat" class="form-control rounded-3 @error('alamat') is-invalid @enderror" name="alamat" rows="2" placeholder="Nama jalan, RT/RW, kelurahan...">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Provinsi -->
            <div class="mb-3">
                <label for="provinsi" class="form-label fw-medium">Provinsi (Penting untuk Filter Lokasi)</label>
                <select id="provinsi" name="provinsi" class="form-select rounded-3 @error('provinsi') is-invalid @enderror" required>
                    <option value="" disabled selected>Pilih Provinsi Domisili Anda</option>
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
                        <option value="{{ $prov }}" {{ old('provinsi') == $prov ? 'selected' : '' }}>{{ $prov }}</option>
                    @endforeach
                </select>
                <div class="form-text small">Lokasi ini digunakan untuk memfilter kurir dan pesanan terdekat.</div>
                @error('provinsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Jenis Kelamin -->
            <div class="mb-3">
                <label class="form-label fw-medium d-block">Jenis Kelamin</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_l" value="L" {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }}>
                    <label class="form-check-label" for="jk_l">Laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_p" value="P" {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }}>
                    <label class="form-check-label" for="jk_p">Perempuan</label>
                </div>
                @error('jenis_kelamin')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Role / Daftar Sebagai -->
            <div class="mb-3">
                <label for="role" class="form-label fw-medium">Daftar Sebagai</label>
                <select id="role" name="role" class="form-select rounded-3 @error('role') is-invalid @enderror" required>
                    <option value="pelanggan" {{ old('role') == 'pelanggan' ? 'selected' : '' }}>Pelanggan (Membeli Makanan)</option>
                    <option value="penjual" {{ old('role') == 'penjual' ? 'selected' : '' }}>Penjual / Mitra UMKM</option>
                    <option value="kurir" {{ old('role') == 'kurir' ? 'selected' : '' }}>Mitra Kurir</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label fw-medium">Password</label>
                <input id="password" type="password" class="form-control rounded-3 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-medium">Confirm Password</label>
                <input id="password_confirmation" type="password" class="form-control rounded-3" name="password_confirmation" required autocomplete="new-password">
            </div>

            <!-- Submit Button -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-dark rounded-3 py-2 fw-bold">
                    Register
                </button>
            </div>
            
            <div class="text-center mt-4 small">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Login sekarang</a>
            </div>
        </form>
    </div>
</div>
@endsection
