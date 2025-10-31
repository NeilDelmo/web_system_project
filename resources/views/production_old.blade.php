<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #fff9e6, #fff3cd, #fce6a4);
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif;
        }

        /* Sidebar */
        .sidebar {
            background-color: #ffffff;
            width: 250px;
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .sidebar .brand {
            background-color: #ffee8c; 
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .sidebar-logo {
            max-height: 100%;
            max-width: 80%;
            object-fit: contain;
            display: block;
        }

        .sidebar .nav-link {
            color: #444;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            margin: 0.25rem 0.75rem;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link:hover {
            background-color: #fff3cd;
            color: #b71c1c;
        }

        .sidebar .nav-link.active {
            background-color: #ffee8c;
            color: #000;
            font-weight: 600;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 1rem;
            width: 100%;
            text-align: center;
            font-size: 0.85rem;
            color: #777;
        }

        /* Main Content */
        .main-content {
            flex-grow: 1;
        }

        .page-header {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .tab-nav .nav-link {
            color: #555;
        }

        .tab-nav .nav-link.active {
            border-bottom: 3px solid #fdd663;
            color: #000;
        }

        .card-item {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            text-align: center;
        }

        .card-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .card-item .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <aside class="sidebar position-relative">
        <div class="brand d-flex align-items-center justify-content-center">
            <img src="{{ asset('images/logo.png') }}" alt="Cuevas Bread Logo" class="sidebar-logo">
        </div>

        <nav class="nav flex-column mt-4">
            <a href="/dashboard" class="nav-link"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
            <a href="/products" class="nav-link"><i class="bi bi-basket-fill me-2"></i>Products</a>
            <a href="/inventory" class="nav-link"><i class="bi bi-box-seam me-2"></i>Inventory</a>
            <a href="/production" class="nav-link active"><i class="bi bi-gear-fill me-2"></i>Production</a>
            <a href="/sales" class="nav-link"><i class="bi bi-cart-check-fill me-2"></i>Sales & Orders</a>
            <a href="/reports" class="nav-link"><i class="bi bi-bar-chart-line-fill me-2"></i>Reports</a>
        </nav>

        <div class="sidebar-footer">
            <div class="dropdown text-center">
                <a href="#" class="d-flex flex-column align-items-center text-decoration-none text-dark dropdown-toggle" id="adminMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('images/user-avatar.jpg') }}" alt="User" class="rounded-circle mb-2" width="50" height="50">
                    <strong>Admin</strong>
                    <small class="text-muted">Manager</small>
                </a>

                <ul class="dropdown-menu shadow border-0 mt-2 text-center" aria-labelledby="adminMenu">
                    <!-- Optional profile link -->
                    <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person-circle me-1"></i> Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <!-- Logout link -->
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger py-2">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <div>
                <h2 class="fw-semibold mb-1">Production Management</h2>
                <p class="text-muted mb-0 small">Monitor and manage all production operations.</p>
            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs tab-nav bg-white px-4 border-bottom" id="productionTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="batches-tab" data-bs-toggle="tab" href="#batches" role="tab">Production Batches</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="schedule-tab" data-bs-toggle="tab" href="#schedule" role="tab">Schedule Production</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tracking-tab" data-bs-toggle="tab" href="#tracking" role="tab">Batch Tracking</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="quality-tab" data-bs-toggle="tab" href="#quality" role="tab">Quality Control Remarks</a>
            </li>
        </ul>

        <div class="tab-content p-4" id="productionTabsContent">
            <!-- Production Batches -->
            <div class="tab-pane fade show active" id="batches" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Production Batches</h5>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#createBatchModal">
                        <i class="bi bi-plus-circle me-1"></i> Add Batch
                    </button>
                </div>
                <p class="text-muted mb-4">View and manage daily production batches.</p>
            </div>

            <!-- Schedule Production -->
            <div class="tab-pane fade" id="schedule" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Schedule Production</h5>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#scheduleProductionModal">
                        <i class="bi bi-calendar-plus me-1"></i> Add Schedule
                    </button>
                </div>
                <p class="text-muted mb-4">Plan upcoming bakery production schedules.</p>
            </div>

            <!-- Batch Tracking -->
            <div class="tab-pane fade" id="tracking" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Batch Tracking</h5>
                    <button class="btn btn-outline-secondary"><i class="bi bi-search me-1"></i> Track Batch</button>
                </div>
                <p class="text-muted mb-4">Monitor progress and current status of batches in production.</p>
            </div>

            <!-- Quality Control -->
            <div class="tab-pane fade" id="quality" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Quality Control Remarks</h5>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addQCModal">
                        <i class="bi bi-calendar-plus me-1"></i> Add QC Remark
                    </button>
                </div>
                <p class="text-muted mb-4">Log remarks and quality checks for finished batches.</p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center py-3 border-top bg-white small text-muted mt-5">
            &copy; {{ date('Y') }} Cuevas Bread. All rights reserved.
        </footer>
    </main>

    <!-- Create Batch Modal -->
    <div class="modal fade" id="createBatchModal" tabindex="-1" aria-labelledby="createBatchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title fw-semibold" id="createBatchModalLabel">
                        <i class="bi bi-gear-wide-connected text-danger me-2"></i> Create Production Batch
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form>
                    <div class="modal-body px-4 py-3">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Batch Name</label>
                                <input type="text" class="form-control" placeholder="e.g. Morning Batch 01" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Production Date</label>
                                <input type="date" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Product Type</label>
                                <select class="form-select">
                                    <option selected disabled>Select product</option>
                                    <!--Dynamic product list to be populated here-->
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Target Quantity</label>
                                <input type="number" class="form-control" placeholder="e.g. 500" min="1">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Notes</label>
                            <textarea class="form-control" rows="2" placeholder="Special instructions or remarks"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer bg-light border-top-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger px-4"><i class="bi bi-check-circle me-1"></i> Save Batch</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        <!-- Schedule Production Modal -->
    <div class="modal fade" id="scheduleProductionModal" tabindex="-1" aria-labelledby="scheduleProductionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title fw-semibold" id="scheduleProductionModalLabel">
                        <i class="bi bi-calendar-plus text-danger me-2"></i> Schedule New Production
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form>
                    <div class="modal-body px-4 py-3">
                        <!-- Schedule Info -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Production Name</label>
                                <input type="text" class="form-control" placeholder="e.g. Evening Batch" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Scheduled Date</label>
                                <input type="date" class="form-control" required>
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Select Product</label>
                                <select class="form-select" required>
                                    <option selected disabled>Choose product</option>
                                <!--Dynamic product list to be populated here-->
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Planned Quantity</label>
                                <input type="number" class="form-control" placeholder="e.g. 300" min="1" required>
                            </div>
                        </div>

                        <!-- Time Slot -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Start Time</label>
                                <input type="time" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">End Time</label>
                                <input type="time" class="form-control" required>
                            </div>
                        </div>

                        <!-- Assigned Staff -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Assigned Staff</label>
                            <select class="form-select">
                                <option selected disabled>Select staff</option>
                                <!--Dynamic staff list to be populated here-->
                            </select>
                        </div>

                        <!-- Remarks -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Remarks</label>
                            <textarea class="form-control" rows="2" placeholder="Add production notes or special reminders"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer bg-light border-top-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger px-4"><i class="bi bi-check-circle me-1"></i> Save Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add QC Remark Modal -->
    <div class="modal fade" id="addQCModal" tabindex="-1" aria-labelledby="addQCModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-warning-subtle">
                    <h5 class="modal-title fw-semibold" id="addQCModalLabel">
                        <i class="bi bi-clipboard-check text-danger me-2"></i> Add Quality Control Remark
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form>
                    <div class="modal-body px-4 py-3">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Select Batch</label>
                                <select class="form-select" required>
                                    <option selected disabled>Select production batch</option>
                                    <!--Dynamic batch list to be populated here-->
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">QC Status</label>
                                <select class="form-select" required>
                                    <option selected disabled>Select status</option>
                                    <option value="Passed">✅ Passed</option>
                                    <option value="Recheck">⚠️ Needs Recheck</option>
                                    <option value="Failed">❌ Failed</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Remarks</label>
                            <textarea class="form-control" rows="3" placeholder="Describe quality observations, e.g. underbaked, uneven color, etc." required></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Checked By</label>
                                <input type="text" class="form-control" placeholder="Enter inspector name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Date Checked</label>
                                <input type="date" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light border-top-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="bi bi-check-circle me-1"></i> Save QC Remark
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>