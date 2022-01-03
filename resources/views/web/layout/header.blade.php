



<!--  Main Header-->

<header class="main-header header-style-three">

    <!--Header Top-->

    <div class="header-top">

        <div class="auto-container clearfix"> 



            <div class="top-right main-menu top-header-menu">

                <ul class="social-icon-one clearfix navigation">
                    <li class="dropdown"><a href="#"><i class="fa fa-language"></i></a> 

                        <ul class="language-dropdown">

                            <li><a href="#" class="select-lang"><img src="{{asset('assetsFront/images/eng.png')}}" class="language-iamge">English</a></li>

                            <li class="ml-0"><a href="#" class="select-lang"><img src="{{asset('assetsFront/images/uae.png')}}" class="language-iamge">عربى</a></li> 

                        </ul>

                    </li> 

                    <li><a href="#"><i class="fa fa-bell"></i></a></li>  
                    <li class="mr-0"><a href="{{url('my-account/my-cart')}}"><i class="fa fa-shopping-cart"></i></a></li>  


                </ul>

            </div>

        </div>

    </div>

    <!-- End Header Top -->

    <!--Header Lower-->

    <div class="header-lower">

        <div class="auto-container">

            <div class="main-box clearfix">

                <div class="pull-left logo-outer">

                    <!--  <div class="logo"><a href="#">Jadidly</a></div> -->
                    <div class="logo"><a href="{{url('home')}}"><img src="{{asset('assetsFront/images/logo_color.png')}}"></a> </div>

                </div>



                <!--Nav Box-->

                <div class="nav-outer clearfix">

                    <!--Mobile Navigation Toggler-->

                    <div class="mobile-nav-toggler"><span class="icon flaticon-menu"></span></div>



                    <!-- Main Menu -->

                    <nav class="main-menu navbar-expand-md navbar-light">

                        <div class="collapse navbar-collapse clearfix" id="navbarSupportedContent">

                            <ul class="navigation clearfix">

                                <li class="current dropdown"><a href="{{url('home')}}">Home</a> 

                                </li> 
                                <li class="dropdown"><a href="{{url('service')}}">Services</a> 
                                </li>


                                <li class="dropdown"><a href="{{url('my-account/my-cars')}}">Cars</a> 

                                </li>
                                <li class="dropdown"><a href="{{url('my-account/my-bookings')}}">My Booking</a> 

                                </li>

                                <li class="dropdown"><a href="{{url('offers')}}">Offers</a> 

                                </li>



                                <li class="dropdown"><a href="{{url('contact-us')}}">Contact Us</a> 

                                </li>

                                <?php $this->user_data=Session::get('login_info');if ($this->user_data) { ?>

                                    <li class="dropdown mr-0 profile-plus"> <a href="{{url('my-account/profile')}}"><img src="{{isset($this->user_data['image']) && $this->user_data['image'] ?$this->user_data['image']:asset('assetsFront/images/dummy.png')}}" class="profile-image"></a> 

                                        <ul class="profile-dropdown">

                                            <li><a href="{{url('my-account/profile')}}" class="select-lang">My Profile</a></li>

                                            <li class="ml-0"><a href="{{url('my-account/change-password')}}" class="select-lang">Change Password</a></li> 
                                            <li class="ml-0"><a onclick="logout(this);" class="select-lang">Logout</a></li> 

                                        </ul>

                                    </li> 
                                <?php } else { ?>
                                    <li class="dropdown mr-0"><a href="{{url('login')}}">Login</a> 

                                    </li> 
                                <?php } ?>

                            </ul>

                        </div>

                    </nav>

                    <!-- Main Menu End--> 

                </div>

            </div>

        </div>

    </div>

    <!--End Header Lower-->



    <!-- Sticky Header  -->

    <div class="sticky-header">

        <div class="auto-container clearfix">

            <!--Logo-->

            <div class="logo pull-left pt-4">

                <div class="logo"><a href="{{url('home')}}"><img src="{{asset('assetsFront/images/logo_color.png')}}"> </a></div>

            </div>

            <!--Right Col-->

            <div class="nav-outer pull-right">

                <!-- Main Menu -->

                <nav class="main-menu">

                    <div class="navbar-collapse show collapse clearfix">

                        <ul class="navigation clearfix"><!--Keep This Empty / Menu will come through Javascript--></ul>

                    </div>

                </nav><!-- Main Menu End-->

            </div>

        </div>

    </div><!-- End Sticky Menu -->





    <!-- Mobile Menu  -->

    <div class="mobile-menu">

        <div class="menu-backdrop"></div>

        <div class="close-btn"><span class="icon flaticon-cancel-1"></span></div>



        <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->

        <nav class="menu-box">

            <div class="nav-logo"><a href="#"><img src="{{asset('assetsFront/images/logo_color.png')}}" alt="" title=""></a></div>



            <ul class="navigation clearfix"><!--Keep This Empty / Menu will come through Javascript--></ul>

        </nav>

    </div><!-- End Mobile Menu -->

</header>              