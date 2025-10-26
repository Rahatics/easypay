@extends('layouts.minimal')

@section('title', 'Settings - Easypay')

@section('content')
<h1>Settings</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<h2>Profile Information</h2>
<form>
    <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" value="{{ Auth::user()->name }}" required>
    </div>
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" value="{{ Auth::user()->email }}" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" placeholder="Enter your phone number">
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <textarea id="address" rows="3" placeholder="Enter your address"></textarea>
    </div>
    <div class="form-group">
        <button type="submit">Save Changes</button>
    </div>
</form>

<h2>Security Settings</h2>
<form>
    <div class="form-group">
        <label for="current_password">Current Password</label>
        <input type="password" id="current_password" required>
    </div>
    <div class="form-group">
        <label for="new_password">New Password</label>
        <input type="password" id="new_password" required>
    </div>
    <div class="form-group">
        <label for="confirm_password">Confirm New Password</label>
        <input type="password" id="confirm_password" required>
    </div>
    <div class="form-group">
        <button type="submit">Update Password</button>
    </div>
</form>

<h2>Notification Preferences</h2>
<ul>
    <li>
        <input type="checkbox" id="email_notifications" checked>
        <label for="email_notifications">Email Notifications</label>
    </li>
    <li>
        <input type="checkbox" id="sms_notifications" checked>
        <label for="sms_notifications">SMS Notifications</label>
    </li>
    <li>
        <input type="checkbox" id="push_notifications">
        <label for="push_notifications">Push Notifications</label>
    </li>
    <li>
        <input type="checkbox" id="marketing_emails">
        <label for="marketing_emails">Marketing Emails</label>
    </li>
</ul>

<h2>Account Management</h2>
<ul>
    <li><a href="#">Download Data</a></li>
    <li><a href="#">Deactivate Account</a></li>
    <li><a href="#">Delete Account</a></li>
</ul>

<div>
    <a href="{{ route('dashboard') }}">Back to Dashboard</a>
</div>
@endsection
