@extends('layouts.app')

@section('title', 'Dashboard - Easypay')

@section('content')
<!-- Welcome Banner -->
<div class="card stat-card mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold mb-3">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="lead mb-0">Here's what's happening with your account today.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <button class="btn btn-light btn-lg">
                    <i class="bi bi-plus-circle me-2"></i> New Order
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card stat-card">
            <div class="card-body">
                <h6 class="card-title text-white-50">Total Balance</h6>
                <h2 class="display-4 mb-0">$12,450.75</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted">This Month</h6>
                <h2 class="display-5 text-primary mb-0">$4,230.50</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted">Orders</h6>
                <h2 class="display-5 text-success mb-0">142</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted">Savings</h6>
                <h2 class="display-5 text-info mb-0">$850.25</h2>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions and Chart -->
<div class="row mb-4">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="text-center">
                            <div class="bg-light-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                                <i class="bi bi-bag-plus text-primary fs-3"></i>
                            </div>
                            <h5>Place Order</h5>
                            <p class="text-muted small">Create new order</p>
                            <a href="#" class="btn btn-outline-primary">Place</a>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="text-center">
                            <div class="bg-light-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                                <i class="bi bi-bag-check text-success fs-3"></i>
                            </div>
                            <h5>Track Order</h5>
                            <p class="text-muted small">Check status</p>
                            <a href="#" class="btn btn-outline-success">Track</a>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="text-center">
                            <div class="bg-light-info rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                                <i class="bi bi-bar-chart text-info fs-3"></i>
                            </div>
                            <h5>Analytics</h5>
                            <p class="text-muted small">View reports</p>
                            <a href="#" class="btn btn-outline-info">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Spending Overview</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-center" style="height: 250px;">
                    <div class="text-center">
                        <i class="bi bi-graph-up text-primary fs-1 mb-3"></i>
                        <p class="mb-0">Spending Chart</p>
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
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Orders</h5>
                <a href="{{ route('orders') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Oct 24, 2025</td>
                                <td>Electronics Purchase</td>
                                <td class="fw-bold text-success">+$3,500.00</td>
                                <td><span class="badge bg-success">Completed</span></td>
                            </tr>
                            <tr>
                                <td>Oct 22, 2025</td>
                                <td>Online Shopping</td>
                                <td class="fw-bold text-danger">-$89.99</td>
                                <td><span class="badge bg-success">Completed</span></td>
                            </tr>
                            <tr>
                                <td>Oct 20, 2025</td>
                                <td>Order to John</td>
                                <td class="fw-bold text-danger">-$150.00</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                            </tr>
                            <tr>
                                <td>Oct 18, 2025</td>
                                <td>Freelance Service</td>
                                <td class="fw-bold text-success">+$750.00</td>
                                <td><span class="badge bg-success">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
