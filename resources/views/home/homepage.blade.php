@extends('layouts.customer')

@section('title', 'Beranda - Bshoot Billiard')
@section('description', 'Halaman beranda - Bshoot Billiard')

@push('styles')
<style>
body {
    font-family: 'Poppins', sans-serif !important;
}

/* Ubah warna teks "Game Sempurna!" menjadi hijau seperti header */
.home-hero-title span {
    color: #135f3a !important; /* Warna hijau sama dengan navbar */
}
</style>
@endpush

@section('content')
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
