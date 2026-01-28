# Alur Autentikasi untuk Pemesanan Meja

## Ringkasan Perubahan

Telah ditambahkan alur autentikasi yang mengharuskan user untuk login sebelum dapat melakukan pemesanan meja. User yang belum login hanya dapat melihat ketersediaan meja.

## Fitur yang Ditambahkan

### 1. **Halaman Daftar Meja (`/pelanggan/meja`)**
- ✅ User yang belum login dapat melihat semua meja dan ketersediaannya
- ✅ Menampilkan pesan informasi bahwa login diperlukan untuk booking
- ✅ Menampilkan notifikasi kecil di setiap meja yang tersedia
- ✅ Popup konfirmasi saat user belum login mencoba mengklik detail meja

### 2. **Halaman Detail Meja (`/pelanggan/meja/{id}/detail`)**
- ✅ User yang belum login dapat melihat detail meja dan spesifikasi
- ✅ Form booking hanya muncul untuk user yang sudah login
- ✅ User yang belum login melihat pesan login dengan tombol "Masuk" dan "Daftar"
- ✅ Menampilkan informasi ketersediaan untuk user yang belum login

### 3. **Halaman Beranda (`/pelanggan/beranda`)**
- ✅ Menampilkan panduan cara booking untuk user yang belum login
- ✅ Langkah-langkah booking dijelaskan dengan jelas

### 4. **Controller dan Middleware**
- ✅ `BookingController` dilindungi dengan middleware `auth`
- ✅ Validasi tambahan di method `processBooking()` dan `checkout()`
- ✅ Response JSON untuk AJAX request yang tidak terautentikasi

## Alur Booking yang Baru

### Untuk User yang Belum Login:
1. **Lihat Daftar Meja** - Dapat melihat semua meja dan status ketersediaan
2. **Lihat Detail Meja** - Dapat melihat spesifikasi dan informasi meja
3. **Pesan Login** - Melihat pesan bahwa login diperlukan untuk booking
4. **Redirect ke Login** - Diarahkan ke halaman login/register

### Untuk User yang Sudah Login:
1. **Lihat Daftar Meja** - Dapat melihat semua meja
2. **Pilih Meja** - Klik detail meja untuk melihat form booking
3. **Isi Form Booking** - Lengkapi tanggal, jam, dan durasi
4. **Proses Pembayaran** - Lanjut ke Midtrans untuk pembayaran
5. **Konfirmasi Booking** - Meja berhasil dibooking

## File yang Dimodifikasi

### Views:
- `resources/views/pelangganMeja/meja.blade.php`
- `resources/views/pelangganMeja/detail.blade.php`
- `resources/views/pelanggan/beranda.blade.php`

### Controllers:
- `app/Http/Controllers/Customer/BookingController.php`

### Routes:
- Routes sudah menggunakan middleware `auth` untuk booking

## Pesan dan Notifikasi

### 1. **Pesan di Halaman Daftar Meja**
```
Anda dapat melihat ketersediaan meja tanpa login. Untuk melakukan pemesanan, 
silakan masuk atau daftar terlebih dahulu.
```

### 2. **Pesan di Detail Meja**
```
Login Diperlukan
Untuk melakukan pemesanan meja, Anda harus masuk ke akun terlebih dahulu. 
Anda dapat melihat ketersediaan meja tanpa login.
```

### 3. **Popup Konfirmasi**
```
Login Diperlukan
Untuk melakukan pemesanan meja, Anda harus masuk ke akun terlebih dahulu.
Anda dapat melihat detail dan ketersediaan meja tanpa login.
```

## Keamanan

- ✅ Middleware `auth` di `BookingController`
- ✅ Validasi autentikasi di setiap method booking
- ✅ Response JSON untuk AJAX request yang tidak terautentikasi
- ✅ Redirect ke login dengan pesan error yang jelas

## Testing

### Test Case yang Harus Dijalankan:

1. **User Belum Login:**
   - Akses `/pelanggan/meja` → Harus bisa melihat daftar meja
   - Klik detail meja → Popup konfirmasi muncul
   - Akses `/pelanggan/meja/{id}/detail` → Harus bisa melihat detail tapi tidak ada form booking
   - Akses `/pelanggan/checkout` → Redirect ke login
   - POST ke `/pelanggan/booking/process` → Error 401

2. **User Sudah Login:**
   - Akses `/pelanggan/meja` → Bisa melihat daftar meja tanpa pesan login
   - Klik detail meja → Langsung ke halaman detail
   - Akses `/pelanggan/meja/{id}/detail` → Form booking muncul
   - Isi form dan submit → Proses booking berhasil

## Catatan Implementasi

- Menggunakan `@auth` dan `@guest` directive di Blade templates
- JavaScript hanya dijalankan untuk user yang sudah login
- SweetAlert2 untuk popup konfirmasi yang user-friendly
- Styling konsisten dengan tema aplikasi
- Responsive design untuk mobile dan desktop