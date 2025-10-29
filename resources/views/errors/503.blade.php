<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 - Service Unavailable</title>
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

        .btn-refresh {
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

        .btn-refresh:hover {
            background-color: #8b0000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(183, 28, 28, 0.3);
            color: white;
        }

        .maintenance-box {
            background-color: white;
            border-radius: 12px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .maintenance-box h6 {
            color: #b71c1c;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .maintenance-box p {
            color: #666;
            margin-bottom: 1rem;
        }

        .loader {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #b71c1c;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 1rem auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <i class="bi bi-cone-striped error-icon"></i>
        <div class="error-code">503</div>
        <h1 class="error-title">Service Unavailable</h1>
        <p class="error-message">
            We're currently performing scheduled maintenance. 
            The Cuevas Bread system will be back online shortly.
        </p>

        <div class="maintenance-box">
            <h6><i class="bi bi-wrench-adjustable me-2"></i>Maintenance in Progress</h6>
            <div class="loader"></div>
            <p class="mt-3">
                We're making improvements to serve you better. 
                This should only take a few moments.
            </p>
            <p class="text-muted small mb-0">
                Thank you for your patience!
            </p>
        </div>

        <div class="mt-4">
            <a href="javascript:location.reload()" class="btn-refresh">
                <i class="bi bi-arrow-clockwise me-2"></i>Try Again
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-refresh every 30 seconds
        setTimeout(function() {
            location.reload();
        }, 30000);
    </script>
</body>
</html>
