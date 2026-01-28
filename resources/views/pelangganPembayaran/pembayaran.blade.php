@extends('layouts.customer')

@section('title', 'Pembayaran - Bshoot Billiard')
@section('description', 'Halaman pembayaran dengan Midtrans - Bshoot Billiard')

@push('styles')
<style>
* {
    font-family: 'Poppins', sans-serif !important;
}

body {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: #333;
    min-height: 100vh;
}

.payment-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 30px 20px;
}

.payment-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    padding: 40px;
    margin-bottom: 30px;
}

.page-title {
    color: #1f2937;
    font-weight: 700;
    margin-bottom: 10px;
    text-align: center;
    font-size: 2.5rem;
}

.page-subtitle {
    color: #6b7280;
    text-align: center;
    margin-bottom: 40px;
    font-size: 1.1rem;
}

.order-summary {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 30px;
}

.order-summary h5 {
    color: #1f2937;
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e9ecef;
}

.order-detail {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #e9ecef;
}

.order-detail:last-child {
    border-bottom: none;
    padding-top: 15px;
    margin-top: 10px;
    border-top: 2px solid #28a745;
}

.order-detail.total {
    font-size: 1.3rem;
    font-weight: 700;
    color: #28a745;
}

.payment-info {
    background: linear-gradient(135deg, #e3f2fd, #bbdefb);
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 30px;
    border-left: 5px solid #2196f3;
}

.payment-info h6 {
    color: #1976d2;
    font-weight: 600;
    margin-bottom: 15px;
}

.payment-info ul {
    margin-bottom: 0;
    padding-left: 20px;
}

.payment-info li {
    color: #333;
    margin-bottom: 8px;
}

.btn-pay {
    background: linear-gradient(45deg, #28a745, #20c997);
    border: none;
    border-radius: 15px;
    padding: 15px 40px;
    font-weight: 700;
    font-size: 1.1rem;
    color: white;
    width: 100%;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.btn-pay:hover {
    background: linear-gradient(45deg, #218838, #1ea085);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
}

.btn-cancel {
    background: #6c757d;
    border: none;
    border-radius: 15px;
    padding: 12px 30px;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

.status-badge {
    display: inline-block;
    padding: 8px 20px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
}

.badge-pending {
    background: #fff3cd;
    color: #856404;
}

.badge-paid {
    background: #d4edda;
    color: #155724;
}

@media (max-width: 768px) {
    .payment-card {
        padding: 25px 20px;
    }
    
    .page-title {
        font-size: 2rem;
    }
}
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="payment-container">
        <div class="payment-card">
            <h1 class="page-title">Pembayaran</h1>
            <p class="page-subtitle">Kode Transaksi: <strong>{{ $transaksi->kode_transaksi }}</strong></p>

            <!-- Status Badge -->
            <div class="text-center mb-4">
                <span class="status-badge badge-{{ $transaksi->status_pembayaran === 'paid' ? 'paid' : 'pending' }}">
                    {{ $transaksi->status_pembayaran_text }}
                </span>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <h5><i class="fas fa-receipt me-2"></i>Detail Pesanan</h5>
                
                <div class="order-detail">
                    <span>Nama Pelanggan</span>
                    <strong>{{ $transaksi->user->name ?? 'Customer' }}</strong>
                </div>
                
                <div class="order-detail">
                    <span>Meja</span>
                    <strong>{{ $transaksi->meja->nama_meja }}</strong>
                </div>
                
                <div class="order-detail">
                    <span>Kategori</span>
                    <strong>{{ $transaksi->meja->category->nama }}</strong>
                </div>
                
                <div class="order-detail">
                    <span>Tanggal Booking</span>
                    <strong>{{ $transaksi->formatted_tanggal_booking }}</strong>
                </div>
                
                <div class="order-detail">
                    <span>Waktu</span>
                    <strong>{{ $transaksi->formatted_jam_mulai }} - {{ $transaksi->formatted_jam_selesai }}</strong>
                </div>
                
                <div class="order-detail">
                    <span>Durasi</span>
                    <strong>{{ $transaksi->durasi }} Jam</strong>
                </div>
                
                <div class="order-detail">
                    <span>Harga per Jam</span>
                    <strong>{{ $transaksi->formatted_harga_per_jam }}</strong>
                </div>
                
                <div class="order-detail total">
                    <span>Total Pembayaran</span>
                    <strong>{{ $transaksi->formatted_total_harga }}</strong>
                </div>
            </div>

            @if($transaksi->status_pembayaran === 'pending')
                <!-- Payment Info -->
                <div class="payment-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Informasi Pembayaran</h6>
                    <ul>
                        <li>Klik tombol "Bayar Sekarang" untuk melanjutkan pembayaran</li>
                        <li>Anda akan diarahkan ke halaman pembayaran Midtrans</li>
                        <li>Pilih metode pembayaran: QRIS, E-Wallet, atau Transfer Bank</li>
                        <li>Selesaikan pembayaran dalam waktu 24 jam</li>
                        <li>Status booking akan otomatis berubah setelah pembayaran berhasil</li>
                    </ul>
                </div>

                <!-- Payment Expiry Info -->
                @if($transaksi->payment_expires_at)
                <div class="alert alert-warning">
                    <i class="fas fa-clock me-2"></i>
                    <strong>Batas Waktu Pembayaran:</strong> 
                    {{ $transaksi->payment_expires_at->format('d/m/Y H:i') }} WIB
                </div>
                @endif

                <!-- Payment Button -->
                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" class="btn btn-cancel" onclick="window.location.href='{{ route('customer.riwayat') }}'">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </button>
                    <button type="button" class="btn btn-pay" id="pay-button">
                        <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                    </button>
                </div>
            @else
                <!-- Already Paid -->
                <div class="alert alert-success text-center">
                    <i class="fas fa-check-circle fa-3x mb-3"></i>
                    <h5>Pembayaran Berhasil!</h5>
                    <p class="mb-0">Terima kasih, pembayaran Anda telah dikonfirmasi.</p>
                </div>

                <div class="text-center">
                    <a href="{{ route('customer.riwayat') }}" class="btn btn-success">
                        <i class="fas fa-history me-2"></i>Lihat Riwayat
                    </a>
                </div>
            @endif
        </div>
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
document.addEventListener('DOMContentLoaded', function() {
    const payButton = document.getElementById('pay-button');
    
    if (payButton) {
        payButton.addEventListener('click', function() {
            // Show loading
            Swal.fire({
                title: 'Memproses...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Get snap token from backend
            const snapToken = '{{ $transaksi->snap_token ?? '' }}';
            
            if (!snapToken) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Token pembayaran tidak ditemukan. Silakan refresh halaman.'
                });
                return;
            }

            // Close loading
            Swal.close();

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
                        window.location.href = '{{ route('customer.payment.finish', $transaksi->id) }}';
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
                        window.location.href = '{{ route('customer.riwayat') }}';
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
        });
    }
});
</script>
@endpush

@push('styles')
<style>
* {
    font-family: 'Poppins', sans-serif !important;
}

body {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: #333;
    min-height: 100vh;
}

.navbar {
    background: white !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.nav-link {
    color: #333 !important;
    font-weight: 500;
    transition: color 0.3s ease;
}

.nav-link:hover {
    color: #28a745 !important;
}

.btn-login {
    background: #28a745;
    color: white;
    font-weight: 600;
    padding: 8px 24px;
    border-radius: 20px;
    border: none;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-login:hover {
    background: #218838;
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
}

.payment-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 30px 20px;
}

.payment-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    padding: 40px;
    margin-bottom: 30px;
}

.page-title {
    color: #1f2937;
    font-weight: 700;
    margin-bottom: 10px;
    text-align: center;
    font-size: 2.5rem;
}

.page-subtitle {
    color: #6b7280;
    text-align: center;
    margin-bottom: 40px;
    font-size: 1.1rem;
}

.payment-methods {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 30px;
}

.payment-method-card {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 20px;
    padding: 40px 30px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 3px solid transparent;
    color: #333;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.payment-method-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    border-color: #28a745;
    background: linear-gradient(135deg, #ffffff, #f8f9fa);
}

.payment-method-card.qris {
    background: linear-gradient(135deg, #e3f2fd, #bbdefb);
    border-color: #2196f3;
}

.payment-method-card.qris:hover {
    background: linear-gradient(135deg, #ffffff, #e3f2fd);
    border-color: #1976d2;
}

.payment-method-card.transfer {
    background: linear-gradient(135deg, #e8f5e8, #c8e6c9);
    border-color: #4caf50;
}

.payment-method-card.transfer:hover {
    background: linear-gradient(135deg, #ffffff, #e8f5e8);
    border-color: #388e3c;
}

.payment-icon {
    font-size: 4rem;
    margin-bottom: 20px;
    display: block;
}

.qris .payment-icon {
    color: #1976d2;
}

.transfer .payment-icon {
    color: #388e3c;
    margin-bottom: 20px;
}

.payment-method-card h5 {
    color: #333;
    font-weight: 600;
    margin-bottom: 15px;
}

.payment-method-card p {
    color: #666;
    margin-bottom: 20px;
    line-height: 1.5;
}

.payment-logos {
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
}

.payment-logo {
    background: #f8f9fa;
    color: #333;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
    border: 1px solid #dee2e6;
}

.order-summary {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    padding: 20px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.badge {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 700 !important;
    letter-spacing: 0.5px;
    border-radius: 8px !important;
}

.btn-dark {
    background: #343a40 !important;
    border: none;
    border-radius: 15px;
    padding: 12px 25px;
    font-weight: 700;
    color: white !important;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(52, 58, 64, 0.3);
}

.btn-dark:hover {
    background: #23272b !important;
    color: white !important;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(52, 58, 64, 0.4);
}

.btn-success {
    background: linear-gradient(45deg, #28a745, #20c997) !important;
    border: none;
    border-radius: 15px;
    padding: 12px 25px;
    font-weight: 700;
    color: white !important;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.btn-success:hover {
    background: linear-gradient(45deg, #218838, #1ea085) !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    color: white !important;
    text-decoration: none;
}

.bg-success {
    background-color: #28a745 !important;
}

.bg-info {
    background-color: #17a2b8 !important;
}

.bg-warning {
    background-color: #ffc107 !important;
}

.bg-primary {
    background-color: #007bff !important;
}

@media (max-width: 768px) {
    .nav-custom {
        flex-direction: column !important;
        text-align: center;
        gap: 10px;
        margin-bottom: 20px;
    }
    
    .nav-title {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    .nav-actions {
        justify-content: center !important;
    }
    
    .nav-actions .nav-link,
    .nav-actions .btn-login {
        margin: 0 5px;
    }
}
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-5 text-white">Pembayaran Cashless</h1>
        <p class="text-white-50">Kami hanya menerima pembayaran cashless untuk booking online</p>
    </div>

    <!-- Payment Method Selection -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="payment-container">
                <h4 class="text-white text-center mb-4">
                    <span class="badge bg-success me-2 px-3 py-2 fs-6">CASHLESS</span>Pembayaran Digital
                </h4>
                
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="payment-method-card qris" onclick="selectQRIS()">
                            <div class="payment-icon">
                                <span class="badge bg-primary px-4 py-3 fs-3 mb-3">QR</span>
                            </div>
                            <h5>QRIS - Pembayaran Digital</h5>
                            <p>Bayar dengan scan QR Code menggunakan e-wallet favorit Anda. Cepat, aman, dan mudah!</p>
                            <div class="payment-logos">
                                <span class="payment-logo">DANA</span>
                                <span class="payment-logo">OVO</span>
                                <span class="payment-logo">GoPay</span>
                                <span class="payment-logo">ShopeePay</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Cashless -->
                <div class="alert alert-info mt-4" style="background: rgba(23, 162, 184, 0.2); border: 1px solid rgba(23, 162, 184, 0.5); color: #fff;">
                    <div class="d-flex align-items-start">
                        <span class="badge bg-info me-3 px-3 py-2 fs-6">INFO</span>
                        <div>
                            <h6 class="mb-2">Informasi Penting:</h6>
                            <ul class="mb-0">
                                <li><strong>Booking Online:</strong> Hanya menerima pembayaran cashless (QRIS/E-wallet)</li>
                                <li><strong>Tidak ada transfer bank</strong> untuk booking online</li>
                                <li><strong>Alternatif:</strong> Jika tidak memiliki e-wallet, Anda bisa booking langsung di tempat dengan pembayaran tunai</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Alternative Booking Info -->
                <div class="alert alert-warning mt-3" style="background: rgba(255, 193, 7, 0.2); border: 1px solid rgba(255, 193, 7, 0.5); color: #fff;">
                    <div class="d-flex align-items-start">
                        <span class="badge bg-warning text-dark me-3 px-3 py-2 fs-6">ALTERNATIF</span>
                        <div>
                            <h6 class="mb-2">Booking Langsung di Tempat:</h6>
                            <p class="mb-2">Jika Anda tidak memiliki e-wallet atau lebih suka pembayaran tunai:</p>
                            <ul class="mb-2">
                                <li>Datang langsung ke <strong>Bshoot Billiard</strong></li>
                                <li>Pilih meja yang tersedia</li>
                                <li>Bayar tunai di kasir</li>
                                <li>Langsung main tanpa ribet!</li>
                            </ul>
                            <p class="mb-0"><strong>Alamat:</strong> Jl. sri pelayang, Gn. Kembang, Kec. Sarolangun, Kabupaten Sarolangun, Jambi</p>
                        </div>
                    </div>
                </div>

                <!-- Detail Pesanan Summary -->
                <div class="order-summary mt-4">
                    <h5 class="text-white mb-3">
                        <span class="badge bg-light text-dark me-2 px-3 py-2 fs-6">RINGKASAN</span>Detail Pesanan
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless text-white">
                                <tr>
                                    <td>Nama</td>
                                    <td>: Haikal</td>
                                </tr>
                                <tr>
                                    <td>Meja</td>
                                    <td>: Meja VIP</td>
                                </tr>
                                <tr>
                                    <td>Durasi</td>
                                    <td>: 2 Jam</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless text-white">
                                <tr>
                                    <td>Tanggal</td>
                                    <td>: 10 Desember 2025</td>
                                </tr>
                                <tr>
                                    <td>Waktu</td>
                                    <td>: 14:00 - 16:00</td>
                                </tr>
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td><strong>: Rp 400.000</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="{{ route('customer.checkout') }}" class="btn btn-dark fw-bold">Kembali</a>
                    <button class="btn btn-success fw-bold" onclick="selectQRIS()">Lanjut Bayar QRIS</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Fungsi untuk memilih QRIS
function selectQRIS() {
    // Redirect ke halaman QRIS
    window.location.href = '{{ route("customer.qris") }}';
}

// Fungsi untuk memilih Transfer
function selectTransfer() {
    // Tampilkan informasi transfer bank
    Swal.fire({
        title: 'Transfer Bank',
        html: `<div style="text-align: left; padding: 20px;">
                <h5 style="color: #28a745; margin-bottom: 15px;">Informasi Rekening:</h5>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-bottom: 15px;">
                    <strong>Bank BCA</strong><br>
                    No. Rekening: <strong>1234567890</strong><br>
                    Atas Nama: <strong>Bshoot Billiard</strong>
                </div>
                <div style="background: #fff3cd; padding: 15px; border-radius: 10px; border-left: 4px solid #ffc107;">
                    <small><strong>Catatan:</strong> Setelah transfer, silakan hubungi admin melalui WhatsApp untuk konfirmasi pembayaran dengan menyertakan bukti transfer.</small>
                </div>
               </div>`,
        showCancelButton: true,
        confirmButtonText: 'Hubungi Admin',
        cancelButtonText: 'Kembali',
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect ke WhatsApp admin
            window.open('https://wa.me/6281367804400?text=Halo, saya ingin konfirmasi pembayaran transfer bank untuk booking meja billiard', '_blank');
        }
    });
}
</script>
@endpush