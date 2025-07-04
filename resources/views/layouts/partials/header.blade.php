<div class="page-main-header">
    <div class="main-header-right row m-0">
      <div class="main-header-left">
        <div class="logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt=""></a></div>
        <div class="dark-logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid" src="{{ asset('assets/images/logo/dark-logo.png') }}" alt=""></a></div>
        <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle"></i></div>
      </div>
      <div class="left-menu-header col">
        <ul>
          <li>
            <form class="form-inline search-form">
              <div class="search-bg"><i class="fa fa-search"></i>
                <input class="form-control-plaintext" placeholder="{{ __('Search here...') }}">
              </div>
            </form><span class="d-sm-none mobile-search search-bg"><i class="fa fa-search"></i></span>
          </li>
        </ul>
      </div>
      <div class="nav-right col pull-right right-menu p-0">
        <ul class="nav-menus">
          <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
          <li class="onhover-dropdown">
            <div class="bookmark-box"><i data-feather="star"></i></div>
            <div class="bookmark-dropdown onhover-show-div">
              <div class="form-group mb-0">
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search"></i></span></div>
                  <input class="form-control" type="text" placeholder="{{ __('Search for bookmark...') }}">
                </div>
              </div>
              <ul class="m-t-5">
                <li class="add-to-bookmark"><i class="bookmark-icon" data-feather="inbox"></i>{{ __('Email') }}<span class="pull-right"><i data-feather="star"></i></span></li>
                <li class="add-to-bookmark"><i class="bookmark-icon" data-feather="message-square"></i>{{ __('Chat') }}<span class="pull-right"><i data-feather="star"></i></span></li>
                <li class="add-to-bookmark"><i class="bookmark-icon" data-feather="command"></i>{{ __('Feather Icon') }}<span class="pull-right"><i data-feather="star"></i></span></li>
                <li class="add-to-bookmark"><i class="bookmark-icon" data-feather="airplay"></i>{{ __('Widgets') }}<span class="pull-right"><i data-feather="star">   </i></span></li>
              </ul>
            </div>
          </li>
          <li class="onhover-dropdown">
            <div class="notification-box"><i data-feather="bell"></i><span class="dot-animated"></span></div>
            <ul class="notification-dropdown onhover-show-div">
              <li>
                <p class="f-w-700 mb-0">{{ __('You have 3 Notifications') }}<span class="pull-right badge badge-primary badge-pill">4</span></p>
              </li>
              <li class="noti-primary">
                <div class="media"><span class="notification-bg bg-light-primary"><i data-feather="activity"> </i></span>
                  <div class="media-body">
                    <p>{{ __('Delivery processing') }} </p><span>{{ __('10 minutes ago') }}</span>
                  </div>
                </div>
              </li>
              <li class="noti-secondary">
                <div class="media"><span class="notification-bg bg-light-secondary"><i data-feather="check-circle"> </i></span>
                  <div class="media-body">
                    <p>{{ __('Order Complete') }}</p><span>{{ __('1 hour ago') }}</span>
                  </div>
                </div>
              </li>
              <li class="noti-success">
                <div class="media"><span class="notification-bg bg-light-success"><i data-feather="file-text"> </i></span>
                  <div class="media-body">
                    <p>{{ __('Tickets Generated') }}</p><span>{{ __('3 hour ago') }}</span>
                  </div>
                </div>
              </li>
              <li class="noti-danger">
                <div class="media"><span class="notification-bg bg-light-danger"><i data-feather="user-check"> </i></span>
                  <div class="media-body">
                    <p>{{ __('Delivery Complete') }}</p><span>{{ __('6 hour ago') }}</span>
                  </div>
                </div>
              </li>
            </ul>
          </li>
          <li>
            <div class="mode"><i class="fa fa-moon-o"></i></div>
          </li>
          <li class="onhover-dropdown"><i data-feather="message-square"></i>
            <ul class="chat-dropdown onhover-show-div">
              <li>
                <div class="media"><img class="img-fluid rounded-circle me-3" src="{{ asset('assets/images/user/4.jpg') }}" alt="">
                  <div class="media-body"><span>{{ __('Ain Chavez') }}</span>
                    <p class="f-12 light-font">{{ __('Lorem Ipsum is simply dummy...') }}</p>
                  </div>
                  <p class="f-12">{{ __('32 mins ago') }}</p>
                </div>
              </li>
              <li>
                <div class="media"><img class="img-fluid rounded-circle me-3" src="{{ asset('assets/images/user/1.jpg') }}" alt="">
                  <div class="media-body"><span>{{ __('Erica Hughes') }}</span>
                    <p class="f-12 light-font">{{ __('Lorem Ipsum is simply dummy...') }}</p>
                  </div>
                  <p class="f-12">{{ __('58 mins ago') }}</p>
                </div>
              </li>
              <li>
                <div class="media"><img class="img-fluid rounded-circle me-3" src="{{ asset('assets/images/user/2.jpg') }}" alt="">
                  <div class="media-body"><span>{{ __('Kori Thomas') }}</span>
                    <p class="f-12 light-font">{{ __('Lorem Ipsum is simply dummy...') }}</p>
                  </div>
                  <p class="f-12">{{ __('1 hr ago') }}</p>
                </div>
              </li>
              <li class="text-center"> <a class="f-w-700" href="javascript:void(0)">{{ __('See All') }}     </a></li>
            </ul>
          </li>
          <li class="onhover-dropdown p-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-primary-light" type="submit"><i data-feather="log-out"></i>{{ __('Log out') }}</button>
            </form>
          </li>
        </ul>
      </div>
      <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
    </div>
  </div>