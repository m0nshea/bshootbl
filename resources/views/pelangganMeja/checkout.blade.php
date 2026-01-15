@extends('layouts.customer')

@section('title', 'Checkout - Bshoot Billiard')
@section('description', 'Halaman checkout untuk pemesanan meja billiard')

@push('styles')
<link href="{{ asset('css/customer-checkout.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="container">
    <!-- Back Button -->
    <a href="{{ route('customer.meja') }}" class="btn-back-top" style="margin-top: 40px; ">
        <i class="bi bi-arrow-left"></i>Kembali ke Daftar Meja
    </a>

    <!-- Checkout Form Card -->
    <div class="checkout-card">
        <form method="POST" action="{{ route('customer.booking.process') }}" id="checkoutForm">
            @csrf
            
            <!-- Hidden field for meja_id -->
            <input type="hidden" name="meja_id" value="{{ $bookingData['meja']->id }}">
            
            <!-- Meja Information -->
            <div class="meja-info-section">
                <h4>Detail Meja yang Dipilih</h4>
                <div class="selected-meja">
                    <img src="{{ $bookingData['meja']->foto_url }}" alt="{{ $bookingData['meja']->nama_meja }}" class="meja-thumb">
                    <div class="meja-details">
                        <h5>{{ $bookingData['meja']->nama_meja }}</h5>
                        <p>Kategori: {{ $bookingData['meja']->category->nama }}</p>
                        <p class="price">{{ $bookingData['meja']->formatted_harga }}/jam</p>
                    </div>
                </div>
            </div>
            
            <!-- Nama Lengkap -->
            <div class="form-group">
                <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                <input type="text" class="form-input @error('nama_pelanggan') is-invalid @enderror" 
                       name="nama_pelanggan" value="{{ old('nama_pelanggan', Auth::user()->name ?? '') }}" required />
                @error('nama_pelanggan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Email -->
            <div class="form-group">
                <label class="form-label">Email <span class="required">*</span></label>
                <input type="email" class="form-input @error('email_pelanggan') is-invalid @enderror" 
                       name="email_pelanggan" value="{{ old('email_pelanggan', Auth::user()->email ?? '') }}" required />
                @error('email_pelanggan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Nomor Telepon -->
            <div class="form-group">
                <label class="form-label">Nomor Telepon</label>
                <input type="text" class="form-input @error('no_telepon') is-invalid @enderror" 
                       name="no_telepon" value="{{ old('no_telepon') }}" placeholder="Contoh: 08123456789" />
                @error('no_telepon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Tanggal dan Waktu -->
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Tanggal Pemesanan <span class="required">*</span></label>
                        <input type="date" class="form-input @error('tanggal_booking') is-invalid @enderror" 
                               name="tanggal_booking" value="{{ old('tanggal_booking', $bookingData['tanggal'] ?? '') }}" required />
                        @error('tanggal_booking')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-col">
                    <div class="form-group">
                        <label class="form-label">Waktu Mulai <span class="required">*</span></label>
                        <select class="form-select @error('jam_mulai') is-invalid @enderror" name="jam_mulai" required>
                            <option value="">Jam berapa akan mulai bermain</option>
                            @for($i = 8; $i <= 21; $i++)
                                @php $time = sprintf('%02d:00', $i); @endphp
                                <option value="{{ $time }}" {{ old('jam_mulai', $bookingData['jam'] ?? '') == $time ? 'selected' : '' }}>
                                    {{ $time }}
                                </option>
                            @endfor
                        </select>
                        @error('jam_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Durasi -->
            <div class="form-group">
                <label class="form-label">Durasi Bermain <span class="required">*</span></label>
                <select class="form-select @error('durasi') is-invalid @enderror" name="durasi" required id="selectDurasi" onchange="hitungTotal()">
                    <option value="">-- Pilih Durasi --</option>
                    @for($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ old('durasi', $bookingData['durasi'] ?? '') == $i ? 'selected' : '' }}>
                            {{ $i }} Jam
                        </option>
                    @endfor
                </select>
                @error('durasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Metode Pembayaran -->
            <div class="form-group">
                <label class="form-label">Metode Pembayaran <span class="required">*</span></label>
                <div class="payment-methods">
                    <label class="payment-option">
                        <input type="radio" name="metode_pembayaran" value="qris" {{ old('metode_pembayaran', 'qris') == 'qris' ? 'checked' : '' }} required>
                        <span class="payment-label">
                            <i class="bi bi-qr-code"></i>
                            QRIS
                        </span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="metode_pembayaran" value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'checked' : '' }} required>
                        <span class="payment-label">
                            <i class="bi bi-bank"></i>
                            Transfer Bank
                        </span>
                    </label>
                </div>
                @error('metode_pembayaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Catatan Tambahan -->
            <div class="form-group">
                <label class="form-label">Catatan Tambahan</label>
                <textarea class="form-textarea @error('catatan') is-invalid @enderror" 
                          name="catatan" placeholder="Masukkan catatan khusus untuk pemesanan (opsional)">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Total Pembayaran -->
            <div class="total-section">
                <div class="total-breakdown">
                    <div class="total-row">
                        <span>Harga per jam:</span>
                        <span id="hargaPerJam">{{ $bookingData['meja']->formatted_harga }}</span>
                    </div>
                    <div class="total-row">
                        <span>Durasi:</span>
                        <span id="durasiText">{{ $bookingData['durasi'] ?? 0 }} jam</span>
                    </div>
                    <div class="total-row total-final">
                        <span class="total-label">Total Pembayaran:</span>
                        <span class="total-amount" id="totalPembayaran">
                            @if(isset($bookingData['total']))
                                Rp {{ number_format($bookingData['total'], 0, ',', '.') }}
                            @else
                                Rp 0
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Error Messages -->
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <!-- Buttons -->
            <div class="btn-group">
                <div class="btn-left">
                    <a href="{{ route('customer.meja') }}" class="btn-back">Kembali</a>
                </div>
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="bi bi-calendar-check me-2"></i>Pesan Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const hargaPerJam = {{ $bookingData['meja']->harga }};

function hitungTotal() {
    const selectDurasi = document.getElementById('selectDurasi');
    const totalElement = document.getElementById('totalPembayaran');
    const durasiText = document.getElementById('durasiText');
    
    if (selectDurasi.value) {
        const durasi = parseInt(selectDurasi.value);
        const total = hargaPerJam * durasi;
        totalElement.textContent = 'Rp ' + total.toLocaleString('id-ID');
        durasiText.textContent = durasi + ' jam';
    } else {
        totalElement.textContent = 'Rp 0';
        durasiText.textContent = '0 jam';
    }
}

// Set tanggal minimum ke hari ini
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.querySelector('input[name="tanggal_booking"]').setAttribute('min', today);
    
    // Calculate initial total if durasi is already selected
    hitungTotal();
});
</script>
@endpush