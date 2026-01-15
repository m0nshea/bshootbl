@extends('layouts.customer-no-footer')

@section('title', 'Profil Pengguna - Bshoot Billiard')
@section('description', 'Halaman profil pengguna - Bshoot Billiard')

@push('styles')
<link href="{{ asset('css/customer-profil.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="container">
    <!-- Profile Card -->
    <div class="profile-card">
        <!-- Profile Header -->
        <div class="profile-header">
            <h1 class="profile-title">
                <i class="bi bi-person-circle"></i>
                Profil Pengguna
            </h1>
        </div>
        
        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Profile Form -->
        <form action="{{ route('customer.profil.update') }}" method="POST" id="profileForm">
            @csrf
            @method('PUT')
            
            <!-- Nama Lengkap -->
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-input" id="nama" name="nama" value="{{ old('nama', $user->name) }}" required />
            </div>
            
            <!-- Email -->
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-input" id="email" name="email" value="{{ old('email', $user->email) }}" required />
            </div>
            
            <!-- Nomor Telepon -->
            <div class="form-group">
                <label class="form-label">Nomor Telepon</label>
                <input type="text" class="form-input" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" placeholder="Contoh: 081234567890" required />
                <div class="form-help">* Diperlukan untuk konfirmasi pemesanan</div>
            </div>
            
            <!-- Alamat Lengkap -->
            <div class="form-group">
                <label class="form-label">Alamat Lengkap</label>
                <textarea class="form-textarea" id="alamat" name="alamat" placeholder="Masukkan alamat lengkap Anda" required>{{ old('alamat', $user->alamat) }}</textarea>
            </div>
            
            <!-- Tanggal Lahir -->
            <div class="form-group">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-input" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" />
            </div>
            
            <!-- Kata Sandi Baru -->
            <div class="form-group">
                <label class="form-label">Kata Sandi Baru</label>
                <input type="password" class="form-input" id="password_baru" name="password_baru" placeholder="Isi jika ingin mengubah kata sandi" />
                <div class="form-help">* Kosongkan jika tidak ingin mengubah kata sandi</div>
            </div>
            
            <!-- Konfirmasi Kata Sandi Baru -->
            <div class="form-group">
                <label class="form-label">Konfirmasi Kata Sandi Baru</label>
                <input type="password" class="form-input" id="password_baru_confirmation" name="password_baru_confirmation" placeholder="Ulangi kata sandi baru" />
            </div>
            
            <!-- Buttons -->
            <div class="btn-group">
                <a href="{{ route('customer.beranda') }}" class="btn-back">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>
                <button type="submit" class="btn-save">
                    <i class="bi bi-save"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Cek apakah datang dari halaman checkout
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('from') === 'checkout') {
        Swal.fire({
            icon: 'info',
            title: 'Lengkapi Profil Anda',
            text: 'Silakan lengkapi data profil Anda untuk melanjutkan pemesanan meja billiard.',
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#28a745'
        });
    }
});

function validasiForm(event) {
    const form = event.target;
    const nama = form.nama.value.trim();
    const email = form.email.value.trim();
    const noTelepon = form.no_telepon.value.trim();
    const alamat = form.alamat.value.trim();
    const passwordBaru = form.password_baru.value;
    const konfirmasiPassword = form.password_baru_confirmation.value;

    // Reset validation states
    const inputs = form.querySelectorAll('.form-input, .form-textarea');
    inputs.forEach(input => {
        input.classList.remove('is-invalid', 'is-valid');
    });

    let isValid = true;

    // Validasi field wajib
    if (!nama || !email || !noTelepon || !alamat) {
        Swal.fire({
            icon: 'error',
            title: 'Data Belum Lengkap!',
            text: 'Mohon lengkapi semua field yang diperlukan.',
            confirmButtonColor: '#dc3545'
        });
        
        // Mark invalid fields
        if (!nama) form.nama.classList.add('is-invalid');
        if (!email) form.email.classList.add('is-invalid');
        if (!noTelepon) form.no_telepon.classList.add('is-invalid');
        if (!alamat) form.alamat.classList.add('is-invalid');
        
        event.preventDefault();
        return false;
    }

    // Validasi email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        Swal.fire({
            icon: 'error',
            title: 'Email Tidak Valid!',
            text: 'Mohon masukkan alamat email yang valid.',
            confirmButtonColor: '#dc3545'
        });
        form.email.classList.add('is-invalid');
        event.preventDefault();
        return false;
    }

    // Validasi nomor HP
    const nohpRegex = /^[0-9]{10,13}$/;
    if (!nohpRegex.test(noTelepon.replace(/[^0-9]/g, ''))) {
        Swal.fire({
            icon: 'error',
            title: 'Nomor Telepon Tidak Valid!',
            text: 'Mohon masukkan nomor telepon yang valid (10-13 digit).',
            confirmButtonColor: '#dc3545'
        });
        form.no_telepon.classList.add('is-invalid');
        event.preventDefault();
        return false;
    }

    // Validasi password jika diisi
    if (passwordBaru || konfirmasiPassword) {
        if (passwordBaru !== konfirmasiPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Password Tidak Cocok!',
                text: 'Konfirmasi password tidak sesuai dengan password baru.',
                confirmButtonColor: '#dc3545'
            });
            form.password_baru.classList.add('is-invalid');
            form.password_baru_confirmation.classList.add('is-invalid');
            event.preventDefault();
            return false;
        }
    }

    // Mark valid fields
    inputs.forEach(input => {
        if (input.value.trim() && !input.classList.contains('is-invalid')) {
            input.classList.add('is-valid');
        }
    });

    // Form akan disubmit secara normal ke server
    return true;
}

// Attach form validation
document.getElementById('profileForm').addEventListener('submit', validasiForm);

// Real-time validation
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.form-input, .form-textarea');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && this.value.trim()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });
        
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid', 'is-valid');
        });
    });
});
</script>
@endpush