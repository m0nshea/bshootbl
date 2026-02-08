# 🔄 CARA RESET DATA TRANSAKSI

## ✅ Data Sudah Direset!

**Status saat ini:**
- ✅ Semua transaksi: **DIHAPUS** (0 transaksi)
- ✅ Status meja: **DIRESET** (semua tersedia)
- ✅ Laporan: **KOSONG** (data = 0)

---

## 📝 Cara Reset Data di Masa Depan

### **Metode 1: Menggunakan Artisan Command (RECOMMENDED)**

```bash
# Dengan konfirmasi
php artisan transaksi:reset

# Tanpa konfirmasi (force)
php artisan transaksi:reset --force
```

**Kelebihan:**
- ✅ Ada konfirmasi sebelum reset
- ✅ Tampilan yang jelas dan informatif
- ✅ Error handling yang baik
- ✅ Bisa dijalankan dari terminal

---

### **Metode 2: Menggunakan Tinker**

```bash
php artisan tinker --execute="DB::table('transaksis')->truncate(); DB::table('mejas')->update(['status' => 'available']); echo 'Reset berhasil';"
```

**Kelebihan:**
- ✅ Cepat dan langsung
- ✅ Tidak perlu konfirmasi

**Kekurangan:**
- ❌ Tidak ada konfirmasi
- ❌ Bisa berbahaya jika salah ketik

---

### **Metode 3: Langsung dari Database (phpMyAdmin/MySQL)**

```sql
-- Hapus semua transaksi
TRUNCATE TABLE transaksis;

-- Reset status meja
UPDATE mejas SET status = 'available';
```

**Kelebihan:**
- ✅ Kontrol penuh
- ✅ Bisa lihat data sebelum dihapus

**Kekurangan:**
- ❌ Harus akses database langsung
- ❌ Lebih ribet

---

## 🎯 Alur Transaksi Baru Setelah Reset

```
1. Pelanggan booking meja
   ↓
2. Status: pending, Status Pembayaran: pending
   ↓
3. Pelanggan bayar (dalam 15 menit)
   ↓
4. Status Pembayaran: paid
   ↓
5. ✅ MASUK LAPORAN
   ↓
6. Tampil di Dashboard & Laporan Admin
```

---

## ⚠️ PENTING!

### **Sebelum Reset:**
1. ✅ Backup database
2. ✅ Export laporan yang diperlukan
3. ✅ Pastikan tidak ada transaksi pending penting

### **Yang DIHAPUS:**
- ❌ Semua transaksi
- ❌ Semua laporan
- ❌ History pembayaran

### **Yang TETAP ADA:**
- ✅ Data User/Pelanggan
- ✅ Data Meja
- ✅ Data Kategori
- ✅ Data Admin

---

## 📊 Verifikasi Setelah Reset

Cek apakah reset berhasil:

```bash
# Cek jumlah transaksi (harus 0)
php artisan tinker --execute="echo 'Total transaksi: ' . DB::table('transaksis')->count();"

# Cek status meja (harus semua available)
php artisan tinker --execute="echo 'Meja tersedia: ' . DB::table('mejas')->where('status', 'available')->count();"
```

---

## 🔐 Keamanan

**Command reset hanya bisa dijalankan oleh:**
- Admin dengan akses terminal/SSH
- Developer dengan akses ke server
- User dengan akses database

**Tidak ada tombol reset di UI** untuk mencegah reset tidak sengaja.

---

## 📞 Bantuan

Jika ada masalah saat reset:
1. Cek error message
2. Pastikan database connection aktif
3. Cek permission database user
4. Hubungi developer jika perlu

---

**Terakhir direset:** 8 Februari 2026, 17:03 WIB
**Total transaksi dihapus:** Semua data lama
**Status:** ✅ Siap untuk transaksi baru
