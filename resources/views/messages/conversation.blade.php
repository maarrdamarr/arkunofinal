@extends('components.sb-admin-layout')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Pesan dengan {{ $buyer->name }}</h1>
            <small class="text-muted">{{ $buyer->email }}</small>
        </div>
    </div>

    <!-- Item Info Card -->
    <div class="card shadow mb-4">
        <div class="card-header bg-info">
            <h6 class="m-0 font-weight-bold text-white">Barang: {{ $item->nama_barang }}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <img src="{{ $item->gambar_barang }}" alt="{{ $item->nama_barang }}" class="img-fluid rounded" style="max-height: 100px;">
                </div>
                <div class="col-md-10">
                    <p class="mb-1"><strong>Kategori:</strong> {{ $item->kategori }}</p>
                    <p class="mb-1"><strong>Harga Mulai:</strong> Rp {{ number_format($item->harga_mulai, 0, ',', '.') }}</p>
                    @php
                        $buyerBid = \App\Models\Bid::where('item_id', $item->id)
                            ->where('user_id', $buyer->id)
                            ->orderBy('bid_amount', 'desc')
                            ->first();
                    @endphp
                    @if($buyerBid)
                        <p class="mb-0"><strong>Penawaran Tertinggi:</strong> Rp {{ number_format($buyerBid->bid_amount, 0, ',', '.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Container -->
    <div class="card shadow">
        <div class="card-header bg-primary">
            <h6 class="m-0 font-weight-bold text-white">Percakapan</h6>
        </div>
        <div class="card-body" style="height: 400px; overflow-y: auto; background-color: #f8f9fa;">
            @forelse($messages as $message)
                <div class="mb-3">
                    <div class="d-flex {{ $message->sender_id === Auth::id() ? 'justify-content-end' : '' }}">
                        <div class="p-3 rounded {{ $message->sender_id === Auth::id() ? 'bg-primary text-white' : 'bg-white border' }}" 
                             style="max-width: 70%;">
                            <p class="mb-1">
                                <strong>
                                    @if($message->sender_id === Auth::id())
                                        Anda
                                    @else
                                        {{ $message->sender->name }}
                                    @endif
                                </strong>
                            </p>
                            <p class="mb-2">{{ $message->pesan }}</p>
                            <small class="text-muted">{{ $message->created_at->format('d M Y H:i') }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    <i class="fas fa-comment-slash"></i> Belum ada pesan. Mulai percakapan sekarang!
                </div>
            @endforelse
        </div>

        <!-- Message Input Form -->
        <div class="card-footer bg-light border-top">
            <form id="messageForm">
                <div class="input-group">
                    <input type="text" 
                           id="messageInput"
                           class="form-control" 
                           placeholder="Ketikkan pesan..." 
                           required>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-paper-plane"></i> Kirim
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('messages.item-buyers', $item->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pembeli
        </a>
    </div>
</div>

<script>
    // Auto scroll ke bawah (pesan terbaru)
    function scrollToBottom() {
        const chatContainer = document.querySelector('.card-body');
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        scrollToBottom();
    });

    // Handle form submission with AJAX
    document.getElementById('messageForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const messageInput = document.getElementById('messageInput');
        const pesan = messageInput.value.trim();
        
        if (!pesan) return;

        const formData = new FormData();
        formData.append('pesan', pesan);
        formData.append('buyer_id', '{{ $buyer->id }}');
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("messages.store", $item->id) }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            credentials: 'same-origin',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text || `HTTP ${response.status}`); });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Clear input
                messageInput.value = '';
                
                // Add message to chat
                const chatBody = document.querySelector('.card-body');
                const messageDiv = document.createElement('div');
                messageDiv.className = 'mb-3';
                messageDiv.innerHTML = `
                    <div class="d-flex justify-content-end">
                        <div class="p-3 rounded bg-primary text-white" style="max-width: 70%;">
                            <p class="mb-1"><strong>Anda</strong></p>
                            <p class="mb-2">${escapeHtml(pesan)}</p>
                            <small class="text-muted">Baru saja</small>
                        </div>
                    </div>
                `;
                chatBody.appendChild(messageDiv);
                scrollToBottom();
            } else {
                alert(data.message || 'Gagal mengirim pesan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    });

    // Escape HTML untuk prevent XSS
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
</script>
@endsection
