# Category Management System Guide

## Overview
Sistem manajemen kategori telah dibuat dengan fitur CRUD lengkap (Create, Read, Update, Delete) untuk admin. Sistem ini memungkinkan admin untuk mengelola kategori permainan billiard dengan upload thumbnail.

## Features Implemented

### 1. **Database Structure**
- **Table**: `categories`
- **Columns**:
  - `id`: Primary key (auto increment)
  - `nama`: Nama kategori (string, required, unique)
  - `thumbnail`: Nama file thumbnail (nullable)
  - `created_at`, `updated_at`: Timestamps

### 2. **Model Category**
- **Fillable fields**: `nama`, `thumbnail`
- **Accessor**: `getThumbnailUrlAttribute()` untuk URL thumbnail
- **Default image**: Jika tidak ada thumbnail, gunakan default image

### 3. **Controller Features**
- **CategoryController** dengan resource methods:
  - `index()`: Menampilkan daftar kategori dengan pagination
  - `create()`: Form tambah kategori
  - `store()`: Simpan kategori baru dengan validasi
  - `edit()`: Form edit kategori
  - `update()`: Update kategori dengan validasi
  - `destroy()`: Hapus kategori (AJAX)

### 4. **File Upload System**
- **Storage**: `storage/app/public/categories/`
- **Allowed formats**: JPEG, PNG, JPG, WEBP
- **Max size**: 2MB
- **Naming**: `timestamp_slug.extension`
- **Auto directory creation**: Jika folder tidak ada
- **File cleanup**: Hapus file lama saat update/delete

### 5. **Validation Rules**
- **Nama kategori**: Required, string, max 255 chars, unique
- **Thumbnail**: Required (create), optional (update), image, max 2MB

### 6. **Frontend Features**
- **Responsive table**: Dengan pagination
- **Image preview**: Saat upload dan edit
- **SweetAlert2**: Untuk konfirmasi dan notifikasi
- **AJAX delete**: Tanpa reload halaman
- **Error handling**: Tampilkan pesan error yang user-friendly

## Routes

### Resource Routes (Protected by admin middleware)
```php
Route::resource('kategori', CategoryController::class);
```

**Generated routes:**
- `GET /admin/kategori` → index (admin.kategori.index)
- `GET /admin/kategori/create` → create (admin.kategori.create)
- `POST /admin/kategori` → store (admin.kategori.store)
- `GET /admin/kategori/{id}/edit` → edit (admin.kategori.edit)
- `PUT /admin/kategori/{id}` → update (admin.kategori.update)
- `DELETE /admin/kategori/{id}` → destroy (admin.kategori.destroy)

## How to Test

### 1. **Access Admin Panel**
1. Login sebagai admin: `admin@bshoot.com` / `admin123`
2. Buka: `http://127.0.0.1:8000/admin/kategori`

### 2. **Test Create Category**
1. Klik "Tambah Kategori"
2. Isi nama kategori (contoh: "Pool 8 Ball")
3. Upload thumbnail (max 2MB, format: jpg/png/webp)
4. Klik "Simpan"
5. Akan redirect ke daftar kategori dengan pesan sukses

### 3. **Test Edit Category**
1. Klik tombol "Edit" pada kategori yang ingin diubah
2. Ubah nama atau ganti thumbnail
3. Klik "Update"
4. Akan redirect dengan pesan sukses

### 4. **Test Delete Category**
1. Klik tombol "Hapus" pada kategori
2. Konfirmasi dengan SweetAlert
3. Kategori akan terhapus dengan AJAX
4. File thumbnail juga akan terhapus dari storage

### 5. **Test Validation**
- **Nama kosong**: Error "Nama kategori harus diisi"
- **Nama duplikat**: Error "Nama kategori sudah ada"
- **File bukan gambar**: Error "File harus berupa gambar"
- **File terlalu besar**: Error "Ukuran gambar maksimal 2MB"

## File Structure

```
app/
├── Http/Controllers/Admin/
│   └── CategoryController.php
├── Models/
│   └── Category.php
database/
├── migrations/
│   └── 2026_01_03_151457_create_categories_table.php
├── seeders/
│   ├── CategorySeeder.php
│   └── DatabaseSeeder.php
resources/views/adminKategori/
├── kategori.blade.php (index)
├── create.blade.php
└── edit.blade.php
storage/app/public/
└── categories/ (upload folder)
```

## Sample Data
Seeder telah dibuat dengan data awal:
- 8 Ball
- 9 Ball  
- Meja VIP
- Snooker

## Error Handling

### 1. **Validation Errors**
- Ditampilkan di form dengan class `is-invalid`
- Pesan error dalam bahasa Indonesia

### 2. **File Upload Errors**
- Cek format file
- Cek ukuran file
- Handle storage errors

### 3. **Database Errors**
- Try-catch untuk semua operasi database
- Pesan error yang user-friendly

## Security Features

### 1. **Authentication & Authorization**
- Hanya admin yang bisa akses
- Middleware `auth` dan `admin`

### 2. **CSRF Protection**
- Token CSRF di semua form
- AJAX requests dengan CSRF token

### 3. **File Upload Security**
- Validasi tipe file
- Validasi ukuran file
- Storage di folder yang aman

### 4. **Input Validation**
- Server-side validation
- Sanitasi input

## Performance Optimization

### 1. **Database**
- Pagination untuk daftar kategori
- Index pada kolom yang sering dicari

### 2. **File Storage**
- Optimized file naming
- Automatic cleanup old files

### 3. **Frontend**
- Image preview tanpa upload
- AJAX delete tanpa reload
- Loading states untuk UX

## URLs untuk Testing
- **Admin Login**: `http://127.0.0.1:8000/login`
- **Category List**: `http://127.0.0.1:8000/admin/kategori`
- **Add Category**: `http://127.0.0.1:8000/admin/kategori/create`
- **Edit Category**: `http://127.0.0.1:8000/admin/kategori/{id}/edit`

## Next Steps
Sistem kategori sudah lengkap dan siap digunakan. Selanjutnya bisa:
1. Menambah fitur search/filter
2. Bulk operations (delete multiple)
3. Category sorting/ordering
4. Integration dengan sistem meja