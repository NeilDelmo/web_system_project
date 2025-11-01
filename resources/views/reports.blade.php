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

        .sidebar-footer {
            padding: 1rem 0;
            text-align: center;
            border-top: 1px solid #f0f0f0;
        }

        .sidebar.collapsed .nav-link span,
        .sidebar.collapsed .sidebar-footer strong,
        .sidebar.collapsed .sidebar-footer small {
            display: none;
        }

        .main-content {
            margin-left: 250px;
            flex-grow: 1;
            overflow-y: auto;
            height: 100vh;
            transition: margin-left 0.6s ease;
        }

        .main-content.collapsed {
            margin-left: 80px;
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
        <div class="brand d-flex align-items-center justify-content-center">
            <img src="{{ asset('images/logo.png') }}" alt="Cuevas Bread Logo" class="sidebar-logo">
             <div class="sidebar-toggle text-dark" id="sidebarToggle">
                <i class="bi bi-chevron-left"></i>
            </div>
        </div>

        <nav class="nav flex-column">
            <a href="/dashboard" class="nav-link"><i class="bi bi-speedometer2 me-2"></i><span>Dashboard</span></a>
            <a href="/products" class="nav-link"><i class="bi bi-basket-fill me-2"></i><span>Products</span></a>
            <a href="/inventory" class="nav-link"><i class="bi bi-box-seam me-2"></i><span>Inventory</span></a>
            <a href="/sales" class="nav-link"><i class="bi bi-cart-check-fill me-2"></i><span>Sales & Orders</span></a>
            <a href="/production" class="nav-link"><i class="bi bi-gear-fill me-2"></i><span>Production</span></a>
            @can('view_reports')
            <a href="/reports" class="nav-link active"><i class="bi bi-bar-chart-line-fill me-2"></i><span>Reports</span></a>
            @endcan
        </nav>

        <div class="sidebar-footer">
            <div class="dropdown text-center">
                <a href="#" class="d-flex flex-column align-items-center text-decoration-none text-dark dropdown-toggle" id="adminMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    @role('admin')
                    <i class="bi bi-person-badge-fill display-4 text-primary mb-2"></i>
                    @else
                    <i class="bi bi-person-fill display-4 text-secondary mb-2"></i>
                    @endrole
                    <strong>{{ auth()->user()->fullname }}</strong>
                    <small class="text-muted">{{ auth()->user()->roles->first()->name ?? 'User' }}</small>
                </a>

                <ul class="dropdown-menu shadow border-0 mt-2 text-center" aria-labelledby="adminMenu">
                    <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person-circle me-1"></i> Profile</a></li>
                    @role('admin')
                    <li><a class="dropdown-item py-2" href="{{ route('settings.index') }}"><i class="bi bi-gear me-1"></i> Settings</a></li>
                    @endrole
                    <li><hr class="dropdown-divider"></li>
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
    <main class="main-content" id="mainContent">
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
                        <input type="date" class="form-control d-inline-block" id="startDate" style="width: auto;" value="{{ \Carbon\Carbon::now('Asia/Manila')->subDays(30)->format('Y-m-d') }}">
                        <span class="mx-2">to</span>
                        <input type="date" class="form-control d-inline-block" id="endDate" style="width: auto;" value="{{ \Carbon\Carbon::now('Asia/Manila')->format('Y-m-d') }}">
                        <button class="btn btn-danger ms-2" id="filterSales"><i class="bi bi-funnel me-1"></i> Filter</button>
                        <button class="btn btn-outline-secondary ms-2" id="resetDates" title="Reset to last 30 days">
                            <i class="bi bi-arrow-clockwise me-1"></i> Reset
                        </button>
                    </div>
                </div>

                <!-- Date Range Display -->
                <div class="alert alert-info mb-3">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Showing data from:</strong> {{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}
                </div>

                <!-- Summary Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <i class="bi bi-currency-dollar fs-1 text-primary"></i>
                                <h3 class="mt-2">₱{{ number_format($totalRevenue, 2) }}</h3>
                                <p class="text-muted mb-0 small">Revenue (Filtered Period)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-success">
                            <div class="card-body text-center">
                                <i class="bi bi-cart-check fs-1 text-success"></i>
                                <h3 class="mt-2">{{ $totalOrders }}</h3>
                                <p class="text-muted mb-0 small">Orders (Filtered Period)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-warning">
                            <div class="card-body text-center">
                                <i class="bi bi-calendar-event fs-1 text-warning"></i>
                                <h3 class="mt-2">₱{{ number_format($todaySales, 2) }}</h3>
                                <p class="text-muted mb-0 small">Today's Sales ({{ \Carbon\Carbon::now()->format('l') }})</p>
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
                        <h6 class="mb-0 fw-semibold">Sales Trend (Filtered Period)</h6>
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
                </div>

                <!-- Summary Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <i class="bi bi-box-seam fs-1 text-primary"></i>
                                <h3 class="mt-2">{{ $ingredients->count() }}</h3>
                                <p class="text-muted mb-0 small">Total Ingredients</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-success">
                            <div class="card-body text-center">
                                <i class="bi bi-basket fs-1 text-success"></i>
                                <h3 class="mt-2">{{ $products->count() }}</h3>
                                <p class="text-muted mb-0 small">Total Products</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-warning">
                            <div class="card-body text-center">
                                <i class="bi bi-exclamation-triangle fs-1 text-warning"></i>
                                <h3 class="mt-2">{{ $lowStockIngredients->count() }}</h3>
                                <p class="text-muted mb-0 small">Low Stock Ingredients</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-danger">
                            <div class="card-body text-center">
                                <i class="bi bi-x-circle fs-1 text-danger"></i>
                                <h3 class="mt-2">{{ $lowStockProducts->count() }}</h3>
                                <p class="text-muted mb-0 small">Low Stock Products (<10)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Alerts -->
                @if($lowStockIngredients->count() > 0)
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Warning:</strong> {{ $lowStockIngredients->count() }} ingredient(s) need restocking!
                </div>
                @endif

                <!-- Ingredients Stock Table -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 fw-semibold">Ingredients Inventory</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Ingredient</th>
                                        <th>Current Stock</th>
                                        <th>Unit</th>
                                        <th>Status</th>
                                        <th>Reorder Level</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ingredients as $ingredient)
                                    <tr>
                                        <td class="fw-semibold">{{ $ingredient->name }}</td>
                                        <td>{{ number_format($ingredient->quantity, 2) }}</td>
                                        <td>{{ $ingredient->unit }}</td>
                                        <td>
                                            @if($ingredient->status === 'in_stock')
                                                <span class="badge bg-success">In Stock</span>
                                            @elseif($ingredient->status === 'low_stock')
                                                <span class="badge bg-warning">Low Stock</span>
                                            @else
                                                <span class="badge bg-danger">Out of Stock</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($ingredient->reorder_level ?? 0, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Products Stock Table -->
                <div class="card">
                    <div class="card-header bg-white">
                        <h6 class="mb-0 fw-semibold">Products Inventory</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Stock Quantity</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr class="{{ $product->stock_quantity < 10 ? 'table-warning' : '' }}">
                                        <td class="fw-semibold">{{ $product->name }}</td>
                                        <td>
                                            {{ $product->stock_quantity }} pcs
                                            @if($product->stock_quantity < 10)
                                                <i class="bi bi-exclamation-circle text-warning ms-1"></i>
                                            @endif
                                        </td>
                                        <td>₱{{ number_format($product->price, 2) }}</td>
                                        <td>
                                            @if($product->stock_quantity >= 10)
                                                <span class="badge bg-success">Available</span>
                                            @elseif($product->stock_quantity > 0)
                                                <span class="badge bg-warning">Low Stock</span>
                                            @else
                                                <span class="badge bg-danger">Out of Stock</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Production Reports -->
            <div class="tab-pane fade" id="production" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Production Reports</h5>
                </div>

                <!-- Summary Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-boxes text-primary fs-2"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-muted mb-1 small">Total Units Produced</h6>
                                        <h4 class="mb-0 fw-bold">{{ number_format($totalProduction) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-grid-3x3-gap text-info fs-2"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-muted mb-1 small">Total Batches</h6>
                                        <h4 class="mb-0 fw-bold">{{ number_format($totalBatches) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-check-circle text-success fs-2"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-muted mb-1 small">Success Rate</h6>
                                        <h4 class="mb-0 fw-bold">{{ $successRate }}%</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-calendar-event text-warning fs-2"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-muted mb-1 small">Today's Production ({{ \Carbon\Carbon::now()->format('l') }})</h6>
                                        <h4 class="mb-0 fw-bold">{{ number_format($todayProduction) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Production Status Summary -->
                @if($productionByStatus->count() > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Production Status Summary</h6>
                        <div class="row">
                            @foreach($productionByStatus as $status)
                            <div class="col-md-4 mb-2">
                                <div class="d-flex align-items-center">
                                    <span class="badge 
                                        @if($status->status == 'completed') bg-success
                                        @elseif($status->status == 'failed') bg-danger
                                        @else bg-secondary
                                        @endif
                                        me-2">{{ ucfirst($status->status) }}</span>
                                    <span class="text-muted">{{ $status->count }} batches</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Production by Product -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Production by Product</h6>
                        @if($productionByProduct->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Rank</th>
                                        <th>Product</th>
                                        <th>Total Produced</th>
                                        <th>Batches</th>
                                        <th>Avg per Batch</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productionByProduct as $index => $prod)
                                    <tr>
                                        <td>
                                            @if($index < 3)
                                                <i class="bi bi-trophy-fill 
                                                    @if($index == 0) text-warning
                                                    @elseif($index == 1) text-secondary
                                                    @else text-danger
                                                    @endif"></i>
                                            @else
                                                {{ $index + 1 }}
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $prod->product->name ?? 'Unknown' }}</strong>
                                        </td>
                                        <td>{{ number_format($prod->total_produced) }} units</td>
                                        <td>{{ number_format($prod->batches) }}</td>
                                        <td>{{ number_format($prod->total_produced / $prod->batches, 2) }} units</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i>No production data available for the selected date range.
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Production Logs -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Recent Production Logs</h6>
                        @if($recentProduction->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Produced By</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentProduction as $log)
                                    <tr>
                                        <td>
                                            <small>{{ \Carbon\Carbon::parse($log->produced_at)->format('M d, Y') }}</small><br>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($log->produced_at)->format('h:i A') }}</small>
                                        </td>
                                        <td><strong>{{ $log->product->name ?? 'Unknown' }}</strong></td>
                                        <td>{{ number_format($log->quantity_produced) }} units</td>
                                        <td>
                                            <span class="badge 
                                                @if($log->status == 'completed') bg-success
                                                @elseif($log->status == 'failed') bg-danger
                                                @else bg-secondary
                                                @endif">
                                                {{ ucfirst($log->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $log->producer->fullname ?? 'N/A' }}</td>
                                        <td>
                                            @if($log->notes)
                                                <small>{{ Str::limit($log->notes, 50) }}</small>
                                            @else
                                                <small class="text-muted">-</small>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i>No production logs available for the selected date range.
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Export Functionality -->
            <div class="tab-pane fade" id="export" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Export Functionality</h5>
                </div>
                <p class="text-muted mb-4">Export reports in Excel or PDF formats for external review and analysis.</p>

                <!-- Sales Report Export -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3"><i class="bi bi-graph-up text-primary me-2"></i>Sales Report</h6>
                        <p class="text-muted small mb-3">Export complete sales data including orders, revenue, and product performance for the selected date range.</p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('reports.export.sales', ['format' => 'excel']) }}?start_date={{ $startDate }}&end_date={{ $endDate }}" 
                               class="btn btn-success">
                                <i class="bi bi-file-earmark-excel me-1"></i> Export to Excel
                            </a>
                            <a href="{{ route('reports.export.sales', ['format' => 'pdf']) }}?start_date={{ $startDate }}&end_date={{ $endDate }}" 
                               class="btn btn-danger">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Export to PDF
                            </a>
                        </div>
                        <small class="text-muted mt-2 d-block">
                            <i class="bi bi-calendar-range me-1"></i>
                            Date Range: {{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}
                        </small>
                    </div>
                </div>

                <!-- Inventory Report Export -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3"><i class="bi bi-box-seam text-info me-2"></i>Inventory Report</h6>
                        <p class="text-muted small mb-3">Export current stock levels for all products and ingredients including status and reorder information.</p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('reports.export.inventory', ['format' => 'excel']) }}" 
                               class="btn btn-success">
                                <i class="bi bi-file-earmark-excel me-1"></i> Export to Excel
                            </a>
                            <a href="{{ route('reports.export.inventory', ['format' => 'pdf']) }}" 
                               class="btn btn-danger">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Export to PDF
                            </a>
                        </div>
                        <small class="text-muted mt-2 d-block">
                            <i class="bi bi-calendar-check me-1"></i>
                            As of: {{ \Carbon\Carbon::now()->format('M d, Y h:i A') }}
                        </small>
                    </div>
                </div>

                <!-- Production Report Export -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3"><i class="bi bi-gear-wide-connected text-warning me-2"></i>Production Report</h6>
                        <p class="text-muted small mb-3">Export production logs, batch details, and manufacturing statistics for the selected date range.</p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('reports.export.production', ['format' => 'excel']) }}?start_date={{ $startDate }}&end_date={{ $endDate }}" 
                               class="btn btn-success">
                                <i class="bi bi-file-earmark-excel me-1"></i> Export to Excel
                            </a>
                            <a href="{{ route('reports.export.production', ['format' => 'pdf']) }}?start_date={{ $startDate }}&end_date={{ $endDate }}" 
                               class="btn btn-danger">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Export to PDF
                            </a>
                        </div>
                        <small class="text-muted mt-2 d-block">
                            <i class="bi bi-calendar-range me-1"></i>
                            Date Range: {{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}
                        </small>
                    </div>
                </div>

                <!-- Export Information -->
                <div class="alert alert-info">
                    <h6 class="alert-heading"><i class="bi bi-info-circle me-2"></i>Export Information</h6>
                    <ul class="mb-0 small">
                        <li><strong>Excel Format:</strong> Best for data analysis and manipulation. Contains multiple sheets with detailed data.</li>
                        <li><strong>PDF Format:</strong> Best for printing and archival. Professional formatted reports ready for presentation.</li>
                        <li><strong>Date Filtering:</strong> Sales and Production reports use the currently selected date range from their respective tabs.</li>
                        <li><strong>Inventory Reports:</strong> Always reflect the current stock levels at the time of export.</li>
                    </ul>
                </div>
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

    // Date validation - prevent end date from being before start date
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    
    // Set max date to today for both inputs (can't select future dates)
    const today = new Date().toISOString().split('T')[0];
    startDateInput.setAttribute('max', today);
    endDateInput.setAttribute('max', today);
    
    // When start date changes, update the minimum allowed end date
    startDateInput.addEventListener('change', function() {
        const startDate = this.value;
        // End date cannot be before start date
        endDateInput.setAttribute('min', startDate);
        
        // If end date is now before start date, reset it to start date
        if (endDateInput.value && endDateInput.value < startDate) {
            endDateInput.value = startDate;
        }
    });
    
    // When end date changes, update the maximum allowed start date
    endDateInput.addEventListener('change', function() {
        const endDate = this.value;
        // Start date cannot be after end date
        startDateInput.setAttribute('max', endDate);
    });

    // Filter button
    document.getElementById('filterSales')?.addEventListener('click', function() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        if (!startDate || !endDate) {
            alert('Please select both start and end dates');
            return;
        }
        
        // Extra validation check
        if (new Date(endDate) < new Date(startDate)) {
            alert('End date cannot be before start date!');
            return;
        }

        // Reload page with date filters
        window.location.href = `/reports?start_date=${startDate}&end_date=${endDate}`;
    });

    // Reset button - go back to default (last 30 days)
    document.getElementById('resetDates')?.addEventListener('click', function() {
        window.location.href = '/reports';
    });

    // Sidebar Toggle
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
});
</script>
</body>
</html>