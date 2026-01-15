@extends('layouts.customer')

@section('title', 'Beranda - Bshoot Billiard')
@section('description', 'Halaman beranda setelah login - Bshoot Billiard')

@push('styles')
<style>
body {
    font-family: 'Poppins', sans-serif !important;
}

/* Ubah warna teks "Game Sempurna!" menjadi hijau seperti header */
.home-hero-title span {
    color: #135f3a !important; /* Warna hijau sama dengan navbar */
}

/* Styling untuk button Temukan Meja */
.home-btn-find {
    background: #135f3a !important;
    color: #ffffff !important;
    padding: 8px 16px !important;
    border-radius: 6px !important;
    text-decoration: none !important;
    font-weight: 600 !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    transition: all 0.3s ease !important;
    border: none !important;
    font-size: 0.9rem !important;
    width: fit-content !important;
    margin-bottom: 1.5rem !important;
}

.home-btn-find:hover {
    background: #0f4a2e !important;
    color: #ffffff !important;
    text-decoration: none !important;
}

.home-btn-find .bi-chevron-right {
    color: white;
    font-size: 0.9rem;
    margin-left: 6px;
}

/* Styling untuk hero title */
.home-hero-title {
    color: #000 !important;
    font-weight: 700 !important;
    font-size: 2.8rem !important;
    line-height: 1.2 !important;
    margin-bottom: 1.5rem !important;
    margin-top: 0 !important;
}

/* Styling untuk hero description */
.home-hero-description {
    color: #000 !important;
    font-size: 1.1rem !important;
    line-height: 1.6 !important;
    margin-bottom: 2rem !important;
    max-width: 400px;
}

.home-hero-description strong {
    color: #135f3a;
    font-weight: 600;
}

/* Social media section */
.home-social-section {
    margin-top: 1rem;
}

.home-social-icons {
    display: flex;
    gap: 12px;
    margin-bottom: 8px;
}

.home-social-icons span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    background: rgba(19, 95, 58, 0.1);
    border-radius: 50%;
    transition: all 0.3s ease;
    cursor: pointer;
}

.home-social-icons span:hover {
    background: rgba(19, 95, 58, 0.2);
}

.home-social-icons span i {
    color: #135f3a !important;
    font-size: 1.1rem;
}

.home-social-handle {
    color: #666 !important;
    font-size: 1rem;
    font-weight: 500;
}

/* Right column positioning */
.col-md-6.ps-md-4 {
    display: flex !important;
    flex-direction: column !important;
    align-items: flex-end !important;
    padding-left: 2rem !important;
    position: relative !important;
    height: 100% !important;
    justify-content: flex-start !important;
}

/* Image wrapper */
.home-image-wrapper {
    position: relative;
    display: flex;
    justify-content: flex-end;
    align-items: flex-start;
    width: 100%;
    margin-bottom: 1rem;
}

/* Hero image */
.home-hero-image {
    border-radius: 15px !important;
    width: 450px !important;
    height: 280px !important;
    object-fit: cover !important;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
    position: relative !important;
    right: -5rem !important;
    margin:10px 80px 0 0;
}

/* Contact section */
.home-contact-section {
    display: flex;
    justify-content: flex-end;
    margin-top: 1rem;
    width: 100%;
}

.home-contact-box {
    max-width: 350px !important;
    position: relative !important;
    background: rgba(19, 95, 58, 0.1) !important;
    backdrop-filter: blur(10px) !important;
    border-radius: 12px !important;
    padding: 24px !important;
    border: 1px solid rgba(19, 95, 58, 0.2) !important;
    text-align: right !important;
    color: #333 !important;
}

.home-contact-box b {
    color: #135f3a !important;
}

/* Ensure footer appears */
body {
    display: flex !important;
    flex-direction: column !important;
    min-height: 100vh !important;
    background: #ffffff !important;
    color: #000 !important;
}

main {
    flex: 1 !important;
}
</style>
@endpush

@section('content')
<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 20px; background: rgba(40, 167, 69, 0.1); color: #155724; border: 1px solid #c3e6cb; border-radius: 8px; padding: 12px 16px;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 20px; background: rgba(220, 53, 69, 0.1); color: #721c24; border: 1px solid #f5c6cb; border-radius: 8px; padding: 12px 16px;">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@auth
    <div class="alert alert-info alert-dismissible fade show" role="alert" style="margin: 20px; background: rgba(13, 202, 240, 0.1); color: #055160; border: 1px solid #b6effb; border-radius: 8px; padding: 12px 16px;">
        Selamat datang, {{ Auth::user()->name }}! Anda login sebagai {{ Auth::user()->role == 'admin' ? 'Admin' : 'Pelanggan' }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endauth

<div class="container py-5 home-hero-section">
    <div class="row align-items-center min-vh-70">
        
        <!-- LEFT CONTENT -->
        <div class="col-md-6 pe-md-5">
            <div class="home-content-wrapper">
                <h1 class="home-hero-title">
                    Satu Klik untuk<br>
                    <span>Game Sempurna!</span>
                </h1>

                <p class="home-hero-description">
                    <strong>B Shoot Billiard</strong> hadir untuk menemani waktu nongkrong Anda. 
                    Dari mencari tempat hingga siap bermain, semua dimulai dari booking meja billiard yang mudah di sini.
                </p>

                <a href="{{ route('customer.meja') }}" class="home-btn-find">
                    Temukan Meja <i class="bi bi-chevron-right"></i>
                </a>

                <div class="home-social-section">
                    <div class="home-social-icons">
                        <span><i class="bi bi-twitter"></i></span>
                        <span><i class="bi bi-instagram"></i></span>
                        <span><i class="bi bi-facebook"></i></span>
                        <span><i class="bi bi-tiktok"></i></span>
                    </div>
                    <span class="home-social-handle">@bshootbilliard</span>
                </div>
            </div>
        </div>

        <!-- RIGHT IMAGE -->
        <div class="col-md-6 ps-md-4">
            <div class="home-image-wrapper">
                <img src="{{ asset('img/table.jpeg') }}" class="home-hero-image" alt="Meja Billiard">
            </div>

            <div class="home-contact-section">
                <div class="home-contact-box">
                    <b>Kontak Kami</b><br>
                    Jl. Sri Pelayang, Gn. Kembang, Kec. Sarolangun,<br>
                    Kabupaten Sarolangun, Jambi<br><br>
                    <b>0813-6780-4400</b>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection