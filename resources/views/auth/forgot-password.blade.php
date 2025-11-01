<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password - Cuevas Bakery</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(110deg, #f9cf12c1, #fafacbff);
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
    }

    .forgot-card {
      border: none;
      border-radius: 30px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 500px;
      max-width: 95%;
      margin: auto;
      background-color: #fce560ff;
      padding: 3rem;
    }

    .forgot-title {
      font-family: 'Poppins', sans-serif;
      font-size: 28px;
      font-weight: 600;
      color: #000;
      margin-bottom: 1rem;
    }

    .forgot-subtitle {
      font-size: 14px;
      color: #666;
      margin-bottom: 2rem;
    }

    .form-control {
      border-radius: 50px;
      padding: 12px 20px;
    }

    .form-control:focus {
      border-color: #0fb55d;
      box-shadow: 0 0 0 0.2rem rgba(15, 181, 93, 0.25);
    }

    .btn-primary {
      background-color: #0fb55d;
      border: none;
      border-radius: 50px;
      padding: 12px;
      font-weight: 500;
      transition: 0.3s;
    }

    .btn-primary:hover {
      background-color: #00572a;
      transform: translateY(-1px);
    }

    .btn-secondary {
      border-radius: 50px;
      padding: 12px;
    }

    .alert {
      border-radius: 50px;
    }

    .input-group-text {
      background-color: #fff;
      border-radius: 50px 0 0 50px;
      border-right: none;
    }

    .form-control {
      border-left: none;
    }
  </style>
</head>

<body>
  <div class="card forgot-card">
    <h2 class="forgot-title text-center">Forgot Password?</h2>
    <p class="forgot-subtitle text-center">No worries! Enter your email and we'll send you a reset link.</p>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach ($errors->all() as $error)
          <i class="bi bi-exclamation-triangle-fill"></i> {{ $error }}
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST">
      @csrf

      <div class="mb-4">
        <label for="email" class="form-label fw-semibold">Email Address</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
          <input type="email"
                 class="form-control"
                 id="email"
                 name="email"
                 placeholder="Enter your email"
                 value="{{ old('email') }}"
                 required>
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100 mb-3">
        <i class="bi bi-send-fill"></i> Send Reset Link
      </button>

      <a href="{{ route('login') }}" class="btn btn-secondary w-100">
        <i class="bi bi-arrow-left"></i> Back to Login
      </a>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
