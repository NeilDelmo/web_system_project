<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Audit Logs - Cuevas Bakery</title>
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
    <h2><i class="bi bi-clock-history me-2"></i>Audit Logs</h2>
    <div>
      <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Settings
      </a>
    </div>
  </div>

  <div class="card shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="text-muted mb-0">
              <i class="bi bi-info-circle me-1"></i>
              System activity logs showing all user actions and changes
            </p>
            <span class="badge bg-primary">{{ $audits->total() }} total logs</span>
          </div>

          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead class="table-light">
                <tr>
                  <th style="width: 5%;">ID</th>
                  <th style="width: 15%;">User</th>
                  <th style="width: 12%;">Event</th>
                  <th style="width: 15%;">Model</th>
                  <th style="width: 18%;">Date/Time</th>
                  <th style="width: 35%;">Details</th>
                </tr>
              </thead>
              <tbody>
                @forelse($audits as $audit)
                  <tr>
                    <td>{{ $audit->id }}</td>
                    <td>
                      @if($audit->user)
                        <div>
                          <strong>{{ $audit->user->fullname }}</strong>
                          <br>
                          <small class="text-muted">{{ $audit->user->email }}</small>
                        </div>
                      @else
                        <span class="text-muted">System</span>
                      @endif
                    </td>
                    <td>
                      @php
                        $eventColors = [
                          'created' => 'success',
                          'updated' => 'primary',
                          'deleted' => 'danger',
                          'restored' => 'info',
                        ];
                        $eventColor = $eventColors[$audit->event] ?? 'secondary';
                      @endphp
                      <span class="badge bg-{{ $eventColor }}">
                        <i class="bi bi-{{ $audit->event === 'created' ? 'plus-circle' : ($audit->event === 'updated' ? 'pencil-square' : ($audit->event === 'deleted' ? 'trash' : 'arrow-clockwise')) }}"></i>
                        {{ ucfirst($audit->event) }}
                      </span>
                    </td>
                    <td>
                      <span class="badge bg-light text-dark">{{ class_basename($audit->auditable_type) }}</span>
                      @if($audit->auditable_id)
                        <br><small class="text-muted">ID: {{ $audit->auditable_id }}</small>
                      @endif
                    </td>
                    <td>
                      <div>{{ $audit->created_at->format('M d, Y') }}</div>
                      <small class="text-muted">{{ $audit->created_at->format('h:i A') }}</small>
                    </td>
                    <td>
                      @if($audit->event === 'created')
                        <small class="text-muted">New {{ class_basename($audit->auditable_type) }} created</small>
                      @elseif($audit->event === 'updated')
                        @php
                          $modified = $audit->getModified();
                          $changedFields = array_keys($modified);
                        @endphp
                        @if(count($changedFields) > 0)
                          <small class="text-muted">
                            Changed: <strong>{{ implode(', ', array_slice($changedFields, 0, 3)) }}</strong>
                            @if(count($changedFields) > 3)
                              <span class="badge bg-secondary">+{{ count($changedFields) - 3 }} more</span>
                            @endif
                          </small>
                        @else
                          <small class="text-muted">Fields updated</small>
                        @endif
                      @elseif($audit->event === 'deleted')
                        <small class="text-danger">{{ class_basename($audit->auditable_type) }} deleted</small>
                      @else
                        <small class="text-muted">{{ ucfirst($audit->event) }} action performed</small>
                      @endif
                      
                      @if($audit->ip_address)
                        <br><small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $audit->ip_address }}</small>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                      <i class="bi bi-inbox display-4"></i>
                      <p class="mt-2">No audit logs found</p>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          @if($audits->hasPages())
            <div class="d-flex justify-content-center mt-4">
              {{ $audits->links() }}
            </div>
          @endif
        </div>
      </div>

  <footer class="mt-5 mb-3 text-center">
    <p class="text-muted small">© 2025 Cuevas Bakery. All rights reserved.</p>
  </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
