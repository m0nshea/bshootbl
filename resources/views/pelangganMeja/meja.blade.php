@extends('layouts.customer')

@section('title', 'Daftar Meja - Bshoot Billiard')
@section('description', 'Daftar meja billiard yang tersedia untuk booking')

@push('styles')
<link href="{{ asset('css/customer-meja.css') }}" rel="stylesheet" />
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
                    <div class="meja-card {{ str_contains(strtolower($meja->category->nama), 'vip') ? 'meja-vip' : '' }}">
                        @if(str_contains(strtolower($meja->category->nama), 'vip'))
                            <div class="vip-badge">
                                <i class="bi bi-star-fill"></i> VIP
                            </div>
                        @endif
                        <img src="{{ $meja->foto_url }}" 
                             class="meja-image" 
                             alt="{{ $meja->nama_meja }}" />
                        <div class="meja-content">
                            <a href="{{ route('customer.meja.detail', $meja->id) }}" class="meja-title">
                                {{ $meja->nama_meja }}
                            </a>
                            <div class="meja-details">
                                <p>Kategori: {{ $meja->category->nama }}</p>
                                <p>Harga: {{ $meja->formatted_harga }}/jam</p>
                                @if($meja->deskripsi)
                                    <p class="text-muted">{{ Str::limit($meja->deskripsi, 50) }}</p>
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
        @endif
    </div>
</div>
@endsection