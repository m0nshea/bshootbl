@extends('layouts.customer')

@section('title', 'Kategori Permainan - Bshoot Billiard')
@section('description', 'Kategori permainan billiard yang tersedia')

@push('styles')
<link href="{{ asset('css/customer-kategori.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid">
    <div class="container py-5">
        <!-- Page Title -->
        <div class="text-center mb-5">
            <h5 class="mb-2 px-3 py-1 rounded-pill d-inline-block border border-2 category-title">
                Kategori Permainan
            </h5>
        </div>

        <!-- Category Cards -->
        <div class="row category-row justify-content-center">
            @forelse($categories as $category)
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card text-center">
                        @if($category->thumbnail)
                            <img src="{{ asset('storage/categories/' . $category->thumbnail) }}" 
                                 class="category-image" 
                                 alt="{{ $category->nama }}" />
                        @else
                            <img src="{{ asset('img/kategori/default.jpg') }}" 
                                 class="category-image" 
                                 alt="{{ $category->nama }}" />
                        @endif
                        <h4>{{ $category->nama }}</h4>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <h4 class="mt-3">Belum Ada Kategori</h4>
                            <p>Kategori permainan akan segera tersedia</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        @if($categories->count() > 0)
            <div class="text-center mt-5">
                <p class="text-muted">
                    <i class="bi bi-info-circle me-2"></i>
                    Menampilkan {{ $categories->count() }} kategori permainan
                </p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Add hover effects to category cards
    $('.card').hover(
        function() {
            $(this).addClass('shadow-lg');
            $(this).find('.category-image').addClass('scale-110');
        },
        function() {
            $(this).removeClass('shadow-lg');
            $(this).find('.category-image').removeClass('scale-110');
        }
    );
});
</script>
@endpush