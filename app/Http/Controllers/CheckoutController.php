<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GatewaysController;

class CheckoutController extends Controller
{
    /**
     * Get setup data from database or create initial data
     *
     * @return array
     */
    private function getSetupData()
    {
        // Check if setup data exists in database
        $setupRecord = \App\Models\SetupData::first();

        // If not, create initial setup data
        if (!$setupRecord) {
            $setupRecord = \App\Models\SetupData::create([
                'website_name' => 'My Website',
                'website_logo' => '',
                'api_key' => 'sk_' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 32),
                'secret_key' => 'ssk_' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 32),
                'merchant_id' => 'MID' . rand(100000, 999999)
            ]);
        }

        // Convert to array for compatibility
        return $setupRecord->toArray();
    }

    /**
     * Display the checkout page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get gateways data from session (in a real app, this would come from the database)
        $gateways = session('gateways_data', [
            [
                'id' => 1,
                'name' => 'bkash',
                'description' => 'bkash is a mobile financial service in Bangladesh that allows users to make payments, send money, and perform various financial transactions using their mobile phones.',
                'enabled' => true,
                'fees' => '1.8% per transaction',
                'account_number' => '01712345678'
            ],
            [
                'id' => 2,
                'name' => 'Nagad',
                'description' => 'Nagad is a government-backed mobile financial service in Bangladesh that provides digital payment solutions to unbanked and underbanked populations.',
                'enabled' => false,
                'fees' => '1.5% per transaction',
                'account_number' => ''
            ]
        ]);

        // Get setup data from file (in a real app, this would come from the database)
        $setupData = $this->getSetupData();

        // Sample order data (in a real app, this would come from the session or database)
        $subtotal = 498.00; // Changed from 500.00 to 498.00 so that with processing fee it rounds to 500

        // Calculate processing fee based on selected gateway (for demo, we'll use bkash)
        $selectedGateway = collect($gateways)->firstWhere('name', 'bkash');
        $processingFee = $selectedGateway ? GatewaysController::calculateProcessingFee($selectedGateway['fees'], $subtotal) : 0;

        $order = [
            'id' => 'ORD-'.strtoupper(uniqid()),
            'product' => 'Premium Package',
            'quantity' => 1,
            'subtotal' => $subtotal,
            'processing_fee' => $processingFee,
            'total' => $subtotal + $processingFee,
            'merchant' => $setupData['website_name'],
            'merchant_logo' => $setupData['website_logo'],
            'invoice_id' => 'INV-'.strtoupper(uniqid())
        ];

        return view('checkout', compact('order', 'gateways'));
    }

    /**
     * Show Bkash payment page
     *
     * @return \Illuminate\Http\Response
     */
    public function showBkashPage()
    {
        // Get setup data from file (in a real app, this would come from the database)
        $setupData = $this->getSetupData();

        // Sample gateway data (in a real app, this would come from the database)
        $gateways = session('gateways_data', [
            [
                'id' => 1,
                'name' => 'bkash',
                'account_number' => '01712345678',
                'fees' => '1.8% per transaction'
            ],
            [
                'id' => 2,
                'name' => 'Nagad',
                'account_number' => '01787654321',
                'fees' => '1.5% per transaction'
            ]
        ]);

        // Sample order data (in a real app, this would come from the session or database)
        $subtotal = 498.00;

        // Calculate processing fee based on bkash gateway fees
        $bkashGateway = collect($gateways)->firstWhere('name', 'bkash');
        $processingFee = $bkashGateway ? GatewaysController::calculateProcessingFee($bkashGateway['fees'], $subtotal) : 0;

        $order = [
            'id' => 'ORD-'.strtoupper(uniqid()),
            'product' => 'Premium Package',
            'quantity' => 1,
            'subtotal' => $subtotal,
            'processing_fee' => $processingFee,
            'total' => $subtotal + $processingFee,
            'merchant' => $setupData['website_name'],
            'merchant_logo' => $setupData['website_logo'],
            'invoice_id' => 'INV-'.strtoupper(uniqid())
        ];

        // Find bkash gateway
        $bkashGateway = collect($gateways)->firstWhere('name', 'bkash');

        $paymentData = [
            'payment_id' => '5f6727b97c8d5c94afb77aa10f5403f7f4f0224b',
            'invoice_id' => $order['invoice_id'],
            'amount' => $order['total'],
            'merchant' => $order['merchant'],
            'merchant_logo' => $order['merchant_logo'],
            'order' => $order,
            'recipient_number' => $bkashGateway['account_number'] ?? '017XXXXXXXX',
            'gateway' => $bkashGateway
        ];

        return view('payment.bKash', compact('paymentData'));
    }

    /**
     * Show Nagad payment page
     *
     * @return \Illuminate\Http\Response
     */
    public function showNagadPage()
    {
        // Get setup data from file (in a real app, this would come from the database)
        $setupData = $this->getSetupData();

        // Sample gateway data (in a real app, this would come from the database)
        $gateways = session('gateways_data', [
            [
                'id' => 1,
                'name' => 'bkash',
                'account_number' => '01712345678',
                'fees' => '1.8% per transaction'
            ],
            [
                'id' => 2,
                'name' => 'Nagad',
                'account_number' => '01787654321',
                'fees' => '1.5% per transaction'
            ]
        ]);

        // Sample order data (in a real app, this would come from the session or database)
        $subtotal = 498.00;

        // Calculate processing fee based on nagad gateway fees
        $nagadGateway = collect($gateways)->firstWhere('name', 'Nagad');
        $processingFee = $nagadGateway ? GatewaysController::calculateProcessingFee($nagadGateway['fees'], $subtotal) : 0;

        $order = [
            'id' => 'ORD-'.strtoupper(uniqid()),
            'product' => 'Premium Package',
            'quantity' => 1,
            'subtotal' => $subtotal,
            'processing_fee' => $processingFee,
            'total' => $subtotal + $processingFee,
            'merchant' => $setupData['website_name'],
            'merchant_logo' => $setupData['website_logo'],
            'invoice_id' => 'INV-'.strtoupper(uniqid())
        ];

        // Find nagad gateway
        $nagadGateway = collect($gateways)->firstWhere('name', 'Nagad');

        $paymentData = [
            'payment_id' => '5f6727b97c8d5c94afb77aa10f5403f7f4f0224b',
            'invoice_id' => $order['invoice_id'],
            'amount' => $order['total'],
            'merchant' => $order['merchant'],
            'merchant_logo' => $order['merchant_logo'],
            'order' => $order,
            'recipient_number' => $nagadGateway['account_number'] ?? '017XXXXXXXX',
            'gateway' => $nagadGateway
        ];

        return view('payment.nagad', compact('paymentData'));
    }

    /**
     * Process the payment
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:bkash,nagad',
            'order_id' => 'required',
            'transaction_id' => 'required_if:payment_method,bkash,nagad|max:10',
            'phone_number' => 'required_if:payment_method,nagad|max:12'
        ]);

        $paymentMethod = $request->payment_method;
        $orderId = $request->order_id;
        $transactionId = $request->transaction_id;
        $phoneNumber = $request->phone_number;

        // In a real application, you would:
        // 1. Verify the order exists and belongs to the user
        // 2. Create a payment record in the database
        // 3. Redirect to the appropriate payment gateway
        // 4. Handle the callback from the payment gateway

        // For now, we'll just simulate the redirect
        switch ($paymentMethod) {
            case 'bkash':
                // Verify transaction ID with Bkash API
                // For demo purposes, we'll just show a success message
                return redirect()->route('checkout')->with('success', 'Bkash payment processed successfully!');
            case 'nagad':
                // Verify transaction ID with Nagad API
                // For demo purposes, we'll just show a success message
                return redirect()->route('checkout')->with('success', 'Nagad payment processed successfully!');
            default:
                return redirect()->back()->with('error', 'Invalid payment method selected.');
        }
    }

    /**
     * Handle payment callback from gateway
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paymentCallback(Request $request)
    {
        // In a real application, you would:
        // 1. Verify the callback is from the payment gateway
        // 2. Update the payment status in the database
        // 3. Send confirmation to the user
        // 4. Notify the merchant

        return response()->json(['status' => 'success', 'message' => 'Payment processed successfully']);
    }

    /**
     * Cancel the payment
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request)
    {
        // In a real application, you would:
        // 1. Update the payment status to cancelled
        // 2. Redirect back to the merchant website
        // 3. Show a cancellation message

        return redirect('/')->with('info', 'Payment has been cancelled.');
    }
}
