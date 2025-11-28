<x-sb-admin-layout>
    <h1 class="h3 mb-4 text-gray-800">Dompet Saya</h1>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Saldo Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format(Auth::user()->balance) }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-wallet fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-body">
                    <form action="{{ route('bidder.wallet.store') }}" method="POST">
                        @csrf
                        <label>Isi Saldo (Top Up)</label>
                        <div class="input-group">
                            <input type="number" name="amount" class="form-control" placeholder="Minimal 10.000" min="10000" required>
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit">Request</button>
                            </div>
                        </div>
                        <small class="text-muted">*Admin akan memverifikasi permintaan ini.</small>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi</h6></div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Tanggal</th><th>Jumlah</th><th>Status</th></tr></thead>
                <tbody>
                    @foreach($topups as $t)
                    <tr>
                        <td>{{ $t->created_at->format('d M Y H:i') }}</td>
                        <td>Rp {{ number_format($t->amount) }}</td>
                        <td>
                            <span class="badge badge-{{ $t->status == 'approved' ? 'success' : ($t->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($t->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-sb-admin-layout>