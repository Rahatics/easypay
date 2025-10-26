<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Jobs\SendOrderCallback;

class OrderController extends Controller
{
    /**
     * Get pending orders for the authenticated merchant
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPendingOrders(Request $request)
    {
        $merchant = $request->user();

        $pendingOrders = $merchant->orders()
            ->where('status', 'processing')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pendingOrders
        ]);
    }

    /**
     * Approve an order
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function approveOrder(Request $request, Order $order)
    {
        $merchant = $request->user();

        // Check if the order belongs to the merchant
        if ($order->user_id !== $merchant->id) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized action.'
            ], 403);
        }

        // Update order status to completed
        $order->status = 'completed';
        $order->save();

        // Dispatch callback job
        SendOrderCallback::dispatch($order)->onQueue('callbacks');

        return response()->json([
            'success' => true,
            'message' => 'Order approved successfully.',
            'data' => $order
        ]);
    }

    /**
     * Reject an order
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function rejectOrder(Request $request, Order $order)
    {
        $merchant = $request->user();

        // Check if the order belongs to the merchant
        if ($order->user_id !== $merchant->id) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized action.'
            ], 403);
        }

        // Update order status to failed
        $order->status = 'failed';
        $order->save();

        // Dispatch callback job
        SendOrderCallback::dispatch($order)->onQueue('callbacks');

        return response()->json([
            'success' => true,
            'message' => 'Order rejected successfully.',
            'data' => $order
        ]);
    }
}
