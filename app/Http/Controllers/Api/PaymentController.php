<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // Order মডেল
use Illuminate\Support\Str; // Str import করুন
use App\Http\Controllers\GatewaysController; // GatewayController import করুন

class PaymentController extends Controller
{
    /**
     * Process a payment request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function process(Request $request)
    {
        // মিডলওয়্যার থেকে মার্চেন্টের তথ্য নিন
        $merchant = $request->merchant;

        // মার্চেন্টের সাইট থেকে আসা ডেটা ভ্যালিডেট করুন
        $validated = $request->validate([
            'amount' => 'required|numeric|min:10',
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'callback_url' => 'required|url',
            'description' => 'nullable|string',
        ]);

        // আপনার গেটওয়ে কন্ট্রোলার থেকে ফি হিসাব করুন (ধাপ ২ এ তৈরি করা)
        // দ্রষ্টব্য: GatewaysController এর লজিকটি এখানে আবার লেখা বা একটি Service Class এ সরানো ভালো
        $gatewayController = new GatewaysController();
        // ডিফল্ট গেটওয়ে (যেমন bkash) এর ফি হিসাব করুন (আপনাকে এটি উন্নত করতে হবে)
        $processingFee = $gatewayController->calculateProcessingFee($validated['amount'], $merchant->id, 'bkash'); // উদাহরণ
        $totalAmount = $validated['amount'] + $processingFee;

        // ধাপ ৩ অনুযায়ী অর্ডার তৈরি করুন
        $order = Order::create([
            'user_id' => $merchant->id,
            'order_id' => 'EP-' . Str::random(10), // ইউনিক অর্ডার আইডি
            'amount' => $validated['amount'],
            'processing_fee' => $processingFee,
            'total_amount' => $totalAmount,
            'customer_info' => [
                'name' => $validated['customer_name'],
                'email' => $validated['customer_email'],
            ],
            'status' => 'pending',
            'gateway' => 'bkash', // ডিফল্ট বা কাস্টমার সিলেক্টেড
            'callback_url' => $validated['callback_url'],
            'description' => $validated['description'],
        ]);

        // মার্চেন্টের সাইটকে পেমেন্ট পেজের URL রিটার্ন করুন
        return response()->json([
            'message' => 'Order created successfully. Redirecting to payment.',
            'order_id' => $order->order_id,
            'redirect_url' => route('payment.bkash', ['orderId' => $order->order_id]) // সরাসরি গেটওয়ে পেজ
        ]);
    }

    /**
     * Get redirect URL for payment method
     *
     * @param string $method
     * @param string $orderId
     * @return string
     */
    private function getPaymentRedirectUrl($method, $orderId)
    {
        switch ($method) {
            case 'bkash':
                return route('payment.bkash', ['orderId' => $orderId]);
            case 'nagad':
                return route('payment.nagad', ['orderId' => $orderId]);
            default:
                return url('/');
        }
    }

    /**
     * Handle payment callback from gateway
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function callback(Request $request)
    {
        // In a real application, you would:
        // 1. Verify the callback is from the payment gateway
        // 2. Update the payment status in the database
        // 3. Send confirmation to the user
        // 4. Notify the merchant

        return response()->json([
            'success' => true,
            'message' => 'Payment callback received'
        ]);
    }
}
