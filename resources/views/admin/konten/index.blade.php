@extends('layouts.admin.master')
@section('pageTitle', 'Laporan Ditugaskan kepada Tim Konten')

@section('content')

<style>
    .index-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .index-header {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: center;
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

    /* Filter Section */
    .filter-section {
        background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%);
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .filter-section .form-label {
        font-weight: 600;
        color: #6d28d9;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }

    .filter-section .form-select {
        border-radius: 10px;
        border: 2px solid #ddd6fe;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .filter-section .form-select:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 0.2rem rgba(139, 92, 246, 0.25);
    }

    .btn-filter {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        border: none;
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4);
        color: white;
    }

    .btn-reset {
        background: white;
        border: 2px solid #e5e7eb;
        color: #6b7280;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-reset:hover {
        border-color: #9ca3af;
        color: #374151;
        transform: translateY(-2px);
    }

    .table-container {
        background: white;
        border-radius: 16px;
        overflow-x: auto;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .modern-table {
        margin: 0;
        width: 100%;
        min-width: 1400px;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%);
    }

    .modern-table thead th {
        border: none;
        color: #6d28d9;
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
        transform: scale(1.001);
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

    .number-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
        border-radius: 50%;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .foto-thumbnail {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .foto-thumbnail:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .no-foto {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
    }

    .judul-text {
        font-weight: 600;
        color: #1f2937;
        font-size: 0.95rem;
    }

    .kategori-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.8rem;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        color: #166534;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .prioritas-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .prioritas-tinggi {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }

    .prioritas-sedang {
        background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
        color: #9a3412;
    }

    .prioritas-rendah {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
    }

    .deskripsi-preview {
        font-size: 0.85rem;
        color: #6b7280;
        line-height: 1.5;
    }

    .read-more {
        color: #8b5cf6;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
    }

    .read-more:hover {
        color: #7c3aed;
        text-decoration: underline;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .status-pending {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    .status-diproses {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
    }

    .status-selesai {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .status-ditolak {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }

    .date-text {
        font-size: 0.85rem;
        color: #6b7280;
        white-space: nowrap;
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

    .btn-edit {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        border: none;
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
        color: white;
    }

    .action-buttons-group {
        display: flex;
        gap: 0.4rem;
        flex-wrap: wrap;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #9ca3af;
    }

    .empty-state img {
        max-width: 200px;
        margin-bottom: 1.5rem;
        opacity: 0.7;
    }

    .empty-state h5 {
        color: #6b7280;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 1.2rem;
    }

    .empty-state p {
        color: #9ca3af;
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
    }

    .pagination {
        margin-top: 1.5rem;
    }

    @media (max-width: 768px) {
        .index-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .index-body {
            padding: 1rem;
        }

        .filter-section {
            padding: 1rem;
        }
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mt-3">
            <div class="card index-card">
                <div class="index-header">
                    <div class="header-title">
                        <h4>🎨 Laporan Ditugaskan kepada Tim Konten</h4>
                        <p>Kelola konten dan publikasi laporan yang menjadi tanggung jawab Anda</p>
                    </div>
                </div>

                <div class="index-body">
                    {{-- SWEETALERT OTOMATIS --}}
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

                    @if(session('error'))
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops! ❌',
                                    text: '{{ session('error') }}',
                                    timer: 2500,
                                    showConfirmButton: false
                                });
                            });
                        </script>
                    @endif

                    {{-- Filter Form --}}
                    <div class="filter-section">
                        <form method="GET" action="{{ route('tim_konten.report.index') }}">
                            <div class="row align-items-end">
                                <div class="col-md-3">
                                    <label class="form-label">
                                        <i class="mdi mdi-information-outline"></i> Status
                                    </label>
                                    <select name="status" class="form-select">
                                        <option value="">-- Semua Status --</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">
                                        <i class="mdi mdi-folder-outline"></i> Kategori
                                    </label>
                                    <select name="kategori_id" class="form-select">
                                        <option value="">-- Semua Kategori --</option>
                                        @foreach($kategoris ?? [] as $kategori)
                                            <option value="{{ $kategori->kategori_id }}" {{ request('kategori_id') == $kategori->kategori_id ? 'selected' : '' }}>
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">
                                        <i class="mdi mdi-alert-circle-outline"></i> Prioritas
                                    </label>
                                    <select name="prioritas_id" class="form-select">
                                        <option value="">-- Semua Prioritas --</option>
                                        @foreach($prioritas ?? [] as $prio)
                                            <option value="{{ $prio->prioritas_id }}" {{ request('prioritas_id') == $prio->prioritas_id ? 'selected' : '' }}>
                                                {{ $prio->nama_prioritas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn-filter">
                                        <i class="mdi mdi-filter"></i> Filter
                                    </button>
                                    <a href="{{ route('tim_konten.report.index') }}" class="btn-reset">
                                        <i class="mdi mdi-refresh"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- CEK JIKA BELUM ADA LAPORAN --}}
                    @if($reports->count() == 0)
                        <div class="empty-state">
                            <img src="{{ asset('assets/images/empty.svg') }}" alt="Empty">
                            <h5>Belum Ada Laporan</h5>
                            <p>Saat ini belum ada laporan yang ditugaskan kepada tim konten</p>
                        </div>
                    @else
                        <div class="table-container">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th style="width: 100px;">Foto</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Prioritas</th>
                                        <th style="">Deskripsi</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reports as $r)
                                        <tr>
                                            <td>
                                                <span class="number-badge">{{ $loop->iteration }}</span>
                                            </td>

                                            {{-- FOTO / LAMPIRAN --}}
                                            <td>
                                                @if($r->lampiran)
                                                    <img src="{{ Storage::url($r->lampiran) }}" 
                                                         class="foto-thumbnail"
                                                         onclick="previewImage('{{ Storage::url($r->lampiran) }}')"
                                                         alt="Lampiran">
                                                @else
                                                    <div class="no-foto">
                                                        <i class="mdi mdi-image-off mdi-24px"></i>
                                                    </div>
                                                @endif
                                            </td>

                                            {{-- JUDUL --}}
                                            <td>
                                                <span class="judul-text">{{ Str::limit($r->judul, 40) }}</span>
                                            </td>

                                            {{-- KATEGORI --}}
                                            <td>
                                                <span class="kategori-badge">
                                                    <i class="mdi mdi-folder"></i>
                                                    {{ $r->kategori->nama_kategori ?? '-' }}
                                                </span>
                                            </td>

                                            {{-- PRIORITAS --}}
                                            <td>
                                                @php
                                                    $prioritasNama = $r->prioritas->nama_prioritas ?? 'Sedang';
                                                    $prioritasClass = match(strtolower($prioritasNama)) {
                                                        'tinggi' => 'prioritas-tinggi',
                                                        'sedang' => 'prioritas-sedang',
                                                        'rendah' => 'prioritas-rendah',
                                                        default => 'prioritas-sedang'
                                                    };
                                                @endphp
                                                <span class="prioritas-badge {{ $prioritasClass }}">
                                                    <i class="mdi mdi-alert-circle"></i>
                                                    {{ $prioritasNama }}
                                                </span>
                                            </td>

                                            {{-- DESKRIPSI RINGKAS --}}
                                            <td>
                                                <div class="deskripsi-preview">
                                                    {{ Str::limit($r->deskripsi, 80) }}
                                                    @if(strlen($r->deskripsi) > 80)
                                                        <a href="javascript:void(0)"
                                                           class="read-more"
                                                           onclick="showFullDescription('{{ $r->judul }}', `{{ nl2br(e($r->deskripsi)) }}`)">
                                                            ... baca selengkapnya
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>

                                            {{-- STATUS --}}
                                            <td>
                                                @php
                                                    $statusClass = match($r->status) {
                                                        'pending' => 'status-pending',
                                                        'diproses' => 'status-diproses',
                                                        'selesai' => 'status-selesai',
                                                        'ditolak' => 'status-ditolak',
                                                        default => 'status-pending'
                                                    };
                                                    $statusIcon = match($r->status) {
                                                        'pending' => 'mdi-clock-outline',
                                                        'diproses' => 'mdi-progress-clock',
                                                        'selesai' => 'mdi-check-circle',
                                                        'ditolak' => 'mdi-close-circle',
                                                        default => 'mdi-help-circle'
                                                    };
                                                @endphp
                                                <span class="status-badge {{ $statusClass }}">
                                                    <i class="mdi {{ $statusIcon }}"></i>
                                                    {{ ucfirst($r->status) }}
                                                </span>
                                            </td>

                                            {{-- TANGGAL --}}
                                            <td>
                                                <span class="date-text">
                                                    {{ $r->created_at->format('d M Y') }}
                                                    <br>
                                                    {{ $r->created_at->format('H:i') }}
                                                </span>
                                            </td>

                                            {{-- AKSI --}}
                                            <td>
                                                <div class="action-buttons-group">
                                                    <a href="{{ route('tim_konten.report.show', $r->id) }}"
                                                        class="btn-detail" title="Detail">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('tim_konten.report.edit', $r->id) }}"
                                                        class="btn-edit" title="Edit Konten">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination jika ada --}}
                        @if(method_exists($reports, 'links'))
                            <div class="d-flex justify-content-center">
                                {{ $reports->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- PREVIEW GAMBAR & DESKRIPSI --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function previewImage(url) {
        Swal.fire({
            title: 'Preview Lampiran',
            imageUrl: url,
            imageAlt: 'Lampiran Laporan',
            showCloseButton: true,
            showConfirmButton: false,
            width: 'auto',
            background: '#fff',
            padding: '1rem',
            customClass: {
                image: 'rounded'
            }
        });
    }

    function showFullDescription(title, description) {
        Swal.fire({
            title: title,
            html: description,
            icon: 'info',
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#8b5cf6',
            width: '600px'
        });
    }
</script>

@endsection