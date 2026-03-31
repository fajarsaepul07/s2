@extends('layouts.components-frontend.master')
@section('pageTitle', 'Daftar Tiket Saya')

@section('content')

    <div class="container py-5" style="min-height: calc(100vh - 200px);">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{-- Header --}}
                <div class="mb-4">
                    <a href="{{ route('tiket.index', $tiket->tiket_id) }}" class="btn btn-sm btn-outline-secondary mb-3">
                        <i class="lni lni-arrow-left"></i> Kembali
                    </a>
                    <h2 class="fw-bold mb-2">✏️ Edit Tiket</h2>
                    <p class="text-muted">Ubah informasi tiket sesuai kebutuhan Anda</p>
                </div>

                {{-- Info Kode Tiket --}}
                <div class="alert alert-info d-flex align-items-center mb-4">
                    <i class="lni lni-information me-2"></i>
                    <div>
                        <strong>Kode Tiket:</strong> #{{ $tiket->kode_tiket }}
                    </div>
                </div>

                {{-- Form Card --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('tiket.update', $tiket->tiket_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Judul Tiket --}}
                            <div class="mb-4">
                                <label for="judul" class="form-label fw-semibold">
                                    Judul Tiket <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('judul') is-invalid @enderror" 
                                       id="judul" 
                                       name="judul" 
                                       value="{{ old('judul', $tiket->judul) }}"
                                       placeholder="Contoh: Error saat login ke sistem"
                                       required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-4">
                                <label for="deskripsi" class="form-label fw-semibold">
                                    Deskripsi Lengkap <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                          id="deskripsi" 
                                          name="deskripsi" 
                                          rows="6"
                                          placeholder="Jelaskan masalah yang Anda alami secara detail..."
                                          required>{{ old('deskripsi', $tiket->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kategori & Prioritas --}}
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="kategori_id" class="form-label fw-semibold">
                                        Kategori <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('kategori_id') is-invalid @enderror" 
                                            id="kategori_id" 
                                            name="kategori_id" 
                                            required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->kategori_id }}" 
                                                {{ old('kategori_id', $tiket->kategori_id) == $kategori->kategori_id ? 'selected' : '' }}>
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            {{-- Status --}}

                            {{-- Info Waktu --}}
                            <div class="alert alert-light border mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted d-block mb-1">
                                            <i class="lni lni-calendar"></i> Dibuat
                                        </small>
                                        <strong>{{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('d M Y, H:i') }}</strong>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted d-block mb-1">
                                            <i class="lni lni-timer"></i> Terakhir Diupdate
                                        </small>
                                        <strong>{{ \Carbon\Carbon::parse($tiket->waktu_diubah)->format('d M Y, H:i') }}</strong>
                                    </div>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="lni lni-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('tiket.index', $tiket->tiket_id) }}" class="btn btn-outline-secondary">
                                    <i class="lni lni-close"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Include Footer --}}
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

@endsection