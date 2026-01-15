<!-- Customer Sidebar -->
<div class="customer-sidebar" id="sidebar">
    <div class="sidebar-content">
        <ul class="nav flex-column">
            <li class="nav-item {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                <a href="{{ route('customer.dashboard') }}" class="nav-link">
                    <i class="fas fa-tachometer-alt me-3"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('customer.booking*') ? 'active' : '' }}">
                <a href="{{ route('customer.booking') }}" class="nav-link">
                    <i class="fas fa-calendar-check me-3"></i>
                    <span>My Bookings</span>
                    <span class="badge bg-primary ms-auto">3</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('customer.history*') ? 'active' : '' }}">
                <a href="{{ route('customer.history') }}" class="nav-link">
                    <i class="fas fa-history me-3"></i>
                    <span>Riwayat Booking</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('customer.payment*') ? 'active' : '' }}">
                <a href="{{ route('customer.payment') }}" class="nav-link">
                    <i class="fas fa-credit-card me-3"></i>
                    <span>Riwayat Pembayaran</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('customer.profile*') ? 'active' : '' }}">
                <a href="{{ route('customer.profile') }}" class="nav-link">
                    <i class="fas fa-user me-3"></i>
                    <span>Profil Saya</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('customer.settings*') ? 'active' : '' }}">
                <a href="{{ route('customer.settings') }}" class="nav-link">
                    <i class="fas fa-cog me-3"></i>
                    <span>Pengaturan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="fas fa-home me-3"></i>
                    <span>Kembali ke Home</span>
                </a>
            </li>
        </ul>
    </div>
</div>