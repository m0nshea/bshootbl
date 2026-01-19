@extends('layouts.app2')

@section('content')
<div class="container-fluid py-4" style="margin: 20px auto; max-width: 1200px; padding: 20px;">

    <!-- Breadcrumb -->
    <div class="breadcrumb-section mb-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-success">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
        </ol>
      </nav>
    </div>

    <!-- Page Header -->
    <div class="mb-4">
      <h2 class="page-title">Kelola Pengguna</h2>
      <p class="page-subtitle">Manajemen pengguna dan hak akses sistem</p>
    </div>

    <!-- Stats Cards -->
    

    <!-- Filter Section -->
    <div class="admin-pengguna-filter-card mb-4" style="background: #ffff; border-radius: 15px; box-shadow: 0 6px 25px rgba(0,0,0,0.15); transition: all 0.3s ease; padding: 10px;">
      <div class="card-header">
        <h4 class="card-title mb-0">Filter Pengguna</h4>
      </div>
      <div class="card-body">
        <form method="GET" action="{{ route('admin.pengguna') }}" class="row g-3" style="margin-bottom: 20px;">
          <div class="col-md-3" style="margin-bottom: 15px; margin-right: 10px;">
            <label class="form-label" style="font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 8px;">Role</label>
            <select name="role" class="form-select" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd; background-color: #fff; font-size: 14px; width: 100%; transition: border-color 0.3s ease;">
              <option value="">Semua Role</option>
              <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
            </select>
          </div>
          <div class="col-md-2" style="margin-bottom: 15px; margin-right: 10px;">
            <label class="form-label" style="font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 8px;">Dari Tanggal</label>
            <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd; background-color: #fff; font-size: 14px; width: 100%; transition: border-color 0.3s ease;">
          </div>
          <div class="col-md-2" style="margin-bottom: 15px; margin-right: 10px;">
            <label class="form-label" style="font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 8px;">Sampai Tanggal</label>
            <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd; background-color: #fff; font-size: 14px; width: 100%; transition: border-color 0.3s ease;">
          </div>
          <div class="col-md-3" style="margin-bottom: 15px; margin-right: 10px;">
            <label class="form-label" style="font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 8px;">Cari Pengguna</label>
            <input type="text" name="search" class="form-control" placeholder="Nama atau email..." value="{{ request('search') }}" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd; background-color: #fff; font-size: 14px; width: 100%; transition: border-color 0.3s ease;">
          </div>
          <div class="col-md-2" style="margin-bottom: 15px; margin-top:3px">
            <label class="form-label" style="font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 8px;">&nbsp;</label>
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary" style="padding: 10px 20px; border-radius: 8px; font-weight: 600; background-color: #007bff; border: none; color: white; cursor: pointer; transition: background-color 0.3s ease;">Filter</button>
              <a href="{{ route('admin.pengguna') }}" class="btn btn-secondary" style="padding: 10px 20px; border-radius: 8px; font-weight: 600; background-color: #6c757d; border: none; color: white; text-decoration: none; cursor: pointer; transition: background-color 0.3s ease;">Reset</a>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Main Content Card -->
    <div class="admin-pengguna-main-card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="card-title mb-0">Daftar Pengguna</h4>
          <a href="{{ route('admin.pengguna.export') }}" class="btn btn-outline-success btn-sm">
            <i class="fas fa-download me-1"></i> Export CSV
          </a>
        </div>
      </div>
      <div class="card-body">
        
        <!-- Success/Error Messages -->
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        
        <div class="table-responsive">
          <table class="table table-hover align-middle" style="table-layout: fixed; width: 100%;">
            <thead class="text-center">
              <tr>
                <th width="5%" style="width: 5% !important;">NO</th>
                <th width="10%" style="width: 10% !important;">NAMA</th>
                <th width="20%" style="width: 20% !important;">EMAIL</th>
                <th width="12%" style="width: 12% !important;">NO. HP</th>
                <th width="10%" style="width: 10% !important;">ROLE</th>
                <th width="10%" style="width: 10% !important;">STATUS</th>
                <th width="8%" style="width: 8% !important;">TRANSAKSI</th>
                <th width="12%" style="width: 12% !important;">TOTAL SPENT</th>
                <th width="13%" style="width: 13% !important;">AKSI</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $index => $user)
                <tr>
                  <td class="text-center fw-bold" style="width: 5% !important;">{{ $users->firstItem() + $index }}</td>
                  <td style="width: 10% !important; word-wrap: break-word;">
                    <div class="d-flex align-items-center">
                      <div class="avatar-placeholder me-2">
                        <i class="fas fa-user"></i>
                      </div>
                      <div>
                        <span class="fw-semibold d-block">{{ $user->name }}</span>
                        <small class="text-muted" style="font-size: 0.75rem;">{{ $user->role_text }}</small>
                      </div>
                    </div>
                  </td>
                  <td style="width: 20% !important; word-wrap: break-word;">
                    <span class="text-primary">{{ $user->email }}</span>
                  </td>
                  <td class="text-center" style="width: 12% !important;">
                    <span>{{ $user->no_telepon ?: '-' }}</span>
                  </td>
                  <td class="text-center" style="width: 10% !important;">
                    <span class="badge {{ $user->role_badge }}" style="font-size: 0.7rem;">{{ strtoupper($user->role_text) }}</span>
                  </td>
                  <td class="text-center" style="width: 10% !important;">
                    <span class="badge {{ $user->status_badge }}" style="font-size: 0.7rem;">{{ strtoupper($user->status_text) }}</span>
                  </td>
                  <td class="text-center" style="width: 8% !important;">
                    <span class="fw-bold">{{ $user->transaksis_count }}</span>
                  </td>
                  <td class="text-center" style="width: 12% !important;">
                    @if($user->total_spent > 0)
                      <span class="fw-bold text-success" style="font-size: 0.8rem;">Rp {{ number_format($user->total_spent, 0, ',', '.') }}</span>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td class="text-center" style="width: 13% !important;">
                    <div class="d-flex justify-content-center gap-1 flex-wrap">
                      <a href="{{ route('admin.pengguna.show', $user->id) }}" class="btn btn-info btn-sm" style="font-size: 0.75rem; padding: 4px 8px;" title="Detail">
                        <i class="fas fa-eye"></i>
                      </a>
                      <a href="{{ route('admin.pengguna.edit', $user->id) }}" class="btn btn-primary btn-sm" style="font-size: 0.75rem; padding: 4px 8px;" title="Edit">
                        <i class="fas fa-edit"></i>
                      </a>
                      @if($user->transaksis_count == 0)
                        <button onclick="deleteUser({{ $user->id }})" class="btn btn-danger btn-sm" style="font-size: 0.75rem; padding: 4px 8px;" title="Hapus">
                          <i class="fas fa-trash"></i>
                        </button>
                      @else
                        <button onclick="toggleUserStatus({{ $user->id }})" class="btn btn-warning btn-sm" style="font-size: 0.75rem; padding: 4px 8px;" title="Toggle Status">
                          <i class="fas fa-toggle-{{ $user->status === 'active' ? 'on' : 'off' }}"></i>
                        </button>
                      @endif
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="9" class="text-center py-4">
                    <div class="text-muted">
                      <i class="fas fa-users fa-3x mb-3"></i>
                      <p>Belum ada pengguna yang terdaftar</p>
                      <a href="{{ route('admin.pengguna.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Pengguna Pertama
                      </a>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        
        <!-- Pagination Info -->
        @if($users->hasPages())
          <div class="d-flex justify-content-between align-items-center p-3 border-top">
            <small class="text-muted">
              Menampilkan {{ $users->firstItem() }} sampai {{ $users->lastItem() }} 
              dari {{ $users->total() }} data
            </small>
            <div class="d-flex gap-1">
              {{ $users->links('pagination::bootstrap-4') }}
            </div>
          </div>
        @endif
      </div>
    </div>

</div>
@endsection

@push('styles')
<style>
/* Page Header */
.page-title {
  color: #1f2937;
  font-weight: 700;
  margin: 0;
  font-size: 1.75rem;
}

.page-subtitle {
  color: #6b7280;
  margin: 5px 0 0 0;
  font-size: 0.95rem;
}

/* Breadcrumb */
.breadcrumb {
  background: none;
  padding: 0;
  margin: 0;
  font-size: 0.875rem;
}

.breadcrumb-item a {
  color: #22c55e;
  text-decoration: none;
}

.breadcrumb-item.active {
  color: #6b7280;
}

/* Stats Cards */
.stats-card {
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  transition: all 0.3s ease;
  padding: 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.stats-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.stats-icon {
  font-size: 2.5rem;
  opacity: 0.9;
}

.stats-content h4 {
  font-size: 2rem;
  font-weight: 700;
  margin: 0;
}

.stats-content p {
  margin: 0;
  font-size: 0.9rem;
  opacity: 0.9;
}

/* Filter Card */
.admin-pengguna-filter-card {
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  transition: all 0.3s ease;
  background: #fff;
}

.admin-pengguna-filter-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.admin-pengguna-filter-card .card-header {
  background: linear-gradient(45deg, #f8f9fa, #e9ecef);
  border-bottom: 2px solid #dee2e6;
  border-radius: 15px 15px 0 0 !important;
  padding: 20px;
}

.admin-pengguna-filter-card .card-title {
  color: #495057;
  font-weight: 600;
  font-size: 1.25rem;
  margin: 0;
}

/* Main Card */
.admin-pengguna-main-card {
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  transition: all 0.3s ease;
}

.admin-pengguna-main-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.admin-pengguna-main-card .card-header {
  background: linear-gradient(45deg, #f8f9fa, #e9ecef);
  border-bottom: 2px solid #dee2e6;
  border-radius: 15px 15px 0 0 !important;
  padding: 20px;
}

.admin-pengguna-main-card .card-title {
  color: #495057;
  font-weight: 600;
  font-size: 1.25rem;
  margin: 0;
}

/* Table Styling */
.table {
  border-radius: 10px;
  overflow: hidden;
  margin-bottom: 0;
  font-size: 0.9rem;
  table-layout: fixed !important;
  width: 100% !important;
}

.table thead th {
  background: linear-gradient(45deg, #007bff, #0056b3) !important;
  color: white !important;
  border: none !important;
  font-weight: 600 !important;
  padding: 15px 8px !important;
  text-transform: uppercase;
  font-size: 0.75rem;
  letter-spacing: 0.5px;
  vertical-align: middle !important;
  text-align: center !important;
}

.table tbody td {
  padding: 12px 8px;
  vertical-align: middle;
  border-bottom: 1px solid #f0f0f0;
  word-wrap: break-word;
  overflow-wrap: break-word;
}

.table tbody tr:hover {
  background: #f8f9ff;
  transition: all 0.3s ease;
}

/* Force column widths */
.table th:nth-child(1),
.table td:nth-child(1) { width: 5% !important; }

.table th:nth-child(2),
.table td:nth-child(2) { width: 10% !important; }

.table th:nth-child(3),
.table td:nth-child(3) { width: 20% !important; }

.table th:nth-child(4),
.table td:nth-child(4) { width: 12% !important; }

.table th:nth-child(5),
.table td:nth-child(5) { width: 10% !important; }

.table th:nth-child(6),
.table td:nth-child(6) { width: 10% !important; }

.table th:nth-child(7),
.table td:nth-child(7) { width: 8% !important; }

.table th:nth-child(8),
.table td:nth-child(8) { width: 12% !important; }

.table th:nth-child(9),
.table td:nth-child(9) { width: 13% !important; }

/* Enhanced table-responsive for better horizontal scrolling */
.table-responsive {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* Custom scrollbar for table */
.table-responsive::-webkit-scrollbar {
  height: 8px;
}

.table-responsive::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 4px;
}

.table-responsive::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 4px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
  background: #a8a8a8;
}

/* Avatar */
.avatar-placeholder {
  width: 35px;
  height: 35px;
  background: #e9ecef;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #6c757d;
  font-size: 0.9rem;
}

/* Badges */
.badge {
  font-size: 0.75rem;
  padding: 6px 10px;
  border-radius: 12px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

/* Buttons */
.btn-info {
  background: linear-gradient(45deg, #17a2b8, #138496);
  border: none;
  border-radius: 8px;
  font-weight: 500;
  transition: all 0.3s ease;
}

.btn-info:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
}

.btn-primary {
  background: linear-gradient(45deg, #007bff, #0056b3);
  border: none;
}

.btn-danger {
  background: linear-gradient(45deg, #dc3545, #c82333);
  border: none;
}

.btn-warning {
  background: linear-gradient(45deg, #ffc107, #e0a800);
  border: none;
  color: #212529;
}

/* Alerts */
.alert {
  border-radius: 10px;
  border: none;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
  .page-title {
    font-size: 1.5rem;
  }
  
  .table {
    font-size: 0.8rem;
  }
  
  .table thead th,
  .table tbody td {
    padding: 10px 6px;
  }
  
  .badge {
    font-size: 0.7rem;
    padding: 4px 8px;
  }
  
  .btn-sm {
    font-size: 0.7rem;
    padding: 6px 10px;
  }
  
  .stats-card {
    margin-bottom: 15px;
  }
  
  /* Show scroll hint on mobile */
  .table-responsive::after {
    content: "← Geser untuk melihat semua kolom →";
    display: block;
    text-align: center;
    font-size: 0.75rem;
    color: #6b7280;
    padding: 8px;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
  }
}

/* Loading Animation */
.card {
  opacity: 0;
  animation: fadeInUp 0.8s ease forwards;
}

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
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Delete user function
function deleteUser(userId) {
  Swal.fire({
    title: 'Yakin ingin menghapus?',
    text: "Data pengguna akan dihapus permanen!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`/admin/pengguna/${userId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Content-Type': 'application/json',
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: data.message,
            timer: 1500,
            showConfirmButton: false
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: data.message
          });
        }
      })
      .catch(error => {
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: 'Terjadi kesalahan saat menghapus pengguna'
        });
      });
    }
  });
}

// Toggle user status function
function toggleUserStatus(userId) {
  Swal.fire({
    title: 'Ubah Status Pengguna?',
    text: 'Status pengguna akan diubah (aktif/nonaktif)',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#ffc107',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Ya, Ubah!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`/admin/pengguna/${userId}/toggle-status`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Content-Type': 'application/json',
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: data.message,
            timer: 1500,
            showConfirmButton: false
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: data.message
          });
        }
      })
      .catch(error => {
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: 'Terjadi kesalahan saat mengubah status'
        });
      });
    }
  });
}

// Initialize on page load
$(document).ready(function() {
  // Auto-dismiss alerts after 5 seconds
  setTimeout(function() {
    $('.alert').fadeOut('slow');
  }, 5000);
});
</script>
@endpush