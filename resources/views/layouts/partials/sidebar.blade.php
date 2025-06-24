<header class="main-nav">
    <div class="sidebar-user text-center"><a class="setting-primary" href="javascript:void(0)"><i
                data-feather="settings"></i></a><img class="img-90 rounded-circle"
            src="{{ asset('assets/images/dashboard/1.png') }}" alt="">
        <div class="badge-bottom"><span class="badge badge-primary">{{ __('New') }}</span></div><a href="user-profile.html">
            <h6 class="mt-3 f-14 f-w-600">{{ Auth::user()->name }}</h6>
        </a>
        <p class="mb-0 font-roboto">{{ __('Human Resources Department') }}</p>
        <ul>
            <li><span><span class="counter">19.8</span>k</span>
                <p>{{ __('Follow') }}</p>
            </li>
            <li><span>2 year</span>
                <p>{{ __('Experience') }}</p>
            </li>
            <li><span><span class="counter">95.2</span>k</span>
                <p>{{ __('Follower') }} </p>
            </li>
        </ul>
    </div>
    <nav>
        <div class="main-navbar">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>{{ __('Back') }}</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>{{ __('General') }}</h6>
                        </div>
                    </li>
                    <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i
                                data-feather="home"></i><span>{{ __('Dashboard') }}</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="{{ route('users.index') }}">{{ __('Users') }}</a></li>
                            <li><a href="dashboard-02.html">{{ __('Ecommerce') }}</a></li>
                        </ul>
                    </li>
                    <li ><a class="nav-link title" href="{{route('countries.index')}}"> <i
                                data-feather="globe"></i>
                            <span>{{ __('Countries') }}</span></a>
                        <ul class="nav-submenu menu-content">
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>
