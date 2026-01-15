@extends('layouts.app2')

@section('content')
<div class="content-wrapper">
  <div class="container-fluid">

    <!-- Breadcrumb -->
    <div class="breadcrumb-section mb-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-success">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.transaksi') }}" class="text-success">Transaksi</a></li>
          <li class="breadcrumb-item active" aria-current="page">Detail Transaksi</li>
        </ol>
      </nav>
    </div>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="page-title">Detail Transaksi</h2>
        <p class="page-subtitle">Informasi lengkap transaksi dan pembayaran</p>
      </div>
      <div>
        <a href="{{ route('admin.transaksi') }}" class="btn btn-secondary">Kembali</a>
      </div>
    </div>

    <div class="row">
      <!-- Invoice Details -->
      <div class="col-lg-8">
        <div class="card">
          <div class="invoice-header">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h3 class="mb-1">Invoice</h3>
                <div class="invoice-code">INV-20251211001</div>
              </div>
              <div class="text-end">
                <span class="status-badge status-lunas">LUNAS</span>
              </div>
            </div>
          </div>
          <div class="card-body">
            <!-- Customer Information -->
            <div class="row mb-4">
              <div class="col-md-6">
                <h5 class="mb-3">Informasi Pelanggan</h5>
                <div class="detail-row">
                  <div class="detail-label">Nama Lengkap</div>
                  <div class="detail-value">Haikal Rahman</div>
                </div>
                <div class="detail-row">
                  <div class="detail-label">Email</div>
                  <div class="detail-value">haikal@gmail.com</div>
                </div>
                <div class="detail-row">
                  <div class="detail-label">No. Telepon</div>
                  <div class="detail-value">+62 821-9876-5432</div>
                </div>
              </div>
              <div class="col-md-6">
                <h5 class="mb-3">Informasi Transaksi</h5>
                <div class="detail-row">
                  <div class="detail-label">Tanggal Booking</div>
                  <div class="detail-value">11 Desember 2025</div>
                </div>
                <div class="detail-row">
                  <div class="detail-label">Waktu Mulai</div>
                  <div class="detail-value">14:00 WIB</div>
                </div>
                <div class="detail-row">
                  <div class="detail-label">Waktu Selesai</div>
                  <div class="detail-value">16:00 WIB</div>
                </div>
              </div>
            </div>

            <!-- Booking Details -->
            <h5 class="mb-3">Detail Booking</h5>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead class="table-light">
                  <tr>
                    <th>Meja</th>
                    <th>Kategori</th>
                    <th>Durasi</th>
                    <th>Harga/Jam</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Meja VIP 1</td>
                    <td><span class="badge bg-warning">VIP</span></td>
                    <td>2 Jam</td>
                    <td>Rp 200.000</td>
                    <td>Rp 400.000</td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr class="table-success">
                    <th colspan="4" class="text-end">Total Pembayaran:</th>
                    <th class="amount-highlight">Rp 400.000</th>
                  </tr>
                </tfoot>
              </table>
            </div>

            <!-- Payment Information -->
            <div class="row mt-4">
              <div class="col-md-6">
                <h5 class="mb-3">Informasi Pembayaran</h5>
                <div class="detail-row">
                  <div class="detail-label">Metode Pembayaran</div>
                  <div class="detail-value">Transfer Bank (BCA)</div>
                </div>
                <div class="detail-row">
                  <div class="detail-label">Tanggal Pembayaran</div>
                  <div class="detail-value">11 Desember 2025, 13:45 WIB</div>
                </div>
                <div class="detail-row">
                  <div class="detail-label">Status</div>
                  <div class="detail-value">
                    <span class="status-badge status-lunas">Lunas</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header bg-light">
            <h5 class="card-title mb-0">Aksi</h5>
          </div>
          <div class="card-body">
            <div class="d-grid gap-2">
              <button class="btn btn-primary" onclick="printInvoice()">
                <i class="fas fa-print me-2"></i>Cetak Invoice
              </button>
              <button class="btn btn-warning" onclick="sendEmail()">
                <i class="fas fa-envelope me-2"></i>Kirim Email
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/adminTransaksi.css') }}">
<style>
/* Detail Styling */
.detail-row {
  padding: 12px 0;
  border-bottom: 1px solid #f0f0f0;
}

.detail-label {
  font-weight: 600;
  color: #374151;
  margin-bottom: 4px;
}

.detail-value {
  color: #6b7280;
}

.status-badge {
  font-size: 0.9rem;
  padding: 8px 16px;
  border-radius: 25px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.status-lunas {
  background: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.status-pending {
  background: #fff3cd;
  color: #856404;
  border: 1px solid #ffeaa7;
}

.status-dibatalkan {
  background: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}

.invoice-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 2rem;
  border-radius: 12px 12px 0 0;
  margin: -1.25rem -1.25rem 1.25rem -1.25rem;
}

.invoice-code {
  font-family: 'Courier New', monospace;
  font-weight: 700;
  font-size: 1.5rem;
  color: white;
}

.amount-highlight {
  font-size: 1.5rem;
  font-weight: 700;
  color: #28a745;
}

.card-header {
  background-color: #f8f9fa !important;
  border-bottom: 1px solid #dee2e6;
}

.table-bordered {
  border: 1px solid #dee2e6;
}

.table-light {
  background-color: #f8f9fa;
}

.d-grid {
  display: grid;
}

.gap-2 {
  gap: 10px;
}

.btn {
  padding: 10px 16px;
  font-weight: 500;
  border-radius: 6px;
}

.btn-primary {
  background-color: #3b82f6;
  border-color: #3b82f6;
}

.btn-warning {
  background-color: #f59e0b;
  border-color: #f59e0b;
  color: white;
}

.btn-secondary {
  background-color: #6b7280;
  border-color: #6b7280;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    // Add animation on page load
    $('.card').each(function(index) {
        $(this).delay(index * 100).fadeIn(500);
    });
});

// Print invoice function
function printInvoice() {
    Swal.fire({
        title: 'Cetak Invoice',
        text: 'Invoice akan dicetak...',
        icon: 'info',
        timer: 1500,
        showConfirmButton: false
    }).then(() => {
        window.print();
    });
}

// Send email function
function sendEmail() {
    Swal.fire({
        title: 'Kirim Email',
        text: 'Invoice akan dikirim ke email pelanggan.',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Ya, Kirim!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Invoice berhasil dikirim via email.',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}
</script>
@endpush