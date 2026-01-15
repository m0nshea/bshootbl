# Customer Profile System - Panduan

## Fitur yang Sudah Dibuat

### 1. Halaman Profil Customer
- **Route**: `/pelanggan/profil`
- **Controller**: `App\Http\Controllers\Customer\ProfilController`
- **View**: `resources/views/pelangganProfil/profil.blade.php`

### 2. Fitur Profil
✅ Menampilkan data user yang sedang login:
- Nama Lengkap
- Email
- Nomor Telepon
- Alamat Lengkap
- Tanggal Lahir

✅ Update profil dengan validasi:
- Semua field wajib diisi kecuali tanggal lahir dan password
- Email harus valid dan unique
- Nomor telepon harus 10-13 digit
- Password minimal 8 karakter (jika diubah)
- Konfirmasi password harus sama

✅ Ubah password (opsional):
- Kosongkan jika tidak ingin mengubah password
- Password baru minimal 8 karakter
- Harus konfirmasi password

### 3. Database
✅ Migration sudah dijalankan:
- Kolom `tanggal_lahir` ditambahkan ke tabel `users`
- Kolom `no_telepon` dan `alamat` sudah ada dari migration sebelumnya

### 4. Alur Kerja

#### Registrasi Customer:
1. Customer daftar di `/register`
2. Data disimpan ke database dengan role `customer`
3. Redirect ke halaman login
4. Customer login dengan email dan password
5. Redirect ke beranda customer

#### Login Customer:
1. Customer login di `/login`
2. Sistem cek role:
   - Jika admin → redirect ke admin dashboard
   - Jika customer → redirect ke beranda customer
3. Data user tersimpan di session

#### Update Profil:
1. Customer klik icon profil di navbar
2. Form profil menampilkan data user yang login
3. Customer edit data dan klik "Simpan Perubahan"
4. Data divalidasi di server
5. Jika valid, data disimpan dan tampil pesan sukses
6. Jika error, tampil pesan error

### 5. Validasi
- **Client-side**: JavaScript dengan SweetAlert2
- **Server-side**: Laravel validation rules
- **Real-time**: Input validation saat blur

### 6. Security
✅ Middleware `auth` untuk proteksi route profil
✅ CSRF token untuk form submission
✅ Password hashing dengan bcrypt
✅ Email unique validation

### 7. UI/UX
✅ Design konsisten dengan halaman lain
✅ Green theme (#135f3a)
✅ Responsive design
✅ Alert messages untuk feedback
✅ Icon profil di navbar
✅ Form validation states (valid/invalid)

## Testing

### Test Registrasi dan Login:
1. Buka `http://localhost:8000/register`
2. Daftar dengan data lengkap
3. Login dengan email dan password yang didaftarkan
4. Cek apakah redirect ke beranda customer

### Test Profil:
1. Login sebagai customer
2. Klik icon profil di navbar
3. Cek apakah data user tampil dengan benar
4. Edit data dan simpan
5. Cek apakah data berhasil diupdate

### Test Admin Login:
1. Buka `http://localhost:8000/create-admin-gnov`
2. Login dengan:
   - Email: `gnovfitriana@gmail.com`
   - Password: `12345`
3. Cek apakah redirect ke admin dashboard

## File yang Dimodifikasi/Dibuat

### Controller:
- `app/Http/Controllers/Customer/ProfilController.php` (BARU)

### View:
- `resources/views/pelangganProfil/profil.blade.php` (UPDATE)

### Model:
- `app/Models/User.php` (UPDATE - tambah tanggal_lahir ke fillable)

### Migration:
- `database/migrations/2026_01_14_040008_add_tanggal_lahir_to_users_table.php` (BARU)

### Routes:
- `routes/web.php` (UPDATE - tambah route profil)

### CSS:
- `public/css/customer-profil.css` (UPDATE - tambah alert styles)

## Catatan Penting

1. **Tanggal Lahir**: Field ini opsional (nullable)
2. **Password**: Hanya diupdate jika field password_baru diisi
3. **Email**: Harus unique, tidak boleh sama dengan user lain
4. **Nomor Telepon**: Format bebas, minimal 10 digit, maksimal 13 digit
5. **Session**: Data user tersimpan di session setelah login
6. **Navbar**: Icon profil hanya tampil jika user sudah login

## Troubleshooting

### Profil tidak menampilkan data:
- Pastikan user sudah login
- Cek session dengan `php artisan tinker` → `auth()->user()`

### Error saat update:
- Cek validation error di alert message
- Cek log Laravel di `storage/logs/laravel.log`

### Migration error:
- Jalankan `php artisan migrate:fresh` (HATI-HATI: akan hapus semua data)
- Atau `php artisan migrate:rollback` lalu `php artisan migrate`
