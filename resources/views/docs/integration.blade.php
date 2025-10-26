@extends('layouts.app')

@section('title', 'Integration Guide - Easypay')

@section('styles')
<style>
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

    .card-body h5 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    .card-body h3 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e9ecef;
    }

    .table-responsive {
        margin: 1rem 0;
    }

    .alert {
        margin: 1.5rem 0;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Easypay Integration Guide</h2>
                </div>
                <div class="card-body">
                    <p class="lead">Follow this guide to securely integrate Easypay payment gateway into your website or application.</p>

                    <div class="alert alert-warning">
                        <h5><i class="bx bx-error"></i> Security Notice</h5>
                        <p class="mb-0">Never expose your API credentials (especially Secret Key) in client-side code. Always use server-to-server communication for secure transactions.</p>
                    </div>

                    <hr>

                    <h3>1. API Authentication</h3>
                    <p>To use the Easypay API, you must include your API credentials in the request headers:</p>
                    <ul>
                        <li><strong>X-API-KEY</strong>: Your unique API key</li>
                        <li><strong>X-SECRET-KEY</strong>: Your secret key (Keep this secure!)</li>
                    </ul>
                    <p>You can find these credentials in your <a href="{{ route('setup') }}">Merchant Setup</a> page.</p>

                    <h3>2. Secure Server-to-Server Integration</h3>
                    <p class="mb-3">The recommended and secure way to integrate Easypay is through server-to-server communication. This approach keeps your secret credentials secure on your server.</p>

                    <h5>Step 1: Create a Route (routes/web.php)</h5>
                    <p>Merchant creates a route on their site to initiate payments:</p>
                    <div class="code-block">
                        <pre class="bg-dark text-light p-4 rounded"><code>Route::post('/easypay/initiate', [EasypayController::class, 'initiatePayment']);</code></pre>
                    </div>

                    <h5>Step 2: Create Controller (EasypayController.php)</h5>
                    <p>This controller securely communicates with your Easypay server:</p>
                    <div class="code-block">
                        <pre class="bg-dark text-light p-4 rounded"><code>&lt;?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EasypayController extends Controller
{
    public function initiatePayment(Request $request)
    {
        // These keys should come from your .env file
        $apiKey = config('services.easypay.key');
        $secretKey = config('services.easypay.secret');

        $response = Http::withHeaders([
            'X-API-KEY' => $apiKey,
            'X-SECRET-KEY' => $secretKey,
        ])->post('https://your-easypay-domain.com/api/payment/process', [
            'amount' => $request->amount,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'callback_url' => url('/easypay/callback'), // Your callback endpoint
            'description' => $request->product_name,
        ]);

        if ($response->successful() && isset($response->json()['redirect_url'])) {
            // Redirect customer to Easypay payment page
            return redirect($response->json()['redirect_url']);
        }

        return back()->with('error', 'Payment initiation failed.');
    }
}</code></pre>
                    </div>

                    <h5>Step 3: Add HTML Button on Merchant Site</h5>
                    <p>Customers only see this button. No secret keys are exposed:</p>
                    <div class="code-block">
                        <pre class="bg-dark text-light p-4 rounded"><code>&lt;form action="/easypay/initiate" method="POST"&gt;
    @csrf
    &lt;input type="hidden" name="amount" value="500"&gt;
    &lt;input type="hidden" name="product_name" value="Test Product"&gt;
    &lt;input type="hidden" name="customer_name" value="John Doe"&gt;
    &lt;input type="hidden" name="customer_email" value="john@example.com"&gt;

    &lt;button type="submit" class="btn btn-primary"&gt;Pay Now ৳500&lt;/button&gt;
&lt;/form&gt;</code></pre>
                    </div>

                    <h3>3. Required Parameters</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Parameter</th>
                                    <th>Type</th>
                                    <th>Required</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>amount</td>
                                    <td>number</td>
                                    <td>Yes</td>
                                    <td>The payment amount (minimum 10)</td>
                                </tr>
                                <tr>
                                    <td>customer_name</td>
                                    <td>string</td>
                                    <td>Yes</td>
                                    <td>Customer's full name</td>
                                </tr>
                                <tr>
                                    <td>customer_email</td>
                                    <td>string</td>
                                    <td>Yes</td>
                                    <td>Customer's email address</td>
                                </tr>
                                <tr>
                                    <td>callback_url</td>
                                    <td>string (URL)</td>
                                    <td>Yes</td>
                                    <td>URL where we'll send payment status updates</td>
                                </tr>
                                <tr>
                                    <td>description</td>
                                    <td>string</td>
                                    <td>No</td>
                                    <td>Description of the payment</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>4. API Response</h3>
                    <p>On successful payment creation, the API will return a JSON response:</p>
                    <div class="code-block">
                        <pre class="bg-dark text-light p-4 rounded"><code>{
    "message": "Order created successfully. Redirecting to payment.",
    "order_id": "EP-a1b2c3d4e5",
    "redirect_url": "https://your-easypay-domain.com/checkout?order=EP-a1b2c3d4e5"
}</code></pre>
                    </div>

                    <h3>5. Callback/Webhook Handling</h3>
                    <p>We will send a POST request to your callback_url when the payment status changes. Create a route to handle this:</p>
                    <div class="code-block">
                        <pre class="bg-dark text-light p-4 rounded"><code>Route::post('/easypay/callback', [EasypayController::class, 'handleCallback']);</code></pre>
                    </div>

                    <p>And implement the callback handler in your controller:</p>
                    <div class="code-block">
                        <pre class="bg-dark text-light p-4 rounded"><code>public function handleCallback(Request $request)
{
    // Verify the callback is from Easypay (optional but recommended)
    $signature = $request->header('X-Easypay-Signature');
    $secretKey = config('services.easypay.secret');

    // Verify signature if needed
    // ... verification logic ...

    // Process the payment status
    $orderId = $request->order_id;
    $status = $request->status;
    $transactionId = $request->transaction_id;

    // Update your database with the payment status
    // ... your logic here ...

    return response()->json(['status' => 'success']);
}</code></pre>
                    </div>

                    <h3>6. Error Handling</h3>
                    <p>In case of errors, the API will return appropriate HTTP status codes and error messages:</p>
                    <div class="code-block">
                        <pre class="bg-dark text-light p-4 rounded"><code>{
    "error": "API keys are missing."
}</code></pre>
                    </div>

                    <div class="code-block">
                        <pre class="bg-dark text-light p-4 rounded"><code>{
    "error": "Invalid API credentials."
}</code></pre>
                    </div>

                    <h3>7. Supported Payment Methods</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5><i class="bx bxl-bkash text-danger"></i> Bkash</h5>
                                    <p class="mb-0">Mobile financial service in Bangladesh</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5><i class="bx bx-mobile-alt text-primary"></i> Nagad</h5>
                                    <p class="mb-0">Government-backed mobile financial service</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <h5><i class="bx bx-info-circle"></i> Important Security Notes</h5>
                        <ul class="mb-0">
                            <li>Always store your API credentials in environment variables, never in code</li>
                            <li>Never expose your Secret Key in client-side code (JavaScript, HTML, etc.)</li>
                            <li>Always verify the X-Easypay-Signature header to ensure callbacks are genuine</li>
                            <li>Use HTTPS for all communication</li>
                            <li>Validate all incoming data before processing</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Simple syntax highlighting for code blocks
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.code-block').forEach((block) => {
            block.classList.add('mb-4');
        });
    });
</script>
@endsection
