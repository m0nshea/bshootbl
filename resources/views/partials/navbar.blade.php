<nav class="navbar navbar-expand-lg py-3 shadow-sm">
    <div class="container">
        <!-- Logo & Title -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('img/logo.png') }}" height="40" class="me-2">
            <span class="fw-semibold">Bshoot Billiard</span>
        </a>

        <!-- Toggler mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarMenu">

            <ul class="navbar-nav ms-auto align-items-center gap-3">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.beranda') }}">Beranda</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.kategori') }}">Kategori</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.meja') }}">Meja</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.riwayat') }}">Riwayat</a>
                </li>

                <!-- Profile -->
                <li class="nav-item">
                    <a href="{{ route('customer.profil') }}" class="profile-icon d-flex justify-content-center align-items-center">
                        <i class="bi bi-person-fill"></i>
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger"
                        onclick="event.preventDefault(); if(confirm('Yakin ingin keluar?')) document.getElementById('logout-form').submit();">
                        Keluar
                    </a>
                </li>
            </ul>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

        </div>
    </div>
</nav>