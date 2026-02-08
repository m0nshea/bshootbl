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
          <input type="date" class="form-control" id="startDate" value="">
        </div>
        <div class="col-md-2" style="margin-right: 5px;">
          <label class="form-label">Sampai Tanggal</label>
          <input type="date" class="form-control" id="endDate" value="">
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
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">
              <i class="fas fa-chart-line me-2"></i>Grafik Penghasilan
            </h5>
          </div>
          <div class="card-body">
            <div class="chart-container">
              <canvas id="reportChart"></canvas>
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
                    <td colspan="3" class="text-center text-muted py-4">
                      <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                      <p class="mb-0">Tidak ada data transaksi</p>
                      <small>Data akan muncul setelah ada transaksi baru dengan status pembayaran "Dibayar"</small>
                    </td>
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

/* CARD STYLING - SAMA SEPERTI DASHBOARD */
.card-header {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border-bottom: 1px solid #dee2e6;
  border-radius: 15px 15px 0 0 !important;
}

.card-title {
  color: #495057;
  font-weight: 600;
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
    height: 300px !important;
  }
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
        // Main Chart - Line Chart untuk Grafik Penghasilan (sama seperti dashboard)
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
                    labels: [],
                    datasets: [{
                        label: 'Penghasilan',
                        data: [],
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
                                    if (value >= 1000000) {
                                        return 'Rp ' + (value / 1000000).toFixed(1) + 'Jt';
                                    } else if (value >= 1000) {
                                        return 'Rp ' + (value / 1000).toFixed(0) + 'rb';
                                    } else {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
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
            
            // Store chart reference
            ctx1.chart = mainChart;
            console.log('Main chart created successfully');
        } else {
            console.error('Main chart canvas not found');
        }
        
        console.log('Chart initialized successfully!');
        
    } catch (error) {
        console.error('Error creating charts:', error);
        showChartError();
    }
}

// Function to switch between different time periods (sama seperti dashboard)
function showStats(period, button) {
    // Update active button
    document.querySelectorAll('.btn-group button').forEach(btn => {
        btn.classList.remove('active');
    });
    if (button) {
        button.classList.add('active');
    }
    
    // Data kosong untuk sekarang (nanti akan diisi dari backend)
    let labels = [];
    let data = [];
    let chartLabel = '';
    
    switch(period) {
        case 'daily':
            chartLabel = 'Penghasilan Harian';
            break;
        case 'weekly':
            chartLabel = 'Penghasilan Mingguan';
            break;
        case 'monthly':
            chartLabel = 'Penghasilan Bulanan';
            break;
        case 'yearly':
            chartLabel = 'Penghasilan Tahunan';
            break;
    }
    
    const ctx = document.getElementById('reportChart');
    if (ctx && ctx.chart) {
        // Update chart
        ctx.chart.data.labels = labels;
        ctx.chart.data.datasets[0].data = data;
        ctx.chart.data.datasets[0].label = chartLabel;
        
        // Update chart colors based on period
        const colors = {
            daily: { border: '#28a745', bg: 'rgba(40, 167, 69, 0.1)' },
            weekly: { border: '#17a2b8', bg: 'rgba(23, 162, 184, 0.1)' },
            monthly: { border: '#ffc107', bg: 'rgba(255, 193, 7, 0.1)' },
            yearly: { border: '#dc3545', bg: 'rgba(220, 53, 69, 0.1)' }
        };
        
        ctx.chart.data.datasets[0].borderColor = colors[period].border;
        ctx.chart.data.datasets[0].backgroundColor = colors[period].bg;
        ctx.chart.data.datasets[0].pointBackgroundColor = colors[period].border;
        ctx.chart.data.datasets[0].pointHoverBackgroundColor = colors[period].border;
        
        ctx.chart.update('active');
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
    const reportType = document.getElementById('reportType').value;
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const period = document.getElementById('period').value;

    if (!startDate || !endDate) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Silakan pilih tanggal mulai dan tanggal akhir'
            });
        } else {
            alert('Silakan pilih tanggal mulai dan tanggal akhir');
        }
        return;
    }

    // Show loading
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Memuat Laporan...',
            html: 'Mohon tunggu, sedang mengambil data laporan',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    // Fetch report data
    fetch('{{ route("admin.laporan.data") }}?' + new URLSearchParams({
        type: reportType,
        start_date: startDate,
        end_date: endDate,
        period: period
    }), {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update chart with new data
            updateChart(data.data, period);
            
            // Update table with new data
            updateTable(data.data, reportType);
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Laporan Berhasil Dibuat!',
                    text: 'Data laporan telah diperbarui.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        } else {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message || 'Gagal mengambil data laporan'
                });
            } else {
                alert('Gagal mengambil data laporan');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat mengambil data'
            });
        } else {
            alert('Terjadi kesalahan saat mengambil data');
        }
    });
}

function updateChart(data, period) {
    const ctx = document.getElementById('reportChart');
    if (ctx && ctx.chart) {
        // Convert data object to arrays
        const labels = Object.keys(data);
        const values = Object.values(data).map(item => item.total || 0);
        
        // Update chart
        ctx.chart.data.labels = labels;
        ctx.chart.data.datasets[0].data = values;
        
        // Update label based on period
        const periodLabels = {
            daily: 'Penghasilan Harian',
            weekly: 'Penghasilan Mingguan',
            monthly: 'Penghasilan Bulanan',
            yearly: 'Penghasilan Tahunan'
        };
        ctx.chart.data.datasets[0].label = periodLabels[period] || 'Penghasilan';
        
        ctx.chart.update();
    }
}

function updateTable(data, reportType) {
    const tableBody = document.getElementById('tableBody');
    if (!tableBody) return;
    
    // Clear existing rows
    tableBody.innerHTML = '';
    
    if (Object.keys(data).length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="3" class="text-center text-muted py-4">
                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                    <p class="mb-0">Tidak ada data untuk periode yang dipilih</p>
                </td>
            </tr>
        `;
        return;
    }
    
    // Add new rows
    Object.entries(data).forEach(([key, value]) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${key}</td>
            <td>Total ${document.getElementById('period').options[document.getElementById('period').selectedIndex].text}</td>
            <td>Rp ${value.total.toLocaleString('id-ID')}</td>
        `;
        tableBody.appendChild(row);
    });
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

// Reset all data function
function resetAllData() {
    Swal.fire({
        title: 'Reset Data Laporan?',
        html: `
            <div style="text-align: left; padding: 10px;">
                <p style="margin-bottom: 15px;"><strong>⚠️ PERINGATAN:</strong></p>
                <p style="margin-bottom: 10px;">Tindakan ini akan:</p>
                <ul style="text-align: left; margin-left: 20px;">
                    <li>Menghapus SEMUA data transaksi</li>
                    <li>Mereset semua laporan menjadi 0</li>
                    <li>Mereset status meja menjadi tersedia</li>
                    <li><strong>Data tidak dapat dikembalikan!</strong></li>
                </ul>
                <p style="margin-top: 15px; color: #dc3545;"><strong>Apakah Anda yakin ingin melanjutkan?</strong></p>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Reset Semua Data!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Mereset Data...',
                html: 'Mohon tunggu, sedang mereset semua data transaksi',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Send reset request
            fetch('{{ route("admin.laporan.reset") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        html: `
                            <div style="text-align: center;">
                                <p style="margin-bottom: 10px;">${data.message}</p>
                                <p style="color: #28a745; font-weight: bold;">✓ Semua data transaksi telah dihapus</p>
                                <p style="color: #28a745; font-weight: bold;">✓ Laporan direset menjadi 0</p>
                                <p style="color: #28a745; font-weight: bold;">✓ Status meja direset</p>
                            </div>
                        `,
                        confirmButtonColor: '#28a745',
                        timer: 3000
                    }).then(() => {
                        // Reload page to show empty data
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message || 'Terjadi kesalahan saat mereset data',
                        confirmButtonColor: '#dc3545'
                    });
                }
            })
            .catch(error => {
                console.error('Reset error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat mereset data. Silakan coba lagi.',
                    confirmButtonColor: '#dc3545'
                });
            });
        }
    });
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