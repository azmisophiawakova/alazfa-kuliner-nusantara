@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0"><i class="bi bi-person-circle me-2"></i> Pengaturan Profil</h2>
        <a href="/dashboard" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-sm-5">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-sm-5">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 border-danger border-opacity-25">
                <div class="card-body p-4 p-sm-5 bg-danger bg-opacity-10 rounded-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
