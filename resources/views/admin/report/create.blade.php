@extends('layouts.admin.master')
@section('pageTitle', 'Buat Laporan Baru')

@section('content')

<style>
    .create-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .create-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2.5rem 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .create-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .create-header h4 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }

    .create-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
        position: relative;
        z-index: 1;
    }

    .create-body {
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

    .form-section-create {
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

    .form-label-create {
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

    .form-control-create {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f9fafb;
    }

    .form-control-create:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        background: white;
        outline: none;
    }

    .form-control-create:hover {
        border-color: #cbd5e1;
        background: white;
    }

    select.form-control-create {
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23667eea' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
        padding-right: 2.5rem;
    }

    textarea.form-control-create {
        resize: vertical;
        min-height: 150px;
    }

    .form-hint {
        font-size: 0.8rem;
        color: #9ca3af;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .error-message {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.4rem;
        font-weight: 600;
    }

    .required-mark {
        color: #ef4444;
        margin-left: 0.2rem;
    }

    .optional-mark {
        color: #9ca3af;
        font-size: 0.75rem;
        font-weight: 500;
        margin-left: 0.3rem;
    }

    .file-upload-wrapper {
        position: relative;
    }

    .file-upload-box {
        border: 2px dashed #e5e7eb;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        background: #f9fafb;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .file-upload-box:hover {
        border-color: #667eea;
        background: white;
    }

    .file-upload-box.dragover {
        border-color: #667eea;
        background: #f0f9ff;
    }

    .file-upload-icon {
        font-size: 3rem;
        color: #667eea;
        margin-bottom: 1rem;
    }

    .file-upload-text {
        color: #4b5563;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .file-upload-hint {
        color: #9ca3af;
        font-size: 0.85rem;
    }

    .file-input-hidden {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
        overflow: hidden;
    }

    .btn-save {
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

    .btn-save:hover {
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

    @media (max-width: 768px) {
        .create-body {
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

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mt-3">
            <div class="card create-card">
                <div class="create-header">
                    <h4>📝 Buat Laporan Baru</h4>
                    <p>Laporkan masalah atau keluhan yang Anda alami</p>
                </div>

                <div class="create-body">
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

                    <form id="reportForm" action="{{ route('admin.report.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Informasi Dasar -->
                        <div class="form-section-create">
                            <div class="section-title">
                                <i class="mdi mdi-file-document"></i>
                                Informasi Dasar
                            </div>
                            
                            <div class="form-group mb-3">
                                <label class="form-label-create">
                                    <i class="mdi mdi-text-box-outline label-icon"></i>
                                    Judul Laporan<span class="required-mark">*</span>
                                </label>
                                <input type="text" 
                                       name="judul" 
                                       class="form-control form-control-create" 
                                       required 
                                       maxlength="255" 
                                       value="{{ old('judul') }}"
                                       placeholder="Masukkan judul laporan yang jelas dan ringkas">
                                @error('judul')
                                    <div class="error-message">
                                        <i class="mdi mdi-alert-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-hint">
                                    <i class="mdi mdi-information"></i>
                                    <span>Judul yang baik: singkat, jelas, dan menggambarkan masalah</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label-create">
                                            <i class="mdi mdi-folder label-icon"></i>
                                            Kategori<span class="required-mark">*</span>
                                        </label>
                                        <select name="kategori_id" class="form-control form-control-create" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($kategoris as $kategori)
                                                <option value="{{ $kategori->kategori_id }}" {{ old('kategori_id') == $kategori->kategori_id ? 'selected' : '' }}>
                                                    {{ $kategori->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="form-hint">
                                            <i class="mdi mdi-help-circle"></i>
                                            <span>Pilih kategori yang sesuai dengan masalah Anda</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label-create">
                                            <i class="mdi mdi-alert-circle label-icon"></i>
                                            Prioritas<span class="required-mark">*</span>
                                        </label>
                                        <select name="prioritas_id" class="form-control form-control-create" required>
                                            <option value="">-- Pilih Prioritas --</option>
                                            @foreach ($prioritas as $prio)
                                                <option value="{{ $prio->prioritas_id }}" {{ old('prioritas_id') == $prio->prioritas_id ? 'selected' : '' }}>
                                                    {{ $prio->nama_prioritas }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="form-hint">
                                            <i class="mdi mdi-lightbulb-on"></i>
                                            <span>Seberapa mendesak masalah ini?</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Laporan -->
                        <div class="form-section-create">
                            <div class="section-title">
                                <i class="mdi mdi-text-subject"></i>
                                Detail Laporan
                            </div>
                            
                            <div class="form-group mb-3">
                                <label class="form-label-create">
                                    <i class="mdi mdi-text label-icon"></i>
                                    Deskripsi<span class="required-mark">*</span>
                                </label>
                                <textarea name="deskripsi" 
                                          rows="6" 
                                          class="form-control form-control-create" 
                                          required
                                          placeholder="Jelaskan detail masalah yang Anda alami...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="error-message">
                                        <i class="mdi mdi-alert-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-hint">
                                    <i class="mdi mdi-information"></i>
                                    <span>Jelaskan kronologi, dampak, dan hal-hal penting lainnya</span>
                                </div>
                            </div>
                        </div>

                        <!-- Lampiran -->
                        <div class="form-section-create">
                            <div class="section-title">
                                <i class="mdi mdi-paperclip"></i>
                                Lampiran
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label-create">
                                    <i class="mdi mdi-upload label-icon"></i>
                                    Upload File<span class="optional-mark">(Opsional)</span>
                                </label>
                                <div class="file-upload-wrapper">
                                    <label for="fileInput" class="file-upload-box">
                                        <i class="mdi mdi-cloud-upload file-upload-icon"></i>
                                        <div class="file-upload-text">Klik atau seret file ke sini</div>
                                        <div class="file-upload-hint">JPG, PNG, atau PDF • Maksimal 2MB</div>
                                    </label>
                                    <input type="file" 
                                           id="fileInput"
                                           name="lampiran" 
                                           accept=".jpg,.jpeg,.png,.pdf"
                                           class="file-input-hidden">
                                </div>
                                @error('lampiran')
                                    <div class="error-message">
                                        <i class="mdi mdi-alert-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-hint">
                                    <i class="mdi mdi-information"></i>
                                    <span>Lampirkan screenshot atau dokumen pendukung jika ada</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <button type="submit" class="btn btn-save">
                                <i class="mdi mdi-send"></i> Kirim Laporan
                            </button>
                            <a href="{{ route('admin.report.index') }}" class="btn btn-cancel">
                                <i class="mdi mdi-arrow-left"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // File upload enhancement
    const fileInput = document.getElementById('fileInput');
    const fileUploadBox = document.querySelector('.file-upload-box');

    fileInput.addEventListener('change', function(e) {
        if (this.files.length > 0) {
            const fileName = this.files[0].name;
            fileUploadBox.innerHTML = `
                <i class="mdi mdi-file-check file-upload-icon" style="color: #10b981;"></i>
                <div class="file-upload-text" style="color: #10b981;">${fileName}</div>
                <div class="file-upload-hint">File berhasil dipilih</div>
            `;
        }
    });

    // Drag and drop
    fileUploadBox.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    fileUploadBox.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    fileUploadBox.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            const event = new Event('change');
            fileInput.dispatchEvent(event);
        }
    });
</script>

@endsection