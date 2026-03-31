@extends('layouts.admin.master')
@section('content')

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'success',
            title: 'Yeay! 🎉',
            text: '{{ session('success') }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    });
</script>
@endif

<style>
    .modern-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .card-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        border: none;
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header-modern::before {
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

    .card-header-modern h4 {
        color: white;
        font-weight: 700;
        margin: 0;
        font-size: 1.8rem;
    }

    .card-header-modern p {
        color: rgba(255,255,255,0.9);
        margin: 0.5rem 0 0 0;
        font-size: 0.95rem;
    }

    .btn-add-modern {
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
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-add-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255,255,255,0.4);
        color: #764ba2;
    }

    .card-body {
        padding: 2rem !important;
    }

    .table-container {
        background: white;
        border-radius: 16px;
        overflow-x: auto;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .modern-table {
        margin: 0;
        width: 100%;
        min-width: 1000px;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8eaff 100%);
    }

    .modern-table thead th {
        border: none;
        color: #4338ca;
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1.2rem 1rem;
        white-space: nowrap;
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
        padding: 1rem;
        vertical-align: middle;
        border: none;
        color: #1f2937;
        font-weight: 500;
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

    .event-name {
        font-weight: 700;
        color: #667eea;
        font-size: 0.9rem;
    }

    .location-badge {
        padding: 0.4rem 0.9rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
    }

    .area-badge {
        padding: 0.4rem 0.9rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    .date-box {
        display: inline-block;
    }

    .date-label {
        font-size: 0.7rem;
        color: #000000;
        font-weight: 600;
        text-transform: uppercase;
        display: block;
        margin-bottom: 0.1rem;
    }

    .date-value {
        font-size: 0.9rem;
        color: #1f2937;
        font-weight: 700;
    }

    /* Action Buttons */
    .btn-detail {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        color: white;
    }

    .btn-edit {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        color: white;
    }

    .action-buttons-group {
        display: flex;
        gap: 0.4rem;
        flex-wrap: wrap;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #1f2937;
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
        color: #6b7280;
    }

    .empty-state h5 {
        color: #1f2937;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #4b5563;
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .card-header-modern {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .btn-add-modern {
            width: 100%;
            justify-content: center;
        }

        .card-body {
            padding: 1rem !important;
        }

        .action-buttons-group {
            flex-direction: column;
        }

        .action-buttons-group button,
        .action-buttons-group a {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="col-lg-10 mt-3 grid-margin stretch-card">
    <div class="card modern-card">
        <div class="card-header-modern">
            <div class="header-content">
                <h4>Daftar Event</h4>
                <p>Kelola semua event yang terdaftar di sistem</p>
            </div>
            <a href="{{ route('event.create') }}" class="btn btn-add-modern">
                <i class="mdi mdi-plus-circle"></i> Tambah Event
            </a>
        </div>

        <div class="card-body">
            <div class="table-container">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Nama Event</th>
                            <th>Lokasi</th>
                            <th>Area</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $index => $item)
                            <tr>
                                <td>
                                    <span class="number-badge">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <span class="event-name">{{ $item->nama_event }}</span>
                                </td>
                                <td>
                                    <span class="location-badge">
                                        <i class="mdi mdi-map-marker"></i>
                                        {{ $item->lokasi }}
                                    </span>
                                </td>
                                <td>
                                    <span class="area-badge">
                                        <i class="mdi mdi-earth"></i>
                                        {{ $item->area }}
                                    </span>
                                </td>
                                <td>
                                    <div class="date-box">
                                        <span class="date-label">Mulai</span>
                                        <span class="date-value">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="date-box">
                                        <span class="date-label">Selesai</span>
                                        <span class="date-value">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons-group">
                                        <a href="{{ route('event.show', $item) }}" 
                                           class="btn btn-detail"
                                           title="Lihat Detail">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        <a href="{{ route('event.edit', $item) }}" 
                                           class="btn btn-edit"
                                           title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <form action="{{ route('event.destroy', $item) }}" 
                                              method="POST" 
                                              style="display:inline-block;" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-delete"
                                                    title="Hapus">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="mdi mdi-calendar-blank"></i>
                                    </div>
                                    <h5>Belum Ada Event</h5>
                                    <p>Klik tombol "Tambah Event" untuk membuat event baru</p>
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