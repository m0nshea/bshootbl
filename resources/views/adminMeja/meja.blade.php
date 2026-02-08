@extends('layouts.app2')

@section('content')
<div class="content-wrapper">
  <div class="container-fluid">

    <!-- Breadcrumb -->
    <div class="breadcrumb-section mb-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-success">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Meja</li>
        </ol>
      </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header mb-3">
      <div class="page-text">
        <h3 class="page-title mb-1">Kelola Meja</h3>
        <p class="page-subtitle mb-0">Manajemen meja billiard dan status ketersediaan</p>
      </div>

      <div class="page-action">
        <a href="{{ route('admin.meja.create') }}" class="btn btn-success btn-sm">
          <i class="fas fa-plus me-1"></i> Tambah Meja
        </a>
      </div>
    </div>

    <!-- Main Content Card -->
    <div class="card">
      <div class="card-header">
        <h4 class="card-title mb-0">Daftar Meja</h4>
      </div>
      <div class="card-body">
        
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
        
        <div class="table-responsive">
          <table id="datatable" class="table table-hover align-middle w-100" style="table-layout: fixed;">
            <thead class="text-center">
              <tr>
                <th width="4%" style="width: 4% !important;">NO</th>
                <th width="13%" style="width: 13% !important;">NAMA MEJA</th>
                <th width="13%" style="width: 13% !important;">LANTAI</th>
                <th width="13%" style="width: 13% !important;">KATEGORI</th>
                <th width="13%" style="width: 13% !important;">HARGA/JAM</th>
                <th width="12%" style="width: 12% !important;">STATUS</th>
                <th width="10%" style="width: 10% !important;">FOTO</th>
                <th width="8%" style="width: 8% !important;">AKSI</th>
              </tr>
            </thead>
            <tbody>
              @forelse($mejas as $index => $meja)
                <tr>
                  <td class="text-center fw-bold">{{ $mejas->firstItem() + $index }}</td>
                  <td><span class="fw-semibold">{{ $meja->nama_meja }}</span></td>
                  <td class="text-center">
                    <span class="fw-semibold">Lantai {{ $meja->lantai ?? '1' }}</span>
                  </td>
                  <td class="text-center">
                    <span class="fw-semibold-{{ $meja->category->nama == 'VIP' ? 'warning' : ($meja->category->nama == '8 Ball' ? 'primary' : ($meja->category->nama == '9 Ball' ? 'success' : 'info')) }}">
                      {{ $meja->category->nama }}
                    </span>
                  </td>
                  <td class="text-center"><span class="fw-bold text-success">{{ $meja->formatted_harga }}</span></td>
                  <td class="text-center"><span class="fw-semibold {{ $meja->status_badge }}">{{ $meja->status_text }}</span></td>
                  <td class="text-center">
                    <img src="{{ $meja->foto_url }}" alt="{{ $meja->nama_meja }}" class="table-image shadow-sm" style="width: 60px; height: 45px; object-fit: cover;" />
                  </td>
                  <td class="text-center align-middle">
                    <div style="display:flex; justify-content:center; gap:8px;">
                      <button type="button"
                              style="width:40px; height:40px; border:none; border-radius:4px; background-color:#0d6efd; color:#fff; font-size:16px; cursor:pointer; display:flex; align-items:center; justify-content:center;"
                              title="Edit meja"
                              onclick="window.location='{{ route('admin.meja.edit', $meja->id) }}'">
                        ✏️
                      </button>
                      <button type="button"
                              style="width:40px; height:40px; border:none; border-radius:4px; background-color:#dc3545; color:#fff; font-size:16px; cursor:pointer; display:flex; align-items:center; justify-content:center;"
                              onclick="deleteTable({{ $meja->id }})"
                              title="Hapus meja">
                        🗑️
                      </button>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" class="text-center py-4">
                    <div class="text-muted">
                      <i class="fas fa-inbox fa-3x mb-3"></i>
                      <p>Belum ada meja yang ditambahkan</p>
                      <a href="{{ route('admin.meja.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Meja Pertama
                      </a>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        
        <!-- Pagination Info -->
        @if($mejas->hasPages())
          <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; border-top: 1px solid #dee2e6; background-color: #f8f9fa;">
            <div style="display: flex; align-items: center;">
              <small style="color: #6c757d;">
                Menampilkan {{ $mejas->firstItem() }} sampai {{ $mejas->lastItem() }} 
                dari {{ $mejas->total() }} data
              </small>
            </div>
            <div style="display: flex; justify-content: flex-end; align-items: center;">
              <nav aria-label="Page navigation">
                <ul style="display: flex; list-style: none; padding: 0; margin: 0; gap: 4px;">
                  {{-- Previous Page Link --}}
                  @if ($mejas->onFirstPage())
                    <li style="display: inline-block;">
                      <span style="display: flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0.375rem 0.75rem; font-size: 0.875rem; font-weight: 500; color: #6c757d; background-color: #fff; border: 1px solid #dee2e6; border-radius: 6px; opacity: 0.5; cursor: not-allowed;">‹</span>
                    </li>
                  @else
                    <li style="display: inline-block;">
                      <a href="{{ $mejas->previousPageUrl() }}" rel="prev" style="display: flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0.375rem 0.75rem; font-size: 0.875rem; font-weight: 500; color: #495057; background-color: #fff; border: 1px solid #dee2e6; border-radius: 6px; text-decoration: none; transition: all 0.2s ease;">‹</a>
                    </li>
                  @endif

                  {{-- Pagination Elements --}}
                  @foreach ($mejas->getUrlRange(1, $mejas->lastPage()) as $page => $url)
                    @if ($page == $mejas->currentPage())
                      <li style="display: inline-block;">
                        <span style="display: flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0.375rem 0.75rem; font-size: 0.875rem; font-weight: 600; color: #fff; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: 1px solid #28a745; border-radius: 6px; box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3); cursor: default;">{{ $page }}</span>
                      </li>
                    @else
                      <li style="display: inline-block;">
                        <a href="{{ $url }}" style="display: flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0.375rem 0.75rem; font-size: 0.875rem; font-weight: 500; color: #495057; background-color: #fff; border: 1px solid #dee2e6; border-radius: 6px; text-decoration: none; transition: all 0.2s ease;">{{ $page }}</a>
                      </li>
                    @endif
                  @endforeach

                  {{-- Next Page Link --}}
                  @if ($mejas->hasMorePages())
                    <li style="display: inline-block;">
                      <a href="{{ $mejas->nextPageUrl() }}" rel="next" style="display: flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0.375rem 0.75rem; font-size: 0.875rem; font-weight: 500; color: #495057; background-color: #fff; border: 1px solid #dee2e6; border-radius: 6px; text-decoration: none; transition: all 0.2s ease;">›</a>
                    </li>
                  @else
                    <li style="display: inline-block;">
                      <span style="display: flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0.375rem 0.75rem; font-size: 0.875rem; font-weight: 500; color: #6c757d; background-color: #fff; border: 1px solid #dee2e6; border-radius: 6px; opacity: 0.5; cursor: not-allowed;">›</span>
                    </li>
                  @endif
                </ul>
              </nav>
            </div>
          </div>
        @endif
      </div>
    </div>

  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/adminMeja.css') }}">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<style>
.status-badge {
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 0.8rem;
  font-weight: 500;
}

.status-available {
  background-color: #d1fae5;
  color: #065f46;
}

.status-occupied {
  background-color: #fee2e2;
  color: #991b1b;
}

.status-maintenance {
  background-color: #fef3c7;
  color: #92400e;
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

/* Force table column widths */
#datatable {
  table-layout: fixed !important;
  width: 100% !important;
}

#datatable th:nth-child(1) { width: 4% !important; }
#datatable th:nth-child(2) { width: 13% !important; }
#datatable th:nth-child(3) { width: 13% !important; }
#datatable th:nth-child(4) { width: 13% !important; }
#datatable th:nth-child(5) { width: 13% !important; }
#datatable th:nth-child(6) { width: 12% !important; }
#datatable th:nth-child(7) { width: 10% !important; }
#datatable th:nth-child(8) { width: 8% !important; }

#datatable td:nth-child(1) { width: 4% !important; }
#datatable td:nth-child(2) { width: 13% !important; }
#datatable td:nth-child(3) { width: 13% !important; }
#datatable td:nth-child(4) { width: 13% !important; }
#datatable td:nth-child(5) { width: 13% !important; }
#datatable td:nth-child(6) { width: 12% !important; }
#datatable td:nth-child(7) { width: 10% !important; }
#datatable td:nth-child(8) { width: 8% !important; }

/* Pagination Container */
.pagination-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 1.5rem;
  border-top: 1px solid #dee2e6;
  background-color: #f8f9fa;
}

.pagination-info {
  display: flex;
  align-items: center;
}

/* Pagination Styling */
.pagination-wrapper {
  display: flex;
  justify-content: flex-end;
  align-items: center;
}

.pagination-wrapper nav {
  display: flex;
}

.pagination {
  display: flex;
  list-style: none;
  padding: 0;
  margin: 0;
  gap: 4px;
}

.pagination .page-item {
  display: inline-block;
}

.pagination .page-link {
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 36px;
  height: 36px;
  padding: 0.375rem 0.75rem;
  font-size: 0.875rem;
  font-weight: 500;
  color: #495057;
  background-color: #fff;
  border: 1px solid #dee2e6;
  border-radius: 6px;
  text-decoration: none;
  transition: all 0.2s ease;
  cursor: pointer;
}

.pagination .page-link:hover {
  color: #28a745;
  background-color: #f8f9fa;
  border-color: #28a745;
  transform: translateY(-1px);
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.pagination .page-item.active .page-link {
  color: #fff;
  background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
  border-color: #28a745;
  font-weight: 600;
  box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
  cursor: default;
}

.pagination .page-item.disabled .page-link {
  color: #6c757d;
  background-color: #fff;
  border-color: #dee2e6;
  opacity: 0.5;
  cursor: not-allowed;
  pointer-events: none;
}

.pagination .page-link:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.15);
}

/* Responsive pagination */
@media (max-width: 576px) {
  .pagination .page-link {
    min-width: 32px;
    height: 32px;
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
  }
  
  .pagination {
    gap: 2px;
  }
}

/* Responsive pagination info */
@media (max-width: 768px) {
  .pagination-container {
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start !important;
  }
  
  .pagination-wrapper {
    width: 100%;
    justify-content: center;
  }
}
</style>
@endpush

@push('scripts')
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Delete meja function
function deleteTable(id) {
  Swal.fire({
    title: 'Yakin ingin menghapus?',
    text: "Data meja akan dihapus permanen!",
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
        text: 'Sedang menghapus meja',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      // Send delete request
      fetch(`/admin/meja/${id}`, {
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
          text: 'Terjadi kesalahan saat menghapus meja'
        });
      });
    }
  });
}

$(document).ready(function() {
  // Initialize DataTable
  $('#datatable').DataTable({
    responsive: true,
    language: {
      url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
    }
  });
  
  // Simple hover effects
  $('.table tbody tr').hover(
    function() {
      $(this).addClass('table-hover-effect');
    },
    function() {
      $(this).removeClass('table-hover-effect');
    }
  );
  
  // Pagination hover effects
  $('nav[aria-label="Page navigation"] a').hover(
    function() {
      if (!$(this).parent().hasClass('disabled')) {
        $(this).css({
          'color': '#28a745',
          'background-color': '#f8f9fa',
          'border-color': '#28a745',
          'transform': 'translateY(-1px)',
          'box-shadow': '0 2px 4px rgba(0,0,0,0.1)'
        });
      }
    },
    function() {
      if (!$(this).parent().hasClass('active')) {
        $(this).css({
          'color': '#495057',
          'background-color': '#fff',
          'border-color': '#dee2e6',
          'transform': 'translateY(0)',
          'box-shadow': 'none'
        });
      }
    }
  );
});
</script>
@endpush