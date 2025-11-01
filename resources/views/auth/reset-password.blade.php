<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password - Cuevas Bakery</title>

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

    .reset-card {
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

    .reset-title {
      font-family: 'Poppins', sans-serif;
      font-size: 28px;
      font-weight: 600;
      color: #000;
      margin-bottom: 1rem;
    }

    .reset-subtitle {
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
  <div class="card reset-card">
    <h2 class="reset-title text-center">Reset Password</h2>
    <p class="reset-subtitle text-center">Enter your new password below.</p>

    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach ($errors->all() as $error)
          <i class="bi bi-exclamation-triangle-fill"></i> {{ $error }}
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST">
      @csrf

      <input type="hidden" name="token" value="{{ $token }}">
      <input type="hidden" name="email" value="{{ $email }}">

      <div class="mb-3">
        <label for="email_display" class="form-label fw-semibold">Email</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
          <input type="email"
                 class="form-control"
                 id="email_display"
                 value="{{ $email }}"
                 disabled>
        </div>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label fw-semibold">New Password</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
          <input type="password"
                 class="form-control"
                 id="password"
                 name="password"
                 placeholder="Enter new password"
                 minlength="8"
                 required>
        </div>
      </div>

      <div class="mb-4">
        <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
          <input type="password"
                 class="form-control"
                 id="password_confirmation"
                 name="password_confirmation"
                 placeholder="Confirm new password"
                 minlength="8"
                 required>
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-shield-check"></i> Reset Password
      </button>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
