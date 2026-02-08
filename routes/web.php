<?php

use Illuminate\Support\Facades\Route;

// Include auth routes first
require __DIR__.'/auth.php';

// Debug route (temporary)
Route::get('/debug-user', function () {
    $user = \App\Models\User::where('email', 'admin@bshoot.com')->first();
    if ($user) {
        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'isAdmin' => $user->isAdmin(),
            'adminEmails' => \App\Models\User::getAdminEmails(),
            'isAdminEmail' => \App\Models\User::isAdminEmail($user->email)
        ]);
    }
    return response()->json(['error' => 'User not found']);
});

// Debug current user
Route::get('/debug-current-user', function () {
    if (auth()->check()) {
        $user = auth()->user();
        return response()->json([
            'authenticated' => true,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'isAdmin' => $user->isAdmin()
        ]);
    }
    return response()->json(['authenticated' => false]);
});

// Create admin user - gnovfitriana@gmail.com
Route::get('/create-admin-gnov', function () {
    try {
        // Delete existing user if exists
        \App\Models\User::where('email', 'gnovfitriana@gmail.com')->delete();
        
        // Create new admin user
        $user = \App\Models\User::create([
            'name' => 'Gnov Fitriana',
            'email' => 'gnovfitriana@gmail.com',
            'password' => \Hash::make('12345'),
            'role' => 'admin',
            'status' => 'active'
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Admin user created successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'isAdmin' => $user->isAdmin(),
                'login_url' => route('login')
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error creating admin user: ' . $e->getMessage()
        ]);
    }
});

// Simple admin dashboard test
Route::get('/admin-test', function () {
    return '<h1>Admin Test Page</h1><p>If you can see this, the route works!</p>';
})->middleware(['auth', 'admin']);

// Debug all users
Route::get('/debug-all-users', function () {
    $users = \App\Models\User::all();
    return response()->json($users->map(function($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'isAdmin' => $user->isAdmin()
        ];
    }));
});

// Debug categories
Route::get('/debug-categories', function () {
    $categories = \App\Models\Category::all();
    return response()->json($categories->map(function($category) {
        return [
            'id' => $category->id,
            'nama' => $category->nama,
            'thumbnail' => $category->thumbnail,
            'edit_url' => route('admin.kategori.edit', $category->id)
        ];
    }));
});

// HOME ROUTE - SHOW HOMEPAGE
Route::get('/', function () {
    return view('home.homepage');
})->name('home');

// Authentication Routes - OVERRIDE DEFAULT LARAVEL AUTH VIEWS
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Customer Routes
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', function () {
        return view('customer.dashboard');
    })->name('dashboard');
    
    Route::get('/booking', function () {
        return view('customer.booking');
    })->name('booking');
    
    Route::get('/history', function () {
        return view('customer.history');
    })->name('history');
    
    Route::get('/payment', function () {
        return view('customer.payment');
    })->name('payment');
    
    Route::get('/profile', function () {
        return view('customer.profile');
    })->name('profile');
    
    Route::get('/settings', function () {
        return view('customer.settings');
    })->name('settings');
});

// Admin Routes - Protected by admin middleware
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Simple dashboard test
    Route::get('/dashboard-simple', function () {
        return '<h1>Admin Dashboard</h1><p>Welcome to admin panel!</p><a href="/admin/kategori">Go to Categories</a>';
    });
    
    // Dashboard with simple view
    Route::get('/dashboard-view', function () {
        return view('adminDashboard.simple');
    });
    
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Simple debug route
    Route::get('/debug', function () {
        return response()->json([
            'user' => auth()->user(),
            'is_admin' => auth()->user() ? auth()->user()->isAdmin() : false,
            'categories_count' => \App\Models\Category::count()
        ]);
    });
    
    // Simple kategori route for testing
    Route::get('/kategori-test', function () {
        try {
            $categories = \App\Models\Category::latest()->paginate(10);
            return view('adminKategori.test', compact('categories'));
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage() . " in " . $e->getFile() . " line " . $e->getLine();
        }
    });
    
    Route::get('/kategori-simple', function () {
        try {
            $categories = \App\Models\Category::latest()->paginate(10);
            return view('adminKategori.kategori', compact('categories'));
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage() . " in " . $e->getFile() . " line " . $e->getLine();
        }
    });
    
    // Simple edit test
    Route::get('/kategori-edit-simple/{id}', function ($id) {
        try {
            $category = \App\Models\Category::findOrFail($id);
            return view('adminKategori.edit-simple', compact('category'));
        } catch (\Exception $e) {
            return "Edit Error: " . $e->getMessage() . " in " . $e->getFile() . " line " . $e->getLine();
        }
    });
    
    // Debug edit route
    Route::get('/kategori-edit-test/{id}', function ($id) {
        try {
            $category = \App\Models\Category::findOrFail($id);
            return response()->json([
                'success' => true,
                'category' => $category,
                'edit_url' => route('admin.kategori.edit', $category->id)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    });
    
    // Category routes
    Route::get('/kategori/{id}/price', [\App\Http\Controllers\Admin\CategoryController::class, 'getPrice'])->name('kategori.price');
    Route::resource('kategori', \App\Http\Controllers\Admin\CategoryController::class);
    
    // Meja routes
    Route::resource('meja', \App\Http\Controllers\Admin\MejaController::class);
    
    // Transaksi routes
    Route::resource('transaksi', \App\Http\Controllers\Admin\TransaksiController::class)->only(['index', 'show']);
    Route::post('/transaksi/{transaksi}/update-status', [\App\Http\Controllers\Admin\TransaksiController::class, 'updateStatus'])->name('transaksi.update-status');
    Route::post('/transaksi/{transaksi}/checkin', [\App\Http\Controllers\Admin\TransaksiController::class, 'checkin'])->name('transaksi.checkin');
    Route::post('/transaksi/{transaksi}/checkout', [\App\Http\Controllers\Admin\TransaksiController::class, 'checkout'])->name('transaksi.checkout');
    Route::post('/transaksi/{transaksi}/cancel', [\App\Http\Controllers\Admin\TransaksiController::class, 'cancel'])->name('transaksi.cancel');
    Route::get('/stats', [\App\Http\Controllers\Admin\TransaksiController::class, 'getStats'])->name('stats');
    
    // Pengguna routes
    Route::resource('pengguna', \App\Http\Controllers\Admin\PenggunaController::class);
    Route::post('/pengguna/{pengguna}/toggle-status', [\App\Http\Controllers\Admin\PenggunaController::class, 'toggleStatus'])->name('pengguna.toggle-status');
    Route::get('/pengguna-stats', [\App\Http\Controllers\Admin\PenggunaController::class, 'getStats'])->name('pengguna.stats');
    Route::get('/pengguna-export', [\App\Http\Controllers\Admin\PenggunaController::class, 'export'])->name('pengguna.export');
    
    // Alias route for backward compatibility
    Route::get('/kategori-alias', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('kategori');
    
    Route::get('/transaksi', [\App\Http\Controllers\Admin\TransaksiController::class, 'index'])->name('transaksi');
    
    Route::get('/transaksi/{id}/detail', [\App\Http\Controllers\Admin\TransaksiController::class, 'show'])->name('transaksi.detail');
    
    Route::get('/pengguna', [\App\Http\Controllers\Admin\PenggunaController::class, 'index'])->name('pengguna');
    
    Route::get('/pengguna/create', [\App\Http\Controllers\Admin\PenggunaController::class, 'create'])->name('pengguna.create');
    
    Route::get('/pengguna/{id}/edit', [\App\Http\Controllers\Admin\PenggunaController::class, 'edit'])->name('pengguna.edit');
    
    Route::get('/laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan');
    Route::post('/laporan/reset', [\App\Http\Controllers\Admin\LaporanController::class, 'resetData'])->name('laporan.reset');
    Route::get('/laporan/data', [\App\Http\Controllers\Admin\LaporanController::class, 'getData'])->name('laporan.data');
});

// Customer Routes (Pelanggan) - Some routes protected by auth middleware
Route::prefix('pelanggan')->name('customer.')->group(function () {
    // Public routes (accessible without login)
    Route::get('/beranda', function () {
        return view('pelanggan.beranda');
    })->name('beranda');
    
    // Use controller for kategori
    Route::get('/kategori', [\App\Http\Controllers\Customer\CategoryController::class, 'index'])->name('kategori');
    Route::get('/kategori/{id}', [\App\Http\Controllers\Customer\CategoryController::class, 'show'])->name('kategori.show');
    
    // Use controller for meja
    Route::get('/meja', [\App\Http\Controllers\Customer\MejaController::class, 'index'])->name('meja');
    Route::get('/meja/{id}/detail', [\App\Http\Controllers\Customer\MejaController::class, 'show'])->name('meja.detail');
    Route::get('/meja/{id}/available-times', [\App\Http\Controllers\Customer\BookingController::class, 'getAvailableTimes'])->name('meja.available-times');
    Route::get('/meja/{id}/available-dates', [\App\Http\Controllers\Customer\BookingController::class, 'getAvailableDates'])->name('meja.available-dates');
    Route::get('/meja/{id}/test-overlap', [\App\Http\Controllers\Customer\BookingController::class, 'testOverlap'])->name('meja.test-overlap');
    Route::get('/meja/{id}/debug-timeslot', [\App\Http\Controllers\Customer\BookingController::class, 'debugTimeSlot'])->name('meja.debug-timeslot');
    Route::get('/debug-table-structure', [\App\Http\Controllers\Customer\BookingController::class, 'debugTableStructure'])->name('debug.table-structure');
    Route::post('/meja/{id}/check-time-slot', [\App\Http\Controllers\Customer\BookingController::class, 'checkTimeSlotAvailability'])->name('meja.check-time-slot');
    
    // Backward compatibility route for meja by type
    Route::get('/meja/{type}/detail-type', [\App\Http\Controllers\Customer\MejaController::class, 'showByType'])->name('meja.detail.type');
    
    // Protected routes (require login)
    Route::middleware('auth')->group(function () {
        // Booking routes
        Route::get('/checkout', [\App\Http\Controllers\Customer\BookingController::class, 'checkout'])->name('checkout');
        Route::post('/booking/process', [\App\Http\Controllers\Customer\BookingController::class, 'processBooking'])->name('booking.process');
        
        // Payment routes
        Route::get('/payment/{transaksi}', [\App\Http\Controllers\Customer\BookingController::class, 'paymentPage'])->name('payment.page');
        Route::get('/payment/{transaksi}/finish', [\App\Http\Controllers\Customer\BookingController::class, 'paymentFinish'])->name('payment.finish');
        Route::post('/payment/{transaksi}/cancel', [\App\Http\Controllers\Customer\BookingController::class, 'cancelPayment'])->name('payment.cancel');
        
        // Legacy payment routes (for backward compatibility)
        Route::get('/pembayaran/{transaksi}', [\App\Http\Controllers\Customer\BookingController::class, 'pembayaran'])->name('pembayaran');
        Route::get('/qris/{transaksi?}', [\App\Http\Controllers\Customer\BookingController::class, 'qris'])->name('qris');
        Route::post('/payment/confirm/{transaksi}', [\App\Http\Controllers\Customer\BookingController::class, 'confirmPayment'])->name('payment.confirm');
        
        // Debug route for booking process
        Route::get('/booking/debug', function() {
            return response()->json([
                'user' => Auth::user(),
                'mejas' => \App\Models\Meja::count(),
                'transaksis' => \App\Models\Transaksi::count(),
                'carbon_test' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ]);
        })->name('booking.debug');
        
        // Test route for booking process
        Route::post('/booking/test', function(Request $request) {
            return response()->json([
                'message' => 'POST request received',
                'data' => $request->all(),
                'user' => Auth::user()
            ]);
        })->name('booking.test');
        
        // Temporary direct route for riwayat
        Route::get('/riwayat', function() {
            try {
                if (!Auth::check()) {
                    return redirect()->route('login');
                }
                
                $transaksis = \App\Models\Transaksi::where('user_id', Auth::id())
                                                  ->orderBy('created_at', 'desc')
                                                  ->paginate(10);
                
                return view('pelangganRiwayat.riwayat', compact('transaksis'));
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ], 500);
            }
        })->name('riwayat');
        
        Route::get('/riwayat/{id}', function($id) {
            try {
                if (!Auth::check()) {
                    return redirect()->route('login');
                }
                
                $transaksi = \App\Models\Transaksi::where('user_id', Auth::id())
                                                 ->findOrFail($id);
                
                return view('pelangganRiwayat.detail', compact('transaksi'));
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ], 500);
            }
        })->name('riwayat.detail');
        
        Route::get('/profil', [\App\Http\Controllers\Customer\ProfilController::class, 'index'])->name('profil');
        Route::put('/profil', [\App\Http\Controllers\Customer\ProfilController::class, 'update'])->name('profil.update');
    });
});

// Test route for available times
Route::get('/test-available-times/{mejaId}', function($mejaId) {
    try {
        $date = request('date', now()->format('Y-m-d'));
        
        $transaksis = \App\Models\Transaksi::where('meja_id', $mejaId)
            ->where('tanggal_main', $date)
            ->whereIn('status_pembayaran', ['paid', 'pending'])
            ->get();
            
        return response()->json([
            'success' => true,
            'meja_id' => $mejaId,
            'date' => $date,
            'transaksis_count' => $transaksis->count(),
            'transaksis' => $transaksis->map(function($t) {
                return [
                    'id' => $t->id,
                    'jam_mulai' => $t->jam_mulai,
                    'durasi' => $t->durasi,
                    'status_pembayaran' => $t->status_pembayaran
                ];
            })
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

// Simple test route
Route::get('/test-simple', function() {
    return 'Test route works!';
});

// Test route for debugging
Route::get('/test-riwayat', function() {
    try {
        if (!Auth::check()) {
            return response()->json(['error' => 'Not authenticated']);
        }
        
        $user = Auth::user();
        $transaksis = \App\Models\Transaksi::where('user_id', $user->id)->count();
        
        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'transaksi_count' => $transaksis,
            'message' => 'Test successful'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
})->middleware('auth');

// Webhook routes (no auth required - Midtrans will call this)
Route::post('/webhook/midtrans', [\App\Http\Controllers\WebhookController::class, 'midtransNotification'])->name('webhook.midtrans');

// DASHBOARD REDIRECT - REDIRECT TO BERANDA INSTEAD OF DEFAULT LARAVEL DASHBOARD
Route::get('/dashboard', function () {
    return redirect()->route('customer.beranda');
})->name('dashboard');

// Legacy route for backward compatibility
Route::get('/Dashboard-Admin', function () {
    return redirect()->route('admin.dashboard');
});

// Test Font Awesome route
Route::get('/test-icons', function () {
    return view('adminDashboard.DashboardAdm');
});
