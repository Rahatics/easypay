@extends('layouts.app')

@section('title', 'Setup - Easypay')

@section('styles')
<style>
    .config-section {
        padding: 1.5rem;
        border-radius: 10px;
        background: #f8f9fa;
        margin-bottom: 1.5rem;
        border: 1px solid #e9ecef;
    }

    .config-section h5 {
        color: #495057;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #dee2e6;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border: 1px solid #ced4da;
        padding: 0.75rem 1rem;
        background: #fff;
        border-radius: 8px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        outline: 0;
    }

    .form-control-file {
        border: 1px solid #ced4da;
        padding: 0.75rem 1rem;
        background: #fff;
        border-radius: 8px;
    }

    .input-group {
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        border-radius: 8px;
        overflow: hidden;
    }

    .input-group .form-control {
        border: none;
        border-radius: 0;
    }

    .input-group:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
    }

    .btn-outline-primary {
        border: none;
        background: #e9ecef;
        color: #495057;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background: #4361ee;
        color: white;
    }

    .generate-btn {
        border: none;
        padding: 0.75rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border-radius: 8px;
    }

    .credential-field {
        background: #e8f3ff !important;
        font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
        font-size: 0.85rem;
    }

    .logo-preview {
        max-width: 120px;
        max-height: 120px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .instructions-card {
        height: 100%;
    }

    .instructions-card .list-group-item {
        border: none;
        padding: 1rem 0.75rem;
        border-bottom: 1px solid #e9ecef;
    }

    .instructions-card .list-group-item:last-child {
        border-bottom: none;
    }

    .instructions-card h6 {
        color: #4361ee;
        font-weight: 600;
    }

    .code-block {
        margin-bottom: 1.5rem;
        overflow-x: auto;
    }

    .code-block pre {
        margin-bottom: 0;
        border-radius: 8px;
        font-size: 0.9rem;
        line-height: 1.4;
        overflow-x: auto;
    }

    .code-block code {
        font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
        white-space: pre;
    }

    .credential-copy-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
    }

    .code-container {
        position: relative;
    }

    .alert-info {
        background: #e8f3ff;
        border: 1px solid #d1e2ff;
        border-radius: 8px;
    }

    .alert-info h6 {
        color: #4361ee;
    }
</style>
@endsection

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
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-gear me-2"></i>Merchant Configuration</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('setup.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="website_name" class="form-label">Website Name</label>
                                <input type="text" class="form-control" id="website_name" name="website_name" value="{{ old('website_name', $setupData['website_name'] ?? '') }}" placeholder="Enter your website name" required>
                                @error('website_name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="website_logo" class="form-label">Website Logo</label>
                                <input type="file" class="form-control" id="website_logo" name="website_logo" accept="image/*">
                                @error('website_logo')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror

                                @if(!empty($setupData['website_logo']))
                                    <div class="mt-3 text-center">
                                        <img src="{{ asset($setupData['website_logo']) }}" alt="Current Logo" class="logo-preview">
                                        <p class="text-muted small mt-2">Current logo</p>
                                    </div>
                                @endif
                            </div>

                            <div class="config-section">
                                <h5><i class="bi bi-key me-2"></i>API Credentials</h5>

                                <div class="form-group">
                                    <label for="api_key" class="form-label">API Key</label>
                                    <div class="input-group">
                                        @if(!empty($setupData['api_key']))
                                            <input type="text" class="form-control credential-field" id="api_key" name="api_key" value="{{ old('api_key', $setupData['api_key'] ?? '') }}" readonly>
                                            <button class="btn btn-outline-primary credential-copy-btn" type="button" data-target="api_key">
                                                <i class="bi bi-clipboard"></i> Copy
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-primary generate-btn w-100 generate-credentials-btn" id="generateApiKey">
                                                <i class="bi bi-key me-2"></i> Generate API Key
                                            </button>
                                        @endif
                                    </div>
                                    @error('api_key')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="secret_key" class="form-label">Secret Key</label>
                                    <div class="input-group">
                                        @if(!empty($setupData['secret_key']))
                                            <input type="text" class="form-control credential-field" id="secret_key" name="secret_key" value="{{ old('secret_key', $setupData['secret_key'] ?? '') }}" readonly>
                                            <button class="btn btn-outline-primary credential-copy-btn" type="button" data-target="secret_key">
                                                <i class="bi bi-clipboard"></i> Copy
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-primary generate-btn w-100 generate-credentials-btn" id="generateSecretKey">
                                                <i class="bi bi-shield-lock me-2"></i> Generate Secret Key
                                            </button>
                                        @endif
                                    </div>
                                    @error('secret_key')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="merchant_id" class="form-label">Merchant ID</label>
                                    <div class="input-group">
                                        @if(!empty($setupData['merchant_id']))
                                            <input type="text" class="form-control credential-field" id="merchant_id" name="merchant_id" value="{{ old('merchant_id', $setupData['merchant_id'] ?? '') }}" readonly>
                                            <button class="btn btn-outline-primary credential-copy-btn" type="button" data-target="merchant_id">
                                                <i class="bi bi-clipboard"></i> Copy
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-primary generate-btn w-100 generate-credentials-btn" id="generateMerchantId">
                                                <i class="bi bi-person-badge me-2"></i> Generate Merchant ID
                                            </button>
                                        @endif
                                    </div>
                                    @error('merchant_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3">
                                <i class="bi bi-save me-2"></i> Save Configuration
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card instructions-card h-100">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Setup Instructions</h5>
                    </div>
                    <div class="card-body">
                        <ol class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h6 class="mb-1">Website Name</h6>
                                <p class="mb-0 text-muted small">Enter the name of your website or business. This will appear on payment pages.</p>
                            </li>
                            <li class="list-group-item">
                                <h6 class="mb-1">Website Logo</h6>
                                <p class="mb-0 text-muted small">Upload your website logo (optional). This will appear on payment pages for brand recognition.</p>
                            </li>
                            <li class="list-group-item">
                                <h6 class="mb-1">API Credentials</h6>
                                <p class="mb-0 text-muted small">These are your unique API credentials. Generate them if needed and copy them for integration.</p>
                            </li>
                        </ol>

                        <div class="alert alert-info mt-4">
                            <h6 class="alert-heading"><i class="bi bi-shield-lock me-2"></i>Security Notice</h6>
                            <p class="mb-0 small">Keep your API credentials secure. Never share your Secret Key publicly or expose it in client-side code.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-download me-2"></i>Download Very Easy Step by Step Integration Guide</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-4">Get started quickly with our comprehensive integration guide. Download the PDF version for offline reference.</p>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 3rem;"></i>
                                        </div>
                                        <h5 class="card-title">Easypay Integration Guide</h5>
                                        <p class="card-text text-muted">Complete step-by-step guide for integrating Easypay with your website or application.</p>
                                        <a href="{{ route('setup.download.guide') }}" class="btn btn-primary" download>
                                            <i class="bi bi-download me-2"></i>Download PDF Guide
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="bi bi-code-square text-success" style="font-size: 3rem;"></i>
                                        </div>
                                        <h5 class="card-title">Sample Code Package</h5>
                                        <p class="card-text text-muted">Download ready-to-use code samples for quick integration.</p>
                                        <a href="{{ route('setup.download.code') }}" class="btn btn-success" download>
                                            <i class="bi bi-download me-2"></i>Download Code Samples
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <h6><i class="bi bi-info-circle me-2"></i>Need Help?</h6>
                            <p class="mb-0">If you need assistance with integration, please contact our support team at <a href="mailto:support@easypay.com">support@easypay.com</a> or call us at +880 XXX XXX XXX.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-code-slash me-2"></i>Server-to-Server Integration</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">For secure integration, use the server-to-server approach. Store your credentials in your environment configuration:</p>

                        <div class="code-container">
                            <div class="code-block">
                                <pre class="bg-dark text-light p-4 rounded"><code>/* Add to your .env file */
EASYPAY_KEY={{ $setupData['api_key'] ?? 'your_api_key_here' }}
EASYPAY_SECRET={{ $setupData['secret_key'] ?? 'your_secret_key_here' }}

/* Add to your config/services.php */
'easypay' => [
    'key' => env('EASYPAY_KEY'),
    'secret' => env('EASYPAY_SECRET'),
],</code></pre>
                            </div>
                        </div>

                        <p class="mt-4 mb-3">Then create a controller method to initiate payments:</p>

                        <div class="code-container">
                            <div class="code-block">
                                <pre class="bg-dark text-light p-4 rounded"><code>&lt;?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EasypayController extends Controller
{
    public function initiatePayment(Request $request)
    {
        $apiKey = config('services.easypay.key');
        $secretKey = config('services.easypay.secret');

        $response = Http::withHeaders([
            'X-API-KEY' => $apiKey,
            'X-SECRET-KEY' => $secretKey,
        ])->post('https://your-easypay-domain.com/api/payment/process', [
            'amount' => $request->amount,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'callback_url' => url('/easypay/callback'),
            'description' => $request->product_name,
        ]);

        if ($response->successful() && isset($response->json()['redirect_url'])) {
            return redirect($response->json()['redirect_url']);
        }

        return back()->with('error', 'Payment initiation failed.');
    }
}</code></pre>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-4">
                            <h6><i class="bi bi-exclamation-triangle me-2"></i> Security Reminder</h6>
                            <p class="mb-0">Never expose your Secret Key in client-side code. Always use server-to-server communication for secure transactions.</p>
                        </div>
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
        // Copy buttons functionality for credentials
        document.querySelectorAll('.credential-copy-btn').forEach(button => {
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
    });
</script>
@endsection
