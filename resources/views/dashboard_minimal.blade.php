@extends('layouts.minimal')

@section('title', 'Dashboard - Easypay')

@section('content')
<h1>Dashboard</h1>

<p>Welcome back, {{ Auth::user()->name }}!</p>

<h2>Account Summary</h2>
<ul>
    <li>Total Balance: $12,450.75</li>
    <li>This Month: $4,230.50</li>
    <li>Total Orders: 142</li>
    <li>Savings: $850.25</li>
</ul>

<h2>Quick Actions</h2>
<ul>
    <li><a href="#">Place Order</a></li>
    <li><a href="#">Track Order</a></li>
    <li><a href="#">View Analytics</a></li>
</ul>

<h2>Recent Orders</h2>
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Oct 24, 2025</td>
            <td>Electronics Purchase</td>
            <td>+$3,500.00</td>
        </tr>
        <tr>
            <td>Oct 22, 2025</td>
            <td>Online Shopping</td>
            <td>-$89.99</td>
        </tr>
        <tr>
            <td>Oct 20, 2025</td>
            <td>Order to John</td>
            <td>-$150.00</td>
        </tr>
        <tr>
            <td>Oct 18, 2025</td>
            <td>Freelance Service</td>
            <td>+$750.00</td>
        </tr>
    </tbody>
</table>

<div>
    <a href="{{ route('orders') }}">View All Orders</a> |
    <a href="{{ route('connect') }}">Connect</a> |
    <a href="{{ route('gateways') }}">Gateways</a> |
    <a href="{{ route('settings') }}">Settings</a> |
    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
        @csrf
        <button type="submit" style="background: none; border: none; color: #007bff; text-decoration: underline; cursor: pointer;">Logout</button>
    </form>
</div>
@endsection
