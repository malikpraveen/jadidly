<header class="main-header">  
            <nav class="navbar blue-bg navbar-static-top"> 
              <ul class="nav navbar-nav pull-left">
                <li><a class="sidebar-toggle" data-toggle="push-menu" href=""></a> </li>
              </ul>
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                  <li class="dropdown user user-menu p-ph-res"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="{{asset('assets/images/user.png')}}" class="user-image" alt="User Image"> <span class="hidden-xs">{{Session::get('admin_logged_in')['name']}}</span> </a>
                    <ul class="dropdown-menu">
                 <!--    <li><a href="{{url('change-password')}}"><i class="fa fa-lock"></i> Change password</a></li> -->
                      <li><a href="{{url('/admin/logout')}}"><i class="fa fa-sign-out"></i> Logout</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </nav>
          </header>