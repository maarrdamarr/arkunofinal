<x-sb-admin-layout>
    <h1 class="h3 mb-4 text-gray-800">Barang Favorit Saya ❤️</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($wishlists as $wish)
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100">
                    <div style="height: 200px; overflow: hidden; background: #f8f9fa;">
                        @if($wish->item->image)
                            <img src="{{ asset('storage/' . $wish->item->image) }}" class="card-img-top" style="object-fit: cover; height: 100%; width: 100%;">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">No Image</div>
                        @endif
                    </div>

                    <div class="card-body">
                        <h5 class="card-title font-weight-bold">{{ $wish->item->name }}</h5>
                        <p class="text-primary font-weight-bold">Rp {{ number_format($wish->item->start_price) }}</p>
                        
                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('bidder.auction.show', $wish->item->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            
                            <form action="{{ route('bidder.wishlist.toggle', $wish->item->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-sm" title="Hapus dari Favorit">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Info</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Anda belum memiliki barang favorit.</div>
                                <a href="{{ route('bidder.auction.index') }}" class="btn btn-info btn-sm mt-2">Cari Barang Sekarang</a>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-heart-broken fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</x-sb-admin-layout>