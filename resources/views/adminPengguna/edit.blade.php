@extends('layouts.appeditpenggunaADM')

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
    <div class="form-header" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem;">
      <div>
        <h2 class="form-title" style="font-size: 1.75rem; font-weight: 700; color: #1f2937; margin: 0 0 0.5rem 0;">Edit Pengguna</h2>
        <p class="form-subtitle" style="font-size: 0.875rem; color: #6b7280; margin: 0;">Kelola detail dan status pengguna</p>
      </div>
      <div>
        <a href="{{ route('admin.pengguna') }}" class="form-btn form-btn-secondary" style="display: inline-block; padding: 0.625rem 1.25rem; background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; font-weight: 500; font-size: 0.875rem; transition: all 0.3s ease;">Kembali</a>
      </div>
    </div>

    <div class="form-row" style="display: flex; flex-wrap: wrap; gap: 1.5rem;">
      <!-- User Details -->
      <div class="form-col-6" style="flex: 2; min-width: 0;">
        <div class="form-card" style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); overflow: hidden; animation: fadeInUp 0.5s ease forwards;">
          <div class="form-card-header" style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
            <h4 class="form-card-title" style="font-size: 1.125rem; font-weight: 700; color: #1f2937; margin: 0;">Detail Pengguna</h4>
          </div>
          <div class="form-card-body" style="padding: 1.5rem;">
            <!-- User Profile Section (single column) -->
            <div class="user-profile-section" style="display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid #f1f5f9;">
              <div class="user-details-section" style="width: 100%;">
                <div class="detail-row" style="padding: 0.75rem 0; border-bottom: 1px solid #f8fafc; display: flex; justify-content: space-between; align-items: center;">
                  <div class="detail-label" style="font-weight: 600; color: #4b5563; font-size: 0.875rem;">Nama Lengkap</div>
                  <div class="detail-value" style="color: #374151; font-size: 0.875rem; text-align: right;">Haikal Qurnia</div>
                </div>
                <div class="detail-row" style="padding: 0.75rem 0; border-bottom: 1px solid #f8fafc; display: flex; justify-content: space-between; align-items: center;">
                  <div class="detail-label" style="font-weight: 600; color: #4b5563; font-size: 0.875rem;">Email</div>
                  <div class="detail-value" style="color: #374151; font-size: 0.875rem; text-align: right;">haikal@gmail.com</div>
                </div>
                <div class="detail-row" style="padding: 0.75rem 0; border-bottom: 1px solid #f8fafc; display: flex; justify-content: space-between; align-items: center;">
                  <div class="detail-label" style="font-weight: 600; color: #4b5563; font-size: 0.875rem;">No. Telepon</div>
                  <div class="detail-value" style="color: #374151; font-size: 0.875rem; text-align: right;">+62 821-9876-5432</div>
                </div>
                <div class="detail-row" style="padding: 0.75rem 0; border-bottom: 1px solid #f8fafc; display: flex; justify-content: space-between; align-items: center;">
                  <div class="detail-label" style="font-weight: 600; color: #4b5563; font-size: 0.875rem;">Role</div>
                  <div class="detail-value" style="text-align: right;">
                    <span class="user-badge" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: white; padding: 0.25rem 1rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; display: inline-block;">Pelanggan VIP</span>
                  </div>
                </div>
                <div class="detail-row" style="padding: 0.75rem 0; border-bottom: 1px solid #f8fafc; display: flex; justify-content: space-between; align-items: center;">
                  <div class="detail-label" style="font-weight: 600; color: #4b5563; font-size: 0.875rem;">Tanggal Daftar</div>
                  <div class="detail-value" style="color: #374151; font-size: 0.875rem; text-align: right;">10 Desember 2025</div>
                </div>
                <div class="detail-row" style="padding: 0.75rem 0; display: flex; justify-content: space-between; align-items: center;">
                  <div class="detail-label" style="font-weight: 600; color: #4b5563; font-size: 0.875rem;">Terakhir Login</div>
                  <div class="detail-value" style="color: #374151; font-size: 0.875rem; text-align: right;">12 Desember 2025, 14:30 WIB</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Activity -->
        <div class="form-card" style="margin-top: 1rem; background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); overflow: hidden;">
          <div class="form-card-header" style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
            <h6 class="form-card-title" style="font-size: 1rem; font-weight: 700; color: #1f2937; margin: 0;">Aktivitas Terakhir</h6>
          </div>
          <div class="form-card-body" style="padding: 1.5rem;">
            <div class="timeline" style="position: relative; padding-left: 1.5rem;">
              <div class="timeline-item" style="position: relative; margin-bottom: 1.5rem; padding-left: 0.5rem;">
                <div class="timeline-marker timeline-success" style="position: absolute; left: -1.5rem; top: 5px; width: 14px; height: 14px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.15); z-index: 2; background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);"></div>
                <div class="timeline-content" style="padding: 0.75rem; background: white; border-radius: 8px; border: 1px solid #f1f5f9; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: all 0.3s ease;">
                  <small class="timeline-time" style="color: #64748b; font-size: 0.75rem; font-weight: 600; display: block; margin-bottom: 0.25rem;">2 jam yang lalu</small>
                  <div class="timeline-text" style="color: #1f2937; font-size: 0.875rem; font-weight: 500;">Login ke sistem</div>
                </div>
              </div>
              <div class="timeline-item" style="position: relative; margin-bottom: 1.5rem; padding-left: 0.5rem;">
                <div class="timeline-marker timeline-primary" style="position: absolute; left: -1.5rem; top: 5px; width: 14px; height: 14px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.15); z-index: 2; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);"></div>
                <div class="timeline-content" style="padding: 0.75rem; background: white; border-radius: 8px; border: 1px solid #f1f5f9; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: all 0.3s ease;">
                  <small class="timeline-time" style="color: #64748b; font-size: 0.75rem; font-weight: 600; display: block; margin-bottom: 0.25rem;">1 hari yang lalu</small>
                  <div class="timeline-text" style="color: #1f2937; font-size: 0.875rem; font-weight: 500;">Booking Meja VIP - 2 jam</div>
                </div>
              </div>
              <div class="timeline-item" style="position: relative; margin-bottom: 1.5rem; padding-left: 0.5rem;">
                <div class="timeline-marker timeline-info" style="position: absolute; left: -1.5rem; top: 5px; width: 14px; height: 14px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.15); z-index: 2; background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);"></div>
                <div class="timeline-content" style="padding: 0.75rem; background: white; border-radius: 8px; border: 1px solid #f1f5f9; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: all 0.3s ease;">
                  <small class="timeline-time" style="color: #64748b; font-size: 0.75rem; font-weight: 600; display: block; margin-bottom: 0.25rem;">3 hari yang lalu</small>
                  <div class="timeline-text" style="color: #1f2937; font-size: 0.875rem; font-weight: 500;">Update profil</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Status Management -->
      <div class="form-col-6" style="flex: 1; min-width: 300px;">
        <div class="form-card" style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); overflow: hidden; animation: fadeInUp 0.5s ease forwards; animation-delay: 0.1s;">
          <div class="form-card-header" style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
            <h5 class="form-card-title" style="font-size: 1.125rem; font-weight: 700; color: #1f2937; margin: 0;">Kelola Status</h5>
          </div>
          <div class="form-card-body" style="padding: 1.5rem;">
            <form id="statusForm" class="admin-form">
              <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="font-weight: 600; color: #4b5563; margin-bottom: 0.5rem; display: block;">Status Pengguna</label>
                <div class="status-toggle" style="display: flex; flex-direction: column; gap: 1rem; margin: 1rem 0 1.5rem 0;">
                  <div class="status-option active" onclick="selectStatus('active')" style="padding: 1.25rem; border: 2px solid #22c55e; border-radius: 12px; cursor: pointer; transition: all 0.3s ease; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); position: relative; box-shadow: 0 4px 12px rgba(34, 197, 94, 0.15);">
                    <input type="radio" name="status" value="active" id="active" checked style="display: none;">
                    <div class="status-label status-active" style="font-weight: 700; font-size: 1rem; margin-bottom: 0.375rem; display: flex; align-items: center; gap: 0.5rem; color: #22c55e;">
                      <div style="content: ''; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 0 2px #22c55e; background-color: #22c55e;"></div>
                      Aktif
                    </div>
                    <div class="status-description" style="font-size: 0.875rem; color: #64748b; line-height: 1.4;">Pengguna dapat mengakses sistem</div>
                  </div>
                  <div class="status-option" onclick="selectStatus('inactive')" style="padding: 1.25rem; border: 2px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.3s ease; background: white; position: relative;">
                    <input type="radio" name="status" value="inactive" id="inactive" style="display: none;">
                    <div class="status-label status-inactive" style="font-weight: 700; font-size: 1rem; margin-bottom: 0.375rem; display: flex; align-items: center; gap: 0.5rem; color: #ef4444;">
                      <div style="content: ''; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 0 2px #ef4444; background-color: #ef4444;"></div>
                      Tidak Aktif
                    </div>
                    <div class="status-description" style="font-size: 0.875rem; color: #64748b; line-height: 1.4;">Pengguna tidak dapat mengakses sistem</div>
                  </div>
                </div>
              </div>

              <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="font-weight: 600; color: #4b5563; margin-bottom: 0.5rem; display: block;">Catatan (Opsional)</label>
                <textarea class="form-textarea" rows="3" placeholder="Tambahkan catatan untuk perubahan status..." style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.875rem; transition: all 0.3s ease; resize: vertical; font-family: inherit;"></textarea>
              </div>

              <div class="form-actions-vertical" style="display: flex; flex-direction: column; gap: 0.875rem; margin-top: 2rem;">
                <button type="submit" class="form-btn form-btn-primary" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 0.875rem; cursor: pointer; transition: all 0.3s ease; text-align: center;">Simpan Perubahan</button>
                <button type="button" class="form-btn form-btn-secondary" onclick="resetPassword()" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); color: #374151; border: 1px solid #d1d5db; border-radius: 8px; font-weight: 600; font-size: 0.875rem; cursor: pointer; transition: all 0.3s ease; text-align: center;">Reset Password</button>
                <button type="button" class="form-btn form-btn-danger" onclick="deleteUser()" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 0.875rem; cursor: pointer; transition: all 0.3s ease; text-align: center;">Hapus Pengguna</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* Status Toggle Specific Styles */
.status-option {
    transition: all 0.3s ease !important;
    cursor: pointer !important;
    user-select: none;
}

.status-option:hover {
    transform: translateY(-2px) !important;
    border-color: #94a3b8 !important;
}

.status-option.active {
    border-color: #22c55e !important;
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important;
    box-shadow: 0 4px 12px rgba(34, 197, 94, 0.15) !important;
}

.status-option.inactive {
    border-color: #ef4444 !important;
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%) !important;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15) !important;
}

/* Ensure radio buttons are properly hidden */
.status-option input[type="radio"] {
    display: none !important;
}

/* Visual feedback for click */
.status-option:active {
    transform: translateY(0px) !important;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Add animation on page load
    $('.card').each(function(index) {
        $(this).delay(index * 100).fadeIn(500);
    });
    
    // Add click event listeners to status options
    document.querySelectorAll('.status-option').forEach(option => {
        option.addEventListener('click', function() {
            const isActive = this.querySelector('#active');
            if (isActive) {
                selectStatus('active');
            } else {
                selectStatus('inactive');
            }
        });
    });
    
    console.log('Status toggle initialized'); // Debug log
});

// Status selection function
function selectStatus(status) {
    console.log('selectStatus called with:', status); // Debug log
    
    // Remove active and inactive classes from all options
    document.querySelectorAll('.status-option').forEach(option => {
        option.classList.remove('active', 'inactive');
        // Reset styles
        option.style.borderColor = '#e2e8f0';
        option.style.background = 'white';
        option.style.boxShadow = 'none';
    });

    // Add appropriate class and styles to selected option
    if (status === 'active') {
        const activeOption = document.querySelector('.status-option:first-child');
        activeOption.classList.add('active');
        activeOption.style.borderColor = '#22c55e';
        activeOption.style.background = 'linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%)';
        activeOption.style.boxShadow = '0 4px 12px rgba(34, 197, 94, 0.15)';
        document.getElementById('active').checked = true;
        console.log('Active status selected'); // Debug log
    } else {
        const inactiveOption = document.querySelector('.status-option:last-child');
        inactiveOption.classList.add('inactive');
        inactiveOption.style.borderColor = '#ef4444';
        inactiveOption.style.background = 'linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%)';
        inactiveOption.style.boxShadow = '0 4px 12px rgba(239, 68, 68, 0.15)';
        document.getElementById('inactive').checked = true;
        console.log('Inactive status selected'); // Debug log
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