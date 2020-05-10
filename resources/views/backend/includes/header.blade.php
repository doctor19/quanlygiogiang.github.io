    <!-- Logo -->
    <!-- @include('notify::messages')
    @notifyJs -->
    @toastr_render
    <a href="{{route('dashboard')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <!-- <span class="logo-mini"><b>A</b>LT</span> -->
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Trang Chủ</b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" style="z-index:0">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- <img src="/dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
              <span class="hidden-xs">{{trans('labels.backend.common.hello')}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <div class="small-box" style="margin-bottom:0px;background: #3c8dbc;color:#fff">
                <div class="inner">
                  <h4>{{Auth::user()->name}}</h4>
                  <h6>{{Auth::user()->email}}</h6>
                </div>
                <div class="icon">
                  <i class="fa fa-user"></i>
                </div>
                <div class="small-box-footer">
                  <a href="{{route('mst_users.change_info',['id' => Auth::user()->id])}}" class="pull-left" style="color:#fff">
                    {{trans('labels.backend.users.changeinfo')}}<i class="fa fa-arrow-circle-right"></i>
                  </a>
                  <a href="{{route('mst_users.changepass')}}" style="color:#fff">
                    {{trans('labels.backend.users.changepass')}}<i class="fa fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <!-- <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Thông tin</a>
                </div> -->
                <div class="pull-right">
                  <a href="{{route('logout')}}" class="btn btn-danger btn-flat">Đăng xuất</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>