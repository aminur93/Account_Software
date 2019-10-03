@auth
<div id="header" class="header navbar navbar-default navbar-fixed-top">
    <!-- begin container-fluid -->
    <div class="container-fluid">
        <!-- begin mobile sidebar expand / collapse button -->
        <div class="navbar-header">
            <a href="" class="navbar-brand"><span class="navbar-logo"></span> Purbachol</a>
            <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- end mobile sidebar expand / collapse button -->

        <!-- begin header navigation right -->
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
                    <i class="fa fa-bell-o"></i>
                    <span class="label">5</span>
                </a>
                <ul class="dropdown-menu media-list pull-right animated fadeInDown">
                    <li class="dropdown-header">Notifications (5)</li>
                    <li class="media">
                        <a href="javascript:;">
                            <div class="media-left"><i class="fa fa-bug media-object bg-red"></i></div>
                            <div class="media-body">
                                <h6 class="media-heading">Server Error Reports</h6>
                                <div class="text-muted f-s-11">3 minutes ago</div>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown navbar-user">
                <a href="" class="dropdown-toggle" data-toggle="dropdown">
                    @if(Auth::user()->image)
                        <img src="/uimage/{{ Auth::user()->image }}" />
                    @else
                        <img src="/assets/img/user-13.jpg" />
                    @endif
                    <span class="hidden-xs"></span> <b class="caret">{{Auth::user()->name}}</b>
                </a>
                <ul class="dropdown-menu animated fadeInLeft">
                    <li class="arrow"></li>
                    <li><a href="javascript:;">Edit Profile</a></li>
                    <li><a href="{{ route('user.password') }}">Setting</a></li>
                    <li class="divider"></li>
                    <li>
                      <a class="dropdown-item" href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          @csrf
                      </form>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- end header navigation right -->
    </div>
    <!-- end container-fluid -->
</div>
<!-- end #header -->
@endauth
