@extends('layouts.admin.master')

@section('content')

<style>
    .index-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .index-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .index-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .header-title {
        position: relative;
        z-index: 1;
    }

    .header-title h4 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
    }

    .header-title p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .btn-add-kategori {
        background: white;
        color: #667eea;
        border: none;
        padding: 0.7rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255,255,255,0.3);
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-add-kategori:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255,255,255,0.4);
        color: #764ba2;
    }

    .index-body {
        padding: 2rem;
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

    .alert-success-modern {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    .table-container {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .modern-table {
        margin: 0;
        width: 100%;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8eaff 100%);
    }

    .modern-table thead th {
        border: none;
        color: #4338ca;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1.2rem 1.5rem;
    }

    .modern-table tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: all 0.2s ease;
    }

    .modern-table tbody tr:hover {
        background: #f9fafb;
        transform: scale(1.001);
    }

    .modern-table tbody tr:last-child {
        border-bottom: none;
    }

    .modern-table tbody td {
        padding: 1.2rem 1.5rem;
        vertical-align: middle;
        color: #000000;
        border: none;
    }

    .kategori-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .deskripsi-text {
        color: #000000;
        font-size: 0.9rem;
        line-height: 1.5;
        word-wrap: break-word;
        white-space: normal;
    }

    .number-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 50%;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .btn-edit-modern {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        color: white;
        padding: 0.5rem 1.2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-edit-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-delete-modern {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: none;
        color: white;
        padding: 0.5rem 1.2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-delete-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        color: white;
    }

    .action-buttons-group {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #000000;
    }

    .empty-state i {
        font-size: 4rem;
        color: #6b7280;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state h5 {
        color: #000000;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #4b5563;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .index-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .btn-add-kategori {
            width: 100%;
            justify-content: center;
        }

        .modern-table {
            font-size: 0.85rem;
        }

        .modern-table thead th,
        .modern-table tbody td {
            padding: 0.8rem;
        }

        .action-buttons-group {
            flex-direction: column;
        }

        .action-buttons-group button,
        .action-buttons-group a {
            width: 100%;
            justify-content: center;
        }

        .deskripsi-text {
            max-width: 150px;
        }
    }
</style>

<div class="col-lg-10 mt-3 grid-margin stretch-card">
    <div class="card index-card">
        <div class="index-header">
            <div class="header-title">
                <h4>Daftar Kategori</h4>
                <p>Kelola semua kategori tiket dalam sistem</p>
            </div>
            <a href="{{ route('kategori.create') }}" class="btn-add-kategori">
                <i class="mdi mdi-plus-circle"></i>
                Tambah Kategori
            </a>
        </div>

        <div class="index-body">
            @if (session('success'))
                <div class="alert-modern alert-success-modern">
                    <i class="mdi mdi-check-circle" style="font-size: 1.5rem;"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">#</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th style="width: 250px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategori as $index => $item)
                            <tr>
                                <td>
                                    <span class="number-badge">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <div class="kategori-badge">
                                        <i class="mdi mdi-folder"></i>
                                        {{ $item->nama_kategori }}
                                    </div>
                                </td>
                                <td>
                                    <span class="deskripsi-text" title="{{ $item->deskripsi ?? '-' }}">
                                        {{ $item->deskripsi ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons-group">
                                        <a href="{{ route('kategori.edit', $item) }}"
                                           class="btn-edit-modern">
                                            <i class="mdi mdi-pencil"></i>                                        </a>

                                        <form action="{{ route('kategori.destroy', $item) }}" 
                                              method="POST" 
                                              style="display:inline-block;" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete-modern">
                                                <i class="mdi mdi-delete"></i>
                                                
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">
                                    <i class="mdi mdi-folder-open"></i>
                                    <h5>Belum Ada Kategori</h5>
                                    <p>Klik tombol "Tambah Kategori" untuk membuat kategori baru</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection