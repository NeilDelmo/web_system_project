<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background: linear-gradient(135deg, #fff9e6, #fff3cd, #fce6a4);
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif;
        }

        /* Sidebar section */
        .sidebar {
            background-color: #ffffff;
            width: 250px;
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
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

        .row.g-4>[class*='col-'] {
            display: flex;
        }

        .product-card,
        .category-card,
        .recipe-card {
            width: 100%;
            height: 320px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        .product-card:hover,
        .category-card:hover,
        .recipe-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .product-card .card-body,
        .category-card .card-body,
        .recipe-card .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
            padding: 1.5rem;
        }

        .card-img-top {
            width: 100%;
            height: 120px;
            object-fit: contain;
            margin-bottom: 10px;
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
                <a href="/products" class="nav-link active">
                    <i class="bi bi-basket-fill me-2"></i>Products
                </a>
                <a href="/inventory" class="nav-link">
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
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person-circle me-1"></i> Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
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
                    <h2>Products Management</h2>
                    <p class="text-muted mb-0 small">Manage your bakery’s products, categories, recipes, and pricing.</p>
                </div>
            </div>

            <ul class="nav nav-tabs tab-nav bg-white px-4 border-bottom" id="productTabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="list-tab" data-bs-toggle="tab" href="#list" role="tab">Product List</a></li>
                <li class="nav-item"><a class="nav-link" id="cat-tab" data-bs-toggle="tab" href="#categories" role="tab">Categories</a></li>
                <li class="nav-item"><a class="nav-link" id="ing-tab" data-bs-toggle="tab" href="#ingredients" role="tab">Ingredients</a></li>
                <li class="nav-item"><a class="nav-link" id="rec-tab" data-bs-toggle="tab" href="#recipes" role="tab">Recipes</a></li>
                <li class="nav-item"><a class="nav-link" id="price-tab" data-bs-toggle="tab" href="#pricing" role="tab">Pricing</a></li>
            </ul>

            <div class="tab-content p-4" id="productTabsContent">
                <!-- Product List -->
                <div class="tab-pane fade show active" id="list">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-semibold mb-0">All Products</h5>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addProductModal">
                            <i class="bi bi-plus-circle me-1"></i> Add Product
                        </button>
                    </div>

                    <div class="row g-4">
                        @forelse($products as $product)
                        <div class="col-md-4">
                            <div class="card product-card text-center">
                                <div class="card-body">
                                    <img src="{{  $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
                                    <h6>{{ $product->name }}</h6>
                                    <p class="text-muted small mb-1">{{ $product->category->name ?? 'No Category' }}</p>
                                    <h6 class="text-success fw-bold">₱{{ number_format($product->price, 2) }}</h6>
                                    <span class="badge  
                                    @if($product->stock_quantity > 50) bg-success-subtle text-success
                    @elseif($product->stock_quantity > 0) bg-warning-subtle text-warning
                    @else bg-danger-subtle text-danger
                    @endif mb-3">{{ $product->stock_quantity }} in stock</span>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-warning text-white view-product"
                                            data-product-id="{{ $product->id }}">
                                            View
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary edit-product"
                                            data-product-id="{{ $product->id }}">
                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger delete-product"
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <p class="text-center text-muted">No products found. Add your first product!</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Categories -->
                <div class="tab-pane fade" id="categories" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-semibold mb-0">Categories Management</h5>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                            <i class="bi bi-plus-circle me-1"></i> Add Category
                        </button>
                    </div>

                    <p class="text-muted mb-4">Manage and organize your bakery’s product categories.</p>
                    <div class="row g-4">
                        <div class="row g-4">
                            @forelse($categories as $category)
                            <div class="col-md-4">
                                <div class="card category-card text-center">
                                    <div class="card-body">
                                        <h5>{{ $category->name }}</h5>
                                        <p class="text-muted small">{{ $category->description }}</p>
                                        <p class="text-muted small">{{ $category->products->count() }} products</p>
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="btn btn-sm btn-warning text-white">View</button>
                                            <button class="btn btn-sm btn-outline-secondary">Edit</button>
                                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <p class="text-center text-muted">No categories found. Add your first category!</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Ingredients -->
                <div class="tab-pane fade" id="ingredients" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-semibold mb-0">Ingredients Inventory</h5>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addIngredientModal">
                            <i class="bi bi-plus-circle me-1"></i> Add Ingredient
                        </button>
                    </div>
                    <p class="text-muted mb-4">Manage your bakery's ingredient stock and inventory levels.</p>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
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
                                        <button class="btn btn-sm btn-outline-secondary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" title="Delete">
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

                <!-- Recipes -->
                <div class="tab-pane fade" id="recipes" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-semibold mb-0">Product Recipes</h5>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addRecipeModal">
                            <i class="bi bi-plus-circle me-1"></i> Add Recipe
                        </button>
                    </div>
                    <p class="text-muted mb-4">Manage the recipes for your bakery products.</p>

                    <div class="row g-4">
                        @forelse($recipes as $recipe)
                        <div class="col-md-4">
                            <div class="card recipe-card text-center">
                                <div class="card-body">
                                    <img src="{{ asset('images/recipe-placeholder.jpg')}}" class="card-img-top" alt="{{ $recipe->name }}">
                                    <h6 class="fw-semibold mb-1">{{ $recipe->name }}</h6>
                                    <p class="text-muted small mb-2">{{ $recipe->product->name ?? 'N/A' }}</p>
                                    <p class="text-muted small mb-3">{{ $recipe->ingredients->count() }} items</p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-warning text-white">View</button>
                                        <button class="btn btn-sm btn-outline-secondary">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <p class="text-center text-muted">No recipes found. Add your first recipe!</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pricing -->
                <div class="tab-pane fade" id="pricing" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-semibold mb-0">Pricing Management</h5>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addPricingRuleModal">
                            <i class="bi bi-plus-circle me-1"></i> Add Pricing Rule
                        </button>
                    </div>
                    <p class="text-muted mb-4">Adjust product prices, manage discounts, and set special offers here.</p>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-warning">
                                <tr>
                                    <th>Product</th>
                                    <th>Min Quantity</th>
                                    <th>Discount Type</th>
                                    <th>Discount Value</th>
                                    <th>Notes</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pricingRules as $rule)
                                <tr>
                                    <td>
                                        <strong>{{ $rule->product->name }}</strong><br>
                                        <small class="text-muted">₱{{ number_format($rule->product->price, 2) }}</small>
                                    </td>
                                    <td>{{ $rule->min_quantity }} pcs</td>
                                    <td>
                                        @if($rule->discount_type == 'percentage')
                                        <span class="badge bg-info">Percentage</span>
                                        @else
                                        <span class="badge bg-primary">Fixed Amount</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($rule->discount_type == 'percentage')
                                        <strong class="text-success">{{ $rule->discount_value }}%</strong>
                                        @else
                                        <strong class="text-success">₱{{ number_format($rule->discount_value, 2) }}</strong>
                                        @endif
                                    </td>
                                    <td>{{ $rule->notes ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $rule->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($rule->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="bi bi-tag fs-1 d-block mb-2"></i>
                                        No pricing rules found. Add your first rule!
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <footer class="text-center py-3 border-top bg-white small text-muted mt-5">
                &copy; {{ date('Y') }} Cuevas Bread. All rights reserved.
            </footer>
        </main>


        <!-- ✅ Add Product Modal -->
        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 shadow">
                    <div class="modal-header bg-warning-subtle">
                        <h5 class="modal-title fw-semibold" id="addProductModalLabel">
                            <i class="bi bi-plus-circle text-danger me-2"></i> Add New Product
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="status" value="active">
                            @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Product Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter product name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Category</label>
                                <select class="form-select" name="category_id" required>
                                    <option value="" selected disabled>Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Price (₱)</label>
                                <input type="number" class="form-control" name="price" step="0.01" min="0" placeholder="Enter price" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Stock Quantity</label>
                                <input type="number" class="form-control" name="stock_quantity" min="0" placeholder="Enter stock" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Enter description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Product Image</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                                <small class="text-muted">Max size: 2MB. Formats: JPG, PNG, GIF</small>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Save Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Product Modal -->
<div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title fw-semibold" id="viewProductModalLabel">
                    <i class="bi bi-eye text-danger me-2"></i> Product Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <img id="view_image" src="" alt="Product Image" class="img-fluid rounded" style="max-height: 200px;">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Product Name</label>
                    <p id="view_name" class="form-control-plaintext border p-2 rounded bg-light"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Category</label>
                    <p id="view_category" class="form-control-plaintext border p-2 rounded bg-light"></p>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Price</label>
                        <p id="view_price" class="form-control-plaintext border p-2 rounded bg-light"></p>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Stock</label>
                        <p id="view_stock" class="form-control-plaintext border p-2 rounded bg-light"></p>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <p id="view_description" class="form-control-plaintext border p-2 rounded bg-light"></p>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title fw-semibold" id="editProductModalLabel">
                    <i class="bi bi-pencil-square text-danger me-2"></i> Edit Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editProductForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="active">
                    
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Product Name</label>
                        <input type="text" class="form-control" name="name" id="edit_name" placeholder="Enter product name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category</label>
                        <select class="form-select" name="category_id" id="edit_category_id" required>
                            <option value="" disabled>Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Price (₱)</label>
                        <input type="number" class="form-control" name="price" id="edit_price" step="0.01" min="0" placeholder="Enter price" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Stock Quantity</label>
                        <input type="number" class="form-control" name="stock_quantity" id="edit_stock_quantity" min="0" placeholder="Enter stock" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea class="form-control" name="description" id="edit_description" rows="3" placeholder="Enter description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Product Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <small class="text-muted">Max size: 2MB. Formats: JPG, PNG, GIF</small>
                        <div class="mt-2" id="currentImageContainer"></div>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        <!-- ✅ Add Category Modal -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 shadow">
                    <div class="modal-header bg-warning-subtle">
                        <h5 class="modal-title fw-semibold" id="addCategoryModalLabel">
                            <i class="bi bi-plus-circle text-danger me-2"></i> Add New Category
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="active">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Category Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter category name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Enter category description"></textarea>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Save Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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

        <!-- Add Recipe Modal -->
        <div class="modal fade" id="addRecipeModal" tabindex="-1" aria-labelledby="addRecipeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-warning-subtle">
                        <h5 class="modal-title fw-semibold" id="addRecipeModalLabel">
                            <i class="bi bi-journal-text text-danger me-2"></i> Add New Recipe
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="addRecipeForm" action="{{ route('recipes.store') }}" method="POST">
                        @csrf
                        <div class="modal-body px-4 py-3">
                            @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <!-- Recipe Info -->
                            <input type="hidden" name="status" value="active">
                            <h6 class="fw-semibold mb-3 text-danger">Recipe Information</h6>
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-semibold">Recipe Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter recipe name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-semibold">Product</label>
                                    <select class="form-select" name="product_id" required>
                                        <option value="">Select product</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Ingredients Table -->
                            <h6 class="fw-semibold mb-3 text-danger">Ingredients</h6>
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-warning text-center">
                                        <tr>
                                            <th>Ingredient</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="recipeIngredientsTable">
                                        <tr>
                                            <td>
                                                <select class="form-select ingredient-select" name="ingredient[]" required>
                                                    <option value="">Select ingredient</option>
                                                    @foreach($ingredients as $ingredient)
                                                    <option value="{{ $ingredient->id }}" data-unit="{{ $ingredient->unit }}">{{ $ingredient->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" class="form-control text-center" name="quantity[]" min="0" step="0.01" placeholder="0" required></td>
                                            <td>
                                                <input type="text" class="form-control text-center unit-display" name="unit[]" readonly placeholder="Unit" required>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger removeIngredientRow">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-sm btn-outline-warning" id="addIngredientBtn">
                                    <i class="bi bi-plus-circle me-1"></i> Add Ingredient
                                </button>
                            </div>

                            <!-- Recipe Instructions -->
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Instructions (Required)</label>
                                <textarea class="form-control" name="instructions" rows="3" placeholder="e.g. Mix all dry ingredients, add wet ingredients, bake at 180°C for 20 minutes." required></textarea>
                            </div>

                            <!-- Recipe Notes -->
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Additional Notes (Optional)</label>
                                <textarea class="form-control" name="notes" rows="2" placeholder="Any additional notes or tips..."></textarea>
                            </div>
                        </div>

                        <div class="modal-footer bg-light border-top-0">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger px-4">
                                <i class="bi bi-check-circle me-1"></i> Save Recipe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Add Pricing Rule Modal -->
        <div class="modal fade" id="addPricingRuleModal" tabindex="-1" aria-labelledby="addPricingRuleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-warning-subtle">
                        <h5 class="modal-title fw-semibold" id="addPricingRuleModalLabel">
                            <i class="bi bi-tag text-danger me-2"></i> Add Pricing Rule
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="addPricingRuleForm" action="{{ route('pricing.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="active">
                        <div class="modal-body px-4 py-3">
                            @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <!-- Rule Information -->
                            <h6 class="fw-semibold mb-3 text-danger">Pricing Rule Information</h6>
                            <div class="row mb-3">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label small fw-semibold">Product</label>
                                    <select class="form-select" name="product_id" required>
                                        <option selected disabled>Select product</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} - ₱{{ number_format($product->price, 2) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Rule Details -->
                            <h6 class="fw-semibold mb-3 text-danger">Rule Details</h6>
                            <div class="row mb-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label small fw-semibold">Minimum Quantity</label>
                                    <input type="number" class="form-control" name="min_quantity" min="1" placeholder="1" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label small fw-semibold">Discount Type</label>
                                    <select class="form-select" name="discount_type" required>
                                        <option selected disabled>Select type</option>
                                        <option value="percentage">Percentage (%)</option>
                                        <option value="fixed">Fixed Amount (₱)</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label small fw-semibold">Discount Value</label>
                                    <input type="number" class="form-control" name="discount_value" step="0.01" min="0" placeholder="0" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Notes</label>
                                <textarea class="form-control" name="notes" rows="2" placeholder="Optional notes for this pricing rule"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer bg-light border-top-0">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger px-4">
                                <i class="bi bi-check-circle me-1"></i> Save Rule
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto-populate unit when ingredient is selected
        function attachIngredientChangeEvent(select) {
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const unit = selectedOption.getAttribute('data-unit');
                const row = this.closest('tr');
                const unitInput = row.querySelector('.unit-display');

                if (unit) {
                    unitInput.value = unit;
                } else {
                    unitInput.value = '';
                }
            });
        }

        // Add ingredient row functionality
        document.getElementById('addIngredientBtn').addEventListener('click', function() {
            const tableBody = document.getElementById('recipeIngredientsTable');
            const newRow = tableBody.rows[0].cloneNode(true);

            // Reset the values of inputs in the new row
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            newRow.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

            tableBody.appendChild(newRow);

            // Add event listeners to the new row
            attachRemoveEvent(newRow.querySelector('.removeIngredientRow'));
            attachIngredientChangeEvent(newRow.querySelector('.ingredient-select'));
        });

        // Remove ingredient row functionality
        function attachRemoveEvent(button) {
            button.addEventListener('click', function() {
                const tableBody = document.getElementById('recipeIngredientsTable');
                if (tableBody.rows.length > 1) {
                    this.closest('tr').remove();
                } else {
                    alert('You must have at least one ingredient!');
                }
            });
        }

        // Attach events to initial row
        document.querySelectorAll('.removeIngredientRow').forEach(button => {
            attachRemoveEvent(button);
        });

        document.querySelectorAll('.ingredient-select').forEach(select => {
            attachIngredientChangeEvent(select);
        });

        // View Product
document.querySelectorAll('.view-product').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        
        fetch(`/products/${productId}`)
            .then(response => response.json())
            .then(product => {
                // Populate view modal
                document.getElementById('view_name').textContent = product.name;
                document.getElementById('view_category').textContent = product.category ? product.category.name : 'No Category';
                document.getElementById('view_price').textContent = '₱' + parseFloat(product.price).toFixed(2);
                document.getElementById('view_stock').textContent = product.stock_quantity + ' in stock';
                document.getElementById('view_description').textContent = product.description || 'No description available';
                
                // Set image
                const imageElement = document.getElementById('view_image');
                if (product.image) {
                    imageElement.src = '/storage/' + product.image;
                } else {
                    imageElement.src = '/images/placeholder.jpg';
                }
                
                // Show modal
                const viewModal = new bootstrap.Modal(document.getElementById('viewProductModal'));
                viewModal.show();
            })
            .catch(error => console.error('Error:', error));
    });
});

// Edit Product
document.querySelectorAll('.edit-product').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        
        fetch(`/products/${productId}`)
            .then(response => response.json())
            .then(product => {
                // Populate the edit form
                document.getElementById('edit_name').value = product.name;
                document.getElementById('edit_category_id').value = product.category_id;
                document.getElementById('edit_price').value = product.price;
                document.getElementById('edit_stock_quantity').value = product.stock_quantity;
                document.getElementById('edit_description').value = product.description || '';
                
                // Set form action
                document.getElementById('editProductForm').action = `/products/${productId}`;
                
                // Show current image if exists
                const imageContainer = document.getElementById('currentImageContainer');
                if (product.image) {
                    imageContainer.innerHTML = `
                        <small class="text-muted">Current Image:</small><br>
                        <img src="/storage/${product.image}" alt="Current image" class="img-thumbnail mt-1" style="max-height: 100px;">
                    `;
                } else {
                    imageContainer.innerHTML = '<small class="text-muted">No image uploaded</small>';
                }
                
                // Show modal
                const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                editModal.show();
            })
            .catch(error => console.error('Error:', error));
    });
});

// Delete Product
document.querySelectorAll('.delete-product').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        const productName = this.getAttribute('data-product-name');
        
        if (confirm(`Are you sure you want to delete "${productName}"? This action cannot be undone.`)) {
            // Create a form and submit it
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/products/${productId}`;
            
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
    </script>
</body>

</html>