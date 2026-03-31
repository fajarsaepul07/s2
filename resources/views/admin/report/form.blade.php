@extends('layouts.admin.master')

@section('content')

<style>
    .modern-form-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        background: white;
    }

    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2.5rem 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .form-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .form-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 150px;
        height: 150px;
        background: rgba(8, 8, 8, 0.08);
        border-radius: 50%;
    }

    .form-header h4 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }

    .form-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
        position: relative;
        z-index: 1;
    }

    .form-body {
        padding: 2.5rem;
    }

    .form-label-modern {
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label-icon {
        color: #667eea;
        font-size: 1.1rem;
    }

    .form-control-modern {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f9fafb;
        color: #000000;
    }

    .form-control-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        background: white;
        outline: none;
    }

    .form-control-modern:hover {
        border-color: #cbd5e1;
        background: white;
    }

    .form-section {
        background: #f8f9ff;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 2px dashed #e0e7ff;
    }

    .form-section-title {
        color: #667eea;
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-submit {
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

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
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
    }

    .btn-back:hover {
        border-color: #667eea;
        color: #667eea;
        background: #f8f9ff;
        transform: translateY(-2px);
    }

    .form-group-modern {
        margin-bottom: 1.5rem;
    }

    .required-mark {
        color: #ef4444;
        margin-left: 0.2rem;
    }

    select.form-control-modern {
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23667eea' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
        padding-right: 2.5rem;
        color: #000000;
    }

    select.form-control-modern option {
        color: #000000;
    }

    textarea.form-control-modern {
        resize: vertical;
        min-height: 120px;
    }

    .form-control-modern::placeholder {
        color: #000000;
        opacity: 0.6;
    }

    textarea.form-control-modern::placeholder {
        color: #000000;
        opacity: 0.6;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        padding-top: 1.5rem;
        border-top: 2px solid #f3f4f6;
        margin-top: 1rem;
    }

    @media (max-width: 768px) {
        .form-body {
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

    /* ✅ INI YANG PALING PENTING - SEMUA TEKS HINT JADI HITAM */
    .input-hint {
        font-size: 0.8rem;
        color: #000000 !important;
        margin-top: 0.3rem;
        display: block;
    }

    small.input-hint,
    small,
    .text-muted,
    small.text-muted {
        color: #000000 !important;
    }

    .form-group-modern:hover .form-label-modern {
        color: #667eea;
    }

    .alert-success span,
    .alert-success a {
        color: #000000 !important;
    }

    /* File input styling */
    input[type="file"].form-control-modern {
        padding: 0.6rem 1rem;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-10 mt-3">
        <div class="card modern-form-card">
            <div class="form-header">
                <h4>{{ isset($report) ? 'Edit Laporan' : 'Buat Laporan Baru' }}</h4>
                <p>Laporkan masalah atau keluhan yang Anda alami</p>
            </div>

            <div class="form-body">
                <form id="reportForm"
                      action="{{ isset($report) ? route('admin.report.update', $report->id) : route('admin.report.store') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @if(isset($report)) @method('PUT') @endif

                    <!-- Informasi Dasar -->
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="mdi mdi-information"></i>
                            Informasi Dasar
                        </div>
                        
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="mdi mdi-text-box-outline form-label-icon"></i>
                                Judul Laporan<span class="required-mark">*</span>
                            </label>
                            <input type="text" 
                                   name="judul" 
                                   class="form-control form-control-modern"
                                   required 
                                   maxlength="255"
                                   value="{{ old('judul', $report->judul ?? '') }}"
                                   placeholder="Masukkan judul laporan...">
                            <small class="input-hint">Judul yang baik: singkat, jelas, dan menggambarkan masalah</small>
                            @error('judul') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <i class="mdi mdi-tag-outline form-label-icon"></i>
                                        Kategori<span class="required-mark">*</span>
                                    </label>
                                    <input type="text" 
                                           name="kategori" 
                                           list="kategori-list" 
                                           class="form-control form-control-modern"
                                           required 
                                           value="{{ old('kategori', $report->kategori ?? '') }}"
                                           placeholder="Pilih atau ketik kategori...">
                                    <datalist id="kategori-list">
                                        <option value="bug">
                                        <option value="kerusakan">
                                        <option value="keluhan">
                                        <option value="permintaan fitur">
                                    </datalist>
                                    <small class="input-hint">Pilih kategori yang sesuai dengan masalah Anda</small>
                                    @error('kategori') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <i class="mdi mdi-flag-outline form-label-icon"></i>
                                        Prioritas<span class="required-mark">*</span>
                                    </label>
                                    <select name="prioritas" class="form-control form-control-modern" required>
                                        <option value="">-- Pilih Prioritas --</option>
                                        @foreach(['rendah'=>'🟢 Rendah','sedang'=>'🟡 Sedang','tinggi'=>'🟠 Tinggi','urgent'=>'🔴 Urgent'] as $val => $label)
                                            <option value="{{ $val }}" {{ old('prioritas', $report->prioritas ?? '') == $val ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="input-hint">Seberapa mendesak masalah ini?</small>
                                    @error('prioritas') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="mdi mdi-account-multiple-outline form-label-icon"></i>
                                Tugaskan ke
                            </label>
                            <select name="assigned_to" id="assigned_to" class="form-control form-control-modern">
                                <option value="">-- Pilih Petugas --</option>
                                <optgroup label="Tim Teknisi">
                                    @foreach($teknisis as $t)
                                        <option value="{{ $t->user_id }}" {{ (isset($report) && $report->assigned_to == $t->user_id) ? 'selected' : '' }}>
                                            {{ $t->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Tim Konten">
                                    @foreach($kontens as $k)
                                        <option value="{{ $k->user_id }}" {{ (isset($report) && $report->assigned_to == $k->user_id) ? 'selected' : '' }}>
                                            {{ $k->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
                            <small class="input-hint">Pilih petugas yang akan menangani laporan ini</small>
                        </div>
                    </div>

                    <!-- Detail Laporan -->
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="mdi mdi-file-document-edit"></i>
                            Detail Laporan
                        </div>

                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="mdi mdi-text-subject form-label-icon"></i>
                                Deskripsi<span class="required-mark">*</span>
                            </label>
                            <textarea name="deskripsi" 
                                      rows="6" 
                                      class="form-control form-control-modern" 
                                      required
                                      placeholder="Jelaskan detail masalah...">{{ old('deskripsi', $report->deskripsi ?? '') }}</textarea>
                            <small class="input-hint">Jelaskan kronologi, dampak, dan hal-hal penting lainnya</small>
                            @error('deskripsi') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="mdi mdi-paperclip form-label-icon"></i>
                                Lampiran
                                <small style="color: #000000; font-weight: normal;">(JPG/PNG/PDF - max 2MB)</small>
                            </label>
                            <input type="file" 
                                   name="lampiran" 
                                   accept=".jpg,.jpeg,.png,.pdf" 
                                   class="form-control form-control-modern">
                            @if(isset($report) && $report->lampiran)
                                <div class="alert alert-success mt-3 py-2 px-3 d-flex align-items-center">
                                    <i class="mdi mdi-check-circle me-2"></i>
                                    <span style="color: #000000;">Lampiran saat ini:
                                        <a href="{{ Storage::url($report->lampiran) }}" 
                                           target="_blank" 
                                           class="fw-semibold text-decoration-underline" 
                                           style="color: #000000;">
                                            {{ basename($report->lampiran) }}
                                        </a>
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button type="submit" class="btn btn-submit">
                            <i class="mdi mdi-check-circle"></i>
                            {{ isset($report) ? 'Update Laporan' : 'Kirim Laporan' }}
                        </button>
                        <a href="{{ route('admin.report.index') }}" class="btn btn-back">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection