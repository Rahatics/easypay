@extends('layouts.app')

@section('title', 'Payment Gateways - Easypay')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Payment Gateways</h1>
            <a href="{{ route('docs.integration') }}" class="btn btn-outline-primary">
                <i class="bi bi-book me-2"></i>Integration Guide
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-4">
            @foreach($gateways as $gateway)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $gateway['name'] }}</h5>
                        <span class="badge {{ $gateway['enabled'] ? 'bg-success' : 'bg-secondary' }}">
                            {{ $gateway['enabled'] ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">{{ $gateway['description'] }}</p>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Transaction Fees:</span>
                            <strong>{{ $gateway['fees'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Account Number:</span>
                            <strong>{{ $gateway['account_number'] ?? 'Not configured' }}</strong>
                        </div>

                        <!-- Toggle Switch -->
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input gateway-toggle" type="checkbox" id="switch{{ $gateway['id'] }}" data-gateway-id="{{ $gateway['id'] }}" {{ $gateway['enabled'] ? 'checked' : '' }}>
                            <label class="form-check-label" for="switch{{ $gateway['id'] }}">Enable {{ $gateway['name'] }}</label>
                        </div>

                        <!-- Configure Button -->
                        <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#configureModal{{ $gateway['id'] }}">
                            <i class="bi bi-gear me-2"></i> Configure
                        </button>
                    </div>
                </div>
            </div>

            <!-- Configuration Modal -->
            <div class="modal fade" id="configureModal{{ $gateway['id'] }}" tabindex="-1" aria-labelledby="configureModalLabel{{ $gateway['id'] }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('gateways.update', $gateway['id']) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="configureModalLabel{{ $gateway['id'] }}">Configure {{ $gateway['name'] }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="account_number{{ $gateway['id'] }}" class="form-label">Account Number</label>
                                    <input type="text" class="form-control" id="account_number{{ $gateway['id'] }}" name="account_number" value="{{ old('account_number', $gateway['account_number'] ?? '') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="fees{{ $gateway['id'] }}" class="form-label">Transaction Fees (%)</label>
                                    <input type="text" class="form-control" id="fees{{ $gateway['id'] }}" name="fees" value="{{ old('fees', preg_replace('/[^0-9.]/', '', $gateway['fees']) ?? '') }}" placeholder="Enter fee percentage (e.g., 1.5)" required>
                                </div>
                                <div class="form-check mb-3">
                                    <input type="hidden" name="enabled" value="0">
                                    <input class="form-check-input" type="checkbox" id="enabled{{ $gateway['id'] }}" name="enabled" value="1" {{ old('enabled', $gateway['enabled'] ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="enabled{{ $gateway['id'] }}">Enable Gateway</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Gateway Management</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">Payment gateways can only be added by developers. Please contact your system administrator to request new payment gateways.</p>
                        <p class="mb-0 mt-2 text-muted">For developers: New gateways can be added through the admin panel or by modifying the gateway configuration files.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle gateway toggle switches
    document.querySelectorAll('.gateway-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const gatewayId = this.getAttribute('data-gateway-id');

            fetch("{{ url('/gateways') }}/" + gatewayId + "/toggle", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success alert-dismissible fade show';
                    alertDiv.role = 'alert';
                    alertDiv.innerHTML = data.message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';

                    // Insert alert before the first card
                    document.querySelector('.row.mb-4').insertAdjacentElement('beforebegin', alertDiv);

                    // Remove alert after 3 seconds
                    setTimeout(() => {
                        alertDiv.remove();
                    }, 3000);

                    // Update badge status
                    const badge = this.closest('.card').querySelector('.badge');
                    if (this.checked) {
                        badge.className = 'badge bg-success';
                        badge.textContent = 'Active';
                    } else {
                        badge.className = 'badge bg-secondary';
                        badge.textContent = 'Inactive';
                    }
                } else {
                    // Revert the toggle if there was an error
                    this.checked = !this.checked;
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                // Revert the toggle if there was an error
                this.checked = !this.checked;
                console.error('Error:', error);
                alert('An error occurred while updating the gateway status.');
            });
        });
    });
});
</script>
@endsection
