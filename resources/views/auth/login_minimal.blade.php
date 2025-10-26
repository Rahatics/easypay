@extends('layouts.minimal')

@section('title', 'Login - Easypay')

@section('content')
<h1>Login to Easypay</h1>

@if ($errors->any())
    <div class="alert alert-error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div class="form-group">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Remember me</label>
    </div>
    <div class="form-group">
        <button type="submit">Login</button>
    </div>
</form>

<p>Don't have an account? <a href="{{ route('signup') }}">Sign up here</a></p>
@endsection
