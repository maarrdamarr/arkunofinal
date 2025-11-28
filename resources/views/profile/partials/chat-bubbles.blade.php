@foreach($messages as $msg)
    <div class="mb-2 d-flex {{ $msg->is_admin_reply ? 'justify-content-start' : 'justify-content-end' }} group-chat-item">
        
        <div class="position-relative">
            <div class="p-2 rounded text-white {{ $msg->is_admin_reply ? 'bg-secondary' : 'bg-primary' }}" 
                 style="max-width: 200px; font-size: 13px;">
                {{ $msg->message }}
            </div>
            
            @if($msg->user_id == Auth::id() || Auth::user()->role == 'admin')
            <div class="text-right mt-1" style="font-size: 10px;">
                <a href="#" class="text-warning mr-1 edit-msg-btn" data-id="{{ $msg->id }}" data-msg="{{ $msg->message }}">Edit</a>
                <a href="#" class="text-danger delete-msg-btn" data-id="{{ $msg->id }}">Hapus</a>
            </div>
            @endif
            
            <small class="text-muted d-block" style="font-size: 9px;">
                {{ $msg->created_at->format('H:i') }}
            </small>
        </div>
    </div>
@endforeach