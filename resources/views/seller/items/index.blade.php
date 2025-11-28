<x-sb-admin-layout>
    <h1 class="h3 mb-4 text-gray-800">Barang Saya</h1>

    <a href="{{ route('seller.items.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Upload Barang
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Lelang</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Barang</th>
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
                                    <img src="{{ asset('storage/' . $item->image) }}" width="50">
                                @else
                                    <span class="text-muted">No Img</span>
                                @endif
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>Rp {{ number_format($item->start_price) }}</td>
                            <td>
                                <span class="badge badge-{{ $item->status == 'open' ? 'success' : 'danger' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>
                                @if($item->status == 'open')
                                    <form action="{{ route('seller.items.close', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tutup lelang ini? Pemenang akan ditentukan otomatis.');">
                                        @csrf
                                        <button class="btn btn-warning btn-sm" title="Tutup Lelang">
                                            <i class="fas fa-gavel"></i> Stop
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('seller.items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus barang ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
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