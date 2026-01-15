// ===== ADMIN DASHBOARD JAVASCRIPT =====

// Data statistik
const statsData = {
    daily: {
        labels: ['1 Des', '2 Des', '3 Des', '4 Des', '5 Des', '6 Des', '7 Des', '8 Des', '9 Des', '10 Des'],
        data: [450000, 600000, 350000, 800000, 750000, 900000, 650000, 550000, 700000, 850000],
        transactions: [3, 4, 2, 5, 4, 6, 4, 3, 4, 5]
    },
    weekly: {
        labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
        data: [2800000, 3200000, 2900000, 3100000],
        transactions: [18, 22, 19, 21]
    },
    monthly: {
        labels: ['Sep', 'Okt', 'Nov', 'Des'],
        data: [8500000, 9200000, 8800000, 9500000],
        transactions: [65, 72, 68, 75]
    },
    yearly: {
        labels: ['2022', '2023', '2024', '2025'],
        data: [85000000, 92000000, 98000000, 105000000],
        transactions: [650, 720, 780, 850]
    }
};

let currentChart = null;
let currentPeriod = 'daily';

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar toggle
    initSidebarToggle();
    
    // Initialize chart if element exists
    if (document.getElementById('revenueChart')) {
        initChart();
    }
    
    // Add fade in animation to cards
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('fade-in-up');
        }, index * 100);
    });
});

// Sidebar toggle functionality
function initSidebarToggle() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                // Mobile behavior
                sidebar.classList.toggle('show');
                toggleOverlay();
            } else {
                // Desktop behavior
                sidebar.style.transform = sidebar.style.transform === 'translateX(-100%)' ? 'translateX(0)' : 'translateX(-100%)';
                const isHidden = sidebar.style.transform === 'translateX(-100%)';
                mainContent.style.marginLeft = isHidden ? '0' : '280px';
            }
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('show');
                removeOverlay();
            }
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('show');
            sidebar.style.transform = 'translateX(0)';
            mainContent.style.marginLeft = '280px';
            removeOverlay();
        }
    });
}

// Toggle overlay for mobile
function toggleOverlay() {
    let overlay = document.querySelector('.sidebar-overlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.className = 'sidebar-overlay';
        document.body.appendChild(overlay);
        
        overlay.addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('show');
            removeOverlay();
        });
    }
    overlay.classList.toggle('show');
}

// Remove overlay
function removeOverlay() {
    const overlay = document.querySelector('.sidebar-overlay');
    if (overlay) {
        overlay.remove();
    }
}

// Initialize chart
function initChart() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    currentChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: statsData.daily.labels,
            datasets: [{
                label: 'Penghasilan (Rp)',
                data: statsData.daily.data,
                borderColor: '#0f6d45',
                backgroundColor: 'rgba(15, 109, 69, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#0f6d45',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
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
                        font: {
                            family: 'Poppins',
                            size: 12,
                            weight: '500'
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
                        },
                        font: {
                            family: 'Poppins',
                            size: 11
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    ticks: {
                        font: {
                            family: 'Poppins',
                            size: 11
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            },
            elements: {
                point: {
                    hoverBackgroundColor: '#0d4b34'
                }
            }
        }
    });
}

// Show statistics by period
function showStats(period) {
    currentPeriod = period;
    
    // Update button states
    document.querySelectorAll('.btn-group .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // Update chart
    const data = statsData[period];
    if (currentChart) {
        currentChart.data.labels = data.labels;
        currentChart.data.datasets[0].data = data.data;
        currentChart.update('active');
    }
    
    // Update summary cards
    updateSummaryCards(period);
}

// Update summary cards
function updateSummaryCards(period) {
    const data = statsData[period];
    const totalRevenue = data.data.reduce((a, b) => a + b, 0);
    const totalTransactions = data.transactions.reduce((a, b) => a + b, 0);
    const avgDaily = Math.round(totalRevenue / data.data.length);
    
    // Update elements if they exist
    const totalTransactionsEl = document.getElementById('totalTransactions');
    const totalRevenueEl = document.getElementById('totalRevenue');
    const avgDailyEl = document.getElementById('avgDaily');
    
    if (totalTransactionsEl) {
        totalTransactionsEl.textContent = totalTransactions;
    }
    
    if (totalRevenueEl) {
        totalRevenueEl.textContent = 'Rp ' + totalRevenue.toLocaleString('id-ID');
    }
    
    if (avgDailyEl) {
        avgDailyEl.textContent = 'Rp ' + avgDaily.toLocaleString('id-ID');
    }
    
    // Update period text
    const periodTexts = {
        daily: 'hari ini',
        weekly: 'minggu ini',
        monthly: 'bulan ini',
        yearly: 'tahun ini'
    };
    
    document.querySelectorAll('.stats-card small').forEach((el, index) => {
        if (index < 3) {
            el.textContent = periodTexts[period] || 'periode ini';
        }
    });
}

// Utility function for formatting currency
function formatCurrency(amount) {
    return 'Rp ' + amount.toLocaleString('id-ID');
}

// Utility function for smooth scrolling
function smoothScrollTo(element) {
    element.scrollIntoView({
        behavior: 'smooth'
    });
}