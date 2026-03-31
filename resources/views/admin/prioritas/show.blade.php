@extends('layouts.admin.master')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Detail Prioritas</h4>
                <p class="card-description">
                    <a href="{{ route('prioritas.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                    <a href="{{ route('prioritas.edit', $prioritas) }}" class="btn btn-success btn-sm">Ubah</a>
                </p>
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="200">Nama Prioritas</th>
                                <td>{{ $prioritas->nama_prioritas }}</td>
                            </tr>
                            <tr>
                                <th>Dibuat Pada</th>
                                <td>{{ \Carbon\Carbon::parse($prioritas->created_at)->format('d F Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Diupdate Pada</th>
                                <td>{{ \Carbon\Carbon::parse($prioritas->updated_at)->format('d F Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection