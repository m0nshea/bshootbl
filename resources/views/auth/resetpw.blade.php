<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Reset Password - Bshoot Billiard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Reset your password for Bshoot Billiard" name="description" />
    
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
                    <h1 class="auth-title">Reset Password!</h1>
                    <p class="auth-subtitle">Masukkan email Anda untuk reset password</p>
                    
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
                    
                    <!-- Reset Password Request Form -->
                    <form method="POST" action="{{ route('password.sendOtp') }}" id="resetRequestForm" class="auth-form">
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
                        
                        <!-- Submit Button -->
                        <button type="submit" class="btn-primary">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Kirim Kode OTP
                        </button>
                        
                        <!-- Additional Links -->
                        <div class="auth-links">
                            <a href="{{ route('login') }}" class="auth-link">
                                Kembali ke Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- RIGHT IMAGE -->
            <div class="col-md-6 ps-md-4" style="margin-top: 125px;">
                <div class="auth-image-wrapper" >
                    <img src="{{ asset('img/ball.jpeg') }}"  class="auth-image" alt="Billiard Ball" />
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
        document.getElementById('resetRequestForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!email || !emailRegex.test(email)) {
                e.preventDefault();
                alert('Mohon masukkan email yang valid.');
                return false;
            }

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
