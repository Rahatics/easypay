@extends('layouts.modern')

@section('title', 'Setup - Easypay')

@section('content')
<div class="container-fluid p-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Website Setup</h1>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Configuration</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('setup.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="website_name" class="form-label">Website Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="website_name" name="website_name" value="{{ old('website_name', $setupData['website_name'] ?? '') }}" placeholder="Enter your website name" required>
                                <button class="btn btn-outline-primary copy-btn" type="button" data-target="website_name">
                                    <i class="bi bi-clipboard"></i> Copy
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="website_logo" class="form-label">Website Logo</label>
                            <input type="file" class="form-control" id="website_logo" name="website_logo" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="api_key" class="form-label">API Key</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="api_key" name="api_key" value="{{ old('api_key', $setupData['api_key'] ?? '') }}" readonly>
                                <button class="btn btn-outline-primary copy-btn" type="button" data-target="api_key">
                                    <i class="bi bi-clipboard"></i> Copy
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="secret_key" class="form-label">Secret Key</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="secret_key" name="secret_key" value="{{ old('secret_key', $setupData['secret_key'] ?? '') }}" readonly>
                                <button class="btn btn-outline-primary" type="button" id="generateSecretKey">
                                    <i class="bi bi-arrow-repeat"></i> Generate New
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="merchant_id" class="form-label">Merchant ID</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="merchant_id" name="merchant_id" value="{{ old('merchant_id', $setupData['merchant_id'] ?? '') }}" placeholder="Enter your merchant ID" required>
                                <button class="btn btn-outline-primary copy-btn" type="button" data-target="merchant_id">
                                    <i class="bi bi-clipboard"></i> Copy
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i> Save Configuration
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Copy buttons functionality
        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    targetElement.select();
                    document.execCommand('copy');

                    // Show feedback
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-check-circle"></i> Copied!';
                    setTimeout(() => {
                        this.innerHTML = originalText;
                    }, 2000);
                }
            });
        });

        // Generate Secret Key
        document.getElementById('generateSecretKey').addEventListener('click', function() {
            fetch("{{ route('setup.generate.credentials') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    type: 'secret_key'
                })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('secret_key').value = data.secret_key;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
</script>
@endsection
