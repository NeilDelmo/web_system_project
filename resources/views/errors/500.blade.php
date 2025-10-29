<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error</title>
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
            animation: spin 3s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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

        .btn-refresh {
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

        .btn-refresh:hover {
            background-color: #f8b803;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(248, 184, 3, 0.3);
            color: #333;
        }

        .info-box {
            background-color: #fff3cd;
            border: 1px solid #fdd663;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 2rem;
            text-align: left;
        }

        .info-box h6 {
            color: #b71c1c;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .info-box ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }

        .info-box li {
            padding: 0.5rem 0;
            color: #666;
        }

        .info-box li i {
            color: #0066cc;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <i class="bi bi-gear error-icon"></i>
        <div class="error-code">500</div>
        <h1 class="error-title">Internal Server Error</h1>
        <p class="error-message">
            Oops! Something went wrong on our end. 
            We're working to fix the problem. Please try again later.
        </p>

        <div class="info-box">
            <h6><i class="bi bi-tools me-2"></i>What you can do:</h6>
            <ul>
                <li><i class="bi bi-arrow-clockwise"></i> Try refreshing the page</li>
                <li><i class="bi bi-clock-history"></i> Wait a few moments and try again</li>
                <li><i class="bi bi-house-door"></i> Return to the dashboard</li>
                <li><i class="bi bi-telephone"></i> Contact support if the problem persists</li>
            </ul>
        </div>

        <div class="mt-4">
            <a href="{{ route('dashboard') }}" class="btn-home">
                <i class="bi bi-house-door me-2"></i>Go to Dashboard
            </a>
            <a href="javascript:location.reload()" class="btn-refresh">
                <i class="bi bi-arrow-clockwise me-2"></i>Refresh Page
            </a>
        </div>

        @if(config('app.debug') && isset($exception))
            <div class="alert alert-danger mt-4 text-start">
                <strong>Debug Info:</strong><br>
                <small>{{ $exception->getMessage() }}</small>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
