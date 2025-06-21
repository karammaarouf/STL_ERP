<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    @include('layouts.partials.head')
</head>

<body class="rtl">
    @include('layouts.partials.messages')
    <!-- Loader starts-->
    @include('layouts.partials.loader')
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        @include('layouts.partials.header')
        <!-- Page Header Ends                              -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper horizontal-menu">
            <!-- Page Sidebar Start-->
            @include('layouts.partials.sidebar')
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                @include('layouts.partials.container_header')
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
        </div>
    </div>
    @include('layouts.partials.scripts')
</body>

</html>
