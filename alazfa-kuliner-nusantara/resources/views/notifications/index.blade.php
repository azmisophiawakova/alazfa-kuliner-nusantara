@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold m-0"><i class="bi bi-bell-fill text-warning me-2"></i> Notifikasi Anda</h2>
                <a href="/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($notifications as $n)
                        <div class="list-group-item p-4 hover-shadow transition-all {{ $n->status_baca ? 'bg-white opacity-75' : 'bg-light border-start border-primary border-4' }}">
                            <div class="d-flex gap-3">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                                    <i class="bi bi-info-circle-fill fs-5"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="fw-bold m-0">
                                            {{ $n->judul ?? 'Notifikasi Sistem' }}
                                            @if(!$n->status_baca)
                                                <span class="badge bg-danger ms-2" style="font-size: 0.65rem;">Baru</span>
                                            @endif
                                        </h6>
                                        <small class="text-muted">{{ isset($n->created_at) ? $n->created_at->diffForHumans() : '-' }}</small>
                                    </div>
                                    <p class="text-muted m-0 mb-2">{{ $n->pesan ?? 'Isi pesan tidak tersedia.' }}</p>
                                    
                                    @if(!$n->status_baca)
                                        <form method="POST" action="{{ route('notifications.read', $n->id_notifikasi) }}" class="text-end">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="bi bi-check2-all me-1"></i> Tandai Dibaca</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="bi bi-bell-slash display-1 text-muted opacity-25 d-block mb-3"></i>
                            <h5 class="fw-bold text-muted">Belum ada notifikasi</h5>
                            <p class="text-muted">Anda tidak memiliki pemberitahuan baru saat ini.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection