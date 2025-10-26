<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display the transactions page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // In a real app, this would come from the database
        $transactions = [];

        return view('transactions', compact('transactions'));
    }
}
