<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Production Management</title>
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
            <a href="/sales" class="nav-link">
                <i class="bi bi-cart-check-fill me-2"></i>Sales & Orders
            </a>
            <a href="/production" class="nav-link active">
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
    <main class="main-content">
        <div class="page-header">
            <h2 class="fw-semibold mb-1">Production Management</h2>
            <p class="text-muted mb-0 small">Manufacture products and manage ingredient stock.</p>
        </div>

        <div class="container-fluid p-4">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Production Form Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-gear-fill me-2"></i>Produce Products</h5>
                </div>
                <div class="card-body">
                    <form id="productionForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Select Product</label>
                                <select class="form-select" id="product_id" name="product_id" required>
                                    <option value="">Choose a product...</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-name="{{ $product->name }}">
                                            {{ $product->name }} (Current Stock: {{ $product->stock_quantity }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Quantity to Produce</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Production Notes (Optional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Any special notes about this production batch..."></textarea>
                        </div>

                        <div id="requirementsSection" class="d-none">
                            <h6 class="fw-semibold text-primary mb-3"><i class="bi bi-clipboard-check me-2"></i>Required Ingredients</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-warning">
                                        <tr>
                                            <th>Ingredient</th>
                                            <th>Required</th>
                                            <th>Available</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="requirementsTable"></tbody>
                                </table>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" id="checkRequirementsBtn">
                                <i class="bi bi-search me-1"></i>Check Ingredient Requirements
                            </button>
                            <button type="submit" class="btn btn-success" id="produceBtn" disabled>
                                <i class="bi bi-gear-wide-connected me-1"></i>Start Production
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Production History -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Recent Production History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productionLogs as $log)
                                <tr>
                                    <td>{{ $log->produced_at->format('M d, Y H:i') }}</td>
                                    <td><strong>{{ $log->product->name }}</strong></td>
                                    <td>{{ $log->quantity_produced }} units</td>
                                    <td>
                                        <span class="badge 
                                            @if($log->status == 'completed') bg-success
                                            @elseif($log->status == 'failed') bg-danger
                                            @else bg-secondary
                                            @endif">
                                            {{ ucfirst($log->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $log->notes ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        No production history yet. Start your first production!
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
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
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let canProduce = false;

    document.getElementById('checkRequirementsBtn').addEventListener('click', function() {
        const productId = document.getElementById('product_id').value;
        const quantity = document.getElementById('quantity').value;

        if (!productId || !quantity) {
            alert('Please select a product and enter quantity');
            return;
        }

        fetch(`/production/recipe-requirements/${productId}?quantity=${quantity}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                const tableBody = document.getElementById('requirementsTable');
                tableBody.innerHTML = '';
                canProduce = data.canProduce;

                data.requirements.forEach(req => {
                    const row = `
                        <tr class="${!req.sufficient ? 'table-danger' : ''}">
                            <td><strong>${req.name}</strong></td>
                            <td>${req.required} ${req.unit}</td>
                            <td>${req.available} ${req.unit}</td>
                            <td>
                                ${req.sufficient ? 
                                    '<span class="badge bg-success">Sufficient</span>' : 
                                    '<span class="badge bg-danger">Insufficient</span>'}
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });

                document.getElementById('requirementsSection').classList.remove('d-none');
                document.getElementById('produceBtn').disabled = !canProduce;

                if (!canProduce) {
                    alert('Cannot produce: Insufficient ingredients!');
                }
            })
            .catch(error => console.error('Error:', error));
    });

    document.getElementById('productionForm').addEventListener('submit', function(e) {
        e.preventDefault();

        if (!canProduce) {
            alert('Please check ingredient requirements first!');
            return;
        }

        const formData = new FormData();
        formData.append('product_id', document.getElementById('product_id').value);
        formData.append('quantity', document.getElementById('quantity').value);
        formData.append('notes', document.getElementById('notes').value);
        formData.append('_token', csrfToken);

        fetch('/production/produce', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.redirected) {
                window.location.href = response.url;
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Reset when product or quantity changes
    document.getElementById('product_id').addEventListener('change', function() {
        document.getElementById('requirementsSection').classList.add('d-none');
        document.getElementById('produceBtn').disabled = true;
        canProduce = false;
    });

    document.getElementById('quantity').addEventListener('input', function() {
        document.getElementById('requirementsSection').classList.add('d-none');
        document.getElementById('produceBtn').disabled = true;
        canProduce = false;
    });
</script>
</body>
</html>
