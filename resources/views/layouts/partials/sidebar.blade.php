<header class="main-nav">
    <div class="sidebar-user text-center"><a class="setting-primary" href="javascript:void(0)"><i
                data-feather="settings"></i></a><img class="img-90 rounded-circle"
            src="{{ asset('assets/images/dashboard/1.png') }}" alt="">
        <div class="badge-bottom"><span class="badge badge-primary">{{ __('New') }}</span></div><a
            href="{{ route('profile.edit') }}">
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
                        <div class="mobile-back text-end"><span>{{ __('Back') }}</span><i
                                class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>{{ __('General') }}</h6>
                        </div>
                    </li>
                    <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i
                                data-feather="home"></i><span>{{ __('Dashboard') }}</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="dashboard-02.html">{{ __('Ecommerce') }}</a></li>
                        </ul>
                    </li>
                    <li><a class="nav-link title" href="{{ route('users.index') }}"> <i data-feather="users"></i>
                            <span>{{ __('Users') }}</span></a>
                        <ul class="nav-submenu menu-content">
                        </ul>
                    </li>
                    <li class="dropdown">
                        {{-- تم تعديل الرابط الرئيسي هنا لمنع إعادة التحميل والسماح بفتح القائمة --}}
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i class="icofont icofont-world"></i>
                            <span>{{ __('Geographical Areas') }}</span>
                        </a>
                        <ul class="nav-submenu menu-content">
                            {{-- رابط جديد لصفحة الإدارة الموحدة --}}
                            <li><a href="{{ route('locations.index') }}">{{ __('Locations Management') }}</a></li>
                            <hr class="mt-1 mb-1" />
                            <li><a href="{{ route('countries.index') }}">{{ __('Countries List') }}</a></li>
                            <li><a href="{{ route('states.index') }}">{{ __('State List') }}</a></li>
                            <li><a href="{{ route('cities.index') }}">{{ __('Cities List') }}</a></li>
                        </ul>
                    </li>

                    <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)">
                            <i class="fa fa-cubes"></i> <span>{{ __('Warehouse') }}</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="{{ route('warehouses.index') }}">{{ __('Warehouse List') }}</a></li>
                            <li><a href="{{ route('warehouse-zones.index') }}">{{ __('Warehouse Zones') }}</a></li>
                        </ul>
                    </li>


                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>
