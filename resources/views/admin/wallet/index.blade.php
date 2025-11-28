<x-sb-admin-layout>
    <h1 class="h3 mb-4 text-gray-800">Request Top-up Masuk</h1>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>User</th><th>Jumlah</th><th>Waktu</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($topups as $t)
                    <tr>
                        <td>{{ $t->user->name }}</td>
                        <td>Rp {{ number_format($t->amount) }}</td>
                        <td>{{ $t->created_at->diffForHumans() }}</td>
                        <td>
                            <form action="{{ route('admin.wallet.approve', $t->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success btn-sm"><i class="fas fa-check"></i> Setujui</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">Tidak ada request pending.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-sb-admin-layout>