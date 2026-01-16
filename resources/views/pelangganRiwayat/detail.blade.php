@extends('layouts.customer')

@section('title', 'Detail Pemesanan - Bshoot Billiard')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.beranda') }}" class="text-success">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.riwayat') }}" class="text-success">Riwayat Pemesanan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Transaksi</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-2">Detail Transaksi</h2>
            <p class="text-muted mb-0">Informasi lengkap pesanan Anda</p>
        </div>
        <a href="{{ route('customer.riwayat') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Invoice Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-gradient-primary text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-2 fw-bold">Invoice Pemesanan</h5>
                            <div class="invoice-code">{{ $transaksi->kode_transaksi }}</div>
                        </div>
                        <div>
                            @if($transaksi->status_pembayaran === 'paid')
                                <span class="badge bg-success px-3 py-2" style="font-size: 0.9rem;">LUNAS</span>
                            @elseif($transaksi->status_pembayaran === 'pending')
                                <span class="badge bg-warning text-dark px-3 py-2" style="font-size: 0.9rem;">MENUNGGU PEMBAYARAN</span>
                            @else
                                <span class="badge bg-danger px-3 py-2" style="font-size: 0.9rem;">{{ strtoupper($transaksi->status_pembayaran_text) }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Customer Info -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3 text-primary">
                            <i class="fas fa-user me-2"></i>Informasi Pemesan
                        </h6>
                        <div class="info-box p-3">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block mb-1">Nama Lengkap</small>
                                    <span class="fw-semibold">{{ $transaksi->nama_pelanggan }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block mb-1">Email</small>
                                    <span class="fw-semibold">{{ $transaksi->email_pelanggan }}</span>
                                </div>
                                @if($transaksi->no_telepon)
                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-1">No. Telepon</small>
                                    <span class="fw-semibold">{{ $transaksi->no_telepon }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Booking Info -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3 text-primary">
                            <i class="fas fa-calendar-check me-2"></i>Informasi Booking
                        </h6>
                        <div class="info-box p-3">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block mb-1">Tanggal Booking</small>
                                    <span class="fw-semibold">{{ $transaksi->formatted_tanggal_booking }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block mb-1">Waktu</small>
                                    <span class="fw-semibold">{{ $transaksi->formatted_jam_mulai }} - {{ $transaksi->formatted_jam_selesai }} WIB</span>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-1">Durasi</small>
                                    <span class="fw-semibold">{{ $transaksi->durasi }} Jam</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3 text-primary">
                            <i class="fas fa-list me-2"></i>Detail Pesanan
                        </h6>
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
                                        <td class="fw-bold text-success">{{ $transaksi->formatted_total_harga }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end p-3 bg-light rounded">
                            <h5 class="mb-0">
                                <span class="text-muted me-3">Total Pembayaran:</span>
                                <span class="text-success fw-bold">{{ $transaksi->formatted_total_harga }}</span>
                            </h5>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3 text-primary">
                            <i class="fas fa-credit-card me-2"></i>Informasi Pembayaran
                        </h6>
                        <div class="info-box p-3">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block mb-1">Metode Pembayaran</small>
                                    <span class="fw-semibold">{{ $transaksi->payment_type ?? $transaksi->metode_pembayaran ?? 'Belum dipilih' }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted d-block mb-1">Status Pembayaran</small>
                                    @if($transaksi->status_pembayaran === 'paid')
                                        <span class="fw-bold text-success">Lunas</span>
                                    @elseif($transaksi->status_pembayaran === 'pending')
                                        <span class="fw-bold text-warning">Menunggu Pembayaran</span>
                                    @else
                                        <span class="fw-bold text-danger">{{ $transaksi->status_pembayaran_text }}</span>
                                    @endif
                                </div>
                                @if($transaksi->paid_at)
                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-1">Tanggal Pembayaran</small>
                                    <span class="fw-semibold">{{ $transaksi->paid_at->format('d/m/Y H:i') }} WIB</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($transaksi->catatan)
                    <!-- Notes -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3 text-primary">
                            <i class="fas fa-sticky-note me-2"></i>Catatan
                        </h6>
                        <div class="info-box p-3">
                            <p class="mb-0">{{ $transaksi->catatan }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2"></i>Status Booking
                    </h6>
                </div>
                <div class="card-body text-center">
                    @if($transaksi->status_booking === 'confirmed')
                        <div class="mb-3">
                            <i class="fas fa-check-circle text-info" style="font-size: 3rem;"></i>
                        </div>
                        <h6 class="fw-bold text-info">DIKONFIRMASI</h6>
                        <p class="text-muted small mb-0">Pesanan Anda telah dikonfirmasi</p>
                    @elseif($transaksi->status_booking === 'ongoing')
                        <div class="mb-3">
                            <i class="fas fa-clock text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h6 class="fw-bold text-primary">SEDANG BERLANGSUNG</h6>
                        <p class="text-muted small mb-0">Anda sedang menggunakan meja</p>
                    @elseif($transaksi->status_booking === 'completed')
                        <div class="mb-3">
                            <i class="fas fa-check-double text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h6 class="fw-bold text-success">SELESAI</h6>
                        <p class="text-muted small mb-0">Terima kasih atas kunjungan Anda</p>
                    @else
                        <div class="mb-3">
                            <i class="fas fa-times-circle text-secondary" style="font-size: 3rem;"></i>
                        </div>
                        <h6 class="fw-bold text-secondary">{{ strtoupper($transaksi->status_booking_text) }}</h6>
                    @endif
                </div>
            </div>

            <!-- Payment Action -->
            @if($transaksi->status_pembayaran === 'pending' && $transaksi->snap_token)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-exclamation-triangle me-2"></i>Pembayaran Pending
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Silakan selesaikan pembayaran Anda</p>
                    <button class="btn btn-success w-100" id="pay-button">
                        <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                    </button>
                </div>
            </div>
            @endif

            <!-- Help Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-question-circle me-2"></i>Butuh Bantuan?
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Hubungi kami jika ada pertanyaan</p>
                    <div class="d-grid gap-2">
                        <a href="https://wa.me/6281234567890" class="btn btn-outline-success btn-sm" target="_blank">
                            <i class="fab fa-whatsapp me-2"></i>WhatsApp
                        </a>
                        <a href="mailto:support@billiard.com" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-envelope me-2"></i>Email
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.invoice-code {
    font-family: 'Courier New', monospace;
    font-weight: 700;
    font-size: 1.3rem;
    background: rgba(255,255,255,0.2);
    padding: 6px 12px;
    border-radius: 6px;
    display: inline-block;
}

.info-box {
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.card {
    border: none;
    border-radius: 12px;
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
}

.table-bordered {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
}

.table thead {
    background: #f8f9fa;
}

.breadcrumb {
    background: none;
    padding: 0;
}

.breadcrumb-item a {
    text-decoration: none;
}

.btn {
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 500;
}

@media (max-width: 768px) {
    .invoice-code {
        font-size: 1rem;
    }
}
</style>
@endpush

@push('scripts')
@if($transaksi->status_pembayaran === 'pending' && $transaksi->snap_token)
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
document.getElementById('pay-button').addEventListener('click', function() {
    snap.pay('{{ $transaksi->snap_token }}', {
        onSuccess: function(result) {
            console.log('Payment success:', result);
            window.location.href = '{{ route("customer.riwayat") }}?payment=success';
        },
        onPending: function(result) {
            console.log('Payment pending:', result);
            window.location.href = '{{ route("customer.riwayat") }}?payment=pending';
        },
        onError: function(result) {
            console.log('Payment error:', result);
            alert('Pembayaran gagal. Silakan coba lagi.');
        },
        onClose: function() {
            console.log('Payment popup closed');
        }
    });
});
</script>
@endif
@endpush
