@extends('web.layout.master')
@section('content')

<!--Page Title-->
<section class="page-title" style="background-image:url(assetsFront/images/background/3.jpg)">
    <div class="auto-container text-center">
        <h2>Welcome to Car Registeration & Repairing</h2>
        <ul class="page-breadcrumb"> 
            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
        </ul>
    </div>
</section>
<!--End Page Title-->
<section class="services-section bg-white login-section">
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>Register</h2>  
            <div class="text">Have an account ? <a href="{{url('login')}}">Login</a> </div>
        </div>
        <div class="row">
            <div class="column col-lg-6 col-md-6 col-sm-12 offset-md-3"> 
                <!-- Login Form -->
                <div class="login-form login-form-car"> 
                    <p class='text-danger' id='error'></p>
                    <p class='text-success' id='success'></p>
                    <!--Login Form-->
                    <form id='registerForm'> 
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" placeholder="Name" class='mandatory characterOnly'> 
                            <p class='text-danger' id='nameError'></p>
                        </div> 
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="Email"> 
                            <p class='text-danger' id='emailError'></p>
                        </div>
                        <label>Phone Number</label>
                        <div class="form-inline">
                            <select class="select-number mandatory" name='country_code'>
                                <option value='966'>+966</option>
                                <option value='222'>+222</option>
                                <option value='91'>+91</option>
                            </select>
                            <input type="text" name="mobile_number" placeholder="Mobile Number" class="text-number mandatory numberOnly">
                            <p class='text-danger' id='mobile_numberError'></p>
                        </div>

                        <div class="form-group eyepassword">
                            <label>Password</label>
                            <input type="password" name="password" id="password" placeholder="Password" class='mandatory'>
                            <i class="fa fa-eye" onclick="showPassword(this, 'password');"></i>
                            <p class='text-danger' id='passwordError'></p>
                        </div>


                        <div class="form-group">
                            <button class="theme-btn btn-style-one text-white" onclick="register(this);" type="button" name="submit-form"><span class="btn-title">Continue</span></button>
                        </div>

                        <div class="form-group pass">
                            <p class="login-term">By logging in, you agree to our <a href="{{url('term-condition')}}"> Terms & Conditions</a> & <a href="{{url('privacy-policy')}}">Privacy Policy</a></p>                            
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
                                        register($('input[type=button]'));
                                        return false;    //<---- Add this line
                                    }
                                });
                            });
</script>
<script>
    function register(obj) {
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
            if ($(":input[name=email]").val() == "") {
                $(":input[name=email]").attr('disabled', 'true');
            }
            $.ajax({
                url: '<?= url('api/register') ?>',
                type: 'POST',
                data: $("#registerForm").serialize(),
                success: function (data) {
                    if (data.status == true && data.status_code == 200) {
                        $("#success").html(data.message);
                        $("#error").html("");
                        swal({
                            title: "Welcome!",
                            text: data.message,
                            icon: "success",
                            buttons: false,
//                            dangerMode: true,
                        });
                        setTimeout(function () {
                            location.replace('<?= url('verification') ?>?country=' + $(":input[name=country_code]").val() + '&mobile=' + $(":input[name=mobile_number]").val() + '&with=' + data.data.id);
                        }, 2000);
//                        console.log(data);
//                        location.replace('<?= url('verification') ?>?country=' + $(":input[name=country_code]").val() + '&mobile=' + $(":input[name=mobile_number]").val() + '&with=' + data.data.id);
                    } else {
                        errorReported(data);
                    }

                }
            });
        }
    }
</script>