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
              <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="card bg-primary text-white">
                  <div class="card-body">
                    <i class="fas fa-check-circle" style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.9;"></i>
                    <h6>Transaksi Berhasil</h6>
                    <h3>{{ $stats['total_transaksi'] }}</h3>
                    <small>{{ $stats['transaksi_hari_ini'] }} hari ini</small>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="card bg-warning text-white">
                  <div class="card-body">
                    <i class="fas fa-clock" style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.9;"></i>
                    <h6>Menunggu Pembayaran</h6>
                    <h3>{{ $stats['transaksi_pending'] }}</h3>
                    <small>{{ $stats['transaksi_pending_hari_ini'] }} hari ini</small>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="card bg-success text-white">
                  <div class="card-body">
                    <i class="fas fa-money-bill-wave" style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.9;"></i>
                    <h6>Total Penghasilan</h6>
                    <h3>Rp {{ number_format($stats['total_penghasilan'], 0, ',', '.') }}</h3>
                    <small>Rp {{ number_format($stats['penghasilan_hari_ini'], 0, ',', '.') }} hari ini</small>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="card bg-info text-white">
                  <div class="card-body">
                    <i class="fas fa-chart-line" style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.9;"></i>
                    <h6>Rata-rata per Hari</h6>
                    <h3>Rp {{ number_format($stats['rata_rata_per_hari'], 0, ',', '.') }}</h3>
                    <small>10 hari terakhir</small>
                  </div>
                </div>
              </div>
            </div>

            <!-- Additional Statistics Row -->
            <div class="row mb-4">
              <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-left-primary">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          Meja Tersedia
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          {{ $stats['meja_tersedia'] }} / {{ $stats['total_meja'] }}
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-table fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-left-success">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                          Transaksi Paid Hari Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          {{ $stats['transaksi_paid_hari_ini'] }}
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-play-circle fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-left-info">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                          Total Pelanggan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          {{ $stats['total_pelanggan'] }}
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-left-danger">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                          Transaksi Gagal
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          {{ $stats['transaksi_failed'] }}
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                      </div>
                    </div>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Data from controller
const dailyData = @json($dailyRevenue);
const weeklyData = @json($weeklyRevenue);
const monthlyData = @json($monthlyRevenue);
const yearlyData = @json($yearlyRevenue);

let revenueChart;

// Format currency for display
function formatCurrency(value) {
    if (value >= 1000000000) {
        return 'Rp ' + (value / 1000000000).toFixed(1) + 'M'; // Milyar
    } else if (value >= 1000000) {
        return 'Rp ' + (value / 1000000).toFixed(1) + 'Jt'; // Juta
    } else if (value >= 1000) {
        return 'Rp ' + (value / 1000).toFixed(0) + 'rb'; // Ribu
    } else {
        return 'Rp ' + value.toLocaleString('id-ID');
    }
}

// Initialize chart with daily data
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dailyData.map(item => item.date),
            datasets: [{
                label: 'Penghasilan',
                data: dailyData.map(item => item.revenue),
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#28a745',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: '#28a745',
                pointHoverBorderColor: '#ffffff',
                pointHoverBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            family: 'Poppins',
                            size: 12,
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#28a745',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Penghasilan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: 'Poppins',
                            size: 11
                        }
                    }
                },
                y: {
                    beginAtZero: false,
                    min: 30000,
                    max: 1000000,
                    ticks: {
                        stepSize: 100000,
                        callback: function(value) {
                            return formatCurrency(value);
                        },
                        font: {
                            family: 'Poppins',
                            size: 11
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
});

// Function to switch between different time periods
function showStats(period, button) {
    // Update active button
    document.querySelectorAll('.btn-group button').forEach(btn => {
        btn.classList.remove('active');
    });
    button.classList.add('active');
    
    let labels, data, chartLabel;
    
    switch(period) {
        case 'daily':
            labels = dailyData.map(item => item.date);
            data = dailyData.map(item => item.revenue);
            chartLabel = 'Penghasilan Harian';
            break;
        case 'weekly':
            labels = weeklyData.map(item => item.week);
            data = weeklyData.map(item => item.revenue);
            chartLabel = 'Penghasilan Mingguan';
            break;
        case 'monthly':
            labels = monthlyData.map(item => item.month);
            data = monthlyData.map(item => item.revenue);
            chartLabel = 'Penghasilan Bulanan';
            break;
        case 'yearly':
            labels = yearlyData.map(item => item.year);
            data = yearlyData.map(item => item.revenue);
            chartLabel = 'Penghasilan Tahunan';
            break;
    }
    
    // Update chart
    revenueChart.data.labels = labels;
    revenueChart.data.datasets[0].data = data;
    revenueChart.data.datasets[0].label = chartLabel;
    
    // Update chart colors based on period
    const colors = {
        daily: { border: '#28a745', bg: 'rgba(40, 167, 69, 0.1)' },
        weekly: { border: '#17a2b8', bg: 'rgba(23, 162, 184, 0.1)' },
        monthly: { border: '#ffc107', bg: 'rgba(255, 193, 7, 0.1)' },
        yearly: { border: '#dc3545', bg: 'rgba(220, 53, 69, 0.1)' }
    };
    
    revenueChart.data.datasets[0].borderColor = colors[period].border;
    revenueChart.data.datasets[0].backgroundColor = colors[period].bg;
    revenueChart.data.datasets[0].pointBackgroundColor = colors[period].border;
    revenueChart.data.datasets[0].pointHoverBackgroundColor = colors[period].border;
    
    revenueChart.update('active');
    
    // Update summary statistics
    updateSummaryStats(period, data);
}

// Update summary statistics based on selected period
function updateSummaryStats(period, data) {
    const total = data.reduce((a, b) => a + b, 0);
    const average = total / data.length;
    const highest = Math.max(...data);
    const lowest = Math.min(...data);
    
    // Update cards if they exist
    const totalRevenueEl = document.querySelector('.bg-success h3');
    const avgRevenueEl = document.querySelector('.bg-warning h3');
    
    if (totalRevenueEl) {
        totalRevenueEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
    
    if (avgRevenueEl) {
        const periodText = {
            daily: 'per hari',
            weekly: 'per minggu', 
            monthly: 'per bulan',
            yearly: 'per tahun'
        };
        avgRevenueEl.textContent = 'Rp ' + Math.round(average).toLocaleString('id-ID');
        avgRevenueEl.nextElementSibling.textContent = `Rata-rata ${periodText[period]}`;
    }
}
</script>

<style>
.chart-container {
    position: relative;
    height: 400px;
    width: 100%;
}

.card {
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
}

.card-body {
    padding: 1.5rem;
}

.card h3 {
    font-size: 2rem;
    font-weight: bold;
    margin: 0.5rem 0;
}

.card h5 {
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.btn-group .btn {
    border-radius: 0;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-group .btn:first-child {
    border-top-left-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
}

.btn-group .btn:last-child {
    border-top-right-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
}

.btn-group .btn.active {
    background-color: #28a745;
    color: white;
    border-color: #28a745;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
}

.btn-outline-success:hover {
    background-color: #28a745;
    border-color: #28a745;
    transform: translateY(-2px);
}

/* Enhanced card styling */
.bg-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
}

.bg-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
}

.bg-warning {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%) !important;
}

.bg-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
}

.bg-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #545b62 100%) !important;
}

/* Border left cards */
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}

/* Text utilities */
.text-xs {
    font-size: 0.75rem;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.text-gray-300 {
    color: #dddfeb !important;
}

/* Card enhancements for 4 cards layout */
.col-lg-3 .card {
    min-height: 160px;
}

.col-lg-3 .card h6 {
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.col-lg-3 .card h3 {
    font-size: 1.75rem;
    font-weight: bold;
    margin: 0.5rem 0;
}

.col-lg-3 .card small {
    font-size: 0.8rem;
}

/* Responsive adjustments for 4 cards */
@media (max-width: 1200px) {
    .col-lg-3 {
        flex: 0 0 25%;
        max-width: 25%;
    }
}

@media (max-width: 992px) {
    .col-lg-3 {
        flex: 0 0 50%;
        max-width: 50%;
    }
}

@media (max-width: 768px) {
    .col-lg-3 {
        flex: 0 0 50%;
        max-width: 50%;
    }
}

@media (max-width: 576px) {
    .col-lg-3 {
        flex: 0 0 100%;
        max-width: 100%;
    }
}

/* Chart card styling */
.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    border-radius: 15px 15px 0 0 !important;
}

.card-title {
    color: #495057;
    font-weight: 600;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .btn-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.25rem;
    }
    
    .btn-group .btn {
        border-radius: 0.375rem !important;
        flex: 1;
        min-width: calc(50% - 0.125rem);
    }
    
    .chart-container {
        height: 300px;
    }
}
</style>
@endpush