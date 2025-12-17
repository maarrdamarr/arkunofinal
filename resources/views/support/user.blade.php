<x-sb-admin-layout>
    <div class="d-flex align-items-center mb-4">
        <a href="#" onclick="window.history.back();" class="btn btn-secondary btn-circle mr-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="h3 mb-0 text-gray-800">Inbox Support - CS</h1>
    </div>

    <div class="d-flex mb-3">
        <div class="btn-group" role="group" aria-label="chat-tabs">
            <button id="btnCs" class="btn btn-outline-primary">Chat CS</button>
            @if(!in_array(Auth::user()->role, ['seller', 'bidder']))
                <button id="btnSeller" class="btn btn-outline-secondary">Chat Seller</button>
            @endif
        </div>
    </div>

    <div id="csContainer" class="card shadow mb-4">
        <div class="card-body" style="height:60vh; overflow-y:auto;">
            @if($messages->isEmpty())
                <div class="text-center text-muted">Belum ada percakapan dengan CS. Gunakan form di bawah untuk mengirim pesan.</div>
            @else
                @foreach($messages as $msg)
                    <div class="mb-3 d-flex {{ $msg->is_admin_reply ? 'justify-content-end' : 'justify-content-start' }}">
                        <div class="p-3 rounded {{ $msg->is_admin_reply ? 'bg-success text-white' : 'bg-white border' }}" style="max-width:70%;">
                            <div>{{ $msg->message }}</div>
                            <small class="text-muted">{{ $msg->created_at->format('d M H:i') }}</small>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="card-footer bg-white">
            <form id="supportForm">
                <div class="input-group">
                    <input type="text" id="supportInput" class="form-control" placeholder="Tulis pesan untuk CS..." required autocomplete="off">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Kirim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(!in_array(Auth::user()->role, ['seller', 'bidder']))
    <div id="sellerContainer" class="card shadow mb-4" style="display:none;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Chat Seller - Barang yang pernah Anda bid</h6>
        </div>
        <div class="card-body">
            @if(!empty($items) && $items->count() > 0)
                <div class="list-group">
                    @foreach($items as $it)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="font-weight-bold">{{ $it->nama_barang }}</div>
                                <small class="text-muted">Seller: {{ $it->user->name ?? 'Unknown' }}</small>
                            </div>
                            <div>
                                <a href="{{ route('messages.conversation', ['itemId' => $it->id, 'buyerId' => Auth::id()]) }}" class="btn btn-sm btn-primary">Chat</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-muted">Belum ada barang yang Anda bid.</div>
            @endif
        </div>
    </div>
    @endif
</x-sb-admin-layout>

<script>
    function scrollToBottom() {
        const chatContainer = document.querySelector('.card-body');
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        scrollToBottom();
        startSupportPolling();
        // hook up tab buttons
        const btnCs = document.getElementById('btnCs');
        const btnSeller = document.getElementById('btnSeller');
        const csContainerEl = document.getElementById('csContainer');
        const sellerContainerEl = document.getElementById('sellerContainer');

        if (btnCs) {
            btnCs.addEventListener('click', function() {
                if (csContainerEl) csContainerEl.style.display = 'block';
                if (sellerContainerEl) sellerContainerEl.style.display = 'none';
                btnCs.classList.remove('btn-outline-secondary');
                btnCs.classList.add('btn-primary');
                if (btnSeller) {
                    btnSeller.classList.remove('btn-primary');
                    btnSeller.classList.add('btn-outline-secondary');
                }
                startSupportPolling();
            });
        }
        if (btnSeller) {
            btnSeller.addEventListener('click', function() {
                if (csContainerEl) csContainerEl.style.display = 'none';
                if (sellerContainerEl) sellerContainerEl.style.display = 'block';
                btnSeller.classList.remove('btn-outline-secondary');
                btnSeller.classList.add('btn-primary');
                btnCs.classList.remove('btn-primary');
                btnCs.classList.add('btn-outline-primary');
                stopSupportPolling();
            });
        }
    });

    // Poll support messages periodically (every 3s)
    function pollSupport() {
        fetch('{{ route("support.fetch") }}', {
            method: 'GET',
            headers: {'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html'},
            credentials: 'same-origin'
        })
        .then(resp => {
            if (!resp.ok) return resp.text().then(t => { throw new Error(t || ('HTTP ' + resp.status)); });
            return resp.text();
        })
        .then(html => {
            const chatBody = document.querySelector('.card-body');
            if (chatBody) {
                chatBody.innerHTML = html;
                scrollToBottom();
            }
        })
        .catch(err => console.error('Support polling error:', err));
    }

    let supportIntervalId = null;
    function startSupportPolling() {
        if (supportIntervalId) return;
        pollSupport();
        supportIntervalId = setInterval(pollSupport, 3000);
    }
    function stopSupportPolling() {
        if (supportIntervalId) { clearInterval(supportIntervalId); supportIntervalId = null; }
    }

    // Handle form submission with AJAX
    document.getElementById('supportForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const messageInput = document.getElementById('supportInput');
        const message = messageInput.value.trim();
        
        if (!message) return;

        const formData = new FormData();
        formData.append('message', message);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("support.store") }}', {
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
                messageDiv.className = 'mb-3 d-flex justify-content-start';
                messageDiv.innerHTML = `
                    <div class="p-3 rounded bg-white border" style="max-width:70%;">
                        <div>${escapeHtml(message)}</div>
                        <small class="text-muted">Baru saja</small>
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
