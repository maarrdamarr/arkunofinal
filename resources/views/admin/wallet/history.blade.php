<x-sb-admin-layout>
    <h1 class="h3 mb-4 text-gray-800">History Transaksi Saldo</h1>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Tipe</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                    <tr>
                        <td>{{ $t->user->name }}</td>
                        <td>
                            @if($t->amount > 0)
                                <span class="badge badge-success">Masuk</span>
                            @elseif($t->amount < 0)
                                <span class="badge badge-danger">Keluar</span>
                            @else
                                <span class="badge badge-secondary">Netral</span>
                            @endif
                        </td>
                        <td>
                            @if($t->amount > 0)
                                +Rp {{ number_format($t->amount) }}
                            @elseif($t->amount < 0)
                                -Rp {{ number_format(abs($t->amount)) }}
                            @else
                                Rp 0
                            @endif
                        </td>
                        <td>
                            @if($t->status === 'approved')
                                <span class="text-success">✓ Diterima</span>
                            @else
                                <span class="text-warning">⏳ Menunggu</span>
                            @endif
                        </td>
                        <td>{{ $t->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">Belum ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-sb-admin-layout>
