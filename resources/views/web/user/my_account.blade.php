@extends('web.layout.master')
@section('content')
<!--Page Title-->
<section class="page-title" style="background-image:url(<?=asset('assetsFront/images/background/3.jpg')?>)">
    <div class="auto-container text-center">
        <h2>My Profile</h2>
        <ul class="page-breadcrumb"> 
            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
        </ul>
    </div>
</section>
<!--End Page Title-->

<!-- Services Section -->
<section class="services-section bg-white profile-section">
    <div class="auto-container contact-section-two pt-0">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="icon-box text-center"><img id='userimage' src="{{$user['image']?$user['image']:asset('assetsFront/images/dummy.png')}}" class="img-circle"> <h4 class="text-black">User </h4></div> 

            </div> 
        </div>
        <div class="row">
            <!-- Service Block -->
            <div class="service-block col-lg-8 col-md-8 col-sm-12 offset-md-2"> 
                <div class="text-center mt-3">
                    <a href="{{url('/my-account/edit-profile')}}" class="theme-btn btn-style-one"><span class="btn-title">Edit Profile</span></a>
                    <a href="{{url('/my-account/change-password')}}" class="theme-btn btn-style-one"><span class="btn-title">Change Password</span></a>
                    <a href="{{url('/my-account/my-booking')}}" class="theme-btn btn-style-one"><span class="btn-title">My Booking</span></a>
                </div> 
            </div>
        </div>
        <div class="row"> 
            <div class="col-md-8 offset-md-2 text-center">
                <ul class="contact-info"> 
                    <li>
                        <span class="icon fa fa-phone"></span> 
                        <p><strong>Contact Number</strong></p>
                        <p><a id='mobile'>{{isset($user['country_code']) && isset($user['mobile_number']) && $user['country_code'] && $user['mobile_number']?'+'.$user['country_code'].' '.$user['mobile_number']:'N/A'}}</a></p> 
                    </li>

                    <li>
                        <span class="icon fa fa-envelope"></span> 
                        <p><strong>Email Id</strong></p>
                        <p><a id='email'>{{isset($user['email'])?$user['email']:'N/A'}}</a></p> 
                    </li> 
                </ul>  
            </div>
        </div>


    </div>
</section>
<!--End Services Section -->



@endsection
<script src="{{asset('assetsFront/js/jquery.js')}}"></script>
<script>
$(document).ready(function () {
    $.ajax({
        headers: {'Authorization': 'Bearer <?= $user['token'] ?>'},
        url: '<?= url('/api/profileDetail') ?>',
        type: 'GET',
        data: '',
        success: function (data) {
//            console.log(data);
            if (data.status == true && data.status_code == 200) {
                if (data.data.image) {
                    $("#userimage").attr('src', data.data.image);
                }
                var mobile_number = (data.data.mobile_number ? '+' + data.data.country_code + ' ' + data.data.mobile_number : '');
                $("#mobile").html(mobile_number);
                if (data.data.email) {
                    $("#email").html(data.data.email);
                }
            } else if (data.status_code == 401) {
                sessionExpired(data);
            }
        }
    });


});
</script>