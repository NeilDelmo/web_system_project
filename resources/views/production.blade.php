<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Production Management - Bakery Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
            position: fixed;
            top: 0;
            left: 0;
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
            text-decoration: none;
            display: block;
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
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            background-color: #fff;
        }
        .card-header {
            background-color: #ffee8c;
            color: #000;
            border-radius: 10px 10px 0 0;
            padding: 15px;
            font-weight: 600;
        }
        .table-hover tbody tr:hover {
            background-color: #fff9e6;
        }
        .badge-in-stock {
            background-color: #28a745;
        }
        .badge-low-stock {
            background-color: #ffc107;
        }
        .badge-out-of-stock {
            background-color: #dc3545;
        }
        .ingredient-sufficient {
            color: #28a745;
            font-weight: bold;
        }
        .ingredient-insufficient {
            color: #dc3545;
            font-weight: bold;
        }
        #requirementsTable {
            display: none;
        }
        .btn-primary {
            background-color: #fdd663;
            border-color: #fdd663;
            color: #000;
        }
        .btn-primary:hover {
            background-color: #fcc935;
            border-color: #fcc935;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="sidebar-logo">
        </div>
        <a href="{{ route('dashboard') }}" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="{{ route('products.index') }}" class="nav-link"><i class="bi bi-basket"></i> Product Management</a>
        <a href="{{ route('sales') }}" class="nav-link"><i class="bi bi-cart"></i> Sales & Orders</a>
        <a href="{{ route('inventory') }}" class="nav-link"><i class="bi bi-box-seam"></i> Inventory</a>
        <a href="{{ route('production') }}" class="nav-link active"><i class="bi bi-gear-fill"></i> Production</a>
        <a href="{{ route('reports') }}" class="nav-link"><i class="bi bi-bar-chart"></i> Reports</a>
        <form method="POST" action="{{ route('logout') }}" style="margin: 0.25rem 0.75rem;">
            @csrf
            <button type="submit" class="nav-link" style="width: 100%; background: none; border: none; text-align: left; cursor: pointer;">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <h1 class="mb-4">Production Management</h1>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Production Form Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Start Production</h5>
                </div>
                <div class="card-body">
                    <form id="productionForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="product_id" class="form-label">Select Product <span class="text-danger">*</span></label>
                                <select class="form-select" id="product_id" name="product_id" required>
                                    <option value="">-- Select a Product --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label">Quantity to Produce <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-info" id="checkRequirementsBtn">
                                <i class="bi bi-search"></i> Check Ingredient Requirements
                            </button>
                        </div>

                        <!-- Requirements Table (Hidden by default) -->
                        <div id="requirementsTable" class="mb-3">
                            <h6>Ingredient Requirements:</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Ingredient</th>
                                            <th>Required</th>
                                            <th>Available</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="requirementsTableBody">
                                        <!-- Populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Production Notes (Optional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success" id="startProductionBtn" disabled>
                            <i class="bi bi-play-fill"></i> Start Production
                        </button>
                    </form>
                </div>
            </div>

            <!-- Recent Production History -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Recent Production History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date & Time</th>
                                    <th>Product</th>
                                    <th>Quantity Produced</th>
                                    <th>Status</th>
                                    <th>Produced By</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productionLogs as $log)
                                    <tr>
                                        <td>{{ $log->produced_at->format('Y-m-d H:i') }}</td>
                                        <td>{{ $log->product->name }}</td>
                                        <td>{{ $log->quantity_produced }}</td>
                                        <td>
                                            @if($log->status === 'completed')
                                                <span class="badge bg-success">Completed</span>
                                            @elseif($log->status === 'failed')
                                                <span class="badge bg-danger">Failed</span>
                                            @else
                                                <span class="badge bg-secondary">Cancelled</span>
                                            @endif
                                        </td>
                                        <td>{{ $log->producer ? $log->producer->name : 'N/A' }}</td>
                                        <td>{{ $log->notes ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No production history yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // CSRF Token setup for AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        let canProduce = false;

        // Check Requirements Button
        document.getElementById('checkRequirementsBtn').addEventListener('click', async function() {
            const productId = document.getElementById('product_id').value;
            const quantity = document.getElementById('quantity').value;

            if (!productId || !quantity) {
                alert('Please select a product and enter a quantity.');
                return;
            }

            try {
                const response = await fetch(`/production/recipe-requirements/${productId}?quantity=${quantity}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    alert(data.error || 'Error fetching requirements');
                    return;
                }

                // Display requirements table
                const tableBody = document.getElementById('requirementsTableBody');
                tableBody.innerHTML = '';

                canProduce = data.canProduce;

                data.requirements.forEach(req => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${req.name}</td>
                        <td>${req.required} ${req.unit}</td>
                        <td>${req.available} ${req.unit}</td>
                        <td class="${req.sufficient ? 'ingredient-sufficient' : 'ingredient-insufficient'}">
                            ${req.sufficient ? '✓ Sufficient' : '✗ Insufficient'}
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                // Show table
                document.getElementById('requirementsTable').style.display = 'block';

                // Enable/disable production button
                const startBtn = document.getElementById('startProductionBtn');
                if (canProduce) {
                    startBtn.disabled = false;
                    startBtn.classList.remove('btn-secondary');
                    startBtn.classList.add('btn-success');
                } else {
                    startBtn.disabled = true;
                    startBtn.classList.remove('btn-success');
                    startBtn.classList.add('btn-secondary');
                    alert('Insufficient ingredients to complete production. Please restock ingredients.');
                }

            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while checking requirements.');
            }
        });

        // Production Form Submit
        document.getElementById('productionForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            if (!canProduce) {
                alert('Please check ingredient requirements first.');
                return;
            }

            const formData = new FormData(this);

            try {
                const response = await fetch('/production/produce', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    alert(data.message || 'Production completed successfully!');
                    window.location.reload();
                } else {
                    alert(data.error || 'Production failed. Please try again.');
                }

            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred during production.');
            }
        });

        // Reset requirements when product or quantity changes
        document.getElementById('product_id').addEventListener('change', function() {
            document.getElementById('requirementsTable').style.display = 'none';
            document.getElementById('startProductionBtn').disabled = true;
            canProduce = false;
        });

        document.getElementById('quantity').addEventListener('input', function() {
            document.getElementById('requirementsTable').style.display = 'none';
            document.getElementById('startProductionBtn').disabled = true;
            canProduce = false;
        });
    </script>
</body>
</html>
