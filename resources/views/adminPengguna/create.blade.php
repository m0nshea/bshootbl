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
          <li class="breadcrumb-item active" aria-current="page">Tambah Pengguna</li>
        </ol>
      </nav>
    </div>

    <!-- Page Header -->
    <div class="form-header">
      <div>
        <h2 class="form-title">Tambah Pengguna Baru</h2>
        <p class="form-subtitle">Tambahkan pengguna baru ke sistem</p>
      </div>
      <div>
        <a href="{{ route('admin.pengguna') }}" class="form-btn form-btn-secondary">Kembali</a>
      </div>
    </div>

    <!-- Form Card -->
    <div class="form-card">
      <div class="form-card-header">
        <h4 class="form-card-title">Form Tambah Pengguna</h4>
      </div>
      <div class="form-card-body">
        <form action="#" method="POST" enctype="multipart/form-data" class="admin-form">
          @csrf
          
          <div class="form-row">
            <div class="form-col-6">
              <div class="form-group">
                <label for="nama" class="form-label">Nama Lengkap <span class="form-required">*</span></label>
                <input type="text" class="form-input" id="nama" name="nama" 
                       placeholder="Masukkan nama lengkap" required>
                <div class="form-help">Nama lengkap pengguna</div>
              </div>
            </div>
            <div class="form-col-6">
              <div class="form-group">
                <label for="email" class="form-label">Email <span class="form-required">*</span></label>
                <input type="email" class="form-input" id="email" name="email" 
                       placeholder="contoh@email.com" required>
                <div class="form-help">Email untuk login dan notifikasi</div>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-col-6">
              <div class="form-group">
                <label for="no_hp" class="form-label">No. HP <span class="form-required">*</span></label>
                <input type="tel" class="form-input" id="no_hp" name="no_hp" 
                       placeholder="08123456789" required>
                <div class="form-help">Nomor HP untuk kontak</div>
              </div>
            </div>
            <div class="form-col-6">
              <div class="form-group">
                <label for="role" class="form-label">Role <span class="form-required">*</span></label>
                <select class="form-select" id="role" name="role" required>
                  <option value="">Pilih Role</option>
                  <option value="admin">Admin</option>
                  <option value="vip">VIP</option>
                  <option value="user">User</option>
                </select>
                <div class="form-help">Hak akses pengguna dalam sistem</div>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-col-6">
              <div class="form-group">
                <label for="password" class="form-label">Password <span class="form-required">*</span></label>
                <input type="password" class="form-input" id="password" name="password" 
                       placeholder="Minimal 8 karakter" required>
                <div class="form-help">Password minimal 8 karakter</div>
              </div>
            </div>
            <div class="form-col-6">
              <div class="form-group">
                <label for="status" class="form-label">Status <span class="form-required">*</span></label>
                <select class="form-select" id="status" name="status" required>
                  <option value="active">Aktif</option>
                  <option value="inactive">Tidak Aktif</option>
                </select>
                <div class="form-help">Status aktif pengguna</div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="avatar" class="form-label">Avatar</label>
            <input type="file" class="form-file" id="avatar" name="avatar" accept="image/*">
            <div class="form-help">Format: JPG, PNG, WEBP. Maksimal 2MB</div>
          </div>

          <div class="form-group">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-textarea" id="deskripsi" name="deskripsi" rows="3" 
                      placeholder="Deskripsi opsional tentang pengguna..."></textarea>
            <div class="form-help">Deskripsi opsional tentang pengguna</div>
          </div>

          <div class="form-actions">
            <a href="{{ route('admin.pengguna') }}" class="form-btn form-btn-secondary">Batal</a>
            <button type="submit" class="form-btn form-btn-primary">
              <i class="fas fa-save"></i> Simpan Pengguna
            </button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Preview avatar when selected
    $('#avatar').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Remove existing preview
                $('.avatar-preview').remove();
                
                // Add new preview
                const preview = `
                    <div class="avatar-preview mt-2">
                        <img src="${e.target.result}" alt="Preview" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 2px solid #dee2e6;">
                    </div>
                `;
                $('#avatar').after(preview);
            };
            reader.readAsDataURL(file);
        }
    });

    // Form validation
    $('form').submit(function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Simpan Pengguna?',
            text: 'Data pengguna akan disimpan ke sistem',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#22c55e',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Pengguna berhasil ditambahkan.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    // Redirect to pengguna list
                    window.location.href = '{{ route("admin.pengguna") }}';
                });
            }
        });
    });
});
</script>
@endpush