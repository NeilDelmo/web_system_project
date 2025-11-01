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

        <!-- Email Settings -->
<div class="col-md-12">
  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="card-title"><i class="bi bi-envelope text-success"></i> Email Settings</h5>
      <p class="text-muted small">Set up email notifications for your bakery</p>
      
      <form action="{{ route('settings.email.update') }}" method="POST" class="mt-3">
        @csrf
        
        <!-- Gmail Instructions -->
        <div class="alert alert-info mb-4">
          <h6 class="alert-heading"><i class="bi bi-google me-2"></i>Gmail Setup Instructions</h6>
          <p class="mb-2">Follow these steps to enable email notifications:</p>
          <ol class="mb-0">
            <li>Go to your <a href="https://myaccount.google.com/security" target="_blank" class="alert-link">Google Account Security</a></li>
            <li>Enable <strong>"2-Step Verification"</strong> if not already enabled</li>
            <li>Search for <strong>"App passwords"</strong> and click it</li>
            <li>Generate a new app password for "Mail"</li>
            <li>Copy that 16-character password and paste it below (not your regular Gmail password!)</li>
          </ol>
        </div>

        <!-- Hidden technical fields (auto-configured for Gmail) -->
        <input type="hidden" name="mail_mailer" value="smtp">
        <input type="hidden" name="mail_host" value="smtp.gmail.com">
        <input type="hidden" name="mail_port" value="587">
        <input type="hidden" name="mail_encryption" value="tls">

        <div class="row">
          <!-- User-friendly fields -->
          <div class="col-md-6 mb-3">
            <label class="form-label">Gmail Address *</label>
            <input type="email" name="mail_username" class="form-control" value="{{ $settings['mail_username'] }}" placeholder="yourbakery@gmail.com" required>
            <small class="text-muted">Your Gmail email address</small>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Gmail App Password *</label>
            <input type="password" name="mail_password" class="form-control" value="{{ $settings['mail_password'] }}" placeholder="16-character app password" required>
            <small class="text-muted">Use the app password generated in step 4 above</small>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Bakery Name *</label>
            <input type="text" name="mail_from_name" class="form-control" value="{{ $settings['mail_from_name'] }}" placeholder="Cuevas Bakery" required>
            <small class="text-muted">How your bakery name appears in emails</small>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Reply-To Email *</label>
            <input type="email" name="mail_from_address" class="form-control" value="{{ $settings['mail_from_address'] }}" placeholder="info@cuevasbakery.com" required>
            <small class="text-muted">Where customers can reply to (can be same as Gmail)</small>
          </div>
        </div>
        <button type="submit" class="btn btn-success">
          <i class="bi bi-save me-1"></i> Save Email Settings
        </button>
        <button type="button" class="btn btn-outline-secondary ms-2" onclick="testEmail()">
          <i class="bi bi-send me-1"></i> Send Test Email
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
              </form>
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
