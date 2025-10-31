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
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Purchase Requests</h5>
                    @role('admin')
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#createPurchaseRequestModal">
                            <i class="bi bi-plus-circle"></i> New Request
                        </button>
                    @endrole
                </div>

                @if($purchaseRequests->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle bg-white">
                            <thead class="table-warning">
                                <tr>
                                    <th>Request ID</th>
                                    <th>Ingredient</th>
                                    <th>Supplier</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Requested By</th>
                                    <th>Date Needed</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchaseRequests as $request)
                                    <tr>
                                        <td>#PR-{{ str_pad($request->id, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $request->ingredient->name }}</td>
                                        <td>{{ $request->supplier ? $request->supplier->name : 'N/A' }}</td>
                                        <td>{{ number_format($request->requested_quantity, 2) }} {{ $request->unit }}</td>
                                        <td>
                                            @if($request->status === 'requested')
                                                <span class="badge bg-warning text-dark">Requested</span>
                                            @elseif($request->status === 'received')
                                                <span class="badge bg-success">Received</span>
                                            @else
                                                <span class="badge bg-danger">Cancelled</span>
                                            @endif
                                        </td>
                                        <td>{{ $request->requestedBy ? $request->requestedBy->fullname : 'Admin' }}</td>
                                        <td>{{ $request->date_needed ? $request->date_needed->format('Y-m-d') : 'N/A' }}</td>
                                        <td>{{ $request->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info view-purchase-request" 
                                                    data-request-id="{{ $request->id }}"
                                                    data-ingredient="{{ $request->ingredient->name }}"
                                                    data-supplier="{{ $request->supplier ? $request->supplier->name : 'N/A' }}"
                                                    data-quantity="{{ $request->requested_quantity }}"
                                                    data-unit="{{ $request->unit }}"
                                                    data-status="{{ $request->status }}"
                                                    data-notes="{{ $request->notes }}"
                                                    data-requested-by="{{ $request->requestedBy ? $request->requestedBy->fullname : 'Admin' }}"
                                                    data-date-needed="{{ $request->date_needed ? $request->date_needed->format('Y-m-d') : '' }}"
                                                    data-created="{{ $request->created_at->format('Y-m-d H:i') }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            @role('admin')
                                                @if($request->status !== 'received' && $request->status !== 'cancelled')
                                                    <button class="btn btn-sm btn-primary edit-purchase-request"
                                                            data-request-id="{{ $request->id }}"
                                                            data-status="{{ $request->status }}"
                                                            data-notes="{{ $request->notes }}">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                @endif
                                                <button class="btn btn-sm btn-danger delete-purchase-request" 
                                                        data-request-id="{{ $request->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            @endrole
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No purchase requests found. Click "New Request" to create one.
                    </div>
                @endif
            </div>

            <!-- Suppliers List -->
            <div class="tab-pane fade" id="suppliers" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Suppliers List</h5>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#createSupplierModal">
                        <i class="bi bi-plus-circle"></i> Add Supplier
                    </button>
                </div>

                @if($suppliers->count() > 0)
                    <div class="row g-4" id="suppliers-grid">
                        @foreach($suppliers as $supplier)
                            <div class="col-md-4" data-supplier-id="{{ $supplier->id }}">
                                <div class="card inv-card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="mb-0">{{ $supplier->name }}</h6>
                                            @if($supplier->status === 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </div>
                                        @if($supplier->contact_person)
                                            <p class="text-muted small mb-1"><i class="bi bi-person"></i> {{ $supplier->contact_person }}</p>
                                        @endif
                                        @if($supplier->phone)
                                            <p class="text-muted small mb-1"><i class="bi bi-telephone"></i> {{ $supplier->phone }}</p>
                                        @endif
                                        @if($supplier->email)
                                            <p class="text-muted small mb-1"><i class="bi bi-envelope"></i> {{ $supplier->email }}</p>
                                        @endif
                                        @if($supplier->address)
                                            <p class="text-muted small mb-2"><i class="bi bi-geo-alt"></i> {{ $supplier->address }}</p>
                                        @endif
                                        <div class="mt-3">
                                            <button class="btn btn-sm btn-info view-supplier"
                                                    data-supplier-id="{{ $supplier->id }}"
                                                    data-name="{{ $supplier->name }}"
                                                    data-contact-person="{{ $supplier->contact_person }}"
                                                    data-phone="{{ $supplier->phone }}"
                                                    data-email="{{ $supplier->email }}"
                                                    data-address="{{ $supplier->address }}"
                                                    data-status="{{ $supplier->status }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-primary edit-supplier"
                                                    data-supplier-id="{{ $supplier->id }}"
                                                    data-name="{{ $supplier->name }}"
                                                    data-contact-person="{{ $supplier->contact_person }}"
                                                    data-phone="{{ $supplier->phone }}"
                                                    data-email="{{ $supplier->email }}"
                                                    data-address="{{ $supplier->address }}"
                                                    data-status="{{ $supplier->status }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger delete-supplier"
                                                    data-supplier-id="{{ $supplier->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No suppliers found. Click "Add Supplier" to create one.
                    </div>
                @endif
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

    <!-- Create Purchase Request Modal -->
    <div class="modal fade" id="createPurchaseRequestModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title fw-semibold"><i class="bi bi-plus-circle me-2"></i> New Purchase Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="createPurchaseRequestForm" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ingredient <span class="text-danger">*</span></label>
                            <select class="form-select" id="create-ingredient-select" name="ingredient_id" required>
                                <option value="">Select ingredient</option>
                                @foreach($ingredients as $ingredient)
                                    <option value="{{ $ingredient->id }}">{{ $ingredient->name }} ({{ $ingredient->unit }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Supplier <span class="text-danger">*</span></label>
                            <select class="form-select" id="create-supplier-select" name="supplier_id" required>
                                <option value="">Select ingredient first</option>
                            </select>
                            <small class="text-muted">Select a supplier who provides this ingredient</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Quantity Needed <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="requested_quantity" step="0.01" min="0.01" required>
                            <small class="text-muted">Enter the quantity you need to order</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Date Needed</label>
                            <input type="date" class="form-control" name="date_needed" min="{{ date('Y-m-d') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Notes</label>
                            <textarea class="form-control" name="notes" rows="3" placeholder="Optional notes or special instructions"></textarea>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning">Create Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Purchase Request Modal -->
    <div class="modal fade" id="viewPurchaseRequestModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header bg-info-subtle">
                    <h5 class="modal-title fw-semibold"><i class="bi bi-eye me-2"></i> Purchase Request Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold text-muted small">Ingredient</label>
                            <p class="mb-0" id="view-pr-ingredient"></p>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold text-muted small">Supplier</label>
                            <p class="mb-0" id="view-pr-supplier"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold text-muted small">Quantity</label>
                            <p class="mb-0" id="view-pr-quantity"></p>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold text-muted small">Status</label>
                            <p class="mb-0 text-capitalize" id="view-pr-status"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold text-muted small">Requested By</label>
                            <p class="mb-0" id="view-pr-requested-by"></p>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold text-muted small">Date Needed</label>
                            <p class="mb-0" id="view-pr-date-needed"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold text-muted small">Date Needed</label>
                            <p class="mb-0" id="view-pr-date-needed"></p>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold text-muted small">Created</label>
                            <p class="mb-0" id="view-pr-created"></p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Notes</label>
                        <p class="mb-0 text-muted" id="view-pr-notes"></p>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Purchase Request Modal -->
    <div class="modal fade" id="editPurchaseRequestModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title fw-semibold"><i class="bi bi-pencil me-2"></i> Update Purchase Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="editPurchaseRequestForm" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit-pr-status" name="status" required>
                                <option value="requested">Requested</option>
                                <option value="received">Received</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Notes</label>
                            <textarea class="form-control" id="edit-pr-notes" name="notes" rows="3"></textarea>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning">Update Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Supplier Modal -->
    <div class="modal fade" id="createSupplierModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title fw-semibold"><i class="bi bi-plus-circle me-2"></i> Add New Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="createSupplierForm" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Supplier Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Contact Person</label>
                            <input type="text" class="form-control" name="contact_person">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" class="form-control" name="phone">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Address</label>
                            <textarea class="form-control" name="address" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ingredients Supplied</label>
                            <select class="form-select" id="create-supplier-ingredients" multiple size="5">
                                @foreach($ingredients as $ingredient)
                                    <option value="{{ $ingredient->id }}">{{ $ingredient->name }} ({{ $ingredient->unit }})</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple ingredients</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning">Add Supplier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Supplier Modal -->
    <div class="modal fade" id="viewSupplierModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header bg-info-subtle">
                    <h5 class="modal-title fw-semibold"><i class="bi bi-eye me-2"></i> Supplier Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Supplier Name</label>
                        <p class="mb-0" id="view-supplier-name"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Contact Person</label>
                        <p class="mb-0" id="view-supplier-contact"></p>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold text-muted small">Phone</label>
                            <p class="mb-0" id="view-supplier-phone"></p>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold text-muted small">Email</label>
                            <p class="mb-0" id="view-supplier-email"></p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Address</label>
                        <p class="mb-0" id="view-supplier-address"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">Status</label>
                        <p class="mb-0" id="view-supplier-status"></p>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Supplier Modal -->
    <div class="modal fade" id="editSupplierModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title fw-semibold"><i class="bi bi-pencil me-2"></i> Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="editSupplierForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Supplier Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit-supplier-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Contact Person</label>
                            <input type="text" class="form-control" id="edit-supplier-contact" name="contact_person">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" class="form-control" id="edit-supplier-phone" name="phone">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" id="edit-supplier-email" name="email">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Address</label>
                            <textarea class="form-control" id="edit-supplier-address" name="address" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ingredients Supplied</label>
                            <select class="form-select" id="edit-supplier-ingredients" multiple size="5">
                                @foreach($ingredients as $ingredient)
                                    <option value="{{ $ingredient->id }}">{{ $ingredient->name }} ({{ $ingredient->unit }})</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple ingredients</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit-supplier-status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning">Update Supplier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Activate tab from URL hash on page load
    window.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash;
        if (hash) {
            const tabTrigger = document.querySelector(`a[href="${hash}"]`);
            if (tabTrigger) {
                const tab = new bootstrap.Tab(tabTrigger);
                tab.show();
            }
        }
    });

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
        // Preserve the ingredients tab when sorting
        url.hash = '#ingredients';
        window.location.href = url.toString();
    });

    // ========================================
    // PURCHASE REQUEST HANDLERS
    // ========================================

    // Load suppliers when ingredient is selected
    document.getElementById('create-ingredient-select').addEventListener('change', function() {
        const ingredientId = this.value;
        const supplierSelect = document.getElementById('create-supplier-select');
        
        if (!ingredientId) {
            supplierSelect.innerHTML = '<option value="">Select ingredient first</option>';
            supplierSelect.disabled = true;
            return;
        }
        
        // Show loading
        supplierSelect.innerHTML = '<option value="">Loading suppliers...</option>';
        supplierSelect.disabled = true;
        
        // Fetch suppliers for this ingredient
        fetch(`/ingredients/${ingredientId}/suppliers`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data.length > 0) {
                    const unit = data.ingredient_unit || 'unit';
                    supplierSelect.innerHTML = '<option value="">Select a supplier</option>';
                    data.data.forEach(supplier => {
                        const option = document.createElement('option');
                        option.value = supplier.id;
                        option.textContent = supplier.name;
                        if (supplier.pivot && supplier.pivot.unit_price) {
                            option.textContent += ` (₱${parseFloat(supplier.pivot.unit_price).toFixed(2)}/${unit})`;
                        }
                        supplierSelect.appendChild(option);
                    });
                    supplierSelect.disabled = false;
                } else {
                    supplierSelect.innerHTML = '<option value="">No suppliers found for this ingredient</option>';
                    supplierSelect.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error loading suppliers:', error);
                supplierSelect.innerHTML = '<option value="">Error loading suppliers</option>';
                supplierSelect.disabled = true;
            });
    });

    // Create Purchase Request
    let isSubmittingPurchaseRequest = false;
    document.getElementById('createPurchaseRequestForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Prevent duplicate submissions
        if (isSubmittingPurchaseRequest) {
            return;
        }
        isSubmittingPurchaseRequest = true;
        
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Creating...';
        
        const formData = new FormData(this);
        
        fetch('/purchase-requests/store', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('createPurchaseRequestModal')).hide();
                
                // Add new row to table dynamically
                addPurchaseRequestRow(data.data);
                
                // Reset form and button
                document.getElementById('createPurchaseRequestForm').reset();
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
                isSubmittingPurchaseRequest = false;
                
                // Show success message
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while creating the purchase request.');
            submitButton.disabled = false;
            submitButton.innerHTML = originalText;
            isSubmittingPurchaseRequest = false;
        });
    });

    // Helper function to add purchase request row dynamically
    function addPurchaseRequestRow(request) {
        const tbody = document.querySelector('#requests tbody');
        
        // Remove "no requests" message if exists
        const noDataAlert = document.querySelector('#requests .alert-info');
        if (noDataAlert) {
            noDataAlert.remove();
            // Show table if hidden
            const tableDiv = document.querySelector('#requests .table-responsive');
            if (tableDiv) {
                tableDiv.style.display = 'block';
            }
        }

        // Create table if it doesn't exist
        if (!tbody) {
            const requestsTab = document.getElementById('requests');
            const tableHtml = `
                <div class="table-responsive">
                    <table class="table table-bordered align-middle bg-white">
                        <thead class="table-warning">
                            <tr>
                                <th>Request ID</th>
                                <th>Ingredient</th>
                                <th>Supplier</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Requested By</th>
                                <th>Date Needed</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            `;
            requestsTab.insertAdjacentHTML('beforeend', tableHtml);
        }

        const tbody2 = document.querySelector('#requests tbody');
        const statusBadgeClass = getStatusBadgeClass(request.status);
        const requestId = String(request.id).padStart(3, '0');
        const dateNeeded = request.date_needed ? new Date(request.date_needed).toISOString().split('T')[0] : 'N/A';
        const createdAt = new Date(request.created_at).toISOString().split('T')[0];
        
        const supplierName = request.supplier ? request.supplier.name : 'N/A';
        
        const row = `
            <tr>
                <td>#PR-${requestId}</td>
                <td>${request.ingredient.name}</td>
                <td>${supplierName}</td>
                <td>${parseFloat(request.requested_quantity).toFixed(2)} ${request.unit}</td>
                <td><span class="badge ${statusBadgeClass}">${capitalizeFirst(request.status)}</span></td>
                <td>${request.requested_by.fullname}</td>
                <td>${dateNeeded}</td>
                <td>${createdAt}</td>
                <td>
                    <button class="btn btn-sm btn-info view-purchase-request" 
                            data-request-id="${request.id}"
                            data-ingredient="${request.ingredient.name}"
                            data-supplier="${supplierName}"
                            data-quantity="${request.requested_quantity}"
                            data-unit="${request.unit}"
                            data-status="${request.status}"
                            data-notes="${request.notes || ''}"
                            data-requested-by="${request.requested_by.fullname}"
                            data-date-needed="${dateNeeded}"
                            data-created="${createdAt}">
                        <i class="bi bi-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-primary edit-purchase-request"
                            data-request-id="${request.id}"
                            data-status="${request.status}"
                            data-notes="${request.notes || ''}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger delete-purchase-request" 
                            data-request-id="${request.id}">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        
        tbody2.insertAdjacentHTML('afterbegin', row);
        
        // Reattach event listeners to new buttons
        attachPurchaseRequestEventListeners();
    }

    function getStatusBadgeClass(status) {
        const badges = {
            'requested': 'bg-warning text-dark',
            'received': 'bg-success',
            'cancelled': 'bg-danger'
        };
        return badges[status] || 'bg-secondary';
    }

    function capitalizeFirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    // Edit Purchase Request - Attach event listeners function
    let isSubmittingEdit = false;
    function attachPurchaseRequestEventListeners() {
        // View Purchase Request
        document.querySelectorAll('.view-purchase-request').forEach(button => {
            button.replaceWith(button.cloneNode(true)); // Remove old listeners
        });
        
        document.querySelectorAll('.view-purchase-request').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('view-pr-ingredient').textContent = this.getAttribute('data-ingredient');
                document.getElementById('view-pr-supplier').textContent = this.getAttribute('data-supplier') || 'N/A';
                document.getElementById('view-pr-quantity').textContent = this.getAttribute('data-quantity') + ' ' + this.getAttribute('data-unit');
                document.getElementById('view-pr-status').textContent = this.getAttribute('data-status');
                document.getElementById('view-pr-requested-by').textContent = this.getAttribute('data-requested-by');
                document.getElementById('view-pr-date-needed').textContent = this.getAttribute('data-date-needed') || 'N/A';
                document.getElementById('view-pr-created').textContent = this.getAttribute('data-created');
                document.getElementById('view-pr-notes').textContent = this.getAttribute('data-notes') || 'No notes';
                
                const viewModal = new bootstrap.Modal(document.getElementById('viewPurchaseRequestModal'));
                viewModal.show();
            });
        });

        // Edit Purchase Request
        document.querySelectorAll('.edit-purchase-request').forEach(button => {
            button.replaceWith(button.cloneNode(true)); // Remove old listeners
        });
        
        document.querySelectorAll('.edit-purchase-request').forEach(button => {
            button.addEventListener('click', function() {
                const requestId = this.getAttribute('data-request-id');
                const currentRow = this.closest('tr');
                document.getElementById('edit-pr-status').value = this.getAttribute('data-status');
                document.getElementById('edit-pr-notes').value = this.getAttribute('data-notes');
                
                // Reset throttle flag when opening modal
                isSubmittingEdit = false;
                
                document.getElementById('editPurchaseRequestForm').onsubmit = function(e) {
                    e.preventDefault();
                    
                    // Prevent duplicate submissions
                    if (isSubmittingEdit) {
                        return;
                    }
                    isSubmittingEdit = true;
                    
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalText = submitButton.innerHTML;
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Updating...';
                    
                    const formData = {
                        status: document.getElementById('edit-pr-status').value,
                        notes: document.getElementById('edit-pr-notes').value
                    };
                    
                    fetch(`/purchase-requests/${requestId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Close modal
                            bootstrap.Modal.getInstance(document.getElementById('editPurchaseRequestModal')).hide();
                            
                            // Update the row in the table
                            const statusCell = currentRow.querySelector('td:nth-child(5)'); // Adjusted for supplier column
                            const statusBadgeClass = getStatusBadgeClass(formData.status);
                            statusCell.innerHTML = `<span class="badge ${statusBadgeClass}">${capitalizeFirst(formData.status)}</span>`;
                            
                            // Update button data attributes
                            const viewBtn = currentRow.querySelector('.view-purchase-request');
                            const editBtn = currentRow.querySelector('.edit-purchase-request');
                            if (viewBtn) {
                                viewBtn.setAttribute('data-status', formData.status);
                                viewBtn.setAttribute('data-notes', formData.notes || '');
                            }
                            if (editBtn) {
                                editBtn.setAttribute('data-status', formData.status);
                                editBtn.setAttribute('data-notes', formData.notes || '');
                            }
                            
                            // If status is received or cancelled, remove edit button
                            if (formData.status === 'received' || formData.status === 'cancelled') {
                                if (editBtn) {
                                    editBtn.remove();
                                }
                            }
                            
                            // If status changed to received, show message about stock update
                            if (formData.status === 'received' && data.data) {
                                alert(data.message + '\n\nStock has been updated automatically.');
                            } else {
                                alert(data.message);
                            }
                            
                            // Reset form and button
                            submitButton.disabled = false;
                            submitButton.innerHTML = originalText;
                            isSubmittingEdit = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating the purchase request.');
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalText;
                        isSubmittingEdit = false;
                    });
                };
                
                const editModal = new bootstrap.Modal(document.getElementById('editPurchaseRequestModal'));
                editModal.show();
            });
        });

        // Delete Purchase Request
        document.querySelectorAll('.delete-purchase-request').forEach(button => {
            button.replaceWith(button.cloneNode(true)); // Remove old listeners
        });
        
        document.querySelectorAll('.delete-purchase-request').forEach(button => {
            button.addEventListener('click', function() {
                if (!confirm('Are you sure you want to delete this purchase request?')) {
                    return;
                }
                
                const requestId = this.getAttribute('data-request-id');
                const deleteButton = this;
                const currentRow = this.closest('tr');
                
                // Disable button to prevent double clicks
                deleteButton.disabled = true;
                const originalHtml = deleteButton.innerHTML;
                deleteButton.innerHTML = '<i class="bi bi-hourglass-split"></i>';
                
                fetch(`/purchase-requests/${requestId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the row from table
                        currentRow.remove();
                        
                        // Check if table is empty
                        const tbody = document.querySelector('#requests tbody');
                        if (tbody && tbody.children.length === 0) {
                            const requestsTab = document.getElementById('requests');
                            const tableDiv = requestsTab.querySelector('.table-responsive');
                            if (tableDiv) {
                                tableDiv.remove();
                            }
                            // Add no data message
                            const noDataHtml = `
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i> No purchase requests found. Click "New Request" to create one.
                                </div>
                            `;
                            requestsTab.insertAdjacentHTML('beforeend', noDataHtml);
                        }
                        
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the purchase request.');
                    deleteButton.disabled = false;
                    deleteButton.innerHTML = originalHtml;
                });
            });
        });
    }

    // Initialize event listeners on page load
    attachPurchaseRequestEventListeners();

    // Delete Purchase Request
    document.querySelectorAll('.delete-purchase-request').forEach(button => {
        button.addEventListener('click', function() {
            if (!confirm('Are you sure you want to delete this purchase request?')) {
                return;
            }
            
            const requestId = this.getAttribute('data-request-id');
            const deleteButton = this;
            
            // Disable button to prevent double clicks
            deleteButton.disabled = true;
            const originalHtml = deleteButton.innerHTML;
            deleteButton.innerHTML = '<i class="bi bi-hourglass-split"></i>';
            
            fetch(`/purchase-requests/${requestId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    // Reload preserving the purchase requests tab
                    const url = new URL(window.location.href);
                    url.hash = '#requests';
                    window.location.href = url.toString();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the purchase request.');
                deleteButton.disabled = false;
                deleteButton.innerHTML = originalHtml;
            });
        });
    });

    // ========================================
    // SUPPLIER HANDLERS
    // ========================================

    // Create Supplier
    let isSubmittingSupplier = false;
    document.getElementById('createSupplierForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (isSubmittingSupplier) return;
        isSubmittingSupplier = true;
        
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Creating...';
        
        const formData = new FormData(this);
        
        // Add selected ingredients
        const ingredientSelect = document.getElementById('create-supplier-ingredients');
        const selectedIngredients = Array.from(ingredientSelect.selectedOptions).map(opt => opt.value);
        selectedIngredients.forEach(id => {
            formData.append('ingredient_ids[]', id);
        });
        
        fetch('/suppliers/store', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('createSupplierModal')).hide();
                addSupplierCard(data.data);
                document.getElementById('createSupplierForm').reset();
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
                isSubmittingSupplier = false;
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while creating the supplier.');
            submitButton.disabled = false;
            submitButton.innerHTML = originalText;
            isSubmittingSupplier = false;
        });
    });

    function addSupplierCard(supplier) {
        const grid = document.getElementById('suppliers-grid');
        if (!grid) {
            const suppliersTab = document.getElementById('suppliers');
            const noDataAlert = suppliersTab.querySelector('.alert-info');
            if (noDataAlert) noDataAlert.remove();
            
            suppliersTab.insertAdjacentHTML('beforeend', '<div class="row g-4" id="suppliers-grid"></div>');
        }
        
        const statusBadge = supplier.status === 'active' ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
        const cardHtml = `
            <div class="col-md-4" data-supplier-id="${supplier.id}">
                <div class="card inv-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="mb-0">${supplier.name}</h6>
                            ${statusBadge}
                        </div>
                        ${supplier.contact_person ? `<p class="text-muted small mb-1"><i class="bi bi-person"></i> ${supplier.contact_person}</p>` : ''}
                        ${supplier.phone ? `<p class="text-muted small mb-1"><i class="bi bi-telephone"></i> ${supplier.phone}</p>` : ''}
                        ${supplier.email ? `<p class="text-muted small mb-1"><i class="bi bi-envelope"></i> ${supplier.email}</p>` : ''}
                        ${supplier.address ? `<p class="text-muted small mb-2"><i class="bi bi-geo-alt"></i> ${supplier.address}</p>` : ''}
                        <div class="mt-3">
                            <button class="btn btn-sm btn-info view-supplier"
                                    data-supplier-id="${supplier.id}"
                                    data-name="${supplier.name}"
                                    data-contact-person="${supplier.contact_person || ''}"
                                    data-phone="${supplier.phone || ''}"
                                    data-email="${supplier.email || ''}"
                                    data-address="${supplier.address || ''}"
                                    data-status="${supplier.status}">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary edit-supplier"
                                    data-supplier-id="${supplier.id}"
                                    data-name="${supplier.name}"
                                    data-contact-person="${supplier.contact_person || ''}"
                                    data-phone="${supplier.phone || ''}"
                                    data-email="${supplier.email || ''}"
                                    data-address="${supplier.address || ''}"
                                    data-status="${supplier.status}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-supplier"
                                    data-supplier-id="${supplier.id}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.getElementById('suppliers-grid').insertAdjacentHTML('afterbegin', cardHtml);
        attachSupplierEventListeners();
    }

    // View Supplier
    function attachSupplierEventListeners() {
        document.querySelectorAll('.view-supplier').forEach(button => {
            button.replaceWith(button.cloneNode(true));
        });
        
        document.querySelectorAll('.view-supplier').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('view-supplier-name').textContent = this.getAttribute('data-name');
                document.getElementById('view-supplier-contact').textContent = this.getAttribute('data-contact-person') || 'N/A';
                document.getElementById('view-supplier-phone').textContent = this.getAttribute('data-phone') || 'N/A';
                document.getElementById('view-supplier-email').textContent = this.getAttribute('data-email') || 'N/A';
                document.getElementById('view-supplier-address').textContent = this.getAttribute('data-address') || 'N/A';
                document.getElementById('view-supplier-status').textContent = this.getAttribute('data-status');
                
                const viewModal = new bootstrap.Modal(document.getElementById('viewSupplierModal'));
                viewModal.show();
            });
        });

        // Edit Supplier
        document.querySelectorAll('.edit-supplier').forEach(button => {
            button.replaceWith(button.cloneNode(true));
        });
        
        document.querySelectorAll('.edit-supplier').forEach(button => {
            button.addEventListener('click', function() {
                const supplierId = this.getAttribute('data-supplier-id');
                
                document.getElementById('edit-supplier-name').value = this.getAttribute('data-name');
                document.getElementById('edit-supplier-contact').value = this.getAttribute('data-contact-person');
                document.getElementById('edit-supplier-phone').value = this.getAttribute('data-phone');
                document.getElementById('edit-supplier-email').value = this.getAttribute('data-email');
                document.getElementById('edit-supplier-address').value = this.getAttribute('data-address');
                document.getElementById('edit-supplier-status').value = this.getAttribute('data-status');
                
                // Fetch supplier with ingredients to pre-select them
                fetch(`/suppliers/${supplierId}`)
                    .then(response => response.json())
                    .then(supplier => {
                        const ingredientSelect = document.getElementById('edit-supplier-ingredients');
                        // Clear selections
                        Array.from(ingredientSelect.options).forEach(opt => opt.selected = false);
                        // Select the supplier's ingredients
                        if (supplier.ingredients && supplier.ingredients.length > 0) {
                            supplier.ingredients.forEach(ing => {
                                const option = ingredientSelect.querySelector(`option[value="${ing.id}"]`);
                                if (option) option.selected = true;
                            });
                        }
                    })
                    .catch(error => console.error('Error loading supplier ingredients:', error));
                
                document.getElementById('editSupplierForm').onsubmit = function(e) {
                    e.preventDefault();
                    
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalText = submitButton.innerHTML;
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Updating...';
                    
                    const ingredientSelect = document.getElementById('edit-supplier-ingredients');
                    const selectedIngredients = Array.from(ingredientSelect.selectedOptions).map(opt => opt.value);
                    
                    const formData = {
                        name: document.getElementById('edit-supplier-name').value,
                        contact_person: document.getElementById('edit-supplier-contact').value,
                        phone: document.getElementById('edit-supplier-phone').value,
                        email: document.getElementById('edit-supplier-email').value,
                        address: document.getElementById('edit-supplier-address').value,
                        status: document.getElementById('edit-supplier-status').value,
                        ingredient_ids: selectedIngredients
                    };
                    
                    console.log('Updating supplier ID:', supplierId);
                    console.log('Form data:', formData);
                    
                    fetch(`/suppliers/${supplierId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            return response.text().then(text => {
                                console.error('Error response:', text);
                                throw new Error(`Server error: ${response.status}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            bootstrap.Modal.getInstance(document.getElementById('editSupplierModal')).hide();
                            
                            // Find and update the card
                            const card = document.querySelector(`.edit-supplier[data-supplier-id="${supplierId}"]`).closest('.col-md-4');
                            const statusBadge = formData.status === 'active' ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
                            const cardBody = card.querySelector('.card-body');
                            cardBody.innerHTML = `
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0">${formData.name}</h6>
                                    ${statusBadge}
                                </div>
                                ${formData.contact_person ? `<p class="text-muted small mb-1"><i class="bi bi-person"></i> ${formData.contact_person}</p>` : ''}
                                ${formData.phone ? `<p class="text-muted small mb-1"><i class="bi bi-telephone"></i> ${formData.phone}</p>` : ''}
                                ${formData.email ? `<p class="text-muted small mb-1"><i class="bi bi-envelope"></i> ${formData.email}</p>` : ''}
                                ${formData.address ? `<p class="text-muted small mb-2"><i class="bi bi-geo-alt"></i> ${formData.address}</p>` : ''}
                                <div class="mt-3">
                                    <button class="btn btn-sm btn-info view-supplier"
                                            data-supplier-id="${supplierId}"
                                            data-name="${formData.name}"
                                            data-contact-person="${formData.contact_person}"
                                            data-phone="${formData.phone}"
                                            data-email="${formData.email}"
                                            data-address="${formData.address}"
                                            data-status="${formData.status}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-primary edit-supplier"
                                            data-supplier-id="${supplierId}"
                                            data-name="${formData.name}"
                                            data-contact-person="${formData.contact_person}"
                                            data-phone="${formData.phone}"
                                            data-email="${formData.email}"
                                            data-address="${formData.address}"
                                            data-status="${formData.status}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-supplier"
                                            data-supplier-id="${supplierId}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                            
                            attachSupplierEventListeners();
                            submitButton.disabled = false;
                            submitButton.innerHTML = originalText;
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error details:', error);
                        alert('An error occurred while updating the supplier: ' + error.message);
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalText;
                    });
                };
                
                const editModal = new bootstrap.Modal(document.getElementById('editSupplierModal'));
                editModal.show();
            });
        });

        // Delete Supplier
        document.querySelectorAll('.delete-supplier').forEach(button => {
            button.replaceWith(button.cloneNode(true));
        });
        
        document.querySelectorAll('.delete-supplier').forEach(button => {
            button.addEventListener('click', function() {
                if (!confirm('Are you sure you want to delete this supplier?')) return;
                
                const supplierId = this.getAttribute('data-supplier-id');
                const card = this.closest('[data-supplier-id]');
                const deleteButton = this;
                
                deleteButton.disabled = true;
                const originalHtml = deleteButton.innerHTML;
                deleteButton.innerHTML = '<i class="bi bi-hourglass-split"></i>';
                
                fetch(`/suppliers/${supplierId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Add fade out animation
                        card.style.transition = 'opacity 0.3s';
                        card.style.opacity = '0';
                        
                        setTimeout(() => {
                            card.remove();
                            
                            // Check if grid is empty
                            const grid = document.getElementById('suppliers-grid');
                            if (grid && grid.children.length === 0) {
                                grid.remove();
                                const suppliersTab = document.getElementById('suppliers');
                                const header = suppliersTab.querySelector('.d-flex');
                                header.insertAdjacentHTML('afterend', '<div class="alert alert-info"><i class="bi bi-info-circle"></i> No suppliers found. Click "Add Supplier" to create one.</div>');
                            }
                        }, 300);
                        
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the supplier. ' + error.message);
                    deleteButton.disabled = false;
                    deleteButton.innerHTML = originalHtml;
                });
            });
        });
    }

    // Initialize supplier event listeners
    attachSupplierEventListeners();
</script>
</body>
</html>