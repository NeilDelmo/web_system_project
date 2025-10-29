<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Denied</title>
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
            color: #dc3545;
            margin-bottom: 1rem;
            animation: shake 0.5s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
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

        .permission-info {
            background-color: #fff3cd;
            border: 1px solid #fdd663;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 2rem;
            text-align: left;
        }

        .permission-info h6 {
            color: #b71c1c;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .permission-info ul {
            list-style: none;
            padding-left: 0;
        }

        .permission-info li {
            padding: 0.5rem 0;
            color: #666;
        }

        .permission-info li i {
            color: #28a745;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <i class="bi bi-shield-x error-icon"></i>
        <div class="error-code">403</div>
        <h1 class="error-title">Access Denied</h1>
        <p class="error-message">
            Sorry, you don't have permission to access this page. 
            This area is restricted to authorized users with specific roles or permissions.
        </p>

        @if(auth()->check())
            <div class="permission-info">
                <h6><i class="bi bi-info-circle me-2"></i>Your Current Access Level</h6>
                <ul>
                    <li><i class="bi bi-person-badge"></i> <strong>User:</strong> {{ auth()->user()->fullname ?? auth()->user()->email }}</li>
                    @if(auth()->user()->roles->isNotEmpty())
                        <li><i class="bi bi-shield-check"></i> <strong>Role:</strong> {{ auth()->user()->roles->pluck('name')->join(', ') }}</li>
                    @else
                        <li><i class="bi bi-shield-exclamation text-warning"></i> <strong>Role:</strong> No role assigned</li>
                    @endif
                </ul>
                <p class="mb-0 mt-3 text-muted small">
                    <i class="bi bi-lightbulb"></i> If you believe you should have access to this page, please contact your system administrator.
                </p>
            </div>
        @endif

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
