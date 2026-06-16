@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-dark text-white border-bottom-0 py-3 px-4">
                    <h5 class="fw-bold m-0"><i class="bi bi-speedometer2 me-2"></i> Dashboard Utama</h5>
                </div>
                <div class="card-body p-4 p-sm-5 text-center">
                    <div class="display-1 text-success opacity-25 mb-3"><i class="bi bi-check-circle-fill"></i></div>
                    <h3 class="fw-bold text-dark">Anda berhasil login!</h3>
                    <p class="text-muted">Selamat datang di Alazfa Kuliner Nusantara.</p>
                    
                    <div class="mt-4">
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-dark rounded-3 px-4">Masuk ke Panel Admin</a>
                        @elseif(Auth::user()->role === 'penjual')
                            <a href="{{ route('penjual.dashboard') }}" class="btn btn-dark rounded-3 px-4">Masuk ke Panel Penjual</a>
                        @elseif(Auth::user()->role === 'kurir')
                            <a href="{{ route('kurir.dashboard') }}" class="btn btn-dark rounded-3 px-4">Masuk ke Panel Kurir</a>
                        @else
                            <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-dark rounded-3 px-4">Masuk ke Dashboard Pelanggan</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
