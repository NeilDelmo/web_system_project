<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
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
        <a href="/inventory" class="nav-link active">
            <i class="bi bi-box-seam me-2"></i>Inventory
        </a>
        <a href="/sales" class="nav-link">
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
                <h2>Inventory Management</h2>
                <p class="text-muted mb-0 small">Monitor ingredients, stock levels, and supplier details efficiently.</p>
            </div>
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
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Ingredients Stock</h5>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addInventoryModal">
                        <i class="bi bi-plus-circle me-1"></i> Add Inventory Item
                    </button>
                </div>
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

    <!-- Add Inventory Item Modal -->
    <div class="modal fade" id="addInventoryModal" tabindex="-1" aria-labelledby="addInventoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title fw-semibold" id="addInventoryModalLabel">
                        <i class="bi bi-box-seam text-danger me-2"></i> Add Inventory Item
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="addInventoryForm">
                    <div class="modal-body px-4 py-3">
                        <!-- Inventory Info -->
                        <h6 class="fw-semibold mb-3 text-danger">Item Information</h6>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold">Item Name</label>
                                <input type="text" class="form-control" name="item_name" placeholder="Enter item name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-semibold">Category</label>
                                <select class="form-select" name="category" required>
                                    <option selected disabled>Select category</option>
                                    <!-- Add your categories here from the categories management -->
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 mb-3">
                                <label class="form-label small fw-semibold">Quantity</label>
                                <input type="number" class="form-control" name="quantity" min="0" placeholder="0" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small fw-semibold">Unit</label>
                                <select class="form-select" name="unit" required>
                                    <option selected disabled>Select unit</option>
                                    <option>pcs</option>
                                    <option>kg</option>
                                    <option>g</option>
                                    <option>liters</option>
                                    <option>ml</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small fw-semibold">Price per Unit (₱)</label>
                                <input type="text" class="form-control" name="price" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Supplier</label>
                            <input type="text" class="form-control" name="supplier" placeholder="Supplier name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Notes</label>
                            <textarea class="form-control" name="notes" rows="2" placeholder="Optional notes about the item"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer bg-light border-top-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="bi bi-check-circle me-1"></i> Add Item
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