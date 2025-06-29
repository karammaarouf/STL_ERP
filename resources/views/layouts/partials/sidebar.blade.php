<header class="main-nav">
    <div class="sidebar-user text-center"><a class="setting-primary" href="{{ route('profile.edit') }}"><i
                data-feather="settings"></i></a><img class="img-90 rounded-circle"
            src="{{ asset('assets/images/dashboard/1.png') }}" alt="">
        <div class="badge-bottom"><span class="badge badge-primary">{{ __('New') }}</span></div><a
            href="{{ route('profile.edit') }}">
            <h6 class="mt-3 f-14 f-w-600">{{ Auth::user()->name }}</h6>
        </a>
        <p class="mb-0 font-roboto">{{ __(Auth::user()->roles->first()->name) }}</p>

    </div>
    <nav>
        <div class="main-navbar">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>{{ __('Back') }}</span><i
                                class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
                    
                    <!-- القسم الرئيسي -->
                    <li class="sidebar-main-title">
                        <div>
                            <h6>{{ __('General') }}</h6>
                        </div>
                    </li>
                    
                    <!-- لوحة التحكم -->
                    <li class="dropdown">
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i data-feather="home"></i>
                            <span>{{ __('Dashboard') }}</span>
                        </a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="{{ route('dashboard') }}">{{ __('Main Dashboard') }}</a></li>
                            <li><a href="dashboard-02.html">{{ __('Ecommerce') }}</a></li>
                        </ul>
                    </li>

                    <!-- إدارة المستخدمين -->
                    <li class="dropdown">
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i data-feather="users"></i>
                            <span>{{ __('Users Management') }}</span>
                        </a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="{{ route('users.index') }}">{{ __('Users List') }}</a></li>
                            @can('create-user')
                                <li><a href="{{ route('users.create') }}">{{ __('Add New User') }}</a></li>
                            @endcan
                        </ul>
                    </li>

                    <!-- المناطق الجغرافية -->
                    <li class="dropdown">
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i class="icofont icofont-world"></i>
                            <span>{{ __('Geographical Areas') }}</span>
                        </a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="{{ route('locations.index') }}">{{ __('Locations Management') }}</a></li>
                            <li class="dropdown-divider"></li>
                            <li><a href="{{ route('countries.index') }}">{{ __('Countries List') }}</a></li>
                            <li><a href="{{ route('states.index') }}">{{ __('State List') }}</a></li>
                            <li><a href="{{ route('cities.index') }}">{{ __('Cities List') }}</a></li>
                        </ul>
                    </li>

                    <!-- إدارة المستودعات -->
                    <li class="dropdown">
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i class="fa fa-cubes"></i>
                            <span>{{ __('Warehouse Management') }}</span>
                        </a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="{{ route('warehouses.index') }}">{{ __('Warehouse List') }}</a></li>
                            <li><a href="{{ route('warehouse-zones.index') }}">{{ __('Warehouse Zones') }}</a></li>
                            <li><a href="{{ route('warehouse-sections.index') }}">{{ __('Warehouse Sections') }}</a></li>
                        </ul>
                    </li>

                    <!-- قسم الإعدادات -->
                    <li class="sidebar-main-title">
                        <div>
                            <h6>{{ __('Settings') }}</h6>
                        </div>
                    </li>

                    <!-- الملف الشخصي -->
                    <li>
                        <a class="nav-link" href="{{ route('profile.edit') }}">
                            <i data-feather="user"></i>
                            <span>{{ __('Profile') }}</span>
                        </a>
                    </li>

                    <!-- الإعدادات العامة -->
                    <li class="dropdown">
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i data-feather="settings"></i>
                            <span>{{ __('System Settings') }}</span>
                        </a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="#">{{ __('General Settings') }}</a></li>
                            <li><a href="#">{{ __('Permissions') }}</a></li>
                            <li><a href="#">{{ __('Roles') }}</a></li>
                        </ul>
                    </li>

                    <!-- تسجيل الخروج -->
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <a class="nav-link" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i data-feather="log-out"></i>
                                <span>{{ __('Logout') }}</span>
                            </a>
                        </form>
                    </li>

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>
