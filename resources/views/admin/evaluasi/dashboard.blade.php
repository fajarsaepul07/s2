@extends('layouts.admin.master')

@section('content')

<style>
    /* Reuse styles dari list laporan */
    .index-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .index-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .index-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .header-title {
        position: relative;
        z-index: 1;
    }

    .header-title h4 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
    }

    .header-title p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .index-body {
        padding: 2rem;
    }

    /* Stats Cards */
    .stats-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }

    .stats-card-gradient {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .stats-number {
        font-size: 3rem;
        font-weight: 700;
        line-height: 1;
        margin: 1rem 0;
    }

    .stats-label {
        font-size: 0.9rem;
        opacity: 0.8;
        margin-bottom: 0.5rem;
    }

    .stats-icon {
        font-size: 2.5rem;
        opacity: 0.3;
        position: absolute;
        right: 1.5rem;
        top: 1.5rem;
    }

    /* Rating Stars */
    .rating-stars {
        font-size: 1.8rem;
        margin: 1rem 0;
    }

    /* Distribution Bars */
    .distribution-item {
        margin-bottom: 1rem;
    }

    .distribution-stars {
        min-width: 100px;
        font-size: 1.2rem;
    }

    .distribution-bar {
        flex-grow: 1;
        margin: 0 1rem;
    }

    .distribution-bar .progress {
        height: 8px;
        border-radius: 10px;
        background: #f3f4f6;
    }

    .distribution-bar .progress-bar {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    }

    .distribution-count {
        min-width: 100px;
        text-align: right;
    }

    /* Type Stats Cards */
    .type-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
        border-left: 4px solid;
    }

    .type-card.feedback {
        border-left-color: #3b82f6;
    }

    .type-card.evaluasi {
        border-left-color: #10b981;
    }

    .type-card.complaint {
        border-left-color: #ef4444;
    }

    .type-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }

    .type-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0.5rem 0;
    }

    .type-progress {
        height: 6px;
        border-radius: 10px;
        margin-top: 1rem;
    }

    /* Table Container */
    .table-container {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        margin-top: 1.5rem;
    }

    .modern-table {
        margin: 0;
        width: 100%;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8eaff 100%);
    }

    .modern-table thead th {
        border: none;
        color: #4338ca;
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1.2rem 1rem;
        white-space: nowrap;
    }

    .modern-table tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: all 0.2s ease;
    }

    .modern-table tbody tr:hover {
        background: #f9fafb;
    }

    .modern-table tbody tr:last-child {
        border-bottom: none;
    }

    .modern-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: #4b5563;
        border: none;
    }

    /* Avatar */
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin-right: 0.75rem;
    }

    /* Badges */
    .rating-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 1.2rem;
        font-weight: 700;
        color: #f59e0b;
    }

    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .type-badge.feedback {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
    }

    .type-badge.evaluasi {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .type-badge.complaint {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }

    .count-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.3rem 0.7rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    /* Complaint Card */
    .complaint-card {
        background: white;
        border-radius: 12px;
        padding: 1.2rem;
        margin-bottom: 1rem;
        border-left: 4px solid #ef4444;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
    }

    .complaint-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateX(3px);
    }

    /* Buttons */
    .btn-back {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
        padding: 0.6rem 1.3rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-detail {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }

    .btn-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        color: white;
    }

    .btn-view-complaint {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: none;
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }

    .btn-view-complaint:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #9ca3af;
    }

    .empty-state i {
        font-size: 3rem;
        opacity: 0.3;
        margin-bottom: 1rem;
    }

    .empty-state h5 {
        color: #6b7280;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #9ca3af;
        font-size: 0.95rem;
    }

    /* Section Title */
    .section-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: #667eea;
    }

    /* Scrollable Area */
    .scrollable-area {
        max-height: 500px;
        overflow-y: auto;
        padding-right: 0.5rem;
    }

    .scrollable-area::-webkit-scrollbar {
        width: 6px;
    }

    .scrollable-area::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 10px;
    }

    .scrollable-area::-webkit-scrollbar-track {
        background: #f3f4f6;
        border-radius: 10px;
    }

    @media (max-width: 768px) {
        .index-header {
            padding: 1.5rem;
        }

        .header-title h4 {
            font-size: 1.5rem;
        }

        .index-body {
            padding: 1rem;
        }

        .stats-number {
            font-size: 2rem;
        }
    }
</style>

@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil! 🎉',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    });
</script>
@endif

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mt-3">
            {{-- Header Card --}}
            <div class="card index-card">
                <div class="index-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="header-title">
                            <h4>📊 Dashboard Evaluasi & Feedback</h4>
                            <p>Monitoring kualitas layanan berdasarkan feedback user</p>
                        </div>
                        <a href="{{ route('admin.tiket.index') }}" class="btn-back">
                            <i class="mdi mdi-arrow-left"></i> Kembali ke Tiket
                        </a>
                    </div>
                </div>

                <div class="index-body">
                    {{-- Rating Overview --}}
                    <div class="row mb-4">
                        {{-- Average Rating Card --}}
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="stats-card stats-card-gradient position-relative">
                                <i class="mdi mdi-star stats-icon"></i>
                                <div class="stats-label">Rating Rata-rata</div>
                                <div class="stats-number">
                                    {{ number_format($averageRating, 1) }}
                                    <span style="font-size: 1.5rem; font-weight: 400;">/5.0</span>
                                </div>
                                <div class="rating-stars text-center my-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span>{{ $i <= round($averageRating) ? '⭐' : '☆' }}</span>
                                    @endfor
                                </div>
                                <div class="stats-label">Dari {{ $ratingStats->sum('total') }} penilaian</div>
                            </div>
                        </div>

                        {{-- Rating Distribution --}}
                        <div class="col-lg-8 col-md-6 mb-3">
                            <div class="stats-card">
                                <h5 class="section-title mb-4">
                                    <i class="mdi mdi-chart-bar"></i> Distribusi Rating
                                </h5>
                                @foreach($ratingStats->sortByDesc('rating') as $stat)
                                    <div class="distribution-item d-flex align-items-center">
                                        <div class="distribution-stars">
                                            {{ str_repeat('⭐', $stat->rating) }}
                                        </div>
                                        <div class="distribution-bar">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" 
                                                    style="width: {{ ($stat->total / $ratingStats->sum('total')) * 100 }}%">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="distribution-count">
                                            <span style="font-weight: 700; color: #1f2937;">{{ $stat->total }}</span>
                                            <span style="color: #9ca3af; font-size: 0.85rem;">
                                                ({{ number_format(($stat->total / $ratingStats->sum('total')) * 100, 1) }}%)
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Tipe Komentar Stats --}}
                    <div class="row mb-4">
                        @foreach($tipeStats as $tipe)
                            <div class="col-lg-4 col-md-6 mb-3">
                                <div class="type-card {{ $tipe->tipe_komentar }}">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 style="font-weight: 700; margin: 0; color: 
                                                @if($tipe->tipe_komentar === 'feedback') #3b82f6
                                                @elseif($tipe->tipe_komentar === 'evaluasi') #10b981
                                                @else #ef4444
                                                @endif">
                                                @if($tipe->tipe_komentar === 'feedback')
                                                    <i class="mdi mdi-thumb-up"></i> Feedback Positif
                                                @elseif($tipe->tipe_komentar === 'evaluasi')
                                                    <i class="mdi mdi-chart-line"></i> Evaluasi
                                                @else
                                                    <i class="mdi mdi-alert"></i> Keluhan
                                                @endif
                                            </h6>
                                            <small style="color: #6b7280;">Total komentar masuk</small>
                                        </div>
                                        <div class="type-number" style="color: 
                                            @if($tipe->tipe_komentar === 'feedback') #3b82f6
                                            @elseif($tipe->tipe_komentar === 'evaluasi') #10b981
                                            @else #ef4444
                                            @endif">
                                            {{ $tipe->total }}
                                        </div>
                                    </div>
                                    <div class="progress type-progress">
                                        <div class="progress-bar" 
                                            style="width: {{ ($tipe->total / $tipeStats->sum('total')) * 100 }}%; background: 
                                                @if($tipe->tipe_komentar === 'feedback') linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)
                                                @elseif($tipe->tipe_komentar === 'evaluasi') linear-gradient(135deg, #10b981 0%, #059669 100%)
                                                @else linear-gradient(135deg, #ef4444 0%, #dc2626 100%)
                                                @endif">
                                        </div>
                                    </div>
                                    <small style="color: #9ca3af; margin-top: 0.5rem; display: block;">
                                        {{ number_format(($tipe->total / $tipeStats->sum('total')) * 100, 1) }}% dari total
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Performa Tim & Keluhan --}}
                    <div class="row mb-4">
                        {{-- Performa Tim --}}
                        <div class="col-lg-6 mb-3">
                            <div class="stats-card">
                                <h5 class="section-title mb-4">
                                    <i class="mdi mdi-account-group"></i> Performa Tim
                                </h5>
                                <div class="table-container">
                                    <table class="modern-table">
                                        <thead>
                                            <tr>
                                                <th>Tim Support</th>
                                                <th class="text-center">Rating</th>
                                                <th class="text-center">Komentar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($timStats as $stat)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="user-avatar">
                                                                {{ strtoupper(substr($stat['user']->name, 0, 1)) }}
                                                            </div>
                                                            <div>
                                                                <div style="font-weight: 600; color: #1f2937;">
                                                                    {{ $stat['user']->name }}
                                                                </div>
                                                                <small style="color: #9ca3af;">
                                                                    {{ $stat['user']->email }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="rating-badge">
                                                            ⭐ {{ $stat['avg_rating'] }}
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="count-badge">
                                                            {{ $stat['total_komentar'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3">
                                                        <div class="empty-state">
                                                            <i class="mdi mdi-inbox"></i>
                                                            <p class="mb-0">Belum ada data performa tim</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Keluhan Prioritas --}}
                        <div class="col-lg-6 mb-3">
                            <div class="stats-card">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="section-title mb-0">
                                        <i class="mdi mdi-alert"></i> Keluhan & Rating Rendah
                                    </h5>
                                    <span class="count-badge" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                                        {{ $complaints->count() }}
                                    </span>
                                </div>
                                <div class="scrollable-area">
                                    @forelse($complaints as $complaint)
                                        <div class="complaint-card">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <div style="font-weight: 700; color: #1f2937;">
                                                        {{ $complaint->user->name }}
                                                    </div>
                                                    <small style="color: #667eea;">
                                                        <i class="mdi mdi-ticket"></i> 
                                                        {{ $complaint->tiket->kode_tiket }}
                                                    </small>
                                                </div>
                                                <div class="text-end">
                                                    <div class="mb-1" style="font-size: 1.1rem;">
                                                        {{ str_repeat('⭐', $complaint->rating) }}
                                                    </div>
                                                    <span class="type-badge {{ $complaint->tipe_komentar }}">
                                                        {{ ucfirst($complaint->tipe_komentar) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <p style="color: #4b5563; font-size: 0.9rem; margin-bottom: 0.75rem;">
                                                {{ Str::limit($complaint->komentar, 120) }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small style="color: #9ca3af;">
                                                    <i class="mdi mdi-clock-outline"></i> 
                                                    {{ $complaint->waktu_komentar->diffForHumans() }}
                                                </small>
                                                <a href="{{ route('admin.tiket.show', $complaint->tiket_id) }}" 
                                                    class="btn-view-complaint">
                                                    <i class="mdi mdi-eye"></i> Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="empty-state">
                                            <i class="mdi mdi-check-circle"></i>
                                            <h5>Tidak ada keluhan</h5>
                                            <p class="mb-0">Semua feedback positif! 🎉</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Komentar Terbaru --}}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="stats-card">
                                <h5 class="section-title mb-4">
                                    <i class="mdi mdi-comment-text"></i> Komentar Terbaru
                                </h5>
                                <div class="table-container">
                                    <table class="modern-table">
                                        <thead>
                                            <tr>
                                                <th>User & Tiket</th>
                                                <th>Komentar</th>
                                                <th class="text-center">Tipe</th>
                                                <th class="text-center">Rating</th>
                                                <th>Waktu</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentKomentars as $komentar)
                                                <tr>
                                                    <td>
                                                        <div style="font-weight: 600; color: #1f2937;">
                                                            {{ $komentar->user->name }}
                                                        </div>
                                                        <small style="color: #667eea;">
                                                            <i class="mdi mdi-ticket"></i> 
                                                            {{ $komentar->tiket->kode_tiket }}
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <span style="color: #6b7280; font-size: 0.9rem;">
                                                            {{ Str::limit($komentar->komentar, 80) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="type-badge {{ $komentar->tipe_komentar }}">
                                                            {{ ucfirst($komentar->tipe_komentar) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span style="font-size: 1.1rem;">
                                                            {{ str_repeat('⭐', $komentar->rating) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <small style="color: #9ca3af;">
                                                            {{ $komentar->waktu_komentar->diffForHumans() }}
                                                        </small>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.tiket.show', $komentar->tiket_id) }}" 
                                                            class="btn-detail">
                                                            <i class="mdi mdi-eye"></i> Detail
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6">
                                                        <div class="empty-state">
                                                            <i class="mdi mdi-inbox"></i>
                                                            <h5>Belum ada komentar</h5>
                                                            <p class="mb-0">Komentar akan muncul di sini</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection