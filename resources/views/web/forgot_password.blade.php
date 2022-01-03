@extends('web.layout.master')
@section('content')
<!--Page Title-->
<section class="page-title" style="background-image:url(assetsFront/images/background/3.jpg)">
    <div class="auto-container text-center">
        <h2>Forgot Password</h2>
        <ul class="page-breadcrumb"> 
            <li>Enter the phone no associated with your Car Registeration & Repairing  account. <br>We will send a verifcation OTP for creating a new password.</li>
        </ul>
    </div>
</section>
<!--End Page Title-->
<section class="services-section bg-white login-section">
    <div class="auto-container"> 
        <div class="row">
            <div class="column col-lg-6 col-md-6 col-sm-12 offset-md-3"> 
                <!-- Login Form -->
                <div class="login-form login-form-car"> 
                    <!--Login Form-->
                    <form id="forgotPassword"> 
                        <div class="login_type">
                            <label>Phone Number</label>
                            <div class="form-inline">
                                <select class="select-number mandatory" name="country_code">
                                    <option value='966'>+966</option>
                                    <option value='222'>+222</option>
                                    <option value='91'>+91</option>
                                </select>
                                <input type="text" name="mobile_number" placeholder=" " class="text-number mandatory numberOnly">
                                <p class='text-danger' id='country_codeError'></p>
                                <p class='text-danger' id='mobile_numberError'></p>
                            </div>
                        </div> 

                        <div class="form-group">

                            <button class="theme-btn btn-style-one text-white" type="button" onclick="sendOtp(this);" name="submit-form"><span class="btn-title">Send OTP on Mobile</span></button>
                        </div>
                    </form>
                    <h6 class="text-center mt-2 mb-2">Or</h6>
                    <form id="forgotPassword1"> 
                        <div class="login_type">
                            <div class="form-group eml">
                                <label class="eml">Email Address</label><input type="text" name="email" placeholder=" " class="mandatory1">
                                <p class="text-danger" id="emailError"></p>
                            </div>
                        </div> 

                        <div class="form-group">

                            <button class="theme-btn btn-style-one text-white" type="button" onclick="sendOtpEmail(this);" name="submit-form"><span class="btn-title">Send OTP on Email</span></button>
                        </div>
                        <p class='text-danger' id='error'></p>
                        <p class='text-success' id='success'></p>

                        <div class="form-group pass">
                            <p>
                                Go Back to <a href="{{url('login')}}">Login</a></p>        
                        </div>
                    </form>
                </div>
                <!--End Login Form -->
            </div>
        </div> 

    </div>
</section>
@endsection
<script src="{{asset('assetsFront/js/jquery.js')}}"></script>
<script>
                                $(document).ready(function () {
                                    $('.mandatory').keypress(function (e) {
                                        if (e.which == 13) {
                                            sendOtp($('input[type=button]'));
                                            return false;    //<---- Add this line
                                        }
                                    });
                                });
</script>
<script>
    function sendOtp(obj) {
        var flag = true;
        $(".mandatory").each(function (i, v) {
            var elem = $(this);
            var valu = elem.val();
            if (valu == null || valu == '' || valu == 0) {
                flag = false;
                $("#" + elem.attr('name') + 'Error').html('This field is required.');
            } else {
                $("#" + elem.attr('name') + 'Error').html('');
            }
        });

        if (flag) {
            $.ajax({
                url: '<?= url('/api/forgotPassword') ?>',
                type: 'POST',
                data: $("#forgotPassword").serialize() + '&type=2',
                success: function (data) {
                    if (data.status == true && data.status_code == 200) {
                        $("#error").html("");
                        $("#success").html(data.message);
                        window.location.href = '<?= url('/verify') ?>?country=' + $(":input[name=country_code]").val() + '&mobile=' + $(":input[name=mobile_number]").val() + '&with=' + data.data.user_id;
                    } else {
                        errorReported(data);
                    }
                }
            });
        }

    }

    function sendOtpEmail(obj) {
        var flag = true;
        $(".mandatory1").each(function (i, v) {
            var elem = $(this);
            var valu = elem.val();
            if (valu == null || valu == '' || valu == 0) {
                flag = false;
                $("#" + elem.attr('name') + 'Error').html('This field is required.');
            } else {
                $("#" + elem.attr('name') + 'Error').html('');
            }
        });

        if (flag) {
            $.ajax({
                url: '<?= url('/api/forgotPassword') ?>',
                type: 'POST',
                data: $("#forgotPassword1").serialize() + '&type=1',
                success: function (data) {
                    if (data.status == true && data.status_code == 200) {
                        $("#error").html("");
                        $("#success").html(data.message);
                        window.location.href = '<?= url('/verify') ?>?email=' + $(":input[name=email]").val() + '&with=' + data.data.user_id;
                    } else {
                        errorReported(data);
                    }
                }
            });
        }

    }
</script>