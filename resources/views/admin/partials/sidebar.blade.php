<div class="sidebar" id="sidebar">
    <div class="sidebar-content">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <span>Dashboard</span>
                    <span class="badge bg-primary ms-auto">MAIN</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.kategori*') ? 'active' : '' }}" href="{{ route('admin.kategori.index') }}">
                    <span>Kategori</span>
                    <span class="badge bg-success ms-auto">DATA</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.meja*') ? 'active' : '' }}" href="{{ route('admin.meja') }}">
                    <span>Meja</span>
                    <span class="badge bg-success ms-auto">DATA</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.transaksi*') ? 'active' : '' }}" href="{{ route('admin.transaksi') }}">
                    <span>Transaksi</span>
                    <span class="badge bg-warning ms-auto">ORDER</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.pengguna*') ? 'active' : '' }}" href="{{ route('admin.pengguna') }}">
                    <span>Pengguna</span>
                    <span class="badge bg-info ms-auto">USER</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}" href="{{ route('admin.laporan') }}">
                    <span>Laporan</span>
                    <span class="badge bg-secondary ms-auto">REPORT</span>
                </a>
            </li>
        </ul>
    </div>
</div>