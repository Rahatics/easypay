@extends('layouts.app')

@section('title', 'Orders - Easypay')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Orders</h1>
                <button class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i> New Order
                </button>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                        <div>
                            <h5 class="card-title mb-1">Order History</h5>
                            <p class="text-muted mb-0">Track and manage all your orders</p>
                        </div>

                        <div class="d-flex gap-2">
                            <div class="input-group" style="max-width: 300px;">
                                <input type="text" class="form-control" placeholder="Search orders...">
                                <button class="btn btn-outline-primary" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>

                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-funnel me-1"></i> Filter
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">All Orders</a></li>
                                    <li><a class="dropdown-item" href="#">Completed</a></li>
                                    <li><a class="dropdown-item" href="#">Pending</a></li>
                                    <li><a class="dropdown-item" href="#">Cancelled</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover order-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Order Details</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    ['date' => 'Oct 24, 2025', 'type' => 'Electronics Purchase', 'to' => 'Amazon', 'amount' => '+$3,500.00', 'status' => 'Completed'],
                                    ['date' => 'Oct 22, 2025', 'type' => 'Online Shopping', 'to' => 'BestBuy', 'amount' => '-$89.99', 'status' => 'Completed'],
                                    ['date' => 'Oct 20, 2025', 'type' => 'Order to John', 'from' => 'John Smith', 'amount' => '-$150.00', 'status' => 'Pending'],
                                    ['date' => 'Oct 18, 2025', 'type' => 'Freelance Service', 'from' => 'Michael Brown', 'amount' => '+$750.00', 'status' => 'Completed'],
                                    ['date' => 'Oct 15, 2025', 'type' => 'Grocery Shopping', 'to' => 'Walmart', 'amount' => '-$125.50', 'status' => 'Cancelled'],
                                    ['date' => 'Oct 12, 2025', 'type' => 'Order to Sarah', 'from' => 'Sarah Johnson', 'amount' => '-$200.00', 'status' => 'Completed'],
                                    ['date' => 'Oct 10, 2025', 'type' => 'Consulting Service', 'to' => 'TechCorp', 'amount' => '+$1,200.00', 'status' => 'Pending'],
                                    ['date' => 'Oct 8, 2025', 'type' => 'Restaurant Payment', 'to' => 'Burger King', 'amount' => '-$45.75', 'status' => 'Completed']
                                ] as $order)
                                <tr>
                                    <td>{{ $order['date'] }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="transaction-icon bg-light-primary me-3">
                                                <i class="bi bi-bag"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $order['type'] }}</h6>
                                                <small class="text-muted">
                                                    @if(isset($order['to']))
                                                        To: {{ $order['to'] }}
                                                    @elseif(isset($order['from']))
                                                        From: {{ $order['from'] }}
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if(str_starts_with($order['type'], 'Order to'))
                                            <span class="badge bg-light-red">Sent</span>
                                        @else
                                            <span class="badge bg-light-green">Received</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $order['amount'] }}</strong>
                                    </td>
                                    <td>
                                        @if($order['status'] == 'Completed')
                                            <span class="badge badge-success">Completed</span>
                                        @elseif($order['status'] == 'Pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @else
                                            <span class="badge badge-secondary">Cancelled</span>
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

                    <nav aria-label="Order pagination">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Order Statistics</h5>
                            <div class="d-flex justify-content-around text-center my-4">
                                <div>
                                    <h3 class="text-primary">24</h3>
                                    <p class="text-muted mb-0">Total Orders</p>
                                </div>
                                <div>
                                    <h3 class="text-success">18</h3>
                                    <p class="text-muted mb-0">Completed</p>
                                </div>
                                <div>
                                    <h3 class="text-warning">4</h3>
                                    <p class="text-muted mb-0">Pending</p>
                                </div>
                                <div>
                                    <h3 class="text-danger">2</h3>
                                    <p class="text-muted mb-0">Cancelled</p>
                                </div>
                            </div>

                            <div class="progress-stacked">
                                <div class="progress" role="progressbar" style="height: 10px">
                                    <div class="progress-bar bg-success" style="width: 75%"></div>
                                    <div class="progress-bar bg-warning" style="width: 15%"></div>
                                    <div class="progress-bar bg-danger" style="width: 10%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Recent Activity</h5>
                            <div class="mt-3">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="transaction-icon bg-light-primary me-3">
                                        <i class="bi bi-check-circle text-success"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Order Completed</h6>
                                        <small class="text-muted">Electronics Purchase - $3,500.00</small>
                                    </div>
                                    <small class="text-muted ms-auto">2 hours ago</small>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <div class="transaction-icon bg-light-green me-3">
                                        <i class="bi bi-arrow-down-circle text-success"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Payment Received</h6>
                                        <small class="text-muted">Freelance Service - $750.00</small>
                                    </div>
                                    <small class="text-muted ms-auto">1 day ago</small>
                                </div>

                                <div class="d-flex align-items-center">
                                    <div class="transaction-icon bg-light me-3">
                                        <i class="bi bi-clock-history text-warning"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Order Pending</h6>
                                        <small class="text-muted">Order to John - $150.00</small>
                                    </div>
                                    <small class="text-muted ms-auto">2 days ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
