<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easypay Integration Demo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .demo-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            color: #4361ee;
            font-weight: 700;
        }

        .product-card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .product-image {
            height: 200px;
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: 600;
        }

        .product-info {
            padding: 20px;
        }

        .price {
            font-size: 28px;
            font-weight: 700;
            color: #4361ee;
        }

        .integration-section {
            background: #f0f4ff;
            border-radius: 10px;
            padding: 25px;
            margin: 30px 0;
        }

        .code-block {
            background: #2d2d2d;
            color: #f8f8f2;
            border-radius: 8px;
            padding: 20px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            overflow-x: auto;
            margin: 20px 0;
        }

        .btn-pay {
            background: #4361ee;
            border: none;
            padding: 12px 30px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-pay:hover {
            background: #3a56e4;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
        }
    </style>
</head>
<body>
    <div class="demo-container">
        <div class="header">
            <h1>Easypay Integration Demo</h1>
            <p class="text-muted">See how easy it is to integrate Easypay into your website</p>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="product-card">
                    <div class="product-image">
                        PREMIUM PACKAGE
                    </div>
                    <div class="product-info">
                        <h3>Premium Website Package</h3>
                        <p class="text-muted">Complete website solution with hosting and support</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="price">৳ 510.00</div>
                                <small class="text-muted">incl. VAT</small>
                            </div>
                            <button class="btn-pay" id="payButton">
                                Pay Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="integration-section">
                    <h4>How to Integrate</h4>
                    <p>Add this code to your website:</p>

                    <div class="code-block">
                        &lt;!-- Easypay SDK --&gt;<br>
                        &lt;script src="/js/easypay-sdk.js"&gt;&lt;/script&gt;<br><br>

                        &lt;!-- Payment Button --&gt;<br>
                        &lt;button id="payButton"&gt;Pay Now&lt;/button&gt;<br><br>

                        &lt;!-- Initialize Easypay --&gt;<br>
                        &lt;script&gt;<br>
                        &nbsp;&nbsp;const easypay = new Easypay();<br>
                        &nbsp;&nbsp;document.getElementById('payButton').onclick = function() {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;easypay.createPayment({<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;amount: 510.00,<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;method: 'bkash',<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;description: 'Premium Package'<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;}).then(data => {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if (data.success) {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;window.location.href = data.data.redirect_url;<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;});<br>
                        &nbsp;&nbsp;};<br>
                        &lt;/script&gt;
                    </div>

                    <a href="{{ route('docs.integration') }}" class="btn btn-primary w-100">
                        <i class="bi bi-book me-2"></i>View Full Documentation
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Easypay SDK -->
    <script src="{{ asset('js/easypay-sdk.js') }}"></script>

    <!-- Demo Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const easypay = new Easypay();

            document.getElementById('payButton').addEventListener('click', function() {
                // Show processing state
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
                this.disabled = true;

                // Create payment
                easypay.createPayment({
                    amount: 510.00,
                    method: 'bkash',
                    description: 'Premium Package'
                }).then(data => {
                    if (data.success) {
                        // In a real implementation, you would redirect to the payment gateway
                        alert('Payment would redirect to: ' + data.data.redirect_url);
                        // window.location.href = data.data.redirect_url;
                    } else {
                        throw new Error(data.message || 'Payment failed');
                    }
                }).catch(error => {
                    alert('Payment failed: ' + error.message);
                }).finally(() => {
                    // Reset button
                    this.innerHTML = originalText;
                    this.disabled = false;
                });
            });
        });
    </script>
</body>
</html>
