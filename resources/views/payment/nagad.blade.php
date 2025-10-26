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
    <meta name="description" content="Secure Nagad payment processing">

    <!-- Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Secure Checkout - Easypay">
    <meta property="og:description" content="Secure Nagad payment processing">
    <meta property="og:image" content="https://via.placeholder.com/1200x630/4361ee/ffffff?text=Easypay">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="Secure Checkout - Easypay">
    <meta property="twitter:description" content="Secure Nagad payment processing">
    <meta property="twitter:image" content="https://via.placeholder.com/1200x600/4361ee/ffffff?text=Easypay">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Baloo+Da+2:wght@400;500;600;700;800&family=Inter:wght@100;200;300;400&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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

        .font-bangla {
            font-family: 'Baloo Da 2', cursive;
        }

        /* Nagad */
        .brand-bg {
            --tw-bg-opacity: 1;
            background-color: rgb(201 0 8 / var(--tw-bg-opacity));
        }

        .brand-hr {
            --tw-border-opacity: 1;
            border-color: rgb(175 0 7 / var(--tw-border-opacity));
        }

        .brand-btn {
            --tw-bg-opacity: 1;
            background-color: rgb(201 0 8 / var(--tw-bg-opacity));
        }

        .brand-btn:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(236 28 36 / var(--tw-bg-opacity));
        }

        .up-container {
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
            padding: 20px;
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

        .invoice-info {
            text-align: center;
        }

        .invoice-label {
            color: #94a9c7;
            font-size: 14px;
        }

        .invoice-id {
            color: #6D7F9A;
            font-size: 14px;
            word-break: break-all;
        }

        .amount-box {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }

        .amount-value {
            font-size: 32px;
            font-weight: 700;
            color: #6D7F9A;
        }

        .transaction-form {
            background: #f8f9ff;
            border-radius: 12px;
            padding: 25px;
            margin: 20px;
        }

        .form-title {
            text-align: center;
            margin-bottom: 20px;
            color: white;
            font-weight: 600;
        }

        .form-control-custom {
            appearance: none;
            width: 100%;
            font-size: 15px;
            border-radius: 10px;
            background: #fbfcff;
            box-shadow: 0 2px 5px rgba(0, 87, 208, 0.05);
            padding: 15px;
            color: #333;
            border: 1px solid #e1e5eb;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: #4361ee;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .instructions {
            margin-top: 20px;
            padding: 0 15px;
        }

        .instruction-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .bullet {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            margin-right: 10px;
            margin-top: 6px;
        }

        .instruction-text {
            color: #e1e5eb;
            font-size: 14px;
            line-height: 1.5;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: #c90008;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .submit-btn:hover {
            background: #ec1c24;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(201, 0, 8, 0.3);
        }

        @media (max-width: 576px) {
            .up-container {
                border-radius: 12px;
                margin: 0 10px;
            }

            body {
                padding: 10px 0;
            }

            .merchant-info {
                padding: 15px;
            }

            .transaction-form {
                margin: 15px;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Full Design -->
    <div class="up-container">
        <!-- nav -->
        <div class="nav-header">
            <div class="">
                <a href="{{ url('/checkout') }}">
                    <svg width="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.5 1C4.80558 1 1 4.80558 1 9.5C1 14.1944 4.80558 18 9.5 18C14.1944 18 18 14.1944 18 9.5C18 4.80558 14.1944 1 9.5 1Z" stroke="#6D7F9A" stroke-width="1.5"></path>
                        <path d="M10.7749 12.9L7.3749 9.50002L10.7749 6.10002" stroke="#94A9C7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </a>
            </div>
            <div class="d-flex align-items-center">
                <button class="cancel-btn" id="cancelButton" data-cancel-url="{{ $paymentData['order']['cancel_url'] ?? url('/') }}">
                    <svg width="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 1L1 13" stroke="#94A9C7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M1 1L13 13" stroke="#6D7F9A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
            </div>
        </div>
        <!--END nav -->

        <!-- Nagad Transaction -->
        <div class="w-100">
            <!-- First Row: Nagad Logo -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="bg-white shadow rounded-lg p-4 d-flex justify-content-center align-items-center" style="min-height: 120px;">
                        <img src="{{ asset('image/Nagad-Logo.wine.svg') }}" alt="Nagad Logo" style="height: 80px; width: auto;">
                    </div>
                </div>
            </div>

            <!-- Second Row: Website Name/Logo and Payment Info -->
            <div class="row">
                <div class="col-12">
                    <div class="bg-white shadow rounded-lg p-4">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                            <!-- Website Name and Logo -->
                            <div class="d-flex align-items-center mb-3 mb-md-0">
                                <div class="merchant-logo-container me-3">
                                    @if(!empty($paymentData['merchant_logo']))
                                        <img src="{{ $paymentData['merchant_logo'] }}" alt="{{ $paymentData['merchant'] }}" class="merchant-logo-img" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                                    @else
                                        <div class="merchant-logo-placeholder" style="width: 60px; height: 60px; border-radius: 50%; background: #4361ee; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 20px;">
                                            {{ substr($paymentData['merchant'], 0, 2) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="merchant-details">
                                    <h3 class="merchant-name fw-semibold text-[#6D7F9A] mb-0">{{ $paymentData['merchant'] }}</h3>
                                </div>
                            </div>

                            <!-- Payment Information on Right Side -->
                            <div class="payment-info text-md-end">
                                <div class="mb-1">
                                    <span class="text-[#94a9c7] font-bangla">টাকার পরিমাণঃ</span>
                                    <span class="text-[#6D7F9A] fw-bold"> ৳ {{ number_format($paymentData['order']['subtotal'], 0) }}</span>
                                </div>
                                <div class="mb-1">
                                    <span class="text-[#94a9c7] font-bangla">প্রসেসিং ফি ({{ $paymentData['gateway']['fees'] ?? '1.5%' }})ঃ</span>
                                    <span class="text-[#6D7F9A] fw-bold"> ৳ {{ number_format($paymentData['order']['processing_fee'], 0) }}</span>
                                </div>
                                <div>
                                    <span class="text-[#94a9c7] font-bangla">মোট টাকাঃ</span>
                                    <span class="text-[#6D7F9A] fw-bold"> ৳ {{ number_format($paymentData['amount'], 0) }}</span>
                                </div>
                                <div>
                                    <span class="text-[#94a9c7] font-bangla">ইনভয়েস আইডিঃ</span>
                                    <span class="text-[#6D7F9A] select-all"> {{ $paymentData['invoice_id'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('checkout.process') }}" class="actionForm" method="post">
                @csrf
                <input type="hidden" name="payment_id" value="5f6727b97c8d5c94afb77aa10f5403f7f4f0224b" />
                <input type="hidden" name="payment_method" value="nagad" />
                <input type="hidden" name="payment_method_id" value="7" />
                <input type="hidden" name="order_id" value="{{ $paymentData['order']['id'] }}" />

                <!-- Transaction Id -->
                <div class="brand-bg p-4 mt-3 rounded-lg">
                    <div class="text-center mt-3">
                        <h2 class="mb-3 fw-semibold text-white font-bangla">ট্রান্সজেকশন আইডি দিন</h2>
                        <input type="text" name="transaction_id" placeholder="ট্রান্সজেকশন আইডি দিন" class="font-bangla form-control-custom" maxlength="8" required>
                    </div>

                    <div class="instructions">
                        <ul class="mt-4 text-slate-200 ps-3 mb-0">
                            <li class="d-flex text-sm mb-3">
                                <div><span class="bullet"></span></div>
                                <p class="instruction-text font-bangla ms-2 mb-0"><strong style="font-size: 1.1em; font-weight: 600;">*167#</strong> ডায়াল করে আপনার <strong style="font-size: 1.1em; font-weight: 600;">NAGAD</strong> মোবাইল মেনুতে যান অথবা <strong style="font-size: 1.1em; font-weight: 600;">NAGAD</strong> অ্যাপে যান।</p>
                            </li>
                            <hr class="brand-hr my-3">
                            <li class="d-flex text-sm mb-3">
                                <div><span class="bullet"></span></div>
                                <p class="instruction-text font-bangla ms-2 mb-0">"<strong style="font-size: 1.1em; font-weight: 600;">Send Money</strong>" -এ ক্লিক করুন।</p>
                            </li>
                            <hr class="brand-hr my-3">
                            <li class="d-flex text-sm mb-3">
                                <div><span class="bullet"></span></div>
                                <p class="instruction-text font-bangla ms-2 mb-0"><strong style="font-size: 1.1em; font-weight: 600;">প্রাপক নম্বর</strong> হিসেবে এই নম্বরটি লিখুনঃ <strong style="font-size: 1.2em; color: #C90008; background-color: #ffffff; padding: 2px 5px; border-radius: 3px;">{{ $paymentData['recipient_number'] }}</strong> <button class="btn btn-sm btn-light copy-btn ms-2" data-copy="{{ $paymentData['recipient_number'] }}" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">Copy</button></p>
                            </li>
                            <hr class="brand-hr my-3">
                            <li class="d-flex text-sm mb-3">
                                <div><span class="bullet"></span></div>
                                <p class="instruction-text font-bangla ms-2 mb-0"><strong style="font-size: 1.1em; font-weight: 600;">টাকার পরিমাণঃ</strong> <strong style="font-size: 1.2em; color: #C90008; background-color: #ffffff; padding: 2px 5px; border-radius: 3px;">৳ {{ number_format($paymentData['amount'], 0) }}</strong></p>
                            </li>
                            <hr class="brand-hr my-3">
                            <li class="d-flex text-sm mb-3">
                                <div><span class="bullet"></span></div>
                                <p class="instruction-text font-bangla ms-2 mb-0">নিশ্চিত করতে এখন আপনার <strong style="font-size: 1.1em; font-weight: 600;">NAGAD</strong> মোবাইল মেনু <strong style="font-size: 1.1em; font-weight: 600;">পিন</strong> লিখুন।</p>
                            </li>
                            <hr class="brand-hr my-3">
                            <li class="d-flex text-sm mb-3">
                                <div><span class="bullet"></span></div>
                                <p class="instruction-text font-bangla ms-2 mb-0">সবকিছু ঠিক থাকলে, আপনি <strong style="font-size: 1.1em; font-weight: 600;">NAGAD</strong> থেকে একটি <strong style="font-size: 1.1em; font-weight: 600;">নিশ্চিতকরণ বার্তা</strong> পাবেন।</p>
                            </li>
                            <hr class="brand-hr my-3">
                            <li class="d-flex text-sm mb-3">
                                <div><span class="bullet"></span></div>
                                <p class="instruction-text font-bangla ms-2 mb-0">এখন উপরের বক্সে আপনার <strong style="font-size: 1.1em; font-weight: 600;">Transaction ID</strong> দিন এবং নিচের <strong style="font-size: 1.1em; font-weight: 600;">VERIFY</strong> বাটনে ক্লিক করুন।</p>
                            </li>
                        </ul>
                    </div>

                    <button type="submit" class="submit-btn" style="background-color: #fff; color: #ec1c24; border: 2px solid #ec1c24;">
                        <i class="bx bx-check-circle me-2"></i> ভেরিফাই করুন
                    </button>
                </div>
            </form>
        </div>
        <!--END Nagad Transaction -->
    </div>
    <!--END Full Design -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Copy button functionality
            document.querySelectorAll('.copy-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const textToCopy = this.getAttribute('data-copy');
                    navigator.clipboard.writeText(textToCopy).then(() => {
                        // Show feedback
                        const originalText = this.textContent;
                        this.textContent = 'Copied!';
                        this.classList.remove('btn-light');
                        this.classList.add('btn-success');

                        // Reset button after 2 seconds
                        setTimeout(() => {
                            this.textContent = originalText;
                            this.classList.remove('btn-success');
                            this.classList.add('btn-light');
                        }, 2000);
                    }).catch(err => {
                        console.error('Failed to copy: ', err);
                    });
                });
            });

            // Cancel button functionality
            document.getElementById('cancelButton').addEventListener('click', function() {
                if (confirm('Are you sure you want to cancel this payment?')) {
                    // Redirect to merchant's cancel URL or home page if not set
                    const cancelUrl = this.getAttribute('data-cancel-url');
                    window.location.href = cancelUrl;
                }
            });

            // Language toggle functionality removed as requested
        });
    </script>
</body>

</html>
