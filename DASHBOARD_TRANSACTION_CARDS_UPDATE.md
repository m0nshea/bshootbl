# Update Card Transaksi Dashboard Admin

## Ringkasan Perubahan

Dashboard admin telah diperbarui untuk memisahkan transaksi berdasarkan status pembayaran. Sekarang card "Total Transaksi" hanya menghitung transaksi yang sudah dibayar, dan ditambahkan card terpisah untuk transaksi pending.

## Perubahan Utama

### 1. **Card "Total Transaksi" → "Transaksi Berhasil"**
- ✅ **Sebelum**: Menghitung semua transaksi (termasuk pending)
- ✅ **Sesudah**: Hanya menghitung transaksi dengan `status_pembayaran = 'paid'`
- ✅ **Icon**: Berubah dari receipt menjadi check-circle
- ✅ **Warna**: Tetap biru (primary)

### 2. **Card Baru: "Menunggu Pembayaran"**
- ✅ **Fungsi**: Menghitung transaksi dengan `status_pembayaran = 'pending'`
- ✅ **Icon**: Clock (fas fa-clock)
- ✅ **Warna**: Kuning (warning)
- ✅ **Data**: Total pending + pending hari ini

### 3. **Layout Cards Diperbarui**
- ✅ **Dari**: 4 cards dalam 1 row (col-lg-3)
- ✅ **Ke**: 5 cards dalam 1 row (col-lg-2)
- ✅ **Responsive**: Adaptif untuk semua ukuran layar
- ✅ **Card tambahan**: Row kedua dengan 4 cards statistik detail

## Struktur Card Baru

### **Row 1 - Main Statistics (5 Cards)**
1. **Transaksi Berhasil** (Primary/Biru)
   - Total transaksi paid
   - Transaksi paid hari ini

2. **Menunggu Pembayaran** (Warning/Kuning)
   - Total transaksi pending
   - Transaksi pending hari ini

3. **Total Penghasilan** (Success/Hijau)
   - Total revenue dari transaksi paid
   - Revenue hari ini

4. **Rata-rata per Hari** (Info/Biru Muda)
   - Rata-rata penghasilan 10 hari terakhir
   - Hanya dari transaksi paid

5. **Meja Terfavorit** (Secondary/Abu-abu)
   - Meja dengan booking terbanyak
   - Jumlah booking

### **Row 2 - Detail Statistics (4 Cards)**
1. **Meja Tersedia** - Jumlah meja available/total
2. **Sedang Berlangsung** - Transaksi dengan status ongoing
3. **Total Pelanggan** - Jumlah user dengan role customer
4. **Transaksi Gagal** - Transaksi failed/cancelled

## File yang Dimodifikasi

### 1. **Controller**
- `app/Http/Controllers/Admin/DashboardController.php`
  - Update logic statistik untuk memisahkan paid dan pending
  - Tambah statistik transaksi_pending dan transaksi_pending_hari_ini
  - Tambah statistik transaksi_failed
  - Optimasi query menggunakan scope

### 2. **Model**
- `app/Models/Transaksi.php`
  - Tambah scope `paid()`, `pending()`, `today()`, `thisMonth()`, `failed()`
  - Tambah attribute `status_pembayaran_badge` dan `status_pembayaran_text`
  - Clean up duplicate methods

### 3. **View**
- `resources/views/adminDashboard/DashboardAdm.blade.php`
  - Restructure layout menjadi 5 cards di row pertama
  - Tambah row kedua dengan 4 cards detail
  - Update styling untuk responsive design
  - Tambah CSS untuk border-left cards

## Logic Perubahan

### **Sebelum:**
```php
'total_transaksi' => Transaksi::count(), // Semua transaksi
'transaksi_hari_ini' => Transaksi::whereDate('created_at', today())->count(), // Semua transaksi hari ini
```

### **Sesudah:**
```php
'total_transaksi' => Transaksi::paid()->count(), // Hanya transaksi paid
'transaksi_hari_ini' => Transaksi::paid()->today()->count(), // Hanya transaksi paid hari ini
'transaksi_pending' => Transaksi::pending()->count(), // Transaksi pending
'transaksi_pending_hari_ini' => Transaksi::pending()->today()->count(), // Pending hari ini
```

## Scope Baru di Model Transaksi

```php
// Transaksi yang sudah dibayar
public function scopePaid($query) {
    return $query->where('status_pembayaran', 'paid');
}

// Transaksi pending
public function scopePending($query) {
    return $query->where('status_pembayaran', 'pending');
}

// Transaksi hari ini
public function scopeToday($query) {
    return $query->whereDate('created_at', today());
}

// Transaksi bulan ini
public function scopeThisMonth($query) {
    return $query->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year);
}

// Transaksi gagal/dibatalkan
public function scopeFailed($query) {
    return $query->whereIn('status_pembayaran', ['failed', 'cancelled']);
}
```

## Responsive Design

### **Desktop (≥1200px)**: 5 cards per row (col-lg-2)
### **Tablet (992px-1199px)**: 3 cards per row (col-md-4)
### **Mobile Large (768px-991px)**: 2 cards per row (col-sm-6)
### **Mobile Small (<768px)**: 1 card per row (col-12)

## CSS Enhancements

### **Gradient Backgrounds:**
- Primary: Blue gradient
- Success: Green gradient  
- Warning: Yellow gradient
- Info: Cyan gradient
- Secondary: Gray gradient

### **Border-left Cards:**
- Subtle left border untuk secondary statistics
- Color-coded borders matching content type

### **Typography:**
- Smaller font sizes untuk 5-card layout
- Consistent spacing dan padding
- Responsive text sizing

## Manfaat Perubahan

### 1. **Clarity**
- Pemisahan jelas antara transaksi berhasil dan pending
- Admin dapat melihat berapa transaksi yang masih menunggu pembayaran

### 2. **Accuracy**
- Total transaksi dan penghasilan hanya dari transaksi yang benar-benar berhasil
- Data lebih akurat untuk analisis bisnis

### 3. **Monitoring**
- Mudah memantau transaksi pending yang perlu difollow up
- Statistik yang lebih komprehensif

### 4. **User Experience**
- Layout yang lebih informatif
- Visual yang lebih organized
- Responsive design yang baik

## Testing

### Test Cases:
1. **Card Transaksi Berhasil**: Hanya menghitung status_pembayaran = 'paid'
2. **Card Menunggu Pembayaran**: Hanya menghitung status_pembayaran = 'pending'
3. **Total Penghasilan**: Hanya dari transaksi paid
4. **Responsive Layout**: Cards menyesuaikan dengan ukuran layar
5. **Data Accuracy**: Angka sesuai dengan query database

Dashboard admin sekarang memberikan insight yang lebih jelas tentang status transaksi dan memisahkan transaksi berhasil dari yang masih pending pembayaran.