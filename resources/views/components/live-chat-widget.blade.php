@auth
<div id="live-chat-container" style="position: fixed; bottom: 25px; right: 25px; z-index: 9999;">
    
    <div id="chat-box" class="card shadow-lg mb-3 d-none" style="width: 300px; height: 400px; border-radius: 15px; overflow: hidden;">
        <div class="card-header bg-primary text-white py-2 px-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold" style="font-size: 14px;"><i class="fas fa-headset mr-1"></i> Customer Service</h6>
            <button type="button" class="close text-white" onclick="toggleChat()" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        <div class="card-body bg-light" id="chat-messages" style="height: 290px; overflow-y: auto; padding: 10px;">
            <div class="text-center text-muted mt-5"><i class="fas fa-spinner fa-spin"></i> Memuat...</div>
        </div>

        <div class="card-footer p-2 bg-white">
            <form id="chat-form">
                @csrf
                <div class="input-group">
                    <input type="text" id="chat-input" class="form-control form-control-sm" placeholder="Tulis pesan..." autocomplete="off">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <button onclick="toggleChat()" class="btn btn-primary rounded-circle shadow-lg d-flex align-items-center justify-content-center" 
            style="width: 60px; height: 60px; transition: transform 0.3s;">
        <i class="fas fa-comments fa-2x"></i>
    </button>

</div>

<script>
    // Toggle Buka/Tutup
    function toggleChat() {
        $('#chat-box').toggleClass('d-none');
        if(!$('#chat-box').hasClass('d-none')) {
            loadMessages(); // Load pesan saat dibuka
        }
    }

    // Load Pesan
    function loadMessages() {
        $.get("{{ route('support.fetch') }}", function(data) {
            $('#chat-messages').html(data);
            scrollToBottom();
        });
    }

    function scrollToBottom() {
        var chatDiv = document.getElementById("chat-messages");
        chatDiv.scrollTop = chatDiv.scrollHeight;
    }

    // Kirim Pesan
    $('#chat-form').submit(function(e) {
        e.preventDefault();
        let msg = $('#chat-input').val();
        if(!msg) return;

        $.post("{{ route('support.store') }}", {
            _token: "{{ csrf_token() }}",
            message: msg
        }, function(response) {
            $('#chat-input').val(''); // Kosongkan input
            loadMessages(); // Reload
        });
    });

    // Hapus Pesan
    $(document).on('click', '.delete-msg-btn', function(e) {
        e.preventDefault();
        if(!confirm('Hapus pesan ini?')) return;
        let id = $(this).data('id');

        $.ajax({
            url: "/support/delete/" + id,
            type: 'DELETE',
            data: { _token: "{{ csrf_token() }}" },
            success: function(result) {
                loadMessages();
            }
        });
    });

    // Edit Pesan (Simple Prompt)
    $(document).on('click', '.edit-msg-btn', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let oldMsg = $(this).data('msg');
        let newMsg = prompt("Edit pesan Anda:", oldMsg);

        if(newMsg && newMsg !== oldMsg) {
            $.post("/support/update/" + id, {
                _token: "{{ csrf_token() }}",
                message: newMsg
            }, function(response) {
                loadMessages();
            });
        }
    });

    // Auto Refresh setiap 5 detik (Simple Polling)
    setInterval(function() {
        if(!$('#chat-box').hasClass('d-none')) {
            // loadMessages(); // Aktifkan jika ingin real-time (tapi hati-hati server load)
        }
    }, 5000);
</script>
@endauth