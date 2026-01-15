<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Masuk - Bshoot Billiard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Masuk ke akun Bshoot Billiard Anda" name="description" />
    
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
                <div class="auth-form-wrapper">
                    <h1 class="auth-title">Selamat Datang Kembali!</h1>
                    <p class="auth-subtitle">Masuk ke akun Anda untuk mulai booking meja billiard favorit</p>
                    
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success mb-4">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <!-- Success Message from Registration -->
                    @if (session('success'))
                        <div class="alert alert-success mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" id="loginForm" class="auth-form">
                        @csrf
                        
                        <!-- Email -->
                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" 
                                   class="form-input @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="contoh@email.com"
                                   required 
                                   autofocus />
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
                        
                        <!-- Remember Me -->
                        <div class="form-group">
                            <label class="form-check-label d-flex align-items-center">
                                <input type="checkbox" 
                                       class="form-check-input me-2" 
                                       id="remember_me" 
                                       name="remember">
                                Ingat saya
                            </label>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="btn-primary">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang
                        </button>
                        
                        <!-- Additional Links -->
                        <div class="auth-links">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="auth-link">
                                    Lupa password?
                                </a>
                            @endif
                            <span class="mx-2">•</span>
                            <a href="{{ route('register') }}" class="auth-link">
                                Belum punya akun? Daftar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- RIGHT IMAGE -->
            <div class="col-md-6 ps-md-4">
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
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                e.preventDefault();
                alert('Mohon lengkapi email dan password!');
                return false;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('.btn-primary');
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
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
