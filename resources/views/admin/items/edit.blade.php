<x-sb-admin-layout>
    <h1 class="h3 mb-4 text-gray-800">Edit Data Barang</h1>
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i> Perhatian: Anda mengedit data milik Seller. Lakukan hanya jika diperlukan.
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.items.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                </div>
                <div class="form-group">
                    <label>Harga Awal</label>
                    <input type="number" name="start_price" class="form-control" value="{{ $item->start_price }}" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="open" {{ $item->status == 'open' ? 'selected' : '' }}>Open (Sedang Lelang)</option>
                        <option value="closed" {{ $item->status == 'closed' ? 'selected' : '' }}>Closed (Selesai)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ $item->description }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update Barang</button>
                <a href="{{ route('admin.items.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</x-sb-admin-layout>