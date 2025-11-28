<x-sb-admin-layout>
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.support.index') }}" class="btn btn-secondary btn-circle mr-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="h3 mb-0 text-gray-800">Chat dengan {{ $user->name }}</h1>
    </div>

    <div class="card shadow mb-4" style="height: 70vh;">
        <div class="card-body bg-light" id="message-container" style="overflow-y: auto; height: 100%;">
            @foreach($messages as $msg)
                <div class="d-flex mb-3 {{ $msg->is_admin_reply ? 'justify-content-end' : 'justify-content-start' }}">
                    
                    @if(!$msg->is_admin_reply)
                        <div class="mr-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" class="rounded-circle" style="width: 30px;">
                        </div>
                    @endif

                    <div class="{{ $msg->is_admin_reply ? 'bg-success text-white' : 'bg-white text-dark border' }} p-3 rounded shadow-sm" style="max-width: 70%;">
                        <p class="mb-1">{{ $msg->message }}</p>
                        <small class="{{ $msg->is_admin_reply ? 'text-white-50' : 'text-muted' }}" style="font-size: 10px;">
                            {{ $msg->created_at->format('d M H:i') }}
                            
                            <form action="{{ route('support.destroy', $msg->id) }}" method="POST" class="d-inline ml-2" onsubmit="return confirm('Hapus pesan ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-link p-0 text-danger" style="font-size: 10px; text-decoration: none;">Hapus</button>
                            </form>
                        </small>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="card-footer bg-white">
            <form action="{{ route('admin.support.reply', $user->id) }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="message" class="form-control" placeholder="Tulis balasan sebagai Admin..." required autocomplete="off">
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit">
                            <i class="fas fa-paper-plane"></i> Kirim
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var container = document.getElementById("message-container");
            container.scrollTop = container.scrollHeight;
        });
    </script>
</x-sb-admin-layout>