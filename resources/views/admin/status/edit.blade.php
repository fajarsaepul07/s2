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

    .alert-danger-modern {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
        border-left: 4px solid #ef4444;
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

    .form-control-edit::placeholder {
        color: #000000;
        opacity: 1;
    }

    .form-hint {
        font-size: 0.8rem;
        color: #000000;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .required-mark {
        color: #ef4444;
        margin-left: 0.2rem;
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

    .example-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.8rem;
    }

    .example-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .example-open {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
    }

    .example-progress {
        background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
        color: #9a3412;
    }

    .example-resolved {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .example-closed {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        color: #374151;
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
            <h4>Edit Status Tiket</h4>
            <p>Perbarui informasi status tiket dalam sistem</p>
        </div>

        <div class="edit-body">
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

            <form action="{{ route('admin.status.update', $status) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Informasi Status -->
                <div class="form-section-edit">
                    <div class="section-title">
                        <i class="mdi mdi-label"></i>
                        Informasi Status
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label-edit">
                            <i class="mdi mdi-tag label-icon"></i>
                            Nama Status<span class="required-mark">*</span>
                        </label>
                        <input type="text" 
                               class="form-control form-control-edit" 
                               id="nama_status" 
                               name="nama_status"
                               value="{{ old('nama_status', $status->nama_status) }}" 
                               placeholder="Masukkan nama status"
                               required>
                        <div class="form-hint">
                            <i class="mdi mdi-information"></i>
                            <span>Contoh status yang umum digunakan:</span>
                        </div>
                        <div class="example-badges">
                            <span class="example-badge example-open">
                                <i class="mdi mdi-circle-outline"></i> Open
                            </span>
                            <span class="example-badge example-progress">
                                <i class="mdi mdi-progress-clock"></i> In Progress
                            </span>
                            <span class="example-badge example-resolved">
                                <i class="mdi mdi-check-circle"></i> Resolved
                            </span>
                            <span class="example-badge example-closed">
                                <i class="mdi mdi-close-circle"></i> Closed
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button type="submit" class="btn btn-update">
                        <i class="mdi mdi-content-save"></i> Update Status
                    </button>
                    <a href="{{ route('admin.status.index') }}" class="btn btn-cancel">
                        <i class="mdi mdi-arrow-left"></i> Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection