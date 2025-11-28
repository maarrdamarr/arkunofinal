<x-sb-admin-layout>
    <h1 class="h3 mb-4 text-gray-800">Selamat! Anda Pemenangnya 🏆</h1>
    <div class="row">
        @foreach($wonItems as $item)
        <div class="col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Menang Lelang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $item->name }}</div>
                            <p class="mt-2">Harga Akhir: <strong>Rp {{ number_format($item->highestBid()->bid_amount) }}</strong></p>
                            <button class="btn btn-success btn-sm mt-2">Bayar Sekarang</button>
                        </div>
                        <div class="col-auto"><i class="fas fa-trophy fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</x-sb-admin-layout>