@extends('layouts.app2')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" style="margin-bottom: 1.5rem; padding: 12px 0; background: transparent;">
    <ol class="breadcrumb" style="display: flex; flex-wrap: wrap; padding: 0; margin: 0; list-style: none; background: transparent;">
        <li class="breadcrumb-item" style="font-size: 0.875rem;">
            <a href="{{ route('admin.dashboard') }}" style="color: #667eea; text-decoration: none; transition: color 0.3s;">Home</a>
        </li>
        <li class="breadcrumb-item" style="font-size: 0.875rem;">
            <a href="{{ route('admin.transaksi') }}" style="color: #667eea; text-decoration: none; transition: color 0.3s;">Transaksi</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page" style="font-size: 0.875rem; color: #495057; font-weight: 500;">Detail Transaksi</li>
    </ol>
</nav>

<!-- Page Header -->
<div style="display: flex; justify-content: space-between; align-items: flex-start; background: #ffffff; padding: 20px 24px; border-radius: 12px; border: 1px solid #e9ecef; margin-bottom: 1.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.04);">
    <div>
        <h2 style="font-size: 1.5rem; font-weight: 700; color: #212529; margin-bottom: 0.5rem;">Detail Transaksi</h2>
        <p style="font-size: 0.9rem; color: #6c757d; margin: 0;">Informasi lengkap transaksi #{{ $transaksi->kode_transaksi }}</p>
    </div>
    <a href="{{ route('admin.transaksi') }}" 
       style="display: inline-flex; align-items: center; border: 1px solid #ced4da; color: #495057; padding: 8px 16px; border-radius: 8px; font-weight: 500; background: #f8f9fa; text-decoration: none; transition: all 0.3s;">
        <i class="fas fa-arrow-left" style="margin-right: 0.5rem;"></i>Kembali
    </a>
</div>

<div style="display: flex; flex-wrap: wrap; margin: 0 -12px;">
    <!-- Main Content -->
    <div style="flex: 0 0 66.666667%; max-width: 66.666667%; padding: 0 12px;">
        <!-- Invoice Card -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e0e0e0; margin-bottom: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.06); overflow: hidden;">
            <!-- Card Header -->
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 1.5rem; color: white;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h5 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">Invoice Transaksi</h5>
                        <div style="font-size: 1.5rem; font-weight: 700; letter-spacing: 0.5px;">{{ $transaksi->kode_transaksi }}</div>
                    </div>
                    <div>
                        @if($transaksi->status_pembayaran === 'paid')
                            <span style="display: inline-block; background: linear-gradient(135deg, #28a745 0%, #218838 100%); color: white; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.9rem; font-weight: 600;">LUNAS</span>
                        @elseif($transaksi->status_pembayaran === 'pending')
                            <span style="display: inline-block; background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: #212529; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.9rem; font-weight: 600;">MENUNGGU PEMBAYARAN</span>
                        @elseif($transaksi->status_pembayaran === 'failed')
                            <span style="display: inline-block; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.9rem; font-weight: 600;">PEMBAYARAN GAGAL</span>
                        @else
                            <span style="display: inline-block; background: #6c757d; color: white; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.9rem; font-weight: 600;">{{ strtoupper($transaksi->status_pembayaran_text) }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div style="padding: 1.5rem;">
                <!-- Customer Info -->
                <div style="margin-bottom: 1.5rem;">
                    <h6 style="font-size: 1rem; font-weight: 700; color: #667eea; margin-bottom: 1rem; display: flex; align-items: center;">
                        <i class="fas fa-user" style="margin-right: 0.5rem;"></i>Informasi Pelanggan
                    </h6>
                    <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; padding: 1rem; border-left: 4px solid #667eea;">
                        <div style="display: flex; flex-wrap: wrap; margin: 0 -0.75rem;">
                            <div style="flex: 0 0 50%; max-width: 50%; padding: 0 0.75rem; margin-bottom: 1rem;">
                                <div style="color: #6c757d; font-size: 0.875rem; margin-bottom: 0.25rem;">Nama Lengkap</div>
                                <div style="font-weight: 600; color: #212529;">{{ $transaksi->user->name ?? 'Customer' }}</div>
                            </div>
                            <div style="flex: 0 0 50%; max-width: 50%; padding: 0 0.75rem; margin-bottom: 1rem;">
                                <div style="color: #6c757d; font-size: 0.875rem; margin-bottom: 0.25rem;">Email</div>
                                <div style="font-weight: 600; color: #212529;">{{ $transaksi->user->email ?? '-' }}</div>
                            </div>
                            @if($transaksi->user->no_telepon ?? null)
                            <div style="flex: 0 0 50%; max-width: 50%; padding: 0 0.75rem;">
                                <div style="color: #6c757d; font-size: 0.875rem; margin-bottom: 0.25rem;">No. Telepon</div>
                                <div style="font-weight: 600; color: #212529;">{{ $transaksi->user->no_telepon }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Booking Info -->
                <div style="margin-bottom: 1.5rem;">
                    <h6 style="font-size: 1rem; font-weight: 700; color: #667eea; margin-bottom: 1rem; display: flex; align-items: center;">
                        <i class="fas fa-calendar-check" style="margin-right: 0.5rem;"></i>Informasi Booking
                    </h6>
                    <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; padding: 1rem; border-left: 4px solid #28a745;">
                        <div style="display: flex; flex-wrap: wrap; margin: 0 -0.75rem;">
                            <div style="flex: 0 0 50%; max-width: 50%; padding: 0 0.75rem; margin-bottom: 1rem;">
                                <div style="color: #6c757d; font-size: 0.875rem; margin-bottom: 0.25rem;">Tanggal Booking</div>
                                <div style="font-weight: 600; color: #212529;">{{ $transaksi->formatted_tanggal_booking }}</div>
                            </div>
                            <div style="flex: 0 0 50%; max-width: 50%; padding: 0 0.75rem; margin-bottom: 1rem;">
                                <div style="color: #6c757d; font-size: 0.875rem; margin-bottom: 0.25rem;">Waktu</div>
                                <div style="font-weight: 600; color: #212529;">{{ $transaksi->formatted_jam_mulai }} - {{ $transaksi->formatted_jam_selesai }} WIB</div>
                            </div>
                            <div style="flex: 0 0 50%; max-width: 50%; padding: 0 0.75rem;">
                                <div style="color: #6c757d; font-size: 0.875rem; margin-bottom: 0.25rem;">Durasi</div>
                                <div style="font-weight: 600; color: #212529;">{{ $transaksi->durasi }} Jam</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Details -->
                <div style="margin-bottom: 1.5rem;">
                    <h6 style="font-size: 1rem; font-weight: 700; color: #667eea; margin-bottom: 1rem; display: flex; align-items: center;">
                        <i class="fas fa-list" style="margin-right: 0.5rem;"></i>Detail Pesanan
                    </h6>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: separate; border-spacing: 0; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                            <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                <tr>
                                    <th style="padding: 0.75rem; border-bottom: 1px solid #dee2e6; text-align: left; font-weight: 600; color: #495057;">Meja</th>
                                    <th style="padding: 0.75rem; border-bottom: 1px solid #dee2e6; text-align: left; font-weight: 600; color: #495057;">Kategori</th>
                                    <th style="padding: 0.75rem; border-bottom: 1px solid #dee2e6; text-align: left; font-weight: 600; color: #495057;">Durasi</th>
                                    <th style="padding: 0.75rem; border-bottom: 1px solid #dee2e6; text-align: left; font-weight: 600; color: #495057;">Harga/Jam</th>
                                    <th style="padding: 0.75rem; border-bottom: 1px solid #dee2e6; text-align: left; font-weight: 600; color: #495057;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 0.75rem; border-bottom: 1px solid #dee2e6; font-weight: 600;">{{ $transaksi->meja->nama_meja }}</td>
                                    <td style="padding: 0.75rem; border-bottom: 1px solid #dee2e6;">
                                        @if($transaksi->meja->category->nama === 'VIP')
                                            <span style="display: inline-block; background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: #212529; padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.875rem; font-weight: 600;">{{ $transaksi->meja->category->nama }}</span>
                                        @else
                                            <span style="display: inline-block; background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.875rem; font-weight: 600;">{{ $transaksi->meja->category->nama }}</span>
                                        @endif
                                    </td>
                                    <td style="padding: 0.75rem; border-bottom: 1px solid #dee2e6;">{{ $transaksi->durasi }} Jam</td>
                                    <td style="padding: 0.75rem; border-bottom: 1px solid #dee2e6;">{{ $transaksi->formatted_harga_per_jam }}</td>
                                    <td style="padding: 0.75rem; border-bottom: 1px solid #dee2e6; font-weight: 700; color: #28a745;">{{ $transaksi->formatted_total_harga }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="text-align: right; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 1rem; border-radius: 8px; margin-top: 1rem;">
                        <h5 style="font-size: 1.25rem; margin: 0; display: inline-flex; align-items: center;">
                            <span style="color: #6c757d; margin-right: 1rem;">Total Pembayaran:</span>
                            <span style="color: #28a745; font-weight: 700;">{{ $transaksi->formatted_total_harga }}</span>
                        </h5>
                    </div>
                </div>

                <!-- Payment Info -->
                <div style="margin-bottom: 1.5rem;">
                    <h6 style="font-size: 1rem; font-weight: 700; color: #667eea; margin-bottom: 1rem; display: flex; align-items: center;">
                        <i class="fas fa-credit-card" style="margin-right: 0.5rem;"></i>Informasi Pembayaran
                    </h6>
                    <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; padding: 1rem; border-left: 4px solid #fd7e14;">
                        <div style="display: flex; flex-wrap: wrap; margin: 0 -0.75rem;">
                            <div style="flex: 0 0 50%; max-width: 50%; padding: 0 0.75rem; margin-bottom: 1rem;">
                                <div style="color: #6c757d; font-size: 0.875rem; margin-bottom: 0.25rem;">Metode Pembayaran</div>
                                <div style="font-weight: 600; color: #212529;">{{ $transaksi->payment_type ?? $transaksi->metode_pembayaran ?? 'Belum dipilih' }}</div>
                            </div>
                            <div style="flex: 0 0 50%; max-width: 50%; padding: 0 0.75rem; margin-bottom: 1rem;">
                                <div style="color: #6c757d; font-size: 0.875rem; margin-bottom: 0.25rem;">Status Pembayaran</div>
                                @if($transaksi->status_pembayaran === 'paid')
                                    <div style="font-weight: 700; color: #28a745;">Lunas</div>
                                @elseif($transaksi->status_pembayaran === 'pending')
                                    <div style="font-weight: 700; color: #ffc107;">Menunggu Pembayaran</div>
                                @else
                                    <div style="font-weight: 700; color: #dc3545;">{{ $transaksi->status_pembayaran_text }}</div>
                                @endif
                            </div>
                            @if($transaksi->paid_at)
                            <div style="flex: 0 0 50%; max-width: 50%; padding: 0 0.75rem; margin-bottom: 1rem;">
                                <div style="color: #6c757d; font-size: 0.875rem; margin-bottom: 0.25rem;">Tanggal Pembayaran</div>
                                <div style="font-weight: 600; color: #212529;">{{ $transaksi->paid_at->format('d/m/Y H:i') }} WIB</div>
                            </div>
                            @endif
                            @if($transaksi->midtrans_order_id)
                            <div style="flex: 0 0 50%; max-width: 50%; padding: 0 0.75rem;">
                                <div style="color: #6c757d; font-size: 0.875rem; margin-bottom: 0.25rem;">Order ID Midtrans</div>
                                <code style="background: #e9ecef; padding: 0.2rem 0.4rem; border-radius: 4px; font-family: monospace; font-weight: 600;">{{ $transaksi->midtrans_order_id }}</code>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Check-in/Check-out Info -->
                @if($transaksi->waktu_checkin || $transaksi->waktu_checkout)
                <div style="margin-bottom: 1.5rem;">
                    <h6 style="font-size: 1rem; font-weight: 700; color: #667eea; margin-bottom: 1rem; display: flex; align-items: center;">
                        <i class="fas fa-door-open" style="margin-right: 0.5rem;"></i>Informasi Check-in/Check-out
                    </h6>
                    <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; padding: 1rem; border-left: 4px solid #6f42c1;">
                        <div style="display: flex; flex-wrap: wrap; margin: 0 -0.75rem;">
                            @if($transaksi->waktu_checkin)
                            <div style="flex: 0 0 50%; max-width: 50%; padding: 0 0.75rem; margin-bottom: 1rem;">
                                <div style="color: #6c757d; font-size: 0.875rem; margin-bottom: 0.25rem;">Waktu Check-in</div>
                                <div style="font-weight: 600; color: #212529;">{{ $transaksi->waktu_checkin->format('d/m/Y H:i') }} WIB</div>
                            </div>
                            @endif
                            @if($transaksi->waktu_checkout)
                            <div style="flex: 0 0 50%; max-width: 50%; padding: 0 0.75rem;">
                                <div style="color: #6c757d; font-size: 0.875rem; margin-bottom: 0.25rem;">Waktu Check-out</div>
                                <div style="font-weight: 600; color: #212529;">{{ $transaksi->waktu_checkout->format('d/m/Y H:i') }} WIB</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Notes -->
                @if($transaksi->catatan)
                <div style="margin-bottom: 1.5rem;">
                    <h6 style="font-size: 1rem; font-weight: 700; color: #667eea; margin-bottom: 1rem; display: flex; align-items: center;">
                        <i class="fas fa-sticky-note" style="margin-right: 0.5rem;"></i>Catatan
                    </h6>
                    <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; padding: 1rem; border-left: 4px solid #20c997;">
                        <p style="margin: 0; color: #212529;">{{ $transaksi->catatan }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div style="flex: 0 0 33.333333%; max-width: 33.333333%; padding: 0 12px;">
        <!-- Status Card -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e0e0e0; margin-bottom: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.06); overflow: hidden;">
            <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 1rem 1.5rem; border-bottom: 1px solid #dee2e6;">
                <h6 style="margin: 0; font-weight: 700; display: flex; align-items: center;">
                    <i class="fas fa-info-circle" style="margin-right: 0.5rem; color: #667eea;"></i>Status Booking
                </h6>
            </div>
            <div style="padding: 1.5rem; text-align: center;">
                @if($transaksi->status_booking === 'confirmed')
                    <div style="margin-bottom: 1rem;">
                        <i class="fas fa-check-circle" style="font-size: 3rem; color: #17a2b8;"></i>
                    </div>
                    <h6 style="font-weight: 700; color: #17a2b8; margin-bottom: 0.5rem;">DIKONFIRMASI</h6>
                    <p style="color: #6c757d; font-size: 0.875rem; margin-bottom: 1rem;">Booking telah dikonfirmasi</p>
                    <button onclick="checkinCustomer({{ $transaksi->id }})" 
                            style="width: 100%; background: linear-gradient(135deg, #28a745 0%, #218838 100%); color: white; border: none; padding: 0.75rem; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.3s;">
                        <i class="fas fa-sign-in-alt" style="margin-right: 0.5rem;"></i>Check In Customer
                    </button>
                @elseif($transaksi->status_booking === 'ongoing')
                    <div style="margin-bottom: 1rem;">
                        <i class="fas fa-clock" style="font-size: 3rem; color: #667eea;"></i>
                    </div>
                    <h6 style="font-weight: 700; color: #667eea; margin-bottom: 0.5rem;">SEDANG BERLANGSUNG</h6>
                    <p style="color: #6c757d; font-size: 0.875rem; margin-bottom: 1rem;">Customer sedang menggunakan meja</p>
                    <button onclick="checkoutCustomer({{ $transaksi->id }})" 
                            style="width: 100%; background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: #212529; border: none; padding: 0.75rem; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.3s;">
                        <i class="fas fa-sign-out-alt" style="margin-right: 0.5rem;"></i>Check Out Customer
                    </button>
                @elseif($transaksi->status_booking === 'completed')
                    <div style="margin-bottom: 1rem;">
                        <i class="fas fa-check-double" style="font-size: 3rem; color: #28a745;"></i>
                    </div>
                    <h6 style="font-weight: 700; color: #28a745; margin-bottom: 0.5rem;">SELESAI</h6>
                    <p style="color: #6c757d; font-size: 0.875rem; margin-bottom: 0;">Transaksi telah selesai</p>
                @else
                    <div style="margin-bottom: 1rem;">
                        <i class="fas fa-times-circle" style="font-size: 3rem; color: #6c757d;"></i>
                    </div>
                    <h6 style="font-weight: 700; color: #6c757d; margin-bottom: 0.5rem;">{{ strtoupper($transaksi->status_booking_text) }}</h6>
                @endif
            </div>
        </div>

        <!-- Action Buttons Card -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e0e0e0; margin-bottom: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.06); overflow: hidden;">
            <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 1rem 1.5rem; border-bottom: 1px solid #dee2e6;">
                <h6 style="margin: 0; font-weight: 700; display: flex; align-items: center;">
                    <i class="fas fa-cog" style="margin-right: 0.5rem; color: #667eea;"></i>Aksi Admin
                </h6>
            </div>
            <div style="padding: 1.5rem;">
                <div style="display: grid; gap: 0.75rem;">
                    <button onclick="printInvoice()" 
                            style="background: linear-gradient(135deg, #667eea 0%, #5a67d8 100%); color: white; border: none; padding: 0.75rem; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-print" style="margin-right: 0.5rem;"></i>Cetak Invoice
                    </button>
                    <button onclick="sendEmail()" 
                            style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; border: none; padding: 0.75rem; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-envelope" style="margin-right: 0.5rem;"></i>Kirim Email
                    </button>
                    @if($transaksi->status_pembayaran !== 'paid' && $transaksi->status_booking !== 'completed')
                    <button onclick="cancelTransaction({{ $transaksi->id }})" 
                            style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; padding: 0.75rem; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-times" style="margin-right: 0.5rem;"></i>Batalkan Transaksi
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Help Card -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e0e0e0; box-shadow: 0 2px 8px rgba(0,0,0,0.06); overflow: hidden;">
            <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 1rem 1.5rem; border-bottom: 1px solid #dee2e6;">
                <h6 style="margin: 0; font-weight: 700; display: flex; align-items: center;">
                    <i class="fas fa-question-circle" style="margin-right: 0.5rem; color: #667eea;"></i>Bantuan Admin
                </h6>
            </div>
            <div style="padding: 1.5rem;">
                <p style="color: #6c757d; font-size: 0.875rem; margin-bottom: 1rem;">Panduan untuk admin</p>
                <div style="display: grid; gap: 0.75rem;">
                    <a href="#" 
                       style="border: 1px solid #28a745; color: #28a745; background: transparent; padding: 0.75rem; border-radius: 8px; text-decoration: none; font-size: 0.875rem; font-weight: 500; text-align: center; transition: all 0.3s; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-book" style="margin-right: 0.5rem;"></i>Manual Admin
                    </a>
                    <a href="#" 
                       style="border: 1px solid #667eea; color: #667eea; background: transparent; padding: 0.75rem; border-radius: 8px; text-decoration: none; font-size: 0.875rem; font-weight: 500; text-align: center; transition: all 0.3s; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-headset" style="margin-right: 0.5rem;"></i>Support IT
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Inline Styles -->
<style>
    /* Hover Effects */
    a:hover {
        text-decoration: none;
    }
    
    .breadcrumb-item a:hover {
        color: #5a67d8;
        text-decoration: underline;
    }
    
    button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    a[style*="border: 1px solid"]:hover {
        background: rgba(0,0,0,0.05);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    /* Responsive Design */
    @media (max-width: 992px) {
        div[style*="flex: 0 0 66.666667%"] {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            margin-bottom: 1.5rem;
        }
        
        div[style*="flex: 0 0 33.333333%"] {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
    }
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }
        
        div[style*="flex: 0 0 50%"] {
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
        
        table {
            display: block;
            overflow-x: auto;
        }
        
        button, a[style*="border: 1px solid"] {
            width: 100%;
        }
    }
    
    @media (max-width: 576px) {
        .page-header h2 {
            font-size: 1.25rem;
        }
        
        .breadcrumb {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            display: none;
        }
    }
    
    /* Print Styles */
    @media print {
        button, .page-header > a {
            display: none !important;
        }
        
        .detail-transaksi-card {
            box-shadow: none !important;
            border: 1px solid #000 !important;
        }
    }
</style>

<!-- FontAwesome untuk ikon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- JavaScript Functions -->
<script>
function checkinCustomer(transaksiId) {
    if (confirm('Konfirmasi check-in customer?')) {
        // Implement check-in logic here
        fetch(`/admin/transaksi/${transaksiId}/checkin`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Check-in berhasil!');
                location.reload();
            } else {
                alert('Gagal melakukan check-in: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat check-in');
        });
    }
}

function checkoutCustomer(transaksiId) {
    if (confirm('Konfirmasi check-out customer?')) {
        // Implement check-out logic here
        fetch(`/admin/transaksi/${transaksiId}/checkout`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Check-out berhasil!');
                location.reload();
            } else {
                alert('Gagal melakukan check-out: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat check-out');
        });
    }
}

function printInvoice() {
    window.print();
}

function sendEmail() {
    if (confirm('Kirim invoice ke email customer?')) {
        // Implement email sending logic here
        fetch(`/admin/transaksi/{{ $transaksi->id }}/send-invoice`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Invoice berhasil dikirim ke email customer!');
            } else {
                alert('Gagal mengirim email: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengirim email');
        });
    }
}

function cancelTransaction(transaksiId) {
    if (confirm('Batalkan transaksi ini? Tindakan ini tidak dapat dibatalkan.')) {
        // Implement cancellation logic here
        fetch(`/admin/transaksi/${transaksiId}/cancel`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ reason: 'Dibatalkan oleh admin' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Transaksi berhasil dibatalkan!');
                location.reload();
            } else {
                alert('Gagal membatalkan transaksi: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat membatalkan transaksi');
        });
    }
}
</script>
@endsection