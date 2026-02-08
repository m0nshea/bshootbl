@extends('layouts.app2')

@section('content')
<div class="content-wrapper">
  <div class="container-fluid">

    <!-- Breadcrumb -->
    <div class="breadcrumb-section mb-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-success">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Laporan</li>
        </ol>
      </nav>
    </div>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="page-title">Laporan</h2>
        <p class="page-subtitle">Kelola dan cetak laporan bisnis</p>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section" >
      <div class="row" style="padding: 5px;">
        <div class="col-md-3">
          <label class="form-label" style="margin-right: 5px;">Jenis Laporan</label>
          <select class="form-control" id="reportType" style="margin-right: 5px;">
            <option value="revenue" >Laporan Pendapatan</option>
            <option value="transaction">Laporan Transaksi</option>
            <option value="table">Laporan Meja</option>
            <option value="customer">Laporan Pelanggan</option>
          </select>
        </div>
        <div class="col-md-2" style="margin-right: 5px;">
          <label class="form-label">Dari Tanggal</label>
          <input type="date" class="form-control" id="startDate" value="2025-12-01">
        </div>
        <div class="col-md-2" style="margin-right: 5px;">
          <label class="form-label">Sampai Tanggal</label>
          <input type="date" class="form-control" id="endDate" value="2025-12-10">
        </div>
        <div class="col-md-2" style="margin-right: 5px;">
          <label class="form-label">Periode</label>
          <select class="form-control" id="period">
            <option value="daily">Harian</option>
            <option value="weekly">Mingguan</option>
            <option value="monthly">Bulanan</option>
            <option value="yearly">Tahunan</option>
          </select>
        </div>
        <div class="col-md-2" style="margin-right: 5px; margin-top: 30px;">
          <button class="btn btn-primary mb-2 w-100" onclick="generateReport()">Terapkan</button>
        </div>
        <div class="col-md-2">
          <label class="form-label">Unduh Laporan</label>
          <div class="d-flex gap-2 mt-2">
            <button class="btn btn-outline-success btn-sm px-2 py-1" onclick="exportExcel()">Excel</button>
            <button class="btn btn-outline-danger btn-sm px-2 py-1" onclick="exportPDF()">PDF</button>
            <button class="btn btn-outline-info btn-sm px-2 py-1" onclick="printReport()">Print</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart Section -->
    <div class="row"style="margin:5px;">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Grafik Laporan</h4>
          </div>
          <div class="card-body">
            <div class="chart-container">
              <canvas id="reportChart" width="400" height="350"></canvas>
              <noscript>
                <div style="text-align: center; padding: 50px; color: #666;">
                  <p>JavaScript diperlukan untuk menampilkan grafik</p>
                </div>
              </noscript>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Distribusi Meja</h4>
          </div>
          <div class="card-body">
            <div class="chart-container">
              <canvas id="pieChart" width="400" height="350"></canvas>
              <noscript>
                <div style="text-align: center; padding: 50px; color: #666;">
                  <p>JavaScript diperlukan untuk menampilkan grafik</p>
                </div>
              </noscript>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Data Table -->
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Detail Data Laporan</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="reportTable">
                <thead>
                  <tr id="tableHeader">
                    <th>Tanggal</th>
                    <th>Periode</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody id="tableBody">
                  <tr>
                    <td>10 Des 2025</td>
                    <td>Total Harian</td>
                    <td>Rp 850.000</td>
                  </tr>
                  <tr>
                    <td>09 Des 2025</td>
                    <td>Total Harian</td>
                    <td>Rp 700.000</td>
                  </tr>
                  <tr>
                    <td>08 Des 2025</td>
                    <td>Total Harian</td>
                    <td>Rp 550.000</td>
                  </tr>
                  <tr>
                    <td>07 Des 2025</td>
                    <td>Total Harian</td>
                    <td>Rp 650.000</td>
                  </tr>
                  <tr>
                    <td>06 Des 2025</td>
                    <td>Total Harian</td>
                    <td>Rp 900.000</td>
                  </tr>
                  <tr>
                    <td>05 Des 2025</td>
                    <td>Total Harian</td>
                    <td>Rp 750.000</td>
                  </tr>
                  <tr>
                    <td>04 Des 2025</td>
                    <td>Total Harian</td>
                    <td>Rp 800.000</td>
                  </tr>
                  <tr>
                    <td>03 Des 2025</td>
                    <td>Total Harian</td>
                    <td>Rp 350.000</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/adminLaporan.css') }}">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

<!-- COMPLETE ANIMATION REMOVAL -->
<style>
/* GLOBAL ANIMATION KILLER */
*, *::before, *::after, *:hover, *:focus, *:active, *:visited {
  -webkit-transition: none !important;
  -moz-transition: none !important;
  -o-transition: none !important;
  -ms-transition: none !important;
  transition: none !important;
  
  -webkit-transform: none !important;
  -moz-transform: none !important;
  -o-transform: none !important;
  -ms-transform: none !important;
  transform: none !important;
  
  -webkit-animation: none !important;
  -moz-animation: none !important;
  -o-animation: none !important;
  -ms-animation: none !important;
  animation: none !important;
  
  -webkit-animation-duration: 0s !important;
  -moz-animation-duration: 0s !important;
  -o-animation-duration: 0s !important;
  -ms-animation-duration: 0s !important;
  animation-duration: 0s !important;
  
  -webkit-animation-delay: 0s !important;
  -moz-animation-delay: 0s !important;
  -o-animation-delay: 0s !important;
  -ms-animation-delay: 0s !important;
  animation-delay: 0s !important;
  
  -webkit-transition-duration: 0s !important;
  -moz-transition-duration: 0s !important;
  -o-transition-duration: 0s !important;
  -ms-transition-duration: 0s !important;
  transition-duration: 0s !important;
  
  -webkit-transition-delay: 0s !important;
  -moz-transition-delay: 0s !important;
  -o-transition-delay: 0s !important;
  -ms-transition-delay: 0s !important;
  transition-delay: 0s !important;
}

/* CARD SPECIFIC OVERRIDES */
.card, .card-body, .card-header, .card-footer {
  box-shadow: 0 2px 10px rgba(0,0,0,0.08) !important;
  transition: none !important;
  transform: none !important;
  animation: none !important;
  width: auto !important;
  height: auto !important;
}

.card:hover, .card:focus, .card:active {
  box-shadow: 0 2px 10px rgba(0,0,0,0.08) !important;
  transition: none !important;
  transform: none !important;
  animation: none !important;
  width: auto !important;
  height: auto !important;
}

/* CHART CONTAINER FIXES */
.chart-container {
  width: 100% !important;
  height: 400px !important;
  position: relative !important;
  transition: none !important;
  transform: none !important;
  animation: none !important;
}

canvas {
  width: 100% !important;
  height: 100% !important;
  max-width: 100% !important;
  max-height: 100% !important;
  transition: none !important;
  transform: none !important;
  animation: none !important;
}

/* ROW AND COLUMN FIXES */
.row, .col-md-8, .col-md-4, .col-12 {
  transition: none !important;
  transform: none !important;
  animation: none !important;
}

/* BOOTSTRAP OVERRIDE */
.fade, .collapse, .collapsing {
  transition: none !important;
  animation: none !important;
}
</style>
@endpush

@push('scripts')
<!-- Chart.js CDN - Load first -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Wait for jQuery to be available (loaded from app2.blade.php)
function waitForJQuery(callback) {
    if (typeof $ !== 'undefined') {
        callback();
    } else {
        setTimeout(function() {
            waitForJQuery(callback);
        }, 100);
    }
}

// Initialize everything when both jQuery and Chart.js are ready
waitForJQuery(function() {
    $(document).ready(function() {
        console.log('jQuery and DOM ready - starting initialization...');
        
        // Check Chart.js availability
        if (typeof Chart === 'undefined') {
            console.error('Chart.js not loaded!');
            showChartError();
            return;
        }
        console.log('Chart.js loaded successfully');
        
        // Initialize charts immediately
        initCharts();
        
        // Initialize DataTable
        try {
            $('#reportTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir", 
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
            console.log('DataTable initialized successfully');
        } catch (error) {
            console.error('DataTable initialization error:', error);
        }
    });
});

function initCharts() {
    console.log('Starting chart initialization...');
    
    try {
        // Main Chart - Line Chart untuk Grafik Laporan
        const ctx1 = document.getElementById('reportChart');
        if (ctx1) {
            console.log('Creating main chart...');
            
            // Destroy existing chart if exists
            if (ctx1.chart) {
                ctx1.chart.destroy();
            }
            
            const mainChart = new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: ['1 Des', '2 Des', '3 Des', '4 Des', '5 Des', '6 Des', '7 Des', '8 Des', '9 Des', '10 Des'],
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: [450000, 600000, 350000, 800000, 750000, 900000, 650000, 550000, 700000, 850000],
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#28a745',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 6
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
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#28a745',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    return 'Pendapatan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.1)',
                                drawBorder: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + (value/1000) + 'K';
                                },
                                font: {
                                    size: 11
                                }
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0,0,0,0.1)',
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    animation: false
                }
            });
            
            // Store chart reference
            ctx1.chart = mainChart;
            console.log('Main chart created successfully');
        } else {
            console.error('Main chart canvas not found');
        }

        // Pie Chart - Doughnut Chart untuk Distribusi Meja
        const ctx2 = document.getElementById('pieChart');
        if (ctx2) {
            console.log('Creating pie chart...');
            
            // Destroy existing chart if exists
            if (ctx2.chart) {
                ctx2.chart.destroy();
            }
            
            const pieChart = new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: ['Meja A', 'Meja B', 'Meja VIP'],
                    datasets: [{
                        data: [45, 35, 65],
                        backgroundColor: ['#007bff', '#28a745', '#ffc107'],
                        borderWidth: 4,
                        borderColor: '#fff',
                        hoverBorderWidth: 4,
                        hoverOffset: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    size: 12
                                },
                                generateLabels: function(chart) {
                                    const data = chart.data;
                                    if (data.labels.length && data.datasets.length) {
                                        return data.labels.map((label, i) => {
                                            const dataset = data.datasets[0];
                                            const value = dataset.data[i];
                                            const total = dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = Math.round((value / total) * 100);
                                            
                                            return {
                                                text: `${label}: ${percentage}%`,
                                                fillStyle: dataset.backgroundColor[i],
                                                strokeStyle: dataset.borderColor,
                                                lineWidth: dataset.borderWidth,
                                                pointStyle: 'circle',
                                                hidden: false,
                                                index: i
                                            };
                                        });
                                    }
                                    return [];
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${percentage}% (${value} meja)`;
                                }
                            }
                        }
                    },
                    animation: false
                }
            });
            
            // Store chart reference
            ctx2.chart = pieChart;
            console.log('Pie chart created successfully');
        } else {
            console.error('Pie chart canvas not found');
        }
        
        console.log('All charts initialized successfully!');
        
    } catch (error) {
        console.error('Error creating charts:', error);
        showChartError();
    }
}

function showChartError() {
    console.log('Showing chart error message...');
    document.querySelectorAll('.chart-container').forEach(function(container) {
        container.innerHTML = `
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 300px; color: #666; text-align: center;">
                <i class="fas fa-exclamation-triangle" style="font-size: 3rem; margin-bottom: 15px; color: #dc3545;"></i>
                <h5>Grafik Tidak Dapat Dimuat</h5>
                <p>Silakan refresh halaman atau periksa console untuk detail error</p>
                <button onclick="location.reload()" class="btn btn-primary btn-sm mt-2">Refresh Halaman</button>
            </div>
        `;
    });
}

function generateReport() {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'success',
            title: 'Laporan Berhasil Dibuat!',
            text: 'Data laporan telah diperbarui.',
            timer: 1500,
            showConfirmButton: false
        });
    } else {
        alert('Laporan berhasil dibuat!');
    }
}

function exportExcel() {
    if (typeof Swal !== 'undefined') {
        Swal.fire('Info', 'Export Excel akan segera tersedia', 'info');
    } else {
        alert('Export Excel akan segera tersedia');
    }
}

function exportPDF() {
    if (typeof Swal !== 'undefined') {
        Swal.fire('Info', 'Export PDF akan segera tersedia', 'info');
    } else {
        alert('Export PDF akan segera tersedia');
    }
}

function printReport() {
    window.print();
}

// Backup initialization on window load
window.addEventListener('load', function() {
    console.log('Window loaded - backup chart initialization...');
    setTimeout(function() {
        const canvas1 = document.getElementById('reportChart');
        const canvas2 = document.getElementById('pieChart');
        
        if ((canvas1 && !canvas1.chart) || (canvas2 && !canvas2.chart)) {
            console.log('Charts not found, trying to initialize again...');
            initCharts();
        }
    }, 1000);
    
    // Force disable all animations on cards
    setTimeout(function() {
        // Add global CSS to disable all animations
        const style = document.createElement('style');
        style.textContent = `
            *, *:before, *:after, *:hover, *:focus, *:active {
                -webkit-transition: none !important;
                -moz-transition: none !important;
                -o-transition: none !important;
                transition: none !important;
                -webkit-transform: none !important;
                -moz-transform: none !important;
                -o-transform: none !important;
                transform: none !important;
                -webkit-animation: none !important;
                -moz-animation: none !important;
                -o-animation: none !important;
                animation: none !important;
                -webkit-animation-duration: 0s !important;
                -moz-animation-duration: 0s !important;
                -o-animation-duration: 0s !important;
                animation-duration: 0s !important;
                -webkit-transition-duration: 0s !important;
                -moz-transition-duration: 0s !important;
                -o-transition-duration: 0s !important;
                transition-duration: 0s !important;
            }
            
            .card, .card:hover, .card:focus, .card:active {
                box-shadow: 0 2px 10px rgba(0,0,0,0.08) !important;
                transition: none !important;
                transform: none !important;
                animation: none !important;
                width: auto !important;
                height: auto !important;
            }
            
            .chart-container {
                width: 100% !important;
                height: 400px !important;
                min-width: 100% !important;
                position: relative !important;
            }
            
            canvas {
                width: 100% !important;
                height: 100% !important;
                max-width: 100% !important;
                max-height: 100% !important;
            }
        `;
        document.head.appendChild(style);
        
        // Remove all transitions and animations from everything
        const allElements = document.querySelectorAll('*');
        allElements.forEach(function(element) {
            element.style.setProperty('transition', 'none', 'important');
            element.style.setProperty('transform', 'none', 'important');
            element.style.setProperty('animation', 'none', 'important');
            element.style.setProperty('-webkit-transition', 'none', 'important');
            element.style.setProperty('-moz-transition', 'none', 'important');
            element.style.setProperty('-o-transition', 'none', 'important');
            element.style.setProperty('-webkit-transform', 'none', 'important');
            element.style.setProperty('-moz-transform', 'none', 'important');
            element.style.setProperty('-o-transform', 'none', 'important');
            element.style.setProperty('-webkit-animation', 'none', 'important');
            element.style.setProperty('-moz-animation', 'none', 'important');
            element.style.setProperty('-o-animation', 'none', 'important');
            element.style.setProperty('animation-duration', '0s', 'important');
            element.style.setProperty('transition-duration', '0s', 'important');
        });
        
        console.log('All animations completely disabled');
    }, 50);
});
</script>
@endpush