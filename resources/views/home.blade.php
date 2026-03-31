<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard - Majestic Admin</title>

  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/base/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
</head>
<body>
  <div class="container-scroller">

    <!-- NAVBAR -->
    @include('layouts.admin.navbar')
    <!-- END NAVBAR -->

    <div class="container-fluid page-body-wrapper">

      <!-- SIDEBAR -->
      @include('layouts.admin.sidebar')
      <!-- END SIDEBAR -->

      <div class="main-panel">
        <div class="content-wrapper">

          <!-- Header Selamat Datang -->
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                  <div class="mr-md-3 mr-xl-5">
                    <h2>Selamat Datang, {{ Auth::user()->name }}!</h2>
                    <p class="mb-md-0">Dashboard {{ ucfirst(Auth::user()->role) }}</p>
                  </div>
                  <div class="d-flex">
                    <i class="mdi mdi-home text-muted hover-cursor"></i>
                    <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
                    <p class="text-primary mb-0 hover-cursor">Overview</p>
                  </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                  <button type="button" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                    <i class="mdi mdi-clock-outline text-muted"></i>
                  </button>
                  @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.tiket.create') }}" class="btn btn-primary mt-2 mt-xl-0">
                      <i class="mdi mdi-plus mr-1"></i> Buat Tiket
                    </a>
                  @elseif(!in_array(Auth::user()->role, ['tim_teknisi', 'tim_konten']))
                    <a href="{{ route('tiket.create') }}" class="btn btn-primary mt-2 mt-xl-0">
                      <i class="mdi mdi-plus mr-1"></i> Buat Tiket
                    </a>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <!-- Cards Statistik -->
          <div class="row">
            <!-- Card Tiket -->
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body dashboard-tabs p-0">
                  <ul class="nav nav-tabs px-4" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="tiket-tab" data-toggle="tab" href="#tiket-overview" role="tab">
                        <i class="mdi mdi-ticket mr-2"></i>Tiket
                      </a>
                    </li>
                  </ul>
                  <div class="tab-content py-0 px-0">
                    <div class="tab-pane fade show active" id="tiket-overview">
                      <div class="d-flex flex-wrap justify-content-xl-between">
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-ticket-confirmation mr-3 icon-lg text-primary"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Total Tiket</small>
                            <h5 class="mr-2 mb-0">{{ $stats['total_tiket'] }}</h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-alert-circle mr-3 icon-lg text-warning"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Tiket Baru</small>
                            <h5 class="mr-2 mb-0">{{ $stats['tiket_baru'] }}</h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-clock-fast mr-3 icon-lg text-info"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Dalam Proses</small>
                            <h5 class="mr-2 mb-0">{{ $stats['tiket_proses'] }}</h5>
                          </div>
                        </div>
                        <div class="d-flex py-3 flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-check-circle mr-3 icon-lg text-success"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Selesai</small>
                            <h5 class="mr-2 mb-0">{{ $stats['tiket_selesai'] }}</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Card Laporan -->
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body dashboard-tabs p-0">
                  <ul class="nav nav-tabs px-4" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="laporan-tab" data-toggle="tab" href="#laporan-overview" role="tab">
                        <i class="mdi mdi-file-document mr-2"></i>Laporan
                      </a>
                    </li>
                  </ul>
                  <div class="tab-content py-0 px-0">
                    <div class="tab-pane fade show active" id="laporan-overview">
                      <div class="d-flex flex-wrap justify-content-xl-between">
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-file-multiple mr-3 icon-lg text-primary"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Total Laporan</small>
                            <h5 class="mr-2 mb-0">{{ $stats['total_laporan'] }}</h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-clock-alert mr-3 icon-lg text-warning"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Pending</small>
                            <h5 class="mr-2 mb-0">{{ $stats['laporan_pending'] }}</h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-progress-clock mr-3 icon-lg text-info"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Diproses</small>
                            <h5 class="mr-2 mb-0">{{ $stats['laporan_proses'] }}</h5>
                          </div>
                        </div>
                        <div class="d-flex py-3 flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-check-all mr-3 icon-lg text-success"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Selesai</small>
                            <h5 class="mr-2 mb-0">{{ $stats['laporan_selesai'] }}</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Chart + Status -->
          <div class="row">
            <!-- Grafik Tiket & Laporan -->
            <div class="col-md-7 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Grafik Tiket & Laporan (6 Bulan Terakhir)</p>
                  <p class="mb-4">Data pembuatan tiket dan laporan per bulan</p>
                  <canvas id="tiket-laporan-chart"></canvas>
                </div>
              </div>
            </div>

            <!-- Status Summary -->
            <div class="col-md-5 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Ringkasan Status</p>
                  <canvas id="status-chart"></canvas>
                  <div class="mt-4">
                    <div class="d-flex justify-content-between mb-2">
                      <span>Tiket Pending</span>
                      <span class="text-warning font-weight-bold">{{ $stats['tiket_baru'] + $stats['tiket_proses'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                      <span>Tiket Selesai</span>
                      <span class="text-success font-weight-bold">{{ $stats['tiket_selesai'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                      <span>Laporan Pending</span>
                      <span class="text-warning font-weight-bold">{{ $stats['laporan_pending'] + $stats['laporan_proses'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                      <span>Laporan Selesai</span>
                      <span class="text-success font-weight-bold">{{ $stats['laporan_selesai'] }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Tabel Recent Data -->
          <div class="row">
            <!-- Recent Tiket -->
            <div class="col-md-6 stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="card-title mb-0">Tiket Terbaru</p>
                    @if(Auth::user()->role == 'admin')
                      <a href="{{ route('admin.tiket.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    @elseif(in_array(Auth::user()->role, ['tim_teknisi', 'tim_konten']))
                      <a href="{{ route('tim.tiket.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    @else
                      <a href="{{ route('tiket.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    @endif
                  </div>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Kode</th>
                          <th>Judul</th>
                          <th>Status</th>
                          <th>Prioritas</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($stats['recent_tikets'] as $tiket)
                        <tr>
                          <td>
                            @if(Auth::user()->role == 'admin')
                              <a href="{{ route('admin.tiket.show', $tiket->tiket_id) }}">
                                {{ $tiket->kode_tiket }}
                              </a>
                            @elseif(in_array(Auth::user()->role, ['tim_teknisi', 'tim_konten']))
                              <a href="{{ route('tim.tiket.show', $tiket->tiket_id) }}">
                                {{ $tiket->kode_tiket }}
                              </a>
                            @else
                              <a href="{{ route('tiket.show', $tiket->tiket_id) }}">
                                {{ $tiket->kode_tiket }}
                              </a>
                            @endif
                          </td>
                          <td>{{ Str::limit($tiket->judul, 30) }}</td>
                          <td>
                            <span class="badge badge-{{ $tiket->status->nama_status == 'Selesai' ? 'success' : ($tiket->status->nama_status == 'Sedang Diproses' ? 'info' : 'warning') }}">
                              {{ $tiket->status->nama_status }}
                            </span>
                          </td>
                          <td>
                            <span class="badge badge-{{ $tiket->prioritas->nama_prioritas == 'Tinggi' ? 'danger' : ($tiket->prioritas->nama_prioritas == 'Sedang' ? 'warning' : 'secondary') }}">
                              {{ $tiket->prioritas->nama_prioritas }}
                            </span>
                          </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="4" class="text-center text-muted">Belum ada tiket</td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <!-- Recent Laporan -->
            <div class="col-md-6 stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="card-title mb-0">Laporan Terbaru</p>
                    @if(Auth::user()->role == 'admin')
                      <a href="{{ route('admin.report.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    @elseif(Auth::user()->role == 'tim_teknisi')
                      <a href="{{ route('tim.tiket.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    @elseif(Auth::user()->role == 'tim_konten')
                      <a href="{{ route('tim.tiket.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    @else
                      <a href="{{ route('report.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    @endif
                  </div>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Judul</th>
                          <th>Status</th>
                          <th>Kategori</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($stats['recent_reports'] as $report)
                        @if($report && $report->id)
                        <tr>
                          <td>
                            @if(Auth::user()->role == 'admin')
                              <a href="{{ route('admin.report.show', $report->id) }}">
                                #{{ $report->id }}
                              </a>
                            @elseif(Auth::user()->role == 'tim_teknisi')
                              <a href="{{ route('tim.tiket.show', $report->id) }}">
                                #{{ $report->id }}
                              </a>
                            @elseif(Auth::user()->role == 'tim_konten')
                              <a href="{{ route('tim.tiket.show', $report->id) }}">
                                #{{ $report->id }}
                              </a>
                            @else
                              <a href="{{ route('report.show', $report->id) }}">
                                #{{ $report->id }}
                              </a>
                            @endif
                          </td>
                          <td>{{ Str::limit($report->judul ?? 'N/A', 30) }}</td>
                          <td>
                            <span class="badge badge-{{ $report->status == 'selesai' ? 'success' : ($report->status == 'diproses' ? 'info' : 'warning') }}">
                              {{ ucfirst($report->status) }}
                            </span>
                          </td>
                          <td>{{ $report->kategori->nama_kategori ?? 'N/A' }}</td>
                        </tr>
                        @endif
                        @empty
                        <tr>
                          <td colspan="4" class="text-center text-muted">Belum ada laporan</td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Footer Dashboard -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                Copyright © 2025. All rights reserved.
              </span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i>
              </span>
            </div>
          </footer>

        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- main-panel ends -->

    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="{{ asset('assets/vendors/base/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>

  <!-- inject:js -->
  <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('assets/js/template.js') }}"></script>

  <!-- Custom Chart JS -->
  <script>
    // Grafik Tiket & Laporan per Bulan
    var ctx1 = document.getElementById('tiket-laporan-chart').getContext('2d');
    var tiketLaporanChart = new Chart(ctx1, {
      type: 'line',
      data: {
        labels: {!! json_encode($chartData['labels']) !!},
        datasets: [{
          label: 'Tiket',
          data: {!! json_encode($chartData['tiket']) !!},
          borderColor: '#4747A1',
          backgroundColor: 'rgba(71, 71, 161, 0.1)',
          borderWidth: 2,
          fill: true,
          tension: 0.4
        }, {
          label: 'Laporan',
          data: {!! json_encode($chartData['laporan']) !!},
          borderColor: '#F77E53',
          backgroundColor: 'rgba(247, 126, 83, 0.1)',
          borderWidth: 2,
          fill: true,
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 1
            }
          }
        },
        plugins: {
          legend: {
            display: true,
            position: 'top'
          }
        }
      }
    });

    // Grafik Status (Doughnut)
    var ctx2 = document.getElementById('status-chart').getContext('2d');
    var statusChart = new Chart(ctx2, {
      type: 'doughnut',
      data: {
        labels: ['Tiket Pending', 'Tiket Selesai', 'Laporan Pending', 'Laporan Selesai'],
        datasets: [{
          data: [
            {{ $stats['tiket_baru'] + $stats['tiket_proses'] }},
            {{ $stats['tiket_selesai'] }},
            {{ $stats['laporan_pending'] + $stats['laporan_proses'] }},
            {{ $stats['laporan_selesai'] }}
          ],
          backgroundColor: ['#FFC107', '#28A745', '#FF9800', '#17A2B8'],
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      }
    });
  </script>
</body>
</html>