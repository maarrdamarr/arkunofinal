<section>
    <header class="mb-4">
        <h2 class="h5 font-weight-bold text-danger">Hapus Akun</h2>
        <p class="text-muted small">
            Aksi ini permanen dan tidak dapat dibatalkan.
        </p>
    </header>

    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteAccountModal">
        Hapus Akun
    </button>

    <!-- Delete Account Confirmation Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteAccountModalLabel">Konfirmasi Hapus Akun</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <p class="text-muted small mb-3">Masukkan password untuk melanjutkan.</p>
                        <div class="form-group">
                            <label for="password" class="font-weight-bold mb-2">Password</label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="form-control form-control-sm @error('password', 'userDeletion') is-invalid @enderror" 
                                placeholder="Password"
                                required
                                autocomplete="off">
                            @error('password', 'userDeletion')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger btn-sm">Hapus Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($errors->userDeletion->has('password'))
        <div class="alert alert-danger small mt-3" role="alert">
            Password anda salah.
        </div>
    @endif
</section>
