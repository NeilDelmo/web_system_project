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
    <aside class="sidebar position-relative">
        <div class="brand d-flex align-items-center justify-content-center">
            <img src="{{ asset('images/logo.png') }}" alt="Cuevas Bread Logo" class="sidebar-logo">
        </div>

        <nav class="nav flex-column mt-4">
            <a href="/dashboard" class="nav-link"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
            <a href="/products" class="nav-link"><i class="bi bi-basket-fill me-2"></i>Products</a>
            <a href="/inventory" class="nav-link"><i class="bi bi-box-seam me-2"></i>Inventory</a>
            <a href="/sales" class="nav-link active"><i class="bi bi-cart-check-fill me-2"></i>Sales & Orders</a>
            <a href="/production" class="nav-link"><i class="bi bi-gear-fill me-2"></i>Production</a>
            <a href="/reports" class="nav-link"><i class="bi bi-bar-chart-line-fill me-2"></i>Reports</a>
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
                <a class="nav-link" id="customers-tab" data-bs-toggle="tab" href="#customers" role="tab">Customer Management</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="history-tab" data-bs-toggle="tab" href="#history" role="tab">Order History</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="bulk-tab" data-bs-toggle="tab" href="#bulk" role="tab">Bulk Orders</a>
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

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card card-item">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-1">Order #001</h6>
                                <p class="text-muted small mb-1">Customer: Juan Dela Cruz</p>
                                <p class="text-success fw-bold mb-1">₱320.00</p>
                                <span class="badge bg-success-subtle text-success mb-3">Completed</span>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-warning text-white"><i class="bi bi-eye"></i> View</button>
                                    <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i> Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Management -->
            <div class="tab-pane fade" id="customers" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Customer Management</h5>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#createCustomerModal">
                        <i class="bi bi-person-plus me-1"></i> Add Customer</button>
                </div>
                <p class="text-muted mb-4">View, add, and manage your customers.</p>
            </div>

            <!-- Order History -->
            <div class="tab-pane fade" id="history" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Order History</h5>
                    <button class="btn btn-outline-secondary"><i class="bi bi-download me-1"></i> Export</button>
                </div>
            </div>

            <!-- Bulk Orders  -->
            <div class="tab-pane fade" id="bulk" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Bulk Orders</h5>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#createBulkOrderModal">
                    <i class="bi bi-plus-circle me-1"></i> Add Bulk Order
                    </button>
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

                <form>
                    <div class="modal-body px-4 py-3">
                        <!-- Customer Info -->
                        <h6 class="fw-semibold mb-3 text-danger">Customer Information</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Customer Name</label>
                                <select class="form-select" id="customerSelect" required>
                                    <option selected disabled>Select existing customer</option>
                                    <!-- Dynamic list of customers will be loaded here -->
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Contact Number</label>
                                <input type="text" class="form-control" id="customerContact" placeholder="09XXXXXXXXX" readonly>
                            </div>
                        </div>
                     

                        <!-- Order Details -->
                        <h6 class="fw-semibold mb-3 text-danger">Order Details</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Select Product</label>
                                <select class="form-select">
                                    <option selected disabled>Choose product</option>
                                    <!-- Dynamic product list will be inserted here -->
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold">Quantity</label>
                                <input type="number" class="form-control" min="1" placeholder="0">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold">Price (₱)</label>
                                <input type="text" class="form-control" placeholder="0.00">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Order Notes</label>
                            <textarea class="form-control" rows="2" placeholder="e.g. No sugar on top, pack separately."></textarea>
                        </div>

                        <!-- Payment Info -->
                        <h6 class="fw-semibold mb-3 text-danger">Payment Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Payment Method</label>
                                <select class="form-select">
                                    <option>Cash</option>
                                    <option>GCash</option>
                                    <option>Bank Transfer</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Total Amount (₱)</label>
                                <input type="text" class="form-control fw-semibold" placeholder="0.00">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light border-top-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger px-4"><i class="bi bi-check-circle me-1"></i> Save Order</button>
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

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>