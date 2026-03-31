 <div class="sidebar" id="sidebar">
        <div class="sidebar-inner">
            <div class="sidebar-menu">
                <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
                    <i class="lni lni-home"></i> <span>Home</span>
                </a>
                @auth
                <hr>
                <a href="{{ route('tiket.index') }}" class="{{ request()->routeIs('tiket.*') ? 'active' : '' }}">
                    <i class="lni lni-ticket"></i> <span>Tiket Saya</span>
                </a>
                <a href="{{ route('report.index') }}" class="{{ request()->routeIs('report.*') ? 'active' : '' }}">
                    <i class="lni lni-files"></i> <span>Laporan</span>
                </a>
                <a href="{{ route('notifications.index') }}"><i class="lni lni-alarm"></i> <span>Notifikasi</span></a>
                <hr>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="lni lni-exit"></i> <span>Logout</span>
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">@csrf</form>
                @endauth
                @guest
                <hr>
                @endguest
            </div>
        </div>
    </div>