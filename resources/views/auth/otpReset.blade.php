<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Masuk OTP - Bshoot Billiard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Masuk OTP yang dikirim email" name="description" />
    
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
                <a href="{{ route('register') }}" class="nav-link">Daftar</a>
                <a href="{{ route('login') }}" class="nav-link active">Masuk</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row align-items-center min-vh-70">
            <!-- LEFT CONTENT - Login Form -->
            <div class="col-md-6 pe-md-5">
                <div class="auth-form-wrapper" style="margin-top: -40px">
                    <h1 class="auth-title">Reset Password</h1>
                    <p class="auth-subtitle">Masukkan kode OTP dan password baru Anda</p>
                    
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success mb-4">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <!-- Reset Password Form -->
                    <form method="POST" action="{{ route('password.reset.verify') ?? '#' }}" id="resetForm" class="auth-form">
                        @csrf
                        
                        <input type="hidden" name="email" id="email" value="{{ old('email', request()->query('email') ?? $email ?? '') }}" />

                        <div class="form-group">
                            <label class="form-label">Email Tujuan</label>
                            <input type="text" class="form-input" value="{{ old('email', request()->query('email') ?? $email ?? '') }}" readonly />
                            <small class="text-muted">Kode OTP telah dikirim ke email tersebut.</small>
                        </div>

                        <!-- OTP Code -->
                        <div class="form-group">
                            <label class="form-label" for="otp">Kode OTP</label>
                            <input type="text" 
                                   class="form-input @error('otp') is-invalid @enderror" 
                                   id="otp" 
                                   name="otp" 
                                   value="{{ old('otp') }}" 
                                   placeholder="Masukkan 6 digit kode OTP"
                                   maxlength="6"
                                   pattern="[0-9]{6}"
                                   required />
                            @error('otp')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Password Baru -->
                        <div class="form-group">
                            <label class="form-label" for="password">Password Baru</label>
                            <div class="password-input-wrapper">
                                <input type="password" 
                                       class="form-input @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Masukkan password baru Anda"
                                       required />
                                <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Konfirmasi Password -->
                        <div class="form-group">
                            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                            <div class="password-input-wrapper">
                                <input type="password" 
                                       class="form-input @error('password_confirmation') is-invalid @enderror" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Konfirmasi password baru Anda"
                                       required />
                            </div>
                            @error('password_confirmation')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Reset Password
                        </button>
                        
                        <!-- Additional Links -->
                        <div class="auth-links">
                            <a href="{{ route('login') }}" class="auth-link">
                                <i class="bi bi-arrow-left me-1"></i>Kembali ke Login
                            </a>
                            <span class="mx-2">•</span>
                            <a href="{{ route('register') }}" class="auth-link">
                                Belum punya akun? Daftar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- RIGHT IMAGE -->
            <div class="col-md-6 ps-md-4" style="margin-top: 90px;">
                <div class="auth-image-wrapper">
                    <img src="{{ asset('img/ball.jpeg') }}" class="auth-image" alt="Billiard Ball" />
                </div> 
                <div class="mt-3 auth-info-box">
                    <h4><b>Kenapa Memilih Kami?</b></h4>
                    <ul>
                        <li>Booking mudah dan cepat</li>
                        <li>Meja berkualitas premium</li>
                        <li>Harga terjangkau</li>
                        <li>Lokasi strategis</li>
                    </ul>
                    <p class="mt-3"><b>Hubungi Kami:</b><br>
                    Jl. sri pelayang, Gn. Kembang<br>
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
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            const otp = document.getElementById('otp').value;
            const password = document.getElementById('password').value;
            const passwordConfirm = document.getElementById('password_confirmation').value;
            
            if (!/^\d{6}$/.test(otp)) {
                e.preventDefault();
                alert('Kode OTP harus 6 digit!');
                return false;
            }
            
            if (password !== passwordConfirm) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak sama!');
                document.getElementById('password_confirmation').classList.add('is-invalid');
                return false;
            }
            
            const submitBtn = this.querySelector('.btn-primary');
            submitBtn.textContent = 'Memproses...';
            submitBtn.disabled = true;
        });
        
        // OTP input hanya boleh angka
        document.getElementById('otp').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
        // Password confirmation validation real-time
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            if (this.value && this.value !== password) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    </script>
</body>
</html>
