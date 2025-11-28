<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>System Settings - {{ $bakeryInfo['name'] ?? 'Cuevas Bakery' }}</title>
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
              
              <form action="{{ route('settings.bakery-info.update') }}" method="POST" class="mt-3">
                @csrf
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Bakery Name *</label>
                    <input type="text" name="bakery_name" class="form-control" value="{{ $settings['bakery_name'] }}" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="bakery_phone" class="form-control" value="{{ $settings['bakery_phone'] }}">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="bakery_email" class="form-control" value="{{ $settings['bakery_email'] }}">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Operating Hours</label>
                    <input type="text" name="operating_hours" class="form-control" value="{{ $settings['operating_hours'] }}" placeholder="e.g., Mon-Fri: 8AM-6PM">
                  </div>
                  <div class="col-md-12 mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="bakery_address" class="form-control" rows="2">{{ $settings['bakery_address'] }}</textarea>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-save me-1"></i> Save Changes
                </button>
              </form>
            </div>
          </div>
        </div>

        <!-- Notification Preferences -->
        <div class="col-md-12">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="bi bi-bell text-warning"></i> Notification Preferences</h5>
              <p class="text-muted small">Manage system notification settings</p>
              
              <form action="{{ route('settings.notifications.update') }}" method="POST" class="mt-3">
                @csrf
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" name="notify_low_stock" value="1" id="notifyLowStock" {{ $settings['notify_low_stock'] ? 'checked' : '' }}>
                      <label class="form-check-label" for="notifyLowStock">
                        <strong>Low Stock Alerts</strong><br>
                        <small class="text-muted">Get notified when inventory is running low</small>
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Low Stock Threshold</label>
                    <input type="number" name="low_stock_threshold" class="form-control" value="{{ $settings['low_stock_threshold'] }}" min="1" max="1000" required>
                    <small class="text-muted">Alert when stock falls below this quantity</small>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" name="notify_orders" value="1" id="notifyOrders" {{ $settings['notify_orders'] ? 'checked' : '' }}>
                      <label class="form-check-label" for="notifyOrders">
                        <strong>Order Notifications</strong><br>
                        <small class="text-muted">Get notified about new orders</small>
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" name="notify_production" value="1" id="notifyProduction" {{ $settings['notify_production'] ? 'checked' : '' }}>
                      <label class="form-check-label" for="notifyProduction">
                        <strong>Production Updates</strong><br>
                        <small class="text-muted">Get notified about production milestones</small>
                      </label>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-warning">
                  <i class="bi bi-save me-1"></i> Save Preferences
                </button>
                <button type="button" class="btn btn-outline-secondary ms-2" onclick="testEmail()">
                  <i class="bi bi-send me-1"></i> Send Test Email
                </button>
              </form>
            </div>
          </div>
        </div>

      </div>

  <footer class="mt-5 mb-3 text-center">
    <p class="text-muted small">© {{ date('Y') }} {{ $bakeryInfo['name'] ?? 'Cuevas Bakery' }}. All rights reserved.</p>
  </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
  function testEmail() {
    if(confirm('Send a test email to your bakery email address?')) {
        fetch('{{ route("settings.test-email") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Test email sent successfully! Check your inbox.');
            } else {
                alert('Failed to send test email: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error sending test email.');
        });
    }
}
</html>
