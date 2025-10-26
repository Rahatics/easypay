@extends('layouts.app')

@section('title', 'Settings - Easypay')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Settings</h1>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Profile Information</h5>
                            <form method="POST" action="{{ route('settings.update') }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Security Settings</h5>
                            <form method="POST" action="{{ route('settings.password.update') }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Notification Preferences</h5>
                            <div class="setting-item">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center">
                                    <div>
                                        <label class="form-check-label" for="email_notifications">
                                            <h6 class="mb-0">Email Notifications</h6>
                                            <small class="text-muted">Receive email updates about your orders</small>
                                        </label>
                                    </div>
                                    <input class="form-check-input" type="checkbox" id="email_notifications" checked>
                                </div>
                            </div>

                            <div class="setting-item">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center">
                                    <div>
                                        <label class="form-check-label" for="sms_notifications">
                                            <h6 class="mb-0">SMS Notifications</h6>
                                            <small class="text-muted">Receive SMS alerts for order updates</small>
                                        </label>
                                    </div>
                                    <input class="form-check-input" type="checkbox" id="sms_notifications" checked>
                                </div>
                            </div>

                            <div class="setting-item">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center">
                                    <div>
                                        <label class="form-check-label" for="push_notifications">
                                            <h6 class="mb-0">Push Notifications</h6>
                                            <small class="text-muted">Receive mobile push notifications</small>
                                        </label>
                                    </div>
                                    <input class="form-check-input" type="checkbox" id="push_notifications">
                                </div>
                            </div>

                            <div class="setting-item">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center">
                                    <div>
                                        <label class="form-check-label" for="marketing_emails">
                                            <h6 class="mb-0">Marketing Emails</h6>
                                            <small class="text-muted">Receive promotional emails and offers</small>
                                        </label>
                                    </div>
                                    <input class="form-check-input" type="checkbox" id="marketing_emails">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Account Management</h5>
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-download me-2"></i> Download Data
                                </button>
                                <button class="btn btn-outline-warning">
                                    <i class="bi bi-exclamation-triangle me-2"></i> Deactivate Account
                                </button>
                                <button class="btn btn-outline-danger">
                                    <i class="bi bi-trash me-2"></i> Delete Account
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
