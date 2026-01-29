# Auto Cancellation System

## 🎯 **Overview**
Sistem otomatis untuk membatalkan booking yang tidak dibayar dalam waktu yang ditentukan (15 menit).

## 🔧 **How It Works**

### **1. Payment Token Creation**
Ketika payment token dibuat di `PaymentService::createPaymentToken()`:
```php
// Set expiry time
'payment_expires_at' => now()->addMinutes(15)

// Schedule auto cancellation job
\App\Jobs\AutoCancellationBook::dispatch($transaksi->id)
    ->delay(now()->addMinutes(15));
```

### **2. Auto Cancellation Job**
Job `AutoCancellationBook` akan dijalankan setelah 15 menit:

**Kondisi yang dicek:**
- ✅ Transaksi masih ada di database
- ✅ Status pembayaran masih `pending`
- ✅ Waktu sudah melewati `payment_expires_at`

**Aksi yang dilakukan:**
- 🔄 Update `status_pembayaran` menjadi `expired`
- 🔄 Update `status_booking` menjadi `cancelled`
- 🔄 Cancel transaksi di Midtrans (optional)
- 📝 Log aktivitas cancellation

## 📊 **Status Flow**

### **Normal Flow:**
```
pending → paid (user bayar dalam 15 menit)
```

### **Auto Cancellation Flow:**
```
pending → expired (setelah 15 menit tidak dibayar)
```

## 🛠 **Implementation Details**

### **PaymentService Changes:**
```php
// Dispatch job saat create token
\App\Jobs\AutoCancellationBook::dispatch($transaksi->id)
    ->delay(now()->addMinutes(15));

// Dispatch job saat reuse existing token
if ($transaksi->payment_expires_at > now()) {
    $delayMinutes = now()->diffInMinutes($transaksi->payment_expires_at);
    \App\Jobs\AutoCancellationBook::dispatch($transaksi->id)
        ->delay(now()->addMinutes($delayMinutes));
}
```

### **AutoCancellationBook Job:**
```php
public function handle(): void
{
    $transaksi = Transaksi::find($this->transaksiId);
    
    // Check if still pending and expired
    if ($transaksi->status_pembayaran === 'pending' && 
        $transaksi->payment_expires_at <= now()) {
        
        // Cancel the booking
        $transaksi->update([
            'status_pembayaran' => 'expired',
            'status_booking' => 'cancelled'
        ]);
        
        // Cancel in Midtrans
        \Midtrans\Transaction::cancel($transaksi->midtrans_order_id);
    }
}
```

## 🔍 **Monitoring & Logging**

### **Log Events:**
- ✅ `AutoCancellationBook: Transaction auto-cancelled` - Booking berhasil dibatalkan
- ⚠️ `AutoCancellationBook: Transaction already processed` - Sudah dibayar/dibatalkan
- ❌ `AutoCancellationBook: Job execution failed` - Error saat eksekusi

### **Database Status:**
```sql
-- Cek booking yang expired
SELECT * FROM transaksis 
WHERE status_pembayaran = 'expired' 
AND status_booking = 'cancelled';

-- Cek booking yang pending tapi sudah expired
SELECT * FROM transaksis 
WHERE status_pembayaran = 'pending' 
AND payment_expires_at < NOW();
```

## ⚙️ **Configuration**

### **Expiry Time:**
Default: 15 menit (dapat diubah di `PaymentService`)
```php
'payment_expires_at' => now()->addMinutes(15) // Ubah angka ini
```

### **Queue Configuration:**
Pastikan queue worker berjalan:
```bash
php artisan queue:work
```

## 🚀 **Benefits**

1. **Automatic Cleanup**: Booking expired otomatis dibersihkan
2. **Slot Liberation**: Slot waktu yang tidak dibayar kembali tersedia
3. **User Experience**: User tidak perlu manual cancel
4. **System Integrity**: Mencegah slot terkunci selamanya
5. **Midtrans Sync**: Sinkronisasi dengan payment gateway

## 🔧 **Testing**

### **Manual Test:**
1. Buat booking baru
2. Jangan bayar dalam 15 menit
3. Cek status setelah 15 menit
4. Status harus berubah menjadi `expired`/`cancelled`

### **Queue Test:**
```bash
# Jalankan queue worker
php artisan queue:work

# Cek failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all
```

## 📝 **Notes**

- Job menggunakan Laravel Queue system
- Memerlukan queue worker yang berjalan
- Logging detail untuk monitoring
- Graceful error handling
- Midtrans integration untuk cancel payment