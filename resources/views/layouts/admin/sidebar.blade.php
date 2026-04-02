<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        {{-- Semua role bisa melihat Dashboard --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="mdi mdi-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        {{-- ✅ Hanya ADMIN yang bisa melihat menu Tiket dan Pengaturan --}}
        @if (auth()->user()->role === 'admin')
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
                    aria-controls="ui-basic">
                    <i class="mdi mdi-circle-outline menu-icon"></i>
                    <span class="menu-title">Tiket</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('kategori.index') }}">Kategori</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.status.index') }}">Status</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.prioritas.index') }}">Prioritas</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.tiket.index') }}">Tiket</a></li>
                    </ul>
                </div>
            </li>

            {{-- Menu Laporan khusus Admin --}}
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#report-menu" aria-expanded="false"
                    aria-controls="report-menu">
                    <i class="mdi mdi-file-document-box-outline menu-icon"></i>
                    <span class="menu-title">Laporan</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="report-menu">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.report.index') }}">Daftar
                                Laporan</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.report.create') }}">Buat Laporan
                                Baru</a></li>
                    </ul>
                </div>
            </li>

            {{-- FIXED: Menu Feedback dengan route name yang benar --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.evaluasi.dashboard') }}">
                    <i class="mdi mdi-message-alert-outline menu-icon" style="color: #000 !important;"></i>
                    <span class="menu-title" style="color: #000 !important;">Feedback</span>
                </a>
            </li>
        @endif

        {{-- ✅ Menu untuk TIM TEKNISI dan TIM KONTEN --}}
        @if (auth()->user()->role === 'tim_teknisi' || auth()->user()->role === 'tim_konten')
            {{-- Menu Tiket yang Ditugaskan --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tim.tiket.index') }}">
                    <i class="mdi mdi-ticket menu-icon"></i>
                    <span class="menu-title">Tiket Saya</span>
                    @php
                        $assignedCount = \App\Models\Tiket::where('assigned_to', auth()->id())
                            ->whereHas('status', function ($q) {
                                $q->whereIn('nama_status', ['Baru', 'Sedang Diproses']);
                            })
                            ->count();
                    @endphp
                    @if ($assignedCount > 0)
                        <badge class="badge badge-danger ml-2">{{ $assignedCount }}</badge>
                    @endif
                </a>
            </li>

            {{-- Menu Laporan yang Ditugaskan --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('report.index') }}">
                    <i class="mdi mdi-file-document-box-outline menu-icon"></i>
                    <span class="menu-title">Laporan Saya</span>
                </a>
            </li>
        @endif

    </ul>
</nav>