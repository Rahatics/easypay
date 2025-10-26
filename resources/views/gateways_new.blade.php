@extends('layouts.app')

@section('title', 'Payment Gateways - Easypay')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Payment Gateways</h1>

            <div class="row">
                @foreach([
                    ['id' => 1, 'name' => 'bkash', 'description' => 'Bangladeshi mobile financial service', 'fees' => '1.8% per transaction', 'enabled' => true],
                    ['id' => 2, 'name' => 'Nagad', 'description' => 'Bangladeshi mobile financial service', 'fees' => '1.5% per transaction', 'enabled' => false]
                ] as $gateway)
                <div class="col-md-6 mb-4">
                    <div class="card gateway-card {{ strtolower($gateway['name']) }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="card-title mb-1">{{ $gateway['name'] }}</h5>
                                    <p class="text-muted mb-0">{{ $gateway['description'] }}</p>
                                </div>
                                <span class="badge bg-success">Active</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <small class="text-muted">Transaction Fees</small>
                                    <p class="mb-0 fw-bold">{{ $gateway['fees'] }}</p>
                                </div>
                                <div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="gateway_{{ $gateway['id'] }}" name="enabled" {{ $gateway['enabled'] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gateway_{{ $gateway['id'] }}">Enable</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn btn-primary me-md-2" data-bs-toggle="modal" data-bs-target="#configModal{{ $gateway['id'] }}">
                                    <i class="bi bi-gear me-2"></i> Configure
                                </button>
                                <button type="button" class="btn btn-outline-secondary">
                                    <i class="bi bi-info-circle me-2"></i> Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configuration Modal for each gateway -->
                <div class="modal fade" id="configModal{{ $gateway['id'] }}" tabindex="-1" aria-labelledby="configModalLabel{{ $gateway['id'] }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="configModalLabel{{ $gateway['id'] }}">{{ $gateway['name'] }} Configuration</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="account_number_{{ $gateway['id'] }}" class="form-label">Account Number</label>
                                        <input type="text" class="form-control" id="account_number_{{ $gateway['id'] }}" placeholder="Enter your account number">
                                    </div>
                                    <div class="mb-3">
                                        <label for="extra_charge_{{ $gateway['id'] }}" class="form-label">Extra Charge (in %)</label>
                                        <input type="number" class="form-control" id="extra_charge_{{ $gateway['id'] }}" placeholder="Enter extra charge percentage" min="0" max="100" step="0.01">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Add New Gateway</h5>
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gateway_name" class="form-label">Gateway Name</label>
                                    <input type="text" class="form-control" id="gateway_name" placeholder="Enter gateway name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gateway_fees" class="form-label">Transaction Fees</label>
                                    <input type="text" class="form-control" id="gateway_fees" placeholder="e.g., 2.9% + $0.30 per transaction" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="gateway_description" class="form-label">Description</label>
                            <textarea class="form-control" id="gateway_description" rows="3" placeholder="Enter gateway description" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-plus-circle me-2"></i> Add Gateway
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
