@extends('layouts.app2')

@section('content')
<!-- Font Awesome Test Icons (for debugging) -->
<div style="display: none;">
  <i class="fas fa-test"></i>
  <i class="far fa-test"></i>
  <i class="fab fa-test"></i>
</div>
<div class="content-wrapper">
  <div class="container-fluid">

            <!-- Breadcrumb -->
            <div class="breadcrumb-section mb-4">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
              </nav>
            </div>

            <!-- Page Title -->
            <div class="page-header mb-4">
              <h2 class="page-title">Dashboard</h2>
              <p class="page-subtitle text-muted">Selamat datang di panel admin Bshoot Billiard</p>
            </div>



            <!-- Summary Cards -->
            <div class="row mb-4">
              <div class="col-lg-3 col-md-6">
                <div class="card bg-primary text-white">
                  <div class="card-body">
                    <i class="fas fa-receipt" style="font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.9;"></i>
                    <h5>Total Transaksi</h5>
                    <h3>25</h3>
                    <small>Periode ini</small>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6">
                <div class="card bg-success text-white">
                  <div class="card-body">
                    <i class="fas fa-money-bill-wave" style="font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.9;"></i>
                    <h5>Total Penghasilan</h5>
                    <h3>Rp 8.500.000</h3>
                    <small>Periode ini</small>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6">
                <div class="card bg-warning text-white">
                  <div class="card-body">
                    <i class="fas fa-chart-line" style="font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.9;"></i>
                    <h5>Rata-rata per Hari</h5>
                    <h3>Rp 850.000</h3>
                    <small>10 hari terakhir</small>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6">
                <div class="card bg-info text-white">
                  <div class="card-body">
                    <i class="fas fa-star" style="font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.9;"></i>
                    <h5>Meja Terfavorit</h5>
                    <h3>Meja VIP</h3>
                    <small>12 booking</small>
                  </div>
                </div>
              </div>
            </div>

            <!-- Statistik Chart -->
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                      <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Grafik Penghasilan
                      </h5>
                      <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-success btn-sm active" onclick="showStats('daily', this)">
                          <i class="fas fa-calendar-day me-1"></i>Harian
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="showStats('weekly', this)">
                          <i class="fas fa-calendar-week me-1"></i>Mingguan
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="showStats('monthly', this)">
                          <i class="fas fa-calendar-alt me-1"></i>Bulanan
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="showStats('yearly', this)">
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
</div>
@endsection