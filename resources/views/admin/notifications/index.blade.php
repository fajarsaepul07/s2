@extends('layouts.admin.master')
@section('content')

{{-- Load SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil! 🎉',
            text: '{{ session('success') }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    });
</script>
@endif

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Pusat Notifikasi</h4>
                        @if($notifications->where('status_baca', false)->count() > 0)
                            <button id="mark-all-read-btn" class="btn btn-primary btn-sm">
                                <i class="mdi mdi-check-all"></i> Tandai Semua Dibaca
                            </button>
                        @endif
                    </div>

                    <!-- Stats -->
                    <div class="row mb-4 g-3">
                        <div class="col-md-4">
                            <div class="alert alert-primary d-flex justify-content-between align-items-center mb-0">
                                <span><i class="mdi mdi-bell-badge"></i> Total</span>
                                <strong>{{ $notifications->total() }}</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-warning d-flex justify-content-between align-items-center mb-0">
                                <span><i class="mdi mdi-email-alert"></i> Belum Dibaca</span>
                                <strong>{{ $notifications->where('status_baca', false)->count() }}</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-success d-flex justify-content-between align-items-center mb-0">
                                <span><i class="mdi mdi-check-circle"></i> Sudah Dibaca</span>
                                <strong>{{ $notifications->where('status_baca', true)->count() }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive pt-2">
                        @if($notifications->count() > 0)
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="50" class="text-center">#</th>
                                    <th>Pesan</th>
                                    <th width="180">Waktu</th>
                                    <th width="120" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notifications as $index => $notification)
                                <tr class="{{ !$notification->status_baca ? 'table-info' : '' }} notification-row"
                                    data-notif-id="{{ $notification->notif_id }}"
                                    data-tiket-id="{{ $notification->tiket_id ?? '' }}"
                                    style="cursor:pointer;">
                                    <td class="text-center align-middle">
                                        @if(!$notification->status_baca)
                                            <i class="mdi mdi-bell-ring text-primary"></i>
                                        @else
                                            <i class="mdi mdi-check text-success"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $notification->pesan }}</strong><br>
                                        @if($notification->tiket)
                                            <small class="text-muted">
                                                <i class="mdi mdi-ticket-outline"></i> Tiket #{{ $notification->tiket->kode_tiket }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="mdi mdi-clock-outline"></i>
                                            {{ $notification->waktu_kirim->diffForHumans() }}
                                        </small><br>
                                        <small class="text-muted">{{ $notification->waktu_kirim->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td class="text-center align-middle" onclick="event.stopPropagation();">
                                        <div class="btn-group" role="group">
                                            @if($notification->tiket_id)
                                            <button type="button" 
                                                    class="btn btn-info btn-sm view-tiket" 
                                                    data-notif-id="{{ $notification->notif_id }}"
                                                    data-tiket-id="{{ $notification->tiket_id }}"
                                                    title="Lihat Tiket">
                                                <i class="mdi mdi-eye"></i>
                                            </button>
                                            @endif
                                            
                                            @if(!$notification->status_baca)
                                            <button type="button" 
                                                    class="btn btn-success btn-sm mark-read-single" 
                                                    data-notif-id="{{ $notification->notif_id }}"
                                                    title="Tandai Dibaca">
                                                <i class="mdi mdi-check"></i>
                                            </button>
                                            @endif
                                            
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm delete-notif" 
                                                    data-notif-id="{{ $notification->notif_id }}"
                                                    title="Hapus">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $notifications->links() }}
                        </div>
                        @else
                            <div class="text-center py-5">
                                <i class="mdi mdi-bell-off-outline" style="font-size: 70px; color:#ccc;"></i>
                                <p class="text-muted mt-3 mb-0">Belum ada notifikasi</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Notification page loaded');

    // CSRF Token
    const csrfToken = '{{ csrf_token() }}';
    
    // User role untuk routing yang tepat
    const userRole = '{{ auth()->user()->role }}';
    console.log('👤 User role:', userRole);

    // Helper function untuk get redirect URL berdasarkan role
    function getTiketUrl(tiketId) {
        if (userRole === 'admin') {
            return `/admin/tiket/${tiketId}`;
        } else if (userRole === 'tim_teknisi' || userRole === 'tim_konten') {
            return `/tim/tiket/${tiketId}`;
        } else {
            return `/tiket/${tiketId}`;
        }
    }

    // 1. TANDAI SEMUA SEBAGAI DIBACA
    const markAllBtn = document.getElementById('mark-all-read-btn');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const btn = this;
            const originalHtml = btn.innerHTML;
            
            btn.disabled = true;
            btn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> Memproses...';
            
            fetch('{{ route("notifications.markAllRead") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network error');
                return response.json();
            })
            .then(data => {
                console.log('✅ Mark all read:', data);
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Semua notifikasi telah ditandai sebagai dibaca',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    throw new Error(data.message || 'Gagal');
                }
            })
            .catch(error => {
                console.error('❌ Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: error.message,
                    confirmButtonText: 'OK'
                });
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            });
        });
    }

    // 2. KLIK BARIS NOTIFIKASI (redirect ke tiket)
    const notificationRows = document.querySelectorAll('.notification-row');
    notificationRows.forEach(row => {
        row.addEventListener('click', function(e) {
            // Jangan trigger jika klik button
            if (e.target.closest('button, .btn-group')) {
                return;
            }

            const notifId = this.dataset.notifId;
            const tiketId = this.dataset.tiketId;

            console.log('📱 Row clicked:', { notifId, tiketId });

            if (tiketId) {
                // Tandai sebagai dibaca, lalu redirect
                fetch(`/notifications/${notifId}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('✅ Marked as read:', data);
                    window.location.href = getTiketUrl(tiketId);
                })
                .catch(error => {
                    console.error('❌ Error:', error);
                    // Tetap redirect meski gagal
                    window.location.href = getTiketUrl(tiketId);
                });
            }
        });
    });

    // 3. LIHAT TIKET (dari button)
    const viewTiketBtns = document.querySelectorAll('.view-tiket');
    viewTiketBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const notifId = this.dataset.notifId;
            const tiketId = this.dataset.tiketId;

            console.log('👁️ View tiket:', { notifId, tiketId });

            // Show loading
            this.disabled = true;
            const originalHtml = this.innerHTML;
            this.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i>';

            // Tandai sebagai dibaca, lalu redirect
            fetch(`/notifications/${notifId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('✅ Marked as read:', data);
                window.location.href = getTiketUrl(tiketId);
            })
            .catch(error => {
                console.error('❌ Error:', error);
                window.location.href = getTiketUrl(tiketId);
            });
        });
    });

    // 4. TANDAI SATU SEBAGAI DIBACA
    const markReadBtns = document.querySelectorAll('.mark-read-single');
    markReadBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const notifId = this.dataset.notifId;
            console.log('✓ Mark single as read:', notifId);

            // Show loading
            this.disabled = true;
            const originalHtml = this.innerHTML;
            this.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i>';

            fetch(`/notifications/${notifId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('✅ Response:', data);
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Notifikasi telah ditandai sebagai dibaca',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                }
            })
            .catch(error => {
                console.error('❌ Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Gagal menandai sebagai dibaca',
                    confirmButtonText: 'OK'
                });
                this.disabled = false;
                this.innerHTML = originalHtml;
            });
        });
    });

    // 5. HAPUS NOTIFIKASI
    const deleteBtns = document.querySelectorAll('.delete-notif');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const notifId = this.dataset.notifId;
            const btnElement = this;

            console.log('🗑️ Delete notification:', notifId);

            Swal.fire({
                title: 'Hapus Notifikasi?',
                text: 'Tindakan ini tidak dapat dibatalkan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    btnElement.disabled = true;
                    const originalHtml = btnElement.innerHTML;
                    btnElement.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i>';

                    fetch(`/notifications/${notifId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('✅ Delete response:', data);
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: 'Notifikasi berhasil dihapus',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        }
                    })
                    .catch(error => {
                        console.error('❌ Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal menghapus notifikasi',
                            confirmButtonText: 'OK'
                        });
                        btnElement.disabled = false;
                        btnElement.innerHTML = originalHtml;
                    });
                }
            });
        });
    });

    console.log('🎉 All event listeners attached successfully');
});
</script>

<style>
.notification-row:hover {
    background-color: rgba(0, 123, 255, 0.05) !important;
}

.table-info {
    background-color: rgba(13, 202, 240, 0.1) !important;
}

.btn-group {
    box-shadow: none !important;
}

.btn-group .btn {
    margin: 0 2px;
}
</style>

@endsection