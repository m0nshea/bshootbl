<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_telepon',
        'alamat',
        'tanggal_lahir',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is customer
     */
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    /**
     * Get list of admin emails
     */
    public static function getAdminEmails(): array
    {
        return [
            'admin@bshoot.com',
            'admin@bshootbilliard.com',
            'superadmin@bshoot.com',
            'owner@bshoot.com',
            'gnovfitriana@gmail.com'
        ];
    }

    /**
     * Check if email is admin email
     */
    public static function isAdminEmail(string $email): bool
    {
        return in_array(strtolower($email), array_map('strtolower', self::getAdminEmails()));
    }

    /**
     * Get user's transactions
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    /**
     * Get user's total spent amount
     */
    public function getTotalSpentAttribute()
    {
        return $this->transaksis()->where('status_pembayaran', 'paid')->sum('total_harga');
    }

    /**
     * Get formatted total spent
     */
    public function getFormattedTotalSpentAttribute()
    {
        return 'Rp ' . number_format($this->total_spent, 0, ',', '.');
    }

    /**
     * Get user status badge class
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status ?? 'active') {
            'active' => 'bg-success',
            'inactive' => 'bg-secondary',
            default => 'bg-success'
        };
    }

    /**
     * Get user status text
     */
    public function getStatusTextAttribute()
    {
        return match($this->status ?? 'active') {
            'active' => 'Aktif',
            'inactive' => 'Nonaktif',
            default => 'Aktif'
        };
    }

    /**
     * Get role badge class
     */
    public function getRoleBadgeAttribute()
    {
        return match($this->role) {
            'admin' => 'bg-danger',
            'customer' => 'bg-primary',
            default => 'bg-secondary'
        };
    }

    /**
     * Get role text
     */
    public function getRoleTextAttribute()
    {
        return match($this->role) {
            'admin' => 'Admin',
            'customer' => 'Customer',
            default => 'Unknown'
        };
    }

    /**
     * Get formatted registration date
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    /**
     * Scope for customers only
     */
    public function scopeCustomers($query)
    {
        return $query->where('role', 'customer');
    }

    /**
     * Scope for admins only
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope for active users
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for users with transactions
     */
    public function scopeWithTransactions($query)
    {
        return $query->has('transaksis');
    }
}
