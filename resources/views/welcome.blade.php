<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Easypay - Simple Payment Gateway</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
            html {
                line-height: 1.15;
                -webkit-text-size-adjust: 100%;
            }
            body {
                margin: 0;
                font-family: 'Poppins', sans-serif;
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }
            .header {
                text-align: center;
                margin-bottom: 50px;
            }
            .header h1 {
                font-size: 3rem;
                font-weight: 700;
                color: #4361ee;
                margin-bottom: 20px;
            }
            .header p {
                font-size: 1.2rem;
                color: #6c757d;
                max-width: 700px;
                margin: 0 auto;
            }
            .features {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 30px;
                margin-bottom: 50px;
            }
            .feature-card {
                background: white;
                border-radius: 15px;
                padding: 30px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                text-align: center;
            }
            .feature-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 15px 40px rgba(0,0,0,0.15);
            }
            .feature-icon {
                width: 80px;
                height: 80px;
                background: #4361ee;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 20px;
                color: white;
                font-size: 2rem;
            }
            .feature-card h3 {
                font-size: 1.5rem;
                margin-bottom: 15px;
                color: #343a40;
            }
            .feature-card p {
                color: #6c757d;
                line-height: 1.6;
            }
            .cta-section {
                text-align: center;
                background: white;
                border-radius: 15px;
                padding: 50px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            }
            .cta-section h2 {
                font-size: 2.5rem;
                color: #4361ee;
                margin-bottom: 20px;
            }
            .btn {
                display: inline-block;
                padding: 15px 30px;
                background: #4361ee;
                color: white;
                text-decoration: none;
                border-radius: 50px;
                font-weight: 600;
                font-size: 1.1rem;
                transition: all 0.3s ease;
                margin: 10px;
                border: none;
                cursor: pointer;
            }
            .btn:hover {
                background: #3a56e4;
                transform: translateY(-3px);
                box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
            }
            .btn-outline {
                background: transparent;
                border: 2px solid #4361ee;
                color: #4361ee;
            }
            .btn-outline:hover {
                background: #4361ee;
                color: white;
            }
            .footer {
                text-align: center;
                margin-top: 50px;
                color: #6c757d;
                font-size: 0.9rem;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Easypay Payment Gateway</h1>
                <p>Simple, secure, and reliable payment processing for your business</p>
            </div>

            <div class="features">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-lightning">⚡</i>
                    </div>
                    <h3>Lightning Fast</h3>
                    <p>Process payments in seconds with our optimized payment infrastructure</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-shield">🛡️</i>
                    </div>
                    <h3>Secure & Reliable</h3>
                    <p>Bank-level security with end-to-end encryption and fraud protection</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-phone">📱</i>
                    </div>
                    <h3>Mobile Payments</h3>
                    <p>Accept payments through bkash and Nagad mobile wallets</p>
                </div>
            </div>

            <div class="cta-section">
                <h2>Ready to Get Started?</h2>
                <p>Join thousands of businesses using Easypay to process payments</p>
                <div>
                    <a href="{{ route('login') }}" class="btn">Login to Dashboard</a>
                    <a href="{{ route('signup') }}" class="btn btn-outline">Create Account</a>
                </div>
                <div style="margin-top: 30px;">
                    <a href="{{ route('checkout') }}" class="btn btn-outline">View Checkout Page</a>
                    <a href="{{ route('integration.demo') }}" class="btn btn-outline">Integration Demo</a>
                </div>
            </div>

            <div class="footer">
                <p>© {{ date('Y') }} Easypay. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
