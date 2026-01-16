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
                    <h3>{{ $stats['total_transaksi'] }}</h3>
                    <small>{{ $stats['transaksi_hari_ini'] }} transaksi hari ini</small>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6">
                <div class="card bg-success text-white">
                  <div class="card-body">
                    <i class="fas fa-money-bill-wave" style="font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.9;"></i>
                    <h5>Total Penghasilan</h5>
                    <h3>Rp {{ number_format($stats['total_penghasilan'], 0, ',', '.') }}</h3>
                    <small>Rp {{ number_format($stats['penghasilan_hari_ini'], 0, ',', '.') }} hari ini</small>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6">
                <div class="card bg-warning text-white">
                  <div class="card-body">
                    <i class="fas fa-chart-line" style="font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.9;"></i>
                    <h5>Rata-rata per Hari</h5>
                    <h3>Rp {{ number_format($stats['rata_rata_per_hari'], 0, ',', '.') }}</h3>
                    <small>10 hari terakhir</small>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6">
                <div class="card bg-info text-white">
                  <div class="card-body">
                    <i class="fas fa-star" style="font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.9;"></i>
                    <h5>Meja Terfavorit</h5>
                    <h3>{{ $stats['meja_terfavorit'] }}</h3>
                    <small>{{ $stats['meja_terfavorit_count'] }} booking</small>
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

// Initialize chart with daily data
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dailyData.map(item => item.date),
            datasets: [{
                label: 'Penghasilan (Rp)',
                data: dailyData.map(item => item.revenue),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
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
    
    let labels, data;
    
    switch(period) {
        case 'daily':
            labels = dailyData.map(item => item.date);
            data = dailyData.map(item => item.revenue);
            break;
        case 'weekly':
            labels = weeklyData.map(item => item.week);
            data = weeklyData.map(item => item.revenue);
            break;
        case 'monthly':
            labels = monthlyData.map(item => item.month);
            data = monthlyData.map(item => item.revenue);
            break;
        case 'yearly':
            labels = yearlyData.map(item => item.year);
            data = yearlyData.map(item => item.revenue);
            break;
    }
    
    // Update chart
    revenueChart.data.labels = labels;
    revenueChart.data.datasets[0].data = data;
    revenueChart.update();
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
    background-color: #198754;
    color: white;
    border-color: #198754;
}
</style>
@endpush