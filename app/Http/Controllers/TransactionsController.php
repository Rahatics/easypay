<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class TransactionsController extends Controller
{
    /**
     * Display the transactions page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all orders for the authenticated merchant
        $transactions = Auth::user()->orders()->latest()->paginate(15);

        return view('transactions_new', compact('transactions'));
    }
}
