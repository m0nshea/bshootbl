@extends('layouts.customer')

@section('title', 'Daftar Meja - Bshoot Billiard')
@section('description', 'Daftar meja billiard yang tersedia untuk booking')

@push('styles')
<link href="{{ asset('css/customer-meja.css') }}" rel="stylesheet" />
<style>
/* Meja yang sudah dibooking */
.meja-card.meja-booked {
    background-color: #f8f9fa;
    border: 2px solid #dee2e6;
    opacity: 0.7;
    position: relative;
}

.meja-card.meja-booked .meja-image {
    filter: grayscale(50%);
    opacity: 0.8;
}

.meja-card.meja-booked .meja-content {
    color: #6c757d;
}

.meja-title-disabled {
    color: #6c757d !important;
    text-decoration: none;
    cursor: not-allowed;
    font-weight: 600;
    font-size: 1.1rem;
    display: block;
    margin-bottom: 10px;
}

.booking-status-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(108, 117, 125, 0.9);
    color: white;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    z-index: 2;
}

.booking-info {
    background: #e9ecef;
    color: #495057;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 0.85rem;
    margin-top: 10px;
    border-left: 4px solid #6c757d;
}

.booking-info i {
    color: #6c757d;
}

/* Hover effect untuk meja yang tidak dibooking */
.meja-card:not(.meja-booked):hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

/* Disable hover untuk meja yang sudah dibooking */
.meja-card.meja-booked:hover {
    transform: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="container py-5">
        <!-- Page Title -->
        <div class="text-center mb-5">
            <h5 class="page-title">
                Daftar Meja
            </h5>
        </div>

        <!-- Meja Cards -->
        <div class="row meja-row justify-content-center">
            @forelse($mejas as $meja)
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="meja-card {{ str_contains(strtolower($meja->category->nama), 'vip') ? 'meja-vip' : '' }} {{ $meja->booking_status_class }}">
                        @if(str_contains(strtolower($meja->category->nama), 'vip'))
                            <div class="vip-badge">
                                <i class="bi bi-star-fill"></i> VIP
                            </div>
                        @endif
                        
                        @if($meja->isBooked())
                            <div class="booking-status-badge">
                                <i class="bi bi-calendar-check"></i> Sudah Dibooking
                            </div>
                        @endif
                        
                        <img src="{{ $meja->foto_url }}" 
                             class="meja-image" 
                             alt="{{ $meja->nama_meja }}" 
                             onerror="this.src='{{ asset('img/table.jpeg') }}'" />
                        <div class="meja-content">
                            @if($meja->isBooked())
                                <span class="meja-title meja-title-disabled">
                                    {{ $meja->nama_meja }}
                                </span>
                            @else
                                <a href="{{ route('customer.meja.detail', $meja->id) }}" class="meja-title">
                                    {{ $meja->nama_meja }}
                                </a>
                            @endif
                            <div class="meja-details">
                                <p>Kategori: {{ $meja->category->nama }}</p>
                                <p>Harga: {{ $meja->formatted_harga }}/jam</p>
                                @if($meja->deskripsi)
                                    <p class="text-muted">{{ Str::limit($meja->deskripsi, 50) }}</p>
                                @endif
                                @if($meja->isBooked())
                                    <p class="booking-info">
                                        <i class="bi bi-info-circle"></i> 
                                        Meja ini sudah dibooking dan dibayar
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <h4 class="mt-3">Belum Ada Meja Tersedia</h4>
                            <p>Meja billiard akan segera tersedia</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        @if($mejas->count() > 0)
            <div class="text-center mt-5">
                <p class="text-muted">
                    <i class="bi bi-info-circle me-2"></i>
                    Menampilkan {{ $mejas->count() }} meja tersedia
                </p>
            </div>
        @else
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="text-muted">
                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Belum Ada Meja Tersedia</h4>
                        <p>Silakan hubungi admin untuk menambahkan meja</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection