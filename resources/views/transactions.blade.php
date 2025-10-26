<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions - Easypay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #6f42c1;
            --secondary: #00c9a7;
            --dark: #2b3035;
            --light: #f8f9fa;
        }

        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar {
            background: linear-gradient(180deg, var(--primary), #5a32a3);
            color: white;
            height: calc(100vh - 56px);
            position: fixed;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 5px;
            margin: 5px 10px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 25px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
        }

        .transaction-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .bg-light-purple {
            background-color: rgba(111, 66, 193, 0.1);
            color: var(--primary);
        }

        .bg-light-green {
            background-color: rgba(0, 201, 167, 0.1);
            color: var(--secondary);
        }

        .bg-light-red {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .transaction-table th {
            font-weight: 600;
            color: #6c757d;
        }

        .badge-success {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .badge-warning {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .badge-secondary {
            background-color: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
                <i class="bi bi-lightning-charge-fill me-2 text-primary"></i>
                <span class="fw-bold">Easypay</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <div class="me-2">
                                <span class="fw-medium">{{ Auth::user()->name }}</span>
                                <small class="d-block text-muted">Premium User</small>
                            </div>
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-person text-primary"></i>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="bi bi-gear me-2"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 d-lg-block d-none p-0">
                <div class="sidebar p-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('connect') }}">
                                <i class="bi bi-people me-2"></i> Connect
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('transactions') }}">
                                <i class="bi bi-arrow-left-right me-2"></i> Transactions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('gateways') }}">
                                <i class="bi bi-credit-card me-2"></i> Gateways
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('settings') }}">
                                <i class="bi bi-gear me-2"></i> Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 col-12 p-0">
                <div class="main-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h1>Transactions</h1>
                                <button class="btn btn-primary">
                                    <i class="bi bi-download me-2"></i> Export
                                </button>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="card-title mb-0">Transaction History</h5>
                                        <div class="d-flex gap-2">
                                            <div class="input-group" style="width: 300px;">
                                                <input type="text" class="form-control" placeholder="Search transactions...">
                                                <button class="btn btn-outline-secondary" type="button">
                                                    <i class="bi bi-search"></i>
                                                </button>
                                            </div>
                                            <select class="form-select" style="width: 150px;">
                                                <option>All Types</option>
                                                <option>Payments Sent</option>
                                                <option>Payments Received</option>
                                            </select>
                                        </div>
                                    </div>

                                    @if($transactions->isEmpty())
                                        <div class="text-center py-5">
                                            <i class="bi bi-arrow-left-right text-muted" style="font-size: 3rem;"></i>
                                            <h3 class="mt-3">No Transactions Yet</h3>
                                            <p class="text-muted">When you start sending or receiving payments, they will appear here.</p>
                                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                                <i class="bi bi-wallet2 me-2"></i> Make Your First Payment
                                            </a>
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table transaction-table">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Description</th>
                                                        <th>Gateway</th>
                                                        <th>Amount</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($transactions as $transaction)
                                                    <tr>
                                                        <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="transaction-icon bg-light-purple me-3">
                                                                    <i class="bi bi-bag"></i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0">{{ $transaction->description ?? 'Order #' . $transaction->order_id }}</h6>
                                                                    <small class="text-muted">
                                                                        Order ID: {{ $transaction->order_id }}
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-light-primary">{{ ucfirst($transaction->gateway) }}</span>
                                                        </td>
                                                        <td>
                                                            <strong>৳{{ number_format($transaction->total_amount, 0) }}</strong>
                                                        </td>
                                                        <td>
                                                            @if($transaction->status == 'completed')
                                                                <span class="badge badge-success">Completed</span>
                                                            @elseif($transaction->status == 'processing')
                                                                <span class="badge badge-warning">Processing</span>
                                                            @elseif($transaction->status == 'pending')
                                                                <span class="badge badge-warning">Pending</span>
                                                            @elseif($transaction->status == 'failed')
                                                                <span class="badge badge-secondary">Failed</span>
                                                            @elseif($transaction->status == 'cancelled')
                                                                <span class="badge badge-secondary">Cancelled</span>
                                                            @else
                                                                <span class="badge badge-secondary">{{ ucfirst($transaction->status) }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $transactions->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
