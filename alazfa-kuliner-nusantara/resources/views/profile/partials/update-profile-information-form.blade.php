<section>
    <header class="mb-4">
        <h4 class="fw-bold text-dark">Informasi Profil</h4>
        <p class="text-muted small">Perbarui informasi profil dan alamat email akun Anda.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
            <input id="name" name="name" type="text" class="form-control rounded-3 p-2 border-2 @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="provinsi" class="form-label fw-semibold">Provinsi (Untuk Filter Lokasi Menu & Kurir)</label>
            <select id="provinsi" name="provinsi" class="form-select rounded-3 p-2 border-2 @error('provinsi') is-invalid @enderror" required>
                <option value="" disabled>Pilih Provinsi</option>
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
                    <option value="{{ $prov }}" {{ old('provinsi', $user->provinsi) == $prov ? 'selected' : '' }}>{{ $prov }}</option>
                @endforeach
            </select>
            @error('provinsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="kota" class="form-label fw-semibold">Kota / Kabupaten</label>
            <input id="kota" name="kota" type="text" class="form-control rounded-3 p-2 border-2 @error('kota') is-invalid @enderror" value="{{ old('kota', $user->kota) }}" placeholder="Contoh: Kota Bandung" required>
            @error('kota')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label fw-semibold">Alamat Lengkap (Beserta Kecamatan & Kode Pos)</label>
            <textarea id="alamat" name="alamat" class="form-control rounded-3 p-2 border-2 @error('alamat') is-invalid @enderror" rows="3" placeholder="Nama jalan, RT/RW, kecamatan..." required>{{ old('alamat', $user->alamat) }}</textarea>
            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="email" class="form-label fw-semibold">Alamat Email</label>
            <input id="email" name="email" type="email" class="form-control rounded-3 p-2 border-2 @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-warning small">
                    Email Anda belum diverifikasi. 
                    <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline text-decoration-none">
                        Klik di sini untuk mengirim ulang email verifikasi.
                    </button>
                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success mt-1 fw-bold">Link verifikasi baru telah dikirim ke email Anda.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-dark rounded-3 px-4 py-2 fw-medium">Simpan Perubahan</button>
            @if (session('status') === 'profile-updated')
                <p class="text-success m-0 fw-bold"><i class="bi bi-check-circle me-1"></i> Tersimpan.</p>
            @endif
        </div>
    </form>
</section>
