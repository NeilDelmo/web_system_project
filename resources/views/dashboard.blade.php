<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Cuevas Bakery</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background: linear-gradient(135deg, #fff9e6, #fff3cd, #fce6a4);
      display: flex;
      height: 100vh;
      overflow: hidden; /* prevents double scrollbars */
    }

    /* Sidebar */
    .sidebar {
      background-color: #ffffff;
      width: 250px;
      height: 100vh;
      box-shadow: 2px 0 10px rgba(0,0,0,0.05);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: fixed;
      left: 0;
      top: 0;
      transition: width 0.6s ease;
      z-index: 1000;
    }

    .sidebar.collapsed {
      width: 80px;
    }

    .brand {
      background-color: #ffee8c;
      height: 180px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .sidebar-logo {
      max-height: 100%;
      max-width: 80%;
      object-fit: contain;
      transition: all 0.6s;
    }

    .sidebar.collapsed .sidebar-logo {
      width: 50px;
    }

    .sidebar .nav {
      flex-grow: 1;
      padding-top: 20px;
    }

    .sidebar .nav-link {
      color: #444;
      font-weight: 500;
      padding: 0.75rem 1.25rem;
      border-radius: 8px;
      margin: 0.25rem 0.5rem;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
    }

    .sidebar .nav-link i {
      min-width: 20px;
      text-align: center;
    }

    .sidebar .nav-link span {
      transition: all 0.6s;
    }

    .sidebar .nav-link:hover {
      background-color: #fff3cd;
      color: #b71c1c;
    }

    .sidebar .nav-link.active {
      background-color: #ffee8c;
      color: #000;
      font-weight: 600;
    }

    /* Sidebar Footer */
    .sidebar-footer {
      padding: 1rem 0;
      text-align: center;
      border-top: 1px solid #f0f0f0;
    }

    .sidebar-footer img {
      border-radius: 50%;
      margin-bottom: 0.25rem;
      transition: all 0.6s;
    }

    /* Hide text when collapsed */
    .sidebar.collapsed .nav-link span,
    .sidebar.collapsed .sidebar-footer strong,
    .sidebar.collapsed .sidebar-footer small {
      display: none;
    }

    /* Main Content */
    .main-content {
      margin-left: 250px;
      flex-grow: 1;
      overflow-y: auto;
      height: 100vh;
      padding: 20px;
      transition: margin-left 0.6s ease;
    }

    .main-content.collapsed {
      margin-left: 80px;
    }

    /* Cards */
    .stats-card, .notification-card, .chart-card {
      border-radius: 12px;
      padding: 1.5rem;
      transition: all 0.6s ease;
    }

    .stats-card:hover, .notification-card:hover, .chart-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }

    /* Sidebar toggle button */
    .sidebar-toggle {
      position: absolute;
      top: 10px;
      right: -15px;
      background: #ffc107;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      box-shadow: 0 0 5px rgba(0,0,0,0.2);
      transition: all 0.6s;
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <aside class="sidebar" id="sidebar">
    <div class="brand">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="sidebar-logo">
      <div class="sidebar-toggle text-dark" id="sidebarToggle">
        <i class="bi bi-chevron-left"></i>
      </div>
    </div>

    <nav class="nav flex-column">
      <a href="/dashboard" class="nav-link active"><i class="bi bi-speedometer2 me-2"></i> <span>Dashboard</span></a>
      <a href="/products" class="nav-link"><i class="bi bi-basket-fill me-2"></i> <span>Products</span></a>
      <a href="/inventory" class="nav-link"><i class="bi bi-box-seam me-2"></i> <span>Inventory</span></a>
      <a href="/sales" class="nav-link"><i class="bi bi-cart-check-fill me-2"></i> <span>Sales & Orders</span></a>
      <a href="/production" class="nav-link"><i class="bi bi-gear-fill me-2"></i> <span>Production</span></a>
      <a href="/reports" class="nav-link"><i class="bi bi-bar-chart-line-fill me-2"></i> <span>Reports</span></a>
    </nav>

    <div class="sidebar-footer">
      <div class="dropdown text-center">
        <a href="#" class="d-flex flex-column align-items-center text-decoration-none text-dark dropdown-toggle"
           id="adminMenu" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="{{ asset('images/user-avatar.jpg') }}" alt="User" width="40" height="40">
          <strong style="font-size: 0.9rem;">Admin</strong>
          <small class="text-muted" style="font-size: 0.75rem;">Manager</small>
        </a>
        <ul class="dropdown-menu shadow border-0 text-center" aria-labelledby="adminMenu">
          <li><a class="dropdown-item py-1" href="#"><i class="bi bi-person-circle me-1"></i> Profile</a></li>
          <li><a class="dropdown-item py-1" href="{{ route('settings.index') }}"><i class="bi bi-gear me-1"></i> Settings</a></li>
          <li><hr class="dropdown-divider my-1"></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item text-danger py-1">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="main-content" id="mainContent">
    <div class="container-fluid">
      <div class="card shadow-sm mb-4">
        <div class="card-body">
          <h3 class="card-title">Welcome, {{ auth()->user()?->full_name ?? auth()->user()?->username ?? 'User' }}</h3>
          <p class="card-text text-muted">You are now logged in to the Cuevas Bakery system.</p>
        </div>
      </div>

      <div class="row g-4 mb-4">
        <div class="col-md-3">
          <div class="card stats-card text-center shadow-sm p-3">
            <i class="bi bi-basket-fill display-4 text-primary"></i>
            <h3 class="mt-2 mb-0">{{ number_format($totalProducts) }}</h3>
            <h6 class="text-muted">Total Products</h6>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card stats-card text-center shadow-sm p-3">
            <i class="bi bi-currency-dollar display-4 text-success"></i>
            <h3 class="mt-2 mb-0">₱{{ number_format($todaySales, 2) }}</h3>
            <h6 class="text-muted">Today's Sales</h6>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card stats-card text-center shadow-sm p-3">
            <i class="bi bi-cart-check-fill display-4 text-warning"></i>
            <h3 class="mt-2 mb-0">{{ number_format($pendingOrders) }}</h3>
            <h6 class="text-muted">Pending Orders</h6>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card stats-card text-center shadow-sm p-3">
            <i class="bi bi-exclamation-triangle-fill display-4 text-danger"></i>
            <h3 class="mt-2 mb-0">{{ number_format($totalLowStock) }}</h3>
            <h6 class="text-muted">Low Stock Alerts</h6>
          </div>
        </div>
      </div>
 <!-- Notifications & Charts -->
      <div class="row g-4">
        <div class="col-md-6">
          <!-- Daily Sales Summary -->
          <div class="card notification-card shadow-sm mb-3">
            <div class="card-body">
              <h6 class="fw-semibold text-primary mb-3">
                <i class="bi bi-clock-history me-1"></i> Today's Sales Summary
              </h6>
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span>Total Revenue:</span>
                <strong class="text-success">₱{{ number_format($todaySales, 2) }}</strong>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span>Orders Completed:</span>
                <strong class="text-info">{{ number_format($todayOrders) }}</strong>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <span>Average Order Value:</span>
                <strong class="text-warning">₱{{ $todayOrders > 0 ? number_format($todaySales / $todayOrders, 2) : '0.00' }}</strong>
              </div>
            </div>
          </div>

          <!-- Low Stock Alerts -->
          <div class="card notification-card shadow-sm mb-3">
            <div class="card-body">
              <h6 class="fw-semibold text-warning mb-3">
                <i class="bi bi-exclamation-triangle me-1"></i> Low Stock Alerts
              </h6>
              @if($lowStockProductsList->count() > 0 || $lowStockIngredientsList->count() > 0)
                @if($lowStockProductsList->count() > 0)
                  <small class="text-muted d-block mb-2"><strong>Products:</strong></small>
                  <ul class="list-unstyled mb-3">
                    @foreach($lowStockProductsList as $product)
                    <li class="mb-1">
                      <i class="bi bi-dot"></i> {{ $product->name }}: 
                      <span class="badge bg-warning text-dark">{{ $product->stock_quantity }} units</span>
                    </li>
                    @endforeach
                  </ul>
                @endif
                
                @if($lowStockIngredientsList->count() > 0)
                  <small class="text-muted d-block mb-2"><strong>Ingredients:</strong></small>
                  <ul class="list-unstyled mb-0">
                    @foreach($lowStockIngredientsList as $ingredient)
                    <li class="mb-1">
                      <i class="bi bi-dot"></i> {{ $ingredient->name }}: 
                      <span class="badge bg-danger">{{ $ingredient->status }}</span>
                    </li>
                    @endforeach
                  </ul>
                @endif
              @else
                <p class="text-muted mb-0">All stock levels are healthy! ✓</p>
              @endif
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <!-- Recent Production -->
          <div class="card notification-card shadow-sm mb-3">
            <div class="card-body">
              <h6 class="fw-semibold text-success mb-3">
                <i class="bi bi-gear-fill me-1"></i> Recent Production Batches
              </h6>
              @if($recentProduction->count() > 0)
                <ul class="list-unstyled mb-0">
                  @foreach($recentProduction as $production)
                  <li class="mb-2 pb-2 border-bottom">
                    <div class="d-flex justify-content-between align-items-start">
                      <div>
                        <strong>{{ $production->product->name ?? 'Unknown' }}</strong>
                        <br>
                        <small class="text-muted">
                          {{ $production->quantity_produced }} units • {{ $production->produced_at->format('M d, Y') }}
                        </small>
                      </div>
                      <span class="badge 
                        @if($production->status == 'completed') bg-success
                        @elseif($production->status == 'failed') bg-danger
                        @else bg-secondary
                        @endif">
                        {{ ucfirst($production->status) }}
                      </span>
                    </div>
                  </li>
                  @endforeach
                </ul>
              @else
                <p class="text-muted mb-0">No recent production batches.</p>
              @endif
            </div>
          </div>

          <!-- Sales Trends Chart -->
          <div class="card chart-card shadow-sm mb-3">
            <div class="card-body">
              <h6 class="fw-semibold mb-3">Sales Trends (Last 7 Days)</h6>
              <div style="position: relative; height: 250px;">
                <canvas id="salesChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

      <footer class="text-center py-3 mt-4 bg-white border-top small text-muted">
        &copy; {{ date('Y') }} Cuevas Bread. All rights reserved.
      </footer>
    </div>
  </main>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

  <!-- Sidebar Toggle Script -->
  <script>
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleBtn = document.getElementById('sidebarToggle');

    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
      mainContent.classList.toggle('collapsed');
      toggleBtn.innerHTML = sidebar.classList.contains('collapsed') 
        ? '<i class="bi bi-chevron-right"></i>' 
        : '<i class="bi bi-chevron-left"></i>';
    });

    // Sales Chart
    const salesData = @json($salesChartData);
    
    // Prepare data for last 7 days chart
    const dates = salesData.map(item => {
        const date = new Date(item.date);
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    });
    const revenues = salesData.map(item => parseFloat(item.total));
    const orderCounts = salesData.map(item => parseInt(item.orders));

    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Revenue (₱)',
                data: revenues,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.4,
                fill: true,
                yAxisID: 'y'
            }, {
                label: 'Orders',
                data: orderCounts,
                borderColor: 'rgb(255, 159, 64)',
                backgroundColor: 'rgba(255, 159, 64, 0.1)',
                tension: 0.4,
                fill: true,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
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
                            if (context.parsed.y !== null) {
                                if (context.datasetIndex === 0) {
                                    label += '₱' + context.parsed.y.toLocaleString();
                                } else {
                                    label += context.parsed.y;
                                }
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Revenue (₱)'
                    },
                    ticks: {
                        callback: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Orders'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            }
        }
    });
  </script>
</body>
</html>