<!-- Top Header -->
<div class="top-header">
    <div class="container-fluid d-flex justify-content-between align-items-center h-100 px-4">
        <div class="header-left d-flex align-items-center">
            <div class="logo-section d-flex align-items-center">
                <div class="logo-container">
                    <img src="{{ asset('img/logo.png') }}" alt="Bshoot Billiard Logo" class="header-logo">
                </div>
                <h4 class="header-title mb-0">Bshoot Billiard</h4>
            </div>
        </div>
        
        <div class="header-right d-flex align-items-center">
            <div class="dropdown">
                <button class="profile-link dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('img/admincantik.jpeg') }}" alt="Admin" class="profile-img">
                    <span class="profile-name">Gege</span>
                    <i class="fas fa-chevron-down"></i>
                    <span class="chevron-fallback">▼</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li>
                        <a class="dropdown-item" href="#" onclick="return confirm('Yakin mau logout?')">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="logout-fallback">→</span>
                            Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>