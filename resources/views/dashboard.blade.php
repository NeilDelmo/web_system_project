<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cuevas Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Cuevas Bakery</a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title">Welcome, {{ auth()->user()?->full_name ?? auth()->user()?->username ?? 'User' }}</h3>
                <p class="card-text text-muted">You are now logged in to the Cuevas Bakery system.</p>

                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card text-center border-0 shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-people-fill display-4 text-primary"></i>
                                <h5 class="mt-2">Users</h5>
                                <p class="text-muted">Manage system users</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-center border-0 shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-basket-fill display-4 text-success"></i>
                                <h5 class="mt-2">Orders</h5>
                                <p class="text-muted">Track bakery orders</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-center border-0 shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-graph-up display-4 text-warning"></i>
                                <h5 class="mt-2">Reports</h5>
                                <p class="text-muted">View sales reports</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
