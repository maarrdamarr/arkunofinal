<x-sb-admin-layout>
    <h1 class="h3 mb-4 text-gray-800">Manajemen Pengguna</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar User Terdaftar</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="text-center">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" class="rounded-circle" style="width: 40px; height: 40px;">
            @endif
        </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge badge-{{ $user->role == 'seller' ? 'info' : 'secondary' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
    <div class="d-flex">
        <button type="button" class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#topupModal{{ $user->id }}" title="Isi Saldo Manual">
            <i class="fas fa-wallet"></i> +Saldo
        </button>

        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info btn-sm mr-1">
            <i class="fas fa-edit"></i>
        </a>

        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mem-banned user ini?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm">
                <i class="fas fa-ban"></i>
            </button>
        </form>
    </div>

    <div class="modal fade" id="topupModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Isi Saldo: {{ $user->name }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.users.topup', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Saldo Saat Ini: <strong>Rp {{ number_format($user->balance) }}</strong></label>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Tambahan (Rp)</label>
                            <input type="number" name="amount" class="form-control" placeholder="Contoh: 500000" min="1000" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Konfirmasi Top Up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-sb-admin-layout>