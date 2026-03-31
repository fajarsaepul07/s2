<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Laporan - Helpdesk</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    
    <!-- LineIcons CDN -->
    <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">

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
    }

    /* FORM STYLE */
    .form-control, .form-select {
        border-radius: 10px !important;
        padding: 12px !important;
        border: 1px solid #ced4da;
    }

    textarea.form-control {
        min-height: 130px;
        resize: vertical;
    }

    .form-control:focus, .form-select:focus {
        border-color: #1976ff;
        box-shadow: 0 0 0 0.2rem rgba(25, 118, 255, 0.25);
    }

    /* Current File Display */
    .current-file {
        background: #e3f2fd;
        padding: 12px 16px;
        border-radius: 10px;
        border-left: 4px solid #1976ff;
    }
</style>

</head>
<body>

    @include('layouts.components-frontend.navbar')

    <div class="container py-5" style="max-width: 900px;">

        <div class="card shadow-lg form-card">

            <!-- HEADER BIRU -->
            <div class="header-gradient">
                <div class="header-circle"></div>

                <div class="header-icon">
                    <i class="lni lni-pencil-alt"></i>
                </div>

                <h2 class="fw-bold">Edit Laporan</h2>
                <p class="mb-0">Perbarui informasi laporan Anda</p>
            </div>

            <!-- FORM -->
            <div class="card-body p-4">

                <form action="{{ route('report.update', $report->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Judul -->
                    <div class="mb-4">
                        <label for="judul" class="form-label fw-semibold">Judul Laporan <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('judul') is-invalid @enderror" 
                               id="judul" 
                               name="judul" 
                               value="{{ old('judul', $report->judul) }}"
                               placeholder="Contoh: Error saat login ke sistem"
                               required>

                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->kategori_id }}" 
                                    {{ old('kategori_id', $report->kategori_id) == $kategori->kategori_id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>

                        @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Prioritas (Hanya untuk Admin/Teknisi/Konten) -->
                    @if(in_array(auth()->user()->role, ['admin', 'tim_teknisi', 'tim_konten']))
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Prioritas <span class="text-danger">*</span></label>
                            <select name="prioritas_id" class="form-control @error('prioritas_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Prioritas --</option>
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->prioritas_id }}" 
                                        {{ old('prioritas_id', $report->prioritas_id) == $priority->prioritas_id ? 'selected' : '' }}>
                                        {{ $priority->nama }}
                                    </option>
                                @endforeach
                            </select>

                            @error('prioritas_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Deskripsi Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  name="deskripsi"
                                  placeholder="Jelaskan masalah yang Anda alami secara detail..."
                                  required>{{ old('deskripsi', $report->deskripsi) }}</textarea>

                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="text-muted">
                            <i class="lni lni-information"></i> Berikan detail sejelas mungkin agar proses lebih cepat
                        </small>
                    </div>

                    <!-- Lampiran Saat Ini -->
                    @if($report->lampiran)
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Lampiran Saat Ini</label>
                            <div class="current-file d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="lni lni-files me-2 fs-5"></i>
                                    <div>
                                        <div class="fw-semibold">{{ basename($report->lampiran) }}</div>
                                        <small class="text-muted">File yang sudah diunggah</small>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $report->lampiran) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="lni lni-eye"></i> Lihat
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Lampiran Baru -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            {{ $report->lampiran ? 'Ganti Lampiran (Opsional)' : 'Lampiran (Opsional)' }}
                        </label>
                        <input type="file" 
                               class="form-control @error('lampiran') is-invalid @enderror" 
                               id="lampiran" 
                               name="lampiran"
                               accept=".jpg,.jpeg,.png,.pdf">

                        @error('lampiran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="text-muted">
                            Format: JPG, PNG, PDF (Maks 2MB)
                            @if($report->lampiran)
                                <br><strong>Catatan:</strong> File baru akan menggantikan file lama
                            @endif
                        </small>
                    </div>

                    <!-- Preview File Baru -->
                    <div id="preview-container" class="mb-4" style="display: none;">
                        <div class="alert alert-info d-flex align-items-center">
                            <i class="lni lni-image me-2"></i>
                            <span id="preview-name"></span>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('report.index') }}" class="btn btn-outline-secondary">
                            <i class="lni lni-close"></i> Batal
                        </a>

                        <button type="submit" class="btn btn-primary px-4">
                            <i class="lni lni-checkmark-circle"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

    <footer class="bg-light py-4 mt-5 border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">2021 © Mazer</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-muted">
                        Crafted with <span class="text-danger">❤️</span> by 
                        <a href="http://ahmadsaugi.com" class="text-decoration-none">A. Saugi</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

<script>
document.getElementById('lampiran').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const previewContainer = document.getElementById('preview-container');
    const previewName = document.getElementById('preview-name');

    if (file) {
        previewName.textContent = `File baru terpilih: ${file.name} (${(file.size / 1024).toFixed(2)} KB)`;
        previewContainer.style.display = 'block';
    } else {
        previewContainer.style.display = 'none';
    }
});
</script>

</body>
</html>