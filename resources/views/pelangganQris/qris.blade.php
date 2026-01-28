@extends('layouts.customer')

@section('title', 'Pembayaran QRIS - Bshoot Billiard')
@section('description', 'Halaman pembayaran dengan QRIS - Bshoot Billiard')

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
    border-bottom: none;
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
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    padding: 40px;
    margin-bottom: 30px;
}

/* Override customer.css untuk payment container */
.payment-container * {
    color: #333 !important;
}

.payment-container h5 {
    color: #333 !important;
}

.payment-container .table td {
    color: #333 !important;
}

.payment-container .text-dark {
    color: #333 !important;
}

.payment-container .text-muted {
    color: #666 !important;
}

.timer-container {
    background: linear-gradient(45deg, #dc3545, #fd7e14);
    color: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    margin-bottom: 30px;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
}

.timer-display {
    font-size: 2.5rem;
    font-weight: bold;
    font-family: 'Courier New', monospace;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.qris-container {
    background: white;
    padding: 20px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.qris-container h5 {
    color: #333 !important;
}

.qris-container p {
    color: #666 !important;
}

.qris-image {
    max-width: 250px;
    width: 100%;
    height: auto;
    border: 3px solid #28a745;
    border-radius: 10px;
    padding: 10px;
    background: white;
}

.payment-methods {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin: 20px 0;
    flex-wrap: wrap;
}

.payment-method {
    background: white;
    padding: 10px 20px;
    border-radius: 25px;
    color: #333 !important;
    font-weight: 600;
    border: 2px solid #28a745;
    transition: all 0.3s ease;
}

.payment-method:hover {
    background: #28a745;
    color: white !important;
}

.total-amount {
    background: linear-gradient(45deg, #28a745, #20c997);
    color: white;
    padding: 15px;
    border-radius: 10px;
    font-size: 1.5rem;
    font-weight: bold;
    text-align: center;
    margin: 20px 0;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.expired-message {
    background: #dc3545;
    color: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    display: none;
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

.bg-danger {
    background-color: #dc3545 !important;
}

.bg-warning {
    background-color: #ffc107 !important;
}

.bg-info {
    background-color: #17a2b8 !important;
}

.bg-primary {
    background-color: #007bff !important;
}

.bg-secondary {
    background-color: #6c757d !important;
}

.alert {
    border-radius: 15px;
    border: none;
    padding: 20px;
    margin-bottom: 25px;
    font-weight: 500;
}

.alert-info {
    background: rgba(23, 162, 184, 0.1);
    border: 1px solid rgba(23, 162, 184, 0.3);
    color: #333 !important;
}

.alert-info h6 {
    color: #333 !important;
}

.alert-info ol {
    color: #333 !important;
}

.alert-info li {
    color: #333 !important;
}

.footer-item .btn-link {
    color: #fff !important;
    text-decoration: none;
    padding: 8px 0;
    transition: all 0.3s ease;
}

.footer-item .btn-link:hover {
    color: #28a745 !important;
    text-decoration: none;
    transform: translateX(5px);
}

.footer-item .badge {
    transition: all 0.3s ease;
}

.footer-item .btn-link:hover .badge {
    transform: scale(1.1);
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
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
        <h1 class="display-5 text-white">Pembayaran QRIS</h1>
        <p class="text-white-50">Scan QR Code untuk melakukan pembayaran</p>
    </div>

    <!-- Timer Countdown -->
    <div class="timer-container" id="timerContainer">
        <h4><span class="badge bg-danger me-2 px-3 py-2 fs-6">TIMER</span>Batas Waktu Pembayaran</h4>
        <div class="timer-display" id="countdown">05:00</div>
        <p class="mb-0">Silakan selesaikan pembayaran sebelum waktu habis</p>
    </div>

    <!-- Expired Message -->
    <div class="expired-message" id="expiredMessage">
        <h4><span class="badge bg-warning text-dark me-2 px-3 py-2 fs-6">EXPIRED</span>Waktu Pembayaran Habis</h4>
        <p class="mb-3">Maaf, batas waktu pembayaran telah berakhir. Silakan lakukan pemesanan ulang.</p>
        <a href="{{ route('customer.checkout') }}" class="btn btn-light fw-bold">Pesan Ulang</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="payment-container">
                <!-- Detail Pesanan -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="text-dark mb-3"><span class="badge bg-info me-2 px-3 py-2 fs-6">DETAIL</span>Pesanan Anda</h5>
                        <table class="table table-borderless text-dark">
                            <tr>
                                <td>Nama</td>
                                <td>: {{ isset($transaksi) ? ($transaksi->user->name ?? 'Customer') : 'Customer' }}</td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td>: {{ isset($transaksi) ? ($transaksi->user->no_telepon ?? '081234567890') : '081234567890' }}</td>
                            </tr>
                            <tr>
                                <td>Meja</td>
                                <td>: {{ isset($transaksi) ? $transaksi->meja->nama_meja : 'Meja VIP' }}</td>
                            </tr>
                            <tr>
                                <td>Durasi</td>
                                <td>: {{ isset($transaksi) ? $transaksi->durasi : '2' }} Jam</td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>: {{ isset($transaksi) ? \Carbon\Carbon::parse($transaksi->tanggal_booking)->format('d F Y') : '10 Desember 2025' }}</td>
                            </tr>
                            <tr>
                                <td>Waktu</td>
                                <td>: {{ isset($transaksi) ? $transaksi->jam_mulai . ' - ' . \Carbon\Carbon::parse($transaksi->jam_mulai)->addHours($transaksi->durasi)->format('H:i') : '14:00 - 16:00' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="qris-container">
                            <h5 class="text-dark mb-3"><span class="badge bg-primary me-2 px-3 py-2 fs-6">QRIS</span>Scan QR Code</h5>
                            <img src="{{ asset('img/qr.png') }}" alt="QRIS Code" class="qris-image mb-3">
                            <div class="payment-methods">
                                <span class="payment-method">DANA</span>
                                <span class="payment-method">OVO</span>
                                <span class="payment-method">GoPay</span>
                                <span class="payment-method">ShopeePay</span>
                            </div>
                            <p class="text-muted small mb-0">
                                <span class="badge bg-secondary me-1 px-2 py-1" style="font-size: 0.7rem;">INFO</span>
                                Scan dengan aplikasi e-wallet favorit Anda
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Total Pembayaran -->
                <div class="total-amount">
                    <span class="badge bg-light text-dark me-2 px-3 py-2 fs-6">TOTAL</span>Rp {{ isset($transaksi) ? number_format($transaksi->total_harga, 0, ',', '.') : '400.000' }}
                </div>

                <!-- Instruksi QRIS -->
                <div class="alert alert-info" style="background: rgba(23, 162, 184, 0.1); border: 1px solid rgba(23, 162, 184, 0.3); color: #333;">
                    <h6><span class="badge bg-info me-2 px-3 py-2 fs-6">PANDUAN</span>Cara Pembayaran QRIS:</h6>
                    <ol class="mb-0">
                        <li>Buka aplikasi e-wallet (DANA, OVO, GoPay, ShopeePay)</li>
                        <li>Pilih menu "Scan QR" atau "Bayar"</li>
                        <li>Arahkan kamera ke QR Code di atas</li>
                        <li>Konfirmasi pembayaran sebesar <strong>Rp {{ isset($transaksi) ? number_format($transaksi->total_harga, 0, ',', '.') : '400.000' }}</strong></li>
                        <li>Simpan bukti pembayaran</li>
                    </ol>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('customer.meja') }}" class="btn btn-dark fw-bold">Kembali ke Meja</a>
                    @if(isset($transaksi))
                    <button class="btn btn-success fw-bold" onclick="confirmPayment({{ $transaksi->id }})">Sudah Bayar</button>
                    @else
                    <button class="btn btn-success fw-bold" onclick="alert('Transaksi tidak ditemukan')">Sudah Bayar</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Timer countdown 5 menit
let timeLeft = 5 * 60; // 5 menit dalam detik

function updateTimer() {
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    const display = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    
    document.getElementById('countdown').textContent = display;
    
    if (timeLeft <= 0) {
        // Waktu habis
        document.getElementById('timerContainer').style.display = 'none';
        document.getElementById('expiredMessage').style.display = 'block';
        document.querySelector('.payment-container').style.display = 'none';
        return;
    }
    
    // Ubah warna timer jika kurang dari 1 menit
    if (timeLeft <= 60) {
        document.getElementById('timerContainer').style.background = 'linear-gradient(45deg, #dc3545, #c82333)';
        document.getElementById('countdown').style.animation = 'pulse 1s infinite';
    }
    
    timeLeft--;
}

// Mulai timer saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    updateTimer(); // Update pertama
    setInterval(updateTimer, 1000); // Update setiap detik
});

// Fungsi konfirmasi pembayaran
function confirmPayment(transaksiId) {
    if (confirm('Apakah Anda yakin sudah melakukan pembayaran?')) {
        // Send AJAX request to confirm payment
        fetch(`/pelanggan/payment/confirm/${transaksiId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Terima kasih! Pembayaran Anda sedang diverifikasi.');
                window.location.href = '{{ route("customer.riwayat") }}';
            } else {
                alert('Terjadi kesalahan: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengkonfirmasi pembayaran.');
        });
    }
}
</script>
@endpush