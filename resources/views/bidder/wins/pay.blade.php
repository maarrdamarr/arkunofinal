<x-sb-admin-layout>
    <h1 class="h3 mb-4 text-gray-800">Pembayaran Item Menang</h1>

    <div class="card">
        <div class="card-body">
            <h4>{{ $item->name }}</h4>
            <p>Harga Akhir: <strong>Rp {{ number_format($highestBid->bid_amount) }}</strong></p>
            <p class="text-muted">Saldo sudah dipotong saat lelang dan akan digunakan untuk pembayaran ini.</p>

            <form action="{{ route('bidder.wins.pay.process', $item->id) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-success">Konfirmasi & Bayar</button>
                <a href="{{ route('bidder.wins.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</x-sb-admin-layout>
