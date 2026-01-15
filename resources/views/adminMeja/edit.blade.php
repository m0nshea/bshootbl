@extends('layouts.app2')

@section('content')
<div class="content-wrapper">
  <div class="container-fluid">

    <!-- Breadcrumb -->
    <div class="breadcrumb-section mb-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-success">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.meja.index') }}" class="text-success">Meja</a></li>
          <li class="breadcrumb-item active" aria-current="page">Edit Meja</li>
        </ol>
      </nav>
    </div>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="page-title">Edit Meja</h2>
        <p class="page-subtitle">Edit data meja billiard</p>
      </div>
      <div>
        <a href="{{ route('admin.meja.index') }}" class="btn btn-secondary">Kembali</a>
      </div>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm">
      <div class="card-header bg-light">
        <h4 class="card-title mb-0">Form Edit Meja</h4>
      </div>
      <div class="card-body p-4">
        <form action="{{ route('admin.meja.update', $meja->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="nama_meja" class="form-label fw-semibold">Nama Meja <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_meja') is-invalid @enderror" 
                       id="nama_meja" name="nama_meja" value="{{ old('nama_meja', $meja->nama_meja) }}" required>
                <div class="form-text">Contoh: Meja VIP 1, Meja A, dll.</div>
                @error('nama_meja')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="lantai" class="form-label fw-semibold">Lantai <span class="text-danger">*</span></label>
                <select class="form-select @error('lantai') is-invalid @enderror" 
                        id="lantai" name="lantai" required>
                  <option value="1" {{ old('lantai', $meja->lantai ?? '1') == '1' ? 'selected' : '' }}>Lantai 1</option>
                  <option value="2" {{ old('lantai', $meja->lantai ?? '1') == '2' ? 'selected' : '' }}>Lantai 2</option>
                  <option value="3" {{ old('lantai', $meja->lantai ?? '1') == '3' ? 'selected' : '' }}>Lantai 3</option>
                </select>
                @error('lantai')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="kategori" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('kategori') is-invalid @enderror" 
                       id="kategori" name="kategori" value="{{ old('kategori', $meja->category->nama ?? '') }}" 
                       placeholder="Contoh: VIP, Regular, Premium" required>
                <div class="form-text">Masukkan nama kategori meja</div>
                @error('kategori')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="harga" class="form-label fw-semibold">Harga per Jam <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text">Rp</span>
                  <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                         id="harga" name="harga" value="{{ old('harga', $meja->harga) }}" required>
                </div>
                <div class="form-text">Masukkan harga dalam rupiah</div>
                @error('harga')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                <select class="form-select @error('status') is-invalid @enderror" 
                        id="status" name="status" required>
                  <option value="available" {{ old('status', $meja->status) == 'available' ? 'selected' : '' }}>Tersedia</option>
                  <option value="occupied" {{ old('status', $meja->status) == 'occupied' ? 'selected' : '' }}>Terisi</option>
                  <option value="maintenance" {{ old('status', $meja->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
                @error('status')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="foto" class="form-label fw-semibold">Foto Meja</label>
            <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                   id="foto" name="foto" accept="image/*">
            <div class="form-text">Format: JPG, PNG, WEBP. Maksimal 2MB - Kosongkan jika tidak ingin mengubah</div>
            @error('foto')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            
            @if($meja->foto)
              <div class="current-image mt-3 p-3 bg-light rounded">
                <p class="mb-2 fw-semibold">Foto saat ini:</p>
                <img src="{{ $meja->foto_url }}" alt="{{ $meja->nama_meja }}" 
                     class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
              </div>
            @endif
          </div>

          <div class="mb-4">
            <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                      id="deskripsi" name="deskripsi" rows="4" 
                      placeholder="Deskripsi opsional tentang meja...">{{ old('deskripsi', $meja->deskripsi) }}</textarea>
            <div class="form-text">Deskripsi opsional tentang meja</div>
            @error('deskripsi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.meja.index') }}" class="btn btn-secondary px-4">Batal</a>
            <button type="submit" class="btn btn-success px-4">
              <i class="fas fa-save me-1"></i> Update Meja
            </button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/adminMeja.css') }}">
<style>
.card {
  border: none;
  border-radius: 10px;
  max-width: 900px;
  margin: 0 auto;
}

.card-header {
  border-bottom: 1px solid #e9ecef;
  border-radius: 10px 10px 0 0 !important;
}

.card-title {
  color: #495057;
  font-weight: 600;
  font-size: 1.2rem;
}

.form-label {
  color: #374151;
  margin-bottom: 8px;
}

.form-control, .form-select {
  border: 1px solid #d1d5db;
  border-radius: 8px;
  padding: 12px 15px;
  font-size: 0.95rem;
  transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
  border-color: #22c55e;
  box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
  outline: none;
}

.form-control.is-invalid, .form-select.is-invalid {
  border-color: #dc3545;
}

.invalid-feedback {
  color: #dc3545;
  font-size: 0.875rem;
  margin-top: 5px;
}

.form-text {
  font-size: 0.875rem;
  color: #6b7280;
  margin-top: 5px;
}

.input-group-text {
  background-color: #f8f9fa;
  border: 1px solid #d1d5db;
  border-right: none;
  padding: 12px 15px;
  font-size: 0.95rem;
}

.btn {
  padding: 12px 24px;
  font-size: 0.95rem;
  border-radius: 8px;
  font-weight: 500;
  border: none;
  cursor: pointer;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  transition: all 0.2s ease;
}

.btn-success {
  background-color: #22c55e;
  color: white;
}

.btn-success:hover {
  background-color: #16a34a;
  color: white;
  transform: translateY(-1px);
}

.btn-secondary {
  background-color: #6b7280;
  color: white;
}

.btn-secondary:hover {
  background-color: #4b5563;
  color: white;
  text-decoration: none;
  transform: translateY(-1px);
}

.current-image {
  border: 1px solid #e5e7eb;
}

.breadcrumb {
  background: none;
  padding: 0;
  margin: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
  content: "›";
  color: #6b7280;
}

.page-title {
  color: #1f2937;
  font-weight: 600;
  margin-bottom: 5px;
}

.page-subtitle {
  color: #6b7280;
  margin-bottom: 0;
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
  
  .d-flex.justify-content-end {
    flex-direction: column;
  }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Preview image when selected
    $('#foto').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Remove existing preview
                $('.image-preview').remove();
                
                // Add new preview
                const preview = `
                    <div class="image-preview mt-3 p-3 bg-light rounded">
                        <p class="mb-2 fw-semibold">Preview baru:</p>
                        <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                    </div>
                `;
                $('.current-image').length ? $('.current-image').after(preview) : $('#foto').after(preview);
            };
            reader.readAsDataURL(file);
        }
    });

    // Form validation
    $('form').on('submit', function(e) {
        let isValid = true;
        
        // Check required fields
        $(this).find('[required]').each(function() {
            if (!$(this).val()) {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Form Tidak Lengkap',
                text: 'Mohon lengkapi semua field yang wajib diisi'
            });
        }
    });
});
</script>
@endpush