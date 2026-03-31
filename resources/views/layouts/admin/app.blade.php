<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title', 'Dashboard') - Ticket System</title>

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/base/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
  
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
  
  @stack('styles')
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
          
          <!-- Alert Messages -->
          @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
          
          @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
          
          @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Whoops!</strong> There were some problems with your input.
            <ul class="mb-0 mt-2">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
          
          <!-- Main Content -->
          @yield('content')
          
        </div>
        <!-- content-wrapper ends -->
        
        <!-- Footer -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
              Copyright © {{ date('Y') }} Ticket Management System. All rights reserved.
            </span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
              Developed with <i class="mdi mdi-heart text-danger"></i>
            </span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="{{ asset('assets/vendors/base/vendor.bundle.base.js') }}"></script>
  
  <!-- inject:js -->
  <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('assets/js/template.js') }}"></script>
  
  <!-- Plugin js for this page-->
  <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
  
  <!-- Custom js for this page-->
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/chart.js') }}"></script>
  
  <!-- End custom js for this page-->
  @stack('scripts')
  
  <script>
    // Auto hide alerts after 5 seconds
    setTimeout(function() {
      $('.alert').fadeOut('slow');
    }, 5000);
  </script>
</body>
</html>