@extends('layouts.app2')

@section('content')
<div class="container-fluid py-4">
    <!-- Breadcrumb -->
    <div class="breadcrumb-section mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-success">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tarif Meja</li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title mb-1">Kelola Tarif Meja</h2>
                <p class="page-subtitle mb-0 text-muted">Manajemen harga sewa meja billiard per jam</p>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="filter-card mb-4" style="margin-left:15px;">
        <div class="row align-items-center" style="display: flex; align-items: center; padding: 5px;">
            <div class="col-md-4">
                <select class="form-select form-select-lg" id="categoryFilter" style="margin-top: 10px;">
                    <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->nama }}</option>
                        @endforeach
               </select>
            </div>
        </div>
    </div>

    <!-- Main Table -->
    <div class="table-card">
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <form id="tarifForm">
                        @csrf
                        <table class="table table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center" style="width: 60px;">NO</th>
                                    <th style="width: 250px;">NAMA MEJA</th>
                                    <th class="text-center" style="width: 120px;">KATEGORI</th>
                                    <th class="text-center" style="width: 100px;">LANTAI</th>
                                    <th class="text-center" style="width: 120px;">STATUS</th>
                                    <th class="text-center" style="width: 180px;">HARGA PER JAM</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mejas as $index => $meja)
                                    <tr data-category="{{ $meja->category_id }}">
                                        <td class="text-center fw-bold">
                                            {{ $index + 1 }}
                                        </td>
                                        <td>
                                            <span class="fw-semibold">{{ $meja->nama_meja }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if($meja->category->nama == 'VIP')
                                                <span class="badge bg-warning text-dark">{{ $meja->category->nama }}</span>
                                            @elseif($meja->category->nama == '8 Ball')
                                                <span class="badge bg-primary">{{ $meja->category->nama }}</span>
                                            @elseif($meja->category->nama == '9 Ball')
                                                <span class="badge bg-success">{{ $meja->category->nama }}</span>
                                            @else
                                                <span class="badge bg-info">{{ $meja->category->nama }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary">Lantai {{ $meja->lantai ?? '1' }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if($meja->status === 'available')
                                                <span class="badge bg-success">Tersedia</span>
                                            @elseif($meja->status === 'occupied')
                                                <span class="badge bg-danger">Terisi</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Maintenance</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-semibold">Rp {{ number_format($meja->harga, 0, ',', '.') }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-inbox text-muted mb-3" style="font-size: 3rem;"></i>
                                                <p class="text-muted mb-0">Belum ada meja yang tersedia</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update by Category -->
<div class="modal fade" id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel" aria-hidden="true" style="margin:20px;">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white" style="padding:10px;">
                <h5 class="modal-title fw-bold" id="updateCategoryModalLabel" >
                    <i class="fas fa-tags me-2"></i>Update Tarif per Kategori
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="categoryTarifForm">
                <div class="modal-body p-4" style="padding:10px;">
                    @csrf
                    <div class="row" style="gap: 0; margin-left:20px;">
                        <div class="col-md-3" style="padding: 0 8px;">
                            <label for="categorySelect" class="form-label fw-semibold" style="display: block; margin-bottom: 8px; color: #2c3e50;">
                                <i class="fas fa-list me-2 text-success"></i>Pilih Kategori
                            </label>
                            <select class="form-select" id="categorySelect" name="category_id" required style="height: 48px; padding: 0.75rem; border: 2px solid #28a745; border-radius: 8px; font-weight: 500; font-size: 0.95rem;">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4" style="padding: 0 8px;">
                            <label for="categoryHarga" class="form-label fw-semibold" style="display: block; margin-bottom: 8px; color: #2c3e50;">
                                <i class="fas fa-money-bill-wave me-2 text-success"></i>Harga per Jam
                            </label>
                            <div class="input-group" style="height: 48px;">
                                <span class="input-group-text" style="background: #28a745; color: white; border: 2px solid #28a745; border-radius: 8px 0 0 8px; font-weight: 700; padding: 0.75rem;">Rp</span>
                                <input type="number" class="form-control" id="categoryHarga" name="harga" 
                                       min="0" step="1000" placeholder="Masukkan harga" required style="height: 48px; padding: 0.75rem; border: 2px solid #28a745; border-left: none; border-radius: 0 8px 8px 0; font-weight: 600; font-size: 0.95rem;">
                            </div>
                            <small style="color: #6c757d; font-size: 0.8rem; display: block; margin-top: 4px;">
                                <i class="fas fa-info-circle me-1"></i>Contoh: 50000 untuk Rp 50.000
                            </small>
                        </div>
                        <div class="col-md-2" >
                            <button type="submit" class="btn btn-success w-100" style="margin-top: 27px; height: 48px; padding: 5px; display: flex; align-items: center; justify-content: center; border-radius: 8px; font-weight: 600; font-size: 0.95rem; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; ">
                                <i class="fas fa-check me-2"></i>Simpan
                            </button>
                        </div>
                        <div class="col-md-2" style="padding: 0 8px; ">
                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal" style="margin-top: 27px; height: 48px; padding: 5px; display: flex; align-items: center; justify-content: center; border-radius: 8px; font-weight: 600; font-size: 0.95rem; background: #6c757d; border: none; color: white;">
                                <i class="fas fa-times me-2"></i>Batal
                            </button>
                        </div>
                    </div>
                    
                    <div class="alert alert-info mt-4 mb-3" style="margin:20px;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle text-info me-3 fs-4"></i>
                            <div style="padding:5px;">
                                <h6 class="alert-heading mb-1 text-info fw-bold">Perhatian</h6>
                                <p class="mb-0">Harga ini akan diterapkan ke <strong>semua meja</strong> dalam kategori yang dipilih.</p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
/* ===== GLOBAL STYLES ===== */
.container-fluid {
    max-width: 1400px;
}

/* ===== PAGE HEADER ===== */
.page-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid #e9ecef;
}

.page-title {
    color: #2c3e50;
    font-weight: 700;
    font-size: 1.75rem;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    color: #6c757d;
    font-size: 1rem;
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

.header-actions .btn {
    border-radius: 8px;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.header-actions .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* ===== FILTER SECTION ===== */
.filter-card {
    margin-bottom: 2rem;
}

.filter-card .card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    border: 1px solid #e9ecef;
}

.filter-card .card-body {
    padding: 2rem;
}

.filter-card h5 {
    color: #2c3e50;
    font-weight: 700;
    font-size: 1.25rem;
    margin: 0;
}

.filter-card .form-select {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    font-weight: 500;
    font-size: 1rem;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.filter-card .form-select:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

/* ===== TABLE SECTION ===== */
.table-card {
    margin-bottom: 2rem;
}

.table-card .card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
    border: 1px solid #e9ecef;
}

.table-responsive {
    border-radius: 12px;
}

.table {
    margin-bottom: 0;
    font-size: 0.9rem;
}

.table thead th {
    background: #343a40;
    color: white;
    font-weight: 600;
    font-size: 0.85rem;
    padding: 1.25rem 1rem;
    border: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

.table tbody td {
    padding: 1.25rem 1rem;
    vertical-align: middle;
    border-color: #f1f3f4;
    white-space: nowrap;
}

.table tbody tr {
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* ===== TABLE IMAGE ===== */
.table-img {
    width: 30px;
    height: 22px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #dee2e6;
    transition: all 0.2s ease;
}

.table-img:hover {
    transform: scale(1.1);
}

/* ===== BADGES ===== */
.badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

/* ===== FORM INPUTS ===== */
.tarif-input {
    font-weight: 600;
    font-size: 0.9rem;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    text-align: center;
}

.tarif-input:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.tarif-input.border-warning {
    border-color: #ffc107 !important;
    background-color: #fff3cd !important;
}

.input-group-text {
    background-color: #f8f9fa;
    border: 2px solid #e9ecef;
    font-weight: 600;
    color: #495057;
}

/* ===== BUTTONS ===== */
.btn {
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.btn-warning {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
    color: #212529;
}

.reset-btn {
    border-radius: 6px;
    padding: 0.375rem 0.5rem;
    border: 1px solid #6c757d;
}

/* ===== EMPTY STATE ===== */
.empty-state {
    padding: 3rem;
    color: #6c757d;
    text-align: center;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

/* ===== MODAL STYLES ===== */
.modal-xl {
    max-width: 1200px;
}

.modal-content {
    border: none;
    border-radius: 15px;
    box-shadow: 0 15px 50px rgba(0,0,0,0.2);
    overflow: hidden;
}

.modal-header {
    border-bottom: none;
    padding: 1.5rem 2rem;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 700;
}

.modal-body {
    padding: 2rem;
    background: #fff;
}

.modal-body .row {
    margin: 0;
}

.modal-body .col-md-3,
.modal-body .col-md-4,
.modal-body .col-md-2 {
    padding: 0 0.75rem;
}

.modal-body .form-label {
    font-size: 0.95rem;
    margin-bottom: 0.5rem;
    color: #2c3e50;
    font-weight: 600;
}

.modal-body .form-select,
.modal-body .form-control {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.modal-body .form-select:focus,
.modal-body .form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.modal-body .input-group-text {
    background: #28a745;
    color: white;
    border: 2px solid #28a745;
    font-weight: 700;
}

.modal-body .btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 0.95rem;
    font-weight: 600;
    border-radius: 8px;
}

/* ===== ALERTS ===== */
.alert {
    border: none;
    border-radius: 10px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1rem;
}

.alert-info {
    background: linear-gradient(135deg, rgba(23, 162, 184, 0.1) 0%, rgba(13, 202, 240, 0.1) 100%);
    border-left: 4px solid #17a2b8;
}

.alert-warning {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(224, 168, 0, 0.1) 100%);
    border-left: 4px solid #ffc107;
}

.alert-heading {
    font-size: 1rem;
    font-weight: 700;
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 1200px) {
    .modal-xl {
        max-width: 95%;
        margin: 1rem auto;
    }
}

@media (max-width: 992px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .header-actions {
        flex-direction: column;
        gap: 0.5rem;
        width: 100%;
    }
    
    .header-actions .btn {
        width: 100%;
    }
    
    .filter-card .card-body {
        padding: 1.5rem;
    }
    
    .filter-card .row {
        flex-direction: column;
        gap: 1rem;
    }
    
    .modal-body .row {
        flex-direction: column;
        gap: 1rem;
    }
    
    .modal-body .col-md-3,
    .modal-body .col-md-4,
    .modal-body .col-md-2 {
        padding: 0;
        margin-bottom: 1rem;
    }
}

@media (max-width: 768px) {
    .page-title {
        font-size: 1.5rem;
    }
    
    .page-subtitle {
        font-size: 0.9rem;
    }
    
    .filter-card h5 {
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        font-size: 0.85rem;
    }
    
    .table thead th {
        padding: 1rem 0.75rem;
        font-size: 0.75rem;
    }
    
    .table tbody td {
        padding: 1rem 0.75rem;
    }
    
    .table-img {
        width: 26px;
        height: 20px;
    }
    
    .badge {
        font-size: 0.7rem;
        padding: 0.375rem 0.5rem;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .modal-header {
        padding: 1rem 1.5rem;
    }
}

@media (max-width: 576px) {
    .container-fluid {
        padding: 1rem;
    }
    
    .page-header {
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .filter-card .card-body {
        padding: 1rem;
    }
    
    .table thead th {
        padding: 0.75rem 0.5rem;
        font-size: 0.7rem;
    }
    
    .table tbody td {
        padding: 0.75rem 0.5rem;
    }
    
    .modal-body {
        padding: 1rem;
    }
    
    .modal-header {
        padding: 1rem;
    }
    
    .modal-title {
        font-size: 1.1rem;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Track changes
    let hasChanges = false;
    
    // Category data for preview
    const categoryData = @json($categories->keyBy('id'));
    const mejaData = @json($mejas->groupBy('category_id'));

    // Category filter functionality
    $('#categoryFilter').on('change', function() {
        const categoryId = $(this).val();
        if (categoryId) {
            $('tr[data-category]').hide();
            $(`tr[data-category="${categoryId}"]`).show();
        } else {
            $('tr[data-category]').show();
        }
    });

    // Track input changes
    $('.tarif-input').on('input', function() {
        const original = parseFloat($(this).data('original'));
        const current = parseFloat($(this).val());
        
        if (current !== original && !isNaN(current)) {
            $(this).addClass('border-warning bg-warning-subtle');
            hasChanges = true;
        } else {
            $(this).removeClass('border-warning bg-warning-subtle');
        }
        
        updateSaveButton();
    });

    // Reset individual tarif
    $('.reset-btn').on('click', function() {
        const mejaId = $(this).data('meja-id');
        const original = $(this).data('original');
        const input = $(`input[data-meja-id="${mejaId}"]`);
        
        input.val(original).removeClass('border-warning bg-warning-subtle');
        updateSaveButton();
    });

    // Update save button state
    function updateSaveButton() {
        const changedInputs = $('.tarif-input.border-warning').length;
        if (changedInputs > 0) {
            $('#saveAllBtn').removeClass('btn-primary').addClass('btn-warning').prop('disabled', false);
            hasChanges = true;
        } else {
            $('#saveAllBtn').removeClass('btn-warning').addClass('btn-primary').prop('disabled', false);
            hasChanges = false;
        }
    }

    // Save all changes
    $('#saveAllBtn').on('click', function() {
        if (!hasChanges) {
            Swal.fire({
                icon: 'info',
                title: 'Tidak Ada Perubahan',
                text: 'Tidak ada tarif yang diubah.',
                confirmButtonColor: '#007bff'
            });
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Perubahan',
            text: 'Apakah Anda yakin ingin menyimpan semua perubahan tarif?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-check me-1"></i>Ya, Simpan',
            cancelButtonText: '<i class="fas fa-times me-1"></i>Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                saveTarif();
            }
        });
    });

    // Save tarif function
    function saveTarif() {
        const formData = new FormData($('#tarifForm')[0]);
        
        $.ajax({
            url: '{{ route("admin.tarif.update-bulk") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#saveAllBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    // Update original values and remove warning classes
                    $('.tarif-input').each(function() {
                        $(this).data('original', $(this).val()).removeClass('border-warning bg-warning-subtle');
                    });
                    
                    hasChanges = false;
                    updateSaveButton();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message,
                        confirmButtonColor: '#dc3545'
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat menyimpan data.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage,
                    confirmButtonColor: '#dc3545'
                });
            },
            complete: function() {
                $('#saveAllBtn').prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Semua');
            }
        });
    }

    // Category selection preview
    $('#categorySelect').on('change', function() {
        const categoryId = $(this).val();
        if (categoryId && mejaData[categoryId]) {
            const mejaCount = mejaData[categoryId].length;
            const categoryName = categoryData[categoryId].nama;
            $('#previewText').text(`Akan mengubah tarif untuk ${mejaCount} meja dalam kategori "${categoryName}"`);
            $('#categoryPreview').removeClass('d-none');
        } else {
            $('#categoryPreview').addClass('d-none');
        }
    });

    // Update by category
    $('#categoryTarifForm').on('submit', function(e) {
        e.preventDefault();
        
        const categoryId = $('#categorySelect').val();
        const harga = $('#categoryHarga').val();
        
        if (!categoryId || !harga) {
            Swal.fire({
                icon: 'warning',
                title: 'Form Tidak Lengkap',
                text: 'Mohon pilih kategori dan masukkan harga.',
                confirmButtonColor: '#ffc107'
            });
            return;
        }

        // Langsung simpan tanpa konfirmasi
        updateCategoryTarif();
    });

    // Update category tarif function
    function updateCategoryTarif() {
        const formData = new FormData($('#categoryTarifForm')[0]);
        const categoryId = $('#categorySelect').val();
        const harga = parseFloat($('#categoryHarga').val());
        
        $.ajax({
            url: '{{ route("admin.tarif.update-category") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#categoryTarifForm button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Memperbarui...');
            },
            success: function(response) {
                if (response.success) {
                    // Update input harga di tabel untuk meja-meja dalam kategori ini
                    $(`tr[data-category="${categoryId}"] .tarif-input`).each(function() {
                        $(this).val(harga).data('original', harga).removeClass('border-warning bg-warning-subtle');
                    });
                    
                    // Reset form dan close modal
                    $('#categoryTarifForm')[0].reset();
                    $('#categoryPreview').addClass('d-none');
                    $('#updateCategoryModal').modal('hide');
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    // Update original values untuk input yang diubah
                    $(`tr[data-category="${categoryId}"] .tarif-input`).each(function() {
                        $(this).data('original', harga).removeClass('border-warning bg-warning-subtle');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message,
                        confirmButtonColor: '#dc3545'
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat memperbarui tarif.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage,
                    confirmButtonColor: '#dc3545'
                });
            },
            complete: function() {
                $('#categoryTarifForm button[type="submit"]').prop('disabled', false).html('<i class="fas fa-check me-1"></i>Update Tarif');
            }
        });
    }

    // Reset modal when closed
    $('#updateCategoryModal').on('hidden.bs.modal', function() {
        $('#categoryTarifForm')[0].reset();
        $('#categoryPreview').addClass('d-none');
    });

    // Warn before leaving if there are unsaved changes
    window.addEventListener('beforeunload', function(e) {
        if (hasChanges) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>