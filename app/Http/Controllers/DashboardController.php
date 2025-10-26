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
        $totalRevenue = $merchant->orders()->where('status', 'completed')->sum('amount');

        // পেন্ডিং অর্ডার (ভেরিফিকেশনের অপেক্ষায়)
        $pendingOrders = $merchant->orders()->where('status', 'processing')->count();

        // এই মাসের আয়
        $thisMonthRevenue = $merchant->orders()
            ->where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');

        // মোট অর্ডার সংখ্যা
        $totalOrders = $merchant->orders()->count();

        // সাম্প্রতিক অর্ডারগুলো
        $recentOrders = $merchant->orders()->latest()->take(5)->get();

        return view('dashboard_new', compact(
            'totalRevenue',
            'pendingOrders',
            'thisMonthRevenue',
            'totalOrders',
            'recentOrders'
        ));
    }
}
