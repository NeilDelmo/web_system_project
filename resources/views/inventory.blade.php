<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management | Cuevas Bread</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #fff9e6, #fff3cd, #fce6a4);
            font-family: 'Poppins', sans-serif;
        }

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
        }

        .sidebar-logo {
            max-height: 100%;
            max-width: 80%;
            object-fit: contain;
        }

        .sidebar .nav-link {
            color: #444;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            margin: 0.25rem 0.75rem;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link.active {
            background-color: #ffee8c;
            font-weight: 600;
            color: #000;
        }

        .sidebar .nav-link:hover {
            background-color: #fff3cd;
            color: #b71c1c;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 1rem;
            width: 100%;
            text-align: center;
            font-size: 0.85rem;
            color: #777;
        }

        .main-content {
            flex-grow: 1;
            padding: 0;
        }

        .page-header {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h2 {
            font-weight: 600;
        }

        .tab-nav .nav-link {
            color: #555;
        }

        .tab-nav .nav-link.active {
            border-bottom: 3px solid #fdd663;
            color: #000;
        }

        .inv-card {
            width: 100%;
            height: 280px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .inv-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
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
        <a href="/dashboard" class="nav-link">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard
        </a>
        <a href="/products" class="nav-link">
            <i class="bi bi-basket-fill me-2"></i>Products
        </a>
        <a href="/inventory" class="nav-link">
            <i class="bi bi-box-seam me-2"></i>Inventory
        </a>
        <a href="/sale_and_orders" class="nav-link">
            <i class="bi bi-cart-check-fill me-2"></i>Sales & Orders
        </a>
        <a href="/production" class="nav-link">
            <i class="bi bi-gear-fill me-2"></i>Production
        </a>
        <a href="/reports" class="nav-link">
            <i class="bi bi-bar-chart-line-fill me-2"></i>Reports
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="d-flex flex-column align-items-center">
            <img src="{{ asset('images/user-avatar.jpg') }}" alt="User" class="rounded-circle mb-2" width="50" height="50">
            <strong>Admin</strong>
            <small class="text-muted">Manager</small>
        </div>
    </div>
</aside>
    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <div>
                <h2>Inventory Management</h2>
                <p class="text-muted mb-0 small">Monitor ingredients, stock levels, and supplier details efficiently.</p>
            </div>
            <button class="btn btn-danger">
                <i class="bi bi-plus-circle me-1"></i> Add Inventory Item
            </button>
        </div>

        <ul class="nav nav-tabs tab-nav bg-white px-4 border-bottom" id="inventoryTabs" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#ingredients" role="tab">Ingredients Stock</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#lowstock" role="tab">Low Stock Alerts</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#storage" role="tab">Storage Locations</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#requests" role="tab">Purchase Requests</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#suppliers" role="tab">Suppliers List</a></li>
        </ul>

        <div class="tab-content p-4" id="inventoryTabsContent">
            <!-- Ingredients Stock -->
            <div class="tab-pane fade show active" id="ingredients" role="tabpanel">
                <h5 class="fw-semibold mb-3">Ingredients Stock</h5>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card inv-card">
                            <div class="card-body">
                                <h6>Flour</h6>
                                <p class="text-muted small">In Stock: 50 kg</p>
                                <span class="badge bg-success-subtle text-success">Sufficient</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card inv-card">
                            <div class="card-body">
                                <h6>Sugar</h6>
                                <p class="text-muted small">In Stock: 20 kg</p>
                                <span class="badge bg-warning-subtle text-warning">Moderate</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card inv-card">
                            <div class="card-body">
                                <h6>Butter</h6>
                                <p class="text-muted small">In Stock: 5 kg</p>
                                <span class="badge bg-danger-subtle text-danger">Low</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Low Stock Alerts -->
            <div class="tab-pane fade" id="lowstock" role="tabpanel">
                <h5 class="fw-semibold mb-3">Low Stock Alerts</h5>
                <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>Butter and yeast are running low. Please restock soon.</div>
                </div>
            </div>

            <!-- Storage Locations -->
            <div class="tab-pane fade" id="storage" role="tabpanel">
                <h5 class="fw-semibold mb-3">Storage Locations</h5>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card inv-card">
                            <div class="card-body">
                                <h6>Warehouse A</h6>
                                <p class="text-muted small">Dry ingredients like flour, sugar, and salt.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card inv-card">
                            <div class="card-body">
                                <h6>Cold Storage</h6>
                                <p class="text-muted small">For butter, milk, and perishable ingredients.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purchase Requests -->
            <div class="tab-pane fade" id="requests" role="tabpanel">
                <h5 class="fw-semibold mb-3">Purchase Requests</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle bg-white">
                        <thead class="table-warning">
                            <tr>
                                <th>Request ID</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Date Requested</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#PR-001</td>
                                <td>Butter</td>
                                <td>20 kg</td>
                                <td><span class="badge bg-info">Pending</span></td>
                                <td>2025-10-25</td>
                            </tr>
                            <tr>
                                <td>#PR-002</td>
                                <td>Yeast</td>
                                <td>10 kg</td>
                                <td><span class="badge bg-success">Approved</span></td>
                                <td>2025-10-20</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Suppliers List -->
            <div class="tab-pane fade" id="suppliers" role="tabpanel">
                <h5 class="fw-semibold mb-3">Suppliers List</h5>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card inv-card">
                            <div class="card-body">
                                <h6>ABC Baking Supplies</h6>
                                <p class="text-muted small">Contact: 0917-123-4567<br>Email: abc@supplies.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card inv-card">
                            <div class="card-body">
                                <h6>Golden Wheat Corp.</h6>
                                <p class="text-muted small">Contact: 0920-555-1111<br>Email: sales@goldenwheat.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="text-center py-3 border-top bg-white small text-muted mt-5">
            &copy; {{ date('Y') }} Cuevas Bread. All rights reserved.
        </footer>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>