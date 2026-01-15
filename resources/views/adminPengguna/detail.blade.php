@extends('layouts.app2')

@section('content')
<div class="content-wrapper">
  <div class="container-fluid">

    <!-- Breadcrumb -->
    <div class="breadcrumb-section mb-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-success">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.pengguna.index') }}" class="text-success">Pengguna</a></li>
          <li class="breadcrumb-item active" aria-current="page">Detail Pengguna</li>
        </ol>
      </nav>
    </div>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="page-title">Detail Pengguna</h2>
        <p class="page-subtitle">Informasi lengkap pengguna dan riwayat transaksi</p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('admin.pengguna.edit', $pengguna->id) }}" class="btn btn-primary">
          <i class="fas fa-edit me-1"></i> Edit Pengguna
        </a>
        <a href="{{ route('admin.pengguna.index') }}" class="btn btn-secondary">Kembali</a>
      </div>
    </div>

    <div class="row">
      <!-- User Information Card -->
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Informasi Pengguna</h5>
          </div>
          <div class="card-body text-center">
            <div class="avatar-placeholder mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
              <i class="fas fa-user"></i>
            </div>
            
            <h4 class="mb-1">{{ $pengguna->name }}</h4>
            <p class="text-muted mb-3">{{ $pengguna->email }}</p>
            
            <div class="d-flex justify-content-center gap-2 mb-3">
              <span class="badge {{ $pengguna->role_badge }}">{{ $pengguna->role_text }}</span>
              <span class="badge {{ $pengguna->status_badge }}">{{ $pengguna->status_text }}</span>
            </div>
            
            <div class="user-details">
              <div class="detail-row">
                <strong>No. Telepon:</strong>
                <span>{{ $pengguna->no_telepon ?: '-' }}</span>
              </div>
              
              @if($pengguna->alamat)
              <div class="detail-row">
                <strong>Alamat:</strong>
                <span>{{ $pengguna->alamat }}</span>
              </div>
              @endif
              
              <div class="detail-row">
                <strong>Tanggal Daftar:</strong>
                <span>{{ $pengguna->formatted_created_at }}</span>
              </div>
              
              @if($pengguna->last_login_at)
              <div class="detail-row">
                <strong>Login Terakhir:</strong>
                <span>{{ $pengguna->last_login_at->format('d/m/Y H:i') }}</span>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>

      <!-- Statistics Card -->
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Statistik Pengguna</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <div class="stat-card">
                  <div class="stat-number">{{ $userStats['total_transaksi'] }}</div>
                  <div class="stat-label">Total Transaksi</div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="stat-card">
                  <div class="stat-number text-success">Rp {{ number_format($userStats['total_spent'], 0, ',', '.') }}</div>
                  <div class="stat-label">Total Spent</div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="stat-card">
                  <div class="stat-number text-info">{{ $userStats['transaksi_completed'] }}</div>
                  <div class="stat-label">Transaksi Selesai</div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="stat-card">
                  <div class="stat-number text-warning">{{ $userStats['transaksi_pending'] }}</div>
                  <div class="stat-label">Pending Payment</div>
                </div>
              </div>
            </div>
            
            @if($userStats['favorite_meja'])
            <div class="mt-4">
              <h6>Meja Favorit:</h6>
              <div class="d-flex align-items-center">
                <span class="badge bg-info me-2">{{ $userStats['favorite_meja']->nama_meja }}</span>
                <small class="text-muted">{{ $userStats['favorite_meja']->category->nama }}</small>
              </div>
            </div>
            @endif
            
            @if($userStats['last_transaction'])
            <div class="mt-3">
              <h6>Transaksi Terakhir:</h6>
              <div class="d-flex justify-content-between align-items-center">
                <span>{{ $userStats['last_transaction']->kode_transaksi }}</span>
                <span class="text-muted">{{ $userStats['last_transaction']->created_at->format('d/m/Y') }}</span>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Transaction History -->
    @if($pengguna->transaksis->count() > 0)
    <div class="card mt-4">
      <div class="card-header">
        <h5 class="card-title mb-0">Riwayat Transaksi</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Kode Transaksi</th>
                <th>Meja</th>
                <th>Tanggal</th>
                <th>Durasi</th>
                <th>Total</th>
                <th>Status Pembayaran</th>
                <th>Status Booking</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pengguna->transaksis->sortByDesc('created_at')->take(10) as $transaksi)
              <tr>
                <td>
                  <a href="{{ route('admin.transaksi.show', $transaksi->id) }}" class="text-primary">
                    {{ $transaksi->kode_transaksi }}
                  </a>
                </td>
                <td>
                  <span class="fw-semibold">{{ $transaksi->meja->nama_meja }}</span><br>
                  <small class="text-muted">{{ $transaksi->meja->category->nama }}</small>
                </td>
                <td>
                  {{ $transaksi->formatted_tanggal_booking }}<br>
                  <small class="text-muted">{{ $transaksi->formatted_jam_mulai }} - {{ $transaksi->formatted_jam_selesai }}</small>
                </td>
                <td>{{ $transaksi->durasi }} jam</td>
                <td class="fw-bold text-success">{{ $transaksi->formatted_total_harga }}</td>
                <td>
                  <span class="badge {{ $transaksi->status_pembayaran_badge }}">
                    {{ $transaksi->status_pembayaran_text }}
                  </span>
                </td>
                <td>
                  <span class="badge {{ $transaksi->status_booking_badge }}">
                    {{ $transaksi->status_booking_text }}
                  </span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        
        @if($pengguna->transaksis->count() > 10)
        <div class="text-center mt-3">
          <a href="{{ route('admin.transaksi.index', ['search' => $pengguna->email]) }}" class="btn btn-outline-primary">
            Lihat Semua Transaksi
          </a>
        </div>
        @endif
      </div>
    </div>
    @endif

  </div>
</div>
@endsection

@push('styles')
<style>
.avatar-placeholder {
  background: #e9ecef;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #6c757d;
}

.user-details {
  text-align: left;
}

.detail-row {
  display: flex;
  justify-content: space-between;
  padding: 8px 0;
  border-bottom: 1px solid #f1f1f1;
}

.detail-row:last-child {
  border-bottom: none;
}

.stat-card {
  text-align: center;
  padding: 20px;
  background: #f8f9fa;
  border-radius: 8px;
  margin-bottom: 15px;
}

.stat-number {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 5px;
}

.stat-label {
  color: #6c757d;
  font-size: 0.9rem;
}

.card {
  border: 1px solid #dee2e6;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.card-header {
  background-color: #f8f9fa;
  border-bottom: 1px solid #dee2e6;
  padding: 15px 20px;
}

.card-title {
  color: #495057;
  font-weight: 600;
  font-size: 1.1rem;
  margin: 0;
}
</style>
@endpush