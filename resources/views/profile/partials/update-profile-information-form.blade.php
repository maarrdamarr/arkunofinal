<section>
    <header class="mb-4">
        <h2 class="h5 font-weight-bold text-gray-800">
            Informasi Profil
        </h2>
        <p class="text-muted small">
            Perbarui informasi profil akun dan alamat email Anda.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-group">
    <label class="text-gray-800 font-weight-bold small">Foto Profil</label>
    <div class="d-flex align-items-center">
        <div class="mr-3">
            @if(Auth::user()->avatar)
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 2px solid #ddd;">
            @else
                <div class="rounded-circle bg-gray-200 d-flex align-items-center justify-content-center text-gray-500" style="width: 80px; height: 80px; border: 2px solid #ddd;">
                    <i class="fas fa-user fa-2x"></i>
                </div>
            @endif
        </div>
        <div>
            <input type="file" name="avatar" class="form-control-file small">
            <small class="text-muted d-block mt-1">Format: JPG, PNG. Max: 2MB.</small>
        </div>
    </div>
</div>

        <div class="form-group">
            <label for="name" class="text-gray-800 font-weight-bold small">Nama Lengkap</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="text-gray-800 font-weight-bold small">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-800">
                        Email Anda belum diverifikasi.
                        <button form="send-verification" class="btn btn-link p-0 small">
                            Klik di sini untuk mengirim ulang email verifikasi.
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success small font-weight-bold">
                            Link verifikasi baru telah dikirim ke email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-4">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>

            @if (session('status') === 'profile-updated')
                <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-success small ml-3 font-weight-bold">
                    <i class="fas fa-check"></i> Tersimpan.
                </span>
            @endif
        </div>
    </form>
</section>