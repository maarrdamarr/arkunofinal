@extends('components.sb-admin-layout')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pembeli {{ $item->nama_barang }}</h1>
    </div>

    <!-- Item Info Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <img src="{{ $item->gambar_barang }}" alt="{{ $item->nama_barang }}" class="img-fluid rounded" style="max-height: 150px;">
                </div>
                <div class="col-md-9">
                    <h5 class="card-title">{{ $item->nama_barang }}</h5>
                    <p class="text-muted mb-2">Kategori: <strong>{{ $item->kategori }}</strong></p>
                    <p class="text-muted">Harga Mulai: <strong>Rp {{ number_format($item->harga_mulai, 0, ',', '.') }}</strong></p>
                    <p class="text-muted">Total Penawaran: <strong>{{ $buyers->count() }} pembeli</strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Buyers List -->
    <div class="card shadow">
        <div class="card-header bg-primary">
            <h6 class="m-0 font-weight-bold text-white">Daftar Pembeli</h6>
        </div>
        <div class="card-body">
            @if($buyers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Pembeli</th>
                                <th>Email</th>
                                <th>Penawaran Tertinggi</th>
                                <th>Tanggal Penawaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($buyers as $buyer)
                                @php
                                    $bid = \App\Models\Bid::where('item_id', $item->id)
                                        ->where('user_id', $buyer->id)
                                        ->orderBy('bid_amount', 'desc')
                                        ->first();
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $buyer->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($buyer->name) }}" 
                                                 alt="{{ $buyer->name }}" 
                                                 class="rounded-circle" 
                                                 width="35" 
                                                 height="35" 
                                                 style="margin-right: 10px;">
                                            <span>{{ $buyer->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $buyer->email }}</td>
                                    <td>
                                        @if($bid)
                                            <span class="badge badge-success">Rp {{ number_format($bid->bid_amount, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($bid)
                                            <small class="text-muted">{{ $bid->created_at->format('d M Y H:i') }}</small>
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('messages.conversation', ['itemId' => $item->id, 'buyerId' => $buyer->id]) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-comment"></i> Pesan
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle"></i> Belum ada pembeli untuk barang ini.
                </div>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('seller.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
