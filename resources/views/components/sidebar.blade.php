<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html"> <img alt="image" src="/assets/img/logo.png" class="header-logo" /> <span
                    class="logo-name">SmartGau</span>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown {{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown {{ request()->is('user/userproduct*') ? 'active' : '' }}">
                <a href="{{ route('userproduct.index') }}" class="nav-link"><i
                        data-feather="package"></i><span>Products</span></a>
            </li>
        </ul>
    </aside>
</div>
