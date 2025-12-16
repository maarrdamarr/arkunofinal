<x-sb-admin-layout>
    <div class="d-flex align-items-center mb-4">
        <a href="#" onclick="window.history.back();" class="btn btn-secondary btn-circle mr-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="h3 mb-0 text-gray-800">Inbox Support - CS</h1>
    </div>

    <div class="card shadow mb-4">
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
            <form action="{{ route('support.store') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="message" class="form-control" placeholder="Tulis pesan untuk CS..." required autocomplete="off">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Kirim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-sb-admin-layout>
