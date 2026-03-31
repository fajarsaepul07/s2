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

    .alert-success-modern {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    .alert-danger-modern {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }

    .alert-info-modern {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
        border-left: 4px solid #3b82f6;
        display: flex;
        align-items: center;
        gap: 0.8rem;
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

    .form-control-edit:disabled {
        background: #f3f4f6;
        color: #000000;
        cursor: not-allowed;
        opacity: 0.7;
    }

    select.form-control-edit {
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23667eea' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
        padding-right: 2.5rem;
        color: #000000;
    }

    select.form-control-edit option {
        color: #000000;
    }

    textarea.form-control-edit {
        resize: vertical;
        min-height: 120px;
    }

    .readonly-field {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        border: 2px solid #d1d5db;
        position: relative;
    }

    .readonly-badge {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: #6b7280;
        color: white;
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .assignment-box {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8eaff 100%);
        border: 2px solid #e0e7ff;
        border-radius: 12px;
        padding: 1.2rem;
        margin-bottom: 1rem;
    }

    .assignment-title {
        font-weight: 700;
        color: #4338ca;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .assignment-hint {
        font-size: 0.85rem;
        color: #6366f1;
        display: flex;
        align-items: start;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .current-assignment {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border: 2px solid #86efac;
        border-radius: 12px;
        padding: 1rem 1.2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 0.8rem;
    }

    .assignment-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .assignment-info {
        flex: 1;
    }

    .assignment-name {
        font-weight: 700;
        color: #065f46;
        font-size: 1.05rem;
    }

    .assignment-role {
        font-size: 0.85rem;
        color: #047857;
        margin-top: 0.2rem;
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

    optgroup {
        font-weight: 700;
        color: #000000;
    }

    optgroup option {
        font-weight: 400;
        padding-left: 1rem;
        color: #000000;
    }

    @keyframes highlight {
        0% { border-color: #10b981; }
        100% { border-color: #e5e7eb; }
    }

    .auto-selected {
        animation: highlight 2s ease;
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
            <h4>Edit Tiket</h4>
            <p>Perbarui informasi tiket dan tugaskan ke tim yang sesuai</p>
        </div>

        <div class="edit-body">
            @if(session('success'))
                <div class="alert-modern alert-success-modern">
                    <i class="mdi mdi-check-circle" style="font-size: 1.5rem;"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert-modern alert-danger-modern">
                    <i class="mdi mdi-alert-circle" style="font-size: 1.5rem;"></i>
                    <div>
                        <strong>Terdapat kesalahan:</strong>
                        <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.tiket.update', $tiket->tiket_id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Info Tiket (Read-only) -->
                <div class="form-section-edit">
                    <div class="section-title">
                        <i class="mdi mdi-information"></i>
                        Informasi Tiket
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label-edit">
                                    <i class="mdi mdi-barcode label-icon"></i>
                                    Kode Tiket
                                </label>
                                <div style="position: relative;">
                                    <input type="text" class="form-control form-control-edit readonly-field" 
                                           value="{{ $tiket->kode_tiket }}" disabled>
                                    <span class="readonly-badge">READ-ONLY</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label-edit">
                                    <i class="mdi mdi-clock label-icon"></i>
                                    Waktu Dibuat
                                </label>
                                <div style="position: relative;">
                                    <input type="text" class="form-control form-control-edit readonly-field" 
                                           value="{{ $tiket->waktu_dibuat->format('d M Y H:i') }}" disabled>
                                    <span class="readonly-badge">READ-ONLY</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User -->
                <div class="form-section-edit">
                    <div class="section-title">
                        <i class="mdi mdi-account-group"></i>
                        User 
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label-edit">
                                    <i class="mdi mdi-account label-icon"></i>
                                    Pembuat Tiket
                                </label>
                                <select name="user_id" class="form-control form-control-edit">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->user_id }}" {{ $tiket->user_id == $user->user_id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Tiket -->
                <div class="form-section-edit">
                    <div class="section-title">
                        <i class="mdi mdi-file-document-edit"></i>
                        Detail Tiket
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label-edit">
                            <i class="mdi mdi-format-title label-icon"></i>
                            Judul Tiket<span class="required-mark">*</span>
                        </label>
                        <input type="text" name="judul" class="form-control form-control-edit" 
                               value="{{ $tiket->judul }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label-edit">
                                    <i class="mdi mdi-tag label-icon"></i>
                                    Kategori
                                </label>
                                <select name="kategori_id" class="form-control form-control-edit" id="kategori_select">
                                    @foreach ($kategoris as $kat)
                                        <option value="{{ $kat->kategori_id }}" {{ $tiket->kategori_id == $kat->kategori_id ? 'selected' : '' }}>
                                            {{ $kat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label-edit">
                                    <i class="mdi mdi-alert-circle label-icon"></i>
                                    Prioritas
                                </label>
                                <select name="prioritas_id" class="form-control form-control-edit">
                                    @foreach ($prioritas as $prio)
                                        <option value="{{ $prio->prioritas_id }}" {{ $tiket->prioritas_id == $prio->prioritas_id ? 'selected' : '' }}>
                                            {{ $prio->nama_prioritas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label-edit">
                                    <i class="mdi mdi-progress-check label-icon"></i>
                                    Status
                                </label>
                                <select name="status_id" class="form-control form-control-edit">
                                    @foreach ($statuses as $st)
                                        <option value="{{ $st->status_id }}" {{ $tiket->status_id == $st->status_id ? 'selected' : '' }}>
                                            {{ $st->nama_status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assignment Section -->
                <div class="assignment-box">
                    <div class="assignment-title">
                        <i class="mdi mdi-account-tie"></i>
                        Tugaskan Ke Tim
                    </div>
                    <select name="assigned_to" class="form-control form-control-edit" id="assigned_to_select">
                        <option value="">-- Belum Ditugaskan --</option>
                        
                        <optgroup label="🔧 Tim Teknisi">
                            @foreach ($timTeknisi as $teknisi)
                                <option value="{{ $teknisi->user_id }}" {{ $tiket->assigned_to == $teknisi->user_id ? 'selected' : '' }}>
                                    {{ $teknisi->name }}
                                </option>
                            @endforeach
                        </optgroup>
                        
                        <optgroup label="🎨 Tim Konten">
                            @foreach ($timKonten as $konten)
                                <option value="{{ $konten->user_id }}" {{ $tiket->assigned_to == $konten->user_id ? 'selected' : '' }}>
                                    {{ $konten->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                    <div class="assignment-hint">
                        <i class="mdi mdi-lightbulb-on"></i>
                        <span><strong>Tips:</strong> Sistem akan menyarankan tim yang sesuai berdasarkan kategori tiket yang dipilih</span>
                    </div>

                    @if($tiket->assignedTo)
                    <div class="current-assignment">
                        <div class="assignment-avatar">
                            {{ strtoupper(substr($tiket->assignedTo->name, 0, 1)) }}
                        </div>
                        <div class="assignment-info">
                            <div style="font-size: 0.8rem; color: #047857; font-weight: 600;">SAAT INI DITUGASKAN KE:</div>
                            <div class="assignment-name">{{ $tiket->assignedTo->name }}</div>
                            <div class="assignment-role">{{ ucfirst($tiket->assignedTo->role) }}</div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Deskripsi & Waktu Selesai -->
                <div class="form-section-edit">
                    <div class="section-title">
                        <i class="mdi mdi-text-box"></i>
                        Deskripsi & Timeline
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label-edit">
                            <i class="mdi mdi-text label-icon"></i>
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" class="form-control form-control-edit" rows="5">{{ $tiket->deskripsi }}</textarea>
                        <small class="form-hint">Jelaskan detail masalah atau update progress penanganan</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label-edit">
                            <i class="mdi mdi-clock-check label-icon"></i>
                            Waktu Selesai (Opsional)
                        </label>
                        <input type="datetime-local" name="waktu_selesai" class="form-control form-control-edit" 
                               value="{{ $tiket->waktu_selesai ? $tiket->waktu_selesai->format('Y-m-d\TH:i') : '' }}">
                        <small class="form-hint">Isi jika tiket sudah selesai ditangani</small>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button type="submit" class="btn btn-update">
                        <i class="mdi mdi-content-save"></i> Update Tiket
                    </button>
                    <a href="{{ route('admin.tiket.index') }}" class="btn btn-cancel">
                        <i class="mdi mdi-arrow-left"></i> Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kategoriSelect = document.getElementById('kategori_select');
    const assignedToSelect = document.getElementById('assigned_to_select');
    
    // Auto-suggest tim berdasarkan kategori
    kategoriSelect.addEventListener('change', function() {
        const kategoriText = this.options[this.selectedIndex].text.toLowerCase();
        
        // Reset selection jika sudah ada yang dipilih
        if (assignedToSelect.value !== '') {
            if (!confirm('Anda sudah menugaskan tiket ini. Apakah ingin mengubah tim yang ditugaskan berdasarkan kategori?')) {
                return;
            }
        }
        
        // Auto-select berdasarkan kategori
        const options = assignedToSelect.options;
        let found = false;
        
        for (let i = 0; i < options.length; i++) {
            const optionText = options[i].text.toLowerCase();
            
            // Jika kategori mengandung kata "teknis", "sistem", "hardware", dll -> pilih teknisi pertama
            if ((kategoriText.includes('teknis') || kategoriText.includes('sistem') || 
                 kategoriText.includes('hardware') || kategoriText.includes('software') ||
                 kategoriText.includes('bug') || kategoriText.includes('error')) && 
                optionText.includes('teknisi')) {
                assignedToSelect.selectedIndex = i;
                assignedToSelect.classList.add('auto-selected');
                assignedToSelect.style.borderColor = '#10b981';
                setTimeout(() => {
                    assignedToSelect.classList.remove('auto-selected');
                }, 2000);
                found = true;
                break;
            }
            
            // Jika kategori mengandung kata "konten", "media", "desain" -> pilih konten pertama
            if ((kategoriText.includes('konten') || kategoriText.includes('media') || 
                 kategoriText.includes('desain') || kategoriText.includes('foto') ||
                 kategoriText.includes('video') || kategoriText.includes('grafis')) && 
                optionText.includes('konten')) {
                assignedToSelect.selectedIndex = i;
                assignedToSelect.classList.add('auto-selected');
                assignedToSelect.style.borderColor = '#10b981';
                setTimeout(() => {
                    assignedToSelect.classList.remove('auto-selected');
                }, 2000);
                found = true;
                break;
            }
        }
        
        if (found) {
            // Show success notification
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                z-index: 9999;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            `;
            notification.innerHTML = '<i class="mdi mdi-check-circle"></i> Tim yang sesuai telah dipilih secara otomatis!';
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.transition = 'opacity 0.3s ease';
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    });
});
</script>
@endpush
@endsection