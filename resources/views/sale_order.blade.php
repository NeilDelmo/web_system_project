<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales & Orders</title>
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
            padding: 20px;
            transition: margin-left 0.6s ease;
        }

        .main-content.collapsed {
            margin-left: 80px;
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

        /* Main Content */
        .main-content {
            flex-grow: 1;
            transition: margin-left 0.6s ease;
        }

        .page-header {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .tab-nav .nav-link {
            color: #555;
        }

        .tab-nav .nav-link.active {
            border-bottom: 3px solid #fdd663;
            color: #000;
        }

        /* Cards */
        .card-item {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            text-align: center;
            height: 280px;
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
    <aside class="sidebar position-relative" id="sidebar">
        <div class="brand d-flex align-items-center justify-content-center">
            <img src="{{ asset('images/logo.png') }}" alt="Cuevas Bread Logo" class="sidebar-logo">
            <div class="sidebar-toggle text-dark" id="sidebarToggle">
                <i class="bi bi-chevron-left"></i>
            </div>
        </div>

        <nav class="nav flex-column mt-4">
            <a href="/dashboard" class="nav-link"><i class="bi bi-speedometer2 me-2"></i><span>Dashboard</span></a>
            <a href="/products" class="nav-link"><i class="bi bi-basket-fill me-2"></i><span>Products</span></a>
            <a href="/inventory" class="nav-link"><i class="bi bi-box-seam me-2"></i><span>Inventory</span></a>
            <a href="/sales" class="nav-link active"><i class="bi bi-cart-check-fill me-2"></i><span>Sales & Orders</span></a>
            <a href="/production" class="nav-link"><i class="bi bi-gear-fill me-2"></i><span>Production</span></a>
            @can('view_reports')
            <a href="/reports" class="nav-link"><i class="bi bi-bar-chart-line-fill me-2"></i><span>Reports</span></a>
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
                <h2>Sales & Orders</h2>
                <p class="text-muted mb-0 small">Manage all bakery sales, customers, and order transactions.</p>
            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs tab-nav bg-white px-4 border-bottom" id="salesTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab">Order Management</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="history-tab" data-bs-toggle="tab" href="#history" role="tab">Order History</a>
            </li>
        </ul>

        <div class="tab-content p-4" id="salesTabsContent">
            <!-- Order Management -->
            <div class="tab-pane fade show active" id="orders" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Order Management</h5>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#createOrderModal">
                        <i class="bi bi-plus-circle me-1"></i> Create Order
                    </button>
                </div>

                <p class="text-muted mb-4">Create, view, and update bakery orders.</p>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Type</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Staff</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="ordersTableBody">
                            @forelse($orders as $order)
                            <tr data-order-id="{{ $order->id }}">
                                <td>#{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td><span class="badge bg-info">{{ ucfirst($order->order_type) }}</span></td>
                                <td>{{ $order->customer_name ?? 'Walk-in' }}</td>
                                <td>{{ $order->customer_phone ?? '-' }}</td>
                                <td class="fw-bold">₱{{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    @if($order->status === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($order->status === 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <span class="badge bg-danger">Canceled</span>
                                    @endif
                                </td>
                                <td>{{ $order->staff->fullname ?? 'N/A' }}</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info view-order" data-id="{{ $order->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    @if($order->status === 'pending')
                                    <button class="btn btn-sm btn-warning edit-order" data-id="{{ $order->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    @endif
                                    <button class="btn btn-sm btn-danger delete-order" data-id="{{ $order->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">No orders found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Order History -->
            <div class="tab-pane fade" id="history" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Order History</h5>
                    <div>
                        <button class="btn btn-outline-secondary" id="filterAllOrders">All</button>
                        <button class="btn btn-outline-success" id="filterCompleted">Completed</button>
                        <button class="btn btn-outline-danger" id="filterCanceled">Canceled</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Type</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Items</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody">
                            @foreach($orders->where('status', '!=', 'pending') as $order)
                            <tr data-status="{{ $order->status }}">
                                <td>#{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td><span class="badge bg-info">{{ ucfirst($order->order_type) }}</span></td>
                                <td>{{ $order->customer_name ?? 'Walk-in' }}</td>
                                <td>{{ $order->customer_phone ?? '-' }}</td>
                                <td>{{ $order->items->count() }} item(s)</td>
                                <td class="fw-bold">₱{{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    @if($order->status === 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <span class="badge bg-danger">Canceled</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info view-order-history" data-id="{{ $order->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Summary Cards -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card border-success">
                            <div class="card-body text-center">
                                <h3 class="text-success">{{ $orders->where('status', 'completed')->count() }}</h3>
                                <p class="text-muted mb-0">Completed Orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-danger">
                            <div class="card-body text-center">
                                <h3 class="text-danger">{{ $orders->where('status', 'canceled')->count() }}</h3>
                                <p class="text-muted mb-0">Canceled Orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <h3 class="text-primary">₱{{ number_format($orders->where('status', 'completed')->sum('total_amount'), 2) }}</h3>
                                <p class="text-muted mb-0">Total Revenue</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="text-center py-3 border-top bg-white small text-muted mt-5">
            &copy; {{ date('Y') }} Cuevas Bread. All rights reserved.
        </footer>
    </main>

    <!-- Create Order Modal -->
    <div class="modal fade" id="createOrderModal" tabindex="-1" aria-labelledby="createOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title fw-semibold" id="createOrderModalLabel">
                        <i class="bi bi-cart-plus me-2 text-danger"></i> Create New Order
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="createOrderForm">
                    @csrf
                    <div class="modal-body px-4 py-3">
                        <!-- Order Type -->
                        <h6 class="fw-semibold mb-3 text-danger">Order Information</h6>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Order Type <span class="text-danger">*</span></label>
                                <select class="form-select" name="order_type" required>
                                    <option value="walk-in">Walk-in</option>
                                    <option value="phone">Phone</option>
                                    <option value="online">Online</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Customer Name</label>
                                <input type="text" class="form-control" name="customer_name" placeholder="Optional">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold">Contact Number</label>
                                <input type="text" class="form-control" name="customer_phone" placeholder="09XXXXXXXXX">
                            </div>
                        </div>

                        <!-- Products -->
                        <h6 class="fw-semibold mb-3 text-danger">Products <span class="text-danger">*</span></h6>
                        <div id="orderItemsContainer">
                            <div class="row mb-2 order-item">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Product</label>
                                    <select class="form-select product-select" name="items[0][product_id]" required>
                                        <option value="">Choose product</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock_quantity }}">
                                            {{ $product->name }} - ₱{{ number_format($product->price, 2) }} (Stock: {{ $product->stock_quantity }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold">Quantity</label>
                                    <input type="number" class="form-control quantity-input" name="items[0][quantity]" min="1" value="1" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small fw-semibold">&nbsp;</label>
                                    <button type="button" class="btn btn-danger btn-sm w-100 remove-item" disabled>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger mb-3" id="addItemBtn">
                            <i class="bi bi-plus-circle"></i> Add Another Product
                        </button>

                        <!-- Total Display -->
                        <div class="alert alert-info">
                            <strong>Total Amount:</strong> <span id="totalAmount">₱0.00</span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Order Notes</label>
                            <textarea class="form-control" name="notes" rows="2" placeholder="Special instructions"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer bg-light border-top-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger px-4"><i class="bi bi-check-circle me-1"></i> Create Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Create Customer Modal -->
    <div class="modal fade" id="createCustomerModal" tabindex="-1" aria-labelledby="createCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title fw-semibold" id="createCustomerModalLabel">
                        <i class="bi bi-person-plus-fill text-danger me-2"></i> Add New Customer
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="addCustomerForm">
                    <div class="modal-body px-4 py-3">
                        <!-- Customer Info -->
                        <h6 class="fw-semibold mb-3 text-danger">Customer Information</h6>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold">Full Name</label>
                                <input type="text" class="form-control" name="customer_name" placeholder="Enter full name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold">Contact Number</label>
                                <input type="text" class="form-control" name="contact_number" placeholder="09XXXXXXXXX" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold">Email Address</label>
                                <input type="email" class="form-control" name="email" placeholder="example@email.com">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold">Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Enter address">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold">Customer Type</label>
                                <select class="form-select" name="customer_type">
                                    <option selected disabled>Select type</option>
                                    <option>Walk-in</option>
                                    <option>Regular</option>
                                    <option>Wholesale</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold">Notes</label>
                                <textarea class="form-control" name="notes" rows="1" placeholder="Additional remarks (optional)"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light border-top-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="bi bi-check-circle me-1"></i> Save Customer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
      
    <!-- Create Bulk Order Modal -->
        <div class="modal fade" id="createBulkOrderModal" tabindex="-1" aria-labelledby="createBulkOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
            
            <!-- Header -->
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title fw-semibold" id="createBulkOrderModalLabel">
                <i class="bi bi-boxes text-danger me-2"></i> Create Bulk Order
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form -->
            <form id="bulkOrderForm">
                <div class="modal-body px-4 py-3">

                <!-- Customer Information -->
                <h6 class="fw-semibold mb-3 text-danger">Customer Information</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                    <label class="form-label small fw-semibold">Customer Name</label>
                    <select class="form-select" name="customer_name" required>
                        <option selected disabled>Select existing customer</option>
                        <!-- Dynamic customer list will be inserted here -->
                    </select>
                    </div>
                    <div class="col-md-6">
                    <label class="form-label small fw-semibold">Order Date</label>
                    <input type="date" class="form-control" name="order_date" required>
                    </div>
                </div>

                <!-- Bulk Order Details -->
                <h6 class="fw-semibold mb-3 text-danger">Bulk Order Details</h6>
                <div class="table-responsive mb-3">
                    <table class="table table-bordered align-middle">
                    <thead class="table-warning text-center">
                        <tr>
                        <th>Product</th>
                        <th>Unit Price (₱)</th>
                        <th>Quantity</th>
                        <th>Subtotal (₱)</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="bulkOrderTable">
                        <tr>
                        <td>
                            <select class="form-select" name="product[]">
                            <option selected disabled>Select product</option>
                            <!-- Dynamic product list will be inserted here -->
                            </select>
                        </td>
                        <td><input type="text" class="form-control text-center" name="price[]" placeholder="0.00"></td>
                        <td><input type="number" class="form-control text-center" name="quantity[]" min="1" placeholder="0"></td>
                        <td><input type="text" class="form-control text-center" name="subtotal[]" placeholder="0.00" readonly></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger removeRow">
                            <i class="bi bi-trash"></i>
                            </button>
                        </td>
                        </tr>
                    </tbody>
                    </table>
                    <button type="button" class="btn btn-sm btn-outline-warning" id="addRowBtn">
                    <i class="bi bi-plus-circle me-1"></i> Add Product
                    </button>
                </div>

                <!-- Payment Information -->
                <h6 class="fw-semibold mb-3 text-danger">Payment Information</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                    <label class="form-label small fw-semibold">Payment Method</label>
                    <select class="form-select" name="payment_method">
                        <option>Cash</option>
                        <option>GCash</option>
                        <option>Bank Transfer</option>
                    </select>
                    </div>
                    <div class="col-md-6 mb-3">
                    <label class="form-label small fw-semibold">Total Amount (₱)</label>
                    <input type="text" class="form-control fw-semibold" name="total_amount" placeholder="0.00" readonly>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Order Notes</label>
                    <textarea class="form-control" name="notes" rows="2" placeholder="e.g. Deliver by next Monday, separate per branch."></textarea>
                </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer bg-light border-top-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger px-4">
                    <i class="bi bi-check-circle me-1"></i> Save Bulk Order
                </button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- View Order Modal -->
    <div class="modal fade" id="viewOrderModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="bi bi-eye me-2"></i>Order Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="viewOrderContent">
                    <!-- Order details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Order Modal -->
    <div class="modal fade" id="editOrderModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Update Order Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editOrderForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editOrderId" name="order_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Order Status</label>
                            <select class="form-select" name="status" id="editOrderStatus" required>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="canceled">Canceled</option>
                            </select>
                            <small class="text-muted">Note: Canceling an order will return products to stock</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Notes</label>
                            <textarea class="form-control" name="notes" id="editOrderNotes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Update Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemCount = 1;
    const productsList = @json($products);

    // Calculate total amount
    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.order-item').forEach(item => {
            const select = item.querySelector('.product-select');
            const quantity = parseInt(item.querySelector('.quantity-input').value) || 0;
            const selectedOption = select.options[select.selectedIndex];
            const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            total += price * quantity;
        });
        document.getElementById('totalAmount').textContent = '₱' + total.toFixed(2);
    }

    // Add product item
    document.getElementById('addItemBtn').addEventListener('click', function() {
        const container = document.getElementById('orderItemsContainer');
        const newItem = container.querySelector('.order-item').cloneNode(true);
        
        // Update names
        newItem.querySelectorAll('[name]').forEach(input => {
            input.name = input.name.replace(/\[\d+\]/, `[${itemCount}]`);
            if (input.tagName === 'SELECT') {
                input.selectedIndex = 0;
            } else {
                input.value = input.type === 'number' ? 1 : '';
            }
        });
        
        // Enable remove button
        newItem.querySelector('.remove-item').disabled = false;
        container.appendChild(newItem);
        itemCount++;
        calculateTotal();
    });

    // Remove product item
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-item')) {
            e.target.closest('.order-item').remove();
            calculateTotal();
        }
    });

    // Update total on change
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select') || e.target.classList.contains('quantity-input')) {
            calculateTotal();
        }
    });

    // Create Order Form Submit
    document.getElementById('createOrderForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const items = [];
        
        // Collect items
        document.querySelectorAll('.order-item').forEach((item, index) => {
            const productId = item.querySelector('.product-select').value;
            const quantity = item.querySelector('.quantity-input').value;
            if (productId && quantity) {
                items.push({ product_id: productId, quantity: parseInt(quantity) });
            }
        });

        const data = {
            order_type: formData.get('order_type'),
            customer_name: formData.get('customer_name'),
            customer_phone: formData.get('customer_phone'),
            notes: formData.get('notes'),
            items: items,
            _token: formData.get('_token')
        };

        try {
            const response = await fetch('/orders', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': formData.get('_token')
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                alert('Order created successfully!');
                bootstrap.Modal.getInstance(document.getElementById('createOrderModal')).hide();
                location.reload();
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            alert('Failed to create order');
            console.error(error);
        }
    });

    // View Order
    document.querySelectorAll('.view-order').forEach(btn => {
        btn.addEventListener('click', async function() {
            const orderId = this.getAttribute('data-id');
            
            try {
                const response = await fetch(`/orders/${orderId}`);
                const order = await response.json();
                
                let itemsHtml = '';
                order.items.forEach(item => {
                    itemsHtml += `
                        <tr>
                            <td>${item.product.name}</td>
                            <td>${item.quantity}</td>
                            <td>₱${parseFloat(item.unit_price).toFixed(2)}</td>
                            <td class="fw-bold">₱${parseFloat(item.subtotal).toFixed(2)}</td>
                        </tr>
                    `;
                });

                const content = `
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Order #:</strong> #${String(order.id).padStart(3, '0')}<br>
                            <strong>Type:</strong> ${order.order_type}<br>
                            <strong>Status:</strong> <span class="badge bg-${order.status === 'pending' ? 'warning' : order.status === 'completed' ? 'success' : 'danger'}">${order.status}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Customer:</strong> ${order.customer_name || 'Walk-in'}<br>
                            <strong>Phone:</strong> ${order.customer_phone || '-'}<br>
                            <strong>Date:</strong> ${new Date(order.created_at).toLocaleDateString()}
                        </div>
                    </div>
                    <h6 class="fw-bold mb-2">Order Items:</h6>
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>${itemsHtml}</tbody>
                    </table>
                    <div class="text-end">
                        <h5>Total: ₱${parseFloat(order.total_amount).toFixed(2)}</h5>
                    </div>
                    ${order.notes ? `<div class="mt-3"><strong>Notes:</strong><br>${order.notes}</div>` : ''}
                    <div class="mt-2"><strong>Staff:</strong> ${order.staff?.fullname || 'N/A'}</div>
                `;

                document.getElementById('viewOrderContent').innerHTML = content;
                new bootstrap.Modal(document.getElementById('viewOrderModal')).show();
            } catch (error) {
                alert('Failed to load order details');
                console.error(error);
            }
        });
    });

    // Edit Order
    document.querySelectorAll('.edit-order').forEach(btn => {
        btn.addEventListener('click', async function() {
            const orderId = this.getAttribute('data-id');
            
            try {
                const response = await fetch(`/orders/${orderId}`);
                const order = await response.json();
                
                document.getElementById('editOrderId').value = order.id;
                document.getElementById('editOrderStatus').value = order.status;
                document.getElementById('editOrderNotes').value = order.notes || '';
                
                new bootstrap.Modal(document.getElementById('editOrderModal')).show();
            } catch (error) {
                alert('Failed to load order');
                console.error(error);
            }
        });
    });

    // Update Order
    document.getElementById('editOrderForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const orderId = document.getElementById('editOrderId').value;
        const formData = new FormData(this);

        try {
            const response = await fetch(`/orders/${orderId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token')
                },
                body: formData
            });

            // Add _method=PUT to formData
            formData.append('_method', 'PUT');

            const result = await response.json();

            if (result.success) {
                alert('Order updated successfully!');
                bootstrap.Modal.getInstance(document.getElementById('editOrderModal')).hide();
                location.reload();
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            alert('Failed to update order');
            console.error(error);
        }
    });

    // Delete Order
    document.querySelectorAll('.delete-order').forEach(btn => {
        btn.addEventListener('click', async function() {
            if (!confirm('Are you sure you want to delete this order? Stock will be returned if order is not canceled.')) {
                return;
            }

            const orderId = this.getAttribute('data-id');
            const token = document.querySelector('input[name="_token"]').value;

            try {
                const response = await fetch(`/orders/${orderId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    alert('Order deleted successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Failed to delete order');
                console.error(error);
            }
        });
    });

    // Order History Filters
    document.getElementById('filterAllOrders')?.addEventListener('click', function() {
        document.querySelectorAll('#historyTableBody tr').forEach(row => {
            row.style.display = '';
        });
    });

    document.getElementById('filterCompleted')?.addEventListener('click', function() {
        document.querySelectorAll('#historyTableBody tr').forEach(row => {
            if (row.getAttribute('data-status') === 'completed') {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    document.getElementById('filterCanceled')?.addEventListener('click', function() {
        document.querySelectorAll('#historyTableBody tr').forEach(row => {
            if (row.getAttribute('data-status') === 'canceled') {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // View Order from History
    document.querySelectorAll('.view-order-history').forEach(btn => {
        btn.addEventListener('click', async function() {
            const orderId = this.getAttribute('data-id');
            
            try {
                const response = await fetch(`/orders/${orderId}`);
                const order = await response.json();
                
                let itemsHtml = '';
                order.items.forEach(item => {
                    itemsHtml += `
                        <tr>
                            <td>${item.product.name}</td>
                            <td>${item.quantity}</td>
                            <td>₱${parseFloat(item.unit_price).toFixed(2)}</td>
                            <td class="fw-bold">₱${parseFloat(item.subtotal).toFixed(2)}</td>
                        </tr>
                    `;
                });

                const content = `
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Order #:</strong> #${String(order.id).padStart(3, '0')}<br>
                            <strong>Type:</strong> ${order.order_type}<br>
                            <strong>Status:</strong> <span class="badge bg-${order.status === 'pending' ? 'warning' : order.status === 'completed' ? 'success' : 'danger'}">${order.status}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Customer:</strong> ${order.customer_name || 'Walk-in'}<br>
                            <strong>Phone:</strong> ${order.customer_phone || '-'}<br>
                            <strong>Date:</strong> ${new Date(order.created_at).toLocaleDateString()}
                        </div>
                    </div>
                    <h6 class="fw-bold mb-2">Order Items:</h6>
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>${itemsHtml}</tbody>
                    </table>
                    <div class="text-end">
                        <h5>Total: ₱${parseFloat(order.total_amount).toFixed(2)}</h5>
                    </div>
                    ${order.notes ? `<div class="mt-3"><strong>Notes:</strong><br>${order.notes}</div>` : ''}
                    <div class="mt-2"><strong>Staff:</strong> ${order.staff?.fullname || 'N/A'}</div>
                `;

                document.getElementById('viewOrderContent').innerHTML = content;
                new bootstrap.Modal(document.getElementById('viewOrderModal')).show();
            } catch (error) {
                alert('Failed to load order details');
                console.error(error);
            }
        });
    });
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
</script>
</body>
</html>