# 📊 ALUR TRANSAKSI BARU SETELAH RESET

## 🔄 Fitur Reset Data Laporan

### **Apa yang Terjadi Saat Reset?**

Ketika Anda menekan tombol **"Reset Data Laporan"** di halaman admin laporan:

1. ✅ **Semua data transaksi dihapus** dari database
2. ✅ **Laporan direset menjadi 0** (tidak ada data transaksi)
3. ✅ **Status semua meja direset** menjadi "Tersedia"
4. ✅ **Data pelanggan tetap ada** (tidak dihapus)
5. ✅ **Data meja tetap ada** (tidak dihapus)
6. ✅ **Data kategori tetap ada** (tidak dihapus)

---

## 📝 ALUR TRANSAKSI BARU

### **1. Pelanggan Melakukan Booking**

**Langkah-langkah:**
1. Pelanggan login ke sistem
2. Pilih meja yang tersedia
3. Pilih tanggal dan jam main
4. Pilih durasi bermain
5. Klik "Pesan Sekarang"

**Yang Terjadi di Sistem:**
```
- Status: pending
- Status Pembayaran: pending
- Snap Token: dibuat untuk Midtrans
- Payment Expires: 15 menit dari sekarang
```

---

### **2. Pelanggan Melakukan Pembayaran**

**Metode Pembayaran:**
- QRIS
- E-Wallet (GoPay, OVO, Dana, dll)
- Transfer Bank
- Kartu Kredit/Debit

**Yang Terjadi di Sistem:**
```
- Status Pembayaran: paid
- Paid At: timestamp pembayaran
- Transaksi masuk ke laporan
```

---

### **3. Data Masuk ke Laporan**

**Transaksi yang Masuk Laporan:**
- ✅ Hanya transaksi dengan `status_pembayaran = 'paid'`
- ✅ Transaksi pending TIDAK masuk laporan
- ✅ Transaksi cancelled TIDAK masuk laporan
- ✅ Transaksi expired TIDAK masuk laporan

**Data yang Tercatat:**
```
- Tanggal transaksi
- Nama pelanggan
- Meja yang dibooking
- Durasi bermain
- Total pembayaran
- Metode pembayaran
```

---

### **4. Laporan Terupdate Otomatis**

**Jenis Laporan yang Terupdate:**

#### **A. Laporan Pendapatan**
- Total pendapatan per periode
- Grafik tren pendapatan
- Perbandingan periode

#### **B. Laporan Transaksi**
- Jumlah transaksi per periode
- Detail setiap transaksi
- Status pembayaran

#### **C. Laporan Meja**
- Meja paling sering dibooking
- Total pendapatan per meja
- Tingkat utilisasi meja

#### **D. Laporan Pelanggan**
- Pelanggan paling aktif
- Total spending per pelanggan
- Frekuensi booking

---

## 🔄 SIKLUS TRANSAKSI LENGKAP

```
┌─────────────────────────────────────────────────────────────┐
│                    TRANSAKSI BARU                           │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  1. Pelanggan Booking Meja                                  │
│     - Pilih meja, tanggal, jam, durasi                      │
│     - Status: pending                                       │
│     - Status Pembayaran: pending                            │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  2. Sistem Generate Payment Token                          │
│     - Midtrans Snap Token dibuat                            │
│     - Payment expires: 15 menit                             │
│     - Auto cancellation job dijadwalkan                     │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
                    ┌───────┴───────┐
                    │               │
                    ▼               ▼
        ┌──────────────────┐  ┌──────────────────┐
        │  DIBAYAR         │  │  TIDAK DIBAYAR   │
        │  (dalam 15 mnt)  │  │  (> 15 menit)    │
        └──────────────────┘  └──────────────────┘
                    │               │
                    ▼               ▼
        ┌──────────────────┐  ┌──────────────────┐
        │ Status: paid     │  │ Status: expired  │
        │ Paid At: now()   │  │ Auto cancelled   │
        └──────────────────┘  └──────────────────┘
                    │               │
                    ▼               ▼
        ┌──────────────────┐  ┌──────────────────┐
        │ ✅ MASUK         │  │ ❌ TIDAK MASUK   │
        │    LAPORAN       │  │    LAPORAN       │
        └──────────────────┘  └──────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────────────────────┐
│  3. Data Tercatat di Laporan                                │
│     - Laporan Pendapatan                                    │
│     - Laporan Transaksi                                     │
│     - Laporan Meja                                          │
│     - Laporan Pelanggan                                     │
└─────────────────────────────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────────────────────┐
│  4. Admin Bisa Lihat di Dashboard & Laporan                 │
│     - Real-time update                                      │
│     - Filter by date range                                  │
│     - Export Excel/PDF                                      │
└─────────────────────────────────────────────────────────────┘
```

---

## ⚙️ AUTO CANCELLATION SYSTEM

**Jika Pelanggan Tidak Bayar dalam 15 Menit:**

1. ⏰ **Job AutoCancellationBook dijalankan**
2. 🔄 **Status Pembayaran**: pending → cancelled
3. 📧 **Notifikasi**: (opsional) email ke pelanggan
4. 🗑️ **Transaksi**: TIDAK masuk laporan

---

## 📊 CARA MELIHAT LAPORAN BARU

### **Di Dashboard Admin:**
1. Login sebagai admin
2. Buka menu "Dashboard"
3. Lihat statistik real-time:
   - Total Pendapatan
   - Transaksi Hari Ini
   - Transaksi Pending
   - Grafik Pendapatan

### **Di Halaman Laporan:**
1. Login sebagai admin
2. Buka menu "Laporan"
3. Pilih jenis laporan
4. Pilih periode (harian/mingguan/bulanan)
5. Pilih range tanggal
6. Klik "Terapkan"
7. Lihat data dalam tabel dan grafik

---

## 🔐 KEAMANAN DATA

### **Data yang TIDAK Dihapus Saat Reset:**
- ✅ Data User/Pelanggan
- ✅ Data Meja
- ✅ Data Kategori
- ✅ Data Admin

### **Data yang DIHAPUS Saat Reset:**
- ❌ Semua Transaksi
- ❌ Semua Laporan
- ❌ History Pembayaran

---

## 💡 TIPS PENGGUNAAN

### **Kapan Harus Reset Data?**
- 🔄 Awal tahun baru
- 🔄 Awal periode akuntansi baru
- 🔄 Setelah migrasi sistem
- 🔄 Testing/Development

### **Sebelum Reset:**
1. ✅ **Backup database** terlebih dahulu
2. ✅ **Export laporan** yang diperlukan
3. ✅ **Informasikan** ke tim
4. ✅ **Pastikan** tidak ada transaksi pending

### **Setelah Reset:**
1. ✅ Verifikasi semua data terhapus
2. ✅ Cek status meja (harus tersedia semua)
3. ✅ Test booking baru
4. ✅ Verifikasi laporan kosong

---

## 📞 SUPPORT

Jika ada pertanyaan atau masalah:
- 📧 Email: support@bshootbilliard.com
- 📱 WhatsApp: +62 xxx-xxxx-xxxx
- 🌐 Website: www.bshootbilliard.com

---

**Terakhir diupdate:** 8 Februari 2026
**Versi:** 1.0
