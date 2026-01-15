@extends('layouts.app2')

@section('content')
<div class="content-wrapper">
  <div class="container-fluid">

    <!-- Breadcrumb -->
    <div class="breadcrumb-section mb-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Kategori</li>
        </ol>
      </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header mb-3">
      <div class="page-text">
        <h3 class="page-title mb-1">Kelola Kategori</h3>
        <p class="page-subtitle mb-0">Manajemen kategori permainan billiard</p>
      </div>

      <div class="page-action">
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-success btn-sm">
          <i class="fas fa-plus me-1"></i> Tambah Kategori
        </a>
      </div>
    </div>

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

    <!-- Table Card -->
    <div class="card shadow-sm">
      <div class="card-header bg-light py-2">
        <h5 class="card-title mb-0">Daftar Kategori</h5>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0 table-fixed">
            <thead class="table-primary">
              <tr>
                <th class="text-center" width="15%">NO</th>
                <th class="text-center" width="25%">THUMBNAIL</th>
                <th width="35%">NAMA KATEGORI</th>
                <th class="text-center" width="25%">AKSI</th>
              </tr>
            </thead>
            <tbody>
              @forelse($categories as $index => $category)
                <tr>
                  <td class="text-center align-middle">{{ $categories->firstItem() + $index }}</td>
                  <td class="text-center align-middle">
                    @if($category->thumbnail)
                      <img src="{{ asset('storage/categories/' . $category->thumbnail) }}" 
                           alt="{{ $category->nama }}" class="kategori-thumb" />
                    @else
                      <img src="{{ asset('img/default-category.jpg') }}" 
                           alt="Default" class="kategori-thumb" />
                    @endif
                  </td>
                  <td class="align-middle">{{ $category->nama }}</td>
                  <td class="text-center align-middle">
                    <a href="{{ route('admin.kategori.edit', $category->id) }}" class="btn btn-info btn-sm me-1">
                      <i class="fas fa-edit"></i> Edit
                    </a>
                    <button class="btn btn-danger btn-sm" onclick="deleteCategory({{ $category->id }})">
                      <i class="fas fa-trash"></i> Hapus
                    </button>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center py-4">
                    <div class="text-muted">
                      <i class="fas fa-inbox fa-3x mb-3"></i>
                      <p>Belum ada kategori yang ditambahkan</p>
                      <a href="{{ route('admin.kategori.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Kategori Pertama
                      </a>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        
        <!-- Pagination Info -->
        @if($categories->hasPages())
          <div class="d-flex justify-content-between align-items-center p-3 border-top">
            <small class="text-muted">
              Menampilkan {{ $categories->firstItem() }} sampai {{ $categories->lastItem() }} 
              dari {{ $categories->total() }} data
            </small>
            <div class="d-flex gap-1">
              {{ $categories->links('pagination::bootstrap-4') }}
            </div>
          </div>
        @endif
      </div>
    </div>

  </div>
</div>

<!-- Delete Form (Hidden) -->
<form id="delete-form" method="POST" style="display: none;">
  @csrf
  @method('DELETE')
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Delete category function
function deleteCategory(id) {
  Swal.fire({
    title: 'Yakin ingin menghapus?',
    text: "Data kategori akan dihapus permanen!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      // Show loading
      Swal.fire({
        title: 'Menghapus...',
        text: 'Sedang menghapus kategori',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      // Send delete request
      fetch(`/admin/kategori/${id}`, {
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
          text: 'Terjadi kesalahan saat menghapus kategori'
        });
      });
    }
  });
}

$(document).ready(function() {
  // Simple hover effects
  $('.table tbody tr').hover(
    function() {
      $(this).addClass('table-hover-effect');
    },
    function() {
      $(this).removeClass('table-hover-effect');
    }
  );
});
</script>
@endpush

@push('styles')
<style>
.kategori-thumb {
  width: 60px;
  height: 40px;
  object-fit: cover;
  border-radius: 4px;
  border: 1px solid #dee2e6;
}

.table-hover-effect {
  background-color: #f8f9fa !important;
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

.btn-close {
  background: none;
  border: none;
  font-size: 1.2rem;
  opacity: 0.5;
}

.btn-close:hover {
  opacity: 1;
}
</style>
@endpush