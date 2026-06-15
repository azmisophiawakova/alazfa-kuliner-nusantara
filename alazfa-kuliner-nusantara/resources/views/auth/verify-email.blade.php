@extends('layouts.guest')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="text-center mb-4">
            <div class="display-1 text-primary opacity-25 mb-3"><i class="bi bi-envelope-check"></i></div>
            <h3 class="fw-bold text-dark">Verifikasi Email Anda</h3>
            <p class="text-muted small">Terima kasih telah mendaftar! Sebelum memulai, harap verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan. Jika Anda tidak menerima emailnya, kami dapat mengirimkan ulang.</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-sm-5 text-center">
                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success alert-dismissible fade show rounded-3 small" role="alert">
                        <i class="bi bi-check-circle me-2"></i> Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="d-flex flex-column flex-sm-row align-items-center justify-content-center gap-3 mt-2">
                    <form method="POST" action="{{ route('verification.send') }}" class="w-100">
                        @csrf
                        <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-medium">
                            <i class="bi bi-send me-1"></i> Kirim Ulang Email Verifikasi
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="w-100">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 rounded-3 py-2">
                            <i class="bi bi-box-arrow-right me-1"></i> Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
