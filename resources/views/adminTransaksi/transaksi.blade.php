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
        
        <!-- Simple Scrollable Table -->
        <div style="overflow-x: auto; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
          <table class="table table-striped table-hover mb-0" style="min-width: 1600px; width: 1600px;">
            <thead style="background: #343a40; color: white;">
              <tr>
                <th style="padding: 15px 10px; font-size: 0.8rem; text-align: center; min-width: 60px; width: 60px;">NO</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; min-width: 160px; width: 160px;">KODE TRANSAKSI</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; min-width: 220px; width: 220px;">PELANGGAN</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; text-align: center; min-width: 100px; width: 100px;">MEJA</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; text-align: center; min-width: 120px; width: 120px;">TANGGAL BOOKING</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; text-align: center; min-width: 140px; width: 140px;">JAM</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; text-align: center; min-width: 80px; width: 80px;">DURASI</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; text-align: center; min-width: 120px; width: 120px;">TOTAL</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; text-align: center; min-width: 160px; width: 160px;">STATUS</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; text-align: center; min-width: 160px; width: 160px;">TANGGAL PEMBAYARAN</th>
                <th style="padding: 15px 10px; font-size: 0.8rem; text-align: center; min-width: 140px; width: 140px;">AKSI</th>
              </tr>
            </thead>
            <tbody>
              @forelse($transaksis as $index => $transaksi)
                <tr>
                  <td style="padding: 12px 10px; text-align: center; font-weight: bold; min-width: 60px; width: 60px;">
                    {{ $transaksis->firstItem() + $index }}
                  </td>
                  <td style="padding: 12px 10px; min-width: 160px; width: 160px;">
                    <code style="background: #f8f9fa; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; display: block; text-align: center;">
                      {{ $transaksi->kode_transaksi }}
                    </code>
                  </td>
                  <td style="padding: 12px 10px; min-width: 220px; width: 220px;">
                    <div>
                      <strong style="display: block; margin-bottom: 2px; font-size: 0.9rem;">{{ $transaksi->user->name ?? 'Customer' }}</strong>
                      <small style="color: #6c757d; font-size: 0.75rem;">{{ $transaksi->user->email ?? '-' }}</small>
                    </div>
                  </td>
                  <td style="padding: 12px 10px; text-align: center; min-width: 100px; width: 100px;">
                    <span class="badge bg-info" style="font-size: 0.75rem; padding: 6px 10px;">{{ $transaksi->meja->nama_meja }}</span>
                  </td>
                  <td style="padding: 12px 10px; text-align: center; min-width: 120px; width: 120px;">
                    <strong style="font-size: 0.85rem;">{{ $transaksi->formatted_tanggal_booking }}</strong>
                  </td>
                  <td style="padding: 12px 10px; text-align: center; min-width: 140px; width: 140px;">
                    <small style="font-size: 0.8rem;">{{ $transaksi->formatted_jam_mulai }} - {{ $transaksi->formatted_jam_selesai }}</small>
                  </td>
                  <td style="padding: 12px 10px; text-align: center; min-width: 80px; width: 80px;">
                    <span class="badge bg-secondary" style="font-size: 0.75rem;">{{ $transaksi->durasi }} Jam</span>
                  </td>
                  <td style="padding: 12px 10px; text-align: center; min-width: 120px; width: 120px;">
                    <strong style="color: #28a745; font-size: 0.9rem;">{{ $transaksi->formatted_total_harga }}</strong>
                  </td>
                  <td style="padding: 12px 10px; text-align: center; min-width: 160px; width: 160px;">
                    @if($transaksi->status_pembayaran === 'paid')
                      <span class="badge bg-success" style="font-size: 0.75rem; padding: 6px 12px;">Lunas</span>
                    @elseif($transaksi->status_pembayaran === 'pending')
                      <span class="badge bg-warning text-dark" style="font-size: 0.75rem; padding: 6px 12px;">Menunggu Pembayaran</span>
                    @elseif($transaksi->status_pembayaran === 'failed')
                      <span class="badge bg-danger" style="font-size: 0.75rem; padding: 6px 12px;">Pembayaran Gagal</span>
                    @else
                      <span class="badge bg-secondary" style="font-size: 0.75rem; padding: 6px 12px;">{{ $transaksi->status_pembayaran_text }}</span>
                    @endif
                  </td>
                  <td style="padding: 12px 10px; text-align: center; min-width: 160px; width: 160px;">
                    @if($transaksi->status_pembayaran === 'paid' && $transaksi->paid_at)
                      <div>
                        <strong style="display: block; font-size: 0.85rem;">
                          {{ \Carbon\Carbon::parse($transaksi->paid_at)->format('d/m/Y') }}
                        </strong>
                        <small style="color: #6c757d; font-size: 0.75rem;">
                          {{ \Carbon\Carbon::parse($transaksi->paid_at)->format('H:i') }}
                        </small>
                      </div>
                    @else
                      <span style="color: #6c757d; font-style: italic;">-</span>
                    @endif
                  </td>
                  <td style="padding: 12px 10px; text-align: center; min-width: 140px; width: 140px;">
                    <div style="display: flex; flex-direction: column; gap: 4px; align-items: center;">
                      <a href="{{ route('admin.transaksi.show', $transaksi->id) }}" 
                         class="btn btn-info btn-sm" 
                         style="font-size: 0.75rem; padding: 4px 8px; width: 80px;">
                        Detail
                      </a>
                      @if($transaksi->status_booking === 'confirmed')
                        <button onclick="checkinCustomer({{ $transaksi->id }})" 
                                class="btn btn-success btn-sm" 
                                style="font-size: 0.75rem; padding: 4px 8px; width: 80px;">
                          Check In
                        </button>
                      @elseif($transaksi->status_booking === 'ongoing')
                        <button onclick="checkoutCustomer({{ $transaksi->id }})" 
                                class="btn btn-warning btn-sm" 
                                style="font-size: 0.75rem; padding: 4px 8px; width: 80px;">
                          Check Out
                        </button>
                      @endif
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="11" style="padding: 40px; text-align: center;">
                    <div style="color: #6c757d;">
                      <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 15px; display: block;"></i>
                      <p style="margin: 0; font-size: 1rem;">Belum ada transaksi</p>
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