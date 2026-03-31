@extends('layouts.admin.master')
@section('content')

<style>
    /* Gunakan kembali style modern dari index */
    .modern-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .modern-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    .card-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        border: none;
    }

    .card-header-modern h4 {
        color: white;
        font-weight: 600;
        margin: 0;
        font-size: 1.5rem;
    }

    .card-header-modern p {
        color: rgba(255,255,255,0.9);
        margin: 0.5rem 0 0 0;
        font-size: 0.9rem;
    }

    .btn-add-modern {
        background: white;
        color: #667eea;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-add-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.2);
        color: #667eea;
    }

    .form-modern .form-control {
        border-radius: 10px;
        padding: 0.8rem;
        border: 1px solid #e5e7eb;
        color: #070707;
    }

    .form-modern .form-control::placeholder {
        color: #a9a0a0;
        opacity: 1;
    }

    .form-modern label {
        font-weight: 600;
        color: #4b5563;
    }

</style>

<div class="col-lg-10 mt-3 mx-auto grid-margin stretch-card">
    <div class="card modern-card">

        {{-- HEADER --}}
        <div class="card-header-modern d-flex justify-content-between align-items-center">
            <div>
                <h4>Tambah Event</h4>
                <p>Isi data lengkap untuk membuat event baru</p>
            </div>
            <a href="{{ route('event.index') }}" class="btn btn-add-modern">
                <i class="mdi mdi-arrow-left"></i> Kembali
            </a>
        </div>

        {{-- BODY --}}
        <div class="card-body form-modern">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('event.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="nama_event">Nama Event</label>
                    <input type="text" class="form-control" id="nama_event" name="nama_event"
                        value="{{ old('nama_event') }}" placeholder="Masukkan nama event" required>
                </div>

                <div class="form-group mb-3">
                    <label for="lokasi">Lokasi</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi"
                        value="{{ old('lokasi') }}" placeholder="Masukkan lokasi event" required>
                </div>

                <div class="form-group mb-3">
                    <label for="area">Area</label>
                    <input type="text" class="form-control" id="area" name="area"
                        value="{{ old('area') }}" placeholder="Masukkan area event" required>
                </div>

                <div class="form-group mb-3">
                    <label for="tanggal_mulai">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                        value="{{ old('tanggal_mulai') }}" required>
                </div>

                <div class="form-group mb-4">
                    <label for="tanggal_selesai">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                        value="{{ old('tanggal_selesai') }}" required>
                </div>

                <button type="submit" class="btn btn-add-modern">
                    <i class="mdi mdi-content-save"></i> Simpan
                </button> &nbsp;&nbsp;
                <a href="{{ route('event.index') }}" class="btn btn-light">Batal</a>

            </form>

        </div>
    </div>
</div>

@endsection