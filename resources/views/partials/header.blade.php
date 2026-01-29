<!-- Header Section Begin -->
<header class="header-section">
    <div class="top-nav">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="tn-left">
                        <li><i class="fa fa-phone"></i> +91 9106330780</li>
                        <li><i class="fa fa-envelope"></i> hotel@sora.com</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="tn-right">
                        <div class="top-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-tripadvisor"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </div>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="bk-btn">Admin Panel</a>
                            @else
                                <a href="{{ route('my.bookings') }}" class="bk-btn">My Bookings</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="bk-btn">Login / Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="menu-item">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('img/logo.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="nav-menu">
                        <nav class="mainmenu">
                            <ul>
                                <li class="{{ Request::routeIs('home') ? 'active' : '' }}">
                                    <a href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="{{ Request::routeIs('rooms*') ? 'active' : '' }}">
                                    <a href="{{ route('rooms') }}">Rooms</a>
                                </li>
                                <li class="{{ Request::routeIs('about') ? 'active' : '' }}">
                                    <a href="{{ route('about') }}">About Us</a>
                                </li>
                                <li class="{{ Request::routeIs('blog*') ? 'active' : '' }}">
                                    <a href="{{ route('blog') }}">News</a>
                                </li>
                                <li class="{{ Request::routeIs('contact') ? 'active' : '' }}">
                                    <a href="{{ route('contact') }}">Contact</a>
                                </li>
                                @auth
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                                        </form>
                                    </li>
                                @endauth
                            </ul>
                        </nav>
                        <div class="nav-right search-switch">
                            <i class="icon_search"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header End -->
