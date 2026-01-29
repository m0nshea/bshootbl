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
                
                @if(in_array($meja->status, ['available', 'reserved']))
                    @auth
                    <!-- User sudah login - tampilkan form booking -->
                    <form method="POST" action="{{ route('customer.booking.process') }}" id="bookingForm">
                        @csrf
                        <input type="hidden" name="meja_id" value="{{ $meja->id }}">
                        <input type="hidden" name="metode_pembayaran" value="qris">
                        
                        <div class="form-group">
                            <label class="form-label">Jenis Permainan</label>
                            <select class="form-select" id="ballType" name="jenis_ball" required>
                                <option value="">Pilih Jenis Ball</option>
                                <option value="8_ball">8 Ball</option>
                                <option value="9_ball">9 Ball</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-input" id="bookingDate" name="tanggal_booking" placeholder="mm/dd/yyyy" required disabled>
                            <small class="text-muted">Pilih durasi terlebih dahulu untuk melihat tanggal yang tersedia</small>
                            <div id="availableDatesInfo" class="mt-2" style="display: none;">
                                <small class="text-info">
                                    <i class="bi bi-calendar-check"></i> 
                                    <span id="availableDatesText"></span>
                                </small>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Jam Mulai</label>
                            <select class="form-select" id="startTime" name="jam_mulai" required disabled>
                                <option value="">Pilih tanggal terlebih dahulu</option>
                            </select>
                            <small class="text-muted">Jam yang sudah dibooking tidak akan muncul dalam pilihan</small>
                            <div id="bookedSlotsInfo" class="mt-2" style="display: none;">
                                <small class="text-warning">
                                    <i class="bi bi-info-circle"></i> 
                                    <span id="bookedSlotsText"></span>
                                </small>
                            </div>
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
                            <small class="text-muted">Pilih durasi untuk melihat slot waktu yang tersedia</small>
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
                    <!-- User belum login - tampilkan pesan untuk login -->
                    <div class="login-required-notice">
                        <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 10px; padding: 20px; text-align: center; margin-bottom: 20px;">
                            <i class="bi bi-person-lock" style="font-size: 2.5rem; color: #856404; margin-bottom: 15px;"></i>
                            <h6 style="color: #856404; margin-bottom: 10px;">Login Diperlukan</h6>
                            <p style="color: #856404; margin-bottom: 20px; font-size: 0.9rem;">
                                Untuk melakukan pemesanan meja, Anda harus masuk ke akun terlebih dahulu. 
                                Anda dapat melihat ketersediaan meja tanpa login.
                            </p>
                            <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                                <a href="{{ route('login') }}" class="btn btn-primary" style="text-decoration: none; padding: 10px 20px; border-radius: 5px; font-weight: 500;">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-outline-primary" style="text-decoration: none; padding: 10px 20px; border-radius: 5px; font-weight: 500;">
                                    <i class="bi bi-person-plus me-2"></i>Daftar
                                </a>
                            </div>
                        </div>
                        
                        <!-- Tampilkan informasi ketersediaan untuk user yang belum login -->
                        <div style="background: #e3f2fd; border: 1px solid #bbdefb; border-radius: 10px; padding: 20px;">
                            <h6 style="color: #1976d2; margin-bottom: 15px;">
                                <i class="bi bi-info-circle me-2"></i>Informasi Ketersediaan
                            </h6>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                <span style="color: #1976d2;">Status Meja:</span>
                                <span style="color: #28a745; font-weight: 600;">
                                    <i class="bi bi-check-circle me-1"></i>Tersedia
                                </span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                <span style="color: #1976d2;">Harga per Jam:</span>
                                <span style="color: #1976d2; font-weight: 600;">{{ $meja->formatted_harga }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="color: #1976d2;">Jam Operasional:</span>
                                <span style="color: #1976d2; font-weight: 600;">08:00 - 22:00</span>
                            </div>
                        </div>
                    </div>
                    @endauth
               
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
@auth
@if($meja->status === 'available')
// Price per hour
const pricePerHour = {{ $meja->harga }};

// Available dates cache
let availableDatesCache = [];

// Function to load available dates based on selected duration
async function loadAvailableDates() {
    const selectedDuration = document.getElementById('duration').value;
    const bookingDateInput = document.getElementById('bookingDate');
    const startTimeSelect = document.getElementById('startTime');
    
    if (!selectedDuration) {
        bookingDateInput.disabled = true;
        bookingDateInput.value = '';
        startTimeSelect.innerHTML = '<option value="">Pilih durasi dan tanggal terlebih dahulu</option>';
        startTimeSelect.disabled = true;
        
        // Hide info
        const availableDatesInfo = document.getElementById('availableDatesInfo');
        if (availableDatesInfo) {
            availableDatesInfo.style.display = 'none';
        }
        return;
    }
    
    try {
        // Show loading for date input
        bookingDateInput.disabled = true;
        
        // Fetch available dates for the selected duration
        const response = await fetch(`/pelanggan/meja/{{ $meja->id }}/available-dates?duration=${selectedDuration}`, {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        const data = await response.json();
        console.log('Available dates response:', data); // Debug log
        
        if (data.success) {
            availableDatesCache = data.available_dates || [];
            
            if (availableDatesCache.length > 0) {
                // Enable date input and set constraints
                bookingDateInput.disabled = false;
                
                // Set min date to today or first available date
                const today = new Date().toISOString().split('T')[0];
                const firstAvailableDate = availableDatesCache[0].date;
                bookingDateInput.min = today > firstAvailableDate ? today : firstAvailableDate;
                
                // Set max date to last available date
                const lastAvailableDate = availableDatesCache[availableDatesCache.length - 1].date;
                bookingDateInput.max = lastAvailableDate;
                
                // Show available dates info
                const availableDatesInfo = document.getElementById('availableDatesInfo');
                const availableDatesText = document.getElementById('availableDatesText');
                
                if (availableDatesInfo && availableDatesText) {
                    const totalDates = availableDatesCache.length;
                    availableDatesText.textContent = `${totalDates} tanggal tersedia untuk durasi ${selectedDuration} jam`;
                    availableDatesInfo.style.display = 'block';
                    availableDatesInfo.className = 'mt-2';
                    availableDatesText.className = 'text-info';
                }
                
                // Add custom validation for date input
                bookingDateInput.addEventListener('input', validateSelectedDate);
                
            } else {
                bookingDateInput.disabled = true;
                bookingDateInput.value = '';
                
                // Show no dates available message
                const availableDatesInfo = document.getElementById('availableDatesInfo');
                const availableDatesText = document.getElementById('availableDatesText');
                
                if (availableDatesInfo && availableDatesText) {
                    availableDatesText.textContent = `Tidak ada tanggal tersedia untuk durasi ${selectedDuration} jam`;
                    availableDatesInfo.style.display = 'block';
                    availableDatesInfo.className = 'mt-2';
                    availableDatesText.className = 'text-warning';
                }
            }
            
            // Reset time selection
            startTimeSelect.innerHTML = '<option value="">Pilih tanggal terlebih dahulu</option>';
            startTimeSelect.disabled = true;
            
        } else {
            throw new Error(data.message || 'Gagal memuat tanggal tersedia');
        }
    } catch (error) {
        console.error('Error loading available dates:', error);
        bookingDateInput.disabled = true;
        
        // Show fallback - enable basic date picker
        const today = new Date().toISOString().split('T')[0];
        bookingDateInput.min = today;
        bookingDateInput.disabled = false;
        
        // Show fallback message
        const availableDatesInfo = document.getElementById('availableDatesInfo');
        const availableDatesText = document.getElementById('availableDatesText');
        
        if (availableDatesInfo && availableDatesText) {
            availableDatesText.textContent = 'Menggunakan mode fallback - pilih tanggal untuk melihat ketersediaan';
            availableDatesInfo.style.display = 'block';
            availableDatesInfo.className = 'mt-2';
            availableDatesText.className = 'text-warning';
        }
        
        // Don't show error popup for better UX, just log it
        console.warn('Fallback to basic date picker due to error:', error.message);
    }
}

// Function to validate if selected date is available
function validateSelectedDate() {
    const selectedDate = document.getElementById('bookingDate').value;
    const bookingDateInput = document.getElementById('bookingDate');
    
    if (!selectedDate || availableDatesCache.length === 0) {
        return;
    }
    
    const isDateAvailable = availableDatesCache.some(dateInfo => dateInfo.date === selectedDate);
    
    if (!isDateAvailable) {
        // Date is not available, show warning and clear
        Swal.fire({
            icon: 'warning',
            title: 'Tanggal Tidak Tersedia',
            text: 'Tanggal yang Anda pilih tidak memiliki slot waktu tersedia untuk durasi ini. Silakan pilih tanggal lain.',
            confirmButtonColor: '#ffc107'
        });
        
        bookingDateInput.value = '';
        
        // Reset time selection
        const startTimeSelect = document.getElementById('startTime');
        startTimeSelect.innerHTML = '<option value="">Pilih tanggal terlebih dahulu</option>';
        startTimeSelect.disabled = true;
    } else {
        // Date is available, load time slots
        loadAvailableTimeSlots();
    }
}

// Function to load available time slots based on selected date
async function loadAvailableTimeSlots() {
    const selectedDate = document.getElementById('bookingDate').value;
    const selectedDuration = document.getElementById('duration').value || 1;
    const startTimeSelect = document.getElementById('startTime');
    
    if (!selectedDate) {
        startTimeSelect.innerHTML = '<option value="">Pilih tanggal terlebih dahulu</option>';
        startTimeSelect.disabled = true;
        return;
    }
    
    try {
        // Show loading
        startTimeSelect.innerHTML = '<option value="">Memuat jam tersedia...</option>';
        startTimeSelect.disabled = true;
        
        // Fetch available time slots for the selected date, table, and duration
        const response = await fetch(`/pelanggan/meja/{{ $meja->id }}/available-times?date=${selectedDate}&duration=${selectedDuration}`, {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        const data = await response.json();
        console.log('Available times response:', data); // Debug log
        
        if (data.success) {
            const availableSlots = data.available_slots || [];
            const bookedSlots = data.booked_slots || [];
            
            console.log('Available slots:', availableSlots); // Debug log
            console.log('Booked slots:', bookedSlots); // Debug log
            
            // Populate select options
            startTimeSelect.innerHTML = '<option value="">Pilih Jam</option>';
            
            const availableOptions = availableSlots.filter(slot => slot.available);
            
            if (availableOptions.length > 0) {
                availableOptions.forEach(slot => {
                    const option = document.createElement('option');
                    option.value = slot.time;
                    option.textContent = slot.display;
                    startTimeSelect.appendChild(option);
                });
                startTimeSelect.disabled = false;
            } else {
                startTimeSelect.innerHTML = '<option value="">Tidak ada jam tersedia untuk durasi ini</option>';
                startTimeSelect.disabled = true;
            }
            
            // Show booked slots info if any
            if (bookedSlots.length > 0) {
                const bookedInfo = bookedSlots.map(slot => `${slot.start} - ${slot.end}`).join(', ');
                console.log('Jam yang sudah dibooking:', bookedInfo);
                
                // Show booked slots information to user
                const bookedSlotsInfo = document.getElementById('bookedSlotsInfo');
                const bookedSlotsText = document.getElementById('bookedSlotsText');
                
                if (bookedSlotsInfo && bookedSlotsText) {
                    bookedSlotsText.textContent = `Jam yang sudah dibooking: ${bookedInfo}`;
                    bookedSlotsInfo.style.display = 'block';
                }
            } else {
                // Hide booked slots info if no bookings
                const bookedSlotsInfo = document.getElementById('bookedSlotsInfo');
                if (bookedSlotsInfo) {
                    bookedSlotsInfo.style.display = 'none';
                }
            }
        } else {
            throw new Error(data.message || 'Gagal memuat jam tersedia');
        }
    } catch (error) {
        console.error('Error loading available times:', error);
        startTimeSelect.innerHTML = '<option value="">Error memuat jam tersedia</option>';
        startTimeSelect.disabled = true;
        
        // Show error message with more details
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: `Gagal memuat jam tersedia: ${error.message}`,
            confirmButtonColor: '#dc3545'
        });
    }
}

// Add event listener for duration change to reload available dates
document.getElementById('duration').addEventListener('change', function() {
    calculateTotal();
    loadAvailableDates(); // Reload available dates when duration changes
});

// Add event listener for date change
document.getElementById('bookingDate').addEventListener('change', loadAvailableTimeSlots);

// Calculate total price
function calculateTotal() {
    const duration = document.getElementById('duration').value;
    const total = duration ? duration * pricePerHour : 0;
    document.getElementById('totalPrice').textContent = total > 0 ? `Rp ${total.toLocaleString('id-ID')}` : 'Rp 0';
}

// Handle form submission with Midtrans Snap
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validate form
    const ballType = document.getElementById('ballType').value;
    const tanggal = document.getElementById('bookingDate').value;
    const jamMulai = document.getElementById('startTime').value;
    const durasi = document.getElementById('duration').value;
    
    if (!ballType || !tanggal || !jamMulai || !durasi) {
        Swal.fire({
            icon: 'warning',
            title: 'Form Tidak Lengkap',
            text: 'Mohon lengkapi semua field booking termasuk jenis permainan',
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
            
            // Get ball type text
            const ballTypeText = ballType === '8_ball' ? '8 Ball' : '9 Ball';
            
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
                                <td style="padding: 8px 0;"><strong>Jenis Permainan:</strong></td>
                                <td style="padding: 8px 0;">${ballTypeText}</td>
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
@endauth
</script>
@endpush