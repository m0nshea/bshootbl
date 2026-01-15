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
          <li class="breadcrumb-item active" aria-current="page">Tambah Pengguna</li>
        </ol>
      </nav>
    </div>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="page-title">Tambah Pengguna Baru</h2>
        <p class="page-subtitle">Tambahkan pengguna baru ke sistem</p>
      </div>
      <div>
        <a href="{{ route('admin.pengguna') }}" class="btn btn-secondary">Kembali</a>
      </div>
    </div>

    <!-- Form Card -->
    <div class="card">
      <div class="card-header">
        <h4 class="card-title mb-0">Form Tambah Pengguna</h4>
      </div>
      <div class="card-body">
        <form action="#" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama" name="nama" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="no_hp" class="form-label">No. HP <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="no_hp" name="no_hp" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                <select class="form-select" id="role" name="role" required>
                  <option value="">Pilih Role</option>
                  <option value="admin">Admin</option>
                  <option value="vip">VIP</option>
                  <option value="user">User</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select" id="status" name="status" required>
                  <option value="active">Aktif</option>
                  <option value="inactive">Tidak Aktif</option>
                </select>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="avatar" class="form-label">Avatar</label>
            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
            <div class="form-text">Format: JPG, PNG, WEBP. Maksimal 2MB</div>
          </div>

          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
            <div class="form-text">Deskripsi opsional tentang pengguna</div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.pengguna') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-success">Simpan Pengguna</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/adminPengguna.css') }}">
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