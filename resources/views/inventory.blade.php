<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#lowstock" role="tab">
                    Low Stock Alerts 
                    @if($lowStockIngredients->count() > 0)
                        <span class="badge bg-warning text-dark ms-1">{{ $lowStockIngredients->count() }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#requests" role="tab">Purchase Requests</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#suppliers" role="tab">Suppliers List</a></li>
        </ul>

        <div class="tab-content p-4" id="inventoryTabsContent">
            <!-- Ingredients Stock -->
            <div class="tab-pane fade show active" id="ingredients" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Ingredients Inventory</h5>
                    <div class="d-flex gap-2">
                        <div class="d-flex align-items-center">
                            <label class="me-2 small fw-semibold">Sort by:</label>
                            <select class="form-select form-select-sm" id="sortBy" style="width: auto;">
                                <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Name (A-Z)</option>
                                <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>Name (Z-A)</option>
                                <option value="quantity-asc" {{ request('sort') == 'quantity-asc' ? 'selected' : '' }}>Quantity (Low-High)</option>
                                <option value="quantity-desc" {{ request('sort') == 'quantity-desc' ? 'selected' : '' }}>Quantity (High-Low)</option>
                                <option value="category-asc" {{ request('sort') == 'category-asc' ? 'selected' : '' }}>Category (A-Z)</option>
                                <option value="status-asc" {{ request('sort') == 'status-asc' ? 'selected' : '' }}>Status</option>
                            </select>
                        </div>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addIngredientModal">
                            <i class="bi bi-plus-circle me-1"></i> Add Ingredient
                        </button>
                    </div>
                </div>
                <p class="text-muted mb-4">Manage your bakery's ingredient stock and inventory levels.</p>

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle bg-white">
                        <thead class="table-warning">
                            <tr>
                                <th>Ingredient Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Reorder Level</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ingredients as $ingredient)
                            <tr>
                                <td><strong>{{ $ingredient->name }}</strong></td>
                                <td>{{ $ingredient->category }}</td>
                                <td>
                                    <span class="badge 
                                        @if($ingredient->quantity == 0) bg-danger
                                        @elseif($ingredient->quantity <= $ingredient->reorder_level) bg-warning
                                        @else bg-success
                                        @endif">
                                        {{ $ingredient->quantity }}
                                    </span>
                                </td>
                                <td>{{ $ingredient->unit }}</td>
                                <td>{{ $ingredient->reorder_level }}</td>
                                <td>
                                    <span class="badge 
                                        @if($ingredient->status == 'out_of_stock') bg-danger
                                        @elseif($ingredient->status == 'low_stock') bg-warning
                                        @else bg-success
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $ingredient->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning text-white view-ingredient" data-ingredient-id="{{ $ingredient->id }}" title="View">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary edit-ingredient" data-ingredient-id="{{ $ingredient->id }}" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-ingredient" data-ingredient-id="{{ $ingredient->id }}" data-ingredient-name="{{ $ingredient->name }}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-basket fs-1 d-block mb-2"></i>
                                    No ingredients found. Add your first ingredient!
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Low Stock Alerts -->
            <div class="tab-pane fade" id="lowstock" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Low Stock Alerts</h5>
                    <span class="badge bg-warning text-dark fs-6">{{ $lowStockIngredients->count() }} items need attention</span>
                </div>
                <p class="text-muted mb-4">Ingredients that are at or below their reorder level.</p>

                @if($lowStockIngredients->count() > 0)
                    <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                        <div>
                            <strong>Action Required!</strong> The following ingredients are running low and need restocking.
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle bg-white">
                            <thead class="table-warning">
                                <tr>
                                    <th>Ingredient Name</th>
                                    <th>Category</th>
                                    <th>Current Qty</th>
                                    <th>Reorder Level</th>
                                    <th>Unit</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStockIngredients as $ingredient)
                                <tr class="{{ $ingredient->status == 'out_of_stock' ? 'table-danger' : '' }}">
                                    <td><strong>{{ $ingredient->name }}</strong></td>
                                    <td>{{ $ingredient->category }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($ingredient->quantity == 0) bg-danger
                                            @else bg-warning
                                            @endif">
                                            {{ $ingredient->quantity }}
                                        </span>
                                    </td>
                                    <td>{{ $ingredient->reorder_level }}</td>
                                    <td>{{ $ingredient->unit }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($ingredient->status == 'out_of_stock') bg-danger
                                            @else bg-warning
                                            @endif">
                                            @if($ingredient->status == 'out_of_stock')
                                                <i class="bi bi-exclamation-circle-fill me-1"></i> Out of Stock
                                            @else
                                                <i class="bi bi-exclamation-triangle-fill me-1"></i> Low Stock
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning text-white view-ingredient" data-ingredient-id="{{ $ingredient->id }}" title="View">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success edit-ingredient" data-ingredient-id="{{ $ingredient->id }}" title="Restock">
                                            <i class="bi bi-box-arrow-in-down"></i> Restock
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                        <div>
                            <strong>All Good!</strong> All ingredients are sufficiently stocked. No action required at this time.
                        </div>
                    </div>
                @endif
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

    <!-- Add Ingredient Modal -->
    <div class="modal fade" id="addIngredientModal" tabindex="-1" aria-labelledby="addIngredientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title fw-semibold" id="addIngredientModalLabel">
                        <i class="bi bi-plus-circle text-danger me-2"></i> Add New Ingredient
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <form action="{{ route('ingredients.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ingredient Name</label>
                            <input type="text" class="form-control" name="name" placeholder="e.g., All-purpose Flour" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Category</label>
                                <input type="text" class="form-control" name="category" placeholder="e.g., Flour, Sugar, Dairy" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Unit</label>
                                <select class="form-select" name="unit" required>
                                    <option value="">Select unit</option>
                                    <option value="kg">Kilogram (kg)</option>
                                    <option value="g">Gram (g)</option>
                                    <option value="L">Liter (L)</option>
                                    <option value="mL">Milliliter (mL)</option>
                                    <option value="pcs">Pieces (pcs)</option>
                                    <option value="bag">Bag</option>
                                    <option value="box">Box</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Initial Quantity</label>
                                <input type="number" class="form-control" name="quantity" step="0.01" min="0" placeholder="0.00" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Reorder Level</label>
                                <input type="number" class="form-control" name="reorder_level" step="0.01" min="0" placeholder="0.00" required>
                                <small class="text-muted">Alert when stock reaches this level</small>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Save Ingredient</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Ingredient Modal -->
    <div class="modal fade" id="viewIngredientModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title fw-semibold"><i class="bi bi-eye me-2"></i> View Ingredient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ingredient Name:</label>
                        <p id="view-ingredient-name"></p>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Category:</label>
                            <p id="view-ingredient-category"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Unit:</label>
                            <p id="view-ingredient-unit"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Quantity:</label>
                            <p id="view-ingredient-quantity"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Reorder Level:</label>
                            <p id="view-ingredient-reorder"></p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status:</label>
                        <p id="view-ingredient-status"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Ingredient Modal -->
    <div class="modal fade" id="editIngredientModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title fw-semibold"><i class="bi bi-pencil me-2"></i> Edit Ingredient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="editIngredientForm" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ingredient Name</label>
                            <input type="text" class="form-control" id="edit-ingredient-name" name="name" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Category</label>
                                <input type="text" class="form-control" id="edit-ingredient-category" name="category" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Unit</label>
                                <select class="form-select" id="edit-ingredient-unit" name="unit" required>
                                    <option value="">Select unit</option>
                                    <option value="kg">Kilogram (kg)</option>
                                    <option value="g">Gram (g)</option>
                                    <option value="L">Liter (L)</option>
                                    <option value="mL">Milliliter (mL)</option>
                                    <option value="pcs">Pieces (pcs)</option>
                                    <option value="bag">Bag</option>
                                    <option value="box">Box</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Quantity</label>
                                <input type="number" class="form-control" id="edit-ingredient-quantity" name="quantity" step="0.01" min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Reorder Level</label>
                                <input type="number" class="form-control" id="edit-ingredient-reorder" name="reorder_level" step="0.01" min="0" required>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Update Ingredient</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // View Ingredient
    document.querySelectorAll('.view-ingredient').forEach(button => {
        button.addEventListener('click', function() {
            const ingredientId = this.getAttribute('data-ingredient-id');
            
            fetch(`/ingredients/${ingredientId}`)
                .then(response => response.json())
                .then(ingredient => {
                    document.getElementById('view-ingredient-name').textContent = ingredient.name;
                    document.getElementById('view-ingredient-category').textContent = ingredient.category;
                    document.getElementById('view-ingredient-unit').textContent = ingredient.unit;
                    document.getElementById('view-ingredient-quantity').textContent = ingredient.quantity;
                    document.getElementById('view-ingredient-reorder').textContent = ingredient.reorder_level;
                    
                    let statusBadge = '';
                    if (ingredient.status === 'out_of_stock') {
                        statusBadge = '<span class="badge bg-danger">Out of Stock</span>';
                    } else if (ingredient.status === 'low_stock') {
                        statusBadge = '<span class="badge bg-warning">Low Stock</span>';
                    } else {
                        statusBadge = '<span class="badge bg-success">In Stock</span>';
                    }
                    document.getElementById('view-ingredient-status').innerHTML = statusBadge;
                    
                    const viewModal = new bootstrap.Modal(document.getElementById('viewIngredientModal'));
                    viewModal.show();
                })
                .catch(error => console.error('Error:', error));
        });
    });

    // Edit Ingredient
    document.querySelectorAll('.edit-ingredient').forEach(button => {
        button.addEventListener('click', function() {
            const ingredientId = this.getAttribute('data-ingredient-id');
            
            fetch(`/ingredients/${ingredientId}`)
                .then(response => response.json())
                .then(ingredient => {
                    document.getElementById('edit-ingredient-name').value = ingredient.name;
                    document.getElementById('edit-ingredient-category').value = ingredient.category;
                    document.getElementById('edit-ingredient-unit').value = ingredient.unit;
                    document.getElementById('edit-ingredient-quantity').value = ingredient.quantity;
                    document.getElementById('edit-ingredient-reorder').value = ingredient.reorder_level;
                    
                    document.getElementById('editIngredientForm').action = `/ingredients/${ingredientId}`;
                    
                    const editModal = new bootstrap.Modal(document.getElementById('editIngredientModal'));
                    editModal.show();
                })
                .catch(error => console.error('Error:', error));
        });
    });

    // Delete Ingredient
    document.querySelectorAll('.delete-ingredient').forEach(button => {
        button.addEventListener('click', function() {
            const ingredientId = this.getAttribute('data-ingredient-id');
            const ingredientName = this.getAttribute('data-ingredient-name');
            
            if (confirm(`Are you sure you want to delete "${ingredientName}"? This action cannot be undone and may affect recipes that use this ingredient.`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/ingredients/${ingredientId}`;
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                const csrfField = document.createElement('input');
                csrfField.type = 'hidden';
                csrfField.name = '_token';
                csrfField.value = csrfToken;
                
                form.appendChild(methodField);
                form.appendChild(csrfField);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    // Sort functionality
    document.getElementById('sortBy').addEventListener('change', function() {
        const sortValue = this.value;
        const url = new URL(window.location.href);
        url.searchParams.set('sort', sortValue);
        window.location.href = url.toString();
    });
</script>
</body>
</html>