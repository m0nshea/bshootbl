@extends('layouts.app2')

@section('content')
<div class="content-wrapper">
  <div class="container-fluid">

    <!-- Breadcrumb -->
    <div class="breadcrumb-section mb-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-success">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
        </ol>
      </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header mb-3">
      <div class="page-text">
        <h3 class="page-title mb-1">Kelola Pengguna</h3>
        <p class="page-subtitle mb-0">Manajemen pengguna dan hak akses sistem</p>
      </div>

      <div class="page-action d-flex gap-2">
        <div class="stats-card">
          <small>Total Pengguna</small>
          <h5>{{ $stats['total_users'] }}</h5>
        </div>
        <div class="stats-card">
          <small>Customer</small>
          <h5>{{ $stats['total_customers'] }}</h5>
        </div>
        <div class="stats-card">
          <small>Dengan Transaksi</small>
          <h5 class="text-success">{{ $stats['users_with_transactions'] }}</h5>
        </div>
        <a href="{{ route('admin.pengguna.create') }}" class="btn btn-success btn-sm">
          <i class="fas fa-plus me-1"></i> Tambah Pengguna
        </a>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
      <div class="card-body">
        <form method="GET" action="{{ route('admin.pengguna.index') }}" class="row g-3">
          <div class="col-md-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select">
              <option value="">Semua Role</option>
              <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label">Dari Tanggal</label>
            <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
          </div>
          <div class="col-md-2">
            <label class="form-label">Sampai Tanggal</label>
            <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
          </div>
          <div class="col-md-3">
            <label class="form-label">Cari Pengguna</label>
            <input type="text" name="search" class="form-control" placeholder="Nama atau email..." value="{{ request('search') }}">
          </div>
          <div class="col-md-2">
            <label class="form-label">&nbsp;</label>
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">Filter</button>
              <a href="{{ route('admin.pengguna.index') }}" class="btn btn-secondary">Reset</a>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Main Content Card -->
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Daftar Pengguna</h4>
        <div class="d-flex gap-2">
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
          <table id="datatable" class="table table-hover align-middle w-100">
            <thead class="text-center">
              <tr>
                <th width="8%">No</th>
                <th width="15%">Nama</th>
                <th width="20%">Email</th>
                <th width="12%">No. HP</th>
                <th width="10%">Role</th>
                <th width="10%">Status</th>
                <th width="10%">Total Transaksi</th>
                <th width="10%">Total Spent</th>
                <th width="5%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $index => $user)
                <tr>
                  <td class="text-center fw-bold">{{ $users->firstItem() + $index }}</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="avatar-placeholder me-2">
                        <i class="fas fa-user"></i>
                      </div>
                      <div>
                        <span class="fw-semibold">{{ $user->name }}</span><br>
                        <small class="text-muted">{{ $user->role_text }}</small>
                      </div>
                    </div>
                  </td>
                  <td><span class="text-primary">{{ $user->email }}</span></td>
                  <td class="text-center">
                    <span>{{ $user->no_telepon ?: '-' }}</span>
                  </td>
                  <td class="text-center">
                    <span class="badge {{ $user->role_badge }}">{{ $user->role_text }}</span>
                  </td>
                  <td class="text-center">
                    <span class="badge {{ $user->status_badge }}">{{ $user->status_text }}</span>
                  </td>
                  <td class="text-center">
                    <span class="fw-bold">{{ $user->transaksis_count }}</span>
                    @if($user->transaksis_count > 0)
                      <br><small class="text-muted">transaksi</small>
                    @endif
                  </td>
                  <td class="text-center">
                    @if($user->total_spent > 0)
                      <span class="fw-bold text-success">Rp {{ number_format($user->total_spent, 0, ',', '.') }}</span>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td class="text-center">
                    <div class="d-flex justify-content-center gap-1">
                      <a href="{{ route('admin.pengguna.show', $user->id) }}" class="btn btn-info btn-sm" title="Detail Pengguna">
                        <i class="fas fa-eye"></i>
                      </a>
                      <a href="{{ route('admin.pengguna.edit', $user->id) }}" class="btn btn-primary btn-sm" title="Edit Pengguna">
                        <i class="fas fa-edit"></i>
                      </a>
                      @if($user->transaksis_count == 0)
                        <button onclick="deleteUser({{ $user->id }})" class="btn btn-danger btn-sm" title="Hapus Pengguna">
                          <i class="fas fa-trash"></i>
                        </button>
                      @else
                        <button onclick="toggleUserStatus({{ $user->id }})" class="btn btn-warning btn-sm" title="Toggle Status">
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
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/adminPengguna.css') }}">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<style>
.stats-card {
  background: #f8f9fa;
  padding: 10px 15px;
  border-radius: 8px;
  border-left: 4px solid #28a745;
  min-width: 100px;
}

.stats-card small {
  color: #6c757d;
  font-size: 0.8rem;
}

.stats-card h5 {
  margin: 0;
  font-weight: 600;
}

.avatar-placeholder {
  width: 40px;
  height: 40px;
  background: #e9ecef;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #6c757d;
}

.alert {
  border-radius: 8px;
  border: none;
  margin-bottom: 20px;
}

.alert-success {
  background-color: rgba(40, 167, 69, 0.1);
  color: #155724;
  border-left: 4px solid #28a745;
}

.alert-danger {
  background-color: rgba(220, 53, 69, 0.1);
  color: #721c24;
  border-left: 4px solid #dc3545;
}
</style>
@endpush

@push('scripts')
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
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

$(document).ready(function() {
  // Initialize DataTable
  $('#datatable').DataTable({
    responsive: true,
    order: [[0, 'desc']],
    language: {
      url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
    }
  });
});
</script>
@endpush