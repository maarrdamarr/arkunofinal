<x-sb-admin-layout>
    <a href="{{ route('bidder.auction.index') }}" class="btn btn-secondary mb-3">&larr; Kembali</a>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Barang</h6>
                </div>
                <div class="card-body">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid rounded mb-3">
                    @endif
                    <h3>{{ $item->name }}</h3>
                    <p>{{ $item->description }}</p>
                    <hr>
                    <p><strong>Penjual:</strong> {{ $item->user->name }}</p>
                    <p><strong>Harga Awal:</strong> Rp {{ number_format($item->start_price) }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow mb-4 border-left-primary">
                <div class="card-body">
                    <h4 class="font-weight-bold text-gray-800">Posisi Tertinggi: Rp {{ number_format($highestBid) }}</h4>
                    <p class="mb-4">Masukkan penawaran lebih tinggi dari nominal di atas.</p>

                    <form action="{{ route('bidder.auction.store', $item->id) }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" name="bid_amount" class="form-control" placeholder="Masukan nominal..." required min="{{ $highestBid + 1 }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Kirim Tawaran</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">Riwayat Penawaran ({{ $item->bids->count() }})</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($item->bids as $bid)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="font-weight-bold">{{ $bid->user->name }}</span>
                                    <br>
                                    <small class="text-muted">{{ $bid->created_at->diffForHumans() }}</small>
                                </div>
                                <span class="badge badge-success badge-pill">Rp {{ number_format($bid->bid_amount) }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted">Belum ada penawaran. Jadilah yang pertama!</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="mt-3">
    <form action="{{ route('bidder.wishlist.toggle', $item->id) }}" method="POST" class="d-inline">
        @csrf
        <button class="btn btn-outline-danger btn-sm">
            <i class="fas fa-heart"></i> Favorit
        </button>
    </form>

    <hr>
    <h6>Tanya Penjual:</h6>
    <form action="{{ route('messages.store', $item->id) }}" method="POST">
        @csrf
        <div class="input-group">
            <input type="text" name="message" class="form-control form-control-sm" placeholder="Barang ready gan?" required>
            <div class="input-group-append">
                <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </form>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-comments"></i> Diskusi & Tanya Jawab</h6>
            </div>
            <div class="card-body">
                <div class="chat-box mb-4" style="max-height: 400px; overflow-y: auto;">
                    @forelse($item->comments as $chat)
                        <div class="mb-3 {{ $chat->user_id == Auth::id() ? 'text-right' : '' }}">
                            <div class="d-inline-block p-3 rounded {{ $chat->user_id == $item->user_id ? 'bg-warning text-dark' : ($chat->user_id == Auth::id() ? 'bg-primary text-white' : 'bg-gray-200 text-dark') }}">
                                <small class="font-weight-bold d-block mb-1">
                                    {{ $chat->user->name }} 
                                    @if($chat->user_id == $item->user_id) <span class="badge badge-dark">Penjual</span> @endif
                                </small>
                                {{ $chat->body }}
                            </div>
                            <br>
                            <small class="text-muted">{{ $chat->created_at->diffForHumans() }}</small>
                        </div>
                    @empty
                        <p class="text-center text-muted">Belum ada diskusi. Jadilah yang pertama bertanya!</p>
                    @endforelse
                </div>

                <form action="{{ route('comments.store', $item->id) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="body" class="form-control" placeholder="Tulis pertanyaan Anda di sini..." required>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-paper-plane"></i> Kirim
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
</x-sb-admin-layout>