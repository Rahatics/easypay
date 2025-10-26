@extends('layouts.minimal')

@section('title', 'Orders - Easypay')

@section('content')
<h1>Orders</h1>

<h2>Order History</h2>
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Oct 24, 2025</td>
            <td>Electronics Purchase</td>
            <td>Received</td>
            <td>+$3,500.00</td>
            <td>Completed</td>
        </tr>
        <tr>
            <td>Oct 22, 2025</td>
            <td>Online Shopping</td>
            <td>Sent</td>
            <td>-$89.99</td>
            <td>Completed</td>
        </tr>
        <tr>
            <td>Oct 20, 2025</td>
            <td>Order to John</td>
            <td>Sent</td>
            <td>-$150.00</td>
            <td>Pending</td>
        </tr>
        <tr>
            <td>Oct 18, 2025</td>
            <td>Freelance Service</td>
            <td>Received</td>
            <td>+$750.00</td>
            <td>Completed</td>
        </tr>
        <tr>
            <td>Oct 15, 2025</td>
            <td>Grocery Shopping</td>
            <td>Sent</td>
            <td>-$125.50</td>
            <td>Cancelled</td>
        </tr>
    </tbody>
</table>

<h2>Order Statistics</h2>
<ul>
    <li>Total Orders: 24</li>
    <li>Completed: 18</li>
    <li>Pending: 4</li>
    <li>Cancelled: 2</li>
</ul>

<div>
    <a href="{{ route('dashboard') }}">Back to Dashboard</a>
</div>
@endsection
