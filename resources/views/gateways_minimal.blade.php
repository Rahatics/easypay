@extends('layouts.minimal')

@section('title', 'Payment Gateways - Easypay')

@section('content')
<h1>Payment Gateways</h1>

<h2>Available Gateways</h2>
<ul>
    <li>
        <strong>bkash</strong> - Bangladeshi mobile financial service
        <br>Transaction Fees: 1.8% per transaction
        <br>Status: Active
    </li>
    <li>
        <strong>Nagad</strong> - Bangladeshi mobile financial service
        <br>Transaction Fees: 1.5% per transaction
        <br>Status: Inactive
    </li>
</ul>

<h2>Gateway Management</h2>
<p>Payment gateways can only be added by developers. Please contact your system administrator to request new payment gateways.</p>
<p class="text-muted">For developers: New gateways can be added through the admin panel or by modifying the gateway configuration files.</p>

<div>
    <a href="{{ route('dashboard') }}">Back to Dashboard</a>
</div>
@endsection
