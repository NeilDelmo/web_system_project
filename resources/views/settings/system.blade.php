<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>System Settings - Cuevas Bakery</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #fff9e6, #fff3cd, #fce6a4);
      font-family: 'Poppins', sans-serif;
    }
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<div class="container-fluid p-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-sliders me-2"></i>System Settings</h2>
    <div>
      <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Settings
      </a>
    </div>
  </div>

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

      <div class="row g-4">
        <!-- Bakery Information -->
        <div class="col-md-12">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="bi bi-shop text-primary"></i> Bakery Information</h5>
              <p class="text-muted small">Update your bakery's basic information</p>
              <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                This section will allow you to configure bakery name, address, contact details, and operating hours.
              </div>
              <button class="btn btn-primary btn-sm" disabled>
                <i class="bi bi-pencil me-1"></i> Edit Information
              </button>
            </div>
          </div>
        </div>

        <!-- Email Settings -->
        <div class="col-md-12">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="bi bi-envelope text-success"></i> Email Settings</h5>
              <p class="text-muted small">Configure email notifications and SMTP settings</p>
              <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                Configure SMTP server details, sender email, and notification preferences for order confirmations, low stock alerts, and production updates.
              </div>
              <button class="btn btn-success btn-sm" disabled>
                <i class="bi bi-gear me-1"></i> Configure Email
              </button>
            </div>
          </div>
        </div>

        <!-- Notification Preferences -->
        <div class="col-md-12">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="bi bi-bell text-warning"></i> Notification Preferences</h5>
              <p class="text-muted small">Manage system notification settings</p>
              <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                Control which notifications are sent, notification frequency, and threshold settings for low stock alerts and production milestones.
              </div>
              <button class="btn btn-warning btn-sm" disabled>
                <i class="bi bi-sliders me-1"></i> Manage Notifications
              </button>
            </div>
          </div>
        </div>

        <!-- Backup & Restore -->
        <div class="col-md-12">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="bi bi-cloud-arrow-down text-danger"></i> Backup & Restore</h5>
              <p class="text-muted small">Manage database backups and restore points</p>
              <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                Create manual backups, schedule automatic backups, and restore from previous backup points. Includes database and uploaded files.
              </div>
              <button class="btn btn-danger btn-sm me-2" disabled>
                <i class="bi bi-download me-1"></i> Create Backup
              </button>
              <button class="btn btn-outline-danger btn-sm" disabled>
                <i class="bi bi-upload me-1"></i> Restore Backup
              </button>
            </div>
          </div>
        </div>

        <!-- System Information -->
        <div class="col-md-12">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="bi bi-info-square text-info"></i> System Information</h5>
              <p class="text-muted small">Current system details and version information</p>
              <table class="table table-sm">
                <tbody>
                  <tr>
                    <th width="30%">System Version</th>
                    <td>1.0.0</td>
                  </tr>
                  <tr>
                    <th>PHP Version</th>
                    <td>{{ phpversion() }}</td>
                  </tr>
                  <tr>
                    <th>Laravel Version</th>
                    <td>{{ app()->version() }}</td>
                  </tr>
                  <tr>
                    <th>Timezone</th>
                    <td>{{ config('app.timezone') }}</td>
                  </tr>
                  <tr>
                    <th>Environment</th>
                    <td><span class="badge bg-{{ app()->environment('production') ? 'success' : 'warning' }}">{{ ucfirst(app()->environment()) }}</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

  <footer class="mt-5 mb-3 text-center">
    <p class="text-muted small">© 2025 Cuevas Bakery. All rights reserved.</p>
  </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
