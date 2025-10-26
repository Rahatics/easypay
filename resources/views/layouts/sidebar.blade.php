<!-- Desktop Sidebar -->
<div class="col-lg-2 d-none d-lg-block p-0">
    <div class="sidebar p-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('connect') ? 'active' : '' }}" href="{{ route('connect') }}">
                    <i class="bi bi-people me-2"></i> Connect
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('orders') ? 'active' : '' }}" href="{{ route('orders') }}">
                    <i class="bi bi-bag me-2"></i> Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('gateways') ? 'active' : '' }}" href="{{ route('gateways') }}">
                    <i class="bi bi-credit-card me-2"></i> Gateways
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('settings') ? 'active' : '' }}" href="{{ route('settings') }}">
                    <i class="bi bi-gear me-2"></i> Settings
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Mobile Sidebar -->
<div class="mobile-sidebar">
    <div class="sidebar p-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('connect') ? 'active' : '' }}" href="{{ route('connect') }}">
                    <i class="bi bi-people me-2"></i> Connect
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('orders') ? 'active' : '' }}" href="{{ route('orders') }}">
                    <i class="bi bi-bag me-2"></i> Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('gateways') ? 'active' : '' }}" href="{{ route('gateways') }}">
                    <i class="bi bi-credit-card me-2"></i> Gateways
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('settings') ? 'active' : '' }}" href="{{ route('settings') }}">
                    <i class="bi bi-gear me-2"></i> Settings
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay"></div>
