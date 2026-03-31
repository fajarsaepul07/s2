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
        padding: 2.5rem 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .detail-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .detail-header h4 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }

    .detail-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
        position: relative;
        z-index: 1;
    }

    .detail-body {
        padding: 2.5rem;
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        border: 2px solid #f59e0b;
    }

    .status-diproses {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
        border: 2px solid #3b82f6;
    }

    .status-selesai {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        border: 2px solid #10b981;
    }

    .status-ditolak {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
        border: 2px solid #ef4444;
    }

    /* Priority Badge */
    .priority-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .priority-low {
        background: #e0f2fe;
        color: #0369a1;
        border: 2px solid #0ea5e9;
    }

    .priority-medium {
        background: #fef3c7;
        color: #92400e;
        border: 2px solid #f59e0b;
    }

    .priority-high {
        background: #fee2e2;
        color: #991b1b;
        border: 2px solid #ef4444;
    }

    /* Info Sections */
    .info-section {
        background: #f8f9ff;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 2px solid #e0e7ff;
    }

    .section-title-detail {
        color: #667eea;
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .info-label {
        font-size: 0.8rem;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-value {
        font-size: 1rem;
        color: #1f2937;
        font-weight: 600;
    }

    .info-value-large {
        font-size: 1.1rem;
        color: #111827;
        font-weight: 700;
        line-height: 1.5;
    }

    /* Description Box */
    .description-box {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        color: #374151;
        line-height: 1.8;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    /* Attachment Box */
    .attachment-box {
        background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
        border: 2px solid #0ea5e9;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .attachment-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .attachment-icon {
        font-size: 3rem;
        color: #0284c7;
    }

    .attachment-details h6 {
        margin: 0;
        color: #0c4a6e;
        font-weight: 700;
        font-size: 1rem;
    }

    .attachment-details p {
        margin: 0.3rem 0 0 0;
        color: #075985;
        font-size: 0.85rem;
    }

    .btn-download {
        background: white;
        border: 2px solid #0284c7;
        color: #0284c7;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-download:hover {
        background: #0284c7;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);
    }

    .no-attachment {
        background: #f9fafb;
        border: 2px dashed #e5e7eb;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        color: #9ca3af;
    }

    .no-attachment i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        padding-top: 1.5rem;
        border-top: 2px solid #f3f4f6;
        margin-top: 1.5rem;
    }

    .btn-edit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 0.8rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: none;
        color: white;
        padding: 0.8rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.5);
        color: white;
    }

    .btn-back {
        background: white;
        border: 2px solid #e5e7eb;
        color: #6b7280;
        padding: 0.8rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-back:hover {
        border-color: #667eea;
        color: #667eea;
        background: #f8f9ff;
        transform: translateY(-2px);
    }

    /* Timeline Item */
    .timeline-item {
        display: flex;
        gap: 1rem;
        align-items: center;
        padding: 0.5rem 0;
    }

    .timeline-icon {
        font-size: 1.2rem;
        color: #667eea;
    }

    .timeline-text {
        color: #4b5563;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .detail-body {
            padding: 1.5rem;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .action-buttons a,
        .action-buttons button {
            width: 100%;
            justify-content: center;
        }

        .attachment-box {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mt-3">
            <div class="card detail-card">
                <div class="detail-header">
                    <h4>📋 Detail Laporan</h4>
                    <p>Informasi lengkap tentang laporan ini</p>
                </div>

                <div class="detail-body">
                    
                    <!-- Status & Priority -->
                    <div class="info-section">
                        <div class="section-title-detail">
                            <i class="mdi mdi-information-outline"></i>
                            Status & Prioritas
                        </div>
                        <div class="d-flex gap-3 flex-wrap">
                            <div>
                                <div class="info-label">
                                    <i class="mdi mdi-flag"></i>
                                    Status
                                </div>
                                <div class="mt-2">
                                    @if($report->status == 'pending')
                                        <span class="status-badge status-pending">
                                            <i class="mdi mdi-clock-outline"></i> Pending
                                        </span>
                                    @elseif($report->status == 'diproses')
                                        <span class="status-badge status-diproses">
                                            <i class="mdi mdi-progress-clock"></i> Diproses
                                        </span>
                                    @elseif($report->status == 'selesai')
                                        <span class="status-badge status-selesai">
                                            <i class="mdi mdi-check-circle"></i> Selesai
                                        </span>
                                    @else
                                        <span class="status-badge status-ditolak">
                                            <i class="mdi mdi-close-circle"></i> Ditolak
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <div class="info-label">
                                    <i class="mdi mdi-alert-circle"></i>
                                    Prioritas
                                </div>
                                <div class="mt-2">
                                    @php
                                        $priorityClass = 'priority-medium';
                                        $priorityIcon = 'mdi-alert';
                                        if($report->prioritas) {
                                            $priorityName = strtolower($report->prioritas->nama_prioritas ?? '');
                                            if(str_contains($priorityName, 'rendah') || str_contains($priorityName, 'low')) {
                                                $priorityClass = 'priority-low';
                                                $priorityIcon = 'mdi-arrow-down';
                                            } elseif(str_contains($priorityName, 'tinggi') || str_contains($priorityName, 'high')) {
                                                $priorityClass = 'priority-high';
                                                $priorityIcon = 'mdi-arrow-up';
                                            }
                                        }
                                    @endphp
                                    <span class="priority-badge {{ $priorityClass }}">
                                        <i class="mdi {{ $priorityIcon }}"></i>
                                        {{ $report->prioritas->nama_prioritas ?? 'Tidak Ada' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Laporan -->
                    <div class="info-section">
                        <div class="section-title-detail">
                            <i class="mdi mdi-file-document"></i>
                            Informasi Laporan
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="mdi mdi-pound"></i>
                                    ID Laporan
                                </div>
                                <div class="info-value">#{{ $report->id }}</div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">
                                    <i class="mdi mdi-folder"></i>
                                    Kategori
                                </div>
                                <div class="info-value">{{ $report->kategori->nama_kategori ?? 'Tidak Ada' }}</div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">
                                    <i class="mdi mdi-calendar"></i>
                                    Tanggal Dibuat
                                </div>
                                <div class="info-value">{{ $report->created_at->format('d M Y, H:i') }}</div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">
                                    <i class="mdi mdi-update"></i>
                                    Terakhir Diperbarui
                                </div>
                                <div class="info-value">{{ $report->updated_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Pelapor & Penugasan -->
                    <div class="info-section">
                        <div class="section-title-detail">
                            <i class="mdi mdi-account-group"></i>
                            Pelapor & Penugasan
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="mdi mdi-account-arrow-right"></i>
                                    Ditugaskan Kepada
                                </div>
                                <div class="info-value">
                                    @if($report->assigned_to && $report->assignedUser)
                                        {{ $report->assignedUser->name }}
                                        <br><small class="text-muted">{{ ucfirst(str_replace('_', ' ', $report->assignedUser->role)) }}</small>
                                    @else
                                        <span class="text-muted">Belum Ditugaskan</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Judul Laporan -->
                    <div class="info-section">
                        <div class="section-title-detail">
                            <i class="mdi mdi-text-box"></i>
                            Judul Laporan
                        </div>
                        <div class="info-value-large">
                            {{ $report->judul }}
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="info-section">
                        <div class="section-title-detail">
                            <i class="mdi mdi-text-subject"></i>
                            Deskripsi Lengkap
                        </div>
                        <div class="description-box">
                            {{ $report->deskripsi }}
                        </div>
                    </div>

                    <!-- Lampiran -->
                    <div class="info-section">
                        <div class="section-title-detail">
                            <i class="mdi mdi-paperclip"></i>
                            Lampiran
                        </div>
                        
                        @if($report->lampiran)
                            <div class="attachment-box">
                                <div class="attachment-info">
                                    @php
                                        $extension = pathinfo($report->lampiran, PATHINFO_EXTENSION);
                                        $isPdf = strtolower($extension) === 'pdf';
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png']);
                                    @endphp
                                    <i class="mdi {{ $isPdf ? 'mdi-file-pdf-box' : 'mdi-file-image' }} attachment-icon"></i>
                                    <div class="attachment-details">
                                        <h6>📎 {{ basename($report->lampiran) }}</h6>
                                        <p>Tipe: {{ strtoupper($extension) }} • Tersedia untuk diunduh</p>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ asset('storage/' . $report->lampiran) }}" 
                                       target="_blank" 
                                       class="btn-download">
                                        <i class="mdi mdi-eye"></i> Lihat
                                    </a>
                                    <a href="{{ asset('storage/' . $report->lampiran) }}" 
                                       download 
                                       class="btn-download">
                                        <i class="mdi mdi-download"></i> Unduh
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="no-attachment">
                                <i class="mdi mdi-file-remove"></i>
                                <p class="mb-0">Tidak ada lampiran</p>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="{{ route('admin.report.edit', $report->id) }}" class="btn-edit">
                            <i class="mdi mdi-pencil"></i> Edit Laporan
                        </a>

                        <form action="{{ route('admin.report.destroy', $report->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus laporan ini?')"
                              style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">
                                <i class="mdi mdi-delete"></i> Hapus Laporan
                            </button>
                        </form>

                        <a href="{{ route('admin.report.index') }}" class="btn-back">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection