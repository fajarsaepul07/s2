@extends('layouts.components-frontend.master')
@section('pageTitle', 'Detail Tiket')

@section('content')

@include('layouts.components-frontend.navbar')

@push('styles')
<style>

/* === TYPOGRAPHY DETAIL TIKET (SAMA DENGAN RIWAYAT) === */

.report-title{
    font-size:1.6rem;
    font-weight:700;
}

.report-subtitle{
    font-size:0.9rem;
    color:#6c757d;
}

.report-card-title{
    font-size:1.1rem;
    font-weight:600;
}

/* Card */

.card{
    border-radius:12px;
    transition:all .3s ease;
}

.card:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(0,0,0,0.08)!important;
}

/* Badge */

.badge{
    font-size:12px;
    padding:6px 12px;
    font-weight:500;
}

/* Description */

.description-content{
    background:#f8f9fa;
    border-radius:10px;
    padding:18px;
}

/* Attachment */

.attachment-box{
    border:1px dashed #dee2e6;
    border-radius:10px;
    padding:18px;
}

/* Comment */

.comment-box{
    background:#f8f9fa;
    border-radius:10px;
}

/* Timeline */

.timeline-modern{
    position:relative;
}

.timeline-item-modern{
    position:relative;
    padding-left:40px;
    padding-bottom:20px;
}

.timeline-dot-modern{
    position:absolute;
    left:0;
    top:0;
    width:14px;
    height:14px;
    border-radius:50%;
}

.timeline-item-modern::before{
    content:'';
    position:absolute;
    left:6px;
    top:14px;
    height:100%;
    width:2px;
    background:#dee2e6;
}

.timeline-content-modern{
    background:#f8f9fa;
    border-radius:8px;
    padding:12px;
}

/* Footer */

.footer-modern{
    margin-top:50px;
    padding:20px 0;
    border-top:1px solid #dee2e6;
}

</style>
@endpush


<div class="container-fluid px-4" style="padding-top:70px;">

    {{-- Breadcrumb --}}

    <nav aria-label="breadcrumb" class="mb-4">
        <h3 class="tiket-title mb-1"><a href="{{ route('tiket.index') }}" class="text-decoration-none">
            📋 Detail Tiket</a></h3>
    </nav>

    {{-- Alert Success --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    {{-- CTA COMMENT WHEN FINISHED --}}
    @if($tiket->status->nama_status === 'Selesai')
        @if(!$tiket->hasUserComment(Auth::id()))
            <div class="alert alert-primary mb-4">
                <strong>Tiket Anda telah selesai.</strong>
                Silakan berikan komentar untuk membantu kami meningkatkan layanan.

                <div class="mt-2">
                    <a href="{{ route('tiket.komentar.form', $tiket->tiket_id) }}" class="btn btn-primary btn-sm">
                        Berikan Komentar
                    </a>
                </div>
            </div>
        @else
            <div class="alert alert-success mb-4">
                Terima kasih! Anda sudah memberikan komentar untuk tiket ini.
            </div>
        @endif
    @endif


    <div class="row g-4">

        {{-- MAIN CONTENT --}}
        <div class="col-lg-8">

            {{-- HEADER CARD --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">

                    <h3 class="report-title mb-2">{{ $tiket->judul }}</h3>

                    <p class="report-subtitle mb-3">
                        Dibuat oleh {{ $tiket->user->name ?? 'Unknown' }} •
                        {{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('d M Y H:i') }}
                    </p>

                    <div class="d-flex gap-2">

                        @php
                            $p = strtolower($tiket->prioritas->nama_prioritas ?? '');
                            $prioritasColor = 'secondary';

                            if(str_contains($p,'critical') || str_contains($p,'high') || str_contains($p,'tinggi')){
                                $prioritasColor='danger';
                            }elseif(str_contains($p,'medium') || str_contains($p,'sedang')){
                                $prioritasColor='warning';
                            }else{
                                $prioritasColor='info';
                            }
                        @endphp

                        <span class="badge bg-{{ $prioritasColor }}">
                            {{ $tiket->prioritas->nama_prioritas ?? 'Medium' }}
                        </span>

                        @php
                            $statusName = $tiket->status->nama_status ?? 'Open';
                            $statusColor = 'secondary';

                            if($statusName == 'In Progress'){
                                $statusColor='primary';
                            }elseif($statusName == 'Resolved' || $statusName == 'Selesai'){
                                $statusColor='success';
                            }elseif($statusName == 'Closed'){
                                $statusColor='secondary';
                            }elseif($statusName == 'Open'){
                                $statusColor='warning';
                            }
                        @endphp

                        <span class="badge bg-{{ $statusColor }}">
                            {{ $statusName }}
                        </span>

                    </div>

                </div>
            </div>


            {{-- DESKRIPSI --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">

                    <h5 class="report-card-title mb-3">
                        Deskripsi Tiket
                    </h5>

                    <div class="description-content">
                        <p class="mb-0">{{ $tiket->deskripsi }}</p>
                    </div>

                </div>
            </div>


            {{-- LAMPIRAN --}}
            @if($tiket->lampiran)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">

                    <h5 class="report-card-title mb-3">
                        Lampiran
                    </h5>

                    <div class="attachment-box d-flex justify-content-between align-items-center">

                        <div>
                            <strong>{{ basename($tiket->lampiran) }}</strong>
                        </div>

                        <a href="{{ asset('storage/lampiran/' . $tiket->lampiran) }}"
                           target="_blank"
                           class="btn btn-sm btn-primary">

                           Download
                        </a>

                    </div>

                </div>
            </div>
            @endif


            {{-- KOMENTAR --}}
            @php
                $userComments = $tiket->komentars->where('user_id', Auth::id());
            @endphp

            @if($userComments && $userComments->count() > 0)

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">

                    <h5 class="report-card-title mb-3">
                        Komentar Anda
                    </h5>

                    @foreach($userComments as $komentar)

                        <div class="comment-box p-3 mb-3">

                            <div class="d-flex justify-content-between mb-2">

                                <span class="badge bg-primary">
                                    {{ $komentar->tipe_komentar }}
                                </span>

                                <small class="text-muted">
                                    {{ $komentar->waktu_komentar->format('d M Y H:i') }}
                                </small>

                            </div>

                            <p class="mb-1">{{ $komentar->komentar }}</p>

                            <small>
                                Rating: {{ str_repeat('⭐', $komentar->rating) }}
                            </small>

                        </div>

                    @endforeach

                </div>
            </div>

            @endif

        </div>


        {{-- SIDEBAR --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">

                    <p class="text-muted small mb-1">Kategori</p>
                    <p class="fw-semibold mb-3">
                        {{ $tiket->kategori->nama_kategori ?? 'Tidak ada' }}
                    </p>

                    <p class="text-muted small mb-1">Dibuat</p>
                    <p class="fw-semibold mb-0">
                        {{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->diffForHumans() }}
                    </p>

                </div>
            </div>


            {{-- TIMELINE --}}
            <!-- <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5 class="report-card-title mb-4">
                        Riwayat Status
                    </h5>

                    <div class="timeline-modern">

                        @if($tiket->riwayat && $tiket->riwayat->count() > 0)

                            @foreach($tiket->riwayat as $index => $log)

                                <div class="timeline-item-modern">

                                    <div class="timeline-dot-modern bg-primary"></div>

                                    <div class="timeline-content-modern">

                                        <strong>
                                            {{ $log->status->nama_status ?? '-' }}
                                        </strong>

                                        <div class="text-muted small">
                                            {{ $log->user->name ?? '-' }}
                                        </div>

                                        <div class="text-muted small">
                                            {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i') }}
                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        @endif

                    </div>

                </div>

            </div> -->

        </div>

    </div>

</div>


<footer class="footer-modern text-center">
    <div class="container">
        <small class="text-muted">
            © 2025 Helpdesk System
        </small>
    </div>
</footer>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

@endsection