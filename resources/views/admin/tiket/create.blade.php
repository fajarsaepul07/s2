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
        opacity: 1;
    }

    textarea.form-control-modern::placeholder {
        color: #000000;
        opacity: 1;
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

    .input-hint {
        font-size: 0.8rem;
        color: #000000;
        margin-top: 0.3rem;
        display: block;
    }

    .form-group-modern:hover .form-label-modern {
        color: #667eea;
    }

    .info-label {
        font-weight: 700;
        color: #000000;
        margin-bottom: 0.5rem;
        font-size: 0.85rem;
        display: block;
    }

    .info-value {
        color: #6b7280;
        font-size: 0.95rem;
        padding: 0.75rem 1rem;
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        display: block;
    }

    /* Style untuk teks deskripsi kecil di tabel */
    table .text-muted,
    table small,
    .table .text-muted,
    .table small {
        color: #000000 !important;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-10 mt-3">
        <div class="card modern-form-card">
            <div class="form-header">
                <h4>Buat Tiket Baru</h4>
                <p>Lengkapi formulir di bawah untuk membuat tiket support baru</p>
            </div>

            <div class="form-body">
                <form action="{{ route('admin.tiket.store') }}" method="POST">
                    @csrf

                    <!-- Informasi User -->
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="mdi mdi-account-group"></i>
                            Informasi User
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <i class="mdi mdi-account form-label-icon"></i>
                                        User<span class="required-mark">*</span>
                                    </label>
                                    <select name="user_id" class="form-control form-control-modern" required>
                                        <option value="">Pilih User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->user_id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="input-hint">Pilih user yang mengajukan tiket</small>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Detail Tiket -->
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="mdi mdi-file-document-edit"></i>
                            Detail Tiket
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <i class="mdi mdi-format-title form-label-icon"></i>
                                        Judul Tiket<span class="required-mark">*</span>
                                    </label>
                                    <input type="text" name="judul" class="form-control form-control-modern" 
                                           placeholder="Contoh: Masalah pada pendaftaran event" required>
                                    <small class="input-hint">Berikan judul yang jelas dan deskriptif</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <i class="mdi mdi-tag form-label-icon"></i>
                                        Kategori<span class="required-mark">*</span>
                                    </label>
                                    <select name="kategori_id" class="form-control form-control-modern" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->kategori_id }}">{{ $kategori->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <i class="mdi mdi-alert-circle form-label-icon"></i>
                                        Prioritas<span class="required-mark">*</span>
                                    </label>
                                    <select name="prioritas_id" class="form-control form-control-modern" required>
                                        <option value="">Pilih Prioritas</option>
                                        @foreach($prioritas as $prio)
                                            <option value="{{ $prio->prioritas_id }}">{{ $prio->nama_prioritas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <i class="mdi mdi-progress-check form-label-icon"></i>
                                        Status<span class="required-mark">*</span>
                                    </label>
                                    <select name="status_id" class="form-control form-control-modern" required>
                                        <option value="">Pilih Status</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->status_id }}">{{ $status->nama_status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group-modern">
                                    <label class="form-label-modern">
                                        <i class="mdi mdi-text-box form-label-icon"></i>
                                        Deskripsi<span class="required-mark">*</span>
                                    </label>
                                    <textarea name="deskripsi" class="form-control form-control-modern" 
                                              rows="5" 
                                              placeholder="Jelaskan detail masalah atau kebutuhan support secara lengkap..." 
                                              required></textarea>
                                    <small class="input-hint">Berikan informasi selengkap mungkin untuk mempercepat penanganan</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button type="submit" class="btn btn-submit">
                            <i class="mdi mdi-check-circle"></i> Simpan Tiket
                        </button>
                        <a href="{{ route('admin.tiket.index') }}" class="btn btn-back">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection