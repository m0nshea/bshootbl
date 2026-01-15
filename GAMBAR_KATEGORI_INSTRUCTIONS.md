# 📸 Instruksi Gambar Kategori Billiard

## 📁 Lokasi File
Semua gambar harus ditempatkan di: `public/img/kategori/`

## 🎯 Gambar yang Diperlukan

### 1. **8ball.webp** atau **8ball.jpg** atau **8ball.png**
- **Deskripsi**: Gambar bola billiard nomor 8 (bola hitam)
- **Ukuran**: Minimal 200x150px
- **Format**: WebP, JPG, atau PNG
- **Contoh**: Foto close-up bola billiard hitam dengan angka 8

### 2. **9ball.jpg** atau **9ball.png**
- **Deskripsi**: Gambar bola billiard nomor 9 (bola kuning bergaris)
- **Ukuran**: Minimal 200x150px  
- **Format**: JPG atau PNG
- **Contoh**: Foto bola billiard kuning dengan garis putih dan angka 9

### 3. **vip.jpg** atau **vip.png**
- **Deskripsi**: Gambar meja billiard VIP atau ruang VIP
- **Ukuran**: Minimal 200x150px
- **Format**: JPG atau PNG
- **Contoh**: Foto meja billiard mewah, ruang VIP, atau interior premium

### 4. **snooker.webp** atau **snooker.jpg** atau **snooker.png**
- **Deskripsi**: Gambar meja snooker atau bola snooker
- **Ukuran**: Minimal 200x150px
- **Format**: WebP, JPG, atau PNG
- **Contoh**: Foto meja snooker hijau dengan bola-bola warna-warni

## 🔧 Cara Menambahkan Gambar

### Opsi 1: Manual Upload
1. Siapkan gambar dengan nama file yang tepat
2. Copy file ke folder `public/img/kategori/`
3. Refresh halaman kategori

### Opsi 2: Download Gambar Sample
Anda bisa download gambar sample dari:
- **Unsplash**: https://unsplash.com/s/photos/billiard
- **Pexels**: https://www.pexels.com/search/billiard/
- **Pixabay**: https://pixabay.com/images/search/billiard/

## 📝 Contoh Struktur Folder
```
public/
└── img/
    └── kategori/
        ├── 8ball.webp     ← Gambar 8 Ball
        ├── 9ball.jpg      ← Gambar 9 Ball  
        ├── vip.jpg        ← Gambar VIP
        └── snooker.webp   ← Gambar Snooker
```

## 🎨 Tips Gambar yang Bagus
- **Resolusi tinggi** untuk tampilan yang sharp
- **Aspect ratio 4:3** atau **16:9** untuk proporsi yang baik
- **Background bersih** tanpa watermark
- **Pencahayaan yang baik** agar detail terlihat jelas
- **Format WebP** untuk ukuran file yang lebih kecil

## ⚠️ Catatan Penting
- Jika gambar tidak ditemukan, akan muncul placeholder berwarna
- Nama file harus **persis sama** dengan yang ada di kode
- Ukuran file sebaiknya **di bawah 500KB** untuk loading yang cepat
- Pastikan gambar memiliki **hak cipta yang sesuai**

## 🔄 Fallback System
Sistem sudah dilengkapi dengan fallback placeholder yang akan muncul jika:
- File gambar tidak ditemukan
- File gambar rusak atau tidak bisa dimuat
- Format file tidak didukung

Placeholder akan menampilkan nama kategori dengan warna yang berbeda untuk setiap jenis.