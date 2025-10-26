<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GatewaysController;
use App\Models\MerchantGateway;
use App\Models\Order;
use App\Models\User;

class CheckoutController extends Controller
{
    /**
     * Get setup data from merchant user
     *
     * @param User $user
     * @return array
     */
    private function getSetupData($user)
    {
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
        // Get order ID from request
        $orderId = $request->get('order');
        
        if (!$orderId) {
            return redirect('/')->with('error', 'Invalid checkout request.');
        }

        // Find the order
        $orderRecord = Order::where('order_id', $orderId)->first();
        
        if (!$orderRecord) {
            return redirect('/')->with('error', 'Order not found.');
        }

        // Get the merchant user
        $user = $orderRecord->user;

        // Get user's gateways from database
        $userGateways = $user->merchantGateways;

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

        // Get setup data from merchant user
        $setupData = $this->getSetupData($user);

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
        if (!$orderId) {
            return redirect('/')->with('error', 'Invalid payment request.');
        }

        // Find the order
        $orderRecord = Order::where('order_id', $orderId)->first();
        
        if (!$orderRecord) {
            return redirect('/')->with('error', 'Order not found.');
        }

        // Get the merchant user
        $user = $orderRecord->user;

        // Get setup data from merchant user
        $setupData = $this->getSetupData($user);

        // Get user's gateways from database
        $userGateways = $user->merchantGateways;

        // Find bkash gateway
        $bkashGateway = $userGateways->firstWhere('gateway_name', 'bkash');
        
        if (!$bkashGateway || !$bkashGateway->is_enabled) {
            return redirect('/')->with('error', 'Bkash payment gateway is not available.');
        }

        // Format order data
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
        if (!$orderId) {
            return redirect('/')->with('error', 'Invalid payment request.');
        }

        // Find the order
        $orderRecord = Order::where('order_id', $orderId)->first();
        
        if (!$orderRecord) {
            return redirect('/')->with('error', 'Order not found.');
        }

        // Get the merchant user
        $user = $orderRecord->user;

        // Get setup data from merchant user
        $setupData = $this->getSetupData($user);

        // Get user's gateways from database
        $userGateways = $user->merchantGateways;

        // Find nagad gateway
        $nagadGateway = $userGateways->firstWhere('gateway_name', 'Nagad');
        
        if (!$nagadGateway || !$nagadGateway->is_enabled) {
            return redirect('/')->with('error', 'Nagad payment gateway is not available.');
        }

        // Format order data
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
            'transaction_id' => 'required|max:50'
        ]);

        // Find the order in the database
        $order = Order::where('order_id', $request->order_id)->first();
        
        if (!$order) {
            return redirect('/')->with('error', 'Order not found.');
        }

        // Update the order with transaction ID and status
        $order->transaction_id = $request->transaction_id;
        $order->status = 'processing'; // or 'pending_verification' for manual verification
        $order->save();

        // Redirect to success page with success message
        return redirect()->route('checkout')->with('success', 'Payment verification submitted successfully. Please wait for confirmation.');
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

        // For demo purposes, we'll just update the order status
        $orderId = $request->get('order_id');
        $transactionId = $request->get('transaction_id');
        $status = $request->get('status', 'completed');

        // Find the order
        $order = Order::where('order_id', $orderId)->first();

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