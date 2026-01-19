@extends('layouts.app2')

@section('content')
<div class="form-wrapper">
  <div class="form-container">

    <!-- Breadcrumb -->
    <div class="form-breadcrumb">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.pengguna') }}">Pengguna</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit Pengguna</li>
        </ol>
      </nav>
    </div>

    <!-- Page Header -->
    <div class="form-header">
      <div>
        <h2 class="form-title">Edit Pengguna</h2>
        <p class="form-subtitle">Kelola detail dan status pengguna</p>
      </div>
      <div>
        <a href="{{ route('admin.pengguna') }}" class="form-btn form-btn-secondary">Kembali</a>
      </div>
    </div>

    <div class="form-row">
      <!-- User Details -->
      <div class="form-col-6" style="flex: 2;">
        <div class="form-card">
          <div class="form-card-header">
            <h4 class="form-card-title">Detail Pengguna</h4>
          </div>
          <div class="form-card-body">
            <!-- User Profile Section -->
            <div class="user-profile-section">
              <div class="user-avatar-section">
                <img src="{{ asset('img/haikal.jpeg') }}" alt="User Avatar" class="user-avatar"/>
                <h5 class="user-name">Haikal Qurnia</h5>
                <span class="user-badge">Pelanggan VIP</span>
              </div>
              <div class="user-details-section">
                <div class="form-row">
                  <div class="form-col-6">
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
                  <div class="form-col-6">
                    <div class="detail-row">
                      <div class="detail-label">Role</div>
                      <div class="detail-value">
                        <span class="user-badge">Pelanggan VIP</span>
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
            <h5 class="stats-title">Statistik Aktivitas</h5>
            <div class="stats-grid">
              <div class="stat-card stat-primary">
                <h3 class="stat-number">15</h3>
                <small class="stat-label">Total Booking</small>
              </div>
              <div class="stat-card stat-success">
                <h3 class="stat-number">Rp 2.500.000</h3>
                <small class="stat-label">Total Transaksi</small>
              </div>
              <div class="stat-card stat-info">
                <h3 class="stat-number">45 Jam</h3>
                <small class="stat-label">Total Bermain</small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Status Management -->
      <div class="form-col-6" style="flex: 1;">
        <div class="form-card">
          <div class="form-card-header">
            <h5 class="form-card-title">Kelola Status</h5>
          </div>
          <div class="form-card-body">
            <form id="statusForm" class="admin-form">
              <div class="form-group">
                <label class="form-label">Status Pengguna</label>
                <div class="status-toggle">
                  <div class="status-option active" onclick="selectStatus('active')">
                    <input type="radio" name="status" value="active" id="active" checked>
                    <div class="status-label status-active">Aktif</div>
                    <div class="status-description">Pengguna dapat mengakses sistem</div>
                  </div>
                  <div class="status-option" onclick="selectStatus('inactive')">
                    <input type="radio" name="status" value="inactive" id="inactive">
                    <div class="status-label status-inactive">Tidak Aktif</div>
                    <div class="status-description">Pengguna tidak dapat mengakses sistem</div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="form-label">Catatan (Opsional)</label>
                <textarea class="form-textarea" rows="3" placeholder="Tambahkan catatan untuk perubahan status..."></textarea>
              </div>

              <div class="form-actions-vertical">
                <button type="submit" class="form-btn form-btn-primary">Simpan Perubahan</button>
                <button type="button" class="form-btn form-btn-secondary" onclick="resetPassword()">Reset Password</button>
                <button type="button" class="form-btn form-btn-danger" onclick="deleteUser()">Hapus Pengguna</button>
              </div>
            </form>
          </div>
        </div>

        <!-- Recent Activity -->
        <div class="form-card" style="margin-top: 1rem;">
          <div class="form-card-header">
            <h6 class="form-card-title">Aktivitas Terakhir</h6>
          </div>
          <div class="form-card-body">
            <div class="timeline">
              <div class="timeline-item">
                <div class="timeline-marker timeline-success"></div>
                <div class="timeline-content">
                  <small class="timeline-time">2 jam yang lalu</small>
                  <div class="timeline-text">Login ke sistem</div>
                </div>
              </div>
              <div class="timeline-item">
                <div class="timeline-marker timeline-primary"></div>
                <div class="timeline-content">
                  <small class="timeline-time">1 hari yang lalu</small>
                  <div class="timeline-text">Booking Meja VIP - 2 jam</div>
                </div>
              </div>
              <div class="timeline-item">
                <div class="timeline-marker timeline-info"></div>
                <div class="timeline-content">
                  <small class="timeline-time">3 hari yang lalu</small>
                  <div class="timeline-text">Update profil</div>
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
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
<style>
/* Additional styles for edit pengguna page */
.user-profile-section {
  display: flex;
  gap: 2rem;
  margin-bottom: 2rem;
}

.user-avatar-section {
  text-align: center;
  min-width: 150px;
}

.user-avatar {
  width: 120px;
  height: 120px;
  object-fit: cover;
  border-radius: 50%;
  border: 4px solid #e2e8f0;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  margin-bottom: 1rem;
}

.user-name {
  margin: 0.5rem 0;
  color: #1f2937;
  font-weight: 600;
}

.user-badge {
  background: #fbbf24;
  color: white;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 600;
}

.user-details-section {
  flex: 1;
}

.detail-row {
  padding: 0.75rem 0;
  border-bottom: 1px solid #f0f0f0;
}

.detail-label {
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.25rem;
  font-size: 0.875rem;
}

.detail-value {
  color: #6b7280;
  font-size: 0.875rem;
}

.stats-title {
  margin: 1.5rem 0 1rem 0;
  color: #1f2937;
  font-weight: 600;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 1rem;
}

.stat-card {
  padding: 1.5rem;
  border-radius: 8px;
  text-align: center;
  color: white;
}

.stat-primary { background: #3b82f6; }
.stat-success { background: #22c55e; }
.stat-info { background: #06b6d4; }

.stat-number {
  margin: 0 0 0.5rem 0;
  font-size: 1.5rem;
  font-weight: 700;
}

.stat-label {
  font-size: 0.875rem;
  opacity: 0.9;
}

.status-toggle {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-top: 1rem;
}

.status-option {
  padding: 1rem;
  border: 2px solid #e2e8f0;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s ease;
  background: white;
}

.status-option:hover {
  border-color: #3b82f6;
  transform: translateY(-1px);
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
  font-size: 1rem;
  margin-bottom: 0.25rem;
}

.status-active { color: #22c55e; }
.status-inactive { color: #ef4444; }

.status-description {
  font-size: 0.875rem;
  color: #6b7280;
}

.form-actions-vertical {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  margin-top: 1.5rem;
}

.form-btn-danger {
  background-color: #ef4444;
  color: white;
  border-color: #ef4444;
}

.form-btn-danger:hover {
  background-color: #dc2626;
  border-color: #dc2626;
  color: white;
  text-decoration: none;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
}

/* Timeline styles */
.timeline {
  position: relative;
  padding-left: 1.5rem;
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
  margin-bottom: 1.5rem;
}

.timeline-marker {
  position: absolute;
  left: -1.5rem;
  top: 5px;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  border: 2px solid white;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-success { background: #22c55e; }
.timeline-primary { background: #3b82f6; }
.timeline-info { background: #06b6d4; }

.timeline-content {
  padding-left: 0.5rem;
}

.timeline-time {
  color: #6b7280;
  font-size: 0.75rem;
}

.timeline-text {
  color: #374151;
  font-size: 0.875rem;
  margin-top: 0.25rem;
}

/* Responsive */
@media (max-width: 768px) {
  .user-profile-section {
    flex-direction: column;
    text-align: center;
  }
  
  .stats-grid {
    grid-template-columns: 1fr;
  }
  
  .form-actions-vertical .form-btn {
    width: 100%;
  }
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