# Checkout & QRIS Payment Update

## Perubahan yang Dilakukan

### 1. Metode Pembayaran di Checkout
✅ **Hapus COD (Cash on Delivery)**
- Hanya tersedia 2 metode pembayaran:
  1. **QRIS** (default/terpilih otomatis)
  2. **Transfer Bank**

✅ **QRIS sebagai default**
- QRIS dipilih secara otomatis saat halaman checkout dibuka
- User bisa ganti ke Transfer Bank jika mau

### 2. Redirect ke Halaman QRIS
✅ **Setelah klik "Pesan Sekarang"**:
- Sistem membuat transaksi baru di database
- Generate kode transaksi unik (format: TRX-YYYYMMDD-XXXXXX)
- Jika pilih QRIS → redirect ke halaman QRIS dengan data transaksi
- Jika pilih Transfer Bank → redirect ke halaman pembayaran transfer

### 3. Alur Booking Lengkap

#### Step 1: Pilih Meja
- Customer pilih meja di halaman `/pelanggan/meja`
- Klik "Booking Sekarang"

#### Step 2: Checkout
- Isi form checkout:
  - Nama lengkap (auto-fill dari user login)
  - Email (auto-fill dari user login)
  - Nomor telepon
  - Tanggal booking
  - Waktu mulai
  - Durasi (1-8 jam)
  - Metode pembayaran (QRIS/Transfer Bank)
  - Catatan tambahan (opsional)
- Total harga dihitung otomatis: harga per jam × durasi
- Klik "Pesan Sekarang"

#### Step 3: Pembayaran QRIS
- Redirect ke halaman QRIS
- Tampil detail pesanan:
  - Nama pelanggan
  - Nomor telepon
  - Nama meja
  - Durasi
  - Tanggal & waktu booking
  - Total pembayaran
- QR Code untuk scan
- Timer countdown 5 menit
- Klik "Sudah Bayar" setelah transfer

#### Step 4: Konfirmasi
- Status pembayaran berubah jadi "paid"
- Redirect ke halaman riwayat
- Transaksi tersimpan di database

### 4. File yang Dimodifikasi

#### Views:
1. `resources/views/pelangganMeja/checkout.blade.php`
   - Hapus metode pembayaran COD
   - QRIS sebagai default
   - Hapus debug info

2. `resources/views/pelangganQris/qris.blade.php`
   - Update untuk menampilkan data transaksi
   - Tambah fungsi konfirmasi pembayaran via AJAX
   - Update tombol "Kembali" ke halaman meja

#### Controllers:
1. `app/Http/Controllers/Customer/BookingController.php`
   - Update method `processBooking()`:
     - Validasi input
     - Create transaksi baru
     - Generate kode transaksi
     - Redirect ke QRIS atau pembayaran
   - Update method `qris()`:
     - Handle transaksi dengan benar
     - Check ownership transaksi

### 5. Database - Tabel Transaksis

Kolom yang diisi saat booking:
```php
- kode_transaksi (auto-generated)
- user_id (dari Auth)
- meja_id (dari form)
- nama_pelanggan (dari form)
- email_pelanggan (dari form)
- no_telepon (dari form)
- tanggal_booking (dari form)
- jam_mulai (dari form)
- durasi (dari form)
- total_harga (calculated)
- metode_pembayaran (qris/transfer)
- status_pembayaran (pending)
- status_booking (pending)
- catatan (dari form, optional)
```

### 6. Validasi Form Checkout

✅ **Field Wajib**:
- Nama lengkap
- Email
- Tanggal booking
- Waktu mulai
- Durasi
- Metode pembayaran

✅ **Field Opsional**:
- Nomor telepon
- Catatan tambahan

✅ **Validasi Server-side**:
- Meja ID harus valid
- Email harus valid
- Tanggal booking harus valid
- Durasi 1-8 jam
- Metode pembayaran hanya qris/transfer

### 7. Testing

#### Test Booking dengan QRIS:
1. Login sebagai customer
2. Pilih meja di `/pelanggan/meja`
3. Klik "Booking Sekarang"
4. Isi form checkout
5. Pilih QRIS (sudah terpilih otomatis)
6. Klik "Pesan Sekarang"
7. Cek redirect ke halaman QRIS
8. Cek data transaksi tampil dengan benar
9. Klik "Sudah Bayar"
10. Cek redirect ke riwayat

#### Test Booking dengan Transfer Bank:
1. Login sebagai customer
2. Pilih meja
3. Isi form checkout
4. Pilih Transfer Bank
5. Klik "Pesan Sekarang"
6. Cek redirect ke halaman pembayaran transfer

### 8. Routes

```php
// Checkout
GET  /pelanggan/checkout

// Process Booking
POST /pelanggan/booking/process

// QRIS Payment
GET  /pelanggan/qris/{transaksi}

// Confirm Payment
POST /pelanggan/payment/confirm/{transaksi}

// Transfer Payment
GET  /pelanggan/pembayaran/{transaksi}

// Riwayat
GET  /pelanggan/riwayat
```

### 9. Status Transaksi

#### Status Pembayaran:
- `pending` → Belum bayar
- `paid` → Sudah bayar
- `failed` → Gagal

#### Status Booking:
- `pending` → Menunggu konfirmasi
- `confirmed` → Dikonfirmasi admin
- `checked_in` → Sudah check-in
- `checked_out` → Sudah check-out
- `cancelled` → Dibatalkan

### 10. Timer QRIS

✅ **Countdown 5 menit**:
- Timer mulai saat halaman QRIS dibuka
- Tampil format MM:SS
- Warna berubah merah jika < 1 menit
- Animasi pulse jika < 1 menit
- Halaman expired jika waktu habis

### 11. Security

✅ **CSRF Protection**:
- Semua form menggunakan @csrf token

✅ **Authentication**:
- Checkout hanya untuk user yang login
- Check ownership transaksi

✅ **Validation**:
- Server-side validation untuk semua input
- Client-side validation untuk UX

### 12. Error Handling

✅ **Try-Catch di Controller**:
- Log error ke Laravel log
- Redirect back dengan error message
- Keep user input dengan withInput()

✅ **Error Messages**:
- Tampil di halaman checkout
- Alert untuk error AJAX

## Kesimpulan

Semua perubahan sudah selesai:
✅ Hapus metode pembayaran COD
✅ Hanya QRIS dan Transfer Bank
✅ QRIS sebagai default
✅ Redirect ke halaman QRIS setelah booking
✅ Tampil data transaksi di halaman QRIS
✅ Konfirmasi pembayaran via AJAX
✅ Timer countdown 5 menit
✅ Validasi lengkap
✅ Error handling
