<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Jobs\SendOrderCallback;

class VerificationController extends Controller
{
    /**
     * Auto-verify payment based on SMS data
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyPaymentFromSMS(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|string',
            'amount' => 'required|numeric',
            'sender_number' => 'required|string|in:bkash,nagad,Bkash,Nagad'
        ]);

        $merchant = $request->user();

        // Normalize sender number to lowercase
        $gateway = strtolower($request->sender_number);

        // Find matching order
        $order = $merchant->orders()
            ->where('status', 'processing')
            ->where('total_amount', $request->amount)
            ->where('gateway', $gateway)
            ->first();

        // If order is found
        if ($order) {
            // Update transaction ID and status
            $order->transaction_id = $request->transaction_id;
            $order->status = 'completed';
            $order->save();

            // Dispatch callback job
            SendOrderCallback::dispatch($order)->onQueue('callbacks');

            return response()->json([
                'success' => true,
                'message' => 'Order auto-approved successfully.'
            ]);
        }

        // If no matching order found
        return response()->json([
            'success' => false,
            'error' => 'No matching order found.'
        ], 404);
    }
}
