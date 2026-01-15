<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Daftar - Bshoot Billiard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Daftar akun baru di Bshoot Billiard" name="description" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"/>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/customer-navbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet" />
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg py-3">
        <div class="container d-flex justify-content-between align-items-center nav-custom">
            <div class="nav-title">
                <div class="d-flex align-items-center">
                    <img height="40px" src="{{ asset('img/logo.png') }}" alt="Logo Bshoot Billiard" class="me-2" />
                    <span class="brand-text">Bshoot Billiard</span>
                </div>
            </div>
            <div class="nav-actions d-flex align-items-center">
                <a href="{{ route('home') }}" class="nav-link">Beranda</a>
                <a href="{{ route('register') }}" class="nav-link active">Daftar</a>
                <a href="{{ route('login') }}" class="nav-link">Masuk</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row align-items-center min-vh-70">
            <!-- LEFT CONTENT - Register Form -->
            <div class="col-md-6 pe-md-5">
                <div class="auth-form-wrapper">
                    <h1 class="auth-title">Bergabung dengan Kami!</h1>
                    <p class="auth-subtitle">Buat akun baru untuk mulai menikmati pengalaman booking meja billiard terbaik. Setelah registrasi, Anda perlu login untuk mengakses akun.</p>
                    
                    <!-- Registration Form -->
                    <form method="POST" action="{{ route('register') }}" id="registerForm" class="auth-form">
                        @csrf
                        
                        <!-- Name -->
                        <div class="form-group">
                            <label class="form-label" for="name">Nama Lengkap</label>
                            <input type="text" 
                                   class="form-input @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Masukkan nama lengkap Anda"
                                   required 
                                   autofocus />
                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" 
                                   class="form-input @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="contoh@email.com"
                                   required />
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Password -->
                        <div class="form-group">
                            <label class="form-label" for="password">Password</label>
                            <div class="password-input-wrapper">
                                <input type="password" 
                                       class="form-input @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Masukkan password Anda"
                                       required />
                                <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                            <div class="password-input-wrapper">
                                <input type="password" 
                                       class="form-input" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Ulangi password Anda"
                                       required />
                                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="btn-primary">
                            <i class="bi bi-person-plus me-2"></i>Daftar Akun
                        </button>
                        
                        <!-- Additional Links -->
                        <div class="auth-links">
                            <a href="{{ route('login') }}" class="auth-link">
                                Sudah punya akun? Masuk sekarang
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- RIGHT IMAGE -->
            <div class="col-md-6 ps-md-4">
                <div class="auth-image-wrapper">
                    <img src="{{ asset('img/table.jpeg') }}" class="auth-image" alt="Meja Billiard" />
                </div>
                <div class="mt-3 auth-info-box">
                    <h4><b>Registrasi Pelanggan</b></h4>
                    <ul>
                        <li>Akses booking 24/7</li>
                        <li>Notifikasi real-time</li>
                        <li>Riwayat booking lengkap</li>
                        <li>Promo member eksklusif</li>
                    </ul>
                    <p class="mt-3"><b>Catatan:</b><br>
                    Registrasi ini khusus untuk pelanggan.<br>
                    Admin menggunakan email khusus yang sudah ditentukan.<br><br>
                    <b>Lokasi Kami:</b><br>
                    Jl. sri pelayang, Gn. Kembang, Kec. Sarolangun<br>
                    Kabupaten Sarolangun, Jambi<br>
                    <b>0813-6780-4400</b></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
        
        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                return false;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('.btn-primary');
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        });
        
        // Real-time validation
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password !== confirmPassword) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                if (confirmPassword) {
                    this.classList.add('is-valid');
                }
            }
        });
        
        // Email validation
        document.getElementById('email').addEventListener('blur', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value && !emailRegex.test(this.value)) {
                this.classList.add('is-invalid');
            } else if (this.value) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    </script>
</body>
</html>
