@extends('layouts.app2')

@section('content')
<div class="form-wrapper">
  <div class="form-container">

    <!-- Breadcrumb -->
    <div class="form-breadcrumb mb-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.kategori.index') }}">Kategori</a></li>
          <li class="breadcrumb-item active" aria-current="page">Tambah Kategori</li>
        </ol>
      </nav>
    </div>

    <!-- Page Header -->
    <div class="form-header">
      <div>
        <h2 class="form-title">Tambah Kategori</h2>
        <p class="form-subtitle">Tambah kategori permainan billiard baru</p>
      </div>
      <div>
        <a href="{{ route('admin.kategori.index') }}" class="form-btn form-btn-secondary">Kembali</a>
      </div>
    </div>

    <!-- Form Card -->
    <div class="form-card">
      <div class="form-card-header">
        <h4 class="form-card-title">Form Tambah Kategori</h4>
      </div>
      <div class="form-card-body">
        <form action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data" class="admin-form" id="kategoriForm">
          @csrf
          
          <div class="form-group">
            <label for="nama" class="form-label">Nama Kategori <span class="form-required">*</span></label>
            <input type="text" class="form-input @error('nama') form-input-error @enderror" 
                   id="nama" name="nama" value="{{ old('nama') }}" 
                   placeholder="Masukkan nama kategori" required>
            <div class="form-help">Contoh: VIP, Regular, Premium, dll.</div>
            @error('nama')
              <div class="form-error">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="harga_per_jam" class="form-label">Harga per Jam <span class="form-required">*</span></label>
            <div class="input-group">
              <span class="input-group-text">Rp</span>
              <input type="number" class="form-input @error('harga_per_jam') form-input-error @enderror" 
                     id="harga_per_jam" name="harga_per_jam" value="{{ old('harga_per_jam') }}" 
                     placeholder="0" min="0" step="1000" required>
            </div>
            <div class="form-help">Contoh: 50000 untuk Rp 50.000 per jam</div>
            @error('harga_per_jam')
              <div class="form-error">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="form-group">
            <label for="thumbnail" class="form-label">Thumbnail <span class="form-required">*</span></label>
            <input type="file" class="form-file @error('thumbnail') form-input-error @enderror" 
                   id="thumbnail" name="thumbnail" accept="image/*" required>
            <div class="form-help">Format: JPG, PNG, WEBP. Maksimal 2MB</div>
            @error('thumbnail')
              <div class="form-error">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="form-actions">
            <a href="{{ route('admin.kategori.index') }}" class="form-btn form-btn-secondary">Batal</a>
            <button type="submit" class="form-btn form-btn-primary">
              <i class="fas fa-save"></i> Simpan Kategori
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    // Form validation
    $('#kategoriForm').on('submit', function(e) {
        e.preventDefault();
        
        const nama = $('input[name="nama"]').val().trim();
        const hargaPerJam = $('input[name="harga_per_jam"]').val();
        const thumbnail = $('input[name="thumbnail"]')[0].files[0];

        if (!nama) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Nama kategori harus diisi!'
            });
            return;
        }

        if (!hargaPerJam || hargaPerJam < 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Harga per jam harus diisi dan tidak boleh kurang dari 0!'
            });
            return;
        }

        if (!thumbnail) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Thumbnail harus dipilih!'
            });
            return;
        }

        // Check file size (2MB max)
        if (thumbnail.size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Ukuran file maksimal 2MB!'
            });
            return;
        }

        // Simulate save process
        Swal.fire({
            title: 'Menyimpan...',
            text: 'Sedang menyimpan kategori baru',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Submit form
        this.submit();
    });

    // Preview image when selected
    $('input[name="thumbnail"]').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Remove existing preview
                $('.image-preview').remove();
                
                // Add new preview
                const preview = `
                    <div class="image-preview mt-2">
                        <img src="${e.target.result}" alt="Preview" style="max-width: 150px; max-height: 100px; border-radius: 6px; border: 1px solid #dee2e6;">
                    </div>
                `;
                $('input[name="thumbnail"]').after(preview);
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush