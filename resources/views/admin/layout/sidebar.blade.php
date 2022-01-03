<aside class="main-sidebar"> 
    <div class="sidebar"> 
        <div class="user-panel">
            <div class="image text-center"><img src="{{asset('assets/images/logo.png')}}"  alt="logo"> </div>
            <div class="info">
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="<?= Request::segment(2) == 'home' || Request::segment(2) == 'dashboard' ? 'active' : ''; ?>"> <a href="{{url('admin/home')}}">  <i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li> 
            @if(in_array(1,Session::get('admin_logged_in')['permissions']))
            <li> <a href="{{url('admin/user-management')}}"> <i class="fa fa-user"></i> <span>User Management</span> </a>  </li>
            @endif
            @if(in_array(2,Session::get('admin_logged_in')['permissions']))
            <li class="<?= Request::segment(2) == 'category-management' || Request::segment(2) == 'edit-category' ? 'active' : ''; ?>"> <a href="{{url('admin/category-management')}}"> <i class="fa fa-tasks"></i> <span>Category Management</span> </a> </li>
            @endif
            @if(in_array(3,Session::get('admin_logged_in')['permissions']))

            <li class="<?= Request::segment(2) == 'subcategory-management' || Request::segment(2) == 'edit-subcategory' ? 'active' : ''; ?>"> <a href="{{url('admin/subcategory-management')}}"> <i class="fa fa-tasks"></i> <span>Subcategory Management</span> </a> </li>
            @endif
            @if(in_array(4,Session::get('admin_logged_in')['permissions']))
            <li class="<?= Request::segment(2) == 'service-management' || Request::segment(2) == 'edit-service' || Request::segment(2) == 'service-detail' || Request::segment(2) == 'adds-service' ? 'active' : ''; ?>"> <a href="{{url('admin/service-management')}}"> <i class="fa fa-wrench"></i> <span>Service Management</span> </a> </li>
            @endif
            @if(in_array(5,Session::get('admin_logged_in')['permissions']))
            <li class="<?= Request::segment(2) == 'booking-request-management' || Request::segment(2) == 'booking-request-details' ? 'active' : '' ?>"> <a href="{{url('admin/booking-request-management')}}"> <i class="fa fa-legal"></i> <span>Booking Request Management</span> </a> </li>
            <li class="<?= Request::segment(2) == 'booking-management' || Request::segment(2) == 'booking-details' ? 'active' : '' ?>"> <a href="{{url('admin/booking-management')}}"> <i class="fa fa-handshake-o"></i> <span>Booking Management</span> </a> </li>
            <li class="<?= Request::segment(2) == 'booking-cancellation' ? 'active' : '' ?>"> <a href="{{url('admin/booking-cancellation')}}"> <i class="fa fa-times"></i> <span>Booking Cancellation</span> </a> </li>
            @endif
            @if(in_array(6,Session::get('admin_logged_in')['permissions']))
            <li class="treeview <?= Request::segment(2) == 'brand-management' || Request::segment(2) == 'car-management' || Request::segment(2) == 'model-management' ? 'menu-open' : '' ?>"> <a href="#"> <i class="fa fa-car"></i> <span>Cars Management</span><span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span></a>
                <ul class="treeview-menu" style="<?= Request::segment(2) == 'brand-management' || Request::segment(2) == 'car-management' || Request::segment(2) == 'model-management' ? 'display:block' : '' ?>"> 
                    <li class="<?= Request::segment(2) == 'brand-management' ? 'active' : '' ?>"><a href="{{url('admin/brand-management')}}"> Brand List</a></li>
                    <li class="<?= Request::segment(2) == 'car-management' ? 'active' : '' ?>"><a href="{{url('admin/car-management')}}"> Car List</a></li>
                    <li class="<?= Request::segment(2) == 'model-management' ? 'active' : '' ?>"><a href="{{url('admin/model-management')}}"> Model List</a></li>  
                </ul>
            </li>
            @endif
            @if(in_array(7,Session::get('admin_logged_in')['permissions']))
            <li class="<?= Request::segment(2) == 'subadmin-management' || Request::segment(2) == 'edit-subadmin' || Request::segment(2) == 'add-subadmin' || Request::segment(2) == 'subadmin-detail' ? 'active' : '' ?>"> <a href="{{url('admin/subadmin-management')}}"> <i class="fa fa-user"></i> <span>Sub Admin Management</span> </a>  </li>
            @endif
            @if(in_array(13,Session::get('admin_logged_in')['permissions']))
            <li class="<?= Request::segment(2) == 'branch-management' || Request::segment(2) == 'edit-branch' ? 'active' : '' ?>"> <a href="{{url('admin/branch-management')}}"> <i class="fa fa-users"></i> <span>Branch Management</span> </a> </li>
            @endif

            
            <li class="<?= Request::segment(2) == 'employee-management' || Request::segment(2) == 'edit-employee' ? 'active' : '' ?>"> <a href="{{url('admin/employee-management')}}"> <i class="fa fa-user-plus"></i> <span>Employee Management</span> </a> </li>
            

            @if(in_array(8,Session::get('admin_logged_in')['permissions']))
            <li class="<?= Request::segment(2) == 'help-n-support' || Request::segment(2) == 'help-n-support-detail' ? 'active' : '' ?>"> <a href="{{url('admin/help-n-support')}}"> <i class="fa fa-question-circle"></i> <span>Help & Support Management</span> </a>  </li>
            @endif
            @if(in_array(9,Session::get('admin_logged_in')['permissions']))
            <li class="<?= Request::segment(2) == 'content-management' || Request::segment(2) == 'edit-content' ? 'active' : '' ?>"> <a href="{{url('admin/content-management')}}"> <i class="fa fa-file"></i> <span>Content Management</span> </a>  </li>
            @endif
            @if(in_array(10,Session::get('admin_logged_in')['permissions']))
            <li class="<?= Request::segment(2) == 'payment-management' ? 'active' : '' ?>"> <a href="{{url('admin/payment-management')}}"> <i class="fa fa-money"></i> <span>Payment Management</span> </a>  </li>
            @endif
            @if(in_array(11,Session::get('admin_logged_in')['permissions']))
            <li class="<?= Request::segment(2) == 'offer-management' || Request::segment(2) == 'edit-offer' ? 'active' : '' ?>"> <a href="{{url('admin/offer-management')}}"> <i class="fa fa-gift"></i> <span>Offer Management</span> </a>  </li>
            @endif
            @if(in_array(12,Session::get('admin_logged_in')['permissions']))
            <li class="treeview <?= Request::segment(2) == 'support-reason-management' || Request::segment(2) == 'cancel-reason-management' ? 'menu-open' : '' ?>"> <a href="#"> <i class="fa fa-cog"></i> <span>Admin Settings</span><span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span></a>
                <ul class="treeview-menu" style="<?= Request::segment(2) == 'support-reason-management' || Request::segment(2) == 'cancel-reason-management' ? 'display:block' : '' ?>"> 
                    <li class="<?= Request::segment(2) == 'support-reason-management' ? 'active' : '' ?>"><a href="{{url('admin/support-reason-management')}}"> Support Reason</a></li>
                    <li class="<?= Request::segment(2) == 'cancel-reason-management' ? 'active' : '' ?>"><a href="{{url('admin/cancel-reason-management')}}"> Cancellation Reason</a></li>
                    <li class="<?= Request::segment(2) == 'charges-management' ? 'active' : '' ?>"><a href="{{url('admin/charges-management')}}"> Additional Charges</a></li>
                </ul>
            </li>
            @endif
        </ul>
    </div>
</aside>