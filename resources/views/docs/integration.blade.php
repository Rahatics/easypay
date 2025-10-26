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

                    <h3>1. Include the SDK</h3>
                    <p>Add the Easypay SDK to your website by including the following script tag in your HTML:</p>
                    <pre><code class="language-html">&lt;script src="{{ asset('js/easypay-sdk.js') }}"&gt;&lt;/script&gt;</code></pre>

                    <h3>2. Initialize the SDK</h3>
                    <p>Initialize the Easypay SDK with your configuration:</p>
                    <pre><code class="language-javascript">const easypay = new Easypay({
    apiUrl: '/api/payment/process',
    currency: 'BDT'
});</code></pre>

                    <h3>3. Create a Payment Button</h3>
                    <p>Create a container element in your HTML where the payment button will be rendered:</p>
                    <pre><code class="language-html">&lt;div id="easypay-button-container"&gt;&lt;/div&gt;</code></pre>

                    <p>Then render the payment button using the SDK:</p>
                    <pre><code class="language-javascript">easypay.renderPaymentButton('easypay-button-container', {
    amount: 510.00,
    method: 'bkash', // or 'nagad'
    description: 'Premium Package'
}, {
    text: 'Pay with Bkash',
    className: 'btn btn-primary'
});</code></pre>

                    <h3>4. Manual Payment Creation</h3>
                    <p>You can also create payments manually:</p>
                    <pre><code class="language-javascript">easypay.createPayment({
    amount: 510.00,
    method: 'nagad',
    description: 'Premium Package'
}).then(paymentData => {
    if (paymentData.success) {
        // Redirect to payment gateway
        window.location.href = paymentData.data.redirect_url;
    }
}).catch(error => {
    console.error('Payment failed:', error);
});</code></pre>

                    <h3>5. Supported Payment Methods</h3>
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

                    <h3>6. API Endpoints</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Endpoint</th>
                                    <th>Method</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>/api/payment/process</code></td>
                                    <td>POST</td>
                                    <td>Process a payment request</td>
                                </tr>
                                <tr>
                                    <td><code>/api/payment/callback</code></td>
                                    <td>POST</td>
                                    <td>Handle payment callback from gateway</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>7. Example Implementation</h3>
                    <p>Here's a complete example of how to implement Easypay on your website:</p>
                    <pre><code class="language-html">&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;title&gt;Payment Page&lt;/title&gt;
    &lt;meta name="csrf-token" content="{{ csrf_token() }}"&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;h1&gt;Checkout&lt;/h1&gt;
    &lt;div id="easypay-button-container"&gt;&lt;/div&gt;

    &lt;script src="{{ asset('js/easypay-sdk.js') }}"&gt;&lt;/script&gt;
    &lt;script&gt;
        const easypay = new Easypay();

        easypay.renderPaymentButton('easypay-button-container', {
            amount: 510.00,
            method: 'bkash',
            description: 'Premium Package'
        });
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
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
