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
        
        <!-- Simple Scrollable Table -->
        <div style="overflow-x: auto; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
          <table class="table table-striped table-hover mb-0" style="min-width: 1400px; width: 1400px;">
            <thead style="background: #343a40; color: white;">
              <tr>
                <th style="padding: 15px 10px; font-size: 0.8rem; text-align: center; min-width: 60px; width: 60px;">NO</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; min-width: 200px; width: 200px;">NAMA</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; min-width: 220px; width: 220px;">EMAIL</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; text-align: center; min-width: 120px; width: 120px;">NO. HP</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; text-align: center; min-width: 100px; width: 100px;">ROLE</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; text-align: center; min-width: 100px; width: 100px;">STATUS</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; text-align: center; min-width: 100px; width: 100px;">TRANSAKSI</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; text-align: center; min-width: 140px; width: 140px;">TOTAL SPENT</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; text-align: center; min-width: 140px; width: 140px;">TANGGAL DAFTAR</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; text-align: center; min-width: 160px; width: 160px;">AKSI</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $index => $user)
                <tr>
                  <td style="padding: 12px 10px; text-align: center; font-weight: bold; min-width: 60px; width: 60px;">
                    {{ $users->firstItem() + $index }}
                  </td>
                  <td style="padding: 12px 10px; min-width: 200px; width: 200px;">
                    <div style="display: flex; align-items: center;">
                      <div style="width: 35px; height: 35px; background: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6c757d; font-size: 0.9rem; margin-right: 10px;">
                        <i class="fas fa-user"></i>
                      </div>
                      <div>
                        <strong style="display: block; margin-bottom: 2px; font-size: 0.9rem;">{{ $user->name }}</strong>
                        <small style="color: #6c757d; font-size: 0.75rem;">{{ $user->role_text }}</small>
                      </div>
                    </div>
                  </td>
                  <td style="padding: 12px 10px; min-width: 220px; width: 220px;">
                    <span style="color: #007bff; font-size: 0.85rem;">{{ $user->email }}</span>
                  </td>
                  <td style="padding: 12px 10px; text-align: center; min-width: 120px; width: 120px;">
                    <span style="font-size: 0.85rem;">{{ $user->no_telepon ?: '-' }}</span>
                  </td>
                  <td style="padding: 12px 10px; text-align: center; min-width: 100px; width: 100px;">
                    @if($user->role === 'admin')
                      <span class="badge bg-danger" style="font-size: 0.75rem; padding: 6px 10px;">ADMIN</span>
                    @else
                      <span class="badge bg-primary" style="font-size: 0.75rem; padding: 6px 10px;">CUSTOMER</span>
                    @endif
                  </td>
                  <td style="padding: 12px 10px; text-align: center; min-width: 100px; width: 100px;">
                    @if($user->status === 'active')
                      <span class="badge bg-success" style="font-size: 0.75rem; padding: 6px 10px;">AKTIF</span>
                    @else
                      <span class="badge bg-secondary" style="font-size: 0.75rem; padding: 6px 10px;">NONAKTIF</span>
                    @endif
                  </td>
                  <td style="padding: 12px 10px; text-align: center; min-width: 100px; width: 100px;">
                    <span style="font-weight: bold; font-size: 1rem; color: #28a745;">{{ $user->transaksis_count }}</span>
                  </td>
                  <td style="padding: 12px 10px; text-align: center; min-width: 140px; width: 140px;">
                    @if($user->total_spent > 0)
                      <strong style="color: #28a745; font-size: 0.85rem;">Rp {{ number_format($user->total_spent, 0, ',', '.') }}</strong>
                    @else
                      <span style="color: #6c757d;">-</span>
                    @endif
                  </td>
                  <td style="padding: 12px 10px; text-align: center; min-width: 140px; width: 140px;">
                    <div>
                      <strong style="display: block; font-size: 0.85rem;">
                        {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}
                      </strong>
                      <small style="color: #6c757d; font-size: 0.75rem;">
                        {{ \Carbon\Carbon::parse($user->created_at)->format('H:i') }}
                      </small>
                    </div>
                  </td>
                  <td style="padding: 12px 10px; text-align: center; min-width: 160px; width: 160px;">
                    <div style="display: flex; flex-direction: column; gap: 4px; align-items: center;">
                      <div style="display: flex; gap: 4px;">
                        <a href="{{ route('admin.pengguna.show', $user->id) }}" 
                           class="btn btn-info btn-sm" 
                           style="font-size: 0.75rem; padding: 4px 8px; width: 35px;" 
                           title="Detail">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.pengguna.edit', $user->id) }}" 
                           class="btn btn-primary btn-sm" 
                           style="font-size: 0.75rem; padding: 4px 8px; width: 35px;" 
                           title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>
                      </div>
                      <div style="display: flex; gap: 4px;">
                        @if($user->transaksis_count == 0)
                          <button onclick="deleteUser({{ $user->id }})" 
                                  class="btn btn-danger btn-sm" 
                                  style="font-size: 0.75rem; padding: 4px 8px; width: 74px;" 
                                  title="Hapus">
                            <i class="fas fa-trash me-1"></i>Hapus
                          </button>
                        @else
                          <button onclick="toggleUserStatus({{ $user->id }})" 
                                  class="btn btn-warning btn-sm" 
                                  style="font-size: 0.75rem; padding: 4px 8px; width: 74px;" 
                                  title="Toggle Status">
                            <i class="fas fa-toggle-{{ $user->status === 'active' ? 'on' : 'off' }} me-1"></i>Toggle
                          </button>
                        @endif
                      </div>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="10" style="padding: 40px; text-align: center;">
                    <div style="color: #6c757d;">
                      <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 15px; display: block;"></i>
                      <p style="margin: 0 0 15px 0; font-size: 1rem;">Belum ada pengguna yang terdaftar</p>
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

/* Simple Table Styling */
.table {
  font-size: 0.9rem;
}

.table thead th {
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border: none;
  white-space: nowrap;
}

.table tbody td {
  vertical-align: middle;
  border-bottom: 1px solid #dee2e6;
}

.table tbody tr:hover {
  background-color: #f8f9fa;
}

/* Badge Styling */
.badge {
  font-size: 0.75rem;
  padding: 6px 10px;
  border-radius: 15px;
  font-weight: 500;
}

/* Button Styling */
.btn-sm {
  font-size: 0.75rem;
  padding: 4px 8px;
  border-radius: 4px;
  font-weight: 500;
}

.btn-sm:hover {
  transform: translateY(-1px);
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
  
  .table th,
  .table td {
    padding: 8px 6px !important;
  }
  
  .badge {
    font-size: 0.7rem;
    padding: 4px 8px;
  }
  
  .btn-sm {
    font-size: 0.7rem;
    padding: 3px 6px;
  }
}

@media (max-width: 576px) {
  .table {
    font-size: 0.75rem;
  }
  
  .table th,
  .table td {
    padding: 6px 4px !important;
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