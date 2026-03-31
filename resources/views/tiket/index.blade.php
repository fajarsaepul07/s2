@extends('layouts.components-frontend.master')
@section('pageTitle', 'Daftar Tiket Saya')

@section('content')

@push('styles')
<style>
    /* === TYPOGRAPHY DISAMAKAN DENGAN INDEX LAPORAN === */

    .tiket-title {
        font-size: 1.75rem;
        font-weight: 700;
    }

    .tiket-subtitle {
        font-size: 0.95rem;
        color: #6c757d;
    }

    .stats-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
    }

    .stats-value {
        font-size: 1.75rem;
        font-weight: 700;
    }

    table thead th {
        font-size: 0.75rem !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #6c757d;
    }

    table tbody td {
        font-size: 0.9rem;
    }
</style>
@endpush


<div class="container-fluid px-4" style="padding-top: 70px;">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="tiket-title mb-1">📋 Tiket Saya</h3>
            <p class="tiket-subtitle mb-0">Kelola dan pantau semua tiket bantuan Anda</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('tiket.history') }}" class="btn btn-warning">
                <i class="lni lni-history"></i> Riwayat Tiket
            </a>
            <a href="{{ route('tiket.create') }}" class="btn btn-primary">
                <i class="lni lni-plus"></i> Buat Tiket Baru
            </a>
        </div>
    </div>

    {{-- ALERT --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center">
            <i class="lni lni-check me-2 fs-5"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center">
            <i class="lni lni-warning me-2 fs-5"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- STATISTIK --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-opacity-10 rounded-3 p-3">
                        <i class="lni lni-ticket fs-3 text-primary"></i>
                    </div>
                    <div class="ms-3">
                        <p class="stats-label">Total Tiket</p>
                        <div class="stats-value">{{ $stats['total'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-opacity-10 rounded-3 p-3">
                        <i class="lni lni-checkmark-circle fs-3 text-success"></i>
                    </div>
                    <div class="ms-3">
                        <p class="stats-label">Selesai</p>
                        <div class="stats-value">{{ $stats['selesai'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-opacity-10 rounded-3 p-3">
                        <i class="lni lni-timer fs-3 text-warning"></i>
                    </div>
                    <div class="ms-3">
                        <p class="stats-label">Diproses</p>
                        <div class="stats-value">{{ $stats['diproses'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-opacity-10 rounded-3 p-3">
                        <i class="lni lni-cross-circle fs-3 text-danger"></i>
                    </div>
                    <div class="ms-3">
                        <p class="stats-label">Ditolak</p>
                        <div class="stats-value">{{ $stats['ditolak'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL TIKET --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold">Daftar Tiket Terbaru</h5>
            <span class="badge bg-primary">{{ $tikets->count() }} tiket</span>
        </div>

        <div class="card-body p-0">
            @if ($tikets->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Kode & Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Ditangani</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tikets as $tiket)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="fw-semibold text-primary small">#{{ $tiket->kode_tiket }}</div>
                                        <div class="fw-semibold">{{ Str::limit($tiket->judul, 40) }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info bg-opacity-75">
                                            {{ $tiket->kategori->nama_kategori ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($tiket->status->nama_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted d-block">
                                            {{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('d M Y') }}
                                        </small>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        {{ $tiket->assignedTo->name ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('tiket.show', $tiket->tiket_id) }}"
                                           class="btn btn-sm btn-info">
                                            <i class="lni lni-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <h5 class="text-muted mb-2">Belum Ada Tiket</h5>
                    <p class="text-muted">Silakan buat tiket baru</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
