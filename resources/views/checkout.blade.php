<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Meta Tag -->
    <title>Secure Checkout - Easypay</title>
    <meta name="title" content="Secure Checkout - Easypay">
    <link rel="icon" href="https://via.placeholder.com/16x16/4361ee/ffffff?text=EP">

    <!-- Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Secure Checkout - Easypay">
    <meta property="og:description" content="Secure payment processing with Bkash and Nagad">
    <meta property="og:image" content="https://via.placeholder.com/1200x630/4361ee/ffffff?text=Easypay">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="Secure Checkout - Easypay">
    <meta property="twitter:description" content="Secure payment processing with Bkash and Nagad">
    <meta property="twitter:image" content="https://via.placeholder.com/1200x600/4361ee/ffffff?text=Easypay">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style type="text/css">
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(350deg, #f4f9ff, #edf4ffc9), url('https://via.placeholder.com/1920x1080/f4f9ff/edf4ffc9') fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }

        .checkout-container {
            max-width: 650px;
            width: 100%;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .nav-header {
            height: 60px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            background: #fbfcff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #4361ee;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .cancel-btn {
            background: none;
            border: none;
            color: #6D7F9A;
            font-size: 24px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .cancel-btn:hover {
            color: #ff6b6b;
            transform: rotate(90deg);
        }

        .merchant-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 20px;
        }

        .merchant-logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #4361ee;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
        }

        .merchant-name {
            font-size: 22px;
            font-weight: 600;
            color: #6D7F9A;
            margin-bottom: 10px;
        }

        .order-summary {
            background: #f8f9ff;
            border-radius: 12px;
            padding: 25px;
            margin: 0 20px 25px;
        }

        .summary-title {
            font-size: 18px;
            font-weight: 600;
            color: #4361ee;
            margin-bottom: 20px;
            text-align: center;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .item-label {
            color: #6D7F9A;
            font-weight: 500;
        }

        .item-value {
            font-weight: 600;
            color: #333;
        }

        .total-amount {
            border-top: 1px dashed #ddd;
            padding-top: 15px;
            margin-top: 10px;
        }

        .total-label {
            font-size: 18px;
            font-weight: 700;
            color: #4361ee;
        }

        .total-value {
            font-size: 22px;
            font-weight: 800;
            color: #4361ee;
        }

        .payment-methods {
            padding: 0 20px 30px;
        }

        .methods-title {
            font-size: 18px;
            font-weight: 600;
            color: #4361ee;
            margin-bottom: 20px;
            text-align: center;
        }

        .payment-option {
            background: white;
            border: 2px solid #eef2f7;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .payment-option:hover {
            border-color: #4361ee;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.15);
            text-decoration: none;
            color: inherit;
        }

        .payment-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .payment-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background: #f0f4ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 24px;
            color: #4361ee;
        }

        .payment-name {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .payment-logo {
            height: 30px;
            width: auto;
            margin-right: 15px;
        }

        .payment-desc {
            color: #6D7F9A;
            font-size: 14px;
            margin-bottom: 0;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #6D7F9A;
            font-size: 14px;
            border-top: 1px solid #eee;
        }

        .secure-badge {
            display: inline-flex;
            align-items: center;
            background: #e8f3ff;
            color: #4361ee;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            margin-top: 10px;
        }

        .secure-badge i {
            margin-right: 5px;
            font-size: 16px;
        }

        @media (max-width: 576px) {
            .checkout-container {
                border-radius: 12px;
                margin: 0 10px;
            }

            body {
                padding: 10px 0;
            }

            .merchant-info {
                padding: 20px 15px;
            }

            .order-summary {
                margin: 0 15px 20px;
                padding: 20px;
            }

            .payment-methods {
                padding: 0 15px 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Full Design -->
    <div class="checkout-container">
        <!-- Nav -->
        <div class="nav-header">
            <div class="logo">EP</div>
            <div class="d-flex align-items-center">
                <button class="cancel-btn" id="cancelButton" data-cancel-url="{{ url('/') }}">
                    <i class="bx bx-x"></i>
                </button>
            </div>
        </div>
        <!--END Nav -->

        <!-- Profile -->
        <div class="merchant-info text-center mb-4">
            @if(!empty($order['merchant_logo']))
                <img src="{{ $order['merchant_logo'] }}" alt="{{ $order['merchant'] }}" class="merchant-logo-img mb-3" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
            @else
                <div class="merchant-logo mx-auto mb-3">{{ substr($order['merchant'], 0, 2) }}</div>
            @endif
            <h3 class="merchant-name">{{ $order['merchant'] }}</h3>
            <div class="secure-badge mx-auto">
                <i class="bx bx-lock-alt"></i> Secure Payment
            </div>
        </div>
        <!--END Profile -->

        <!-- Order Summary -->
        <div class="order-summary">
            <h4 class="summary-title">Order Summary</h4>
            <div class="summary-item">
                <span class="item-label">Product</span>
                <span class="item-value">{{ $order['product'] ?? 'Premium Package' }}</span>
            </div>
            <div class="summary-item total-amount">
                <span class="total-label">Total Amount</span>
                <span class="total-value">৳ {{ number_format($order['subtotal'] ?? 500.00, 0) }}</span>
            </div>
        </div>
        <!--END Order Summary -->

        <!-- Payment Methods -->
        <div class="payment-methods">
            <h4 class="methods-title">Select Payment Method</h4>

            <!-- Bkash -->
            <a href="{{ route('payment.bkash') }}" class="payment-option">
                <div class="payment-header">
                    <img src="{{ asset('image/BKash-bKash-Logo.wine.svg') }}" alt="Bkash" class="payment-logo">
                    <div>
                        <h5 class="payment-name">Bkash</h5>
                        <p class="payment-desc">Pay with your Bkash mobile wallet</p>
                    </div>
                </div>
            </a>

            <!-- Nagad -->
            <a href="{{ route('payment.nagad') }}" class="payment-option">
                <div class="payment-header">
                    <img src="{{ asset('image/Nagad-Logo.wine.svg') }}" alt="Nagad" class="payment-logo">
                    <div>
                        <h5 class="payment-name">Nagad</h5>
                        <p class="payment-desc">Pay with your Nagad mobile wallet</p>
                    </div>
                </div>
            </a>
        </div>
        <!--END Payment Methods -->

        <!-- Footer -->
        <div class="footer">
            <p>Powered by Easypay | Secure Payment Gateway</p>
        </div>
        <!--END Footer -->
    </div>
    <!--END Full Design -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cancelButton = document.getElementById('cancelButton');

            // Cancel button
            cancelButton.addEventListener('click', function() {
                if (confirm('Are you sure you want to cancel this payment?')) {
                    // Redirect to merchant's cancel URL or home page if not set
                    const cancelUrl = this.getAttribute('data-cancel-url');
                    window.location.href = cancelUrl;
                }
            });
        });
    </script>
</body>

</html>
