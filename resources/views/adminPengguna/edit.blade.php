@extends('layouts.app2')

@section('content')
<div class="content-wrapper">
  <div class="container-fluid">

    <!-- Breadcrumb -->
    <div class="breadcrumb-section mb-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-success">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.pengguna') }}" class="text-success">Pengguna</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit Pengguna</li>
        </ol>
      </nav>
    </div>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="page-title">Edit Pengguna</h2>
        <p class="page-subtitle">Kelola detail dan status pengguna</p>
      </div>
      <div>
        <a href="{{ route('admin.pengguna') }}" class="btn btn-secondary">Kembali</a>
      </div>
    </div>

    <div class="row">
      <!-- User Details -->
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header" style="background: linear-gradient(45deg, #f8f9fa, #e9ecef); border-bottom: 2px solid #dee2e6;">
            <h4 class="card-title mb-0">Detail Pengguna</h4>
          </div>
          <div class="card-body">
            <!-- User Profile Section -->
            <div class="row mb-4">
              <div class="col-md-3 text-center">
                <img src="{{ asset('img/haikal.jpeg') }}" alt="User Avatar" class="user-avatar mb-3"/>
                <h5 class="mb-1">Haikal Qurnia</h5>
                <span class="badge bg-warning">Pelanggan VIP</span>
              </div>
              <div class="col-md-9">
                <div class="row">
                  <div class="col-md-6">
                    <div class="detail-row">
                      <div class="detail-label">Nama Lengkap</div>
                      <div class="detail-value">Haikal Qurnia</div>
                    </div>
                    <div class="detail-row">
                      <div class="detail-label">Email</div>
                      <div class="detail-value">haikal@gmail.com</div>
                    </div>
                    <div class="detail-row">
                      <div class="detail-label">No. Telepon</div>
                      <div class="detail-value">+62 821-9876-5432</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="detail-row">
                      <div class="detail-label">Role</div>
                      <div class="detail-value">
                        <span class="badge bg-warning">Pelanggan VIP</span>
                      </div>
                    </div>
                    <div class="detail-row">
                      <div class="detail-label">Tanggal Daftar</div>
                      <div class="detail-value">10 Desember 2025</div>
                    </div>
                    <div class="detail-row">
                      <div class="detail-label">Terakhir Login</div>
                      <div class="detail-value">12 Desember 2025, 14:30 WIB</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Activity Statistics -->
            <h5 class="mb-3">Statistik Aktivitas</h5>
            <div class="row">
              <div class="col-md-4">
                <div class="card bg-primary text-white">
                  <div class="card-body text-center">
                    <h3 class="mb-1">15</h3>
                    <small>Total Booking</small>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card bg-success text-white">
                  <div class="card-body text-center">
                    <h3 class="mb-1">Rp 2.500.000</h3>
                    <small>Total Transaksi</small>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card bg-info text-white">
                  <div class="card-body text-center">
                    <h3 class="mb-1">45 Jam</h3>
                    <small>Total Bermain</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Status Management -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header" style="background: linear-gradient(45deg, #f8f9fa, #e9ecef); border-bottom: 2px solid #dee2e6;">
            <h5 class="card-title mb-0">Kelola Status</h5>
          </div>
          <div class="card-body">
            <form id="statusForm">
              <div class="mb-3">
                <label class="form-label fw-semibold">Status Pengguna</label>
                <div class="status-toggle">
                  <div class="status-option active" onclick="selectStatus('active')">
                    <input type="radio" name="status" value="active" id="active" checked>
                    <div class="status-label text-success">Aktif</div>
                    <div class="status-description">Pengguna dapat mengakses sistem</div>
                  </div>
                  <div class="status-option" onclick="selectStatus('inactive')">
                    <input type="radio" name="status" value="inactive" id="inactive">
                    <div class="status-label text-danger">Tidak Aktif</div>
                    <div class="status-description">Pengguna tidak dapat mengakses sistem</div>
                  </div>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Catatan (Opsional)</label>
                <textarea class="form-control" rows="3" placeholder="Tambahkan catatan untuk perubahan status..."></textarea>
              </div>

              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <button type="button" class="btn btn-warning" onclick="resetPassword()">Reset Password</button>
                <button type="button" class="btn btn-danger" onclick="deleteUser()">Hapus Pengguna</button>
              </div>
            </form>
          </div>
        </div>

        <!-- Recent Activity -->
        <div class="card mt-3">
          <div class="card-header">
            <h6 class="card-title mb-0">Aktivitas Terakhir</h6>
          </div>
          <div class="card-body">
            <div class="timeline">
              <div class="timeline-item mb-3">
                <div class="timeline-marker bg-success"></div>
                <div class="timeline-content">
                  <small class="text-muted">2 jam yang lalu</small>
                  <div>Login ke sistem</div>
                </div>
              </div>
              <div class="timeline-item mb-3">
                <div class="timeline-marker bg-primary"></div>
                <div class="timeline-content">
                  <small class="text-muted">1 hari yang lalu</small>
                  <div>Booking Meja VIP - 2 jam</div>
                </div>
              </div>
              <div class="timeline-item">
                <div class="timeline-marker bg-info"></div>
                <div class="timeline-content">
                  <small class="text-muted">3 hari yang lalu</small>
                  <div>Update profil</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/adminPengguna.css') }}">
<style>
/* User Profile Styling */
.user-avatar {
  width: 120px;
  height: 120px;
  object-fit: cover;
  border-radius: 50%;
  border: 4px solid #e2e8f0;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.detail-row {
  padding: 12px 0;
  border-bottom: 1px solid #f0f0f0;
}

.detail-label {
  font-weight: 600;
  color: #374151;
  margin-bottom: 5px;
}

.detail-value {
  color: #6b7280;
}

.status-toggle {
  display: flex;
  align-items: center;
  gap: 15px;
  margin-top: 20px;
}

.status-option {
  flex: 1;
  padding: 15px;
  border: 2px solid #e2e8f0;
  border-radius: 10px;
  text-align: center;
  cursor: pointer;
  transition: all 0.3s ease;
  background: white;
}

.status-option:hover {
  border-color: #3b82f6;
  transform: translateY(-2px);
}

.status-option.active {
  border-color: #22c55e;
  background: #f0fdf4;
}

.status-option.inactive {
  border-color: #ef4444;
  background: #fef2f2;
}

.status-option input[type="radio"] {
  display: none;
}

.status-label {
  font-weight: 600;
  font-size: 1.1rem;
}

.status-description {
  font-size: 0.9rem;
  color: #6b7280;
  margin-top: 5px;
}

/* Timeline styling */
.timeline {
  position: relative;
  padding-left: 20px;
}

.timeline::before {
  content: '';
  position: absolute;
  left: 8px;
  top: 0;
  bottom: 0;
  width: 2px;
  background: #e2e8f0;
}

.timeline-item {
  position: relative;
}

.timeline-marker {
  position: absolute;
  left: -16px;
  top: 5px;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  border: 2px solid white;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-content {
  padding-left: 10px;
}

.d-grid {
  display: grid;
}

.gap-2 {
  gap: 10px;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Add animation on page load
    $('.card').each(function(index) {
        $(this).delay(index * 100).fadeIn(500);
    });
});

// Status selection function
function selectStatus(status) {
    // Remove active class from all options
    document.querySelectorAll('.status-option').forEach(option => {
        option.classList.remove('active', 'inactive');
    });

    // Add appropriate class to selected option
    if (status === 'active') {
        document.querySelector('.status-option:first-child').classList.add('active');
        document.getElementById('active').checked = true;
    } else {
        document.querySelector('.status-option:last-child').classList.add('inactive');
        document.getElementById('inactive').checked = true;
    }
}

// Form submission
document.getElementById('statusForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const status = document.querySelector('input[name="status"]:checked').value;
    const statusText = status === 'active' ? 'Aktif' : 'Tidak Aktif';
    
    Swal.fire({
        title: 'Konfirmasi Perubahan',
        text: `Apakah Anda yakin ingin mengubah status pengguna menjadi ${statusText}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Ubah Status!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Berhasil!',
                text: `Status pengguna berhasil diubah menjadi ${statusText}.`,
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                // Redirect back to user list
                window.location.href = '{{ route("admin.pengguna") }}';
            });
        }
    });
});

// Reset password function
function resetPassword() {
    Swal.fire({
        title: 'Reset Password?',
        text: "Password akan direset dan dikirim ke email pengguna.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ffc107',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Reset!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Password Direset!',
                text: 'Password baru telah dikirim ke email pengguna.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
}

// Delete user function
function deleteUser() {
    Swal.fire({
        title: 'Hapus Pengguna?',
        text: "Data pengguna akan dihapus permanen dan tidak dapat dikembalikan!",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Pengguna Dihapus!',
                text: 'Data pengguna berhasil dihapus.',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                // Redirect back to user list
                window.location.href = '{{ route("admin.pengguna") }}';
            });
        }
    });
}
</script>
@endpush