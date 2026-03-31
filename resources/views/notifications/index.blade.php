@extends('layouts.components-frontend.master')
@section('pageTitle', 'Notifikasi Saya')

@section('content')

@push('styles')
<style>
    /* === TYPOGRAPHY SAMA DENGAN INDEX LAPORAN === */

    .notif-title {
        font-size: 1.75rem;
        font-weight: 700;
    }

    .notif-subtitle {
        font-size: 0.95rem;
        color: #6c757d;
    }

    .notif-card-title {
        font-size: 1.1rem;
        font-weight: 600;
    }

    .notif-item-title {
        font-size: 0.95rem;
        font-weight: 600;
    }

    .notif-message {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .notif-date {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .notif-unread {
        background-color: #f8f9ff;
        border-left: 4px solid #0d6efd;
    }
</style>
@endpush


<div class="container-fluid px-4" style="padding-top: 70px;">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="notif-title mb-1">🔔 Notifikasi</h3>
            <p class="notif-subtitle mb-0">
                Informasi terbaru terkait laporan dan aktivitas Anda
            </p>
        </div>

        @if ($notifications->count())
            <form action="{{ route('notifications.markAllRead') }}" method="POST">
                @csrf
                <button class="btn btn-primary">
                    <i class="lni lni-checkmark-circle"></i>
                    Tandai Semua Dibaca
                </button>
            </form>
        @endif
    </div>

    {{-- ALERT --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="lni lni-check me-2 fs-5"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- LIST NOTIFIKASI --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="notif-card-title mb-0">Daftar Notifikasi</h5>
        </div>

        <div class="card-body p-0">

            @forelse ($notifications as $notif)
                <div
                    class="px-4 py-3 border-bottom d-flex justify-content-between align-items-start
                    {{ !$notif->status_baca ? 'notif-unread' : '' }}"
                    onclick="window.location='{{ $notif->tiket_id ? route('report.show', $notif->tiket_id) : '#' }}'"
                    style="cursor: pointer;"
                >
                    {{-- ISI --}}
                    <div class="pe-3">
                        <div class="notif-item-title mb-1">
                            {{ $notif->judul ?? 'Notifikasi Sistem' }}
                        </div>

                        <div class="notif-message">
                            {{ $notif->pesan }}
                        </div>

                        <div class="notif-date mt-1">
                            <i class="lni lni-calendar me-1"></i>
                            {{ \Carbon\Carbon::parse($notif->waktu_kirim)->diffForHumans() }}
                        </div>
                    </div>

                    {{-- ACTION --}}
                    <div onclick="event.stopPropagation();">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="lni lni-cog"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">
                                @if (!$notif->status_baca)
                                    <li>
                                        <form action="{{ route('notifications.read', $notif->notif_id) }}" method="POST">
                                            @csrf
                                            <button class="dropdown-item">
                                                <i class="lni lni-checkmark"></i>
                                                Tandai Dibaca
                                            </button>
                                        </form>
                                    </li>
                                @endif

                                @if ($notif->tiket_id)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('report.show', $notif->tiket_id) }}">
                                            <i class="lni lni-eye"></i>
                                            Lihat Laporan
                                        </a>
                                    </li>
                                @endif

                                <li><hr class="dropdown-divider"></li>

                                <li>
                                    <form action="{{ route('notifications.destroy', $notif->notif_id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus notifikasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item text-danger">
                                            <i class="lni lni-trash"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            @empty
                {{-- EMPTY STATE --}}
                <div class="text-center py-5">
                    <h5 class="text-muted mb-2">Belum Ada Notifikasi</h5>
                    <p class="text-muted mb-0">
                        Semua notifikasi Anda akan muncul di sini.
                    </p>
                </div>
            @endforelse

        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-3">
        {{ $notifications->links() }}
    </div>

</div>

@endsection
