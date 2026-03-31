@extends('layouts.admin.master')
@section('pageTitle', 'Edit Laporan')

@section('content')

<style>
    .edit-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .edit-header {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
        background: linear-gradient(135deg, #f8f9ff 0%, #e8eaff 100%);
        padding: 1.5rem;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .form-label {
        font-weight: 700;
        color: #4338ca;
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
        border: 2px solid #e0e7ff;
        padding: 0.7rem 1rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        outline: none;
    }

    .form-control:disabled,
    .form-control:read-only {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        color: #6b7280;
        cursor: not-allowed;
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
        border: 2px dashed #e0e7ff;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #667eea;
        font-weight: 600;
    }

    .file-upload-label:hover {
        border-color: #667eea;
        background: #f8f9ff;
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
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .current-file-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #3730a3;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .btn-view-file {
        background: white;
        border: none;
        color: #667eea;
        padding: 0.3rem 0.8rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-view-file:hover {
        background: #667eea;
        color: white;
        transform: translateY(-1px);
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

    .action-buttons {
        display: flex;
        gap: 0.8rem;
        flex-wrap: wrap;
        margin-top: 2rem;
    }

    .btn-save {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        color: white;
        padding: 0.8rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
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

    @media (max-width: 768px) {
        .edit-body {
            padding: 1rem;
        }

        .form-section {
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
                        <h4>✏️ Edit Laporan</h4>
                        <p>Perbarui status dan detail laporan: <strong>{{ $report->judul }}</strong></p>
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

                    {{-- FORM --}}
                    <form method="POST" action="{{ route('tim_teknisi.report.update', $report->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-section">
                            {{-- JUDUL (READONLY) --}}
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="mdi mdi-format-title"></i>
                                    Judul Laporan
                                </label>
                                <input type="text" 
                                       name="judul" 
                                       value="{{ $report->judul }}" 
                                       class="form-control" 
                                       readonly>
                                <div class="info-badge mt-2">
                                    <i class="mdi mdi-lock"></i>
                                    Judul tidak dapat diubah
                                </div>
                            </div>

                            {{-- DESKRIPSI / CATATAN TEKNIS --}}
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="mdi mdi-text-box-outline"></i>
                                    Catatan Teknis / Progress
                                </label>
                                <textarea name="deskripsi" 
                                          class="form-control" 
                                          rows="6" 
                                          placeholder="Tuliskan catatan teknis, progress penanganan, atau update terbaru...">{{ old('deskripsi', $report->deskripsi) }}</textarea>
                            </div>

                            {{-- STATUS --}}
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="mdi mdi-information"></i>
                                    Status Laporan
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

                            {{-- LAMPIRAN BARU --}}
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="mdi mdi-paperclip"></i>
                                    Upload Lampiran Baru
                                </label>
                                
                                <div class="file-upload-wrapper">
                                    <label for="lampiran" class="file-upload-label">
                                        <i class="mdi mdi-cloud-upload mdi-24px"></i>
                                        <span>Klik untuk upload file</span>
                                    </label>
                                    <input type="file" 
                                           id="lampiran" 
                                           name="lampiran" 
                                           class="file-upload-input"
                                           accept="image/*"
                                           onchange="displayFileName(this)">
                                    <div id="fileName" class="file-name-display" style="display: none;">
                                        <i class="mdi mdi-file-image"></i>
                                        <span id="fileNameText"></span>
                                    </div>
                                </div>

                                {{-- LAMPIRAN LAMA --}}
                                @if($report->lampiran)
                                    <div class="current-file">
                                        <div class="current-file-info">
                                            <i class="mdi mdi-file-check"></i>
                                            Lampiran saat ini tersedia
                                        </div>
                                        <a href="{{ Storage::url($report->lampiran) }}" 
                                           target="_blank" 
                                           class="btn-view-file">
                                            <i class="mdi mdi-eye"></i>
                                            Lihat File
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div class="action-buttons">
                            <button type="submit" class="btn-save">
                                <i class="mdi mdi-content-save"></i>
                                Simpan & Update Status
                            </button>
                            <a href="{{ route('tim_teknisi.report.index') }}" class="btn-cancel">
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