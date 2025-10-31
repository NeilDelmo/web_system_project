<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports | Cuevas Bread</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #fff9e6, #fff3cd, #fce6a4);
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif;
        }

        /* Sidebar */
        .sidebar {
            background-color: #ffffff;
            width: 250px;
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column; 
            position: relative;
        }

        .sidebar .brand {
            background-color: #ffee8c; 
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .sidebar-logo {
            max-height: 100%;
            max-width: 80%;
            object-fit: contain;
            display: block;
        }

        .sidebar .nav-link {
            color: #444;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            margin: 0.25rem 0.75rem;
            transition: all 0.2s ease;
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

        .sidebar-footer {
            position: absolute;
            bottom: 1rem;
            width: 100%;
            text-align: center;
            font-size: 0.85rem;
            color: #777;
        }

        /* Main Content */
        .main-content {
            flex-grow: 1;
        }

        .page-header {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Tabs */
        .tab-nav .nav-link {
            color: #000 !important;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .tab-nav .nav-link:hover {
            color: #b71c1c !important;
            background-color: #fff3cd !important;
        }

        .tab-nav .nav-link.active {
            border-bottom: 3px solid #fdd663 !important;
            color: #000 !important;
            font-weight: 600;
        }

        .card-item {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            text-align: center;
        }

        .card-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .card-item .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <aside class="sidebar position-relative">
        <div class="brand d-flex align-items-center justify-content-center">
            <img src="{{ asset('images/logo.png') }}" alt="Cuevas Bread Logo" class="sidebar-logo">
        </div>

        <nav class="nav flex-column mt-4">
            <a href="/dashboard" class="nav-link"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
            <a href="/products" class="nav-link"><i class="bi bi-basket-fill me-2"></i>Products</a>
            <a href="/inventory" class="nav-link"><i class="bi bi-box-seam me-2"></i>Inventory</a>
            <a href="/sales" class="nav-link"><i class="bi bi-cart-check-fill me-2"></i>Sales & Orders</a>
            <a href="/production" class="nav-link"><i class="bi bi-gear-fill me-2"></i>Production</a>
            <a href="/reports" class="nav-link active"><i class="bi bi-bar-chart-line-fill me-2"></i>Reports</a>
        </nav>

        <div class="sidebar-footer">
            <div class="dropdown text-center">
                <a href="#" class="d-flex flex-column align-items-center text-decoration-none text-dark dropdown-toggle" id="adminMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('images/user-avatar.jpg') }}" alt="User" class="rounded-circle mb-2" width="50" height="50">
                    <strong>Admin</strong>
                    <small class="text-muted">Manager</small>
                </a>

                <ul class="dropdown-menu shadow border-0 mt-2 text-center" aria-labelledby="adminMenu">
                    <!-- Optional profile link -->
                    <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person-circle me-1"></i> Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <!-- Logout link -->
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger py-2">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <div>
                <h2 class="fw-semibold mb-1">Reports Management</h2>
                <p class="text-muted mb-0 small">View and export detailed analytics across all operations.</p>
            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs tab-nav bg-white px-4 border-bottom" id="reportsTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="sales-tab" data-bs-toggle="tab" href="#sales" role="tab">Sales Reports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="inventory-tab" data-bs-toggle="tab" href="#inventory" role="tab">Inventory Reports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="production-tab" data-bs-toggle="tab" href="#production" role="tab">Production Reports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="export-tab" data-bs-toggle="tab" href="#export" role="tab">Export Functionality</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content p-4" id="reportsTabsContent">
            <!-- Sales Reports -->
            <div class="tab-pane fade show active" id="sales" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Sales Reports</h5>
                    <div>
                        <input type="date" class="form-control d-inline-block" id="startDate" style="width: auto;" value="{{ \Carbon\Carbon::now()->subDays(30)->format('Y-m-d') }}">
                        <span class="mx-2">to</span>
                        <input type="date" class="form-control d-inline-block" id="endDate" style="width: auto;" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        <button class="btn btn-danger ms-2" id="filterSales"><i class="bi bi-funnel me-1"></i> Filter</button>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <i class="bi bi-currency-dollar fs-1 text-primary"></i>
                                <h3 class="mt-2">₱{{ number_format($totalRevenue, 2) }}</h3>
                                <p class="text-muted mb-0 small">Total Revenue</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-success">
                            <div class="card-body text-center">
                                <i class="bi bi-cart-check fs-1 text-success"></i>
                                <h3 class="mt-2">{{ $totalOrders }}</h3>
                                <p class="text-muted mb-0 small">Total Orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-warning">
                            <div class="card-body text-center">
                                <i class="bi bi-calendar-day fs-1 text-warning"></i>
                                <h3 class="mt-2">₱{{ number_format($todaySales, 2) }}</h3>
                                <p class="text-muted mb-0 small">Today's Sales</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-info">
                            <div class="card-body text-center">
                                <i class="bi bi-receipt fs-1 text-info"></i>
                                <h3 class="mt-2">{{ $todayOrders }}</h3>
                                <p class="text-muted mb-0 small">Today's Orders</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales Chart -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 fw-semibold">Sales Trend (Last 30 Days)</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" height="80"></canvas>
                    </div>
                </div>

                <!-- Sales by Order Type -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h6 class="mb-0 fw-semibold">Sales by Order Type</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="orderTypeChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-white">
                                <h6 class="mb-0 fw-semibold">Order Type Summary</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Orders</th>
                                            <th>Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($salesByType as $type)
                                        <tr>
                                            <td><span class="badge bg-info">{{ ucfirst($type->order_type) }}</span></td>
                                            <td>{{ $type->count }}</td>
                                            <td class="fw-bold">₱{{ number_format($type->total, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Selling Products -->
                <div class="card">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 fw-semibold">Top 10 Selling Products</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Rank</th>
                                    <th>Product</th>
                                    <th>Quantity Sold</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProducts as $index => $item)
                                <tr>
                                    <td>
                                        @if($index === 0)
                                            <i class="bi bi-trophy-fill text-warning fs-5"></i>
                                        @elseif($index === 1)
                                            <i class="bi bi-trophy-fill text-secondary fs-5"></i>
                                        @elseif($index === 2)
                                            <i class="bi bi-trophy-fill text-danger fs-5"></i>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $item->product->name ?? 'N/A' }}</td>
                                    <td>{{ $item->total_sold }} pcs</td>
                                    <td class="fw-bold text-success">₱{{ number_format($item->revenue, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Inventory Reports -->
            <div class="tab-pane fade" id="inventory" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Inventory Reports</h5>
                    <button class="btn btn-danger"><i class="bi bi-box-seam me-1"></i> Generate Inventory Report</button>
                </div>
                <p class="text-muted mb-4">Monitor stock levels, movements, and wastage analytics.</p>
            </div>

            <!-- Production Reports -->
            <div class="tab-pane fade" id="production" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Production Reports</h5>
                    <button class="btn btn-danger"><i class="bi bi-gear-wide-connected me-1"></i> Generate Production Report</button>
                </div>
                <p class="text-muted mb-4">Evaluate batch output, performance, and production efficiency.</p>
            </div>

            <!-- Export Functionality -->
            <div class="tab-pane fade" id="export" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Export Functionality</h5>
                    <button class="btn btn-danger"><i class="bi bi-download me-1"></i> Export All Reports</button>
                </div>
                <p class="text-muted mb-4">Export reports in PDF, Excel, or CSV formats for external review.</p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center py-3 border-top bg-white small text-muted mt-5">
            &copy; {{ date('Y') }} Cuevas Bread. All rights reserved.
        </footer>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales data from backend
    const salesData = @json($salesByDate);
    
    // Prepare data for sales trend chart
    const dates = salesData.map(item => {
        const date = new Date(item.date);
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    });
    const revenues = salesData.map(item => parseFloat(item.total));
    const orderCounts = salesData.map(item => parseInt(item.orders));

    // Sales Trend Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Revenue (₱)',
                data: revenues,
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.1)',
                tension: 0.4,
                fill: true,
                yAxisID: 'y'
            }, {
                label: 'Orders',
                data: orderCounts,
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                tension: 0.4,
                fill: true,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
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
                                    label += '₱' + context.parsed.y.toFixed(2);
                                } else {
                                    label += context.parsed.y + ' orders';
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
                        drawOnChartArea: false
                    }
                }
            }
        }
    });

    // Order Type Chart
    const orderTypeData = @json($salesByType);
    const orderTypes = orderTypeData.map(item => item.order_type.charAt(0).toUpperCase() + item.order_type.slice(1));
    const orderTypeCounts = orderTypeData.map(item => parseInt(item.count));
    const orderTypeRevenues = orderTypeData.map(item => parseFloat(item.total));

    const orderTypeCtx = document.getElementById('orderTypeChart').getContext('2d');
    const orderTypeChart = new Chart(orderTypeCtx, {
        type: 'doughnut',
        data: {
            labels: orderTypes,
            datasets: [{
                label: 'Orders',
                data: orderTypeCounts,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} orders (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Filter button
    document.getElementById('filterSales')?.addEventListener('click', function() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        if (!startDate || !endDate) {
            alert('Please select both start and end dates');
            return;
        }

        // Reload page with date filters
        window.location.href = `/reports?start_date=${startDate}&end_date=${endDate}`;
    });
});
</script>
</body>
</html>