@if($messages->isEmpty())
    <div class="text-center text-muted mt-3">Belum ada pesan.</div>
@else
    @foreach($messages as $msg)
        <div class="mb-2 d-flex {{ $msg->is_admin_reply ? 'justify-content-end' : 'justify-content-start' }}">
            <div class="p-2 rounded" style="max-width:80%; background: {{ $msg->is_admin_reply ? '#d4edda' : '#fff' }};">
                <div style="font-size:13px;">{{ $msg->message }}</div>
                <div style="font-size:10px; color:#666; margin-top:6px;">{{ $msg->created_at->format('d M H:i') }}</div>
            </div>
        </div>
    @endforeach
@endif
