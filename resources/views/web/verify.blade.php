@extends('web.layout.master')
@section('content')
<style>
    .resetSection{
        display:none;
    }
</style>
<!--Page Title-->
<section class="page-title" style="background-image:url(assetsFront/images/background/3.jpg)">
    <div class="auto-container text-center">
        <h2>Verify the OTP & Reset Your Password</h2>
        <ul class="page-breadcrumb"> 
            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
        </ul>
    </div>
</section>
<!--End Page Title-->
<section class="services-section bg-white login-section">
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>Verification & Reset Password</h2>  
        </div>
        <div class="row">
            <div class="column col-lg-6 col-md-6 col-sm-12 offset-md-3"> 
                <!-- Login Form -->
                <div class="login-form login-form-car"> 
                    <!--Login Form-->
                    <form id="validationform">  
                        <p class='text-danger' id='error'></p><p class='text-success' id='success'></p>
                        <div class="form-group verifySection">
                            <label>Enter OTP</label>
                            <input type="text" id="otp" class="mandatory1" name="otp" placeholder="test: 111111">
                            <p class='text-danger' id='otpError'></p>
                        </div>
                        <div class="form-group verifySection">
                            <div class="btn-box">
                                <a href="#otp" class="theme-btn btn-style-one" onclick="resend(this);"><span class="btn-title">Resend OTP</span></a>
                                <a href="#otp" class="theme-btn btn-style-one pull-right" onclick="validate(this);"><span class="btn-title">Verify OTP</span></a>
                            </div>
                        </div>
                        <div class="form-group resetSection">
                            <label>Enter New Password</label>
                            <div class="eyepassword">
                                <input type="password" class="mandatory" name="new_password" id="new_password">
                                <i class="fa fa-eye-slash" onclick="showPassword(this, 'new_password')"></i>
                                <p class='text-danger' id='new_passwordError'></p>
                            </div>
                        </div>
                        <div class="form-group resetSection">
                            <label>Confirm Password</label>
                            <div class="eyepassword">
                                <input type="password" class="mandatory" name="confirm_password" id="confirm_password">
                                <i class="fa fa-eye-slash" onclick="showPassword(this, 'confirm_password')"></i>
                                <p class='text-danger' id='confirm_passwordError'></p>
                            </div>
                        </div>


                        <div class="form-group resetSection">
                            <button class="theme-btn btn-style-one text-white" type="button" onclick="resetPassword();" name="submit-form"><span class="btn-title">Submit</span></button>
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
                                    $('.mandatory1').keypress(function (e) {
                                        if (e.which == 13) {
                                            validate($('input[type=button]'));
                                            return false;    //<---- Add this line
                                        }
                                    });
                                });
</script>
<script>

    function validate(obj) {
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
                url: '<?= url('api/otp') ?>',
                type: 'POST',
                data: 'user_id=' +<?= $_GET['with'] ?> + '&' + $("#validationform").serialize(),
                success: function (data) {
                    if (data.status == true && data.status_code == 200) {
//                        $("#success").html(data.message);
                        $("#error").html("");
                        swal({
                            title: "Verification Successful",
                            text: data.message,
                            icon: "success",
                            timer: 2000,
                            buttons: false
                        });
                        setTimeout(function () {
                            $(".verifySection").css('display', 'none');
                            $(".resetSection").css('display', 'block');
                        }, 2000);

//                        $("#success").html("Reset password");
                    } else {
                        errorReported(data);
                    }

                }
            });
        }
    }

    function resend(obj) {
        var type = '<?= isset($_GET['country']) ? 2 : 1 ?>';
        if (type == 2) {
            var send_data = 'type=2&country_code=<?= isset($_GET['country']) && $_GET['country'] ? $_GET['country'] : '' ?>&mobile_number=<?= isset($_GET['mobile']) && $_GET['mobile'] ? $_GET['mobile'] : '' ?>';
        } else {
            var send_data = 'type=1&email=<?= isset($_GET['email']) && $_GET['email'] ? $_GET['email'] : '' ?>';
        }
        $.ajax({
            url: '<?= url('api/forgotPassword') ?>',
            type: 'POST',
            data: send_data,
            success: function (data) {
                if (data.status == true && data.status_code == 200) {
                    $("#success").html(data.message);
                    $("#error").html("");
                } else {
                    errorReported(data);
                }

            }
        });
    }

    function resetPassword(obj) {
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
                url: '<?= url('api/updatePassword') ?>',
                type: 'POST',
                data: 'user_id=' +<?= $_GET['with'] ?> + '&' + $("#validationform").serialize(),
                success: function (data) {
//                    console.log(data);
                    if (data.status == true && data.status_code == 200) {
                        $("#success").html(data.message);
                        $("#error").html("");
                        swal({
                            title: "Password Updated!",
                            text: data.message,
                            icon: "success"
                        });
                        setTimeout(function () {
                            location.replace('<?= url('login') ?>');
                        }, 2000);
//                        location.replace('<?= url('login') ?>');
                    } else {
                        errorReported(data);
                    }

                }
            });
        }
    }
</script> 