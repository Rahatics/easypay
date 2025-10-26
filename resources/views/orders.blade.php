@extends('layouts.app')

@section('title', 'Orders - Easypay')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Orders</h1>

        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Order History</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Oct 24, 2025</td>
                                        <td>Electronics Purchase</td>
                                        <td>Received</td>
                                        <td class="fw-bold text-success">+$3,500.00</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td>Oct 22, 2025</td>
                                        <td>Online Shopping</td>
                                        <td>Sent</td>
                                        <td class="fw-bold text-danger">-$89.99</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td>Oct 20, 2025</td>
                                        <td>Order to John</td>
                                        <td>Sent</td>
                                        <td class="fw-bold text-danger">-$150.00</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>Oct 18, 2025</td>
                                        <td>Freelance Service</td>
                                        <td>Received</td>
                                        <td class="fw-bold text-success">+$750.00</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td>Oct 15, 2025</td>
                                        <td>Grocery Shopping</td>
                                        <td>Sent</td>
                                        <td class="fw-bold text-danger">-$125.50</td>
                                        <td><span class="badge bg-danger">Cancelled</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Order Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total Orders</span>
                            <strong>24</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Completed</span>
                            <strong class="text-success">18</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Pending</span>
                            <strong class="text-warning">4</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Cancelled</span>
                            <strong class="text-danger">2</strong>
                        </div>
                        <div class="progress mt-4">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 75%"></div>
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 17%"></div>
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 8%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Create New Order</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="recipient" class="form-label">Recipient</label>
                                    <select class="form-select" id="recipient">
                                        <option selected>Select recipient</option>
                                        <option>John Smith</option>
                                        <option>Sarah Johnson</option>
                                        <option>Michael Brown</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" id="amount" placeholder="Enter amount">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" rows="3" placeholder="Enter order description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="gateway" class="form-label">Payment Gateway</label>
                                <select class="form-select" id="gateway">
                                    <option selected>Select payment gateway</option>
                                    <option>bkash</option>
                                    <option>Nagad</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-2"></i> Send Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
