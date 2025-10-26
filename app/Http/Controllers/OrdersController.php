<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Jobs\SendOrderCallback;

class OrdersController extends Controller
{
    /**
     * Display the orders page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Use explicit query instead of relationship
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(15); // notun ordergulo age dekhabe

        // Apnar pochonder view file e $orders variableti pass korun
        // Apnar projekte 3ti vinno order er view ache, ami orders_new.blade.php bebohar korchi
        return view('orders_new', compact('orders'));
    }

    /**
     * Update order status
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, Order $order)
    {
        // 1. Check korun je ei orderti ei merchant er kina
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // 2. Request theke notun status nin (jemon 'completed' ba 'failed')
        $request->validate([
            'status' => 'required|string|in:completed,failed,cancelled', // Apnar proyojon moto status jog korun
        ]);

        // 3. Status update korun
        $order->status = $request->status;
        $order->save();

        // 4. কলব্যাক পাঠানোর লজিক
        if (!empty($order->callback_url)) {
            // একটি জব (Job) এর মাধ্যমে কলব্যাক পাঠানো সবচেয়ে ভালো অভ্যাস
            // এটি আপনার সার্ভারকে দ্রুত রেসপন্স করতে সাহায্য করবে
            \App\Jobs\SendOrderCallback::dispatch($order)->onQueue('callbacks');
        }

        return redirect()->route('orders')->with('success', 'Order status updated successfully.');
    }
}
