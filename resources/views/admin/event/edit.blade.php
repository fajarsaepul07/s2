@extends('layouts.admin.master')
@section('content')

<style>
    .edit-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .edit-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2.5rem 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .edit-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .edit-header h4 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }

    .edit-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
        position: relative;
        z-index: 1;
    }

    .edit-body {
        padding: 2.5rem;
    }

    .alert-modern {
        border: none;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .alert-danger-modern {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }

    .form-section-edit {
        background: #f8f9ff;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 2px dashed #e0e7ff;
    }

    .section-title {
        color: #667eea;
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label-edit {
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .label-icon {
        color: #667eea;
        font-size: 1.1rem;
    }

    .form-control-edit {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f9fafb;
        color: #000000;
    }

    .form-control-edit:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        background: white;
        outline: none;
    }

    .form-control-edit:hover {
        border-color: #cbd5e1;
        background: white;
    }

    .form-control-edit::placeholder {
        color: #000000;
        opacity: 1;
    }

    .form-hint {
        font-size: 0.8rem;
        color: #000000;
        margin-top: 0.3rem;
        display: block;
    }

    .required-mark {
        color: #ef4444;
        margin-left: 0.2rem;
    }

    .btn-update {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 0.8rem 2.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-cancel {
        background: white;
        border: 2px solid #e5e7eb;
        color: #6b7280;
        padding: 0.8rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        border-color: #667eea;
        color: #667eea;
        background: #f8f9ff;
        transform: translateY(-2px);
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        padding-top: 1.5rem;
        border-top: 2px solid #f3f4f6;
        margin-top: 1.5rem;
    }

    .date-info {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border: 2px solid #93c5fd;
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .date-info-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #3b82f6;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .date-info-text {
        color: #000000;
        font-size: 0.85rem;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .edit-body {
            padding: 1.5rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .action-buttons button,
        .action-buttons a {
            width: 100%;
        }
    }
</style>

<div class="col-lg-10 mt-3 grid-margin stretch-card">
    <div class="card edit-card">
        <div class="edit-header">
            <h4>Ubah Event</h4>
            <p>Perbarui informasi event yang sudah terdaftar</p>
        </div>

        <div class="edit-body">
            @if ($errors->any())
                <div class="alert-modern alert-danger-modern">
                    <i class="mdi mdi-alert-circle" style="font-size: 1.5rem;"></i>
                    <div>
                        <strong>Terdapat kesalahan:</strong>
                        <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('event.update', $event) }}" method="POST" class="forms-sample">
                @csrf
                @method('PUT')
                
                <!-- Informasi Event -->
                <div class="form-section-edit">
                    <div class="section-title">
                        <i class="mdi mdi-information"></i>
                        Informasi Event
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label-edit">
                            <i class="mdi mdi-calendar-star label-icon"></i>
                            Nama Event<span class="required-mark">*</span>
                        </label>
                        <input type="text" class="form-control form-control-edit" id="nama_event" name="nama_event" 
                               value="{{ old('nama_event', $event->nama_event) }}" 
                               placeholder="Contoh: Workshop Digital Marketing 2024" required>
                        <small class="form-hint">Berikan nama yang jelas dan deskriptif</small>
                    </div>
                </div>

                <!-- Lokasi & Area -->
                <div class="form-section-edit">
                    <div class="section-title">
                        <i class="mdi mdi-map-marker"></i>
                        Lokasi & Area
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label-edit">
                                    <i class="mdi mdi-office-building label-icon"></i>
                                    Lokasi<span class="required-mark">*</span>
                                </label>
                                <input type="text" class="form-control form-control-edit" id="lokasi" name="lokasi" 
                                       value="{{ old('lokasi', $event->lokasi) }}" 
                                       placeholder="Contoh: Hotel Grand Hyatt" required>
                                <small class="form-hint">Nama venue atau tempat event</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label-edit">
                                    <i class="mdi mdi-earth label-icon"></i>
                                    Area<span class="required-mark">*</span>
                                </label>
                                <input type="text" class="form-control form-control-edit" id="area" name="area" 
                                       value="{{ old('area', $event->area) }}" 
                                       placeholder="Contoh: Jakarta Pusat" required>
                                <small class="form-hint">Wilayah atau kota lokasi event</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tanggal Event -->
                <div class="form-section-edit">
                    <div class="section-title">
                        <i class="mdi mdi-calendar-range"></i>
                        Jadwal Event
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label-edit">
                                    <i class="mdi mdi-calendar-start label-icon"></i>
                                    Tanggal Mulai<span class="required-mark">*</span>
                                </label>
                                <input type="date" class="form-control form-control-edit" id="tanggal_mulai" name="tanggal_mulai" 
                                       value="{{ old('tanggal_mulai', $event->tanggal_mulai) }}" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label-edit">
                                    <i class="mdi mdi-calendar-end label-icon"></i>
                                    Tanggal Selesai<span class="required-mark">*</span>
                                </label>
                                <input type="date" class="form-control form-control-edit" id="tanggal_selesai" name="tanggal_selesai" 
                                       value="{{ old('tanggal_selesai', $event->tanggal_selesai) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="date-info">
                        <div class="date-info-icon">
                            <i class="mdi mdi-information"></i>
                        </div>
                        <div class="date-info-text">
                            <strong>Info:</strong> Pastikan tanggal selesai tidak lebih awal dari tanggal mulai event
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button type="submit" class="btn btn-update">
                        <i class="mdi mdi-content-save"></i> Update Event
                    </button>
                    <a href="{{ route('event.index') }}" class="btn btn-cancel">
                        <i class="mdi mdi-arrow-left"></i> Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection