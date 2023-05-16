<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html"> <img alt="image" src="/assets/img/logo.png" class="header-logo" />
                <span class="logo-name">Ecomme</span>
            </a>
        </div>
        <ul class="sidebar-menu" id="sidebarMenu">
            <li class="menu-header">Main</li>
            <li class="dropdown {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link"><i
                        data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown {{ request()->is('category*') || request()->is('subcategory*') ? 'active' : '' }}">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="grid"></i><span>Category</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('category.index') }}">
                            Category
                        </a>
                    </li>
                </ul>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('subcategory.index') }}">Sub Category</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="index.html" class="nav-link"><i data-feather="edit"></i><span>Products</span></a>
            </li>

            <li class="menu-header">User</li>
            <li class="dropdown {{ request()->is('user') || request()->is('user/*') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}" class="nav-link"><i
                        data-feather="users"></i><span>Customers</span></a>
            </li>
            <li class="dropdown {{ request()->is('uservendor*') ? 'active' : '' }}">
                <a href="{{ route('uservendor.index') }}" class="nav-link"><i
                        data-feather="truck"></i><span>Vendors</span></a>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="flag"></i><span>Sliders</span></a>
                <ul class="dropdown-menu">
                    <li><a href="carousel.html">Bootstrap Carousel.html</a></li>
                    <li><a class="nav-link" href="owl-carousel.html">Owl Carousel</a></li>
                </ul>
            </li>
            <li><a class="nav-link" href="timeline.html"><i data-feather="sliders"></i><span>Timeline</span></a></li>
            <li class="menu-header">Addresses</li>
            <li class="dropdown {{ request()->is('commonaddress*') ? 'active' : '' }}">
                <a href="{{ route('commonaddress.index') }}" class="nav-link"><i data-feather="copy"></i><span>Common
                        Address</span></a>
            </li>
            <li class="dropdown">
                <a href="{{ route('uservendor.index') }}" class="nav-link"><i data-feather="map-pin"></i><span>User
                        Address</span></a>
            </li>
            <li class="menu-header">Subscriptions</li>
            <li class="dropdown {{ request()->is('subscription*') ? 'active' : '' }}">
                <a href="{{ route('subscription.index') }}" class="nav-link"><i
                        data-feather="dollar-sign"></i><span>Subscription</span></a>
            </li>
            <li class="dropdown {{ request()->is('usersubscription*') ? 'active' : '' }}">
                <a href="{{ route('usersubscription.index') }}" class="nav-link"><i
                        data-feather="user-check"></i><span>User
                        Subscription</span></a>
            </li>
        </ul>
    </aside>
</div>
