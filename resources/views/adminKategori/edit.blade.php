@extends('layouts.app2')

@section('content')
<div class="content-wrapper">
  <div class="container-fluid">

    <!-- Breadcrumb -->
    <div class="breadcrumb-section mb-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-success">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.kategori.index') }}" class="text-success">Kategori</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit Kategori</li>
        </ol>
      </nav>
    </div>

    <!-- Page Header -->
    <div class="mb-4">
      <h2 class="page-title">Edit Kategori</h2>
      <p class="page-subtitle">Edit kategori permainan billiard</p>
    </div>

    <!-- Form Card -->
    <div class="card">
      <div class="card-header bg-light">
        <h5 class="card-title mb-0">Form Edit Kategori</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.kategori.update', $category->id) }}" method="POST" enctype="multipart/form-data" id="kategoriForm">
          @csrf
          @method('PUT')
          
          <div class="form-group mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                   placeholder="Masukkan nama kategori" value="{{ old('nama', $category->nama) }}" required />
            @error('nama')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="form-group mb-3">
            <label class="form-label">Thumbnail</label>
            <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*" />
            <small class="form-text text-muted">Format: JPG, PNG, WEBP (Max: 2MB) - Kosongkan jika tidak ingin mengubah</small>
            @error('thumbnail')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            
            @if($category->thumbnail)
              <div class="current-image mt-2">
                <p class="mb-1"><strong>Thumbnail saat ini:</strong></p>
                <img src="{{ asset('storage/categories/' . $category->thumbnail) }}" alt="{{ $category->nama }}" 
                     style="max-width: 150px; max-height: 100px; border-radius: 6px; border: 1px solid #dee2e6;">
              </div>
            @endif
          </div>
          
          <div class="form-actions mt-4">
            <button type="submit" class="btn btn-success me-2">Update</button>
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Kembali</a>
          </div>
          
        </form>
      </div>
    </div>

  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/adminKategori.css') }}">
<style>
/* Simple clean form styling */
.card {
  border: 1px solid #dee2e6;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  max-width: 600px;
}

.card-header {
  background-color: #f8f9fa !important;
  border-bottom: 1px solid #dee2e6;
  padding: 15px 20px;
}

.card-title {
  color: #495057;
  font-weight: 600;
  font-size: 1.1rem;
  margin: 0;
}

.card-body {
  padding: 30px;
}

.form-group {
  margin-bottom: 20px;
}

.form-label {
  font-weight: 500;
  color: #374151;
  margin-bottom: 8px;
  display: block;
}

.form-control {
  border: 1px solid #d1d5db;
  border-radius: 6px;
  padding: 10px 12px;
  font-size: 0.9rem;
  width: 100%;
  box-sizing: border-box;
}

.form-control:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  outline: none;
}

.form-control.is-invalid {
  border-color: #dc3545;
}

.invalid-feedback {
  color: #dc3545;
  font-size: 0.8rem;
  margin-top: 5px;
  display: block;
}

.form-text {
  font-size: 0.8rem;
  color: #6b7280 !important;
  margin-top: 5px;
  display: block;
}

.current-image {
  margin-top: 10px;
  padding: 10px;
  background-color: #f8f9fa;
  border-radius: 6px;
}

.form-actions {
  margin-top: 30px;
  text-align: left;
}

.btn {
  padding: 10px 20px;
  font-size: 0.9rem;
  border-radius: 6px;
  font-weight: 500;
  border: none;
  cursor: pointer;
  text-decoration: none;
  display: inline-block;
}

.btn-success {
  background-color: #22c55e;
  color: white;
}

.btn-success:hover {
  background-color: #16a34a;
  color: white;
}

.btn-secondary {
  background-color: #6b7280;
  color: white;
}

.btn-secondary:hover {
  background-color: #4b5563;
  color: white;
  text-decoration: none;
}

.me-2 {
  margin-right: 10px;
}

.mt-4 {
  margin-top: 1.5rem;
}

.mb-3 {
  margin-bottom: 1rem;
}

/* Responsive */
@media (max-width: 768px) {
  .card-body {
    padding: 20px;
  }
  
  .btn {
    width: 100%;
    margin-bottom: 10px;
  }
  
  .me-2 {
    margin-right: 0;
  }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
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
                        <p class="mb-1"><strong>Preview baru:</strong></p>
                        <img src="${e.target.result}" alt="Preview" style="max-width: 150px; max-height: 100px; border-radius: 6px; border: 1px solid #dee2e6;">
                    </div>
                `;
                $('.current-image').after(preview);
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush