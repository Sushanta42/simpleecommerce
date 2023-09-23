<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('vendor.dashboard') }}"> <img alt="image" src="/assets/img/logo.png" class="header-logo" />
                <span class="logo-name">SmartGhau</span>
            </a>
        </div>
        <ul class="sidebar-menu" id="sidebarMenu">
            <li class="menu-header">Main</li>
            <li class="dropdown {{ request()->is('vendor/dashboard') ? 'active' : '' }}">
                <a href="{{ route('vendor.dashboard') }}" class="nav-link"><i
                        data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown {{ request()->is('vendor/product*') ? 'active' : '' }}">
                <a href="{{ route('product.index') }}" class="nav-link"><i
                        data-feather="edit"></i><span>Products</span></a>
            </li>
        </ul>
    </aside>
</div>
