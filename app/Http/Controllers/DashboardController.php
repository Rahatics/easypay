<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Carbon\Carbon; // তারিখের জন্য

class DashboardController extends Controller
{
    // Show dashboard page
    public function index()
    {
        $merchant = Auth::user();

        // মোট আয় (Completed Order)
        $totalRevenue = Order::where('user_id', $merchant->id)->where('status', 'completed')->sum('amount');

        // পেন্ডিং অর্ডার (ভেরিফিকেশনের অপেক্ষায়)
        $pendingOrders = Order::where('user_id', $merchant->id)->where('status', 'processing')->count();

        // এই মাসের আয়
        $thisMonthRevenue = Order::where('user_id', $merchant->id)
            ->where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');

        // মোট অর্ডার সংখ্যা
        $totalOrders = Order::where('user_id', $merchant->id)->count();

        // সাম্প্রতিক অর্ডারগুলো
        $recentOrders = Order::where('user_id', $merchant->id)->latest()->take(5)->get();

        return view('dashboard_new', compact(
            'totalRevenue',
            'pendingOrders',
            'thisMonthRevenue',
            'totalOrders',
            'recentOrders'
        ));
    }
}
