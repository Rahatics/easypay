@extends('layouts.app')

@section('title', 'Dashboard - Easypay')

@section('content')
<div class="welcome-banner">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="display-5 fw-bold mb-3">Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="lead mb-0">Here's what's happening with your account today.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <button class="btn btn-light btn-lg">
                <i class="bi bi-plus-circle me-2"></i> New Order
            </button>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card stat-card">
            <div class="card-body">
                <h6 class="card-title text-white-50">Total Balance</h6>
                <h2 class="display-4 mb-0">৳{{ number_format($totalRevenue, 2) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted">This Month</h6>
                <h2 class="display-5 text-primary mb-0">৳{{ number_format($thisMonthRevenue, 2) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted">Orders</h6>
                <h2 class="display-5 text-success mb-0">{{ $totalOrders }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted">Pending Orders</h6>
                <h2 class="display-5 text-info mb-0">{{ $pendingOrders }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Features and Chart -->
<div class="row mb-4">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Quick Actions</h5>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="feature-card">
                            <div class="transaction-icon bg-light-primary mx-auto">
                                <i class="bi bi-bag-plus"></i>
                            </div>
                            <h5>Place Order</h5>
                            <p class="text-muted">Create new order</p>
                            <a href="#" class="btn btn-outline-primary">Place</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="feature-card">
                            <div class="transaction-icon bg-light-green mx-auto">
                                <i class="bi bi-bag-check"></i>
                            </div>
                            <h5>Track Order</h5>
                            <p class="text-muted">Check status</p>
                            <a href="{{ route('orders') }}" class="btn btn-outline-success">Track</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="feature-card">
                            <div class="transaction-icon bg-light mx-auto">
                                <i class="bi bi-bar-chart"></i>
                            </div>
                            <h5>Analytics</h5>
                            <p class="text-muted">View reports</p>
                            <a href="#" class="btn btn-outline-info">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Spending Overview</h5>
                <div class="chart-container">
                    <div class="chart-placeholder">
                        <i class="bi bi-graph-up"></i>
                        <p>Spending Chart</p>
                        <small class="text-muted">Visualization coming soon</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="row">
    <div class="col-12">
        <div class="card recent-orders">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row">
                    <h5 class="card-title mb-3 mb-md-0">Recent Orders</h5>
                    <a href="{{ route('orders') }}" class="btn btn-outline-primary">View All</a>
                </div>

                @forelse($recentOrders as $order)
                <div class="order-item d-flex align-items-center">
                    <div class="transaction-icon bg-light-primary">
                        <i class="bi bi-bag"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">{{ $order->description ?? 'Order #' . $order->order_id }}</h6>
                        <small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small>
                    </div>
                    <div class="fw-bold @if($order->status == 'completed') text-success @elseif($order->status == 'failed') text-danger @else text-muted @endif">
                        ৳{{ number_format($order->amount, 2) }}
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                    <p class="mt-2">No recent orders</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
