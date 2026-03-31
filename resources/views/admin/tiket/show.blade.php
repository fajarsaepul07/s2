@extends('layouts.admin.master')
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

    .detail-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .detail-header h4 {
        color: white;
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
    }

    .btn-back-modern {
        background: white;
        color: #667eea;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-back-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.2);
        color: #667eea;
    }

    .detail-body {
        padding: 2.5rem;
    }

    .ticket-code-banner {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8eaff 100%);
        border: 2px solid #e0e7ff;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        text-align: center;
    }

    .ticket-code-label {
        font-size: 0.85rem;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }

    .ticket-code-value {
        font-size: 2rem;
        font-weight: 800;
        color: #667eea;
        font-family: 'Courier New', monospace;
        letter-spacing: 2px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-card {
        background: white;
        border: 2px solid #f3f4f6;
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        border-color: #667eea;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.15);
    }

    .info-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.8rem;
    }

    .info-icon {
        color: #667eea;
        font-size: 1.2rem;
    }

    .info-value {
        font-size: 1.1rem;
        color: #1f2937;
        font-weight: 600;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.2rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .badge-pending {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    .badge-process {
        background: linear-gradient(135deg, #dbeafe 0%, #93c5fd 100%);
        color: #1e3a8a;
    }

    .badge-done {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .badge-priority-high {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }

    .badge-priority-medium {
        background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
        color: #9a3412;
    }

    .badge-priority-low {
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #3730a3;
    }

    .assigned-box {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border: 2px solid #86efac;
        border-radius: 12px;
        padding: 1rem 1.2rem;
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
    }

    .assigned-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .assigned-info {
        display: flex;
        flex-direction: column;
    }

    .assigned-name {
        font-weight: 700;
        color: #065f46;
        font-size: 1rem;
    }

    .assigned-role {
        font-size: 0.8rem;
        color: #047857;
    }

    .unassigned-text {
        color: #9ca3af;
        font-style: italic;
        padding: 0.5rem 1rem;
        background: #f9fafb;
        border-radius: 8px;
        display: inline-block;
    }

    .description-section {
        background: #f8f9ff;
        border: 2px solid #e0e7ff;
        border-radius: 16px;
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .description-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 700;
        color: #4338ca;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .description-text {
        color: #374151;
        line-height: 1.8;
        font-size: 0.95rem;
        white-space: pre-wrap;
    }

    .attachment-section {
        background: white;
        border: 2px solid #f3f4f6;
        border-radius: 16px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }

    .attachment-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 700;
        color: #4338ca;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .attachment-preview {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        max-width: 400px;
    }

    .attachment-preview:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .attachment-preview img {
        width: 100%;
        height: auto;
        display: block;
    }

    .timeline-section {
        background: white;
        border: 2px solid #f3f4f6;
        border-radius: 16px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }

    .timeline-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 700;
        color: #4338ca;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .timeline-item {
        display: flex;
        align-items: start;
        gap: 1rem;
        margin-bottom: 1rem;
        padding: 1rem;
        background: #f9fafb;
        border-radius: 12px;
    }

    .timeline-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .timeline-content {
        flex: 1;
    }

    .timeline-label {
        font-size: 0.8rem;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
    }

    .timeline-value {
        font-size: 1rem;
        color: #1f2937;
        font-weight: 600;
        margin-top: 0.2rem;
    }

    @media (max-width: 768px) {
        .detail-header-content {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .ticket-code-value {
            font-size: 1.5rem;
        }
    }
</style>

<div class="col-lg-10 mt-3 grid-margin stretch-card">
    <div class="card detail-card">
        <div class="detail-header">
            <div class="detail-header-content">
                <h4>Detail Tiket</h4>
                <a href="{{ route('admin.tiket.index') }}" class="btn btn-back-modern">
                    <i class="mdi mdi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="detail-body">
            <!-- Ticket Code Banner -->
            <div class="ticket-code-banner">
                <div class="ticket-code-label">Kode Tiket</div>
                <div class="ticket-code-value">{{ $tiket->kode_tiket }}</div>
            </div>

            <!-- Info Grid -->
            <div class="info-grid">
                <!-- User -->
                <div class="info-card">
                    <div class="info-label">
                        <i class="mdi mdi-account info-icon"></i>
                        Pembuat Tiket
                    </div>
                    <div class="info-value">{{ $tiket->user->name ?? '-' }}</div>
                </div>


                <!-- Category -->
                <div class="info-card">
                    <div class="info-label">
                        <i class="mdi mdi-tag info-icon"></i>
                        Kategori
                    </div>
                    <div class="info-value">{{ $tiket->kategori->nama_kategori ?? '-' }}</div>
                </div>

                <!-- Priority -->
                <div class="info-card">
                    <div class="info-label">
                        <i class="mdi mdi-alert-circle info-icon"></i>
                        Prioritas
                    </div>
                    <div class="info-value">
                        <span class="badge-status 
                            @if(strpos(strtolower($tiket->prioritas->nama_prioritas ?? ''), 'tinggi') !== false) 
                                badge-priority-high
                            @elseif(strpos(strtolower($tiket->prioritas->nama_prioritas ?? ''), 'sedang') !== false) 
                                badge-priority-medium
                            @else 
                                badge-priority-low
                            @endif">
                            <i class="mdi mdi-alert"></i>
                            {{ $tiket->prioritas->nama_prioritas ?? '-' }}
                        </span>
                    </div>
                </div>

                <!-- Status -->
                <div class="info-card">
                    <div class="info-label">
                        <i class="mdi mdi-progress-check info-icon"></i>
                        Status
                    </div>
                    <div class="info-value">
                        <span class="badge-status 
                            @switch($tiket->status->nama_status ?? '')
                                @case('Pending') badge-pending @break
                                @case('Diproses') badge-process @break
                                @case('Selesai') badge-done @break
                                @default badge-pending
                            @endswitch">
                            <i class="mdi 
                                @switch($tiket->status->nama_status ?? '')
                                    @case('Pending') mdi-clock-outline @break
                                    @case('Diproses') mdi-cog @break
                                    @case('Selesai') mdi-check-circle @break
                                @endswitch"></i>
                            {{ $tiket->status->nama_status ?? '-' }}
                        </span>
                    </div>
                </div>

                <!-- Assigned To -->
                <div class="info-card">
                    <div class="info-label">
                        <i class="mdi mdi-account-tie info-icon"></i>
                        Ditugaskan Kepada
                    </div>
                    <div class="info-value">
                        @if($tiket->assignedTo)
                            <div class="assigned-box">
                                <div class="assigned-avatar">
                                    {{ strtoupper(substr($tiket->assignedTo->name, 0, 1)) }}
                                </div>
                                <div class="assigned-info">
                                    <span class="assigned-name">{{ $tiket->assignedTo->name }}</span>
                                    <span class="assigned-role">{{ ucfirst($tiket->assignedTo->role) }}</span>
                                </div>
                            </div>
                        @else
                            <span class="unassigned-text">Belum ditugaskan</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="description-section">
                <div class="description-header">
                    <i class="mdi mdi-text-box"></i>
                    Deskripsi
                </div>
                <div class="description-text">{{ $tiket->deskripsi ?? 'Tidak ada deskripsi' }}</div>
            </div>

            <!-- Attachment -->
            @if(!empty($tiket->lampiran))
            <div class="attachment-section">
                <div class="attachment-header">
                    <i class="mdi mdi-paperclip"></i>
                    Lampiran
                </div>
                <a href="{{ Storage::url($tiket->lampiran) }}" target="_blank" class="attachment-preview">
                    <img src="{{ Storage::url($tiket->lampiran) }}" alt="Lampiran Tiket">
                </a>
            </div>
            @endif

            <!-- Timeline -->
            <div class="timeline-section">
                <div class="timeline-header">
                    <i class="mdi mdi-timeline-clock"></i>
                    Timeline
                </div>

                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="mdi mdi-clock-start"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-label">Waktu Dibuat</div>
                        <div class="timeline-value">
                            {{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('d F Y, H:i') }} WIB
                        </div>
                    </div>
                </div>

                @if($tiket->waktu_selesai)
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="mdi mdi-clock-check"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-label">Waktu Selesai</div>
                        <div class="timeline-value">
                            {{ \Carbon\Carbon::parse($tiket->waktu_selesai)->format('d F Y, H:i') }} WIB
                        </div>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="mdi mdi-timer"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-label">Durasi Penyelesaian</div>
                        <div class="timeline-value">
                            {{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->diffForHumans(\Carbon\Carbon::parse($tiket->waktu_selesai), true) }}
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

@endsection