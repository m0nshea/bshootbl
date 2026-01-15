// Admin Meja JavaScript Functions

$(document).ready(function () {
    // Initialize DataTable
    $("#datatable").DataTable({
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
            },
            emptyTable: "Tidak ada data meja",
            zeroRecords: "Tidak ditemukan data yang sesuai"
        },
        columnDefs: [
            { orderable: false, targets: [5, 6] } // Disable sorting for image and action columns
        ],
        order: [[0, 'asc']] // Default sort by No column
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
    $('.card').delay(200).fadeIn(600);

    // Image hover effects
    $('.table-image').hover(
        function() {
            $(this).addClass('shadow-lg');
        },
        function() {
            $(this).removeClass('shadow-lg');
        }
    );

    // Status badge hover effects
    $('.status-badge').hover(
        function() {
            $(this).css('transform', 'scale(1.05)');
        },
        function() {
            $(this).css('transform', 'scale(1)');
        }
    );
});

// Delete table function with SweetAlert2
function deleteTable(id) {
    Swal.fire({
        title: 'Hapus Meja?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
            popup: 'swal-popup',
            title: 'swal-title',
            content: 'swal-content',
            confirmButton: 'swal-confirm',
            cancelButton: 'swal-cancel'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Menghapus...',
                text: 'Mohon tunggu sebentar',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                timer: 1000
            });

            // Simulate delete process (replace with actual AJAX call)
            setTimeout(() => {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Meja berhasil dihapus.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'swal-success'
                    }
                }).then(() => {
                    // In real application, you would make an AJAX call here
                    // For now, just reload the page
                    location.reload();
                });
            }, 1000);
        }
    });
}

// Edit table function (placeholder)
function editTable(id) {
    // Redirect to edit page
    window.location.href = `/admin/meja/${id}/edit`;
}

// View table details function (placeholder)
function viewTable(id) {
    Swal.fire({
        title: 'Detail Meja',
        html: `
            <div class="text-left">
                <p><strong>ID:</strong> ${id}</p>
                <p><strong>Status:</strong> Tersedia</p>
                <p><strong>Terakhir digunakan:</strong> 2 jam yang lalu</p>
                <p><strong>Total penggunaan hari ini:</strong> 6 jam</p>
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'Tutup',
        customClass: {
            popup: 'swal-info'
        }
    });
}

// Change table status function
function changeStatus(id, currentStatus) {
    let newStatus = '';
    let statusColor = '';
    
    if (currentStatus === 'available') {
        newStatus = 'occupied';
        statusColor = '#ef4444';
    } else if (currentStatus === 'occupied') {
        newStatus = 'maintenance';
        statusColor = '#f59e0b';
    } else {
        newStatus = 'available';
        statusColor = '#10b981';
    }

    Swal.fire({
        title: 'Ubah Status Meja?',
        text: `Status akan diubah menjadi: ${newStatus}`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: statusColor,
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Ubah!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Status meja berhasil diubah.',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                // Reload page or update status dynamically
                location.reload();
            });
        }
    });
}

// Search functionality enhancement
$(document).ready(function() {
    // Custom search for specific columns
    $('#searchByName').on('keyup', function() {
        $('#datatable').DataTable().column(1).search(this.value).draw();
    });

    $('#searchByCategory').on('change', function() {
        $('#datatable').DataTable().column(2).search(this.value).draw();
    });

    $('#searchByStatus').on('change', function() {
        $('#datatable').DataTable().column(4).search(this.value).draw();
    });
});

// Export functions (placeholder)
function exportToExcel() {
    Swal.fire({
        title: 'Export ke Excel',
        text: 'Fitur export akan segera tersedia',
        icon: 'info',
        confirmButtonText: 'OK'
    });
}

function exportToPDF() {
    Swal.fire({
        title: 'Export ke PDF',
        text: 'Fitur export akan segera tersedia',
        icon: 'info',
        confirmButtonText: 'OK'
    });
}

// Print function
function printTable() {
    window.print();
}

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