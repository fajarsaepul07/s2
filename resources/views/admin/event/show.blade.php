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

    .header-actions {
        display: flex;
        gap: 0.5rem;
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

    .btn-edit-modern {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-edit-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .detail-body {
        padding: 2.5rem;
    }

    .event-name-banner {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8eaff 100%);
        border: 2px solid #e0e7ff;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        text-align: center;
    }

    .event-name-label {
        font-size: 0.85rem;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }

    .event-name-value {
        font-size: 2rem;
        font-weight: 800;
        color: #667eea;
        line-height: 1.2;
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

    .location-value {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #4338ca;
        padding: 0.6rem 1rem;
        border-radius: 12px;
        font-weight: 700;
    }

    .area-value {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        padding: 0.6rem 1rem;
        border-radius: 12px;
        font-weight: 700;
    }

    .date-display {
        background: #f9fafb;
        padding: 0.8rem 1rem;
        border-radius: 10px;
        border-left: 4px solid #667eea;
    }

    .date-day {
        font-size: 1.5rem;
        font-weight: 800;
        color: #667eea;
        line-height: 1;
    }

    .date-month-year {
        font-size: 0.9rem;
        color: #6b7280;
        font-weight: 600;
        margin-top: 0.2rem;
    }

    .timeline-section {
        background: white;
        border: 2px solid #f3f4f6;
        border-radius: 16px;
        padding: 1.5rem;
        margin-top: 2rem;
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

    .timeline-item:last-child {
        margin-bottom: 0;
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

    .duration-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
        padding: 0.6rem 1rem;
        border-radius: 12px;
        font-weight: 700;
        margin-top: 1rem;
    }

    @media (max-width: 768px) {
        .detail-header-content {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .header-actions {
            width: 100%;
        }

        .header-actions a {
            flex: 1;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .event-name-value {
            font-size: 1.5rem;
        }
    }
</style>

<div class="col-lg-10 mt-3 grid-margin stretch-card">
    <div class="card detail-card">
        <div class="detail-header">
            <div class="detail-header-content">
                <h4>Detail Event</h4>
                <div class="header-actions">
                    <a href="{{ route('event.index') }}" class="btn btn-back-modern">
                        <i class="mdi mdi-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('event.edit', $event) }}" class="btn btn-edit-modern">
                        <i class="mdi mdi-pencil"></i> Ubah
                    </a>
                </div>
            </div>
        </div>

        <div class="detail-body">
            <!-- Event Name Banner -->
            <div class="event-name-banner">
                <div class="event-name-label">Nama Event</div>
                <div class="event-name-value">{{ $event->nama_event }}</div>
            </div>

            <!-- Info Grid -->
            <div class="info-grid">
                <!-- Location -->
                <div class="info-card">
                    <div class="info-label">
                        <i class="mdi mdi-map-marker info-icon"></i>
                        Lokasi
                    </div>
                    <div class="info-value">
                        <span class="location-value">
                            <i class="mdi mdi-map-marker"></i>
                            {{ $event->lokasi }}
                        </span>
                    </div>
                </div>

                <!-- Area -->
                <div class="info-card">
                    <div class="info-label">
                        <i class="mdi mdi-earth info-icon"></i>
                        Area
                    </div>
                    <div class="info-value">
                        <span class="area-value">
                            <i class="mdi mdi-earth"></i>
                            {{ $event->area }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Date Section -->
            <div class="info-grid">
                <!-- Start Date -->
                <div class="info-card">
                    <div class="info-label">
                        <i class="mdi mdi-calendar-start info-icon"></i>
                        Tanggal Mulai
                    </div>
                    <div class="info-value">
                        <div class="date-display">
                            <div class="date-day">
                                {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d') }}
                            </div>
                            <div class="date-month-year">
                                {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('F Y') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- End Date -->
                <div class="info-card">
                    <div class="info-label">
                        <i class="mdi mdi-calendar-end info-icon"></i>
                        Tanggal Selesai
                    </div>
                    <div class="info-value">
                        <div class="date-display">
                            <div class="date-day">
                                {{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d') }}
                            </div>
                            <div class="date-month-year">
                                {{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('F Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Duration Badge -->
            <div class="text-center">
                <span class="duration-badge">
                    <i class="mdi mdi-timer-sand"></i>
                    Durasi Event: {{ \Carbon\Carbon::parse($event->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($event->tanggal_selesai)) + 1 }} Hari
                </span>
            </div>

            <!-- Timeline -->
            <div class="timeline-section">
                <div class="timeline-header">
                    <i class="mdi mdi-timeline-clock"></i>
                    Riwayat
                </div>

                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="mdi mdi-clock-plus"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-label">Dibuat Pada</div>
                        <div class="timeline-value">
                            {{ \Carbon\Carbon::parse($event->created_at)->format('d F Y, H:i') }} WIB
                        </div>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="mdi mdi-clock-edit"></i>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-label">Terakhir Diupdate</div>
                        <div class="timeline-value">
                            {{ \Carbon\Carbon::parse($event->updated_at)->format('d F Y, H:i') }} WIB
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection