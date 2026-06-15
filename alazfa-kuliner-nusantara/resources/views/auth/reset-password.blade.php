@extends('layouts.guest')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-dark">Buat Password Baru</h3>
            <p class="text-muted small">Silakan masukkan password baru Anda untuk mengamankan akun.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-sm-5">
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf
                    
                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 border-2 text-muted"><i class="bi bi-envelope"></i></span>
                            <input id="email" class="form-control border-start-0 border-2 bg-light p-2 @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 border-2 text-muted"><i class="bi bi-lock"></i></span>
                            <input id="password" class="form-control border-start-0 border-2 bg-light p-2 @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password">
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 border-2 text-muted"><i class="bi bi-lock-fill"></i></span>
                            <input id="password_confirmation" class="form-control border-start-0 border-2 bg-light p-2 @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        @error('password_confirmation')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid mt-4">
                        <button class="btn btn-dark py-2 rounded-3 fw-bold" type="submit">
                            Simpan Password Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
