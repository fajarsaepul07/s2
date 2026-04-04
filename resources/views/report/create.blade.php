@extends('layouts.components-frontend.master')
@section('pageTitle', 'Buat Laporan Baru')

@section('content')

<style>
    body {
        background: #f7f9fc;
    }

    /* HEADER BLUE */
    .header-gradient {
        background: linear-gradient(135deg, #1976ff, #5ab3ff);
        padding: 50px 20px;
        color: white;
        text-align: center;
        border-radius: 18px 18px 0 0;
        position: relative;
        overflow: hidden;
    }

    .header-circle {
        position: absolute;
        top: -45px;
        right: -45px;
        width: 160px;
        height: 160px;
        background: rgba(255, 255, 255, 0.22);
        border-radius: 50%;
    }

    .header-icon {
        background: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto 12px auto;
        color: #1976ff;
        font-size: 24px;
        box-shadow: 0 5px 18px rgba(0,0,0,0.15);
    }

    /* CARD */
    .form-card {
        border-radius: 18px;
        overflow: hidden;
        border: none;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }

    /* FORM STYLE */
    .form-control, .form-select {
        border-radius: 10px !important;
        padding: 12px !important;
        border: 1px solid #ced4da;
        transition: all 0.3s ease;
    }

    textarea.form-control {
        min-height: 130px;
        resize: vertical;
    }

    .form-control:focus, .form-select:focus {
        border-color: #1976ff;
        box-shadow: 0 0 0 0.2rem rgba(25, 118, 255, 0.25);
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .form-label i {
        margin-right: 5px;
        color: #1976ff;
    }

    .required {
        color: #dc3545;
    }

    .text-muted {
        font-size: 0.875rem;
        margin-top: 4px;
        display: block;
    }

    /* INFO BOX */
    .info-box {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border-left: 4px solid #1976ff;
        padding: 15px;
        border-radius: 10px;
        display: flex;
        gap: 12px;
        align-items: start;
    }

    .info-box i {
        font-size: 24px;
        color: #1976ff;
        margin-top: 2px;
    }

    .info-box strong {
        color: #1565c0;
    }

    .info-box p {
        color: #424242;
        line-height: 1.6;
    }

    /* BUTTONS */
    .btn {
        padding: 10px 24px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1976ff, #5ab3ff);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(25, 118, 255, 0.4);
    }

    .btn-secondary {
        background: #6c757d;
        border: none;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }

    /* ALERT */
    .alert {
        border-radius: 10px;
        border: none;
    }

    .alert-danger {
        background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
        color: #c62828;
        border-left: 4px solid #d32f2f;
    }

    .alert-danger strong {
        color: #b71c1c;
    }

    .alert-danger ul {
        margin-left: 20px;
    }

    .container {
        max-width: 1200px;
        padding-top: 3rem;
        padding-bottom: 3rem;
    }
</style>

<div class="container">
    <div class="card shadow-lg form-card">

        <!-- HEADER BIRU -->
        <div class="header-gradient">
            <div class="header-circle"></div>

            <div class="header-icon">
                <i class="lni lni-pencil"></i>
            </div>

            <h2 class="fw-bold mb-2">Buat Laporan Baru</h2>
            <p class="mb-0">Isi formulir di bawah untuk melaporkan masalah</p>
        </div>

        <!-- FORM BODY -->
        <div class="card-body p-4">

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <strong><i class="lni lni-warning"></i> Terjadi Kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <!-- Judul Laporan -->
                    <div class="col-12 mb-4">
                        <label for="judul" class="form-label">
                            <i class="lni lni-text-format"></i> Judul Laporan <span class="required">*</span>
                        </label>
                        <input type="text" 
                               name="judul" 
                               id="judul" 
                               class="form-control @error('judul') is-invalid @enderror"
                               placeholder="Contoh: Error saat login ke sistem"
                               value="{{ old('judul') }}" 
                               maxlength="255" 
                               required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Tulis judul yang jelas dan ringkas</small>
                    </div>

                    <!-- Pilih Tiket Terkait -->
                    <div class="col-12 mb-4">
                        <label for="tiket_id" class="form-label">
                            <i class="lni lni-ticket"></i> Terkait dengan Tiket (Opsional)
                        </label>
                        <select name="tiket_id" id="tiket_id" class="form-select @error('tiket_id') is-invalid @enderror">
                            <option value="">-- Tidak terkait tiket tertentu --</option>
                            @foreach ($tikets as $tiket)
                                <option value="{{ $tiket->tiket_id }}" {{ old('tiket_id') == $tiket->tiket_id ? 'selected' : '' }}>
                                    #{{ $tiket->kode_tiket }} - {{ Str::limit($tiket->judul, 60) }}
                                    <small>({{ $tiket->status->nama_status ?? 'Baru' }})</small>
                                </option>
                            @endforeach
                        </select>
                        @error('tiket_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Pilih tiket yang sudah Anda buat sebelumnya jika laporan ini berhubungan.</small>
                    </div>

                    <!-- Kategori -->
                        <div class="mb-4">
                            <label for="kategori_id" class="form-label">
                                <i class="lni lni-tag"></i> Kategori <span class="text-danger">*</span>
                            </label>
                            <select name="kategori_id" id="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->kategori_id }}" {{ old('kategori_id') == $kategori->kategori_id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    <!-- Deskripsi -->
                    <div class="col-12 mb-4">
                        <label for="deskripsi" class="form-label">
                            <i class="lni lni-pencil-alt"></i> Deskripsi Lengkap <span class="required">*</span>
                        </label>
                        <textarea name="deskripsi" 
                                  id="deskripsi" 
                                  class="form-control @error('deskripsi') is-invalid @enderror" 
                                  rows="6"
                                  placeholder="Jelaskan masalah yang Anda alami secara detail...&#10;&#10;Contoh:&#10;- Apa yang terjadi?&#10;- Kapan masalah muncul?&#10;- Bagaimana dampaknya?"
                                  required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="lni lni-information"></i> Jelaskan kronologi, dampak, dan hal penting lainnya
                        </small>
                    </div>

                    <!-- Lampiran -->
                    <div class="col-12 mb-4">
                        <label for="lampiran" class="form-label">
                            <i class="lni lni-files"></i> Lampiran (Opsional)
                        </label>
                        <input type="file" 
                               class="form-control @error('lampiran') is-invalid @enderror" 
                               id="lampiran" 
                               name="lampiran" 
                               accept=".jpg,.jpeg,.png,.pdf">
                        @error('lampiran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: JPG, PNG, PDF (Maksimal 2MB)</small>
                    </div>

                    <!-- Info box -->
                    <div class="col-12 mb-4">
                        <div class="info-box">
                            <i class="lni lni-information"></i>
                            <div>
                                <strong>Catatan:</strong>
                                <p class="mb-0">
                                    Laporan Anda akan ditinjau oleh tim support. 
                                    Pastikan informasi yang diberikan sudah lengkap agar dapat ditangani lebih cepat.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('report.index') }}" class="btn btn-secondary">
                                <i class="lni lni-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="lni lni-checkmark-circle"></i> Kirim Laporan
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection