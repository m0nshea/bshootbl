<footer class="py-5" style="background: var(--bg-dark); color: var(--text-light);">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-item">
                    <h4 class="fw-bold mb-4" style="color: var(--text-light);">Bshoot Billiard</h4>
                    <p style="color: var(--neutral-dark);">
                        B Shoot Billiard hadir untuk menemani waktu nongkrong Anda. 
                        Dari mencari tempat hingga siap bermain, semua dimulai dari booking meja billiard yang mudah di sini.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="footer-item">
                    <h4 class="fw-bold mb-4" style="color: var(--text-light);">Tautan Cepat</h4>
                    <div class="d-flex flex-column align-items-start">
                        <a href="{{ url('/') }}" class="text-decoration-none mb-2" style="color: var(--neutral-dark);">
                            <i class="bi bi-chevron-right me-2"></i>Beranda
                        </a>
                        <a href="{{ url('kategori') }}" class="text-decoration-none mb-2" style="color: var(--neutral-dark);">
                            <i class="bi bi-chevron-right me-2"></i>Kategori
                        </a>
                        <a href="{{ url('meja') }}" class="text-decoration-none mb-2" style="color: var(--neutral-dark);">
                            <i class="bi bi-chevron-right me-2"></i>Daftar Meja
                        </a>
                        <a href="{{ url('daftar') }}" class="text-decoration-none mb-2" style="color: var(--neutral-dark);">
                            <i class="bi bi-chevron-right me-2"></i>Daftar
                        </a>
                        <a href="{{ url('login') }}" class="text-decoration-none" style="color: var(--neutral-dark);">
                            <i class="bi bi-chevron-right me-2"></i>Login
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="footer-item">
                    <h4 class="fw-bold mb-4" style="color: var(--text-light);">Lokasi</h4>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d50413.70794545488!2d102.65598122167965!3d-2.3063046!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e2e2e6aaaaaaaab%3A0xc6e3abd4515b1881!2sBank%20Mandiri%20Sarolangun%20Sri%20Pelayang!5e1!3m2!1sid!2sid!4v1765169332067!5m2!1sid!2sid"
                        width="100%"
                        height="200"
                        style="border: 0; border-radius: 8px;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>

        <hr style="border-color: var(--neutral-darker); margin: 3rem 0 2rem 0;">
        
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0" style="color: var(--neutral-dark);">
                    © 2025 Bshoot Billiard. Dibuat dengan 
                    <i class="bi bi-heart-fill" style="color: var(--accent-red);"></i> 
                    untuk pengalaman bermain yang lebih baik.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="#" class="btn rounded-circle" style="background: var(--primary-green); color: var(--text-light); width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="bi bi-arrow-up"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
