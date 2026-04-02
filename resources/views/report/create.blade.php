@extends('layouts.components-frontend.master')
@section('pageTitle', 'Buat Laporan Baru')

@section('content')

<style>
    /* Style tetap sama seperti sebelumnya (saya tidak ubah desain) */
    body { background: #f7f9fc; }
    .header-gradient { background: linear-gradient(135deg, #1976ff, #5ab3ff); padding: 50px 20px; color: white; text-align: center; border-radius: 18px 18px 0 0; position: relative; overflow: hidden; }
    .header-circle { position: absolute; top: -45px; right: -45px; width: 160px; height: 160px; background: rgba(255,255,255,0.22); border-radius: 50%; }
    .header-icon { background: white; width: 60px; height: 60px; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin: 0 auto 12px auto; color: #1976ff; font-size: 24px; box-shadow: 0 5px 18px rgba(0,0,0,0.15); }
    .form-card { border-radius: 18px; overflow: hidden; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
    .form-control, .form-select { border-radius: 10px !important; padding: 12px !important; border: 1px solid #ced4da; }
    textarea.form-control { min-height: 130px; resize: vertical; }
    .form-control:focus, .form-select:focus { border-color: #1976ff; box-shadow: 0 0 0 0.2rem rgba(25, 118, 255, 0.25); }
</style>

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-lg form-card">

                <div class="header-gradient">
                    <div class="header-circle"></div>
                    <div class="header-icon"><i class="lni lni-pencil"></i></div>
                    <h2 class="fw-bold mb-2">Buat Laporan Baru</h2>
                    <p class="mb-0">Isi formulir di bawah untuk melaporkan masalah</p>
                </div>

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

                        <!-- Judul -->
                        <div class="mb-4">
                            <label for="judul" class="form-label">
                                <i class="lni lni-text-format"></i> Judul Laporan <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" name="judul" value="{{ old('judul') }}"
                                   placeholder="Contoh: Error saat login ke sistem" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pilih Tiket Terkait -->
                        <div class="mb-4">
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
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label">
                                <i class="lni lni-pencil-alt"></i> Deskripsi Lengkap <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" name="deskripsi" rows="6" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Lampiran -->
                        <div class="mb-4">
                            <label for="lampiran" class="form-label">
                                <i class="lni lni-files"></i> Lampiran (Opsional)
                            </label>
                            <input type="file" class="form-control @error('lampiran') is-invalid @enderror" 
                                   id="lampiran" name="lampiran" accept=".jpg,.jpeg,.png,.pdf">
                            @error('lampiran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, PNG, PDF (Maks 2MB)</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('report.index') }}" class="btn btn-secondary">
                                <i class="lni lni-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="lni lni-checkmark-circle"></i> Kirim Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection