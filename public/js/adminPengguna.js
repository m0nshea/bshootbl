// Admin Pengguna JavaScript Functions

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
            emptyTable: "Tidak ada data pengguna",
            zeroRecords: "Tidak ditemukan data yang sesuai"
        },
        columnDefs: [
            { orderable: false, targets: [1, 7] } // Disable sorting for avatar and action columns
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

    // Avatar hover effects
    $('.user-avatar').hover(
        function() {
            $(this).addClass('shadow-lg');
        },
        function() {
            $(this).removeClass('shadow-lg');
        }
    );

    // Role badge hover effects
    $('.role-badge').hover(
        function() {
            $(this).css('transform', 'scale(1.05)');
        },
        function() {
            $(this).css('transform', 'scale(1)');
        }
    );

    // Status hover effects
    $('.status-active, .status-inactive').hover(
        function() {
            $(this).css('transform', 'scale(1.05)');
        },
        function() {
            $(this).css('transform', 'scale(1)');
        }
    );

    // Email click to copy
    $('.text-primary').click(function() {
        const email = $(this).text();
        navigator.clipboard.writeText(email).then(function() {
            Swal.fire({
                title: 'Email Disalin!',
                text: `${email} telah disalin ke clipboard`,
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            });
        });
    });
});

// Edit user function
function editUser(id) {
    // Redirect to edit page
    window.location.href = `/admin/pengguna/${id}/edit`;
}

// Delete user function with SweetAlert2
function deleteUser(id) {
    Swal.fire({
        title: 'Hapus Pengguna?',
        text: "Data pengguna yang dihapus tidak dapat dikembalikan!",
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
                    text: 'Pengguna berhasil dihapus.',
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

// Toggle user status function
function toggleUserStatus(id, currentStatus) {
    let newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    let statusText = newStatus === 'active' ? 'Aktif' : 'Tidak Aktif';
    let statusColor = newStatus === 'active' ? '#10b981' : '#ef4444';

    Swal.fire({
        title: 'Ubah Status Pengguna?',
        text: `Status akan diubah menjadi: ${statusText}`,
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
                text: 'Status pengguna berhasil diubah.',
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

// View user profile function
function viewUserProfile(id) {
    Swal.fire({
        title: 'Profil Pengguna',
        html: `
            <div class="text-left">
                <p><strong>ID:</strong> ${id}</p>
                <p><strong>Bergabung:</strong> 15 November 2024</p>
                <p><strong>Terakhir login:</strong> 2 jam yang lalu</p>
                <p><strong>Total transaksi:</strong> 15 kali</p>
                <p><strong>Total pengeluaran:</strong> Rp 2.500.000</p>
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'Tutup',
        customClass: {
            popup: 'swal-info'
        }
    });
}

// Reset user password function
function resetUserPassword(id) {
    Swal.fire({
        title: 'Reset Password?',
        text: 'Password akan direset dan dikirim ke email pengguna',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Reset!',
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

            setTimeout(() => {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Password baru telah dikirim ke email pengguna.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
            }, 2000);
        }
    });
}

// Send notification to user function
function sendNotification(id) {
    Swal.fire({
        title: 'Kirim Notifikasi',
        input: 'textarea',
        inputLabel: 'Pesan',
        inputPlaceholder: 'Tulis pesan notifikasi...',
        inputAttributes: {
            'aria-label': 'Tulis pesan notifikasi'
        },
        showCancelButton: true,
        confirmButtonText: 'Kirim',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
            if (!value) {
                return 'Pesan tidak boleh kosong!'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Notifikasi berhasil dikirim.',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}

// Filter functions
function filterByRole(role) {
    if (role === 'all') {
        $('#datatable').DataTable().column(5).search('').draw();
    } else {
        $('#datatable').DataTable().column(5).search(role).draw();
    }
}

function filterByStatus(status) {
    if (status === 'all') {
        $('#datatable').DataTable().column(6).search('').draw();
    } else {
        $('#datatable').DataTable().column(6).search(status).draw();
    }
}

// Search enhancement
$(document).ready(function() {
    // Custom search for specific columns
    $('#searchByName').on('keyup', function() {
        $('#datatable').DataTable().column(2).search(this.value).draw();
    });

    $('#searchByEmail').on('keyup', function() {
        $('#datatable').DataTable().column(3).search(this.value).draw();
    });

    $('#searchByRole').on('change', function() {
        $('#datatable').DataTable().column(5).search(this.value).draw();
    });

    $('#searchByStatus').on('change', function() {
        $('#datatable').DataTable().column(6).search(this.value).draw();
    });
});

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

// Bulk actions
function bulkAction(action) {
    const selectedUsers = [];
    $('.user-checkbox:checked').each(function() {
        selectedUsers.push($(this).val());
    });

    if (selectedUsers.length === 0) {
        Swal.fire({
            title: 'Tidak ada pengguna yang dipilih',
            text: 'Pilih minimal satu pengguna untuk melakukan aksi bulk',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return;
    }

    let actionText = '';
    let confirmColor = '';
    
    switch(action) {
        case 'activate':
            actionText = 'mengaktifkan';
            confirmColor = '#10b981';
            break;
        case 'deactivate':
            actionText = 'menonaktifkan';
            confirmColor = '#ef4444';
            break;
        case 'delete':
            actionText = 'menghapus';
            confirmColor = '#ef4444';
            break;
    }

    Swal.fire({
        title: `${actionText.charAt(0).toUpperCase() + actionText.slice(1)} Pengguna?`,
        text: `Anda akan ${actionText} ${selectedUsers.length} pengguna yang dipilih`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: confirmColor,
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Lanjutkan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Berhasil!',
                text: `${selectedUsers.length} pengguna berhasil ${actionText}.`,
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        }
    });
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