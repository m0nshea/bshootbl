<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Bshoot Billiard')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="billiard, booking, meja, beranda" name="keywords" />
    <meta content="@yield('description', 'Bshoot Billiard - Platform booking meja billiard terbaik')" name="description" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"/>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/customer-navbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/customer-footer.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/home.css') }}" rel="stylesheet" />
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    @include('partials.navbarPelanggan')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('partials.footerPelanggan')
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @stack('scripts')
</body>
</html>