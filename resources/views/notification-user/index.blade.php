@extends('layouts.admin')

@section('title', 'Notifikasi')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pusat Notifikasi</h3>
                <p class="text-subtitle text-muted">Kelola semua notifikasi Anda</p>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <section class="section">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon blue mb-2">
                                    <i class="bi bi-bell"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Total</h6>
                                <h6 class="font-extrabold mb-0">{{ $notifications->total() }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon yellow mb-2">
                                    <i class="bi bi-envelope"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Belum Dibaca</h6>
                                <h6 class="font-extrabold mb-0">{{ $notifications->where('status_baca', false)->count() }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon green mb-2">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Sudah Dibaca</h6>
                                <h6 class="font-extrabold mb-0">{{ $notifications->where('status_baca', true)->count() }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Notifications Table --}}
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Notifikasi</h5>
                @if($notifications->where('status_baca', false)->count() > 0)
                    <button id="markAllReadBtn" class="btn btn-sm btn-primary">
                        <i class="bi bi-check-all"></i> Tandai Semua Dibaca
                    </button>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Pesan</th>
                                <th width="15%">Waktu</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notifications as $index => $notif)
                                <tr class="{{ !$notif->status_baca ? 'table-primary' : '' }}" 
                                    style="cursor: pointer;"
                                    onclick="handleNotificationClick(event, {{ $notif->notif_id }}, {{ $notif->tiket_id ?? 'null' }})">
                                    <td>
                                        @if(!$notif->status_baca)
                                            <i class="bi bi-circle-fill text-primary" style="font-size: 8px;"></i>
                                        @else
                                            <i class="bi bi-check-circle text-success"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <strong class="{{ !$notif->status_baca ? 'text-dark' : 'text-muted' }}">
                                            {{ $notif->pesan }}
                                        </strong>
                                        @if($notif->tiket)
                                            <br>
                                            <small class="badge bg-info">
                                                <i class="bi bi-ticket"></i> Tiket #{{ $notif->tiket->kode_tiket }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="bi bi-clock"></i>
                                            {{ \Carbon\Carbon::parse($notif->waktu_kirim)->diffForHumans() }}
                                        </small>
                                    </td>
                                    <td onclick="event.stopPropagation();">
                                        <div class="btn-group" role="group">
                                            @if(!$notif->status_baca)
                                                <button type="button" 
                                                        class="btn btn-sm btn-success" 
                                                        onclick="markAsRead({{ $notif->notif_id }})"
                                                        title="Tandai Dibaca">
                                                    <i class="bi bi-check"></i>
                                                </button>
                                            @endif
                                            
                                            @if($notif->tiket_id)
                                                <a href="{{ 
                                                    $user->role === 'admin' 
                                                    ? route('admin.tiket.show', $notif->tiket_id) 
                                                    : route('tim.tiket.show', $notif->tiket_id) 
                                                }}" 
                                                   class="btn btn-sm btn-info"
                                                   title="Lihat Tiket">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            @endif
                                            
                                            <form action="{{ route('notifications.destroy', $notif->notif_id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Hapus notifikasi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger"
                                                        title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="bi bi-bell-slash display-5 d-block mb-2"></i>
                                        Tidak ada notifikasi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($notifications->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>

<script>
// Mark all as read
document.getElementById('markAllReadBtn')?.addEventListener('click', function() {
    const btn = this;
    const originalHtml = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memproses...';
    
    fetch('{{ route("notifications.markAllRead") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if(data.success) {
            location.reload();
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan: ' + error.message);
        btn.disabled = false;
        btn.innerHTML = originalHtml;
    });
});

// Mark single as read
function markAsRead(notifId) {
    fetch(`/notifications/${notifId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menandai notifikasi sebagai dibaca');
    });
}

// Handle notification click
function handleNotificationClick(event, notifId, tiketId) {
    // Jangan redirect jika klik di area aksi
    if (event.target.closest('.btn-group')) return;
    
    if (!tiketId) {
        // Jika tidak ada tiket, hanya tandai sebagai dibaca
        markAsRead(notifId);
        return;
    }

    // Jika ada tiket, redirect ke endpoint read yang akan handle redirect
    window.location.href = `/notifications/${notifId}/read`;
}
</script>

<style>
.table-primary {
    background-color: rgba(13, 110, 253, 0.1) !important;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

.stats-icon {
    width: 3rem;
    height: 3rem;
    border-radius: .5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stats-icon.blue {
    background-color: #d6e4ff;
}

.stats-icon.yellow {
    background-color: #fff4de;
}

.stats-icon.green {
    background-color: #d1f4e0;
}

.stats-icon i {
    font-size: 1.5rem;
}

.stats-icon.blue i {
    color: #1e40af;
}

.stats-icon.yellow i {
    color: #d97706;
}

.stats-icon.green i {
    color: #059669;
}
</style>
@endsection