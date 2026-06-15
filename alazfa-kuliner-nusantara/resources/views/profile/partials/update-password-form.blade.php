<section>
    <header class="mb-4">
        <h4 class="fw-bold text-dark">Ubah Password</h4>
        <p class="text-muted small">Pastikan akun Anda menggunakan password yang panjang, acak, dan aman.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label fw-semibold">Password Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control rounded-3 p-2 border-2 @if($errors->updatePassword->has('current_password')) is-invalid @endif" autocomplete="current-password">
            @if($errors->updatePassword->has('current_password'))
                <div class="invalid-feedback">{{ $errors->updatePassword->first('current_password') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label fw-semibold">Password Baru</label>
            <input id="update_password_password" name="password" type="password" class="form-control rounded-3 p-2 border-2 @if($errors->updatePassword->has('password')) is-invalid @endif" autocomplete="new-password">
            @if($errors->updatePassword->has('password'))
                <div class="invalid-feedback">{{ $errors->updatePassword->first('password') }}</div>
            @endif
        </div>

        <div class="mb-4">
            <label for="update_password_password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control rounded-3 p-2 border-2 @if($errors->updatePassword->has('password_confirmation')) is-invalid @endif" autocomplete="new-password">
            @if($errors->updatePassword->has('password_confirmation'))
                <div class="invalid-feedback">{{ $errors->updatePassword->first('password_confirmation') }}</div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-dark rounded-3 px-4 py-2 fw-medium">Perbarui Password</button>
            @if (session('status') === 'password-updated')
                <p class="text-success m-0 fw-bold"><i class="bi bi-check-circle me-1"></i> Berhasil diubah.</p>
            @endif
        </div>
    </form>
</section>
