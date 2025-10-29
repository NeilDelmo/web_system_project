<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>401 - Unauthorized</title>
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
            color: #ff9800;
            margin-bottom: 1rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
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

        .btn-login {
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

        .btn-login:hover {
            background-color: #8b0000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(183, 28, 28, 0.3);
            color: white;
        }

        .info-box {
            background-color: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 2rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .info-box h6 {
            color: #b71c1c;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .info-box p {
            color: #666;
            margin-bottom: 0;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <i class="bi bi-lock error-icon"></i>
        <div class="error-code">401</div>
        <h1 class="error-title">Authentication Required</h1>
        <p class="error-message">
            You need to be logged in to access this page. 
            Please sign in with your credentials to continue.
        </p>

        <div class="info-box">
            <h6><i class="bi bi-info-circle me-2"></i>Why am I seeing this?</h6>
            <p>
                This page requires authentication. You may have been logged out due to inactivity, 
                or your session may have expired. Please log in again to access the Cuevas Bread system.
            </p>
        </div>

        <div class="mt-4">
            <a href="{{ route('login') }}" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Go to Login
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
