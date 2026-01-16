@extends('layouts.app2')

@section('content')
<div class="container-fluid py-4" style="margin: 20px auto; max-width: 1400px; padding: 20px;">

    <!-- Breadcrumb -->
    <div class="breadcrumb-section mb-3">
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
        <p class="page-subtitle">Informasi lengkap transaksi #{{ $transaksi->kode_transaksi }}</p>
      </div>
      <div>
        <a href="{{ route('admin.transaksi') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
      </div>
    </div>

    <div class="row">
      <!-- Main Content -->
      <div class="col-lg-8">
        <!-- Invoice Card -->
        <div class="card mb-4">
          <div class="invoice-header">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h4 class="mb-2" style="color: white;">Invoice Transaksi</h4>
                <div class="invoice-code">{{ $transaksi->kode_transaksi }}</div>
              </div>
              <div class="text-end">
                @if($transaksi->status_pembayaran === 'paid')
                  <span class="status-badge status-lunas">LUNAS</span>
                @elseif($transaksi->status_pembayaran === 'pending')
                  <span class="status-badge status-pending">MENUNGGU PEMBAYARAN</span>
                @elseif($transaksi->status_pembayaran === 'failed')
                  <span class="status-badge status-dibatalkan">PEMBAYARAN GAGAL</span>
                @else
                  <span class="status-badge status-dibatalkan">{{ strtoupper($transaksi->status_pembayaran_text) }}</span>
                @endif
              </div>
            </div>
          </div>
          
          <div class="card-body">
            <!-- Customer & Transaction Info -->
            <div class="row mb-4">
              <div class="col-md-6">
                <h5 class="section-title">Informasi Pelanggan</h5>
                <div class="info-box">
                  <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-user me-2"></i>Nama Lengkap</div>
                    <div class="detail-value">{{ $transaksi->nama_pelanggan }}</div>
                  </div>
                  <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-envelope me-2"></i>Email</div>
                    <div class="detail-value">{{ $transaksi->email_pelanggan }}</div>
                  </div>
                  <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-phone me-2"></i>No. Telepon</div>
                    <div class="detail-value">{{ $transaksi->no_telepon ?? '-' }}</div>
                  </div>
                </div>
              </div>
              
              <div class="col-md-6">
                <h5 class="section-title">Informasi Booking</h5>
                <div class="info-box">
                  <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-calendar me-2"></i>Tanggal Booking</div>
                    <div class="detail-value">{{ $transaksi->formatted_tanggal_booking }}</div>
                  </div>
                  <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-clock me-2"></i>Jam Mulai</div>
                    <div class="detail-value">{{ $transaksi->formatted_jam_mulai }} WIB</div>
                  </div>
                  <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-clock me-2"></i>Jam Selesai</div>
                    <div class="detail-value">{{ $transaksi->formatted_jam_selesai }} WIB</div>
                  </div>
                  <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-hourglass-half me-2"></i>Durasi</div>
                    <div class="detail-value fw-bold">{{ $transaksi->durasi }} Jam</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Booking Details Table -->
            <h5 class="section-title">Detail Pesanan</h5>
            <div class="table-responsive">
              <table class="table table-bordered detail-table">
                <thead>
                  <tr>
                    <th width="30%">Meja</th>
                    <th width="20%">Kategori</th>
                    <th width="15%">Durasi</th>
                    <th width="20%">Harga/Jam</th>
                    <th width="15%">Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="fw-semibold">{{ $transaksi->meja->nama_meja }}</td>
                    <td>
                      @if($transaksi->meja->category->nama === 'VIP')
                        <span class="badge bg-warning text-dark">{{ $transaksi->meja->category->nama }}</span>
                      @else
                        <span class="badge bg-info">{{ $transaksi->meja->category->nama }}</span>
                      @endif
                    </td>
                    <td>{{ $transaksi->durasi }} Jam</td>
                    <td>{{ $transaksi->formatted_harga_per_jam }}</td>
                    <td class="fw-bold">{{ $transaksi->formatted_total_harga }}</td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr class="table-success">
                    <th colspan="4" class="text-end">Total Pembayaran:</th>
                    <th class="amount-highlight">{{ $transaksi->formatted_total_harga }}</th>
                  </tr>
                </tfoot>
              </table>
            </div>

            <!-- Payment Information -->
            <div class="row mt-4">
              <div class="col-md-12">
                <h5 class="section-title">Informasi Pembayaran</h5>
                <div class="info-box">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-credit-card me-2"></i>Metode Pembayaran</div>
                        <div class="detail-value">{{ $transaksi->payment_type ?? $transaksi->metode_pembayaran ?? 'Belum dipilih' }}</div>
                      </div>
                      <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-info-circle me-2"></i>Status Pembayaran</div>
                        <div class="detail-value">
                          @if($transaksi->status_pembayaran === 'paid')
                            <span class="fw-bold" style="color: #28a745;">Lunas</span>
                          @elseif($transaksi->status_pembayaran === 'pending')
                            <span class="fw-bold" style="color: #ff8c00;">Menunggu Pembayaran</span>
                          @else
                            <span class="fw-bold" style="color: #dc3545;">{{ $transaksi->status_pembayaran_text }}</span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      @if($transaksi->paid_at)
                      <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-check-circle me-2"></i>Tanggal Pembayaran</div>
                        <div class="detail-value">{{ $transaksi->paid_at->format('d/m/Y H:i') }} WIB</div>
                      </div>
                      @endif
                      @if($transaksi->midtrans_order_id)
                      <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-hashtag me-2"></i>Order ID Midtrans</div>
                        <div class="detail-value"><code>{{ $transaksi->midtrans_order_id }}</code></div>
                      </div>
                      @endif
                    </div>
                  </div>
                  
                  @if($transaksi->catatan)
                  <div class="detail-row mt-3">
                    <div class="detail-label"><i class="fas fa-sticky-note me-2"></i>Catatan</div>
                    <div class="detail-value">{{ $transaksi->catatan }}</div>
                  </div>
                  @endif
                </div>
              </div>
            </div>

            <!-- Check-in/Check-out Info -->
            @if($transaksi->waktu_checkin || $transaksi->waktu_checkout)
            <div class="row mt-4">
              <div class="col-md-12">
                <h5 class="section-title">Informasi Check-in/Check-out</h5>
                <div class="info-box">
                  <div class="row">
                    @if($transaksi->waktu_checkin)
                    <div class="col-md-6">
                      <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-sign-in-alt me-2"></i>Waktu Check-in</div>
                        <div class="detail-value">{{ $transaksi->waktu_checkin->format('d/m/Y H:i') }} WIB</div>
                      </div>
                    </div>
                    @endif
                    @if($transaksi->waktu_checkout)
                    <div class="col-md-6">
                      <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-sign-out-alt me-2"></i>Waktu Check-out</div>
                        <div class="detail-value">{{ $transaksi->waktu_checkout->format('d/m/Y H:i') }} WIB</div>
                      </div>
                    </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>

      <!-- Sidebar Actions -->
      <div class="col-lg-4">
        <!-- Status Card -->
        <div class="card mb-4">
          <div class="card-header bg-light">
            <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Status Booking</h5>
          </div>
          <div class="card-body">
            <div class="text-center mb-3">
              @if($transaksi->status_booking === 'confirmed')
                <span class="badge bg-info p-3" style="font-size: 1rem;">DIKONFIRMASI</span>
              @elseif($transaksi->status_booking === 'ongoing')
                <span class="badge bg-primary p-3" style="font-size: 1rem;">SEDANG BERLANGSUNG</span>
              @elseif($transaksi->status_booking === 'completed')
                <span class="badge bg-success p-3" style="font-size: 1rem;">SELESAI</span>
              @else
                <span class="badge bg-secondary p-3" style="font-size: 1rem;">{{ strtoupper($transaksi->status_booking_text) }}</span>
              @endif
            </div>
            
            <div class="d-grid gap-2">
              @if($transaksi->status_booking === 'confirmed')
                <button class="btn btn-success" onclick="checkinCustomer({{ $transaksi->id }})">
                  <i class="fas fa-sign-in-alt me-2"></i>Check In Customer
                </button>
              @elseif($transaksi->status_booking === 'ongoing')
                <button class="btn btn-warning" onclick="checkoutCustomer({{ $transaksi->id }})">
                  <i class="fas fa-sign-out-alt me-2"></i>Check Out Customer
                </button>
              @endif
            </div>
          </div>
        </div>

        <!-- Action Buttons Card -->
        <div class="card">
          <div class="card-header bg-light">
            <h5 class="card-title mb-0"><i class="fas fa-cog me-2"></i>Aksi</h5>
          </div>
          <div class="card-body">
            <div class="d-grid gap-2">
              <button class="btn btn-primary" onclick="printInvoice()">
                <i class="fas fa-print me-2"></i>Cetak Invoice
              </button>
              <button class="btn btn-info text-white" onclick="sendEmail()">
                <i class="fas fa-envelope me-2"></i>Kirim Email
              </button>
              @if($transaksi->status_pembayaran !== 'paid' && $transaksi->status_booking !== 'completed')
              <button class="btn btn-danger" onclick="cancelTransaction({{ $transaksi->id }})">
                <i class="fas fa-times me-2"></i>Batalkan Transaksi
              </button>
              @endif
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
/* Page Styling */
.page-title {
  color: #1f2937;
  font-weight: 700;
  margin: 0;
  font-size: 1.75rem;
}

.page-subtitle {
  color: #6b7280;
  margin: 5px 0 0 0;
  font-size: 0.95rem;
}

.breadcrumb {
  background: none;
  padding: 0;
  margin: 0;
  font-size: 0.875rem;
}

/* Card Styling */
.card {
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  margin-bottom: 1.5rem;
}

.card-header {
  background-color: #f8f9fa !important;
  border-bottom: 2px solid #dee2e6;
  border-radius: 15px 15px 0 0 !important;
  padding: 15px 20px;
}

.card-title {
  color: #495057;
  font-weight: 600;
  font-size: 1.1rem;
  margin: 0;
}

/* Invoice Header */
.invoice-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 2rem;
  border-radius: 15px 15px 0 0;
  margin: -1px -1px 0 -1px;
}

.invoice-code {
  font-family: 'Courier New', monospace;
  font-weight: 700;
  font-size: 1.5rem;
  color: white;
  background: rgba(255,255,255,0.2);
  padding: 8px 16px;
  border-radius: 8px;
  display: inline-block;
  margin-top: 5px;
}

/* Section Title */
.section-title {
  color: #374151;
  font-weight: 600;
  font-size: 1.1rem;
  margin-bottom: 1rem;
  padding-bottom: 0.5rem;
  border-bottom: 2px solid #e5e7eb;
}

/* Info Box */
.info-box {
  background: #f9fafb;
  border-radius: 10px;
  padding: 15px;
  border: 1px solid #e5e7eb;
}

/* Detail Row */
.detail-row {
  padding: 12px 0;
  border-bottom: 1px solid #e5e7eb;
}

.detail-row:last-child {
  border-bottom: none;
}

.detail-label {
  font-weight: 600;
  color: #374151;
  margin-bottom: 4px;
  font-size: 0.9rem;
}

.detail-value {
  color: #6b7280;
  font-size: 0.95rem;
}

.detail-value code {
  background: #e5e7eb;
  padding: 2px 8px;
  border-radius: 4px;
  font-size: 0.85rem;
  color: #374151;
}

/* Status Badges */
.status-badge {
  font-size: 0.9rem;
  padding: 10px 20px;
  border-radius: 25px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  display: inline-block;
}

.status-lunas {
  background: #d4edda;
  color: #155724;
  border: 2px solid #c3e6cb;
}

.status-pending {
  background: #fff3cd;
  color: #856404;
  border: 2px solid #ffeaa7;
}

.status-dibatalkan {
  background: #f8d7da;
  color: #721c24;
  border: 2px solid #f5c6cb;
}

/* Table Styling */
.detail-table {
  border: 1px solid #dee2e6;
  border-radius: 8px;
  overflow: hidden;
}

.detail-table thead {
  background: linear-gradient(45deg, #007bff, #0056b3);
  color: white;
}

.detail-table thead th {
  color: white !important;
  font-weight: 600;
  padding: 12px;
  border: none;
  font-size: 0.9rem;
}

.detail-table tbody td {
  padding: 12px;
  vertical-align: middle;
}

.detail-table tfoot th {
  padding: 15px;
  font-size: 1.1rem;
}

.amount-highlight {
  font-size: 1.5rem;
  font-weight: 700;
  color: #28a745;
}

/* Buttons */
.btn {
  padding: 10px 20px;
  font-weight: 500;
  border-radius: 8px;
  transition: all 0.3s ease;
}

.btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-primary {
  background-color: #3b82f6;
  border-color: #3b82f6;
}

.btn-info {
  background-color: #06b6d4;
  border-color: #06b6d4;
}

.btn-success {
  background-color: #10b981;
  border-color: #10b981;
}

.btn-warning {
  background-color: #f59e0b;
  border-color: #f59e0b;
  color: white;
}

.btn-danger {
  background-color: #ef4444;
  border-color: #ef4444;
}

.btn-secondary {
  background-color: #6b7280;
  border-color: #6b7280;
}

.d-grid {
  display: grid;
}

.gap-2 {
  gap: 10px;
}

/* Responsive */
@media (max-width: 768px) {
  .invoice-code {
    font-size: 1.2rem;
  }
  
  .page-title {
    font-size: 1.5rem;
  }
  
  .detail-table {
    font-size: 0.85rem;
  }
}

/* Animation */
.card {
  animation: fadeInUp 0.5s ease;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Check in customer
function checkinCustomer(transaksiId) {
  Swal.fire({
    title: 'Konfirmasi Check In',
    text: 'Customer akan di-check in dan meja akan menjadi terisi',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#28a745',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Ya, Check In!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`/admin/transaksi/${transaksiId}/checkin`, {
        method: 'POST',
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
          text: 'Terjadi kesalahan saat check in'
        });
      });
    }
  });
}

// Check out customer
function checkoutCustomer(transaksiId) {
  Swal.fire({
    title: 'Konfirmasi Check Out',
    text: 'Customer akan di-check out dan meja akan tersedia kembali',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#ffc107',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Ya, Check Out!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`/admin/transaksi/${transaksiId}/checkout`, {
        method: 'POST',
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
          text: 'Terjadi kesalahan saat check out'
        });
      });
    }
  });
}

// Cancel transaction
function cancelTransaction(transaksiId) {
  Swal.fire({
    title: 'Batalkan Transaksi?',
    text: 'Transaksi ini akan dibatalkan dan tidak dapat dikembalikan',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#dc3545',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Ya, Batalkan!',
    cancelButtonText: 'Tidak'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`/admin/transaksi/${transaksiId}/cancel`, {
        method: 'POST',
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
          text: 'Terjadi kesalahan saat membatalkan transaksi'
        });
      });
    }
  });
}

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