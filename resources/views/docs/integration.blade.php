@extends('layouts.app')

@section('title', 'Integration Guide - Easypay')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Easypay Integration Guide</h2>
                </div>
                <div class="card-body">
                    <p class="lead">Follow this guide to integrate Easypay payment gateway into your website or application.</p>

                    <hr>

                    <h3>1. API Authentication</h3>
                    <p>To use the Easypay API, you must include your API credentials in the request headers:</p>
                    <ul>
                        <li><strong>X-API-KEY</strong>: Your unique API key</li>
                        <li><strong>X-SECRET-KEY</strong>: Your secret key</li>
                    </ul>
                    <p>You can find these credentials in your <a href="{{ route('setup') }}">Merchant Setup</a> page.</p>

                    <h3>2. Create a Payment Request</h3>
                    <p>To initiate a payment, make a POST request to our API endpoint with the required data:</p>

                    <h5>Using JavaScript (Fetch API)</h5>
                    <pre><code class="language-javascript">const paymentData = {
    amount: 510.00,
    customer_name: 'John Doe',
    customer_email: 'john@example.com',
    callback_url: 'https://yourwebsite.com/payment-callback',
    description: 'Premium Package'
};

fetch('/api/payment/process', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-API-KEY': 'your_api_key_here',
        'X-SECRET-KEY': 'your_secret_key_here'
    },
    body: JSON.stringify(paymentData)
})
.then(response => response.json())
.then(data => {
    if (data.redirect_url) {
        // Redirect user to payment page
        window.location.href = data.redirect_url;
    }
})
.catch(error => {
    console.error('Payment request failed:', error);
});</code></pre>

                    <h5>Using JavaScript (Axios)</h5>
                    <pre><code class="language-javascript">const paymentData = {
    amount: 510.00,
    customer_name: 'John Doe',
    customer_email: 'john@example.com',
    callback_url: 'https://yourwebsite.com/payment-callback',
    description: 'Premium Package'
};

axios.post('/api/payment/process', paymentData, {
    headers: {
        'X-API-KEY': 'your_api_key_here',
        'X-SECRET-KEY': 'your_secret_key_here'
    }
})
.then(response => {
    if (response.data.redirect_url) {
        // Redirect user to payment page
        window.location.href = response.data.redirect_url;
    }
})
.catch(error => {
    console.error('Payment request failed:', error);
});</code></pre>

                    <h5>Using cURL</h5>
                    <pre><code class="language-bash">curl -X POST https://your-easypay-domain.com/api/payment/process \
  -H "Content-Type: application/json" \
  -H "X-API-KEY: your_api_key_here" \
  -H "X-SECRET-KEY: your_secret_key_here" \
  -d '{
    "amount": 510.00,
    "customer_name": "John Doe",
    "customer_email": "john@example.com",
    "callback_url": "https://yourwebsite.com/payment-callback",
    "description": "Premium Package"
  }'</code></pre>

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
                    <pre><code class="language-json">{
    "message": "Order created successfully. Redirecting to payment.",
    "order_id": "EP-a1b2c3d4e5",
    "redirect_url": "https://your-easypay-domain.com/checkout?order=EP-a1b2c3d4e5"
}</code></pre>

                    <h3>5. Callback/Webhook</h3>
                    <p>We will send a POST request to your callback_url when the payment status changes. For security, we include a signature in the X-Easypay-Signature header:</p>
                    <pre><code class="language-json">{
    "order_id": "EP-a1b2c3d4e5",
    "status": "completed",
    "amount": 510.00,
    "transaction_id": "TXN-1234567890",
    "timestamp": "2023-10-26T10:30:00.000000Z"
}</code></pre>

                    <h4>Webhook Signature Verification</h4>
                    <p>To verify that the callback is genuinely from Easypay, you should verify the signature:</p>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>JavaScript (Node.js) Example:</h5>
                            <pre><code class="language-javascript">const crypto = require('crypto');

function verifySignature(payload, signature, secretKey) {
    const payloadJson = JSON.stringify(payload);
    const expectedSignature = crypto
        .createHmac('sha256', secretKey)
        .update(payloadJson)
        .digest('hex');

    return crypto.timingSafeEqual(
        Buffer.from(signature, 'hex'),
        Buffer.from(expectedSignature, 'hex')
    );
}

// In your webhook handler
app.post('/webhook', (req, res) => {
    const signature = req.headers['x-easypay-signature'];
    const payload = req.body;

    if (!verifySignature(payload, signature, YOUR_SECRET_KEY)) {
        return res.status(401).send('Unauthorized');
    }

    // Process the webhook
    // ... your code here
});</code></pre>
                        </div>
                        <div class="col-md-6">
                            <h5>PHP Example:</h5>
                            <pre><code class="language-php">function verifySignature($payload, $signature, $secretKey) {
    $payloadJson = json_encode($payload);
    $expectedSignature = hash_hmac('sha256', $payloadJson, $secretKey);
    return hash_equals($expectedSignature, $signature);
}

// In your webhook handler
$signature = $_SERVER['HTTP_X_EASYPAY_SIGNATURE'] ?? '';
$payload = json_decode(file_get_contents('php://input'), true);

if (!verifySignature($payload, $signature, YOUR_SECRET_KEY)) {
    http_response_code(401);
    echo 'Unauthorized';
    exit;
}

// Process the webhook
// ... your code here</code></pre>
                        </div>
                    </div>

                    <h3>6. Error Handling</h3>
                    <p>In case of errors, the API will return appropriate HTTP status codes and error messages:</p>
                    <pre><code class="language-json">{
    "error": "API keys are missing."
}</code></pre>

                    <pre><code class="language-json">{
    "error": "Invalid API credentials."
}</code></pre>

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
                        <h5><i class="bx bx-info-circle"></i> Important Notes</h5>
                        <ul class="mb-0">
                            <li>Always keep your API credentials secure and never expose them in client-side code</li>
                            <li>Validate all incoming webhook requests to ensure they're from Easypay</li>
                            <li>Always verify the X-Easypay-Signature header to ensure the webhook is genuine</li>
                            <li>Handle both successful and failed payment scenarios in your callback handler</li>
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
        document.querySelectorAll('pre code').forEach((block) => {
            // In a real implementation, you would use a library like Prism.js or Highlight.js
            block.classList.add('bg-light', 'p-3', 'rounded');
        });
    });
</script>
@endsection
