<nav class="navbar navbar-expand-lg bg-light shadow-sm py-2 px-4 
     d-flex justify-content-between align-items-center fixed-top">

    <!-- LEFT: Toggle -->
    <div class="d-flex align-items-center">
        <button onclick="toggleSidebar()" class="btn btn-outline-primary me-3">
            <i class="lni lni-menu"></i>
        </button>
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('user/img/logo/logoo.jpeg') }}" alt="Logo" height="40" class="me-2 rounded" />
            <h5 class="mb-0 fw-bold text-primary"></h5>
        </a>
    </div>

    <!-- CENTER: Search Bar -->
    <div class="flex-grow-1 d-flex justify-content-center">
        <form class="search-wrapper w-100" style="max-width: 780px;">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="lni lni-search-alt"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Search...">
            </div>
        </form>
    </div>

    <!-- RIGHT: Notif + Profile -->
    <div class="d-flex align-items-center gap-3" style="margin-right: 20px;">
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
                aria-labelledby="notificationDropdown">
                <li class="dropdown-header d-flex justify-content-between align-items-center border-bottom p-3 bg-gradient">
                    <span class="fw-bold text-dark">
                        <i class="lni lni-bell me-1"></i> Notifikasi
                    </span>
                    <a href="#" id="mark-all-read" class="text-primary small text-decoration-none fw-semibold">
                        <i class="lni lni-checkmark-circle"></i> Tandai Dibaca
                    </a>
                </li>
                <div id="notification-list" style="max-height: 420px; overflow-y: auto;">
                    <div class="text-center py-5">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted small mt-2 mb-0">Memuat notifikasi...</p>
                    </div>
                </div>
                <li class="dropdown-footer text-center p-2 border-top bg-light">
                    <a href="{{ route('notifications.index') }}" class="notification-item" style="cursor:pointer;">
                        <i class="lni lni-eye"></i> Lihat Semua Notifikasi
                    </a>
                </li>
            </ul>
        </div>

        <!-- Profile Dropdown -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('assets/images/faces/pp.jpg') }}" alt="Profile" width="40"
                    height="40" class="rounded-circle me-2" />
                <span class="fw-semibold text-dark">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="profileDropdown">
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="mdi mdi-account-circle text-primary me-2"></i>Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="mdi mdi-settings text-primary me-2"></i>Settings
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout me-2"></i>Logout
                    </a>
                </li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
        @else
        <!-- Tombol Login/Register jika belum login -->
        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm px-4">Login</a>
        @endauth
    </div>
</nav>

<style>
    body {
        padding-top: 70px !important;
    }

    .navbar {
        height: 70px !important;
        z-index: 1030;
    }

    #sidebarToggle {
        border-radius: 8px;
    }

    .input-group-text {
        border-radius: 8px 0 0 8px !important;
    }

    .form-control {
        border-radius: 0 8px 8px 0 !important;
    }

    .nav .search-wrapper {
        margin-left: auto;
        margin-right: auto;
    }

    /* Notification Dropdown Styles */
    .notification-dropdown {
        border-radius: 12px;
        padding: 0;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
        width: 400px !important;
        max-width: 95vw !important;
        right: 0 !important;
        left: auto !important;
        transform: translateX(0) !important;
        margin-top: 0.5rem !important;
    }

    /* Perbaikan positioning untuk mobile */
    @media (max-width: 576px) {
        .notification-dropdown {
            width: 320px !important;
            right: -10px !important;
        }
    }

    .notification-dropdown .dropdown-header {
        background: #ffffff;
        border-radius: 12px 12px 0 0;
        padding: 16px 20px;
    }

    .notification-item {
        padding: 16px 20px;
        border-bottom: 1px solid #f3f4f6;
        transition: all 0.2s ease;
        cursor: pointer;
        display: block;
        text-decoration: none;
        position: relative;
        background: #ffffff;
    }

    .notification-item:hover {
        background: #f9fafb;
    }

    .notification-item.unread {
        background: #eff6ff;
        border-left: 4px solid #3b82f6;
    }

    .notification-item.unread:hover {
        background: #dbeafe;
    }

    .notification-dot {
        width: 8px;
        height: 8px;
        background: #3b82f6;
        border-radius: 50%;
        flex-shrink: 0;
        position: absolute;
        right: 20px;
        top: 24px;
    }

    .notification-icon {
        width: 48px;
        height: 48px;
        background: #3b82f6;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        flex-shrink: 0;
    }

    .notification-icon.read {
        background: #e5e7eb;
        color: #6b7280;
    }

    #notif-badge {
        animation: badge-bounce 0.5s ease;
    }

    @keyframes badge-bounce {
        0%, 100% { transform: translate(-50%, -50%) scale(1); }
        50% { transform: translate(-50%, -50%) scale(1.2); }
    }

    /* Scrollbar Custom */
    #notification-list::-webkit-scrollbar {
        width: 6px;
    }

    #notification-list::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    #notification-list::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 10px;
    }

    #notification-list::-webkit-scrollbar-thumb:hover {
        background: #764ba2;
    }

    .empty-notification {
        padding: 3rem 1.5rem;
        text-align: center;
    }

    .empty-notification i {
        font-size: 3.5rem;
        color: #d1d5db;
        margin-bottom: 1rem;
        display: block;
    }

    .empty-notification p {
        color: #9ca3af;
        margin: 0;
        font-size: 0.95rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadNotifications();
    
    // Refresh notifikasi setiap 30 detik
    setInterval(loadNotifications, 30000);

    // Tandai semua dibaca
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