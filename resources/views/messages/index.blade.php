<x-sb-admin-layout>
    <h1 class="h3 mb-4 text-gray-800">Inbox Pesan</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pesan Masuk</h6>
        </div>
        <div class="card-body">
            @if($messages->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Pengirim</th>
                                <th>Barang</th>
                                <th>Pesan</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $message)
                            <tr>
                                <td>{{ $message->sender->name }}</td>
                                <td>{{ $message->item->name }}</td>
                                <td>{{ $message->message }}</td>
                                <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center mt-4">Belum ada pesan masuk.</p>
            @endif
        </div>
    </div>
</x-sb-admin-layout>
