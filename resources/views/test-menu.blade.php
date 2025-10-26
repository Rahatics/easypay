@extends('layouts.app')

@section('title', 'Test Menu - Easypay')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1>Menu Test Page</h1>
            <p>This page is for testing the menu functionality.</p>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Menu Testing</h5>
                    <p class="card-text">Use this page to test if the menu is working correctly on both desktop and mobile devices.</p>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary me-md-2">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                        <a href="{{ route('connect') }}" class="btn btn-outline-primary me-md-2">
                            <i class="bi bi-people me-2"></i>Connect
                        </a>
                        <a href="{{ route('orders') }}" class="btn btn-outline-primary">
                            <i class="bi bi-bag me-2"></i>Orders
                        </a>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Desktop Menu</h5>
                            <p>On desktop, you should see the sidebar menu on the left side of the page.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Mobile Menu</h5>
                            <p>On mobile, you should see a hamburger menu button at the top left. Click it to open the slide-in menu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
