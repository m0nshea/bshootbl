@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="page-header mb-4">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Selamat datang di panel admin Bshoot Billiard</p>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stats-card bg-primary text-white">
                <i class="fas fa-receipt"></i>
                <h5>Total Transaksi</h5>
                <h3 id="totalTransactions">25</h3>
                <small>Periode ini</small>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stats-card bg-success text-white">
                <i class="fas fa-money-bill-wave"></i>
                <h5>Total Penghasilan</h5>
                <h3 id="totalRevenue">Rp 8.500.000</h3>
                <small>Periode ini</small>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stats-card bg-warning text-white">
                <i class="fas fa-chart-line"></i>
                <h5>Rata-rata per Hari</h5>
                <h3 id="avgDaily">Rp 850.000</h3>
                <small>10 hari terakhir</small>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stats-card bg-info text-white">
                <i class="fas fa-star"></i>
                <h5>Meja Terfavorit</h5>
                <h3 id="favTable">Meja VIP</h3>
                <small>12 booking</small>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line me-2"></i>Grafik Penghasilan
                        </h5>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-success btn-sm active" onclick="showStats('daily')">
                                <i class="fas fa-calendar-day me-1"></i>Harian
                            </button>
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="showStats('weekly')">
                                <i class="fas fa-calendar-week me-1"></i>Mingguan
                            </button>
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="showStats('monthly')">
                                <i class="fas fa-calendar-alt me-1"></i>Bulanan
                            </button>
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="showStats('yearly')">
                                <i class="fas fa-calendar me-1"></i>Tahunan
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection