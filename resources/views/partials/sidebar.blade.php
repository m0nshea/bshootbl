<!-- Sidebar -->
<div class="modern-sidebar" id="sidebar">
    <div class="sidebar-content">
        <ul class="nav flex-column">
            <li class="nav-item active">
                <a href="{{ url('admin/dashboard') }}" class="nav-link">
                    <span>Dashboard</span>
                    <span class="badge bg-primary ms-auto">MAIN</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.kategori*') ? 'active' : '' }}">
                <a href="{{ route('admin.kategori.index') }}" class="nav-link">
                    <span>Kategori</span>
                    <span class="badge bg-success ms-auto">DATA</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.meja*') ? 'active' : '' }}">
                <a href="{{ route('admin.meja.index') }}" class="nav-link">
                    <span>Meja</span>
                    <span class="badge bg-success ms-auto">DATA</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.transaksi*') ? 'active' : '' }}">
                <a href="{{ route('admin.transaksi') }}" class="nav-link">
                    <span>Transaksi</span>
                    <span class="badge bg-warning ms-auto">ORDER</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.pengguna*') ? 'active' : '' }}">
                <a href="{{ route('admin.pengguna') }}" class="nav-link">
                    <span>Pengguna</span>
                    <span class="badge bg-info ms-auto">USER</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                <a href="{{ route('admin.laporan') }}" class="nav-link">
                    <span>Laporan</span>
                    <span class="badge bg-secondary ms-auto">REPORT</span>
                </a>
            </li>
        </ul>
    </div>
</div>