@extends('layouts.app2')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/adminTransaksiDetail.css') }}">
@endpush

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-success">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.transaksi') }}" class="text-success">Transaksi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Transaksi</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4"
        style="
            background:#ffffff;
            padding:20px 24px;
            border-radius:12px;
            border:1px solid #e9ecef;
        ">
        <div>
            <h2 class="fw-bold mb-1"
                style="
                    font-size:1.5rem;
                    color:#212529;
                ">
                Detail Transaksi
            </h2>
            <p class="mb-0"
              style="
                  font-size:0.9rem;
                  color:#6c757d;
              ">
              Informasi lengkap transaksi #{{ $transaksi->kode_transaksi }}
            </p>
        </div>

        <a href="{{ route('admin.transaksi') }}"
          class="btn"
          style="
              border:1px solid #ced4da;
              color:#495057;
              padding:8px 14px;
              border-radius:10px;
              font-weight:500;
              background:#f8f9fa;
          ">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row detail-transaksi-main-row" style="margin-left: -12px; margin-right: -12px;">
      <!-- Main Content -->
      <div class="col-lg-8 detail-transaksi-main-content" style="padding-left: 12px; padding-right: 12px;">
          <!-- Invoice Card -->
          <div class="detail-transaksi-card shadow-sm mb-4" style="border-radius: 12px; border: 1px solid #e0e0e0; overflow: hidden; background: white;">
              <div class="detail-transaksi-card-header detail-transaksi-bg-gradient-primary text-white p-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                  <div class="d-flex justify-content-between align-items-center">
                      <div>
                          <h5 class="mb-2 fw-bold" style="font-size: 1.25rem; margin-bottom: 0.5rem;">Invoice Transaksi</h5>
                          <div class="detail-transaksi-invoice-code" style="font-size: 1.5rem; font-weight: 700; letter-spacing: 0.5px;">{{ $transaksi->kode_transaksi }}</div>
                      </div>
                      <div>
                          @if($transaksi->status_pembayaran === 'paid')
                              <span class="badge bg-success px-3 py-2" style="font-size: 0.9rem; background-color: #28a745; padding: 0.5rem 1rem; border-radius: 50px;">LUNAS</span>
                          @elseif($transaksi->status_pembayaran === 'pending')
                              <span class="badge bg-warning text-dark px-3 py-2" style="font-size: 0.9rem; background-color: #ffc107; color: #212529; padding: 0.5rem 1rem; border-radius: 50px;">MENUNGGU PEMBAYARAN</span>
                          @elseif($transaksi->status_pembayaran === 'failed')
                              <span class="badge bg-danger px-3 py-2" style="font-size: 0.9rem; background-color: #dc3545; padding: 0.5rem 1rem; border-radius: 50px;">PEMBAYARAN GAGAL</span>
                          @else
                              <span class="badge bg-danger px-3 py-2" style="font-size: 0.9rem; background-color: #dc3545; padding: 0.5rem 1rem; border-radius: 50px;">{{ strtoupper($transaksi->status_pembayaran_text) }}</span>
                          @endif
                      </div>
                  </div>
              </div>

              <div class="detail-transaksi-card-body p-4" style="padding: 1.5rem;">
                  <!-- Customer Info -->
                  <div class="mb-4" style="margin-bottom: 1.5rem;">
                      <h6 class="fw-bold mb-3 text-primary" style="font-weight: 700; margin-bottom: 1rem; color: #667eea;">
                          <i class="fas fa-user me-2" style="margin-right: 0.5rem;"></i>Informasi Pelanggan
                      </h6>
                      <div class="detail-transaksi-info-box p-3" style="background-color: #f8f9fa; border-radius: 8px; padding: 1rem; border-left: 4px solid #667eea;">
                          <div class="row">
                              <div class="col-md-6 mb-3" style="margin-bottom: 1rem;">
                                  <small class="text-muted d-block mb-1" style="color: #6c757d; display: block; margin-bottom: 0.25rem; font-size: 0.875rem;">Nama Lengkap</small>
                                  <span class="fw-semibold" style="font-weight: 600;">{{ $transaksi->user->name ?? 'Customer' }}</span>
                              </div>
                              <div class="col-md-6 mb-3" style="margin-bottom: 1rem;">
                                  <small class="text-muted d-block mb-1" style="color: #6c757d; display: block; margin-bottom: 0.25rem; font-size: 0.875rem;">Email</small>
                                  <span class="fw-semibold" style="font-weight: 600;">{{ $transaksi->user->email ?? '-' }}</span>
                              </div>
                              @if($transaksi->user->no_telepon ?? null)
                              <div class="col-md-6">
                                  <small class="text-muted d-block mb-1" style="color: #6c757d; display: block; margin-bottom: 0.25rem; font-size: 0.875rem;">No. Telepon</small>
                                  <span class="fw-semibold" style="font-weight: 600;">{{ $transaksi->user->no_telepon }}</span>
                              </div>
                              @endif
                          </div>
                      </div>
                  </div>

                  <!-- Booking Info -->
                  <div class="mb-4" style="margin-bottom: 1.5rem;">
                      <h6 class="fw-bold mb-3 text-primary" style="font-weight: 700; margin-bottom: 1rem; color: #667eea;">
                          <i class="fas fa-calendar-check me-2" style="margin-right: 0.5rem;"></i>Informasi Booking
                      </h6>
                      <div class="detail-transaksi-info-box p-3" style="background-color: #f8f9fa; border-radius: 8px; padding: 1rem; border-left: 4px solid #28a745;">
                          <div class="row">
                              <div class="col-md-6 mb-3" style="margin-bottom: 1rem;">
                                  <small class="text-muted d-block mb-1" style="color: #6c757d; display: block; margin-bottom: 0.25rem; font-size: 0.875rem;">Tanggal Booking</small>
                                  <span class="fw-semibold" style="font-weight: 600;">{{ $transaksi->formatted_tanggal_booking }}</span>
                              </div>
                              <div class="col-md-6 mb-3" style="margin-bottom: 1rem;">
                                  <small class="text-muted d-block mb-1" style="color: #6c757d; display: block; margin-bottom: 0.25rem; font-size: 0.875rem;">Waktu</small>
                                  <span class="fw-semibold" style="font-weight: 600;">{{ $transaksi->formatted_jam_mulai }} - {{ $transaksi->formatted_jam_selesai }} WIB</span>
                              </div>
                              <div class="col-md-6">
                                  <small class="text-muted d-block mb-1" style="color: #6c757d; display: block; margin-bottom: 0.25rem; font-size: 0.875rem;">Durasi</small>
                                  <span class="fw-semibold" style="font-weight: 600;">{{ $transaksi->durasi }} Jam</span>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Order Details -->
                  <div class="mb-4" style="margin-bottom: 1.5rem;">
                      <h6 class="fw-bold mb-3 text-primary" style="font-weight: 700; margin-bottom: 1rem; color: #667eea;">
                          <i class="fas fa-list me-2" style="margin-right: 0.5rem;"></i>Detail Pesanan
                      </h6>
                      <div class="table-responsive">
                          <table class="table table-bordered detail-transaksi-table-bordered" style="width: 100%; border-collapse: collapse;">
                              <thead class="table-light" style="background-color: #f8f9fa;">
                                  <tr>
                                      <th style="padding: 0.75rem; border: 1px solid #dee2e6;">Meja</th>
                                      <th style="padding: 0.75rem; border: 1px solid #dee2e6;">Kategori</th>
                                      <th style="padding: 0.75rem; border: 1px solid #dee2e6;">Durasi</th>
                                      <th style="padding: 0.75rem; border: 1px solid #dee2e6;">Harga/Jam</th>
                                      <th style="padding: 0.75rem; border: 1px solid #dee2e6;">Subtotal</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td class="fw-semibold" style="padding: 0.75rem; border: 1px solid #dee2e6; font-weight: 600;">{{ $transaksi->meja->nama_meja }}</td>
                                      <td style="padding: 0.75rem; border: 1px solid #dee2e6;">
                                          @if($transaksi->meja->category->nama === 'VIP')
                                              <span class="badge bg-warning text-dark" style="background-color: #ffc107; color: #212529; padding: 0.25rem 0.5rem; border-radius: 4px;">{{ $transaksi->meja->category->nama }}</span>
                                          @else
                                              <span class="badge bg-info" style="background-color: #17a2b8; padding: 0.25rem 0.5rem; border-radius: 4px;">{{ $transaksi->meja->category->nama }}</span>
                                          @endif
                                      </td>
                                      <td style="padding: 0.75rem; border: 1px solid #dee2e6;">{{ $transaksi->durasi }} Jam</td>
                                      <td style="padding: 0.75rem; border: 1px solid #dee2e6;">{{ $transaksi->formatted_harga_per_jam }}</td>
                                      <td class="fw-bold text-success" style="padding: 0.75rem; border: 1px solid #dee2e6; font-weight: 700; color: #28a745;">{{ $transaksi->formatted_total_harga }}</td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                      <div class="text-end p-3 bg-light rounded" style="text-align: right; padding: 1rem; background-color: #f8f9fa; border-radius: 8px; margin-top: 1rem;">
                          <h5 class="mb-0" style="margin-bottom: 0; font-size: 1.25rem;">
                              <span class="text-muted me-3" style="color: #6c757d; margin-right: 1rem;">Total Pembayaran:</span>
                              <span class="text-success fw-bold" style="color: #28a745; font-weight: 700;">{{ $transaksi->formatted_total_harga }}</span>
                          </h5>
                      </div>
                  </div>

                  <!-- Payment Info -->
                  <div class="mb-4" style="margin-bottom: 1.5rem;">
                      <h6 class="fw-bold mb-3 text-primary" style="font-weight: 700; margin-bottom: 1rem; color: #667eea;">
                          <i class="fas fa-credit-card me-2" style="margin-right: 0.5rem;"></i>Informasi Pembayaran
                      </h6>
                      <div class="detail-transaksi-info-box p-3" style="background-color: #f8f9fa; border-radius: 8px; padding: 1rem; border-left: 4px solid #fd7e14;">
                          <div class="row">
                              <div class="col-md-6 mb-3" style="margin-bottom: 1rem;">
                                  <small class="text-muted d-block mb-1" style="color: #6c757d; display: block; margin-bottom: 0.25rem; font-size: 0.875rem;">Metode Pembayaran</small>
                                  <span class="fw-semibold" style="font-weight: 600;">{{ $transaksi->payment_type ?? $transaksi->metode_pembayaran ?? 'Belum dipilih' }}</span>
                              </div>
                              <div class="col-md-6 mb-3" style="margin-bottom: 1rem;">
                                  <small class="text-muted d-block mb-1" style="color: #6c757d; display: block; margin-bottom: 0.25rem; font-size: 0.875rem;">Status Pembayaran</small>
                                  @if($transaksi->status_pembayaran === 'paid')
                                      <span class="fw-bold text-success" style="font-weight: 700; color: #28a745;">Lunas</span>
                                  @elseif($transaksi->status_pembayaran === 'pending')
                                      <span class="fw-bold text-warning" style="font-weight: 700; color: #ffc107;">Menunggu Pembayaran</span>
                                  @else
                                      <span class="fw-bold text-danger" style="font-weight: 700; color: #dc3545;">{{ $transaksi->status_pembayaran_text }}</span>
                                  @endif
                              </div>
                              @if($transaksi->paid_at)
                              <div class="col-md-6 mb-3" style="margin-bottom: 1rem;">
                                  <small class="text-muted d-block mb-1" style="color: #6c757d; display: block; margin-bottom: 0.25rem; font-size: 0.875rem;">Tanggal Pembayaran</small>
                                  <span class="fw-semibold" style="font-weight: 600;">{{ $transaksi->paid_at->format('d/m/Y H:i') }} WIB</span>
                              </div>
                              @endif
                              @if($transaksi->midtrans_order_id)
                              <div class="col-md-6">
                                  <small class="text-muted d-block mb-1" style="color: #6c757d; display: block; margin-bottom: 0.25rem; font-size: 0.875rem;">Order ID Midtrans</small>
                                  <span class="fw-semibold"><code class="detail-transaksi-code" style="background-color: #e9ecef; padding: 0.2rem 0.4rem; border-radius: 4px; font-family: monospace;">{{ $transaksi->midtrans_order_id }}</code></span>
                              </div>
                              @endif
                          </div>
                      </div>
                  </div>

                  <!-- Check-in/Check-out Info -->
                  @if($transaksi->waktu_checkin || $transaksi->waktu_checkout)
                  <div class="mb-4" style="margin-bottom: 1.5rem;">
                      <h6 class="fw-bold mb-3 text-primary" style="font-weight: 700; margin-bottom: 1rem; color: #667eea;">
                          <i class="fas fa-door-open me-2" style="margin-right: 0.5rem;"></i>Informasi Check-in/Check-out
                      </h6>
                      <div class="detail-transaksi-info-box p-3" style="background-color: #f8f9fa; border-radius: 8px; padding: 1rem; border-left: 4px solid #6f42c1;">
                          <div class="row">
                              @if($transaksi->waktu_checkin)
                              <div class="col-md-6 mb-3" style="margin-bottom: 1rem;">
                                  <small class="text-muted d-block mb-1" style="color: #6c757d; display: block; margin-bottom: 0.25rem; font-size: 0.875rem;">Waktu Check-in</small>
                                  <span class="fw-semibold" style="font-weight: 600;">{{ $transaksi->waktu_checkin->format('d/m/Y H:i') }} WIB</span>
                              </div>
                              @endif
                              @if($transaksi->waktu_checkout)
                              <div class="col-md-6">
                                  <small class="text-muted d-block mb-1" style="color: #6c757d; display: block; margin-bottom: 0.25rem; font-size: 0.875rem;">Waktu Check-out</small>
                                  <span class="fw-semibold" style="font-weight: 600;">{{ $transaksi->waktu_checkout->format('d/m/Y H:i') }} WIB</span>
                              </div>
                              @endif
                          </div>
                      </div>
                  </div>
                  @endif

                  @if($transaksi->catatan)
                  <!-- Notes -->
                  <div class="mb-4" style="margin-bottom: 1.5rem;">
                      <h6 class="fw-bold mb-3 text-primary" style="font-weight: 700; margin-bottom: 1rem; color: #667eea;">
                          <i class="fas fa-sticky-note me-2" style="margin-right: 0.5rem;"></i>Catatan
                      </h6>
                      <div class="detail-transaksi-info-box p-3" style="background-color: #f8f9fa; border-radius: 8px; padding: 1rem; border-left: 4px solid #20c997;">
                          <p class="mb-0" style="margin-bottom: 0;">{{ $transaksi->catatan }}</p>
                      </div>
                  </div>
                  @endif
              </div>
          </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4 detail-transaksi-sidebar" style="padding-left: 12px; padding-right: 12px;">
          <!-- Status Card -->
          <div class="detail-transaksi-card shadow-sm mb-4" style="border-radius: 12px; border: 1px solid #e0e0e0; overflow: hidden; background: white;">
              <div class="detail-transaksi-card-header bg-light" style="background-color: #f8f9fa; padding: 1rem 1.5rem;">
                  <h6 class="mb-0 fw-bold" style="margin-bottom: 0; font-weight: 700;">
                      <i class="fas fa-info-circle me-2" style="margin-right: 0.5rem;"></i>Status Booking
                  </h6>
              </div>
              <div class="detail-transaksi-card-body text-center" style="padding: 1.5rem; text-align: center;">
                  @if($transaksi->status_booking === 'confirmed')
                      <div class="mb-3" style="margin-bottom: 1rem;">
                          <i class="fas fa-check-circle text-info" style="font-size: 3rem; color: #17a2b8;"></i>
                      </div>
                      <h6 class="fw-bold text-info" style="font-weight: 700; color: #17a2b8;">DIKONFIRMASI</h6>
                      <p class="text-muted small mb-3" style="color: #6c757d; font-size: 0.875rem; margin-bottom: 1rem;">Booking telah dikonfirmasi</p>
                      <button class="detail-transaksi-btn detail-transaksi-btn-success w-100" onclick="checkinCustomer({{ $transaksi->id }})" style="background-color: #28a745; color: white; border: none; padding: 0.75rem; border-radius: 6px; width: 100%; font-weight: 500; cursor: pointer; transition: background-color 0.3s;">
                          <i class="fas fa-sign-in-alt me-2" style="margin-right: 0.5rem;"></i>Check In Customer
                      </button>
                  @elseif($transaksi->status_booking === 'ongoing')
                      <div class="mb-3" style="margin-bottom: 1rem;">
                          <i class="fas fa-clock text-primary" style="font-size: 3rem; color: #667eea;"></i>
                      </div>
                      <h6 class="fw-bold text-primary" style="font-weight: 700; color: #667eea;">SEDANG BERLANGSUNG</h6>
                      <p class="text-muted small mb-3" style="color: #6c757d; font-size: 0.875rem; margin-bottom: 1rem;">Customer sedang menggunakan meja</p>
                      <button class="detail-transaksi-btn detail-transaksi-btn-warning w-100" onclick="checkoutCustomer({{ $transaksi->id }})" style="background-color: #ffc107; color: #212529; border: none; padding: 0.75rem; border-radius: 6px; width: 100%; font-weight: 500; cursor: pointer; transition: background-color 0.3s;">
                          <i class="fas fa-sign-out-alt me-2" style="margin-right: 0.5rem;"></i>Check Out Customer
                      </button>
                  @elseif($transaksi->status_booking === 'completed')
                      <div class="mb-3" style="margin-bottom: 1rem;">
                          <i class="fas fa-check-double text-success" style="font-size: 3rem; color: #28a745;"></i>
                      </div>
                      <h6 class="fw-bold text-success" style="font-weight: 700; color: #28a745;">SELESAI</h6>
                      <p class="text-muted small mb-0" style="color: #6c757d; font-size: 0.875rem; margin-bottom: 0;">Transaksi telah selesai</p>
                  @else
                      <div class="mb-3" style="margin-bottom: 1rem;">
                          <i class="fas fa-times-circle text-secondary" style="font-size: 3rem; color: #6c757d;"></i>
                      </div>
                      <h6 class="fw-bold text-secondary" style="font-weight: 700; color: #6c757d;">{{ strtoupper($transaksi->status_booking_text) }}</h6>
                  @endif
              </div>
          </div>

          <!-- Action Buttons Card -->
          <div class="detail-transaksi-card shadow-sm mb-4" style="border-radius: 12px; border: 1px solid #e0e0e0; overflow: hidden; background: white;">
              <div class="detail-transaksi-card-header bg-light" style="background-color: #f8f9fa; padding: 1rem 1.5rem;">
                  <h6 class="mb-0 fw-bold" style="margin-bottom: 0; font-weight: 700;">
                      <i class="fas fa-cog me-2" style="margin-right: 0.5rem;"></i>Aksi Admin
                  </h6>
              </div>
              <div class="detail-transaksi-card-body" style="padding: 1.5rem;">
                  <div class="d-grid gap-2" style="display: grid; gap: 0.5rem;">
                      <button class="detail-transaksi-btn detail-transaksi-btn-primary" onclick="printInvoice()" style="background-color: #667eea; color: white; border: none; padding: 0.75rem; border-radius: 6px; font-weight: 500; cursor: pointer; transition: background-color 0.3s;">
                          <i class="fas fa-print me-2" style="margin-right: 0.5rem;"></i>Cetak Invoice
                      </button>
                      <button class="detail-transaksi-btn detail-transaksi-btn-info text-white" onclick="sendEmail()" style="background-color: #17a2b8; color: white; border: none; padding: 0.75rem; border-radius: 6px; font-weight: 500; cursor: pointer; transition: background-color 0.3s;">
                          <i class="fas fa-envelope me-2" style="margin-right: 0.5rem;"></i>Kirim Email
                      </button>
                      @if($transaksi->status_pembayaran !== 'paid' && $transaksi->status_booking !== 'completed')
                      <button class="detail-transaksi-btn detail-transaksi-btn-danger" onclick="cancelTransaction({{ $transaksi->id }})" style="background-color: #dc3545; color: white; border: none; padding: 0.75rem; border-radius: 6px; font-weight: 500; cursor: pointer; transition: background-color 0.3s;">
                          <i class="fas fa-times me-2" style="margin-right: 0.5rem;"></i>Batalkan Transaksi
                      </button>
                      @endif
                  </div>
              </div>
          </div>

          <!-- Help Card -->
          <div class="detail-transaksi-card shadow-sm" style="border-radius: 12px; border: 1px solid #e0e0e0; overflow: hidden; background: white;">
              <div class="detail-transaksi-card-header bg-light" style="background-color: #f8f9fa; padding: 1rem 1.5rem;">
                  <h6 class="mb-0 fw-bold" style="margin-bottom: 0; font-weight: 700;">
                      <i class="fas fa-question-circle me-2" style="margin-right: 0.5rem;"></i>Bantuan Admin
                  </h6>
              </div>
              <div class="detail-transaksi-card-body" style="padding: 1.5rem;">
                  <p class="text-muted small mb-3" style="color: #6c757d; font-size: 0.875rem; margin-bottom: 1rem;">Panduan untuk admin</p>
                  <div class="d-grid gap-2" style="display: grid; gap: 0.5rem;">
                      <a href="#" class="detail-transaksi-btn detail-transaksi-btn-outline-success detail-transaksi-btn-sm" style="border: 1px solid #28a745; color: #28a745; background: transparent; padding: 0.5rem; border-radius: 6px; text-decoration: none; font-size: 0.875rem; font-weight: 500; text-align: center; transition: all 0.3s;">
                          <i class="fas fa-book me-2" style="margin-right: 0.5rem;"></i>Manual Admin
                      </a>
                      <a href="#" class="detail-transaksi-btn detail-transaksi-btn-outline-primary detail-transaksi-btn-sm" style="border: 1px solid #667eea; color: #667eea; background: transparent; padding: 0.5rem; border-radius: 6px; text-decoration: none; font-size: 0.875rem; font-weight: 500; text-align: center; transition: all 0.3s;">
                          <i class="fas fa-headset me-2" style="margin-right: 0.5rem;"></i>Support IT
                      </a>
                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection

