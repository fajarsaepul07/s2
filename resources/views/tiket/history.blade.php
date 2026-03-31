@extends('layouts.components-frontend.master')
@section('pageTitle', 'Riwayat Tiket')

@section('content')

@push('styles')
<style>
    /* === TYPOGRAPHY GLOBAL UNTUK RIWAYAT TIKET === */

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

    /* Card Header */
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

    /* Badge */
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

    /* Card Hover Effect */
    .card {
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08) !important;
    }

    /* Table Styling */
    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9ff;
    }

    /* Badge Styling */
    .badge {
        padding: 6px 12px;
        font-weight: 500;
        font-size: 12px;
        letter-spacing: 0.3px;
    }

    /* Alert Styling */
    .alert {
        border-radius: 10px;
        border: none;
    }

    /* Form Controls */
    .form-control,
    .form-select {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 10px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0052CC;
        box-shadow: 0 0 0 0.2rem rgba(0, 82, 204, 0.15);
    }

    /* Animation */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: slideDown 0.3s ease;
    }

    /* Pagination */
    .pagination .page-link {
        border-radius: 6px;
        margin: 0 2px;
        border: 1px solid #dee2e6;
    }

    .pagination .page-item.active .page-link {
        background-color: #0052CC;
        border-color: #0052CC;
    }
</style>
@endpush

<div class="container-fluid px-4" style="padding-top: 70px;"> 

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="report-title mb-1">🎫 Riwayat Tiket Saya</h3>
            <p class="report-subtitle mb-0">History semua tiket yang pernah Anda buat</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('tiket.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                <i class="lni lni-arrow-left me-2"></i>Kembali ke Tiket Aktif
            </a>
        </div>
    </div>

    {{-- ALERT SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="lni lni-checkmark-circle me-2 fs-5"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="lni lni-warning me-2 fs-5"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- STATISTIK CARD --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-opacity-10 rounded-3 p-3">
                            <i class="lni lni-ticket text-primary fs-3"></i>
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
                        <div class=" bg-opacity-10 rounded-3 p-3">
                            <i class="lni lni-checkmark-circle text-success fs-3"></i>
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
                        <div class=" bg-opacity-10 rounded-3 p-3">
                            <i class="lni lni-timer text-warning fs-3"></i>
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
                        <div class="bg-opacity-10 rounded-3 p-3">
                            <i class="lni lni-cross-circle text-danger fs-3"></i>
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

    {{-- STATISTIK PER KATEGORI --}}
    @if ($kategoriStats->count() > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="lni lni-bar-chart text-primary"></i> Statistik per Kategori
                        </h5>
                        <div class="row g-3">
                            @foreach ($kategoriStats as $stat)
                                <div class="col-md-3">
                                    <div class="border rounded-3 p-3 bg-light">
                                        <p class="text-muted mb-1 small">
                                            {{ $stat->kategori->nama_kategori ?? 'N/A' }}</p>
                                        <h4 class="mb-0 fw-bold text-primary">{{ $stat->total }} <span
                                                class="small fw-normal text-muted">tiket</span></h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- FILTER SECTION --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('tiket.history') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small">
                            <i class="lni lni-search-alt text-primary"></i> Cari Tiket
                        </label>
                        <input type="text" name="search" class="form-control" placeholder="Judul atau kode tiket..."
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold small">
                            <i class="lni lni-calendar text-primary"></i> Dari Tanggal
                        </label>
                        <input type="date" name="start_date" class="form-control"
                            value="{{ request('start_date') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold small">
                            <i class="lni lni-calendar text-primary"></i> Sampai Tanggal
                        </label>
                        <input type="date" name="end_date" class="form-control"
                            value="{{ request('end_date') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold small">Status</label>
                        <select name="status_id" class="form-select">
                            <option value="">Semua Status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->status_id }}"
                                    {{ request('status_id') == $status->status_id ? 'selected' : '' }}>
                                    {{ $status->nama_status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

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

                    <div class="col-md-1">
                        <label class="form-label fw-semibold small d-block">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="lni lni-funnel"></i>
                        </button>
                    </div>
                </div>

                @if (request()->hasAny(['search', 'start_date', 'end_date', 'status_id', 'kategori_id']))
                    <div class="mt-3">
                        <a href="{{ route('tiket.history') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="lni lni-close"></i> Reset Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    {{-- TABEL RIWAYAT TIKET --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <h5 class="report-card-title mb-0">Daftar Riwayat Tiket</h5>
            <span class="badge bg-primary">{{ $tikets->total() }} tiket</span>
        </div>
        <div class="card-body p-0">
            @if ($tikets->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3 fw-semibold text-uppercase small">Kode Tiket</th>
                                <th class="py-3 fw-semibold text-uppercase small">Judul</th>
                                <th class="py-3 fw-semibold text-uppercase small">Kategori</th>
                                <th class="py-3 fw-semibold text-uppercase small">Prioritas</th>
                                <th class="py-3 fw-semibold text-uppercase small">Status</th>
                                <th class="py-3 fw-semibold text-uppercase small">Tanggal Dibuat</th>
                                <th class="py-3 fw-semibold text-uppercase small">Ditangani Oleh</th>
                                <th class="py-3 fw-semibold text-uppercase small text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tikets as $tiket)
                                <tr>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-light text-primary fw-semibold">
                                            {{ $tiket->kode_tiket }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-info bg-opacity-75 report-badge">
                                            <i class="lni lni-tag"></i>
                                            {{ $tiket->kategori->nama_kategori ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        @if ($tiket->prioritas)
                                            @php
                                                $badgeClass = match ($tiket->prioritas->nama_prioritas) {
                                                    'Urgent' => 'bg-danger',
                                                    'High' => 'bg-warning',
                                                    'Normal' => 'bg-primary',
                                                    'Low' => 'bg-secondary',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">
                                                {{ $tiket->prioritas->nama_prioritas }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @if ($tiket->status)
                                            @php
                                                $statusBadge = match ($tiket->status->nama_status) {
                                                    'Selesai' => 'bg-success',
                                                    'Sedang Diproses' => 'bg-warning',
                                                    'Ditolak' => 'bg-danger',
                                                    'Baru' => 'bg-info',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $statusBadge }}">
                                                {{ $tiket->status->nama_status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <small class="text-muted report-date d-block">
                                            <i class="lni lni-calendar me-1"></i>
                                            {{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('d M Y') }}
                                        </small>
                                        <small class="text-muted report-date">
                                            {{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('H:i') }}
                                        </small>
                                    </td>
                                    <td class="py-3">
                                        @if ($tiket->assignedTo)
                                            <div class="d-flex align-items-center">
                                                <div class="me-2">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                        style="width: 32px; height: 32px; font-size: 14px;">
                                                        {{ strtoupper(substr($tiket->assignedTo->name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <small
                                                    class="fw-semibold">{{ Str::limit($tiket->assignedTo->name, 15) }}</small>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('tiket.show', $tiket->tiket_id) }}"
                                                class="btn btn-sm btn-info" data-bs-toggle="tooltip"
                                                title="Lihat Detail">
                                                <i class="lni lni-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-4 border-top">
                    {{ $tikets->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-5">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                            stroke-linecap="round" stroke-linejoin="round" class="text-muted opacity-50">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                    </div>
                    <h5 class="text-muted mb-2">Tidak ada riwayat tiket ditemukan</h5>
                    <p class="text-muted mb-4">Belum ada tiket yang sesuai dengan filter Anda</p>
                    @if (request()->hasAny(['search', 'start_date', 'end_date', 'status_id', 'kategori_id']))
                        <a href="{{ route('tiket.history') }}" class="btn btn-primary">
                            <i class="lni lni-reload"></i> Reset Filter
                        </a>
                    @endif
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