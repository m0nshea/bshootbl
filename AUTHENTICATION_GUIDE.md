# Authentication System Guide

## Overview
Sistem autentikasi telah dikonfigurasi dengan role-based access control. Terdapat 2 role:
- **Admin**: Ditentukan berdasarkan email khusus
- **Customer**: Semua registrasi normal akan menjadi customer

## Admin Email System
Admin ditentukan berdasarkan email khusus yang sudah ditetapkan:
- admin@bshoot.com
- admin@bshootbilliard.com
- superadmin@bshoot.com
- owner@bshoot.com

**Catatan**: Jika seseorang mendaftar dengan salah satu email di atas, mereka otomatis akan menjadi admin.

## Test Accounts
Berikut adalah akun test yang telah dibuat:

### Admin Account
- **Email**: admin@bshoot.com
- **Password**: admin123
- **Role**: Admin (otomatis berdasarkan email)
- **Redirect**: Dashboard Admin setelah login

### Customer Account
- **Email**: customer@bshoot.com
- **Password**: customer123
- **Role**: Customer
- **Redirect**: Beranda Pelanggan setelah login

### Additional Customer Account
- **Email**: john@example.com
- **Password**: password123
- **Role**: Customer

## How to Test

### 1. Test Admin Login
1. Buka `http://127.0.0.1:8000/login`
2. Login dengan:
   - Email: admin@bshoot.com
   - Password: admin123
3. Setelah login berhasil, akan redirect ke Dashboard Admin

### 2. Test Customer Login
1. Buka `http://127.0.0.1:8000/login`
2. Login dengan:
   - Email: customer@bshoot.com
   - Password: customer123
3. Setelah login berhasil, akan redirect ke Beranda Pelanggan

### 3. Test Customer Registration
1. Buka `http://127.0.0.1:8000/register`
2. Isi form registrasi:
   - Nama Lengkap: [nama anda]
   - Email: [email biasa, bukan admin email]
   - Password: [minimal 8 karakter]
   - Konfirmasi Password: [sama dengan password]
3. Setelah registrasi berhasil, akan redirect ke halaman login dengan pesan sukses
4. Login dengan email dan password yang baru dibuat
5. Setelah login berhasil, akan redirect ke beranda pelanggan

### 4. Test Admin Registration (Automatic)
1. Buka `http://127.0.0.1:8000/register`
2. Isi form registrasi dengan salah satu admin email:
   - Nama Lengkap: [nama anda]
   - Email: admin@bshoot.com (atau email admin lainnya)
   - Password: [minimal 8 karakter]
   - Konfirmasi Password: [sama dengan password]
3. Setelah registrasi berhasil, akan redirect ke halaman login dengan pesan sukses
4. Login dengan email dan password yang baru dibuat
5. Setelah login berhasil, akan redirect ke dashboard admin

### 5. Test Access Control
- Coba akses `http://127.0.0.1:8000/admin/dashboard` tanpa login → akan redirect ke login
- Login sebagai customer, lalu coba akses admin dashboard → akan ditolak dan redirect ke beranda
- Login sebagai admin → dapat akses semua halaman admin

## Create Admin User via Command Line
Anda dapat membuat admin user melalui command line:

```bash
php artisan admin:create admin@bshoot.com "Admin Name" password123
```

Command ini akan:
- Memvalidasi bahwa email termasuk dalam daftar admin email
- Membuat user baru dengan role admin
- Menampilkan informasi user yang dibuat

## Features

### Email-Based Admin Detection
- **Admin emails**: Daftar email yang otomatis menjadi admin
- **Customer emails**: Semua email lainnya menjadi customer
- **Automatic role assignment**: Role ditentukan saat registrasi berdasarkan email

### Role-Based Redirects
- **After Registration** → Login page dengan pesan sukses
- **Admin login** → Dashboard Admin (`/admin/dashboard`)
- **Customer login** → Beranda Pelanggan (`/pelanggan/beranda`)

### Dynamic Navbar
- **Guest users**: Menampilkan tombol "Masuk" dan "Daftar"
- **Authenticated users**: Menampilkan menu sesuai role dan tombol "Keluar"

### Protected Routes
- **Admin routes** (`/admin/*`): Hanya dapat diakses oleh user dengan role admin
- **Customer protected routes**: Checkout, Pembayaran, QRIS, Riwayat, Profil
- **Public routes**: Beranda, Kategori, Meja

### Simplified Registration Flow
- **Registration**: User mengisi form → Akun dibuat → Redirect ke login
- **No auto-login**: User harus login manual setelah registrasi
- **Success message**: Pesan sukses ditampilkan di halaman login
- **Role detection**: Admin ditentukan berdasarkan email saat registrasi

## Database Structure
Tabel `users` memiliki kolom:
- `id`: Primary key
- `name`: Nama lengkap
- `email`: Email (unique)
- `role`: enum('admin', 'customer') - ditentukan otomatis berdasarkan email
- `password`: Password (hashed)
- `created_at`, `updated_at`: Timestamps

## Admin Email List
Untuk menambah email admin baru, edit file `app/Models/User.php` di method `getAdminEmails()`:

```php
public static function getAdminEmails(): array
{
    return [
        'admin@bshoot.com',
        'admin@bshootbilliard.com',
        'superadmin@bshoot.com',
        'owner@bshoot.com',
        // Tambahkan email admin baru di sini
    ];
}
```

## URLs
- **Home**: `http://127.0.0.1:8000/`
- **Login**: `http://127.0.0.1:8000/login`
- **Register**: `http://127.0.0.1:8000/register` (khusus pelanggan)
- **Admin Dashboard**: `http://127.0.0.1:8000/admin/dashboard`
- **Customer Beranda**: `http://127.0.0.1:8000/pelanggan/beranda`

## Success Messages
Sistem akan menampilkan pesan sukses/error di halaman beranda untuk memberikan feedback kepada user tentang status login mereka.