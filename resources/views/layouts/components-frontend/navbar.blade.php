<nav class="navbar navbar-expand-lg bg-light shadow-sm py-2 px-4 fixed-top">
    <div class="container-fluid">

        <!-- LEFT: Toggle Sidebar + Logo -->
        <div class="d-flex align-items-center">
            <button onclick="toggleSidebar()" class="btn btn-outline-primary me-3" id="sidebarToggle">
                <i class="lni lni-menu"></i>
            </button>
            
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('user/img/logo/logoo.jpeg') }}" alt="Logo" height="40" class="me-2 rounded" />
                <h5 class="mb-0 fw-bold text-primary">Helpdesk</h5>
            </a>
        </div>

        <!-- RIGHT: Notifikasi + Profile -->
        <div class="d-flex align-items-center gap-3">
            @auth
            <!-- Notification Bell -->
            <div class="dropdown">
                <a href="#" class="position-relative text-decoration-none" 
                   id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="lni lni-alarm" style="font-size: 24px; color: #0052CC;"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                          id="notif-badge" style="display: none; font-size: 10px;">
                        0
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow-lg notification-dropdown" 
                    aria-labelledby="notificationDropdown" style="width: 380px;">
                    
                    <li class="dropdown-header d-flex justify-content-between align-items-center border-bottom p-3">
                        <span class="fw-bold text-dark">
                            <i class="lni lni-bell me-1"></i> Notifikasi
                        </span>
                        <a href="#" id="mark-all-read" class="text-primary small text-decoration-none fw-semibold">
                            <i class="lni lni-checkmark-circle"></i> Tandai Dibaca
                        </a>
                    </li>

                    <div id="notification-list" style="max-height: 420px; overflow-y: auto;">
                        <!-- JS akan isi -->
                    </div>

                    <li class="dropdown-footer text-center p-2 border-top">
                        <a href="{{ route('notifications.index') }}" class="notification-item">
                            <i class="lni lni-eye"></i> Lihat Semua Notifikasi
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Profile Dropdown -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                   id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('assets/images/faces/pp.jpg') }}" alt="Profile" 
                         width="40" height="40" class="rounded-circle me-2 border" />
                    <span class="fw-semibold text-dark d-none d-md-inline">
                        {{ Auth::user()->name }}
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="mdi mdi-logout me-2"></i> Logout
                        </a>
                    </li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm px-4">Login</a>
            @endauth
        </div>
    </div>
</nav>

<style>
    body { padding-top: 75px !important; }
    .navbar { height: 75px !important; z-index: 1030; }

    .notification-dropdown {
        border-radius: 12px;
        width: 400px !important;
        max-width: 95vw;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    }

    @media (max-width: 576px) {
        .notification-dropdown {
            width: 340px !important;
            right: 10px !important;
        }
        .navbar-brand h5 { display: none; }
    }

    /* Style notifikasi sama seperti navbar admin kamu */
    .notification-item {
        padding: 14px 18px;
        border-bottom: 1px solid #f1f1f1;
        display: block;
        text-decoration: none;
        color: inherit;
    }
    .notification-item:hover { background: #f8f9fa; }
    .notification-item.unread { background: #eff6ff; border-left: 4px solid #3b82f6; }
</style>

<script>
// Script notifikasi (sama seperti yang sudah kamu punya di navbar admin)
document.addEventListener('DOMContentLoaded', function() {
    loadNotifications();
    setInterval(loadNotifications, 30000);

    const markAllBtn = document.getElementById('mark-all-read');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function(e) {
            e.preventDefault();
            markAllAsRead();
        });
    }
});

function loadNotifications() {
    fetch('{{ route("notifications.unread") }}')
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            const notifList = document.getElementById('notification-list');
            const notifBadge = document.getElementById('notif-badge');
            
            // Update badge
            if (data.unread_count > 0) {
                notifBadge.textContent = data.unread_count;
                notifBadge.style.display = 'block';
            } else {
                notifBadge.style.display = 'none';
            }

            // Update list
            if (data.notifications.length === 0) {
                notifList.innerHTML = `
                    <div class="empty-notification">
                        <i class="lni lni-inbox"></i>
                        <p class="fw-semibold text-muted mb-1">Tidak ada notifikasi baru</p>
                        <small class="text-muted">Semua notifikasi sudah dibaca</small>
                    </div>
                `;
            } else {
                notifList.innerHTML = data.notifications.map(notif => {
                    const waktu = notif.waktu_kirim || 'Baru saja';
                    const isUnread = !notif.status_baca;
                    
                    return `
                        <a href="#" 
                            class="notification-item ${isUnread ? 'unread' : ''}"
                            onclick="handleNotificationClick(event, ${notif.notif_id}, ${notif.tiket_id || 'null'})">
                            <div class="d-flex gap-3 align-items-start">
                                <div class="notification-icon ${isUnread ? '' : 'read'}">
                                    <i class="lni lni-envelope"></i>
                                </div>
                                <div class="flex-grow-1" style="min-width: 0;">
                                    <p class="mb-1 text-dark fw-medium" style="font-size: 13px; line-height: 1.5;">
                                        ${escapeHtml(notif.pesan)}
                                    </p>
                                    <div class="d-flex align-items-center gap-2 flex-wrap mt-2">
                                        <small class="text-muted d-flex align-items-center" style="font-size: 12px;">
                                            <i class="lni lni-calendar me-1"></i> ${formatWaktu(waktu)}
                                        </small>
                                        ${notif.tiket ? `
                                            <span class="badge" style="background: #dbeafe; color: #1e40af; font-size: 11px; padding: 3px 8px;">
                                                <i class="lni lni-ticket"></i> ${notif.tiket.kode_tiket}
                                            </span>
                                        ` : ''}
                                    </div>
                                </div>
                                ${isUnread ? '<div class="notification-dot"></div>' : ''}
                            </div>
                        </a>
                    `;
                }).join('');
            }
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
            document.getElementById('notification-list').innerHTML = `
                <div class="text-center py-5 text-danger">
                    <i class="lni lni-warning" style="font-size: 3rem; display: block; margin-bottom: 1rem;"></i>
                    <p class="mb-0 fw-semibold">Gagal memuat notifikasi</p>
                    <small class="text-muted">Silakan refresh halaman</small>
                </div>
            `;
        });
}

function markAllAsRead() {
    const btn = document.getElementById('mark-all-read');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Loading...';
    btn.style.pointerEvents = 'none';
    
    // FIXED: Gunakan route yang benar dengan method POST
    fetch('{{ route("notifications.markAllRead") }}', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            loadNotifications();
            
            // Tutup dropdown setelah berhasil
            const dropdownElement = document.getElementById('notificationDropdown');
            const dropdown = bootstrap.Dropdown.getInstance(dropdownElement);
            if (dropdown) {
                setTimeout(() => dropdown.hide(), 500);
            }
            
            // Optional: Tampilkan toast notification
            showToast('Semua notifikasi telah ditandai sebagai dibaca');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menandai notifikasi. Silakan coba lagi.');
    })
    .finally(() => {
        btn.innerHTML = originalText;
        btn.style.pointerEvents = 'auto';
    });
}

function handleNotificationClick(event, notifId, tiketId) {
    event.preventDefault();
    
    // Kirim POST request untuk mark as read
    fetch(`/notifications/${notifId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect ke tiket jika ada
            if (tiketId) {
                window.location.href = `/tiket/${tiketId}`;
            } else {
                loadNotifications();
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Tetap redirect meskipun ada error
        if (tiketId) {
            window.location.href = `/tiket/${tiketId}`;
        } else {
            loadNotifications();
        }
    });
}

function formatWaktu(waktu) {
    // Format waktu relatif (e.g., "2 jam yang lalu")
    if (typeof waktu === 'string' && waktu.includes('ago')) {
        return waktu;
    }
    
    try {
        const date = new Date(waktu);
        const now = new Date();
        const diff = Math.floor((now - date) / 1000); // dalam detik
        
        if (diff < 60) return 'Baru saja';
        if (diff < 3600) return Math.floor(diff / 60) + ' menit yang lalu';
        if (diff < 86400) return Math.floor(diff / 3600) + ' jam yang lalu';
        if (diff < 604800) return Math.floor(diff / 86400) + ' hari yang lalu';
        
        return date.toLocaleDateString('id-ID', { 
            day: 'numeric', 
            month: 'short', 
            year: 'numeric' 
        });
    } catch (e) {
        return waktu;
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function showToast(message) {
    // Simple toast notification (optional)
    const toast = document.createElement('div');
    toast.className = 'position-fixed bottom-0 end-0 p-3';
    toast.style.zIndex = '11000';
    toast.innerHTML = `
        <div class="toast show" role="alert">
            <div class="toast-body bg-success text-white rounded">
                <i class="lni lni-checkmark-circle me-2"></i>${message}
            </div>
        </div>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>