@extends('layouts.admin.master')
@section('pageTitle', 'Detail Laporan')

@section('content')

<style>
    .detail-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .detail-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .detail-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .header-content {
        position: relative;
        z-index: 1;
    }

    .header-content h4 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .header-content p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .detail-body {
        padding: 2rem;
    }

    .info-section {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8eaff 100%);
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .info-row {
        display: flex;
        align-items: flex-start;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(102, 126, 234, 0.1);
    }

    .info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-row:first-child {
        padding-top: 0;
    }

    .info-label {
        flex: 0 0 180px;
        font-weight: 700;
        color: #4338ca;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-value {
        flex: 1;
        color: #1f2937;
        font-size: 0.95rem;
    }

    .kode-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px;
        font-weight: 700;
        font-family: 'Courier New', monospace;
        font-size: 1rem;
    }

    .pembuat-info {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #3730a3;
        border-radius: 10px;
        font-weight: 600;
    }

    .kategori-info {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        color: #166534;
        border-radius: 10px;
        font-weight: 600;
    }

    .prioritas-info {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
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

    .status-info {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
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

    .deskripsi-section {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .deskripsi-section h5 {
        color: #4338ca;
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .deskripsi-content {
        color: #4b5563;
        line-height: 1.8;
        font-size: 0.95rem;
        white-space: pre-wrap;
    }

    .lampiran-section {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .lampiran-section h5 {
        color: #4338ca;
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .lampiran-preview {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .lampiran-preview:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .lampiran-preview img {
        width: 100%;
        max-width: 500px;
        height: auto;
        display: block;
    }

    .no-lampiran {
        text-align: center;
        padding: 3rem;
        color: #9ca3af;
    }

    .no-lampiran i {
        font-size: 4rem;
        opacity: 0.5;
        margin-bottom: 1rem;
    }

    .action-buttons {
        display: flex;
        gap: 0.8rem;
        flex-wrap: wrap;
    }

    .btn-back {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        border: none;
        color: white;
        padding: 0.7rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(107, 114, 128, 0.4);
        color: white;
    }

    .btn-edit-custom {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        color: white;
        padding: 0.7rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-edit-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
        color: white;
    }

    @media (max-width: 768px) {
        .detail-body {
            padding: 1rem;
        }

        .info-row {
            flex-direction: column;
            gap: 0.5rem;
        }

        .info-label {
            flex: 1;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-back, .btn-edit-custom {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mt-3">
            <div class="card detail-card">
                <div class="detail-header">
                    <div class="header-content">
                        <h4>📋 Detail Laporan</h4>
                        <p>Informasi lengkap tentang laporan ini</p>
                    </div>
                </div>

                <div class="detail-body">
                    {{-- INFO UTAMA --}}
                    <div class="info-section">
                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-tag"></i>
                                ID Laporan
                            </div>
                            <div class="info-value">
                                <span class="kode-badge">
                                    <i class="mdi mdi-pound"></i>
                                    LAP-{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-format-title"></i>
                                Judul Laporan
                            </div>
                            <div class="info-value">
                                <strong style="font-size: 1.1rem;">{{ $report->judul }}</strong>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-account"></i>
                                Pelapor
                            </div>
                            <div class="info-value">
                                <span class="pembuat-info">
                                    <i class="mdi mdi-account-circle"></i>
                                    {{ $report->user->name ?? 'Tidak Diketahui' }}
                                </span>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-folder"></i>
                                Kategori
                            </div>
                            <div class="info-value">
                                <span class="kategori-info">
                                    <i class="mdi mdi-folder-outline"></i>
                                    {{ $report->kategori->nama_kategori ?? '-' }}
                                </span>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-alert-circle"></i>
                                Prioritas
                            </div>
                            <div class="info-value">
                                @php
                                    $prioritasNama = $report->prioritas->nama_prioritas ?? 'Sedang';
                                    $prioritasClass = match(strtolower($prioritasNama)) {
                                        'tinggi' => 'prioritas-tinggi',
                                        'sedang' => 'prioritas-sedang',
                                        'rendah' => 'prioritas-rendah',
                                        default => 'prioritas-sedang'
                                    };
                                @endphp
                                <span class="prioritas-info {{ $prioritasClass }}">
                                    <i class="mdi mdi-alert-circle-outline"></i>
                                    {{ $prioritasNama }}
                                </span>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-information"></i>
                                Status
                            </div>
                            <div class="info-value">
                                @php
                                    $statusClass = match($report->status) {
                                        'pending' => 'status-pending',
                                        'diproses' => 'status-diproses',
                                        'selesai' => 'status-selesai',
                                        'ditolak' => 'status-ditolak',
                                        default => 'status-pending'
                                    };
                                    $statusIcon = match($report->status) {
                                        'pending' => 'mdi-clock-outline',
                                        'diproses' => 'mdi-progress-clock',
                                        'selesai' => 'mdi-check-circle',
                                        'ditolak' => 'mdi-close-circle',
                                        default => 'mdi-help-circle'
                                    };
                                @endphp
                                <span class="status-info {{ $statusClass }}">
                                    <i class="mdi {{ $statusIcon }}"></i>
                                    {{ ucfirst($report->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-calendar"></i>
                                Tanggal Dibuat
                            </div>
                            <div class="info-value">
                                {{ $report->created_at->format('d F Y, H:i') }} WIB
                            </div>
                        </div>

                        @if($report->updated_at != $report->created_at)
                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-calendar-check"></i>
                                Terakhir Diupdate
                            </div>
                            <div class="info-value">
                                {{ $report->updated_at->format('d F Y, H:i') }} WIB
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="deskripsi-section">
                        <h5>
                            <i class="mdi mdi-text-box-outline"></i>
                            Deskripsi Laporan
                        </h5>
                        <div class="deskripsi-content">{{ $report->deskripsi }}</div>
                    </div>

                    {{-- LAMPIRAN --}}
                    <div class="lampiran-section">
                        <h5>
                            <i class="mdi mdi-paperclip"></i>
                            Lampiran
                        </h5>
                        @if($report->lampiran)
                            <div class="lampiran-preview" onclick="previewImage('{{ Storage::url($report->lampiran) }}')">
                                <img src="{{ Storage::url($report->lampiran) }}" alt="Lampiran">
                            </div>
                        @else
                            <div class="no-lampiran">
                                <i class="mdi mdi-image-off"></i>
                                <p>Tidak ada lampiran</p>
                            </div>
                        @endif
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="action-buttons">
                        <a href="{{ route('tim_teknisi.report.edit', $report->id) }}" class="btn-edit-custom">
                            <i class="mdi mdi-pencil"></i>
                            Edit Laporan
                        </a>
                        <a href="{{ route('tim_teknisi.report.index') }}" class="btn-back">
                            <i class="mdi mdi-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- PREVIEW GAMBAR --}}
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
</script>

@endsection