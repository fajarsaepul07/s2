<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
            <a class="brand-logo" href="{{ url('/') }}">
                <img src="{{ asset('user/img/logo/Logoo.png') }}" height="120px" alt="logo" />
            </a>
            <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo" />
            </a>
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="mdi mdi-sort-variant"></span>
            </button>
        </div>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-4 w-100">
            <li class="nav-item nav-search d-none d-lg-block w-100">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="search"><i class="mdi mdi-magnify"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Search now" aria-label="search">
                </div>
            </li>
        </ul>

        <ul class="navbar-nav navbar-nav-right">
            <!-- Notifications -->
            <li class="nav-item dropdown mr-4">
                <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center"
                    id="notificationDropdown" href="#" data-toggle="dropdown">
                    <i class="mdi mdi-bell mx-0"></i>
                    <span class="count" id="notif-badge" style="display: none;"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown notification-dropdown"
                    aria-labelledby="notificationDropdown" style="max-width: 400px; width: 350px;">
                    <div class="dropdown-header d-flex justify-content-between align-items-center p-3 border-bottom">
                        <p class="mb-0 font-weight-bold">Notifikasi</p>
                        <a href="#" id="mark-all-read" class="text-primary small">Tandai semua dibaca</a>
                    </div>
                    <div id="notification-list" style="max-height: 400px; overflow-y: auto;">
                        <!-- Notifikasi akan dimuat di sini -->
                        <div class="text-center py-4">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-footer text-center p-2 border-top">
                        <a href="{{ route('notifications.index') }}" class="text-primary small">Lihat Semua Notifikasi</a>
                    </div>
                </div>
            </li>

            <!-- Profile -->
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <img src="{{ asset('assets/images/faces/face5.jpg') }}" alt="profile" />
                    <span class="nav-profile-name">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item"><i class="mdi mdi-settings text-primary"></i> Settings</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout text-primary"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>

        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>

<style>
.notification-dropdown .dropdown-item {
    white-space: normal;
    padding: 12px 20px;
    border-bottom: 1px solid #f0f0f0;
    transition: background-color 0.3s;
}

.notification-dropdown .dropdown-item:hover {
    background-color: #f8f9fa;
}

.notification-dropdown .dropdown-item.unread {
    background-color: #e3f2fd;
    border-left: 3px solid #2196F3;
}

.notification-item {
    display: flex;
    align-items: start;
    gap: 10px;
}

.notification-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.notification-icon.new-ticket {
    background-color: #e3f2fd;
    color: #2196F3;
}

.notification-icon.status-update {
    background-color: #e8f5e9;
    color: #4CAF50;
}

.notification-content {
    flex: 1;
}

.notification-content h6 {
    font-size: 14px;
    margin-bottom: 4px;
    font-weight: 600;
}

.notification-content p {
    font-size: 12px;
    color: #666;
    margin-bottom: 4px;
}

.notification-time {
    font-size: 11px;
    color: #999;
}

.count-indicator .count {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff4444;
    color: white;
    border-radius: 10px;
    padding: 2px 6px;
    font-size: 10px;
    font-weight: bold;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Fungsi untuk memuat notifikasi
    function loadNotifications() {
        $.ajax({
            url: '{{ route("notifications.unread") }}',
            method: 'GET',
            success: function(response) {
                updateNotificationUI(response);
            },
            error: function(xhr) {
                console.error('Error loading notifications:', xhr);
            }
        });
    }

    // Update UI notifikasi
    function updateNotificationUI(data) {
        const badge = $('#notif-badge');
        const list = $('#notification-list');

        // Update badge
        if (data.unread_count > 0) {
            badge.text(data.unread_count).show();
        } else {
            badge.hide();
        }

        // Update list
        if (data.notifications.length === 0) {
            list.html('<div class="text-center py-4 text-muted">Tidak ada notifikasi baru</div>');
        } else {
            let html = '';
            data.notifications.forEach(function(notif) {
                const isUnread = !notif.status_baca;
                const iconClass = notif.pesan.includes('dibuat') ? 'new-ticket' : 'status-update';
                const icon = notif.pesan.includes('dibuat') ? 'mdi-ticket' : 'mdi-refresh';
                
                html += `
                    <a class="dropdown-item ${isUnread ? 'unread' : ''}" 
                       href="#" 
                       data-notif-id="${notif.notif_id}"
                       data-tiket-id="${notif.tiket_id}">
                        <div class="notification-item">
                            <div class="notification-icon ${iconClass}">
                                <i class="mdi ${icon}"></i>
                            </div>
                            <div class="notification-content">
                                <h6>${notif.pesan.substring(0, 60)}${notif.pesan.length > 60 ? '...' : ''}</h6>
                                <p class="notification-time">${formatTime(notif.waktu_kirim)}</p>
                            </div>
                        </div>
                    </a>
                `;
            });
            list.html(html);
        }
    }

    // Format waktu relatif
    function formatTime(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();
        const diff = Math.floor((now - date) / 1000); // dalam detik

        if (diff < 60) return 'Baru saja';
        if (diff < 3600) return Math.floor(diff / 60) + ' menit yang lalu';
        if (diff < 86400) return Math.floor(diff / 3600) + ' jam yang lalu';
        if (diff < 604800) return Math.floor(diff / 86400) + ' hari yang lalu';
        
        return date.toLocaleDateString('id-ID');
    }

    // Handle klik notifikasi
    $(document).on('click', '.notification-item', function(e) {
        e.preventDefault();
        const notifId = $(this).closest('a').data('notif-id');
        const tiketId = $(this).closest('a').data('tiket-id');

        // Tandai sebagai sudah dibaca
        $.ajax({
            url: `/notifications/${notifId}/read`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                // Redirect ke halaman tiket
                window.location.href = `/admin/tiket/${tiketId}`;
            }
        });
    });

    // Tandai semua sebagai sudah dibaca
    $('#mark-all-read').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("notifications.readAll") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                loadNotifications();
            }
        });
    });

    // Load notifikasi saat halaman dimuat
    loadNotifications();

    // Auto refresh setiap 30 detik
    setInterval(loadNotifications, 30000);
});
</script>