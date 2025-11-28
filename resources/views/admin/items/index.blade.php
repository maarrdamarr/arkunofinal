<x-sb-admin-layout>
    <h1 class="h3 mb-4 text-gray-800">Pengawasan Barang</h1>
    <p class="mb-4">Admin dapat menghapus barang yang melanggar aturan lelang.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Semua Barang Lelang (Seller)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Barang</th>
                            <th>Penjual</th>
                            <th>Harga Awal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" width="50" class="rounded">
                                @else
                                    <span class="text-muted">No Img</span>
                                @endif
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>Rp {{ number_format($item->start_price) }}</td>
                            <td>
                                <span class="badge badge-{{ $item->status == 'open' ? 'success' : 'danger' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus paksa barang ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Hapus Paksa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-sb-admin-layout>