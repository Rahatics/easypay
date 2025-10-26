@extends('layouts.app')

@section('title', 'Setup - Easypay')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Merchant Setup</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Merchant Configuration</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('setup.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="website_name" class="form-label">Website Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="website_name" name="website_name" value="{{ old('website_name', session('website_name', $setupData['website_name'] ?? '')) }}" placeholder="Enter your website name" required>
                                    <button class="btn btn-outline-primary copy-btn" type="button" data-target="website_name">
                                        <i class="bi bi-clipboard"></i> Copy
                                    </button>
                                </div>
                                @error('website_name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="website_logo" class="form-label">Website Logo</label>
                                <input type="file" class="form-control" id="website_logo" name="website_logo" accept="image/*">
                                @error('website_logo')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror

                                @if(session('website_logo') || !empty($setupData['website_logo']))
                                    <div class="mt-2">
                                        <img src="{{ session('website_logo', $setupData['website_logo']) }}" alt="Current Logo" class="img-thumbnail" style="max-height: 100px;">
                                    </div>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="api_key" class="form-label">API Key</label>
                                <div class="input-group">
                                    @if(!empty($setupData['api_key']))
                                        <input type="text" class="form-control" id="api_key" name="api_key" value="{{ old('api_key', $setupData['api_key'] ?? '') }}" readonly>
                                        <button class="btn btn-outline-primary copy-btn" type="button" data-target="api_key">
                                            <i class="bi bi-clipboard"></i> Copy
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-primary generate-credentials-btn" id="generateApiKey">
                                            <i class="bi bi-key me-2"></i> Generate API Key
                                        </button>
                                    @endif
                                </div>
                                @error('api_key')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="secret_key" class="form-label">Secret Key</label>
                                <div class="input-group">
                                    @if(session('plain_secret_key') || !empty($setupData['secret_key']))
                                        <input type="text" class="form-control" id="secret_key" name="secret_key" value="{{ session('plain_secret_key', old('secret_key', $setupData['secret_key'] ?? '')) }}" readonly>
                                        <button class="btn btn-outline-primary copy-btn" type="button" data-target="secret_key">
                                            <i class="bi bi-clipboard"></i> Copy
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-primary generate-credentials-btn" id="generateSecretKey">
                                            <i class="bi bi-shield-lock me-2"></i> Generate Secret Key
                                        </button>
                                    @endif
                                </div>
                                @error('secret_key')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="merchant_id" class="form-label">Merchant ID</label>
                                <div class="input-group">
                                    @if(!empty($setupData['merchant_id']))
                                        <input type="text" class="form-control" id="merchant_id" name="merchant_id" value="{{ old('merchant_id', $setupData['merchant_id'] ?? '') }}" readonly>
                                        <button class="btn btn-outline-primary copy-btn" type="button" data-target="merchant_id">
                                            <i class="bi bi-clipboard"></i> Copy
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-primary generate-credentials-btn" id="generateMerchantId">
                                            <i class="bi bi-person-badge me-2"></i> Generate Merchant ID
                                        </button>
                                    @endif
                                </div>
                                @error('merchant_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i> Save Configuration
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Setup Instructions</h5>
                    </div>
                    <div class="card-body">
                        <ol class="list-group list-group-numbered">
                            <li class="list-group-item">
                                <h6 class="mb-1">Website Name</h6>
                                <p class="mb-0 text-muted small">Enter the name of your website or business.</p>
                            </li>
                            <li class="list-group-item">
                                <h6 class="mb-1">Website Logo</h6>
                                <p class="mb-0 text-muted small">Upload your website logo (optional).</p>
                            </li>
                            <li class="list-group-item">
                                <h6 class="mb-1">API Credentials</h6>
                                <p class="mb-0 text-muted small">These are your unique API credentials. Copy them to integrate with your website.</p>
                            </li>
                        </ol>

                        <div class="alert alert-info mt-4">
                            <h6 class="alert-heading"><i class="bi bi-info-circle-fill me-2"></i>Important</h6>
                            <p class="mb-0 small">These API credentials are unique to your merchant account. Keep them secure and never share them publicly.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Integration Code</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">Use the following code snippet to integrate Easypay with your website:</p>

                        <pre class="bg-dark text-light p-4 rounded"><code>&lt;script src="{{ asset('js/easypay-sdk.js') }}"&gt;&lt;/script&gt;
&lt;script&gt;
    const easypay = new Easypay({
        apiKey: "{{ $setupData['api_key'] ?? 'YOUR_API_KEY' }}",
        merchantId: "{{ $setupData['merchant_id'] ?? 'YOUR_MERCHANT_ID' }}"
    });
&lt;/script&gt;</code></pre>

                        <button class="btn btn-outline-primary mt-3" id="copyCode">
                            <i class="bi bi-clipboard me-2"></i>Copy to Clipboard
                        </button>
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

        // Generate credentials buttons functionality
        document.querySelectorAll('.generate-credentials-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Reload the page to generate credentials
                window.location.reload();
            });
        });

        // Copy Integration Code
        document.getElementById('copyCode').addEventListener('click', function() {
            const codeBlock = document.querySelector('pre code');
            const textArea = document.createElement('textarea');
            textArea.value = codeBlock.textContent;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);

            // Show feedback
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="bi bi-check-circle me-2"></i>Copied!';
            setTimeout(() => {
                this.innerHTML = originalText;
            }, 2000);
        });
    });
</script>
@endsection
