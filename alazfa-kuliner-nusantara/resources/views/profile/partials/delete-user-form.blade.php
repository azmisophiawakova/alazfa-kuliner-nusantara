<section>
    <header class="mb-4">
        <h4 class="fw-bold text-danger">Hapus Akun</h4>
        <p class="text-danger opacity-75 small">Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Harap unduh data atau informasi yang ingin Anda simpan terlebih dahulu.</p>
    </header>

    <button type="button" class="btn btn-danger fw-bold px-4 py-2 rounded-3" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        Hapus Akun Secara Permanen
    </button>

    <!-- Modal Bootstrap 5 -->
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true" @if($errors->userDeletion->isNotEmpty()) data-bs-show="true" @endif>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="modal-header border-0 pt-4 px-4">
                        <h5 class="modal-title fw-bold text-danger" id="confirmUserDeletionModalLabel">Apakah Anda yakin ingin menghapus akun?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4 pb-4 pt-2">
                        <p class="text-muted small mb-4">Tindakan ini tidak dapat dibatalkan. Harap masukkan password Anda untuk mengkonfirmasi penghapusan permanen akun ini.</p>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input id="password" name="password" type="password" class="form-control rounded-3 p-2 border-2 @if($errors->userDeletion->has('password')) is-invalid @endif" placeholder="Masukkan password Anda">
                            @if($errors->userDeletion->has('password'))
                                <div class="invalid-feedback">{{ $errors->userDeletion->first('password') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4 pt-0">
                        <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger rounded-3 px-4">Hapus Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@if($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var myModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
        myModal.show();
    });
</script>
@endif
