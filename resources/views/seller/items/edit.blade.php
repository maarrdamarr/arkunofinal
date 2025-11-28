<x-sb-admin-layout>
    <h1 class="h3 mb-4 text-gray-800">Edit Barang: {{ $item->name }}</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('seller.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi & Kondisi</label>
                    <textarea name="description" class="form-control" rows="3" required>{{ $item->description }}</textarea>
                </div>

                <div class="form-group">
                    <label>Harga Awal (Open Bid)</label>
                    <input type="number" name="start_price" class="form-control" value="{{ $item->start_price }}" required>
                </div>

                <div class="form-group">
                    <label>Foto Barang</label>
                    <div class="row align-items-center">
                        <div class="col-md-3 mb-2">
                            <span class="d-block text-xs text-gray-500 mb-1">Foto Saat Ini:</span>
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" class="img-thumbnail" style="max-height: 150px;">
                            @else
                                <div class="bg-gray-200 p-3 text-center text-muted border rounded">Tidak ada foto</div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <input type="file" name="image" class="form-control-file">
                            <small class="text-muted d-block mt-2">Biarkan kosong jika tidak ingin mengganti foto.</small>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('seller.items.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</x-sb-admin-layout>