<x-sb-admin-layout>
    <h1 class="h3 mb-4 text-gray-800">Inbox Customer Service</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Percakapan</h6>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @forelse($users as $u)
                    @if($u->role == 'guest')
                        <a href="{{ route('admin.support.showGuest', urlencode($u->email)) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    @else
                        <a href="{{ route('admin.support.show', $u->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    @endif
                        <div class="d-flex align-items-center">
                            @if(!empty($u->avatar))
                                <img src="{{ asset('storage/' . $u->avatar) }}" class="rounded-circle mr-3" style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background=random" class="rounded-circle mr-3" style="width: 40px; height: 40px;">
                            @endif
                            
                            <div>
                                <h6 class="mb-0 font-weight-bold">{{ $u->name }}</h6>
                                <small class="text-muted">{{ $u->email }}</small>
                            </div>
                        </div>
                        
                        <div class="text-right">
                            <span class="badge badge-{{ $u->role == 'seller' ? 'info' : ($u->role == 'bidder' ? 'primary' : ($u->role == 'guest' ? 'warning' : 'secondary')) }} mb-1">{{ ucfirst($u->role) }}</span>
                            <br>
                            <small class="text-xs text-gray-500">
                                Klik untuk balas <i class="fas fa-chevron-right ml-1"></i>
                            </small>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-5">
                        <p class="text-muted">Belum ada pesan masuk dari pengguna.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-sb-admin-layout>