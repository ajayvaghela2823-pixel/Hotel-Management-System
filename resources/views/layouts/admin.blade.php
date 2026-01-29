<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sona Hotel</title>
    <!-- CSS Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
    <style>
        .admin-sidebar {
            background: #19191a;
            min-height: 100vh;
            color: #fff;
            padding: 20px;
        }
        .admin-sidebar a {
            color: #a9a9a9;
            display: block;
            padding: 10px 0;
            font-size: 16px;
        }
        .admin-sidebar a:hover, .admin-sidebar a.active {
            color: #dfa974;
        }
        .admin-content {
            padding: 30px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 admin-sidebar">
                <h3 class="text-white mb-4">Sona Admin</h3>
                <nav>
                    <a href="{{ route('admin.dashboard') }}" class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.rooms.index') }}" class="{{ Request::routeIs('admin.rooms*') ? 'active' : '' }}">
                        <i class="fa fa-bed"></i> Rooms
                    </a>
                    <a href="{{ route('admin.bookings.index') }}" class="{{ Request::routeIs('admin.bookings*') ? 'active' : '' }}">
                        <i class="fa fa-calendar"></i> Bookings
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="{{ Request::routeIs('admin.users*') ? 'active' : '' }}">
                        <i class="fa fa-users"></i> Users
                    </a>
                    <a href="{{ route('admin.blogs.index') }}" class="{{ Request::routeIs('admin.blogs*') ? 'active' : '' }}">
                        <i class="fa fa-newspaper-o"></i> Blogs
                    </a>
                    <a href="{{ route('home') }}" target="_blank">
                        <i class="fa fa-globe"></i> View Website
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger w-100">Logout</button>
                    </form>
                </nav>
            </div>
            <div class="col-md-10 admin-content">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>
