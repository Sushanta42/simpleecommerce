<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html"> <img alt="image" src="/assets/img/logo.png" class="header-logo" />
                <span class="logo-name">Ecomme</span>
            </a>
        </div>
        <ul class="sidebar-menu" id="sidebarMenu">
            <li class="menu-header">Main</li>
            <li class="dropdown">
                <a href="index.html" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown">
                <a href="{{ route('product.index') }}" class="nav-link"><i
                        data-feather="edit"></i><span>Products</span></a>
            </li>

            <li class="menu-header">User</li>
            <li class="dropdown">
                <a href="{{ route('user.index') }}" class="nav-link"><i
                        data-feather="users"></i><span>Customers</span></a>
            </li>
            <li class="dropdown">
                <a href="{{ route('uservendor.index') }}" class="nav-link"><i
                        data-feather="truck"></i><span>Vendors</span></a>
            </li>
        </ul>
    </aside>
</div>
