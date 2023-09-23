<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>SmartGhau - Admin Dashboard Template</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="/assets/css/app.min.css">
    <link rel="stylesheet" href="/assets/bundles/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="/assets/bundles/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
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
                    @inject('usersubscriptions', 'App\Models\UserSubscription')

                    <li class="dropdown dropdown-list-toggle">
                        <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg">
                            <i data-feather="bell" class="bell"></i>
                        </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                            <div class="dropdown-header">
                                Notifications
                                {{-- <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div> --}}
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">
                                @foreach ($usersubscriptions->latest()->get() as $item)
                                    <a href="{{ route('usersubscription.edit', $item->id) }}" class="dropdown-item dropdown-item-unread">
                                        <span class="dropdown-item-icon bg-primary text-white">
                                            <i class="fas fa-code"></i>
                                        </span>
                                        <span class="dropdown-item-desc">
                                            {{ $item->user->name }} has a new subscription:
                                            <b>{{ $item->subscription->name }}</b>
                                            <span class="time">{{ $item->created_at->diffForHumans() }}</span>
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="{{ route('usersubscription.index') }}">View All <i
                                        class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>

                    @inject('orders', 'App\Models\Order')

                    <li class="dropdown dropdown-list-toggle">
                        <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg">
                            <i data-feather="mail" class="bell"></i>
                        </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                            <div class="dropdown-header">
                                Order Notifications
                                {{-- <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div> --}}
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">
                                @foreach ($orders->latest()->get() as $item)
                                    <a href="{{ route('order.show', $item->id) }}" class="dropdown-item dropdown-item-unread">
                                        <span class="dropdown-item-icon bg-primary text-white">
                                            <i class="fas fa-code"></i>
                                        </span>
                                        <span class="dropdown-item-desc">
                                            {{ $item->user->name }} has a new order:
                                            <b>{{ $item->total }}</b>
                                            <span class="time">{{ $item->created_at->diffForHumans() }}</span>
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="{{ route('order.index') }}">View All <i
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
                            <a href="profile.html" class="dropdown-item has-icon"> <i
                                    class="far
										fa-user"></i> Profile
                            </a> <a href="timeline.html" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                                Activities
                            </a> <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                                Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('admin.logout') }}" method="POST">
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
            <x-admin.sidebar />
            <!-- Main Content -->
            <div class="main-content">
                {{ $slot }}
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    <a href="">SmartGhau</a></a>
                </div>
                <div class="footer-right">
                </div>
            </footer>
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
    <!-- Page Specific JS File -->
    <script src="/assets/js/page/datatables.js"></script>
    <script src="/assets/js/page/index.js"></script>
    <script src="/assets/js/page/ckeditor.js"></script>
    <script src="/assets/bundles/datatables/export-tables/buttons.print.min.js"></script>
    <!-- Template JS File -->
    <script src="/assets/js/scripts.js"></script>
    <!-- Custom JS File -->
    <script src="/assets/js/custom.js"></script>
</body>


<!-- index.html  21 Nov 2019 03:47:04 GMT -->

</html>
