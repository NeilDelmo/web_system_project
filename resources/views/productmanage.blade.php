<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management | Cuevas Bread</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

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

        .row.g-4 > [class*='col-'] {
            display: flex;
        }

        .product-card, .category-card, .recipe-card {
            width: 100%;
            height: 320px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        .product-card:hover, .category-card:hover, .recipe-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
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
                <h2>Products Management</h2>
                <p class="text-muted mb-0 small">Manage your bakery’s products, categories, recipes, and pricing.</p>
            </div>
            <button class="btn btn-danger">
                <i class="bi bi-plus-circle me-1"></i> Add Product
            </button>
        </div>

        <ul class="nav nav-tabs tab-nav bg-white px-4 border-bottom" id="productTabs" role="tablist">
            <li class="nav-item"><a class="nav-link active" id="list-tab" data-bs-toggle="tab" href="#list" role="tab">Product List</a></li>
            <li class="nav-item"><a class="nav-link" id="cat-tab" data-bs-toggle="tab" href="#categories" role="tab">Categories</a></li>
            <li class="nav-item"><a class="nav-link" id="rec-tab" data-bs-toggle="tab" href="#recipes" role="tab">Recipes & Ingredients</a></li>
            <li class="nav-item"><a class="nav-link" id="price-tab" data-bs-toggle="tab" href="#pricing" role="tab">Pricing</a></li>
        </ul>

        <div class="tab-content p-4" id="productTabsContent">
            <!-- Product List -->
            <div class="tab-pane fade show active" id="list" role="tabpanel">
                <h5 class="fw-semibold mb-3">All Products</h5>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card product-card text-center">
                            <div class="card-body">
                                <img src="{{ asset('images/pandesal.jpg') }}" class="card-img-top" alt="Pan de Sal">
                                <h6>Pan de Sal</h6>
                                <p class="text-muted small mb-1">Breads</p>
                                <h6 class="text-success fw-bold">₱50</h6>
                                <span class="badge bg-success-subtle text-success mb-3">150 in stock</span>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-warning text-white">View</button>
                                    <button class="btn btn-sm btn-outline-secondary">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card product-card text-center">
                            <div class="card-body">
                                <img src="{{ asset('images/cheeseroll.jpg') }}" class="card-img-top" alt="Cheese Roll">
                                <h6>Cheese Roll</h6>
                                <p class="text-muted small mb-1">Breads</p>
                                <h6 class="text-success fw-bold">₱35</h6>
                                <span class="badge bg-success-subtle text-success mb-3">80 in stock</span>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-warning text-white">View</button>
                                    <button class="btn btn-sm btn-outline-secondary">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card product-card text-center">
                            <div class="card-body">
                                <img src="{{ asset('images/chocodrink.jpg') }}" class="card-img-top" alt="Chocolate Drink">
                                <h6>Chocolate Drink</h6>
                                <p class="text-muted small mb-1">Refreshing chocolate beverage</p>
                                <h6 class="text-success fw-bold">₱45</h6>
                                <span class="badge bg-success-subtle text-success mb-3">120 in stock</span>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-warning text-white">View</button>
                                    <button class="btn btn-sm btn-outline-secondary">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="tab-pane fade" id="categories" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Categories Management</h5>
                    <button class="btn btn-danger"><i class="bi bi-plus-circle me-1"></i> Add Category</button>
                </div>

                <p class="text-muted mb-4">Manage and organize your bakery’s product categories.</p>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card category-card text-center">
                            <div class="card-body">
                                <img src="{{ asset('images/breads.jpg') }}" class="card-img-top" alt="Breads">
                                <h6 class="fw-semibold">Breads</h6>
                                <p class="text-muted small mb-3">12 products</p>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-outline-secondary">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card category-card text-center">
                            <div class="card-body">
                                <img src="{{ asset('images/pastries.jpg') }}" class="card-img-top" alt="Pastries">
                                <h6 class="fw-semibold">Pastries</h6>
                                <p class="text-muted small mb-3">8 products</p>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-outline-secondary">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recipes -->
            <div class="tab-pane fade" id="recipes" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Recipes & Ingredients</h5>
                    <button class="btn btn-danger"><i class="bi bi-plus-circle me-1"></i> Add Recipe</button>
                </div>
                <p class="text-muted mb-4">Manage the recipes and ingredients used for your bakery products.</p>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card recipe-card text-center">
                            <div class="card-body">
                                <img src="{{ asset('images/pandesal-recipe.jpg') }}" class="card-img-top" alt="Pandesal Recipe">
                                <h6 class="fw-semibold mb-1">Pandesal Recipe</h6>
                                <p class="text-muted small mb-2">Category: Breads</p>
                                <p class="text-muted small mb-3">Flour, yeast, sugar, salt, butter...</p>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-warning text-white">View</button>
                                    <button class="btn btn-sm btn-outline-secondary">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="tab-pane fade" id="pricing" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Pricing Management</h5>
                    <button class="btn btn-danger"><i class="bi bi-plus-circle me-1"></i> Add Pricing Rule</button>
                </div>
                <p class="text-muted mb-4">Adjust product prices, manage discounts, and set special offers here.</p>
            </div>
        </div>

        <footer class="text-center py-3 border-top bg-white small text-muted mt-5">
            &copy; {{ date('Y') }} Cuevas Bread. All rights reserved.
        </footer>
    </main>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>