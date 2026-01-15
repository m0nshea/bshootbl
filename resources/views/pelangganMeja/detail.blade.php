@extends('layouts.customer')

@section('title', 'Detail {{ $meja->nama_meja }} - Bshoot Billiard')
@section('description', 'Detail {{ $meja->nama_meja }} - Bshoot Billiard')

@push('styles')
<link href="{{ asset('css/customer-detail-meja.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="container">
    <!-- Back Button -->
    <a href="{{ route('customer.meja') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i>Kembali ke Daftar Meja
    </a>

    <!-- Detail Card -->
    <div class="detail-card {{ str_contains(strtolower($meja->category->nama), 'vip') ? 'detail-card-vip' : '' }}">
        @if(str_contains(strtolower($meja->category->nama), 'vip'))
            <div class="vip-badge-detail">
                <i class="bi bi-star-fill"></i> VIP EXCLUSIVE
            </div>
        @endif
        <!-- Table Image -->
        <img src="{{ $meja->foto_url }}" alt="{{ $meja->nama_meja }}" class="table-image" />
        
        <!-- Content Section -->
        <div class="detail-content">
            <!-- Left Section - Meja Information -->
            <div class="left-section">
                <h1 class="meja-title">{{ $meja->nama_meja }}</h1>
                
                <div class="category-badge {{ str_contains(strtolower($meja->category->nama), 'vip') ? 'category-badge-vip' : '' }}">
                    <i class="bi bi-tag me-2"></i>{{ $meja->category->nama }}
                </div>
                
                <div class="availability-badge">
                    <i class="bi bi-check-circle me-2"></i>{{ $meja->status_text }}
                </div>
                
                <div class="price-display">
                    {{ $meja->formatted_harga }}/jam
                </div>

                @if($meja->deskripsi)
                <div class="description-section">
                    <h4 class="spec-title">Deskripsi</h4>
                    <p class="description-text">{{ $meja->deskripsi }}</p>
                </div>
                @endif

                <!-- Specifications -->
                <div class="spec-section">
                    <h4 class="spec-title">Spesifikasi Meja</h4>
                    <ul class="spec-list">
                        <li class="spec-item">
                            <i class="bi bi-tag spec-icon"></i>
                            <span><strong>Kategori:</strong> {{ $meja->category->nama }}</span>
                        </li>
                        <li class="spec-item">
                            <i class="bi bi-rulers spec-icon"></i>
                            <span><strong>Ukuran:</strong> 9 Feet </span>
                        </li>
                        <li class="spec-item">
                            <i class="bi bi-palette spec-icon"></i>
                            <span><strong>Kain:</strong> Kain Berkualitas</span>
                        </li>
                        <li class="spec-item">
                            <i class="bi bi-circle spec-icon"></i>
                            <span><strong>Bola:</strong> Set lengkap 16 bola (8 Ball dan 9 Ball)</span>
                        </li>
                        <li class="spec-item">
                            <i class="bi bi-lightning spec-icon"></i>
                            <span><strong>Pencahayaan:</strong> LED Berkualitas</span>
                        </li>
                        <li class="spec-item">
                            <i class="bi bi-tools spec-icon"></i>
                            <span><strong>Stick:</strong> Tersedia Berbagai Ukuran</span>
                        </li>
                    </ul>
                </div>

                <!-- Additional Facilities -->
                <div class="spec-section">
                    <h4 class="spec-title">Fasilitas Tambahan</h4>
                    <ul class="spec-list">
                        <li class="spec-item">
                            <i class="bi bi-wifi spec-icon"></i>
                            <span>WiFi Gratis</span>
                        </li>
                        <li class="spec-item">
                            <i class="bi bi-cup-hot spec-icon"></i>
                            <span>Area Minum</span>
                        </li>
                        <li class="spec-item">
                            <i class="bi bi-car-front spec-icon"></i>
                            <span>Parkir Luas</span>
                        </li>
                        <li class="spec-item">
                            <i class="bi bi-shield-check spec-icon"></i>
                            <span>Keamanan 24 Jam</span>
                        </li>
                        @if(str_contains(strtolower($meja->category->nama), 'vip'))
                        <li class="spec-item">
                            <i class="bi bi-star spec-icon"></i>
                            <span>Ruang VIP Eksklusif</span>
                        </li>
                        <li class="spec-item">
                            <i class="bi bi-headphones spec-icon"></i>
                            <span>Sound System Premium</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Right Section - Booking Form -->
            <div class="right-section">
                <h5 class="booking-title">Informasi Booking</h5>
                
                @if($meja->status === 'available')
                <form method="POST" action="{{ route('customer.booking.process') }}" id="bookingForm">
                    @csrf
                    <input type="hidden" name="meja_id" value="{{ $meja->id }}">
                    <input type="hidden" name="nama_pelanggan" value="{{ Auth::user()->name ?? '' }}">
                    <input type="hidden" name="email_pelanggan" value="{{ Auth::user()->email ?? '' }}">
                    <input type="hidden" name="metode_pembayaran" value="qris">
                    
                    <div class="form-group">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-input" id="bookingDate" name="tanggal_booking" placeholder="mm/dd/yyyy" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Jam Mulai</label>
                        <select class="form-select" id="startTime" name="jam_mulai" required>
                            <option value="">Pilih Jam</option>
                            <option value="08:00">08:00</option>
                            <option value="09:00">09:00</option>
                            <option value="10:00">10:00</option>
                            <option value="11:00">11:00</option>
                            <option value="12:00">12:00</option>
                            <option value="13:00">13:00</option>
                            <option value="14:00">14:00</option>
                            <option value="15:00">15:00</option>
                            <option value="16:00">16:00</option>
                            <option value="17:00">17:00</option>
                            <option value="18:00">18:00</option>
                            <option value="19:00">19:00</option>
                            <option value="20:00">20:00</option>
                            <option value="21:00">21:00</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Durasi (Jam)</label>
                        <select class="form-select" id="duration" name="durasi" required>
                            <option value="">Pilih Durasi</option>
                            <option value="1">1 Jam</option>
                            <option value="2">2 Jam</option>
                            <option value="3">3 Jam</option>
                            <option value="4">4 Jam</option>
                            <option value="5">5 Jam</option>
                        </select>
                    </div>
                    
                    <div class="total-section">
                        <div class="total-row">
                            <span class="total-label">Total Harga:</span>
                            <span class="total-amount" id="totalPrice">Rp 0</span>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-book {{ str_contains(strtolower($meja->category->nama), 'vip') ? 'btn-book-vip' : '' }}" id="bookingBtn">
                        <i class="bi bi-calendar-check"></i>Pesan Sekarang
                    </button>
                </form>
                @else
                <div class="unavailable-notice">
                    <i class="bi bi-exclamation-triangle"></i>
                    <h6>Meja Tidak Tersedia</h6>
                    <p>Meja ini sedang {{ $meja->status_text }}. Silakan pilih meja lain atau coba lagi nanti.</p>
                    <a href="{{ route('customer.meja') }}" class="btn btn-secondary">Pilih Meja Lain</a>
                </div>
                @endif
            </div>
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
@if($meja->status === 'available')
// Set minimum date to today
document.getElementById('bookingDate').min = new Date().toISOString().split('T')[0];

// Price per hour
const pricePerHour = {{ $meja->harga }};

// Calculate total price
function calculateTotal() {
    const duration = document.getElementById('duration').value;
    const total = duration ? duration * pricePerHour : 0;
    document.getElementById('totalPrice').textContent = total > 0 ? `Rp ${total.toLocaleString('id-ID')}` : 'Rp 0';
}

// Add event listener for duration change
document.getElementById('duration').addEventListener('change', calculateTotal);

// Handle form submission with Midtrans Snap
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validate form
    const tanggal = document.getElementById('bookingDate').value;
    const jamMulai = document.getElementById('startTime').value;
    const durasi = document.getElementById('duration').value;
    
    if (!tanggal || !jamMulai || !durasi) {
        Swal.fire({
            icon: 'warning',
            title: 'Form Tidak Lengkap',
            text: 'Mohon lengkapi semua field booking',
            confirmButtonColor: '#28a745'
        });
        return;
    }
    
    // Show loading
    Swal.fire({
        title: 'Memproses Booking...',
        text: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Get form data
    const formData = new FormData(this);
    
    // Submit booking via AJAX
    fetch('{{ route('customer.booking.process') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.snap_token) {
            // Close loading
            Swal.close();
            
            // Show booking summary before payment
            Swal.fire({
                title: 'Konfirmasi Booking',
                html: `
                    <div style="text-align: left; padding: 20px;">
                        <h5 style="color: #28a745; margin-bottom: 15px;">Detail Booking:</h5>
                        <table style="width: 100%; margin-bottom: 15px;">
                            <tr>
                                <td style="padding: 8px 0;"><strong>Meja:</strong></td>
                                <td style="padding: 8px 0;">{{ $meja->nama_meja }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0;"><strong>Tanggal:</strong></td>
                                <td style="padding: 8px 0;">${tanggal}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0;"><strong>Jam:</strong></td>
                                <td style="padding: 8px 0;">${jamMulai}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0;"><strong>Durasi:</strong></td>
                                <td style="padding: 8px 0;">${durasi} Jam</td>
                            </tr>
                            <tr style="border-top: 2px solid #28a745;">
                                <td style="padding: 12px 0;"><strong>Total:</strong></td>
                                <td style="padding: 12px 0; color: #28a745; font-size: 1.2rem;"><strong>Rp ${(durasi * pricePerHour).toLocaleString('id-ID')}</strong></td>
                            </tr>
                        </table>
                        <div style="background: #e3f2fd; padding: 15px; border-radius: 10px; border-left: 4px solid #2196f3;">
                            <small><strong>Info:</strong> Anda akan diarahkan ke halaman pembayaran Midtrans. Pilih metode pembayaran yang Anda inginkan (QRIS, E-Wallet, atau Transfer Bank).</small>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Lanjut Bayar',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                width: '600px'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Trigger Midtrans Snap
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            console.log('Payment success:', result);
                            Swal.fire({
                                icon: 'success',
                                title: 'Pembayaran Berhasil!',
                                text: 'Terima kasih, booking Anda telah dikonfirmasi.',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                window.location.href = '{{ route('customer.riwayat') }}';
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
                                text: 'Anda menutup halaman pembayaran. Booking Anda masih tersimpan, silakan lanjutkan pembayaran dari halaman riwayat.',
                                confirmButtonColor: '#ffc107'
                            }).then(() => {
                                window.location.href = '{{ route('customer.riwayat') }}';
                            });
                        }
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Booking Gagal',
                text: data.message || 'Terjadi kesalahan saat memproses booking',
                confirmButtonColor: '#dc3545'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Terjadi kesalahan saat memproses booking. Silakan coba lagi.',
            confirmButtonColor: '#dc3545'
        });
    });
});
@endif
</script>
@endpush