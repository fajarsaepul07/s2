@extends('layouts.admin.master')
@section('content')

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <div class="col-11 m-5">
            <div class="bg-secondary rounded h-100 p-4">
                <h4 class="mb-4 text-white">Detail Kategori</h4>

                <div class="card bg-dark text-white p-4 rounded">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kategori:</label>
                        <p class="form-control bg-light text-dark">{{ $kategori->nama_kategori }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi:</label>
                        <p class="form-control bg-light text-dark">{{ $kategori->deskripsi }}</p>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
                        <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-success">Edit</a>
                        <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                            class="d-inline-block"
                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

@endsection
