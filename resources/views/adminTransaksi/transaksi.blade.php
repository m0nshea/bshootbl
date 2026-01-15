@extends('layouts.app2')
@push('styles')
<link href="{{ asset('css/adminTransaksi.css') }}" rel="stylesheet" />
@endpush
@section('content')
<div class="container-fluid py-4" style="margin: 20px auto; max-width: 1200px; padding: 20px;">
 
    <!-- Breadcrumb -->
    <div class="breadcrumb-section mb-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-success">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
        </ol>
      </nav>
    </div>

    <!-- Page Header -->
    <div class="mb-4">
      <h2 class="page-title">Kelola Transaksi</h2>
      <p class="page-subtitle">Manajemen transaksi dan pembayaran</p>
    </div>

    <!-- Filter Section -->
    <div class="admin-transaksi-filter-card mb-4" style="background: #ffff; border-radius: 15px; box-shadow: 0 6px 25px rgba(0,0,0,0.15); transition: all 0.3s ease; padding: 10px;">
      <div class="card-header">
        <h4 class="card-title mb-0">Filter Transaksi</h4>
      </div>
      <div class="card-body">
        <form method="GET" action="{{ route('admin.transaksi') }}" class="row g-3" style="margin-bottom: 20px;">
          <div class="col-md-3" style="margin-bottom: 15px; margin-right: 10px;">
            <label class="form-label" style="font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 8px;">Status Pembayaran</label>
            <select name="status_pembayaran" class="form-select" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd; background-color: #fff; font-size: 14px; width: 100%; transition: border-color 0.3s ease;">
              <option value="">Semua Status</option>
              <option value="pending" {{ request('status_pembayaran') == 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="paid" {{ request('status_pembayaran') == 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
              <option value="failed" {{ request('status_pembayaran') == 'failed' ? 'selected' : '' }}>Gagal</option>
              <option value="cancelled" {{ request('status_pembayaran') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
          </div>
          <div class="col-md-3" style="margin-bottom: 15px; margin-right: 10px;">
            <label class="form-label" style="font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 8px;">Status Booking</label>
            <select name="status_booking" class="form-select" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd; background-color: #fff; font-size: 14px; width: 100%; transition: border-color 0.3s ease;">
              <option value="">Semua Status</option>
              <option value="confirmed" {{ request('status_booking') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
              <option value="ongoing" {{ request('status_booking') == 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
              <option value="completed" {{ request('status_booking') == 'completed' ? 'selected' : '' }}>Selesai</option>
              <option value="cancelled" {{ request('status_booking') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
          </div>
          <div class="col-md-2" style="margin-bottom: 15px; margin-right: 10px;">
            <label class="form-label" style="font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 8px;">Dari Tanggal</label>
            <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd; background-color: #fff; font-size: 14px; width: 100%; transition: border-color 0.3s ease;">
          </div>
          <div class="col-md-2" style="margin-bottom: 15px; margin-right: 10px;">
            <label class="form-label" style="font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 8px;">Sampai Tanggal</label>
            <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd; background-color: #fff; font-size: 14px; width: 100%; transition: border-color 0.3s ease;">
          </div>
          <div class="col-md-2" style="margin-bottom: 15px; margin-top:3px">
            <label class="form-label" style="font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 8px;">&nbsp;</label>
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary" style="padding: 10px 20px; border-radius: 8px; font-weight: 600; background-color: #007bff; border: none; color: white; cursor: pointer; transition: background-color 0.3s ease;">Filter</button>
              <a href="{{ route('admin.transaksi') }}" class="btn btn-secondary" style="padding: 10px 20px; border-radius: 8px; font-weight: 600; background-color: #6c757d; border: none; color: white; text-decoration: none; cursor: pointer; transition: background-color 0.3s ease;">Reset</a>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Main Content Card -->
    <div class="admin-transaksi-main-card">
      <div class="card-header">
        <h4 class="card-title mb-0">Daftar Transaksi</h4>
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
          <table class="table table-hover align-middle">
            <thead class="text-center">
              <tr>
                <th width="8%">No</th>
                <th width="12%">Kode Transaksi</th>
                <th width="15%">Pelanggan</th>
                <th width="12%">Meja</th>
                <th width="12%">Tanggal & Jam</th>
                <th width="8%">Durasi</th>
                <th width="12%">Total</th>
                <th width="10%">Status</th>
                <th width="11%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($transaksis as $index => $transaksi)
                <tr>
                  <td class="text-center fw-bold">{{ $transaksis->firstItem() + $index }}</td>
                  <td><span class="invoice-code">{{ $transaksi->kode_transaksi }}</span></td>
                  <td>
                    <div>
                      <span class="fw-semibold">{{ $transaksi->nama_pelanggan }}</span><br>
                      <small class="text-muted">{{ $transaksi->email_pelanggan }}</small>
                    </div>
                  </td>
                  <td class="text-center">
                    <span class="badge bg-info">{{ $transaksi->meja->nama_meja }}</span><br>
                    <small class="text-muted">{{ $transaksi->meja->category->nama }}</small>
                  </td>
                  <td class="text-center">
                    <span class="fw-semibold">{{ $transaksi->formatted_tanggal_booking }}</span><br>
                    <small class="text-muted">{{ $transaksi->formatted_jam_mulai }} - {{ $transaksi->formatted_jam_selesai }}</small>
                  </td>
                  <td class="text-center"><span class="fw-semibold">{{ $transaksi->durasi }} Jam</span></td>
                  <td class="text-center"><span class="amount-text">{{ $transaksi->formatted_total_harga }}</span></td>
                  <td class="text-center">
                    <span class="badge {{ $transaksi->status_pembayaran_badge }}">{{ $transaksi->status_pembayaran_text }}</span><br>
                    <span class="badge {{ $transaksi->status_booking_badge }} mt-1">{{ $transaksi->status_booking_text }}</span>
                  </td>
                  <td class="text-center">
                    <div class="d-flex justify-content-center gap-1 flex-wrap">
                      <a href="{{ route('admin.transaksi.show', $transaksi->id) }}" class="btn btn-info btn-sm" title="Detail Transaksi">Detail</a>
                      @if($transaksi->status_booking === 'confirmed')
                        <button onclick="checkinCustomer({{ $transaksi->id }})" class="btn btn-success btn-sm" title="Check In">Check In</button>
                      @elseif($transaksi->status_booking === 'ongoing')
                        <button onclick="checkoutCustomer({{ $transaksi->id }})" class="btn btn-warning btn-sm" title="Check Out">Check Out</button>
                      @endif
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="9" class="text-center py-4">
                    <div class="text-muted">
                      <i class="fas fa-inbox fa-3x mb-3"></i>
                      <p>Belum ada transaksi</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        
        <!-- Pagination Info -->
        @if($transaksis->hasPages())
          <div class="d-flex justify-content-between align-items-center p-3 border-top">
            <small class="text-muted">
              Menampilkan {{ $transaksis->firstItem() }} sampai {{ $transaksis->lastItem() }} 
              dari {{ $transaksis->total() }} data
            </small>
            <div class="d-flex gap-1">
              {{ $transaksis->links('pagination::bootstrap-4') }}
            </div>
          </div>
        @endif
      </div>
    </div>

  </div>
</div>
@endsection 

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

// Initialize on page load
$(document).ready(function() {
  // Auto-dismiss alerts after 5 seconds
  setTimeout(function() {
    $('.alert').fadeOut('slow');
  }, 5000);
});
</script>
@endpush