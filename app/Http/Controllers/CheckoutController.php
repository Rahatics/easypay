<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GatewaysController;
use App\Models\MerchantGateway;

class CheckoutController extends Controller
{
    /**
     * Get setup data from authenticated user
     *
     * @return array
     */
    private function getSetupData()
    {
        // Get the authenticated user
        $user = Auth::user();

        // If no user is authenticated, return default data
        if (!$user) {
            return [
                'website_name' => 'My Website',
                'website_logo' => ''
            ];
        }

        // Return user's website name from session or user's name
        return [
            'website_name' => session('website_name', $user->name . '\'s Website'),
            'website_logo' => session('website_logo', '')
        ];
    }

    /**
     * Get gateway description by name
     *
     * @param string $name
     * @return string
     */
    private function getGatewayDescription($name)
    {
        $descriptions = [
            'bkash' => 'bkash is a mobile financial service in Bangladesh that allows users to make payments, send money, and perform various financial transactions using their mobile phones.',
            'Nagad' => 'Nagad is a government-backed mobile financial service in Bangladesh that provides digital payment solutions to unbanked and underbanked populations.'
        ];

        return $descriptions[$name] ?? '';
    }

    /**
     * Display the checkout page
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get user's gateways from database
        $userGateways = $user->merchantGateways;

        // If user has no gateways, create default ones
        if ($userGateways->isEmpty()) {
            $defaultGateways = [
                [
                    'gateway_name' => 'bkash',
                    'is_enabled' => true,
                    'fees_percentage' => 1.80,
                    'account_number' => '01712345678'
                ],
                [
                    'gateway_name' => 'Nagad',
                    'is_enabled' => false,
                    'fees_percentage' => 1.50,
                    'account_number' => ''
                ]
            ];

            foreach ($defaultGateways as $gateway) {
                MerchantGateway::create([
                    'user_id' => $user->id,
                    'gateway_name' => $gateway['gateway_name'],
                    'account_number' => $gateway['account_number'],
                    'fees_percentage' => $gateway['fees_percentage'],
                    'is_enabled' => $gateway['is_enabled']
                ]);
            }
            // Reload gateways
            $userGateways = $user->merchantGateways;
        }

        // Format gateways for the view
        $gateways = $userGateways->map(function ($gateway) {
            return [
                'id' => $gateway->id,
                'name' => $gateway->gateway_name,
                'description' => $this->getGatewayDescription($gateway->gateway_name),
                'enabled' => $gateway->is_enabled,
                'fees' => $gateway->fees_percentage . '% per transaction',
                'fees_percentage' => $gateway->fees_percentage,
                'account_number' => $gateway->account_number
            ];
        })->toArray();

        // Get setup data from authenticated user
        $setupData = $this->getSetupData();

        // Create order from request data
        $amount = $request->get('amount', 500.00);
        $description = $request->get('description', 'Premium Package');

        // Calculate processing fee based on selected gateway (for demo, we'll use bkash)
        $selectedGateway = collect($gateways)->firstWhere('name', 'bkash');
        $processingFee = $selectedGateway ? GatewaysController::calculateProcessingFee($selectedGateway['fees_percentage'], $amount) : 0;

        // Create order in database
        $orderRecord = \App\Models\Order::create([
            'user_id' => $user->id,
            'order_id' => 'ORD-' . strtoupper(uniqid()),
            'amount' => $amount,
            'processing_fee' => $processingFee,
            'total_amount' => $amount + $processingFee,
            'currency' => 'BDT',
            'description' => $description,
            'customer_info' => null,
            'status' => 'pending',
            'gateway' => 'bkash',
            'transaction_id' => null,
            'callback_url' => null
        ]);

        // Format order for view
        $order = [
            'id' => $orderRecord->order_id,
            'product' => $orderRecord->description,
            'quantity' => 1,
            'subtotal' => $orderRecord->amount,
            'processing_fee' => $orderRecord->processing_fee,
            'total' => $orderRecord->total_amount,
            'merchant' => $setupData['website_name'],
            'merchant_logo' => $setupData['website_logo'],
            'invoice_id' => 'INV-' . strtoupper(uniqid())
        ];

        return view('checkout', compact('order', 'gateways'));
    }

    /**
     * Show Bkash payment page
     *
     * @param string $orderId
     * @return \Illuminate\Http\Response
     */
    public function showBkashPage($orderId = null)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get setup data from authenticated user
        $setupData = $this->getSetupData();

        // If order ID is provided, fetch the order from database
        $orderRecord = null;
        if ($orderId) {
            $orderRecord = \App\Models\Order::where('user_id', $user->id)
                ->where('order_id', $orderId)
                ->first();
        }

        // Get user's gateways from database
        $userGateways = $user->merchantGateways;

        // If user has no gateways, create default ones
        if ($userGateways->isEmpty()) {
            $defaultGateways = [
                [
                    'gateway_name' => 'bkash',
                    'is_enabled' => true,
                    'fees_percentage' => 1.80,
                    'account_number' => '01712345678'
                ],
                [
                    'gateway_name' => 'Nagad',
                    'is_enabled' => false,
                    'fees_percentage' => 1.50,
                    'account_number' => ''
                ]
            ];

            foreach ($defaultGateways as $gateway) {
                MerchantGateway::create([
                    'user_id' => $user->id,
                    'gateway_name' => $gateway['gateway_name'],
                    'account_number' => $gateway['account_number'],
                    'fees_percentage' => $gateway['fees_percentage'],
                    'is_enabled' => $gateway['is_enabled']
                ]);
            }
            // Reload gateways
            $userGateways = $user->merchantGateways;
        }

        // Find bkash gateway
        $bkashGateway = $userGateways->firstWhere('gateway_name', 'bkash');

        // Format order data
        if ($orderRecord) {
            $order = [
                'id' => $orderRecord->order_id,
                'product' => $orderRecord->description,
                'quantity' => 1,
                'subtotal' => $orderRecord->amount,
                'processing_fee' => $orderRecord->processing_fee,
                'total' => $orderRecord->total_amount,
                'merchant' => $setupData['website_name'],
                'merchant_logo' => $setupData['website_logo'],
                'invoice_id' => 'INV-' . strtoupper(uniqid())
            ];
        } else {
            // Sample order data (in a real app, this would come from the session or database)
            $subtotal = 498.00;
            $processingFee = $bkashGateway ? GatewaysController::calculateProcessingFee($bkashGateway->fees_percentage, $subtotal) : 0;

            $order = [
                'id' => 'ORD-' . strtoupper(uniqid()),
                'product' => 'Premium Package',
                'quantity' => 1,
                'subtotal' => $subtotal,
                'processing_fee' => $processingFee,
                'total' => $subtotal + $processingFee,
                'merchant' => $setupData['website_name'],
                'merchant_logo' => $setupData['website_logo'],
                'invoice_id' => 'INV-' . strtoupper(uniqid())
            ];
        }

        $paymentData = [
            'payment_id' => '5f6727b97c8d5c94afb77aa10f5403f7f4f0224b',
            'invoice_id' => $order['invoice_id'],
            'amount' => $order['total'],
            'merchant' => $order['merchant'],
            'merchant_logo' => $order['merchant_logo'],
            'order' => $order,
            'recipient_number' => $bkashGateway->account_number ?? '017XXXXXXXX',
            'gateway' => [
                'name' => 'bkash',
                'account_number' => $bkashGateway->account_number,
                'fees' => $bkashGateway->fees_percentage . '% per transaction',
                'fees_percentage' => $bkashGateway->fees_percentage
            ]
        ];

        return view('payment.bKash', compact('paymentData'));
    }

    /**
     * Show Nagad payment page
     *
     * @param string $orderId
     * @return \Illuminate\Http\Response
     */
    public function showNagadPage($orderId = null)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get setup data from authenticated user
        $setupData = $this->getSetupData();

        // If order ID is provided, fetch the order from database
        $orderRecord = null;
        if ($orderId) {
            $orderRecord = \App\Models\Order::where('user_id', $user->id)
                ->where('order_id', $orderId)
                ->first();
        }

        // Get user's gateways from database
        $userGateways = $user->merchantGateways;

        // If user has no gateways, create default ones
        if ($userGateways->isEmpty()) {
            $defaultGateways = [
                [
                    'gateway_name' => 'bkash',
                    'is_enabled' => true,
                    'fees_percentage' => 1.80,
                    'account_number' => '01712345678'
                ],
                [
                    'gateway_name' => 'Nagad',
                    'is_enabled' => false,
                    'fees_percentage' => 1.50,
                    'account_number' => ''
                ]
            ];

            foreach ($defaultGateways as $gateway) {
                MerchantGateway::create([
                    'user_id' => $user->id,
                    'gateway_name' => $gateway['gateway_name'],
                    'account_number' => $gateway['account_number'],
                    'fees_percentage' => $gateway['fees_percentage'],
                    'is_enabled' => $gateway['is_enabled']
                ]);
            }
            // Reload gateways
            $userGateways = $user->merchantGateways;
        }

        // Find nagad gateway
        $nagadGateway = $userGateways->firstWhere('gateway_name', 'Nagad');

        // Format order data
        if ($orderRecord) {
            $order = [
                'id' => $orderRecord->order_id,
                'product' => $orderRecord->description,
                'quantity' => 1,
                'subtotal' => $orderRecord->amount,
                'processing_fee' => $orderRecord->processing_fee,
                'total' => $orderRecord->total_amount,
                'merchant' => $setupData['website_name'],
                'merchant_logo' => $setupData['website_logo'],
                'invoice_id' => 'INV-' . strtoupper(uniqid())
            ];
        } else {
            // Sample order data (in a real app, this would come from the session or database)
            $subtotal = 498.00;
            $processingFee = $nagadGateway ? GatewaysController::calculateProcessingFee($nagadGateway->fees_percentage, $subtotal) : 0;

            $order = [
                'id' => 'ORD-' . strtoupper(uniqid()),
                'product' => 'Premium Package',
                'quantity' => 1,
                'subtotal' => $subtotal,
                'processing_fee' => $processingFee,
                'total' => $subtotal + $processingFee,
                'merchant' => $setupData['website_name'],
                'merchant_logo' => $setupData['website_logo'],
                'invoice_id' => 'INV-' . strtoupper(uniqid())
            ];
        }

        $paymentData = [
            'payment_id' => '5f6727b97c8d5c94afb77aa10f5403f7f4f0224b',
            'invoice_id' => $order['invoice_id'],
            'amount' => $order['total'],
            'merchant' => $order['merchant'],
            'merchant_logo' => $order['merchant_logo'],
            'order' => $order,
            'recipient_number' => $nagadGateway->account_number ?? '017XXXXXXXX',
            'gateway' => [
                'name' => 'Nagad',
                'account_number' => $nagadGateway->account_number,
                'fees' => $nagadGateway->fees_percentage . '% per transaction',
                'fees_percentage' => $nagadGateway->fees_percentage
            ]
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
            'transaction_id' => 'required|max:10',
            'phone_number' => 'required_if:payment_method,nagad|max:12'
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Find the order in the database
        $order = \App\Models\Order::where('user_id', $user->id)
            ->where('order_id', $request->order_id)
            ->firstOrFail();

        // Update the order with transaction ID and status
        $order->transaction_id = $request->transaction_id;
        $order->status = 'processing'; // or 'pending_verification' for manual verification
        $order->save();

        // Redirect to merchant dashboard or order page with success message
        return redirect()->route('orders')->with('success', 'Payment verification submitted successfully. Please wait for confirmation.');
    }

    /**
     * Handle payment callback from gateway
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paymentCallback(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // In a real application, you would:
        // 1. Verify the callback is from the payment gateway
        // 2. Update the payment status in the database
        // 3. Send confirmation to the user
        // 4. Notify the merchant

        // For demo purposes, we'll just update the order status
        $orderId = $request->get('order_id');
        $transactionId = $request->get('transaction_id');
        $status = $request->get('status', 'completed');

        // Find the order
        $order = \App\Models\Order::where('user_id', $user->id)
            ->where('order_id', $orderId)
            ->first();

        if ($order) {
            // Update order status
            $order->status = $status;
            $order->transaction_id = $transactionId;
            $order->save();

            return response()->json(['status' => 'success', 'message' => 'Payment processed successfully']);
        }

        return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
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
