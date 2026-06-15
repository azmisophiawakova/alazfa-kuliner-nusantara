@extends('layouts.guest')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-dark">Konfirmasi Keamanan</h3>
            <p class="text-muted small">Ini adalah area aman aplikasi. Harap konfirmasi password Anda sebelum melanjutkan.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-sm-5">
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password Saat Ini</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 border-2 text-muted"><i class="bi bi-shield-lock"></i></span>
                            <input id="password" class="form-control border-start-0 border-2 bg-light p-2 @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password" autofocus>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-light rounded-3 px-4">Batal</a>
                        <button class="btn btn-dark rounded-3 px-4 fw-bold" type="submit">
                            Konfirmasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
