<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cuevas Bread</title>

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

    .login-card {
      border: none;
      border-radius: 30px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 900px;
      max-width: 95%;
      margin: auto;
    }

    .form-section {
      background-color: #fce560ff;
      padding: 3rem;
    }

    .side-panel {
      background-color: #ffd943ff;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .side-panel img {
      width: 80%;
      max-width: 280px;
      border-radius: 20px;
    }

    .login-title {
      font-family: 'Poppins', sans-serif;
      font-size: 30px;
      font-weight: 600;
      color: #000;
      margin-bottom: 1.5rem;
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

    .text-muted i {
      color: #0fb55d;
    }

    @media (max-width: 768px) {
      .side-panel {
        display: none;
      }
      .form-section {
        border-radius: 30px;
      }
    }
  </style>
</head>

<body>
  <div class="card login-card">
    <div class="row g-0">
      <!-- Form Section -->
      <div class="col-md-6 form-section">
        <h2 class="login-title text-center">Welcome Back!</h2>

        @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
              <i class="bi bi-exclamation-triangle-fill"></i> {{ $error }}
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        @if (session('info'))
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        <form action="{{ route('login') }}" method="POST" autocomplete="off">
          @csrf

          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
              <input type="email"
                     class="form-control"
                     id="email"
                     name="email"
                     placeholder="Enter your email"
                     value="{{ old('email') }}"
                     autocomplete="off"
                     autocapitalize="none"
                     spellcheck="false"
                     required>
            </div>
          </div>

          <div class="mb-4">
            <label for="password" class="form-label fw-semibold">Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
              <input type="password"
                     class="form-control"
                     id="password"
                     name="password"
                     placeholder="Enter your password"
                     autocomplete="new-password"
                     required>
            </div>
          </div>

          <button type="submit" class="btn btn-primary w-100 rounded-pill">
            <i class="bi bi-box-arrow-in-right"></i> Login
          </button>
        </form>

        <div class="text-center mt-3">
          <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #0fb55d; font-weight: 500;">
            <i class="bi bi-key-fill"></i> Forgot password?
          </a>
        </div>

        <div class="text-center mt-2">
          <small class="text-muted">
            <i class="bi bi-shield-check"></i> Secure login
          </small>
        </div>
      </div>

      <!-- Logo Panel -->
      <div class="col-md-6 side-panel">
        <img src="{{ asset('images/logo.png') }}" alt="Cuevas Bakery Logo">
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Prevent authenticated users from accessing login page via back button -->
  <script>
    // Check if user is authenticated by making a quick API call
    @auth
      // User is authenticated, redirect to dashboard
      window.location.replace('{{ route("dashboard") }}');
    @endauth

    // Prevent browser from caching this page
    window.onpageshow = function(event) {
      if (event.persisted) {
        // Page was loaded from cache (back button)
        window.location.reload();
      }
    };
  </script>
</body>
</html>
