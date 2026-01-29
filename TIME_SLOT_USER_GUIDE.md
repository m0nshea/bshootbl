# Panduan Sistem Booking Time-Slot

## Cara Kerja Sistem Booking Baru

### 🎯 **Konsep Utama**
- **Sebelumnya**: Meja yang sudah dibooking tidak bisa digunakan sama sekali
- **Sekarang**: Meja bisa digunakan oleh beberapa customer di waktu yang berbeda

### 📅 **Langkah-langkah Booking**

1. **Pilih Tanggal**
   - Pilih tanggal yang diinginkan (minimal hari ini)
   - Sistem akan mengecek ketersediaan untuk tanggal tersebut

2. **Pilih Durasi**
   - Pilih berapa jam Anda ingin bermain (1-5 jam)
   - Durasi mempengaruhi slot waktu yang tersedia

3. **Pilih Jam Mulai**
   - Hanya jam yang tersedia yang akan muncul di dropdown
   - Jam yang sudah dibooking tidak akan muncul
   - Sistem menampilkan format "Jam Mulai - Jam Selesai"

### ⏰ **Contoh Skenario**

**Meja A pada tanggal 30 Januari 2025:**
- Booking 1: 09:00 - 11:00 (2 jam) ✅ Sudah dibooking
- Booking 2: 14:00 - 16:00 (2 jam) ✅ Sudah dibooking

**Jika Anda ingin booking 2 jam:**
- ✅ Tersedia: 08:00-10:00, 11:00-13:00, 16:00-18:00, 18:00-20:00
- ❌ Tidak tersedia: 09:00-11:00 (bentrok dengan booking 1), 14:00-16:00 (bentrok dengan booking 2)

**Jika Anda ingin booking 3 jam:**
- ✅ Tersedia: 08:00-11:00, 17:00-20:00
- ❌ Tidak tersedia: 09:00-12:00 (bentrok), 13:00-16:00 (bentrok), dll.

### 🔍 **Fitur Sistem**

1. **Real-time Availability**
   - Ketersediaan waktu diupdate secara real-time
   - Tidak ada double booking

2. **Smart Conflict Detection**
   - Sistem otomatis mendeteksi bentrokan waktu
   - Mencegah booking yang overlap

3. **Duration-based Filtering**
   - Slot waktu disesuaikan dengan durasi yang dipilih
   - Durasi lebih panjang = pilihan waktu lebih sedikit

4. **Visual Feedback**
   - Menampilkan jam yang sudah dibooking
   - Pesan error jika waktu tidak tersedia

### 💡 **Tips untuk User**

1. **Pilih durasi dulu** sebelum memilih jam untuk melihat opsi yang tepat
2. **Booking lebih awal** untuk mendapat pilihan waktu yang lebih banyak
3. **Coba durasi yang berbeda** jika waktu yang diinginkan tidak tersedia
4. **Perhatikan jam operasional**: 08:00 - 22:00

### 🚫 **Validasi Sistem**

- Tidak bisa booking di masa lalu
- Tidak bisa booking jam yang sudah terisi
- Tidak bisa booking di luar jam operasional
- Durasi maksimal 5 jam per booking

### 📱 **User Experience**

- Form otomatis memuat jam tersedia saat tanggal/durasi berubah
- Loading indicator saat mengambil data
- Pesan error yang jelas jika ada masalah
- Konfirmasi detail booking sebelum pembayaran