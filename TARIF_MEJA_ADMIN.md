# Halaman Tarif Meja Admin

## Ringkasan Fitur

Telah ditambahkan halaman **Tarif Meja** di panel admin untuk mengelola harga sewa meja billiard per jam. Halaman ini memungkinkan admin untuk melihat, mengedit, dan memperbarui tarif semua meja dengan mudah.

## Fitur Utama

### 1. **Tabel Tarif Meja**
- ✅ Daftar semua meja dengan informasi lengkap
- ✅ Foto meja, nama, kategori, lantai, status
- ✅ Input field untuk edit harga langsung di tabel
- ✅ Filter berdasarkan kategori
- ✅ Sorting dan pencarian dengan DataTables
- ✅ Responsive design untuk mobile

### 2. **Update Tarif**
- ✅ **Update Individual**: Edit harga per meja langsung di tabel
- ✅ **Update Bulk**: Simpan semua perubahan sekaligus
- ✅ **Update per Kategori**: Set harga sama untuk semua meja dalam kategori
- ✅ **Reset**: Kembalikan harga ke nilai asli
- ✅ **Validasi**: Harga minimum 0, step 1000

### 3. **User Experience**
- ✅ Visual indicator untuk perubahan (border kuning)
- ✅ Konfirmasi sebelum menyimpan
- ✅ Loading states dan feedback
- ✅ Warning jika ada perubahan belum disimpan
- ✅ SweetAlert2 untuk notifikasi

## File yang Dibuat

### Controller:
- `app/Http/Controllers/Admin/TarifController.php`

### Views:
- `resources/views/adminTarif/tarif.blade.php`

### CSS:
- `public/css/adminTarif.css`

### Routes:
- `GET /admin/tarif` - Halaman utama tarif
- `POST /admin/tarif/update-bulk` - Update multiple tarif
- `POST /admin/tarif/update-category` - Update tarif per kategori
- `GET /admin/tarif/stats` - API statistik tarif

## Navigasi

Menu **Tarif Meja** telah ditambahkan ke sidebar admin dengan:
- Icon: Badge "PRICE" berwarna warning
- Posisi: Setelah menu "Meja"
- Active state: Highlight saat di halaman tarif

## Cara Penggunaan

### 1. **Update Tarif Individual**
1. Buka halaman Tarif Meja
2. Edit harga langsung di kolom "Harga per Jam"
3. Field akan berubah warna kuning menandakan ada perubahan
4. Klik "Simpan Semua" untuk menyimpan perubahan
5. Atau klik tombol reset untuk membatalkan perubahan

### 2. **Update Tarif per Kategori**
1. Klik tombol "Update per Kategori"
2. Pilih kategori yang ingin diupdate
3. Masukkan harga baru
4. Klik "Update Tarif"
5. Semua meja dalam kategori tersebut akan diupdate

### 3. **Filter dan Pencarian**
1. Gunakan dropdown "Kategori" untuk filter
2. Gunakan search box DataTables untuk pencarian
3. Klik header kolom untuk sorting

## Keamanan

- ✅ Middleware `auth` dan `admin` untuk akses
- ✅ CSRF protection pada semua form
- ✅ Validasi input (numeric, minimum 0)
- ✅ Database transaction untuk konsistensi data
- ✅ Error handling yang komprehensif

## Responsivitas

- ✅ Mobile-friendly design
- ✅ Responsive table dengan scroll horizontal
- ✅ Adaptive layout untuk berbagai ukuran layar
- ✅ Touch-friendly buttons dan inputs

## Teknologi yang Digunakan

- **Backend**: Laravel Controller dengan validation
- **Frontend**: Bootstrap 5, DataTables, SweetAlert2
- **Database**: MySQL dengan Eloquent ORM
- **CSS**: Custom styling dengan gradients dan animations
- **JavaScript**: jQuery untuk interaktivity

## API Endpoints

### GET /admin/tarif
Menampilkan halaman utama tarif meja

### POST /admin/tarif/update-bulk
Update multiple tarif sekaligus
```json
{
  "tarif": {
    "1": 50000,
    "2": 75000,
    "3": 100000
  }
}
```

### POST /admin/tarif/update-category
Update tarif berdasarkan kategori
```json
{
  "category_id": 1,
  "harga": 60000
}
```

### GET /admin/tarif/stats
Mendapatkan statistik tarif (untuk future development)

## Testing

### Test Cases yang Harus Dijalankan:

1. **Akses Halaman:**
   - Admin dapat mengakses `/admin/tarif`
   - Non-admin tidak dapat mengakses
   - Halaman load dengan data yang benar

2. **Update Individual:**
   - Edit harga di input field
   - Visual indicator muncul
   - Simpan berhasil
   - Reset berfungsi

3. **Update Kategori:**
   - Modal terbuka dengan benar
   - Validasi form berfungsi
   - Update berhasil untuk semua meja dalam kategori

4. **Filter dan Search:**
   - Filter kategori berfungsi
   - Search DataTables berfungsi
   - Sorting berfungsi

5. **Responsivitas:**
   - Tampilan mobile responsive
   - Touch interaction berfungsi

## Catatan Implementasi

- Menggunakan pola yang konsisten dengan halaman admin lainnya
- CSS mengikuti design system yang ada
- JavaScript modular dan reusable
- Error handling yang user-friendly
- Performance optimized dengan lazy loading

## Future Enhancements

Fitur yang bisa ditambahkan di masa depan:
- History perubahan tarif
- Bulk import/export tarif
- Tarif berdasarkan waktu (peak hours)
- Diskon dan promosi
- Approval workflow untuk perubahan tarif
- Analytics dan reporting tarif