// Data statistik dengan rentang nominal yang realistis - RESET DATA
const statsData = {
  daily: {
    labels: ['22 Jan', '23 Jan', '24 Jan', '25 Jan', '26 Jan', '27 Jan', '28 Jan'],
    data: [0, 0, 0, 0, 0, 0, 0], // Reset ke 0 - akan menggunakan data dari controller
    transactions: [0, 0, 0, 0, 0, 0, 0]
  },
  weekly: {
    labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
    data: [0, 0, 0, 0], // Reset ke 0 - akan menggunakan data dari controller
    transactions: [0, 0, 0, 0]
  },
  monthly: {
    labels: ['Nov 2025', 'Des 2025', 'Jan 2026', 'Feb 2026'],
    data: [0, 0, 0, 0], // Reset ke 0 - akan menggunakan data dari controller
    transactions: [0, 0, 0, 0]
  },
  yearly: {
    labels: ['2026', '2027', '2028'],
    data: [0, 0, 0], // Reset ke 0 - akan menggunakan data dari controller
    transactions: [0, 0, 0]
  }
};

let currentChart = null;
let currentPeriod = 'daily';

// Initialize chart
function initChart() {
  const canvas = document.getElementById('revenueChart');
  if (!canvas) {
    console.log('Canvas not found');
    return;
  }
  
  const ctx = canvas.getContext('2d');
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
          borderColor: '#0f6d45',
          borderWidth: 1,
          cornerRadius: 8,
          displayColors: false
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
          beginAtZero: true,
          grid: {
            color: 'rgba(0, 0, 0, 0.1)'
          },
          ticks: {
            callback: function(value) {
              return 'Rp ' + value.toLocaleString('id-ID');
            },
            font: {
              family: 'Poppins',
              size: 11
            }
          }
        }
      },
      interaction: {
        intersect: false,
        mode: 'index'
      }
    }
  });
  
  console.log('Chart initialized successfully');
}

// Show statistics by period
function showStats(period, clickedElement) {
  currentPeriod = period;
  
  // Update button states
  document.querySelectorAll('.btn-group .btn').forEach(btn => {
    btn.classList.remove('active');
  });
  
  // Find the clicked button and make it active
  const clickedButton = clickedElement || document.querySelector(`[onclick*="showStats('${period}')"]`);
  if (clickedButton) {
    clickedButton.classList.add('active');
  }
  
  // Update chart
  const data = statsData[period];
  if (currentChart && data) {
    currentChart.data.labels = data.labels;
    currentChart.data.datasets[0].data = data.data;
    currentChart.update('active');
    console.log(`Chart updated for ${period}`);
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
  
  const totalTransactionsEl = document.getElementById('totalTransactions');
  const totalRevenueEl = document.getElementById('totalRevenue');
  const avgDailyEl = document.getElementById('avgDaily');
  
  if (totalTransactionsEl) totalTransactionsEl.textContent = totalTransactions;
  if (totalRevenueEl) totalRevenueEl.textContent = 'Rp ' + totalRevenue.toLocaleString('id-ID');
  if (avgDailyEl) avgDailyEl.textContent = 'Rp ' + avgDaily.toLocaleString('id-ID');
  
  // Update period text
  const periodTexts = {
    daily: 'hari ini',
    weekly: 'minggu ini',
    monthly: 'bulan ini',
    yearly: 'tahun ini'
  };
  
  document.querySelectorAll('.card small').forEach((el, index) => {
    if (index < 3) {
      el.textContent = periodTexts[period] || 'periode ini';
    }
  });
}

// Sidebar Toggle Function
function toggleSidebar() {
  console.log('Toggle sidebar function called');
  const sidebar = document.querySelector('.modern-sidebar');
  const overlay = document.querySelector('.sidebar-overlay');
  
  if (sidebar) {
    const isVisible = sidebar.classList.contains('show');
    
    if (isVisible) {
      sidebar.classList.remove('show');
      if (overlay) overlay.remove();
    } else {
      sidebar.classList.add('show');
      
      // Add overlay for mobile
      if (window.innerWidth <= 768) {
        if (!document.querySelector('.sidebar-overlay')) {
          const newOverlay = document.createElement('div');
          newOverlay.className = 'sidebar-overlay show';
          document.body.appendChild(newOverlay);
          
          // Add click listener to overlay
          newOverlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            this.remove();
          });
        }
      }
    }
  }
}

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
  console.log('DOM Ready - Initializing dashboard');
  
  // Initialize chart if canvas exists
  if (document.getElementById('revenueChart')) {
    setTimeout(() => {
      initChart();
    }, 500);
  }
  
  // Sidebar toggle event listener
  const sidebarToggle = document.getElementById('sidebarToggle');
  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      console.log('Sidebar toggle clicked');
      toggleSidebar();
    });
    console.log('Sidebar toggle listener attached');
  } else {
    console.log('Sidebar toggle button not found');
  }
  
  // Profile dropdown functionality - Simple approach
  let dropdownOpen = false;
  
  const profileDropdown = document.getElementById('profileDropdown');
  const dropdownMenu = document.querySelector('.dropdown-menu');
  
  if (profileDropdown && dropdownMenu) {
    // Toggle dropdown on click
    profileDropdown.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      
      console.log('Profile dropdown clicked, current state:', dropdownOpen);
      
      if (dropdownOpen) {
        // Close dropdown
        dropdownMenu.classList.remove('show');
        dropdownOpen = false;
        console.log('Dropdown closed');
      } else {
        // Open dropdown
        dropdownMenu.classList.add('show');
        dropdownOpen = true;
        console.log('Dropdown opened');
      }
    });
    
    console.log('Profile dropdown listener attached');
  } else {
    console.log('Profile dropdown elements not found');
  }
  
  // Close dropdown when clicking outside
  document.addEventListener('click', function(e) {
    if (dropdownOpen && !e.target.closest('.dropdown')) {
      if (dropdownMenu) {
        dropdownMenu.classList.remove('show');
        dropdownOpen = false;
        console.log('Dropdown closed by outside click');
      }
    }
  });
  
  // Close dropdown on escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && dropdownOpen) {
      if (dropdownMenu) {
        dropdownMenu.classList.remove('show');
        dropdownOpen = false;
        console.log('Dropdown closed by escape key');
      }
    }
  });
  
  // Handle window resize for responsive behavior
  window.addEventListener('resize', function() {
    console.log('Window resized to:', window.innerWidth + 'x' + window.innerHeight);
    
    // Close dropdown on resize
    if (dropdownOpen && dropdownMenu) {
      dropdownMenu.classList.remove('show');
      dropdownOpen = false;
    }
    
    // Handle sidebar on desktop
    const sidebar = document.querySelector('.modern-sidebar');
    if (window.innerWidth > 768 && sidebar) {
      sidebar.classList.remove('show');
      const overlay = document.querySelector('.sidebar-overlay');
      if (overlay) overlay.remove();
    }
  });
  
  // Test Font Awesome loading and hide broken icons
  setTimeout(() => {
    const testIcon = document.createElement('i');
    testIcon.className = 'fas fa-test';
    testIcon.style.display = 'none';
    document.body.appendChild(testIcon);
    
    const computedStyle = window.getComputedStyle(testIcon);
    const fontFamily = computedStyle.getPropertyValue('font-family');
    
    if (fontFamily.includes('Font Awesome') || fontFamily.includes('FontAwesome')) {
      console.log('✅ Font Awesome loaded successfully');
      document.body.classList.add('fa-loaded');
      // Hide fallback icons
      document.querySelectorAll('.hamburger-fallback, .chevron-fallback, .logout-fallback').forEach(el => {
        el.style.display = 'none';
      });
    } else {
      console.log('❌ Font Awesome failed to load, hiding broken icons');
      document.body.classList.add('fa-failed');
      
      // Hide all Font Awesome icons to prevent squares
      document.querySelectorAll('.fas, .far, .fab, .fa').forEach(el => {
        el.style.display = 'none';
      });
      
      // Show fallback icons where available
      document.querySelectorAll('.hamburger-fallback, .chevron-fallback, .logout-fallback').forEach(el => {
        el.style.display = 'inline-block';
      });
    }
    
    document.body.removeChild(testIcon);
    
    // Additional check: hide any remaining square/broken icons
    document.querySelectorAll('i[class*="fa"]').forEach(icon => {
      const rect = icon.getBoundingClientRect();
      const computedStyle = window.getComputedStyle(icon);
      const content = computedStyle.getPropertyValue('content');
      
      // If icon shows as square or empty, hide it
      if (content === '""' || content === 'none' || rect.width === 0) {
        icon.style.display = 'none';
        console.log('Hidden broken icon:', icon.className);
      }
    });
  }, 500);
});

// jQuery ready (if jQuery is available)
if (typeof $ !== 'undefined') {
  $(document).ready(function() {
    console.log('jQuery ready');
    
    // DataTable initialization
    if ($('#transactionTable').length) {
      $('#transactionTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[0, 'desc']],
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
    }
    
    // Additional jQuery sidebar toggle (backup)
    $('#sidebarToggle').on('click', function(e) {
      e.preventDefault();
      console.log('jQuery sidebar toggle');
      toggleSidebar();
    });
  });
}