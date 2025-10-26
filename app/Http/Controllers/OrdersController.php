<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display the orders page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // In a real app, this would come from the database
        $orders = [];

        return view('orders', compact('orders'));
    }
}
