@extends('layouts.guest')

@section('content')
<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-5">
        <h3 class="text-center fw-bold mb-4">Login</h3>
        
        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label fw-medium">Email</label>
                <input id="email" type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label fw-medium">Password</label>
                <input id="password" type="password" class="form-control rounded-3 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                    <label class="form-check-label small" for="remember_me">
                        Remember me
                    </label>
                </div>
                @if (Route::has('password.request'))
                    <a class="small text-decoration-none" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-dark rounded-3 py-2 fw-bold">
                    Login
                </button>
            </div>
            
            <div class="text-center mt-4 small">
                Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Daftar sekarang</a>
            </div>
        </form>
    </div>
</div>
@endsection
