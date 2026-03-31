@extends('layouts.admin.master')
@section('pageTitle', 'Detail Tiket')

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
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .header-content p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .btn-back {
        background: white;
        color: #667eea;
        border: none;
        padding: 0.7rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255,255,255,0.3);
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255,255,255,0.4);
        color: #764ba2;
    }

    .detail-body {
        padding: 2rem;
    }

    .info-section {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid #667eea;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-row {
        display: flex;
        padding: 1rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #6b7280;
        width: 200px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-value {
        color: #1f2937;
        flex: 1;
    }

    .kode-tiket-large {
        font-family: 'Courier New', monospace;
        font-size: 1.2rem;
        font-weight: 700;
        color: #667eea;
        background: linear-gradient(135deg, #f8f9ff 0%, #e8eaff 100%);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        display: inline-block;
    }

    .badge-large {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .status-baru {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
    }

    .status-diproses {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    .status-selesai {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .status-ditutup {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        color: #374151;
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

    .kategori-badge-large {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        color: #166534;
    }

    .deskripsi-box {
        background: #f9fafb;
        border-left: 4px solid #667eea;
        padding: 1.5rem;
        border-radius: 10px;
        line-height: 1.8;
        color: #4b5563;
    }

    .lampiran-section {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .lampiran-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .lampiran-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .lampiran-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .riwayat-section {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
    }

    .timeline-item {
        position: relative;
        padding-bottom: 2rem;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -2.45rem;
        top: 0;
        width: 15px;
        height: 15px;
        background: white;
        border: 3px solid #667eea;
        border-radius: 50%;
    }

    .timeline-content {
        background: #f9fafb;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        border-left: 3px solid #667eea;
    }

    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .timeline-user {
        font-weight: 600;
        color: #1f2937;
    }

    .timeline-date {
        font-size: 0.85rem;
        color: #6b7280;
    }

    .timeline-message {
        color: #4b5563;
        line-height: 1.6;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-edit {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        color: white;
        padding: 0.7rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
        color: white;
    }

    @media (max-width: 768px) {
        .detail-header {
            padding: 1.5rem;
        }

        .detail-body {
            padding: 1rem;
        }

        .info-row {
            flex-direction: column;
        }

        .info-label {
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-back, .btn-edit {
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
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="header-content">
                            <h4>
                                <i class="mdi mdi-ticket-confirmation"></i>
                                Detail Tiket
                            </h4>
                            <p>Informasi lengkap tiket yang ditugaskan kepada Anda</p>
                        </div>
                        <a href="{{ route('tim.tiket.index') }}" class="btn-back">
                            <i class="mdi mdi-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="detail-body">
                    {{-- Informasi Utama --}}
                    <div class="info-section">
                        <h5 class="section-title">
                            <i class="mdi mdi-information"></i>
                            Informasi Tiket
                        </h5>

                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-barcode"></i>
                                Kode Tiket
                            </div>
                            <div class="info-value">
                                <span class="kode-tiket-large">{{ $tiket->kode_tiket }}</span>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-format-title"></i>
                                Judul
                            </div>
                            <div class="info-value">
                                <strong style="font-size: 1.1rem;">{{ $tiket->judul }}</strong>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-account"></i>
                                Pembuat Tiket
                            </div>
                            <div class="info-value">
                                <strong>{{ $tiket->user->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $tiket->user->email }}</small>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-folder"></i>
                                Kategori
                            </div>
                            <div class="info-value">
                                <span class="badge-large kategori-badge-large">
                                    <i class="mdi mdi-folder"></i>
                                    {{ $tiket->kategori->nama_kategori }}
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
                                    $prioritasNama = $tiket->prioritas->nama_prioritas;
                                    $prioritasClass = match(strtolower($prioritasNama)) {
                                        'tinggi' => 'prioritas-tinggi',
                                        'sedang' => 'prioritas-sedang',
                                        'rendah' => 'prioritas-rendah',
                                        default => 'prioritas-sedang'
                                    };
                                @endphp
                                <span class="badge-large {{ $prioritasClass }}">
                                    <i class="mdi mdi-alert-circle"></i>
                                    {{ $prioritasNama }}
                                </span>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-information-outline"></i>
                                Status
                            </div>
                            <div class="info-value">
                                @php
                                    $statusNama = $tiket->status->nama_status;
                                    $statusClass = match(strtolower($statusNama)) {
                                        'baru' => 'status-baru',
                                        'sedang diproses' => 'status-diproses',
                                        'selesai' => 'status-selesai',
                                        'ditutup' => 'status-ditutup',
                                        default => 'status-baru'
                                    };
                                @endphp
                                <span class="badge-large {{ $statusClass }}">
                                    <i class="mdi mdi-{{ strtolower($statusNama) == 'selesai' ? 'check-circle' : 'clock-outline' }}"></i>
                                    {{ $statusNama }}
                                </span>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-calendar"></i>
                                Waktu Dibuat
                            </div>
                            <div class="info-value">
                                {{ $tiket->waktu_dibuat->format('d F Y, H:i') }} WIB
                                <br>
                                <small class="text-muted">{{ $tiket->waktu_dibuat->diffForHumans() }}</small>
                            </div>
                        </div>

                        @if($tiket->waktu_selesai)
                        <div class="info-row">
                            <div class="info-label">
                                <i class="mdi mdi-check-circle"></i>
                                Waktu Selesai
                            </div>
                            <div class="info-value">
                                {{ $tiket->waktu_selesai->format('d F Y, H:i') }} WIB
                                <br>
                                <small class="text-muted">{{ $tiket->waktu_selesai->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- Deskripsi --}}
                    <div class="info-section">
                        <h5 class="section-title">
                            <i class="mdi mdi-text-box"></i>
                            Deskripsi Masalah
                        </h5>
                        <div class="deskripsi-box">
                            {{ $tiket->deskripsi ?? 'Tidak ada deskripsi' }}
                        </div>
                    </div>

                    {{-- Lampiran jika ada --}}
                    @if($tiket->lampiran)
                    <div class="info-section">
                        <h5 class="section-title">
                            <i class="mdi mdi-attachment"></i>
                            Lampiran
                        </h5>
                        <div class="lampiran-section">
                            @foreach(json_decode($tiket->lampiran) ?? [] as $file)
                            <div class="lampiran-item" onclick="previewImage('{{ Storage::url($file) }}')">
                                <img src="{{ Storage::url($file) }}" alt="Lampiran">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Riwayat / Timeline --}}
                    @if(isset($riwayat) && $riwayat->count() > 0)
                    <div class="riwayat-section">
                        <h5 class="section-title">
                            <i class="mdi mdi-history"></i>
                            Riwayat Aktivitas
                        </h5>
                        <div class="timeline">
                            @foreach($riwayat as $item)
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="timeline-header">
                                        <span class="timeline-user">
                                            <i class="mdi mdi-account-circle"></i>
                                            {{ $item->user->name }}
                                        </span>
                                        <span class="timeline-date">
                                            <i class="mdi mdi-clock-outline"></i>
                                            {{ $item->created_at->format('d M Y, H:i') }}
                                        </span>
                                    </div>
                                    <div class="timeline-message">
                                        {{ $item->keterangan }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="action-buttons mt-4">
                        <a href="{{ route('tim.tiket.edit', $tiket->tiket_id) }}" class="btn-edit">
                            <i class="mdi mdi-pencil"></i>
                            Edit Tiket
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Preview Image Script --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function previewImage(url) {
        Swal.fire({
            title: 'Preview Lampiran',
            imageUrl: url,
            imageAlt: 'Lampiran',
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