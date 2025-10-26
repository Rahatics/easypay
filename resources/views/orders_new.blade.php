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

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

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
                                    <th>Order ID</th>
                                    <th>Amount</th>
                                    <th>Customer</th>
                                    <th>Gateway</th>
                                    <th>Transaction ID</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td>{{ $order->order_id }}</td>
                                    <td>৳{{ number_format($order->total_amount, 2) }}</td>
                                    <td>{{ $order->customer_info['name'] ?? 'N/A' }}</td>
                                    <td>{{ ucfirst($order->gateway) }}</td>
                                    <td>{{ $order->transaction_id ?? 'N/A' }}</td>
                                    <td>
                                        @if($order->status == 'completed')
                                            <span class="badge badge-success">Completed</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge badge-warning">Processing</span>
                                        @elseif($order->status == 'pending')
                                            <span class="badge badge-info">Pending</span>
                                        @elseif($order->status == 'failed')
                                            <span class="badge badge-danger">Failed</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge badge-secondary">Cancelled</span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->status == 'processing')
                                            <form action="{{ route('orders.updateStatus', $order) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to approve this order?')">Approve</button>
                                            </form>
                                            <form action="{{ route('orders.updateStatus', $order) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="status" value="failed">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to reject this order?')">Reject</button>
                                            </form>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="py-5">
                                            <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                            <p class="mt-2">No orders found</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Order Statistics</h5>
                            @php
                                $totalOrders = $orders->total();
                                $completedOrders = $orders->where('status', 'completed')->count();
                                $processingOrders = $orders->where('status', 'processing')->count();
                                $failedOrders = $orders->where('status', 'failed')->count();

                                $completedPercentage = $totalOrders > 0 ? ($completedOrders / $totalOrders * 100) : 0;
                                $processingPercentage = $totalOrders > 0 ? ($processingOrders / $totalOrders * 100) : 0;
                                $failedPercentage = $totalOrders > 0 ? ($failedOrders / $totalOrders * 100) : 0;
                            @endphp
                            <div class="d-flex justify-content-around text-center my-4">
                                <div>
                                    <h3 class="text-primary">{{ $totalOrders }}</h3>
                                    <p class="text-muted mb-0">Total Orders</p>
                                </div>
                                <div>
                                    <h3 class="text-success">{{ $completedOrders }}</h3>
                                    <p class="text-muted mb-0">Completed</p>
                                </div>
                                <div>
                                    <h3 class="text-warning">{{ $processingOrders }}</h3>
                                    <p class="text-muted mb-0">Processing</p>
                                </div>
                                <div>
                                    <h3 class="text-danger">{{ $failedOrders }}</h3>
                                    <p class="text-muted mb-0">Failed</p>
                                </div>
                            </div>

                            <div class="progress-stacked">
                                <div class="progress" role="progressbar" style="height: 10px">
                                    <?php echo '<div class="progress-bar bg-success" style="width: ' . $completedPercentage . '%"></div>'; ?>
                                    <?php echo '<div class="progress-bar bg-warning" style="width: ' . $processingPercentage . '%"></div>'; ?>
                                    <?php echo '<div class="progress-bar bg-danger" style="width: ' . $failedPercentage . '%"></div>'; ?>
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
                                @forelse($orders->take(3) as $order)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="transaction-icon bg-light-primary me-3">
                                        <i class="bi bi-clock-history text-warning"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $order->description }}</h6>
                                        <small class="text-muted">৳{{ number_format($order->total_amount, 2) }}</small>
                                    </div>
                                    <small class="text-muted ms-auto">{{ $order->created_at->diffForHumans() }}</small>
                                </div>
                                @empty
                                <div class="text-center py-3">
                                    <p class="text-muted">No recent activity</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
