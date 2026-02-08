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
      
   <style>
        /* Tambahkan ini di bagian head atau sebelum </body> */
        @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
        }

        /* Hover effects */
        .form-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .form-btn-primary:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
        }

        .form-btn-secondary:hover {
        background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
        border-color: #9ca3af;
        }

        .form-btn-danger:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        box-shadow: 0 8px 16px rgba(239, 68, 68, 0.3);
        }

        .status-option:hover {
        border-color: #94a3b8;
        background: #f8fafc;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .timeline-content:hover {
        border-color: #3b82f6;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
        }

        .form-textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
        .form-header {
            flex-direction: column;
            gap: 1rem;
        }
        
        .form-col-6 {
            flex: 1 1 100% !important;
        }
        
        .user-profile-section {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
        }
        
        .detail-row {
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
            gap: 0.25rem;
        }
        
        .detail-label {
            min-width: auto !important;
        }
        
        .detail-value {
            text-align: left !important;
        }
        
        .stats-grid {
            grid-template-columns: 1fr !important;
        }
        
        .form-actions-vertical button {
            width: 100%;
        }
        
        .timeline {
            padding-left: 1rem !important;
        }
        
        .timeline-marker {
            left: -1rem !important;
        }
        }

        @media (max-width: 480px) {
        .form-card-header,
        .form-card-body {
            padding: 1rem !important;
        }
        
        .stat-number {
            font-size: 1.5rem !important;
        }
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
    <!-- Tambahkan FontAwesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Custom Admin CSS -->
    <link href="{{ asset('css/DashboardAdm.css') }}" rel="stylesheet">                       
    <link href="{{ asset('css/adminKategori.css') }}" rel="stylesheet">
    <link href="{{ asset('css/adminLaporan.css') }}" rel="stylesheet">
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