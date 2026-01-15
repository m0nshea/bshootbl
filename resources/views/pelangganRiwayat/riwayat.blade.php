@extends('layouts.customer')

@section('title', 'Riwayat Pemesanan - Bshoot Billiard')
@section('description', 'Riwayat pemesanan meja billiard')

@push('styles')
<link href="{{ asset('css/customer-riwayat.css') }}" rel="stylesheet" />
<style>
.btn-pay-now {
    background: linear-gradient(45deg, #28a745, #20c997);
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
}

.btn-pay-now:hover {
    background: linear-gradient(45deg, #218838, #1ea085);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
    color: white;
}

.btn-view-detail {
    background: #17a2b8;
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-view-detail:hover {
    background: #138496;
    transform: translateY(-2px);
    color: white;
}

.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
    flex-wrap: wrap;
}

.table-badge.pending {
    background: linear-gradient(135deg, #ffc107, #ff9800);
    color: #fff;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state i {
    font-size: 4rem;
    color: #6c757d;
    margin-bottom: 20px;
}

.empty-state h5 {
    color: #333;
    margin-bottom: 10px;
}

.empty-state p {
    color: #6c757d;
    margin-bottom: 20px;
}
</style>
@endpush

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Riwayat Pemesanan</h1>
        <p class="page-subtitle">Kelola dan pantau semua pemesanan Anda</p>
    </div>

    <!-- Status Info Section -->
    <div class="status-info">
        <div class="status-title">
            <i class="bi bi-info-circle"></i>
            Keterangan Status:
        </div>
        <div class="status-items">
            <div class="status-item">
                <div class="status-badge pending">
                    <i class="bi bi-clock-history"></i>
                    MENUNGGU PEMBAYARAN
                </div>
                <span class="status-description">Segera selesaikan pembayaran</span>
            </div>
            <div class="status-item">
                <div class="status-badge siap-main">
                    <i class="bi bi-check-circle"></i>
                    SUDAH DIBAYAR
                </div>
                <span class="status-description">Pemesanan berhasil, siap dimainkan</span>
            </div>
            <div class="status-item">
                <div class="status-badge expired">
                    <i class="bi bi-x-circle"></i>
                    DIBATALKAN/EXPIRED
                </div>
                <span class="status-description">Pemesanan dibatalkan atau kadaluarsa</span>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="bi bi-info-circle me-2"></i>{{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Table Section -->
    <div class="table-container">
        @if($transaksis->count() > 0)
        <table class="riwayat-table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>KODE TRANSAKSI</th>
                    <th>MEJA</th>
                    <th>TANGGAL MAIN</th>
                    <th>JAM MAIN</th>
                    <th>DURASI</th>
                    <th>TOTAL</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $index => $transaksi)
                <tr>
                    <td>{{ $transaksis->firstItem() + $index }}</td>
                    <td><strong>{{ $transaksi->kode_transaksi }}</strong></td>
                    <td>{{ $transaksi->meja->nama_meja }}</td>
                    <td>{{ $transaksi->formatted_tanggal_booking }}</td>
                    <td>{{ $transaksi->formatted_jam_mulai }} - {{ $transaksi->formatted_jam_selesai }}</td>
                    <td>{{ $transaksi->durasi }} Jam</td>
                    <td><strong>{{ $transaksi->formatted_total_harga }}</strong></td>
                    <td>
                        <span class="table-badge {{ $transaksi->status_pembayaran === 'paid' ? 'siap-main' : ($transaksi->status_pembayaran === 'pending' ? 'pending' : 'expired') }}">
                            {{ $transaksi->status_pembayaran_text }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            @if($transaksi->status_pembayaran === 'pending')
                                <button class="btn-pay-now" onclick="payNow('{{ $transaksi->id }}', '{{ $transaksi->snap_token }}')">
                                    <i class="bi bi-credit-card me-1"></i>Bayar
                                </button>
                            @endif
                            <a href="{{ route('customer.riwayat.detail', $transaksi->id) }}" class="btn-view-detail">
                                <i class="bi bi-eye me-1"></i>Detail
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        @if($transaksis->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $transaksis->links('pagination::bootstrap-4') }}
        </div>
        @endif
        @else
        <!-- Empty State -->
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h5>Belum Ada Riwayat Pemesanan</h5>
            <p>Anda belum memiliki riwayat pemesanan. Mulai booking meja sekarang!</p>
            <a href="{{ route('customer.meja') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i>Booking Meja
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<!-- Midtrans Snap JS -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<!-- For Production: -->
<!-- <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script> -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function payNow(transaksiId, snapToken) {
    if (!snapToken) {
        Swal.fire({
            icon: 'error',
            title: 'Token Tidak Ditemukan',
            text: 'Token pembayaran tidak ditemukan. Silakan refresh halaman atau hubungi admin.',
            confirmButtonColor: '#dc3545'
        });
        return;
    }

    // Trigger Midtrans Snap
    window.snap.pay(snapToken, {
        onSuccess: function(result) {
            console.log('Payment success:', result);
            Swal.fire({
                icon: 'success',
                title: 'Pembayaran Berhasil!',
                text: 'Terima kasih, pembayaran Anda telah dikonfirmasi.',
                confirmButtonColor: '#28a745'
            }).then(() => {
                window.location.reload();
            });
        },
        onPending: function(result) {
            console.log('Payment pending:', result);
            Swal.fire({
                icon: 'info',
                title: 'Pembayaran Pending',
                text: 'Pembayaran Anda sedang diproses. Silakan selesaikan pembayaran.',
                confirmButtonColor: '#17a2b8'
            }).then(() => {
                window.location.reload();
            });
        },
        onError: function(result) {
            console.log('Payment error:', result);
            Swal.fire({
                icon: 'error',
                title: 'Pembayaran Gagal',
                text: 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.',
                confirmButtonColor: '#dc3545'
            });
        },
        onClose: function() {
            console.log('Payment popup closed');
            Swal.fire({
                icon: 'warning',
                title: 'Pembayaran Dibatalkan',
                text: 'Anda menutup halaman pembayaran. Silakan lanjutkan pembayaran untuk menyelesaikan booking.',
                confirmButtonColor: '#ffc107'
            });
        }
    });
}

// Auto dismiss alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>
@endpush