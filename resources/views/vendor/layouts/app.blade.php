<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>SmartGhau - Vendor Dashboard Template</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="/assets/css/app.min.css">
    <link rel="stylesheet" href="/assets/bundles/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="/assets/bundles/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="/assets/bundles/prism/prism.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/components.css">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel='shortcut icon' type='image/x-icon' href='/assets/img/favicon.ico' />
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar sticky">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn">
                                <i data-feather="align-justify"></i></a></li>
                        <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                                <i data-feather="maximize"></i>
                            </a></li>
                        <li>
                            <form class="form-inline mr-auto">
                                <div class="search-element">
                                    <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                                        data-width="200">
                                    <button class="btn" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown dropdown-list-toggle">
                        <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg">
                            <i data-feather="mail" class="bell"></i>
                        </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                            <div class="dropdown-header">
                                Product Notifications
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">
                                @php
                                    $vendorId = Auth::user()->id;
                                    $latestProducts = \App\Models\Product::where('vendor_id', $vendorId)
                                        ->where('created_at', '>=', now()->subDays(200))
                                        ->orderBy('created_at', 'desc')
                                        ->get();
                                @endphp

                                @if ($latestProducts->isEmpty())
                                    <p class="dropdown-item">No products added in the last 200 days</p>
                                @else
                                    @foreach ($latestProducts as $product)
                                        <a href="{{ route('product.show', $product->id) }}"
                                            class="dropdown-item dropdown-item-unread">
                                            <span class="dropdown-item-icon bg-primary text-white">
                                                <i class="fas fa-code"></i>
                                            </span>
                                            <span class="dropdown-item-desc">
                                                Latest Added Product: <b>{{ $product->name }}</b>
                                                <span class="time">{{ $product->created_at->diffForHumans() }}</span>
                                            </span>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="{{ route('product.index') }}">View All Products <i
                                        class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown dropdown-list-toggle">
                        <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg">
                            <i data-feather="bell" class="bell"></i>
                        </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                            <div class="dropdown-header">
                                Notifications
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">
                                @php
                                    $vendorId = Auth::user()->id; // Assuming you have a vendor relationship in your User model
                                    $latestUpdatedProducts = \App\Models\Product::where('vendor_id', $vendorId)
                                        ->where('updated_at', '>=', now()->subDays(10))
                                        ->orderBy('updated_at', 'desc')
                                        ->get();
                                @endphp
                                @if ($latestUpdatedProducts->isEmpty())
                                    <p class="dropdown-item">No products updated in the last 10 days</p>
                                @else
                                    @foreach ($latestUpdatedProducts as $product)
                                        <a href="{{ route('product.show', $product->id) }}"
                                            class="dropdown-item dropdown-item-unread">
                                            <span class="dropdown-item-icon bg-primary text-white">
                                                <i class="fas fa-code"></i>
                                            </span>
                                            <span class="dropdown-item-desc">
                                                Latest Updated Product: <b>{{ $product->name }}</b>
                                                <span class="time">{{ $product->updated_at->diffForHumans() }}</span>
                                            </span>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="{{ route('product.index') }}">View All Products <i
                                        class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>

                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image"
                                src="/assets/img/user.png" class="user-img-radious-style"> <span
                                class="d-sm-none d-lg-inline-block"></span></a>
                        <div class="dropdown-menu dropdown-menu-right pullDown">
                            <div class="dropdown-title">Hello {{ Auth::user()->name }}</div>
                            <a href="profile.html" class="dropdown-item has-icon"> <i class="far
										fa-user"></i>
                                Profile
                            </a> <a href="timeline.html" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                                Activities
                            </a> <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                                Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('vendor.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item has-icon text-danger"
                                    style="border: none; background: none; padding: 15; display: flex; align-items: center;">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- Sizebar -->
            <x-vendor.sidebar />
            <!-- Main Content -->
            <div class="main-content">
                {{ $slot }}
            </div>
        </div>
    </div>
    <!-- General JS Scripts -->
    <script src="/assets/js/app.min.js"></script>
    <!-- JS Libraies -->
    <script src="/assets/bundles/summernote/summernote-bs4.js"></script>
    <script src="/assets/bundles/datatables/datatables.min.js"></script>
    <script src="/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/bundles/jquery-ui/jquery-ui.min.js"></script>
    <script src="/assets/bundles/apexcharts/apexcharts.min.js"></script>
    <script src="/assets/bundles/ckeditor/ckeditor.js"></script>

    <script src="/assets/bundles/prism/prism.js"></script>
    <!-- Page Specific JS File -->
    <script src="/assets/js/page/datatables.js"></script>
    <script src="/assets/js/page/index.js"></script>
    <script src="/assets/js/page/ckeditor.js"></script>
    <!-- Template JS File -->
    <script src="/assets/js/scripts.js"></script>
    <!-- Custom JS File -->
    <script src="/assets/js/custom.js"></script>
    <script>
        // Get the current URL
        var currentUrl = window.location.href;

        // Get all the "a" tags in the dropdown menus
        var dropdownLinks = document.querySelectorAll('#sidebarMenu ul.dropdown-menu li a');

        // Loop through each "a" tag and compare its href attribute with the current URL
        dropdownLinks.forEach(function(link) {
            if (link.href === currentUrl) {
                // Add the "active" class to the parent "li" element
                link.parentNode.classList.add('active');

                // If the parent "li" element has a parent "ul" with "dropdown-menu" class,
                // add the "show" class to display the dropdown menu
                var dropdownMenu = link.closest('.dropdown-menu');
                if (dropdownMenu) {
                    dropdownMenu.parentNode.classList.add('show');
                }
            }
        });
    </script>

    <!-- Script to calculate selling price -->
    <script>
        function calculate() {
            var price = document.getElementById('price').value;
            var discount = document.getElementById('discount_percent').value;
            var sp = price - (discount * price) / 100;
            var roundedDiscount = Math.ceil(parseFloat(discount)); // Round up the discount percent
            document.getElementById('discount_percent').value = roundedDiscount;
            document.getElementById('sale_price').value = sp;
        }

        function calculateDiscount() {
            var price = parseFloat(document.getElementById('price').value);
            var sp = parseFloat(document.getElementById('sale_price').value);

            if (!isNaN(price) && !isNaN(sp)) {
                var discount = ((price - sp) / price) * 100;
                var roundedDiscount = Math.ceil(discount); // Round up the discount percent
                document.getElementById('discount_percent').value = roundedDiscount.toFixed(2);
            } else {
                alert("Please enter valid numeric values for Price and Selling Price.");
            }
        }
    </script>


</body>


<!-- index.html  21 Nov 2019 03:47:04 GMT -->

</html>
