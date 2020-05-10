
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('dist/img/UTT.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Danh mục chức năng</li>
          <li class="active">
            <a href="{{route('dashboard')}}">
              <i class="fa fa-pie-chart"></i> <span>{{trans('labels.backend.dashboard.title')}}</span>
            </a>
          </li>
          @if(Auth::user()->role == 2)
            <li class="treeview">
              <a href="#">
                <i class="fa fa-calendar"></i> <span>{{trans('labels.backend.mst_mission.title')}}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{route('mst_mission.index')}}"><i class="fa fa-circle-o"></i>{{trans('labels.backend.common.list')}}</a></li>
                <li><a href="{{route('mst_mission.add')}}"><i class="fa fa-circle-o"></i>{{trans('labels.backend.common.add')}}</a></li>
              </ul>
            </li>
          @endif
          @if(Auth::user()->role == 1 || Auth::user()->role == 2)
            <li class="treeview">
                <a href="#">
                  <i class="fa fa-book"></i> <span>{{trans('labels.backend.mst_term.title')}}</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="{{route('mst_term.index')}}"><i class="fa fa-circle-o"></i>{{trans('labels.backend.common.list')}}</a></li>
                </ul>
            </li>
          @endif
          @if(Auth::user()->role == 1)
            <li class="treeview">
              <a href="#">
                <i class="fa fa-reorder"></i> <span>{{trans('labels.backend.mst_position.title')}}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{route('mst_position.index')}}"><i class="fa fa-circle-o"></i>{{trans('labels.backend.common.list')}}</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-sellsy"></i> <span>{{trans('labels.backend.mst_title.title')}}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{route('mst_title.index')}}"><i class="fa fa-circle-o"></i>{{trans('labels.backend.common.list')}}</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-users"></i> <span>{{trans('labels.backend.mst_class.title')}}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{route('mst_class.index')}}"><i class="fa fa-circle-o"></i>{{trans('labels.backend.common.list')}}</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-calendar-o"></i> <span>{{trans('labels.backend.mst_semester.title')}}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{route('mst_semester.index')}}"><i class="fa fa-circle-o"></i>{{trans('labels.backend.common.list')}}</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-building"></i> <span>{{trans('labels.backend.mst_unit.title')}}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{route('mst_unit.index')}}"><i class="fa fa-circle-o"></i>{{trans('labels.backend.common.list')}}</a></li>
              </ul>
            </li>
            <li class="treeview mst-users">
              <a href="#">
                <i class="fa fa-user"></i> <span>{{trans('labels.backend.users.title')}}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="mst-users"><a href="{{route('mst_users.index')}}"><i class="fa fa-circle-o"></i>{{trans('labels.backend.common.list')}}</a></li>
                <li class="add-user"><a href="{{route('mst_users.add')}}"><i class="fa fa-circle-o"></i>{{trans('labels.backend.common.add')}}</a></li>
              </ul>
            </li>
          @endif
      </ul>
    </section>