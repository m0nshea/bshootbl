// Admin Transaksi JavaScript Functions

$(document).ready(function () {
    // Initialize DataTable
    $("#datatable").DataTable({
        responsive: true,
        pageLength: 10,
        order: [[0, 'desc']], // Sort by No column descending (newest first)
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
            emptyTable: "Tidak ada data transaksi",
            zeroRecords: "Tidak ditemukan data yang sesuai"
        },
        columnDefs: [
            { orderable: false, targets: [7] } // Disable sorting for action column
        ]
    });

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
    $('.stats-card').each(function(index) {
        $(this).delay(index * 100).fadeIn(500);
    });
    $('.card').delay(400).fadeIn(800);

    // Status badge hover effects
    $('.status-badge').hover(
        function() {
            $(this).css('transform', 'scale(1.05)');
        },
        function() {
            $(this).css('transform', 'scale(1)');
        }
    );

    // Invoice code hover effects
    $('.invoice-code').hover(
        function() {
            $(this).css({
                'background': '#e9ecef',
                'border-color': '#adb5bd'
            });
        },
        function() {
            $(this).css({
                'background': '#f8f9fa',
                'border-color': '#dee2e6'
            });
        }
    );

    // Amount text animation
    $('.amount-text').each(function() {
        $(this).hover(
            function() {
                $(this).css('transform', 'scale(1.05)');
            },
            function() {
                $(this).css('transform', 'scale(1)');
            }
        );
    });
});

// View transaction detail function
function viewTransactionDetail(id) {
    // Redirect to detail page
    window.location.href = `/admin/transaksi/${id}/detail`;
}

// Update transaction status function
function updateTransactionStatus(id, currentStatus) {
    let statusOptions = {
        'lunas': { next: 'pending', color: '#f59e0b', text: 'Pending' },
        'pending': { next: 'dibatalkan', color: '#ef4444', text: 'Dibatalkan' },
        'dibatalkan': { next: 'lunas', color: '#10b981', text: 'Lunas' }
    };

    let nextStatus = statusOptions[currentStatus];

    Swal.fire({
        title: 'Ubah Status Transaksi?',
        text: `Status akan diubah menjadi: ${nextStatus.text}`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: nextStatus.color,
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Ubah!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Mengubah status...',
                text: 'Mohon tunggu sebentar',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                timer: 1000
            });

            // Simulate status update (replace with actual AJAX call)
            setTimeout(() => {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Status transaksi berhasil diubah.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    // Reload page or update status dynamically
                    location.reload();
                });
            }, 1000);
        }
    });
}

// Print invoice function
function printInvoice(id) {
    Swal.fire({
        title: 'Print Invoice',
        text: 'Membuka halaman print invoice...',
        icon: 'info',
        timer: 1000,
        showConfirmButton: false
    }).then(() => {
        // Open print page in new window
        window.open(`/admin/transaksi/${id}/print`, '_blank');
    });
}

// Send invoice email function
function sendInvoiceEmail(id) {
    Swal.fire({
        title: 'Kirim Invoice via Email?',
        text: 'Invoice akan dikirim ke email pelanggan',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Kirim!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Mengirim email...',
                text: 'Mohon tunggu sebentar',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                timer: 2000
            });

            // Simulate email sending (replace with actual AJAX call)
            setTimeout(() => {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Invoice berhasil dikirim via email.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
            }, 2000);
        }
    });
}

// Filter functions
function filterByStatus(status) {
    if (status === 'all') {
        $('#datatable').DataTable().column(6).search('').draw();
    } else {
        $('#datatable').DataTable().column(6).search(status).draw();
    }
}

function filterByDateRange(startDate, endDate) {
    // Custom date range filter implementation
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            // Implement date range filtering logic here
            return true; // Placeholder
        }
    );
    $('#datatable').DataTable().draw();
}

// Export functions
function exportToExcel() {
    Swal.fire({
        title: 'Export ke Excel',
        text: 'Mengunduh file Excel...',
        icon: 'info',
        timer: 1000,
        showConfirmButton: false
    }).then(() => {
        // Implement Excel export
        console.log('Exporting to Excel...');
    });
}

function exportToPDF() {
    Swal.fire({
        title: 'Export ke PDF',
        text: 'Mengunduh file PDF...',
        icon: 'info',
        timer: 1000,
        showConfirmButton: false
    }).then(() => {
        // Implement PDF export
        console.log('Exporting to PDF...');
    });
}

// Search enhancement
$(document).ready(function() {
    // Custom search for specific columns
    $('#searchByInvoice').on('keyup', function() {
        $('#datatable').DataTable().column(1).search(this.value).draw();
    });

    $('#searchByCustomer').on('keyup', function() {
        $('#datatable').DataTable().column(2).search(this.value).draw();
    });

    $('#searchByTable').on('change', function() {
        $('#datatable').DataTable().column(3).search(this.value).draw();
    });

    $('#searchByStatus').on('change', function() {
        $('#datatable').DataTable().column(6).search(this.value).draw();
    });
});

// Refresh data function
function refreshData() {
    Swal.fire({
        title: 'Memuat ulang data...',
        text: 'Mohon tunggu sebentar',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        timer: 1000
    }).then(() => {
        location.reload();
    });
}

// Statistics update function
function updateStatistics() {
    // Simulate statistics update
    console.log('Updating statistics...');
}

// Auto refresh every 5 minutes
setInterval(function() {
    updateStatistics();
}, 300000); // 5 minutes