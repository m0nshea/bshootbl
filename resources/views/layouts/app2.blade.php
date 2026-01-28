<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Bshoot Billiard</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome CDN - Multiple Sources -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css" crossorigin="anonymous" />
    
    <!-- Fallback icons dengan CSS -->
    <style>
        /* Fallback untuk chevron */
        .fa-chevron-down::before {
            content: "▼" !important;
            font-family: inherit !important;
        }
    </style>
    
    <script src="{{ asset('assets/panel/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
      WebFont.load({
        google: {
          families: ["Poppins:300,400,500,600,700,800"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/panel/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/panel/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/panel/assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/color-palette.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/admin-icons.css') }}" />
    
    <!-- Bootstrap Icons sebagai fallback -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" />
    
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Custom Admin CSS -->
    <link href="{{ asset('css/DashboardAdm.css') }}" rel="stylesheet">                       
    <link href="{{ asset('css/adminKategori.css') }}" rel="stylesheet">
    <link href="{{ asset('css/adminLaporan.css') }}" rel="stylesheet">
    <link href="{{ asset('css/adminTarif.css') }}" rel="stylesheet">
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/adminTransaksi.css.css')}}">
</head>
<body>
    <div id="app">
        <div class="main-wrapper">

{{-- Top Header --}}
@include('partials.navbar2')

{{-- Admin Layout --}}
<div class="admin-layout">
    {{-- Sidebar --}}
    @include('partials.sidebar')
 
    {{-- Main Content --}}
    <div class="main-content">
        @yield('content')
    </div>
</div>

{{-- Footer --}}
@include('partials.footer2')
    <!-- Core JS Files -->
    <script src="{{ asset('assets/panel/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/panel/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/panel/assets/js/core/bootstrap.min.js') }}"></script>
    
    <!-- Bootstrap 5 CDN (backup) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/panel/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('assets/panel/assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('assets/panel/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('assets/panel/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('assets/panel/assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('assets/panel/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('assets/panel/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/panel/assets/js/plugin/jsvectormap/world.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('assets/panel/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ asset('assets/panel/assets/js/kaiadmin.min.js') }}"></script>
    <script src="{{ asset('assets/panel/assets/js/setting-demo2.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <!-- Custom Dashboard JS -->
    <script src="{{ asset('js/DashboardAdm.js') }}"></script>

    <script>
      $(document).ready(function () {
        $("#datatable").DataTable({
          responsive: true,
          // language: {
          //     url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
          // }
        });
      });
    </script>
    
    @stack('scripts')
</body>
</html>