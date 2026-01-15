// Admin Laporan JavaScript Functions

// Data sample untuk laporan
const reportData = {
    revenue: {
        labels: ['1 Des', '2 Des', '3 Des', '4 Des', '5 Des', '6 Des', '7 Des', '8 Des', '9 Des', '10 Des'],
        data: [450000, 600000, 350000, 800000, 750000, 900000, 650000, 550000, 700000, 850000],
        tableData: [
            ['10 Des 2025', 'Total Harian', 'Rp 850.000', '<span class="badge bg-success">Selesai</span>'],
            ['09 Des 2025', 'Total Harian', 'Rp 700.000', '<span class="badge bg-success">Selesai</span>'],
            ['08 Des 2025', 'Total Harian', 'Rp 550.000', '<span class="badge bg-success">Selesai</span>'],
            ['07 Des 2025', 'Total Harian', 'Rp 650.000', '<span class="badge bg-success">Selesai</span>'],
            ['06 Des 2025', 'Total Harian', 'Rp 900.000', '<span class="badge bg-success">Selesai</span>']
        ]
    },
    transaction: {
        labels: ['Lunas', 'Pending', 'Dibatalkan'],
        data: [85, 12, 3],
        tableData: [
            ['10 Des 2025', 'Harian', 'Rp 1.200.000', '<span class="badge bg-success">Selesai</span>'],
            ['09 Des 2025', 'Harian', 'Rp 950.000', '<span class="badge bg-success">Selesai</span>'],
            ['08 Des 2025', 'Harian', 'Rp 1.100.000', '<span class="badge bg-warning">Pending</span>'],
            ['07 Des 2025', 'Harian', 'Rp 800.000', '<span class="badge bg-success">Selesai</span>']
        ]
    },
    table: {
        labels: ['Meja A', 'Meja B', 'Meja VIP'],
        data: [45, 35, 65],
        tableData: [
            ['10 Des 2025', 'Harian', 'Rp 1.200.000', '<span class="badge bg-success">Tersedia</span>'],
            ['09 Des 2025', 'Harian', 'Rp 950.000', '<span class="badge bg-success">Tersedia</span>'],
            ['08 Des 2025', 'Harian', 'Rp 1.100.000', '<span class="badge bg-danger">Penuh</span>'],
            ['07 Des 2025', 'Harian', 'Rp 800.000', '<span class="badge bg-success">Tersedia</span>']
        ]
    },
    customer: {
        labels: ['Pelanggan Baru', 'Pelanggan Lama'],
        data: [25, 75],
        tableData: [
            ['10 Des 2025', 'Harian', 'Rp 1.200.000', '<span class="badge bg-success">Aktif</span>'],
            ['09 Des 2025', 'Harian', 'Rp 950.000', '<span class="badge bg-success">Aktif</span>'],
            ['08 Des 2025', 'Harian', 'Rp 1.100.000', '<span class="badge bg-warning">Tidak Aktif</span>'],
            ['07 Des 2025', 'Harian', 'Rp 800.000', '<span class="badge bg-success">Aktif</span>']
        ]
    }
};

let currentChart = null;
let currentPieChart = null;
let currentTable = null;

// Initialize page
$(document).ready(function() {
    console.log('Document ready - initializing charts...');
    
    // Check if Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded!');
        return;
    }
    
    // Check if canvas elements exist
    const mainCanvas = document.getElementById('reportChart');
    const pieCanvas = document.getElementById('pieChart');
    
    if (!mainCanvas) {
        console.error('Main chart canvas not found!');
        return;
    }
    
    if (!pieCanvas) {
        console.error('Pie chart canvas not found!');
        return;
    }
    
    console.log('Canvas elements found, initializing charts...');
    
    try {
        initializeCharts();
        initializeTable();
        generateReport();
        console.log('Charts initialized successfully!');
    } catch (error) {
        console.error('Error initializing charts:', error);
    }

    // Sidebar toggle functionality
    $('.sidebar-toggle').click(function() {
        $('#sidebar').toggleClass('show');
    });

    // Close sidebar when clicking outside on mobile
    $(document).click(function(e) {
        if ($(window).width() <= 768) {
            if (!$(e.target).closest('#sidebar, .sidebar-toggle').length) {
                $('#sidebar').removeClass('show');
            }
        }
    });

    // Add animation on page load
    $('.card').each(function(index) {
        $(this).delay(index * 100).fadeIn(600);
    });

    // Date range validation
    $('#startDate, #endDate').change(function() {
        validateDateRange();
    });
});

// Initialize charts
function initializeCharts() {
    try {
        console.log('Initializing main chart...');
        
        // Main chart
        const ctx = document.getElementById('reportChart').getContext('2d');
        currentChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: reportData.revenue.labels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: reportData.revenue.data,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#28a745',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5
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
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#28a745',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    }
                }
            }
        });
        
        console.log('Main chart created successfully');

        console.log('Initializing pie chart...');
        
        // Pie chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        currentPieChart = new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: reportData.table.labels,
                datasets: [{
                    data: reportData.table.data,
                    backgroundColor: ['#007bff', '#28a745', '#ffc107'],
                    borderWidth: 3,
                    borderColor: '#fff',
                    hoverBorderWidth: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff'
                    }
                }
            }
        });
        
        console.log('Pie chart created successfully');
        
    } catch (error) {
        console.error('Error creating charts:', error);
        
        // Show error message in chart containers
        $('#reportChart').closest('.chart-container').html(`
            <div class="chart-error">
                <i class="fas fa-exclamation-triangle"></i>
                <h5>Chart Tidak Dapat Dimuat</h5>
                <p>Terjadi kesalahan saat memuat grafik.<br>
                Silakan refresh halaman atau hubungi administrator.</p>
            </div>
        `);
        
        $('#pieChart').closest('.chart-container').html(`
            <div class="chart-error">
                <i class="fas fa-chart-pie"></i>
                <h5>Pie Chart Tidak Tersedia</h5>
                <p>Grafik distribusi tidak dapat dimuat saat ini.</p>
            </div>
        `);
    }
}

// Initialize DataTable
function initializeTable() {
    currentTable = $('#reportTable').DataTable({
        responsive: true,
        pageLength: 10,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-success btn-sm',
                title: 'Laporan Bshoot Billiard'
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-danger btn-sm',
                title: 'Laporan Bshoot Billiard'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'btn btn-info btn-sm',
                title: 'Laporan Bshoot Billiard'
            }
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            },
            emptyTable: "Tidak ada data laporan",
            zeroRecords: "Tidak ditemukan data yang sesuai"
        }
    });
}

// Generate report
function generateReport() {
    const reportType = document.getElementById('reportType').value;
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const period = document.getElementById('period').value;

    // Validate date range
    if (!validateDateRange()) {
        return;
    }

    // Show loading
    showLoading();

    // Simulate API call delay
    setTimeout(() => {
        const data = reportData[reportType];

        // Update main chart
        updateMainChart(reportType, data);

        // Update pie chart
        updatePieChart(reportType, data);

        // Update table
        updateTable(reportType, data);

        // Update summary
        updateSummary(reportType);

        // Hide loading and show success
        hideLoading();
        
        Swal.fire({
            icon: 'success',
            title: 'Laporan Berhasil Dibuat!',
            text: 'Data laporan telah diperbarui.',
            timer: 1500,
            showConfirmButton: false
        });
    }, 1000);
}

// Update main chart
function updateMainChart(reportType, data) {
    if (reportType === 'revenue') {
        currentChart.data.labels = data.labels;
        currentChart.data.datasets[0].data = data.data;
        currentChart.data.datasets[0].label = 'Pendapatan (Rp)';
        currentChart.data.datasets[0].borderColor = '#28a745';
        currentChart.data.datasets[0].backgroundColor = 'rgba(40, 167, 69, 0.1)';
        currentChart.options.scales.y.ticks.callback = function(value) {
            return 'Rp ' + value.toLocaleString('id-ID');
        };
    } else if (reportType === 'transaction') {
        currentChart.data.labels = data.labels;
        currentChart.data.datasets[0].data = data.data;
        currentChart.data.datasets[0].label = 'Jumlah Transaksi';
        currentChart.data.datasets[0].borderColor = '#007bff';
        currentChart.data.datasets[0].backgroundColor = 'rgba(0, 123, 255, 0.1)';
        currentChart.options.scales.y.ticks.callback = function(value) {
            return value;
        };
    } else if (reportType === 'table') {
        currentChart.data.labels = data.labels;
        currentChart.data.datasets[0].data = data.data;
        currentChart.data.datasets[0].label = 'Okupansi Meja (%)';
        currentChart.data.datasets[0].borderColor = '#ffc107';
        currentChart.data.datasets[0].backgroundColor = 'rgba(255, 193, 7, 0.1)';
        currentChart.options.scales.y.ticks.callback = function(value) {
            return value + '%';
        };
    } else if (reportType === 'customer') {
        currentChart.data.labels = data.labels;
        currentChart.data.datasets[0].data = data.data;
        currentChart.data.datasets[0].label = 'Jumlah Pelanggan';
        currentChart.data.datasets[0].borderColor = '#17a2b8';
        currentChart.data.datasets[0].backgroundColor = 'rgba(23, 162, 184, 0.1)';
        currentChart.options.scales.y.ticks.callback = function(value) {
            return value;
        };
    }

    currentChart.update('active');
}

// Update pie chart
function updatePieChart(reportType, data) {
    if (reportType === 'table') {
        currentPieChart.data.labels = data.labels;
        currentPieChart.data.datasets[0].data = data.data;
        currentPieChart.data.datasets[0].backgroundColor = ['#007bff', '#28a745', '#ffc107'];
    } else if (reportType === 'customer') {
        currentPieChart.data.labels = data.labels;
        currentPieChart.data.datasets[0].data = data.data;
        currentPieChart.data.datasets[0].backgroundColor = ['#17a2b8', '#6c757d'];
    } else if (reportType === 'transaction') {
        currentPieChart.data.labels = data.labels;
        currentPieChart.data.datasets[0].data = data.data;
        currentPieChart.data.datasets[0].backgroundColor = ['#28a745', '#ffc107', '#dc3545'];
    } else {
        // Default for revenue
        currentPieChart.data.labels = ['Pendapatan Harian', 'Target'];
        currentPieChart.data.datasets[0].data = [75, 25];
        currentPieChart.data.datasets[0].backgroundColor = ['#28a745', '#e9ecef'];
    }

    currentPieChart.update('active');
}

// Update table data
function updateTable(reportType, data) {
    // Clear existing data
    currentTable.clear();

    // Add new data based on report type
    let tableData = [];
    
    switch(reportType) {
        case 'revenue':
            tableData = [
                ['10 Des 2025', 'Total Harian', 'Rp 850.000', '<span class="badge bg-success">Selesai</span>'],
                ['09 Des 2025', 'Total Harian', 'Rp 700.000', '<span class="badge bg-success">Selesai</span>'],
                ['08 Des 2025', 'Total Harian', 'Rp 550.000', '<span class="badge bg-success">Selesai</span>'],
                ['07 Des 2025', 'Total Harian', 'Rp 650.000', '<span class="badge bg-warning">Pending</span>'],
                ['06 Des 2025', 'Total Harian', 'Rp 900.000', '<span class="badge bg-success">Selesai</span>'],
                ['05 Des 2025', 'Total Harian', 'Rp 750.000', '<span class="badge bg-success">Selesai</span>'],
                ['04 Des 2025', 'Total Harian', 'Rp 800.000', '<span class="badge bg-success">Selesai</span>'],
                ['03 Des 2025', 'Total Harian', 'Rp 350.000', '<span class="badge bg-danger">Dibatalkan</span>']
            ];
            break;
        case 'transaction':
            tableData = [
                ['10 Des 2025', 'INV-001', 'Rp 400.000', '<span class="badge bg-success">Lunas</span>'],
                ['10 Des 2025', 'INV-002', 'Rp 300.000', '<span class="badge bg-warning">Pending</span>'],
                ['09 Des 2025', 'INV-003', 'Rp 150.000', '<span class="badge bg-success">Lunas</span>'],
                ['09 Des 2025', 'INV-004', 'Rp 800.000', '<span class="badge bg-success">Lunas</span>'],
                ['08 Des 2025', 'INV-005', 'Rp 200.000', '<span class="badge bg-success">Lunas</span>'],
                ['08 Des 2025', 'INV-006', 'Rp 350.000', '<span class="badge bg-danger">Dibatalkan</span>'],
                ['07 Des 2025', 'INV-007', 'Rp 450.000', '<span class="badge bg-success">Lunas</span>'],
                ['07 Des 2025', 'INV-008', 'Rp 200.000', '<span class="badge bg-warning">Pending</span>']
            ];
            break;
        case 'table':
            tableData = [
                ['Meja VIP 1', '85% Okupansi', 'Rp 2.500.000', '<span class="badge bg-success">Tersedia</span>'],
                ['Meja A', '65% Okupansi', 'Rp 1.800.000', '<span class="badge bg-success">Tersedia</span>'],
                ['Meja B', '45% Okupansi', 'Rp 1.200.000', '<span class="badge bg-danger">Penuh</span>'],
                ['Meja VIP 2', '75% Okupansi', 'Rp 2.200.000', '<span class="badge bg-success">Tersedia</span>'],
                ['Meja C', '55% Okupansi', 'Rp 1.500.000', '<span class="badge bg-warning">Maintenance</span>'],
                ['Meja D', '40% Okupansi', 'Rp 1.000.000', '<span class="badge bg-success">Tersedia</span>']
            ];
            break;
        case 'customer':
            tableData = [
                ['Haikal Qurnia', '8 Kunjungan', 'Rp 3.200.000', '<span class="badge bg-success">VIP</span>'],
                ['Humairoah', '5 Kunjungan', 'Rp 2.000.000', '<span class="badge bg-info">Regular</span>'],
                ['Robi', '3 Kunjungan', 'Rp 900.000', '<span class="badge bg-info">Regular</span>'],
                ['Aca', '6 Kunjungan', 'Rp 2.400.000', '<span class="badge bg-success">VIP</span>'],
                ['Budi', '2 Kunjungan', 'Rp 600.000', '<span class="badge bg-secondary">Baru</span>'],
                ['Sari', '4 Kunjungan', 'Rp 1.600.000', '<span class="badge bg-info">Regular</span>']
            ];
            break;
        default:
            tableData = data.tableData || [];
    }

    // Add new data
    tableData.forEach(row => {
        currentTable.row.add(row);
    });

    currentTable.draw();
}

// Update summary cards
function updateSummary(reportType) {
    const summaries = {
        revenue: ['Rp 8.500.000', '125', '85%', '45'],
        transaction: ['125', 'Rp 8.500.000', '85%', '12'],
        table: ['3', '85%', '60', 'VIP'],
        customer: ['45', '25', '75%', '8.5']
    };

    const labels = {
        revenue: ['Total Pendapatan', 'Total Transaksi', 'Tingkat Okupansi', 'Pelanggan Aktif'],
        transaction: ['Total Transaksi', 'Total Pendapatan', 'Tingkat Sukses', 'Pending'],
        table: ['Total Meja', 'Rata-rata Okupansi', 'Total Booking', 'Meja Terfavorit'],
        customer: ['Total Pelanggan', 'Pelanggan Baru', 'Pelanggan Lama (%)', 'Rata-rata Kunjungan']
    };

    const values = summaries[reportType];
    const labelTexts = labels[reportType];

    for (let i = 1; i <= 4; i++) {
        const valueElement = document.getElementById(`summaryValue${i}`);
        const labelElement = valueElement.nextElementSibling;
        
        // Animate value change
        $(valueElement).fadeOut(200, function() {
            $(this).text(values[i-1]).fadeIn(200);
        });
        
        $(labelElement).fadeOut(200, function() {
            $(this).text(labelTexts[i-1]).fadeIn(200);
        });
    }
}

// Validate date range
function validateDateRange() {
    const startDate = new Date(document.getElementById('startDate').value);
    const endDate = new Date(document.getElementById('endDate').value);

    if (startDate > endDate) {
        Swal.fire({
            icon: 'error',
            title: 'Tanggal Tidak Valid',
            text: 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir.',
            confirmButtonText: 'OK'
        });
        return false;
    }

    const diffTime = Math.abs(endDate - startDate);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    if (diffDays > 365) {
        Swal.fire({
            icon: 'warning',
            title: 'Rentang Tanggal Terlalu Lama',
            text: 'Rentang tanggal maksimal 1 tahun.',
            confirmButtonText: 'OK'
        });
        return false;
    }

    return true;
}

// Show loading
function showLoading() {
    $('.chart-container').html('<div class="chart-loading"><i class="fas fa-spinner fa-spin me-2"></i>Memuat data...</div>');
    $('.summary-value').html('<i class="fas fa-spinner fa-spin"></i>');
}

// Hide loading
function hideLoading() {
    // Charts will be redrawn by update functions
    // Summary values will be updated by updateSummary function
}

// Export functions
function exportExcel() {
    currentTable.button('.buttons-excel').trigger();
}

function exportPDF() {
    currentTable.button('.buttons-pdf').trigger();
}

function printReport() {
    currentTable.button('.buttons-print').trigger();
}

// Advanced filter functions
function filterByDateRange(start, end) {
    // Implement date range filtering
    console.log('Filtering by date range:', start, 'to', end);
}

function filterByPeriod(period) {
    // Implement period filtering
    console.log('Filtering by period:', period);
}

// Auto refresh functionality
function enableAutoRefresh(interval = 300000) { // 5 minutes default
    setInterval(function() {
        generateReport();
    }, interval);
}

// Real-time data update simulation
function simulateRealTimeUpdate() {
    setInterval(function() {
        // Simulate random data updates
        const reportType = document.getElementById('reportType').value;
        const data = reportData[reportType];
        
        // Add some randomness to the data
        if (data.data && Array.isArray(data.data)) {
            data.data = data.data.map(value => {
                const variation = Math.random() * 0.1 - 0.05; // ±5% variation
                return Math.round(value * (1 + variation));
            });
        }
        
        updateMainChart(reportType, data);
        updatePieChart(reportType, data);
    }, 30000); // Update every 30 seconds
}

// Initialize real-time updates (optional)
// simulateRealTimeUpdate();

// Keyboard shortcuts
$(document).keydown(function(e) {
    // Ctrl+G to generate report
    if (e.ctrlKey && e.keyCode === 71) {
        e.preventDefault();
        generateReport();
    }
    
    // Ctrl+E to export Excel
    if (e.ctrlKey && e.keyCode === 69) {
        e.preventDefault();
        exportExcel();
    }
    
    // Ctrl+P to print
    if (e.ctrlKey && e.keyCode === 80) {
        e.preventDefault();
        printReport();
    }
});