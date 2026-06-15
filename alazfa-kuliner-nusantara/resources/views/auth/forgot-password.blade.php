@extends('layouts.guest')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-dark">Lupa Password?</h3>
            <p class="text-muted small px-3">Jangan khawatir. Cukup beri tahu kami alamat email Anda, dan kami akan mengirimkan tautan untuk membuat password baru.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-sm-5">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 small" role="alert">
                        <i class="bi bi-check-circle me-2"></i> {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 border-2 text-muted"><i class="bi bi-envelope"></i></span>
                            <input id="email" class="form-control border-start-0 border-2 bg-light p-2 @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid mt-4">
                        <button class="btn btn-dark py-2 rounded-3 fw-bold" type="submit">
                            Kirim Tautan Reset Password
                        </button>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-decoration-none small text-muted hover-dark"><i class="bi bi-arrow-left me-1"></i> Kembali ke Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
