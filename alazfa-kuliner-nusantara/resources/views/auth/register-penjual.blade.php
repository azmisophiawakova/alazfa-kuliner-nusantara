
<h1>Pendaftaran Mitra Penjual (UMKM)</h1>
<form method="POST" action="{{ route('register.penjual') }}">
    @csrf
    <h3>Data Pemilik</h3>
    <input type="text" name="name" placeholder="Nama Lengkap" required value="{{ old('name') }}"><br><br>
    <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}"><br><br>
    <input type="number" name="umur" placeholder="Umur (Min 18)" required value="{{ old('umur') }}"><br><br>
    <select name="jenis_kelamin" required>
        <option value="">-- Pilih Jenis Kelamin --</option>
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
    </select><br><br>
    <input type="text" name="no_hp" placeholder="No HP" required value="{{ old('no_hp') }}"><br><br>
    <textarea name="alamat" placeholder="Alamat Pemilik" required>{{ old('alamat') }}</textarea><br><br>
    
    <h3>Data Usaha / Toko</h3>
    <input type="text" name="nama_toko" placeholder="Nama Toko" required value="{{ old('nama_toko') }}"><br><br>
    <textarea name="alamat_toko" placeholder="Alamat Toko" required>{{ old('alamat_toko') }}</textarea><br><br>
    <textarea name="deskripsi_toko" placeholder="Deskripsi Singkat Toko">{{ old('deskripsi_toko') }}</textarea><br><br>

    <h3>Keamanan</h3>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required><br><br>
    
    @if($errors->any())
        <div style="color:red">
            <ul>@foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
        </div>
    @endif
    <button type="submit">Daftar & Buka Toko</button>
</form>
<a href="/register">Kembali ke Pemilihan Peran</a>
