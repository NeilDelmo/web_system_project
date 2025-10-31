<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Cuevas Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #fff9e6, #fff3cd, #fce6a4);
            font-family: 'Poppins', sans-serif;
        }
        .settings-card {
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            height: 100%;
        }
        .settings-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .sidebar {
            background-color: #ffffff;
            width: 250px;
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
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
        }
        .sidebar .nav-link:hover {
            background-color: #fff3cd;
            color: #b71c1c;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="sidebar-logo">
        </div>
        <a href="{{ route('dashboard') }}" class="nav-link"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="{{ route('products.index') }}" class="nav-link"><i class="bi bi-basket me-2"></i> Products</a>
        <a href="{{ route('inventory') }}" class="nav-link"><i class="bi bi-box-seam me-2"></i> Inventory</a>
        <a href="{{ route('sales') }}" class="nav-link"><i class="bi bi-cart me-2"></i> Sales & Orders</a>
        <a href="{{ route('production') }}" class="nav-link"><i class="bi bi-gear-fill me-2"></i> Production</a>
        <a href="{{ route('reports') }}" class="nav-link"><i class="bi bi-bar-chart me-2"></i> Reports</a>
        <form method="POST" action="{{ route('logout') }}" style="margin: 0.25rem 0.75rem;">
            @csrf
            <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-gear-fill me-2"></i>Settings</h2>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Settings Cards -->
            <div class="row g-4">
                <!-- User Management -->
                <div class="col-md-4">
                    <a href="{{ route('settings.users') }}" class="text-decoration-none">
                        <div class="card settings-card shadow-sm">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-people-fill display-1 text-primary mb-3"></i>
                                <h5 class="card-title">User Management</h5>
                                <p class="card-text text-muted">
                                    Create, edit, and manage user accounts and roles
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- System Settings -->
                <div class="col-md-4">
                    <a href="{{ route('settings.system') }}" class="text-decoration-none">
                        <div class="card settings-card shadow-sm">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-sliders display-1 text-success mb-3"></i>
                                <h5 class="card-title">System Settings</h5>
                                <p class="card-text text-muted">
                                    Configure application settings and preferences
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Audit Logs -->
                <div class="col-md-4">
                    <a href="{{ route('settings.audit-logs') }}" class="text-decoration-none">
                        <div class="card settings-card shadow-sm">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-clock-history display-1 text-warning mb-3"></i>
                                <h5 class="card-title">Audit Logs</h5>
                                <p class="card-text text-muted">
                                    View system activity and user action history
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <footer class="text-center py-3 mt-5 bg-white border-top small text-muted">
            &copy; {{ date('Y') }} Cuevas Bread. All rights reserved.
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
