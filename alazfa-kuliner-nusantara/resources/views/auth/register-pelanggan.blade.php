
@extends('layouts.guest')

@section('content')
<div class="card shadow-sm border-0 rounded-4 my-5">
    <div class="card-body p-5">
        <h3 class="text-center fw-bold mb-4">Pendaftaran Pelanggan</h3>

        @if($errors->any())
            <div class="alert alert-danger rounded-3">
                <ul class="mb-0">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.pelanggan') }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-medium">Nama Lengkap</label>
                <input type="text" name="name" class="form-control rounded-3" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label fw-medium">Email</label>
                <input type="email" name="email" class="form-control rounded-3" value="{{ old('email') }}" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-medium">Umur</label>
                    <input type="number" name="umur" class="form-control rounded-3" value="{{ old('umur') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-medium d-block">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select rounded-3" required>
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-medium">No HP</label>
                <input type="text" name="no_hp" class="form-control rounded-3" value="{{ old('no_hp') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-medium">Alamat</label>
                <textarea name="alamat" class="form-control rounded-3" rows="2" required>{{ old('alamat') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-medium">Password</label>
                <input type="password" name="password" class="form-control rounded-3" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-medium">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control rounded-3" required>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-dark rounded-3 py-2 fw-bold">Daftar Sekarang</button>
            </div>
            
            <div class="text-center mt-4 small">
                <a href="/register" class="text-decoration-none text-muted"><i class="bi bi-arrow-left"></i> Kembali ke Pemilihan Peran</a>
            </div>
        </form>
    </div>
</div>
@endsection
