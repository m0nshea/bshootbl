# Admin Meja Form Update

## Perubahan yang Dilakukan

### 1. Tata Letak Teks Deskripsi - Rata Kanan-Kiri (Justify)
✅ **Halaman Edit Meja**:
- Textarea deskripsi sekarang menggunakan `text-align: justify`
- Line height ditingkatkan menjadi 1.6 untuk readability
- Rows ditingkatkan dari 3 menjadi 5 untuk lebih banyak ruang

✅ **Halaman Create Meja**:
- Sama seperti edit, textarea deskripsi rata kanan-kiri
- Konsisten dengan halaman edit

### 2. Field Kategori - Dari Dropdown ke Input Text
✅ **Perubahan UI**:
- Dropdown `<select>` diganti dengan `<input type="text">`
- User bisa mengetik nama kategori sendiri
- Placeholder: "Contoh: VIP, Regular, Premium"
- Help text: "Masukkan nama kategori meja"

✅ **Perubahan Backend**:
- Controller menggunakan `firstOrCreate()` untuk kategori
- Jika kategori sudah ada → gunakan yang ada
- Jika kategori baru → buat kategori baru otomatis
- Kategori baru dibuat dengan thumbnail null

### 3. File yang Dimodifikasi

#### Views:
1. `resources/views/adminMeja/edit.blade.php`
   - Ubah dropdown kategori jadi input text
   - Tambah CSS untuk textarea justify
   - Tingkatkan rows textarea dari 3 ke 5

2. `resources/views/adminMeja/create.blade.php`
   - Ubah dropdown kategori jadi input text
   - Tambah inline style untuk textarea justify
   - Tingkatkan rows textarea dari 3 ke 5

#### Controller:
1. `app/Http/Controllers/Admin/MejaController.php`
   - Update method `store()`:
     - Validasi `kategori` bukan `category_id`
     - Gunakan `Category::firstOrCreate()`
   - Update method `update()`:
     - Validasi `kategori` bukan `category_id`
     - Gunakan `Category::firstOrCreate()`

### 4. Cara Kerja Kategori Baru

#### Sebelum (Dropdown):
```php
// User harus pilih dari kategori yang sudah ada
<select name="category_id">
  <option value="1">VIP</option>
  <option value="2">Regular</option>
</select>
```

#### Sesudah (Input Text):
```php
// User bisa ketik kategori apa saja
<input type="text" name="kategori" placeholder="Contoh: VIP, Regular, Premium">
```

#### Logic Backend:
```php
// Find or create category
$category = Category::firstOrCreate(
    ['nama' => $request->kategori],  // Cari berdasarkan nama
    ['thumbnail' => null]             // Jika baru, set thumbnail null
);

// Gunakan category_id untuk meja
$meja->category_id = $category->id;
```

### 5. Validasi

✅ **Field Kategori**:
- Required (wajib diisi)
- String
- Max 255 karakter
- Tidak perlu unique (bisa sama dengan kategori lain)

✅ **Field Deskripsi**:
- Nullable (opsional)
- String
- Tidak ada batasan panjang
- Text-align: justify

### 6. CSS untuk Textarea Justify

```css
.deskripsi-textarea {
  text-align: justify;
  line-height: 1.6;
}
```

### 7. Contoh Penggunaan

#### Tambah Meja Baru:
1. Buka `/admin/meja/create`
2. Isi nama meja: "Meja VIP 1"
3. Ketik kategori: "VIP Premium" (bisa kategori baru)
4. Isi harga: 50000
5. Pilih status: Tersedia
6. Upload foto (opsional)
7. Isi deskripsi dengan teks panjang
8. Klik "Simpan Meja"
9. Sistem akan:
   - Cek apakah kategori "VIP Premium" sudah ada
   - Jika belum ada → buat kategori baru
   - Jika sudah ada → gunakan yang ada
   - Simpan meja dengan category_id yang sesuai

#### Edit Meja:
1. Buka `/admin/meja/{id}/edit`
2. Field kategori sudah terisi dengan nama kategori saat ini
3. Bisa edit kategori:
   - Ganti ke kategori yang sudah ada → gunakan yang ada
   - Ganti ke kategori baru → buat kategori baru
4. Deskripsi tampil dengan rata kanan-kiri
5. Klik "Update Meja"

### 8. Keuntungan Perubahan

✅ **Fleksibilitas**:
- Admin bisa membuat kategori baru langsung dari form meja
- Tidak perlu ke halaman kategori dulu

✅ **User Experience**:
- Lebih cepat dan praktis
- Tidak perlu switch halaman

✅ **Konsistensi Data**:
- Kategori dengan nama sama tidak akan duplikat
- `firstOrCreate()` memastikan hanya 1 kategori per nama

✅ **Readability**:
- Deskripsi rata kanan-kiri lebih enak dibaca
- Line height 1.6 memberikan spacing yang baik

### 9. Testing

#### Test Create Meja dengan Kategori Baru:
1. Buka `/admin/meja/create`
2. Isi form dengan kategori "Super VIP"
3. Submit form
4. Cek database:
   - Tabel `categories` ada entry baru "Super VIP"
   - Tabel `mejas` ada entry baru dengan category_id yang benar

#### Test Create Meja dengan Kategori Existing:
1. Buka `/admin/meja/create`
2. Isi form dengan kategori "VIP" (sudah ada)
3. Submit form
4. Cek database:
   - Tabel `categories` tidak ada entry baru
   - Tabel `mejas` menggunakan category_id yang sudah ada

#### Test Edit Meja:
1. Buka `/admin/meja/{id}/edit`
2. Cek field kategori terisi dengan benar
3. Edit kategori ke nama baru
4. Submit form
5. Cek database:
   - Kategori baru dibuat jika belum ada
   - Meja diupdate dengan category_id yang benar

#### Test Deskripsi Justify:
1. Buka form create/edit
2. Isi deskripsi dengan teks panjang (beberapa kalimat)
3. Cek tampilan textarea → teks rata kanan-kiri
4. Submit dan lihat di halaman detail → teks tetap rata kanan-kiri

### 10. Database Impact

#### Tabel Categories:
- Bisa bertambah otomatis saat admin input kategori baru
- Kolom `nama` harus unique (sudah ada di migration)
- Kolom `thumbnail` bisa null untuk kategori yang dibuat dari form meja

#### Tabel Mejas:
- Tidak ada perubahan struktur
- Tetap menggunakan `category_id` sebagai foreign key
- Relasi dengan categories tetap sama

### 11. Catatan Penting

⚠️ **Kategori Tanpa Thumbnail**:
- Kategori yang dibuat dari form meja tidak punya thumbnail
- Admin perlu ke halaman kategori untuk upload thumbnail
- Atau bisa diabaikan jika thumbnail tidak wajib

✅ **Case Sensitivity**:
- "VIP" dan "vip" dianggap berbeda
- Jika ingin case-insensitive, perlu modifikasi query

✅ **Whitespace**:
- Nama kategori di-trim otomatis oleh Laravel
- "VIP " dan "VIP" dianggap sama

## Kesimpulan

Semua perubahan sudah selesai:
✅ Teks deskripsi rata kanan-kiri (justify)
✅ Field kategori dari dropdown ke input text
✅ Auto-create kategori baru jika belum ada
✅ Konsisten antara create dan edit
✅ Textarea lebih besar (5 rows)
✅ Line height 1.6 untuk readability
