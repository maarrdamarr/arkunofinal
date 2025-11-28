<x-sb-admin-layout>
    <h1 class="h3 mb-4 text-gray-800">Laporan Transaksi (Lelang Selesai)</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Barang</th><th>Penjual</th><th>Pemenang</th><th>Harga Akhir</th></tr></thead>
                <tbody>
                    @foreach($soldItems as $item)
                        @php $winner = $item->bids()->orderBy('bid_amount', 'desc')->first(); @endphp
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td class="font-weight-bold text-success">
                                {{ $winner ? $winner->user->name : 'Tidak ada penawar' }}
                            </td>
                            <td>Rp {{ $winner ? number_format($winner->bid_amount) : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-sb-admin-layout>