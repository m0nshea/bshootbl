<nav class="navbar navbar-expand-lg py-3">
    <div class="container d-flex justify-content-between align-items-center nav-custom">
        <div class="nav-title">
            <div class="d-flex align-items-center">
                <img height="40px" src="{{ asset('img/logo.png') }}" alt="Logo Bshoot Billiard" class="me-2" />
                <span class="brand-text">Bshoot Billiard</span>
            </div>
        </div>
        <div class="nav-actions d-flex align-items-center">
            <a href="{{ route('customer.beranda') }}" class="nav-link">Beranda</a>
            <a href="{{ route('customer.kategori') }}" class="nav-link">Kategori</a>
            <a href="{{ route('customer.meja') }}" class="nav-link">Meja</a>
            
            @auth
                <!-- Authenticated user menu -->
                <a href="{{ route('customer.riwayat') }}" class="nav-link">Riwayat</a>
                <!-- Profile Icon -->
                <a href="{{ route('customer.profil') }}" class="profile-icon" title="Profil Pengguna" 
                   style="background: {{ Request::routeIs('customer.profil') ? 'rgba(255, 255, 255, 0.3)' : 'rgba(255, 255, 255, 0.2)' }};">
                    <i class="bi bi-person-fill"></i>
                </a>
                <a href="{{ route('logout') }}" class="btn-logout" 
                   onclick="event.preventDefault(); if(confirm('Yakin ingin keluar?')) { document.getElementById('logout-form').submit(); }">
                    Keluar
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <!-- Guest user menu -->
                <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                <a href="{{ route('register') }}" class="btn-logout" style="background: #fff; color: #135f3a;">
                    Daftar
                </a>
            @endauth
        </div>
    </div>
</nav>