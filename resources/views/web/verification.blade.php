@extends('web.layout.master')
@section('content')
<!--Page Title-->
<section class="page-title" style="background-image:url(assetsFront/images/background/3.jpg)">
    <div class="auto-container text-center">
        <h2>Authentication</h2>
        <ul class="page-breadcrumb"> 
            <li>
                @if(isset($_GET['country']) && $_GET['mobile'])
                We've sent an OTP to the phone +{{$_GET['country'].' '.$_GET['mobile']}}. Please enter it <br>below to complete verification
                @else
                @if(isset($_GET['email']))
                We've sent an OTP to the email address  {{$_GET['email']}}. Please enter it <br>below to complete verification
                @endif
                @endif
            </li>
        </ul>
    </div>
</section>
<!--End Page Title-->
<section class="services-section bg-white login-section">
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>Verification</h2>  
        </div>
        <div class="row">
            <div class="column col-lg-6 col-md-6 col-sm-12 offset-3"> 
                <!-- Login Form -->
                <div class="login-form login-form-car"> 
                    <!--Login Form-->
                    <form id="validationform">  
                        <p class="text-danger" id="error"></p>
                        <p class="text-success" id="success"></p>
                        <div class="form-group">
                            <label>Enter OTP</label>
                            <input type="text" name="otp" placeholder="test: 111111"  class="mandatory numberOnly"/>
                            <p class="text-danger" id="otpError"></p>
                        </div> 

                        <div class="form-group">
                            <button class="theme-btn btn-style-one" type="button" onclick="validate(this);" name="submit-form"><span class="btn-title">Verify</span></button>
                        </div>
                        <div class="form-group pass"><a href="#" onclick="resend(this);">Resend OTP</a></div>

                    </form>
                </div>
                <!--End Login Form -->
            </div>
        </div> 

    </div>
</section>
<script src="{{asset('assetsFront/js/jquery.js')}}"></script>
<script>
                            $(document).ready(function () {
                                $('.mandatory').keypress(function (e) {
                                    if (e.which == 13) {
                                        validate($('input[type=button]'));
                                        return false;    //<---- Add this line
                                    }
                                });
                            });
</script>
@endsection

<script>
    function validate(obj) {
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
                url: '<?= url('api/otp') ?>',
                type: 'POST',
                data: 'user_id=' +<?= $_GET['with'] ?> + '&device_type=web&type=registration&' + $("#validationform").serialize(),
                success: function (data) {
                    if (data.status == true && data.status_code == 200) {
                        $("#success").html(data.message);
                        $("#error").html("");
                        var sendData = {"user_id": data.data.id, "name": data.data.name, "image": data.data.image, "country_code": data.data.country_code, "mobile_number": data.data.mobile_number, "email": data.data.email, "token": data.data.token};
                        setSessionKeys(sendData);
                        swal({
                            title: data.message,
                            text: data.message,
                            icon: "success"
                        });
                        setTimeout(function () {
                            location.replace('<?= url('home') ?>');
                        }, 2000);
//                        console.log(data);
//                        location.replace('<?= url('home') ?>');
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
</script>