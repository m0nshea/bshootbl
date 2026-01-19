@extends('layouts.app2')

@section('content')
<div class="form-wrapper">
  <div class="form-container">

    <!-- Breadcrumb -->
    <div class="form-breadcrumb mb-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-success">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.meja.index') }}" class="text-success">Meja</a></li>
          <li class="breadcrumb-item active" aria-current="page">Tambah Meja</li>
        </ol>
      </nav>
    </div>

    <!-- Page Header -->
    <div class="form-header mb-4">
      <div class="form-header-content">
        <h2 class="form-title">Tambah Meja Baru</h2>
        <p class="form-subtitle">Tambahkan meja billiard baru ke sistem</p>
      </div>
      <div class="form-header-actions">
        <a href="{{ route('admin.meja.index') }}" class="form-btn form-btn-secondary">Kembali</a>
      </div>
    </div>

    <!-- Form Card -->
    <div class="form-card">
      <div class="form-card-header">
        <h4 class="form-card-title">Form Tambah Meja</h4>
      </div>
      <div class="form-card-body">
        <form action="{{ route('admin.meja.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
          @csrf
          
          <div class="form-row">
            <div class="form-col-6">
              <div class="form-group">
                <label for="nama_meja" class="form-label">Nama Meja <span class="form-required">*</span></label>
                <input type="text" class="form-input @error('nama_meja') form-input-error @enderror" 
                       id="nama_meja" name="nama_meja" value="{{ old('nama_meja') }}" required>
                <div class="form-help">Contoh: Meja VIP 1, Meja A, dll.</div>
                @error('nama_meja')
                  <div class="form-error">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="form-col-6">
              <div class="form-group">
                <label for="lantai" class="form-label">Lantai <span class="form-required">*</span></label>
                <select class="form-select @error('lantai') form-input-error @enderror" 
                        id="lantai" name="lantai" required>
                  <option value="1" {{ old('lantai') == '1' ? 'selected' : '' }}>Lantai 1</option>
                  <option value="2" {{ old('lantai') == '2' ? 'selected' : '' }}>Lantai 2</option>
                  <option value="3" {{ old('lantai') == '3' ? 'selected' : '' }}>Lantai 3</option>
                </select>
                @error('lantai')
                  <div class="form-error">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-col-6">
              <div class="form-group">
                <label for="kategori" class="form-label">Kategori <span class="form-required">*</span></label>
                <select class="form-select @error('kategori') form-input-error @enderror" 
                        id="kategori" name="kategori" required>
                  <option value="">Pilih Kategori</option>
                  @foreach($categories as $category)
                    <option value="{{ $category->nama }}" {{ old('kategori') == $category->nama ? 'selected' : '' }}>
                      {{ $category->nama }}
                    </option>
                  @endforeach
                </select>
                <div class="form-help">Pilih kategori meja yang tersedia</div>
                @error('kategori')
                  <div class="form-error">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="form-col-6">
              <div class="form-group">
                <label for="harga" class="form-label">Harga per Jam <span class="form-required">*</span></label>
                <div class="form-input-group">
                  <span class="form-input-prefix">Rp</span>
                  <input type="number" class="form-input form-input-with-prefix @error('harga') form-input-error @enderror" 
                         id="harga" name="harga" value="{{ old('harga') }}" required>
                </div>
                <div class="form-help">Masukkan harga dalam rupiah</div>
                @error('harga')
                  <div class="form-error">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-col-6">
              <div class="form-group">
                <label for="status" class="form-label">Status <span class="form-required">*</span></label>
                <select class="form-select @error('status') form-input-error @enderror" 
                        id="status" name="status" required>
                  <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                  <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Terisi</option>
                  <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Direservasi</option>
                  <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
                @error('status')
                  <div class="form-error">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="foto" class="form-label">Foto Meja</label>
            <input type="file" class="form-file @error('foto') form-input-error @enderror" 
                   id="foto" name="foto" accept="image/*">
            <div class="form-help">Format: JPG, PNG, WEBP. Maksimal 2MB</div>
            @error('foto')
              <div class="form-error">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-textarea @error('deskripsi') form-input-error @enderror" 
                      id="deskripsi" name="deskripsi" rows="4" 
                      placeholder="Deskripsi opsional tentang meja...">{{ old('deskripsi') }}</textarea>
            <div class="form-help">Deskripsi opsional tentang meja</div>
            @error('deskripsi')
              <div class="form-error">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-actions">
            <a href="{{ route('admin.meja.index') }}" class="form-btn form-btn-secondary">Batal</a>
            <button type="submit" class="form-btn form-btn-primary">
              <i class="fas fa-save me-1"></i> Simpan Meja
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
                        <p class="mb-2 fw-semibold">Preview:</p>
                        <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                    </div>
                `;
                $('#foto').after(preview);
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