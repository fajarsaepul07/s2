@extends('layouts.components-frontend.master')
@section('pageTitle', 'Detail Laporan')

@section('content')

@include('layouts.components-frontend.navbar')

@push('styles')
<style>

/* STYLE SAMA SEPERTI SHOW TIKET */

.report-title{
    font-size:1.6rem;
    font-weight:700;
}

.report-subtitle{
    font-size:0.9rem;
    color:#6c757d;
}

.report-card-title{
    font-size:1.1rem;
    font-weight:600;
}

.card{
    border-radius:12px;
    transition:all .3s ease;
}

.card:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(0,0,0,0.08)!important;
}

.badge{
    font-size:12px;
    padding:6px 12px;
    font-weight:500;
}

.description-content{
    background:#f8f9fa;
    border-radius:10px;
    padding:18px;
}

.attachment-box{
    border:1px dashed #dee2e6;
    border-radius:10px;
    padding:18px;
}

.timeline-modern{
    position:relative;
}

.timeline-item-modern{
    position:relative;
    padding-left:40px;
    padding-bottom:20px;
}

.timeline-dot-modern{
    position:absolute;
    left:0;
    top:0;
    width:14px;
    height:14px;
    border-radius:50%;
}

.timeline-item-modern::before{
    content:'';
    position:absolute;
    left:6px;
    top:14px;
    height:100%;
    width:2px;
    background:#dee2e6;
}

.timeline-content-modern{
    background:#f8f9fa;
    border-radius:8px;
    padding:12px;
}

.footer-modern{
    margin-top:50px;
    padding:20px 0;
    border-top:1px solid #dee2e6;
}

</style>
@endpush


<div class="container-fluid px-4" style="padding-top:70px;">

{{-- Breadcrumb --}}
<nav aria-label="breadcrumb" class="mb-4">
    <h3 class="report-title mb-1"><a href="{{ route('report.index') }}" class="text-decoration-none">
        📋 Laporan Saya </a></h3>
</nav>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif


<div class="row g-4">

{{-- MAIN CONTENT --}}
<div class="col-lg-8">

{{-- HEADER CARD --}}
<div class="card border-0 shadow-sm mb-4">
<div class="card-body">

<h3 class="report-title mb-2">{{ $report->judul }}</h3>

<p class="report-subtitle mb-3">
Dibuat oleh {{ $report->user->name ?? 'Unknown' }} •
{{ $report->created_at->format('d M Y H:i') }} WIB
</p>

<div class="d-flex gap-2">

<span class="badge bg-{{
match(strtolower($report->prioritas->nama_prioritas ?? 'medium')){
'urgent','tinggi'=>'danger',
'medium','sedang'=>'warning',
'rendah','low'=>'info',
default=>'secondary'
}
}}">
{{ $report->prioritas->nama_prioritas ?? 'Medium' }}
</span>

<span class="badge bg-{{
match($report->status){
'selesai'=>'success',
'diproses'=>'primary',
'pending'=>'warning',
'ditolak'=>'danger',
default=>'secondary'
}
}}">
{{ ucfirst($report->status ?? 'Pending') }}
</span>

</div>

</div>
</div>


{{-- DESKRIPSI --}}
<div class="card border-0 shadow-sm mb-4">
<div class="card-body">

<h5 class="report-card-title mb-3">
Deskripsi Laporan
</h5>

<div class="description-content">
<p class="mb-0" style="white-space: pre-line;">
{{ $report->deskripsi }}
</p>
</div>

</div>
</div>


{{-- LAMPIRAN --}}
@if($report->lampiran)

<div class="card border-0 shadow-sm mb-4">
<div class="card-body">

<h5 class="report-card-title mb-3">
Lampiran
</h5>

<div class="attachment-box d-flex justify-content-between align-items-center">

<div>
<strong>{{ basename($report->lampiran) }}</strong>
</div>

<a href="{{ Storage::url($report->lampiran) }}"
target="_blank"
class="btn btn-sm btn-primary">

Lihat Lampiran

</a>

</div>

</div>
</div>

@endif


</div>


{{-- SIDEBAR --}}
<div class="col-lg-4">

<div class="card border-0 shadow-sm mb-4">
<div class="card-body">

<p class="text-muted small mb-1">Kategori</p>
<p class="fw-semibold mb-3">
{{ $report->kategori->nama_kategori ?? 'Tidak ada' }}
</p>

<p class="text-muted small mb-1">Ditugaskan Ke</p>
<p class="fw-semibold mb-3">
{{ $report->assignedUser->name ?? 'Tim Konten' }}
</p>

<p class="text-muted small mb-1">Dibuat</p>
<p class="fw-semibold mb-0">
{{ $report->created_at->diffForHumans() }}
</p>

</div>
</div>


{{-- TIMELINE --}}
<div class="card border-0 shadow-sm">

<div class="card-body">

<h5 class="report-card-title mb-4">
Riwayat
</h5>

<div class="timeline-modern">

<div class="timeline-item-modern">

<div class="timeline-dot-modern bg-success"></div>

<div class="timeline-content-modern">

<strong>Laporan Dibuat</strong>

<div class="text-muted small">
{{ $report->created_at->format('d M Y H:i') }} WIB
</div>

</div>

</div>

@if($report->updated_at != $report->created_at)

<div class="timeline-item-modern">

<div class="timeline-dot-modern bg-primary"></div>

<div class="timeline-content-modern">

<strong>Terakhir Diperbarui</strong>

<div class="text-muted small">
{{ $report->updated_at->format('d M Y H:i') }} WIB
</div>

</div>

</div>

@endif

</div>

</div>

</div>

</div>

</div>

</div>


<footer class="footer-modern text-center">
<div class="container">
<small class="text-muted">
© 2025 Helpdesk System
</small>
</div>
</footer>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

@endsection