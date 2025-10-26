@extends('layouts.app')

@section('title', 'Connect - Easypay')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Connect</h1>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Your Contacts</h5>
                            <p class="text-muted">Manage your connected contacts for easy transactions.</p>

                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Search contacts...">
                                <button class="btn btn-outline-primary" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>

                            <div class="mt-4">
                                <h6 class="mb-3">Recent Contacts</h6>
                                <div class="d-flex align-items-center mb-3 p-3 border rounded">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <i class="bi bi-person text-success fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">John Smith</h6>
                                        <small class="text-muted">john@example.com</small>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary">Send</button>
                                </div>

                                <div class="d-flex align-items-center mb-3 p-3 border rounded">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <i class="bi bi-person text-success fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">Sarah Johnson</h6>
                                        <small class="text-muted">sarah@example.com</small>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary">Send</button>
                                </div>

                                <div class="d-flex align-items-center mb-3 p-3 border rounded">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <i class="bi bi-person text-success fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">Michael Brown</h6>
                                        <small class="text-muted">michael@example.com</small>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Add New Contact</h5>
                            <p class="text-muted">Connect with someone new to send payments.</p>

                            <form>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter full name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter email address">
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" placeholder="Enter phone number">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-person-plus me-2"></i> Add Contact
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">Import Contacts</h5>
                            <p class="text-muted">Import your contacts from your device or social networks.</p>

                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-google me-2"></i> Import from Gmail
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-facebook me-2"></i> Import from Facebook
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-phone me-2"></i> Import from Phone
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Social Connections</h5>
                            <p class="text-muted">Connect with your social networks to find friends on Easypay.</p>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                                                <i class="bi bi-facebook text-primary fs-1"></i>
                                            </div>
                                            <h6 class="mb-2">Facebook</h6>
                                            <p class="text-muted small">Find and connect with your Facebook friends</p>
                                            <button class="btn btn-outline-primary">
                                                <i class="bi bi-link me-2"></i> Connect
                                            </button>

                                            @if(false)
                                                <div class="mt-3">
                                                    <p class="text-success mb-2"><i class="bi bi-check-circle-fill me-1"></i> Connected</p>
                                                    <p class="small text-muted">24 friends found</p>
                                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                        @foreach(range(1, 5) as $i)
                                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                <i class="bi bi-person text-success"></i>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                                                <i class="bi bi-google text-danger fs-1"></i>
                                            </div>
                                            <h6 class="mb-2">Google</h6>
                                            <p class="text-muted small">Find and connect with your Google contacts</p>
                                            <button class="btn btn-outline-danger">
                                                <i class="bi bi-link me-2"></i> Connect
                                            </button>

                                            @if(false)
                                                <div class="mt-3">
                                                    <p class="text-success mb-2"><i class="bi bi-check-circle-fill me-1"></i> Connected</p>
                                                    <p class="small text-muted">18 contacts found</p>
                                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                        @foreach(range(1, 5) as $i)
                                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                <i class="bi bi-person text-success"></i>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">Referral Program</h5>
                                            <p class="text-muted">Earn rewards by referring friends to Easypay.</p>

                                            <div class="bg-light p-3 rounded mb-3">
                                                <p class="mb-1"><strong>Your Referral Code:</strong></p>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" value="EZP{{ strtoupper(substr(Auth::user()->name, 0, 3)) }}{{ Auth::user()->id }}" readonly>
                                                    <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard()">
                                                        <i class="bi bi-copy"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <p class="small text-muted">
                                                <i class="bi bi-gift me-1"></i> Earn $5 for each friend who signs up using your code
                                            </p>

                                            @if(false)
                                                <div class="mt-3">
                                                    <h6>Recent Referrals</h6>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                            <i class="bi bi-person text-success"></i>
                                                        </div>
                                                        <div>
                                                            <p class="mb-0 small">Alex Thompson</p>
                                                            <p class="mb-0 text-success small">Joined 2 days ago</p>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                            <i class="bi bi-person text-success"></i>
                                                        </div>
                                                        <div>
                                                            <p class="mb-0 small">Emma Wilson</p>
                                                            <p class="mb-0 text-success small">Joined 1 week ago</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">Invite Friends</h5>
                                            <p class="text-muted">Share Easypay with your friends and get rewards.</p>

                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="{{ url('/invite/' . Auth::user()->id) }}" readonly>
                                                <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard()">
                                                    <i class="bi bi-copy"></i> Copy
                                                </button>
                                            </div>

                                            <div class="d-flex justify-content-center gap-3 mt-4">
                                                <a href="#" class="btn btn-outline-primary">
                                                    <i class="bi bi-facebook"></i>
                                                </a>
                                                <a href="#" class="btn btn-outline-info">
                                                    <i class="bi bi-twitter"></i>
                                                </a>
                                                <a href="#" class="btn btn-outline-success">
                                                    <i class="bi bi-whatsapp"></i>
                                                </a>
                                                <a href="#" class="btn btn-outline-danger">
                                                    <i class="bi bi-envelope"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mt-4">
                                        <div class="card-body">
                                            <h5 class="card-title">Contact Groups</h5>
                                            <p class="text-muted">Organize your contacts into groups for easier ordering.</p>

                                            <div class="d-grid gap-2">
                                                <button class="btn btn-outline-secondary">
                                                    <i class="bi bi-plus-circle me-2"></i> Create New Group
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard() {
        const copyText = document.querySelector('.form-control');
        copyText.select();
        document.execCommand('copy');

        // Show feedback
        const button = document.querySelector('.btn-outline-primary');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="bi bi-check"></i> Copied!';
        setTimeout(() => {
            button.innerHTML = originalText;
        }, 2000);
    }
</script>
@endsection
