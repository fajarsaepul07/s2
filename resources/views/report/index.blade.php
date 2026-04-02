@extends('layouts.components-frontend.master')
@section('pageTitle', 'Daftar Laporan Saya')

@section('content')

@push('styles')
<style>
    /* === TYPOGRAPHY GLOBAL UNTUK INDEX LAPORAN === */

    /* Heading Utama */
    .report-title {
        font-size: 1.75rem;
        font-weight: 700;
    }

    .report-subtitle {
        font-size: 0.95rem;
        color: #6c757d;
    }

    /* Statistik Card */
    .stats-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 2px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .stats-value {
        font-size: 1.75rem;
        font-weight: 700;
    }

    /* Card Header (Daftar Laporan) */
    .report-card-title {
        font-size: 1.1rem;
        font-weight: 600;
    }

    /* Tabel */
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

    /* Badge kategori */
    .report-badge {
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Tanggal */
    .report-date {
        font-size: 0.8rem;
    }

    /* Tombol kecil */
    .btn-sm i {
        font-size: 0.9rem !important;
    }

    /* Label form */
    .form-label {
        font-size: 0.85rem;
        font-weight: 600;
    }
</style>
@endpush


<div class="container-fluid px-4" style="padding-top: 70px;">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="report-title mb-1">📋 Laporan Saya</h3>
            <p class="report-subtitle mb-0">Kelola dan pantau semua laporan masalah Anda</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('report.history') }}" class="btn btn-warning">
                <i class="lni lni-history"></i> Riwayat Laporan
            </a>
            <a href="{{ route('report.create') }}" class="btn btn-primary">
                <i class="lni lni-plus"></i> Buat Laporan Baru
            </a>
        </div>
    </div>


    {{-- ALERT --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="lni lni-check me-2 fs-5"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="lni lni-alert-triangle me-2 fs-5"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


   {{-- STATISTIK CARD (DISESUAIKAN DENGAN HISTORY) --}}
<div class="row g-3 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-opacity-10 rounded-3 p-3">
                            <i class="lni lni-ticket fs-3 text-primary"></i>
                        </div>
                    </div>
                    <div class="ms-3">
                        <p class="stats-label">Total Tiket</p>
                        <div class="stats-value">{{ $stats['total'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-opacity-10 rounded-3 p-3">
                            <i class="lni lni-checkmark-circle text-success fs-3"></i>
                        </div>
                    </div>
                    <div class="ms-3">
                        <p class="stats-label">Selesai</p>
                        <div class="stats-value">{{ $stats['selesai'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-opacity-10 rounded-3 p-3">
                            <i class="lni lni-timer text-warning fs-3"></i>
                        </div>
                    </div>
                    <div class="ms-3">
                        <p class="stats-label">Diproses</p>
                        <div class="stats-value">{{ $stats['diproses'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-opacity-10 rounded-3 p-3">
                            <i class="lni lni-cross-circle text-danger fs-3"></i>
                        </div>
                    </div>
                    <div class="ms-3">
                        <p class="stats-label">Ditolak</p>
                        <div class="stats-value">{{ $stats['ditolak'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    {{-- FILTER --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form action="{{ route('report.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small">Kategori</label>
                        <select name="kategori_id" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->kategori_id }}"
                                    {{ request('kategori_id') == $kategori->kategori_id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="lni lni-search"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    {{-- TABEL LAPORAN --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="report-card-title mb-0">Daftar Laporan</h5>
        </div>

        <div class="card-body p-0">
            @if ($reports->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3 fw-semibold text-uppercase small">Judul & Deskripsi</th>
                                <th class="py-3 fw-semibold text-uppercase small">Kategori</th>
                                <th class="py-3 fw-semibold text-uppercase small">Status</th>
                                <th class="py-3 fw-semibold text-uppercase small">Tanggal</th>
                                <th class="py-3 fw-semibold text-uppercase small">Ditangani Oleh</th>
                                <th class="py-3 fw-semibold text-uppercase small text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                                <tr onclick="window.location='{{ route('report.show', $report->id) }}'" style="cursor:pointer;">
                                    <td class="px-4 py-3">
                                        <div class="fw-semibold">{{ $report->judul }}</div>
                                        @if ($report->deskripsi)
                                            <small class="text-muted">{{ Str::limit($report->deskripsi, 60) }}</small>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge bg-info bg-opacity-75 report-badge">
                                            <i class="lni lni-tag"></i> {{ $report->kategori->nama_kategori ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="py-3">
                                            @php
                                                $statusBadge = match ($report->status) {
                                                    'selesai' => 'bg-success',
                                                    'diproses' => 'bg-warning',
                                                    'ditolak' => 'bg-danger',
                                                    'pending' => 'bg-info',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $statusBadge }}">
                                                {{ ucfirst($report->status) }}
                                            </span>
                                        </td>

                                    <td>
                                        <small class="text-muted report-date">
                                            <i class="lni lni-calendar me-1"></i>
                                            {{ $report->created_at->format('d M Y') }}
                                        </small><br>
                                        <small class="text-muted report-date">
                                            {{ $report->created_at->format('H:i') }}
                                        </small>
                                    </td>

                                    <td class="py-3">
                                        @if ($report->assignedUser)
                                            <div class="d-flex align-items-center">
                                                <div class="me-2">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                        style="width: 32px; height: 32px; font-size: 14px;">
                                                        {{ strtoupper(substr($report->assignedUser->name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <small
                                                    class="fw-semibold">{{ Str::limit($report->assignedUser->name, 15) }}</small>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td onclick="event.stopPropagation();" class="text-center">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('report.show', $report->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                                <i class="lni lni-eye"></i>
                                            </a>
                                            <form action="{{ route('report.destroy', $report->id) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')" title="Hapus">
                                                    <i class="lni lni-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else

                {{-- EMPTY STATE --}}
                <div class="text-center py-5">

                    <h5 class="text-muted mb-2">Belum Ada Laporan</h5>
                    <p class="text-muted mb-4">Anda belum memiliki laporan. Buat laporan pertama Anda.</p>

                    <a href="{{ route('report.create') }}" class="btn btn-primary">
                        <i class="lni lni-plus"></i> Buat Laporan Pertama
                    </a>
                </div>

            @endif
        </div>
    </div>

</div>

<div class="preloader" style="display:none;"></div>

<div class="pricing-active d-none">
    <div class="single-slide"></div>
</div>

@endsection