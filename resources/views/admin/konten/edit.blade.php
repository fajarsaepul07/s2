@extends('layouts.admin.master')
@section('pageTitle', 'Edit Konten Laporan')

@section('content')

<style>
    .edit-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .edit-header {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .edit-header::before {
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

    .edit-body {
        padding: 2rem;
    }

    .form-section {
        background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%);
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .info-section {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .section-title {
        font-weight: 700;
        color: #6d28d9;
        font-size: 1.1rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-row {
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 2px dashed rgba(139, 92, 246, 0.1);
    }

    .info-row:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .info-label {
        font-weight: 700;
        color: #059669;
        font-size: 0.85rem;
        margin-bottom: 0.3rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .info-value {
        color: #374151;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .form-label {
        font-weight: 700;
        color: #6d28d9;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label .required {
        color: #dc2626;
        font-size: 1.1rem;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 2px solid #ddd6fe;
        padding: 0.7rem 1rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 0.2rem rgba(139, 92, 246, 0.25);
        outline: none;
    }

    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }

    .file-upload-wrapper {
        position: relative;
    }

    .file-upload-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 1rem;
        background: white;
        border: 2px dashed #ddd6fe;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #8b5cf6;
        font-weight: 600;
    }

    .file-upload-label:hover {
        border-color: #8b5cf6;
        background: #faf5ff;
    }

    .file-upload-input {
        display: none;
    }

    .file-name-display {
        margin-top: 0.5rem;
        padding: 0.5rem 1rem;
        background: #f0fdf4;
        color: #166534;
        border-radius: 8px;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .current-file {
        margin-top: 0.5rem;
        padding: 0.7rem 1rem;
        background: linear-gradient(135deg, #ddd6fe 0%, #c4b5fd 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .current-file-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #5b21b6;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .current-file-preview {
        max-width: 200px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        margin-top: 0.5rem;
    }

    .btn-view-file {
        background: white;
        border: none;
        color: #8b5cf6;
        padding: 0.3rem 0.8rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-view-file:hover {
        background: #8b5cf6;
        color: white;
        transform: translateY(-1px);
    }

    .badge-modern {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.8rem;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .badge-status-diproses {
        background: linear-gradient(90deg, #fff4e6, #feeccf);
        color: #92400e;
    }

    .badge-status-selesai {
        background: linear-gradient(90deg, #dcfce7, #d1fae5);
        color: #065f46;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border: 2px solid #fca5a5;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        color: #991b1b;
    }

    .alert-danger ul {
        margin: 0.5rem 0 0 0;
        padding-left: 1.5rem;
    }

    .alert-danger li {
        margin: 0.3rem 0;
    }

    .alert-title {
        font-weight: 700;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: 2px solid #6ee7b7;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        color: #065f46;
        font-weight: 600;
    }

    .alert-info {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border: 2px solid #93c5fd;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-top: 1rem;
        color: #1e3a8a;
        font-size: 0.85rem;
    }

    .alert-info strong {
        font-weight: 700;
    }

    .action-buttons {
        display: flex;
        gap: 0.8rem;
        flex-wrap: wrap;
        margin-top: 2rem;
    }

    .btn-save {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        border: none;
        color: white;
        padding: 0.8rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4);
        color: white;
    }

    .btn-cancel {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        border: none;
        color: white;
        padding: 0.8rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
    }

    .btn-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(107, 114, 128, 0.4);
        color: white;
    }

    .info-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.8rem;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    .help-text {
        font-size: 0.85rem;
        color: #6b7280;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    @media (max-width: 768px) {
        .edit-body {
            padding: 1rem;
        }

        .form-section, .info-section {
            padding: 1rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-save, .btn-cancel {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mt-3">
            <div class="card edit-card">
                <div class="edit-header">
                    <div class="header-content">
                        <h4><i class="mdi mdi-palette-outline"></i> Edit Konten Laporan</h4>
                        <p>Kelola konten dan publikasi laporan: <strong>{{ $report->judul }}</strong></p>
                    </div>
                </div>

                <div class="edit-body">
                    {{-- ALERT ERRORS --}}
                    @if($errors->any())
                        <div class="alert-danger">
                            <div class="alert-title">
                                <i class="mdi mdi-alert-circle"></i>
                                Terdapat Kesalahan!
                            </div>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- ALERT SUCCESS --}}
                    @if(session('success'))
                        <div class="alert-success">
                            <i class="mdi mdi-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        {{-- LEFT SIDE: INFORMASI LAPORAN --}}
                        <div class="col-lg-5 mb-3">
                            <div class="info-section">
                                <div class="section-title">
                                    <i class="mdi mdi-information-outline"></i>
                                    Informasi Laporan
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="mdi mdi-format-title"></i>
                                        Judul Laporan
                                    </div>
                                    <div class="info-value">{{ $report->judul }}</div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="mdi mdi-text-box-outline"></i>
                                        Deskripsi
                                    </div>
                                    <div class="info-value">{{ $report->deskripsi ?? '-' }}</div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="mdi mdi-clock-outline"></i>
                                        Tanggal Laporan
                                    </div>
                                    <div class="info-value">{{ $report->created_at->format('d M Y H:i') }}</div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="mdi mdi-information"></i>
                                        Status Saat Ini
                                    </div>
                                    <div class="info-value">
                                        @if($report->status == 'diproses')
                                            <span class="badge-modern badge-status-diproses">🔄 Diproses</span>
                                        @elseif($report->status == 'selesai')
                                            <span class="badge-modern badge-status-selesai">✅ Selesai</span>
                                        @else
                                            <span class="badge-modern badge-status-diproses">{{ $report->status }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="mdi mdi-paperclip"></i>
                                        Lampiran Asli
                                    </div>
                                    <div class="info-value">
                                        @if($report->lampiran)
                                            @php
                                                $ext = pathinfo($report->lampiran, PATHINFO_EXTENSION);
                                            @endphp

                                            @if(in_array(strtolower($ext), ['png','jpg','jpeg','gif']))
                                                <img src="{{ Storage::url($report->lampiran) }}" 
                                                     alt="lampiran" 
                                                     class="current-file-preview">
                                            @else
                                                <div class="current-file mt-2">
                                                    <div class="current-file-info">
                                                        <i class="mdi mdi-file-check"></i>
                                                        {{ basename($report->lampiran) }}
                                                    </div>
                                                    <a href="{{ Storage::url($report->lampiran) }}" 
                                                       target="_blank" 
                                                       class="btn-view-file">
                                                        <i class="mdi mdi-eye"></i>
                                                        Lihat
                                                    </a>
                                                </div>
                                            @endif
                                        @else
                                            <span style="color: #6b7280; font-size: 0.85rem;">Tidak ada lampiran</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="alert-info">
                                    <strong>📌 Catatan:</strong> Kelola konten artikel dan media publikasi untuk laporan ini.
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT SIDE: FORM EDIT --}}
                        <div class="col-lg-7">
                            <form method="POST" action="{{ route('tim_konten.report.update', $report->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-section">
                                    <div class="section-title">
                                        <i class="mdi mdi-text-box-multiple-outline"></i>
                                        Konten & Publikasi
                                    </div>

                                    {{-- KONTEN / ARTIKEL --}}
                                    <div class="mb-4">
                                        <label class="form-label">
                                            <i class="mdi mdi-text-box-multiple-outline"></i>
                                            Konten Artikel / Publikasi
                                            <span class="required">*</span>
                                        </label>
                                        <textarea name="konten_artikel" 
                                                  class="form-control" 
                                                  rows="8" 
                                                  placeholder="Tulis konten artikel yang akan dipublikasikan..." 
                                                  required>{{ old('konten_artikel', $report->konten_artikel ?? '') }}</textarea>
                                        <div class="help-text">
                                            <i class="mdi mdi-information-outline"></i>
                                            Tulis artikel atau konten yang akan dipublikasikan untuk laporan ini
                                        </div>
                                    </div>

                                    {{-- CATATAN TIM KONTEN --}}
                                    <div class="mb-4">
                                        <label class="form-label">
                                            <i class="mdi mdi-note-text-outline"></i>
                                            Catatan Tim Konten
                                        </label>
                                        <textarea name="catatan_konten" 
                                                  class="form-control" 
                                                  rows="4" 
                                                  placeholder="Catatan internal tim konten (opsional)...">{{ old('catatan_konten', $report->catatan_konten ?? '') }}</textarea>
                                    </div>

                                    {{-- STATUS PUBLIKASI --}}
                                    <div class="mb-4">
                                        <label class="form-label">
                                            <i class="mdi mdi-publish"></i>
                                            Status Publikasi
                                            <span class="required">*</span>
                                        </label>
                                        <select name="status" class="form-select" required>
                                            <option value="" disabled>-- Pilih Status --</option>
                                            <option value="diproses" {{ old('status', $report->status) == 'diproses' ? 'selected' : '' }}>
                                                🔄 Diproses
                                            </option>
                                            <option value="selesai" {{ old('status', $report->status) == 'selesai' ? 'selected' : '' }}>
                                                ✅ Selesai
                                            </option>
                                        </select>
                                    </div>

                                    {{-- MEDIA / GAMBAR KONTEN --}}
                                    <div class="mb-4">
                                        <label class="form-label">
                                            <i class="mdi mdi-image-multiple"></i>
                                            Upload Media / Gambar Konten
                                        </label>
                                        
                                        <div class="file-upload-wrapper">
                                            <label for="media_konten" class="file-upload-label">
                                                <i class="mdi mdi-cloud-upload mdi-24px"></i>
                                                <span>Klik untuk upload media</span>
                                            </label>
                                            <input type="file" 
                                                   id="media_konten" 
                                                   name="media_konten" 
                                                   class="file-upload-input"
                                                   accept="image/*"
                                                   onchange="displayFileName(this)">
                                            <div id="fileName" class="file-name-display" style="display: none;">
                                                <i class="mdi mdi-file-image"></i>
                                                <span id="fileNameText"></span>
                                            </div>
                                        </div>

                                        <div class="help-text">
                                            <i class="mdi mdi-information-outline"></i>
                                            Upload gambar pendukung untuk konten artikel
                                        </div>

                                        {{-- MEDIA LAMA --}}
                                        @if(isset($report->media_konten) && $report->media_konten)
                                            <div class="current-file">
                                                <div class="current-file-info">
                                                    <i class="mdi mdi-file-check"></i>
                                                    Media konten saat ini tersedia
                                                </div>
                                                <a href="{{ Storage::url($report->media_konten) }}" 
                                                   target="_blank" 
                                                   class="btn-view-file">
                                                    <i class="mdi mdi-eye"></i>
                                                    Lihat Media
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- URL PUBLIKASI --}}
                                    <div class="mb-4">
                                        <label class="form-label">
                                            <i class="mdi mdi-link-variant"></i>
                                            URL Publikasi
                                        </label>
                                        <input type="url" 
                                               name="url_publikasi" 
                                               value="{{ old('url_publikasi', $report->url_publikasi ?? '') }}" 
                                               class="form-control"
                                               placeholder="https://example.com/artikel-laporan">
                                        <div class="help-text">
                                            <i class="mdi mdi-information-outline"></i>
                                            Link URL tempat artikel dipublikasikan (jika sudah published)
                                        </div>
                                    </div>
                                </div>

                                {{-- ACTION BUTTONS --}}
                                <div class="action-buttons">
                                    <button type="submit" class="btn-save">
                                        <i class="mdi mdi-content-save"></i>
                                        Simpan Konten
                                    </button>
                                    <a href="{{ route('tim_konten.report.index') }}" class="btn-cancel">
                                        <i class="mdi mdi-close"></i>
                                        Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function displayFileName(input) {
        const fileNameDisplay = document.getElementById('fileName');
        const fileNameText = document.getElementById('fileNameText');
        
        if (input.files && input.files[0]) {
            fileNameText.textContent = input.files[0].name;
            fileNameDisplay.style.display = 'flex';
        } else {
            fileNameDisplay.style.display = 'none';
        }
    }
</script>

@endsection