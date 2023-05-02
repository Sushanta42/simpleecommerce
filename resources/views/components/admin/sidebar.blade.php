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
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                        data-feather="grid"></i><span>Category</span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('category.index') }}" class="nav-link"
                            onclick="loadContent(event, '{{ route('category.index') }}')">
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
            <li class="dropdown">
                <a href="{{ route('user.index') }}" class="nav-link"><i
                        data-feather="users"></i><span>Customers</span></a>
            </li>
            <li class="dropdown">
                <a href="{{ route('uservendor.index') }}" class="nav-link"><i data-feather="truck"></i><span>Vendors</span></a>
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
            <li class="dropdown">
                <a href="{{ route('commonaddress.index') }}" class="nav-link"><i
                        data-feather="copy"></i><span>Common Address</span></a>
            </li>
            <li class="dropdown">
                <a href="{{ route('uservendor.index') }}" class="nav-link"><i data-feather="map-pin"></i><span>User Address</span></a>
            </li>
        </ul>
    </aside>
</div>
