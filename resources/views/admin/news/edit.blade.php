<x-sb-admin-layout>
    <h1 class="h3 mb-4 text-gray-800">Edit Berita</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Judul Berita</label>
                    <input type="text" name="title" class="form-control" value="{{ $news->title }}" required>
                </div>
                <div class="form-group">
                    <label>Isi Berita</label>
                    <textarea name="content" class="form-control" rows="5" required>{{ $news->content }}</textarea>
                </div>
                <div class="form-group">
                    <label>Ganti Gambar (Biarkan kosong jika tidak ingin ganti)</label>
                    <input type="file" name="image" class="form-control-file">
                </div>
                <button type="submit" class="btn btn-primary">Update Berita</button>
            </form>
        </div>
    </div>
</x-sb-admin-layout>