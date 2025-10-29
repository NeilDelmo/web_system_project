<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #fff9e6, #fff3cd, #fce6a4);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-container {
            text-align: center;
            max-width: 600px;
            padding: 2rem;
        }

        .error-icon {
            font-size: 120px;
            color: #fdd663;
            margin-bottom: 1rem;
            animation: bounce 1s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .error-code {
            font-size: 80px;
            font-weight: 700;
            color: #b71c1c;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .error-title {
            font-size: 28px;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }

        .error-message {
            font-size: 16px;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .btn-home {
            background-color: #b71c1c;
            border: none;
            color: white;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-home:hover {
            background-color: #8b0000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(183, 28, 28, 0.3);
            color: white;
        }

        .btn-back {
            background-color: #fdd663;
            border: none;
            color: #333;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-left: 10px;
        }

        .btn-back:hover {
            background-color: #f8b803;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(248, 184, 3, 0.3);
            color: #333;
        }

        .breadcrumb-hint {
            background-color: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 2rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .breadcrumb-hint h6 {
            color: #b71c1c;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .breadcrumb-hint ul {
            list-style: none;
            padding-left: 0;
            text-align: left;
        }

        .breadcrumb-hint li {
            padding: 0.5rem 0;
        }

        .breadcrumb-hint a {
            color: #0066cc;
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumb-hint a:hover {
            color: #b71c1c;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <i class="bi bi-signpost-split error-icon"></i>
        <div class="error-code">404</div>
        <h1 class="error-title">Page Not Found</h1>
        <p class="error-message">
            Oops! The page you're looking for doesn't exist. 
            It might have been moved, deleted, or the URL might be incorrect.
        </p>

        <div class="breadcrumb-hint">
            <h6><i class="bi bi-compass me-2"></i>Quick Navigation</h6>
            <ul>
                <li><i class="bi bi-house-door me-2 text-success"></i> <a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><i class="bi bi-basket-fill me-2 text-success"></i> <a href="{{ route('products') }}">Products</a></li>
                @can('manage_inventory')
                    <li><i class="bi bi-box-seam me-2 text-success"></i> <a href="{{ route('inventory') }}">Inventory</a></li>
                @endcan
                @can('manage_orders')
                    <li><i class="bi bi-cart-check-fill me-2 text-success"></i> <a href="{{ route('sales') }}">Sales & Orders</a></li>
                @endcan
                @can('view_reports')
                    <li><i class="bi bi-bar-chart-line-fill me-2 text-success"></i> <a href="{{ route('reports') }}">Reports</a></li>
                @endcan
            </ul>
        </div>

        <div class="mt-4">
            <a href="{{ route('dashboard') }}" class="btn-home">
                <i class="bi bi-house-door me-2"></i>Go to Dashboard
            </a>
            <a href="javascript:history.back()" class="btn-back">
                <i class="bi bi-arrow-left me-2"></i>Go Back
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
