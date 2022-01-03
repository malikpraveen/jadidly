@extends('web.layout.master')
@section('content')
<style>
    /* NOTE: The styles were added inline because Prefixfree needs access to your styles and they must be inlined if they are on local disk! */
    @import url(http://fonts.googleapis.com/css?family=Open+Sans:400,300,700);
    body {
        background: #2A2A34;
    }

    .radio-group {
        width: 249px;
        display: table;
        table-layout: fixed;
        border-spacing: 0;
        border-collapse: separate;
        margin: auto;
    }

    .radio-group__label {
        display: table-cell;
        height: 28px;
        padding: 5px;
        vertical-align: middle;
        text-align: center;
        position: relative;
        border: 1px solid #2601a3;
        border-style: solid none solid solid;
        border-radius: 7px 0 0 7px;
        color: #2601a3;
        -moz-transition: border 250ms, color 250ms;
        -o-transition: border 250ms, color 250ms;
        -webkit-transition: border 250ms, color 250ms;
        transition: border 250ms, color 250ms;
        cursor: pointer;
    }

    .radio-group__label + input + .radio-group__label {
        border-radius: 0 7px 7px 0;
        border-style: solid solid solid none;
    }

    .radio-group__label + input + .radio-group__label:before {
        content: " ";
        display: block;
        position: absolute;
        top: 0px;
        width: 100%;
        height: 100%;
        /*border: 1px solid #4012fb;*/
        border-radius: 5px 0 0 5px;
        transform: translate3d(-103%, 0, 0);
        transition: all 250ms;
    }

    .radio-group__label + input:checked + .radio-group__label:before {
        border-radius: 0 7px 7px 0;
        transform: translate3d(-5px, 0, 0);
    }

    .radio-group__option:checked + label {
        color: #fff;
        background-color: #2601a3;
    }

    .radio-group__option {
        display: none;
    }

    
</style>
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
            <h2>Login</h2> 
            <div class="text">Don't have an account ? <a href="{{url('registration')}}">Register</a> </div>
        </div>
        <div class="row">
            <div class="column col-lg-6 col-md-6 col-sm-12 offset-md-3"> 
                <!-- Login Form -->
                <div class="login-form login-form-car"> 


                    <!--Login Form-->
                    


                    <form id='loginForm'>  
                        <div class="radio-group mb-4">
                            <input id="opt_1" class="radio-group__option" type="radio" name="type" checked="checked" value="2">
                            <label class="radio-group__label" for="opt_1">
                                mobile login
                            </label>

                            <input id="opt_2" class="radio-group__option" type="radio" name="type" value="1">
                            <label class="radio-group__label" for="opt_2">
                                email login
                            </label>
                        </div>
                        <div class="login_type">
                            <label class="phn">Phone Number</label>
                            <div class="form-inline phn">
                                <select class="select-number" name='country_code'>
                                    <option value='966'>+966</option>
                                    <option value='222'>+222</option>
                                    <option value='91'>+91</option>
                                </select>
                                <input type="text" name="mobile_number" placeholder=" " class="text-number numberOnly mandatory">
                                <p class='text-danger' id='mobile_numberError'></p>
                            </div>

                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class='mandatory' placeholder="Password">
                            <p class='text-danger' id='passwordError'></p>
                        </div>

                        <div class="form-group">
                            <a href="{{url('forgot-password')}}">Forgot Password ?</a>
                        </div>
                        <p class='text-danger' id='error'></p>
                        <p class='text-success' id='success'></p>
                        <div class="form-group">
                            <button class="theme-btn btn-style-one text-white" onclick='login(this);' type="button" name="submit-form"><span class="btn-title">LOGIN</span></button>
                        </div>

                        <div class="form-group pass">
                            <p class="login-term">By logging in, you agree to our <a href="{{url('terms-n-conditions')}}"> Terms & Conditions</a> & <a href="{{url('privacy-policy')}}">Privacy Policy</a></p>                            
                        </div>
                    </form>
                    <hr>
                    <div class="row">
                         <div class="col-md-12 text-center mt-1 mb-3"> 
                            <h6>Or</h6>
                        </div>
                        <div class="col-md-12">
                            <label>Continue with :</label>
                            
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-danger text-white"><i class="fa fa-google-plus"></i> google</button>
                   
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary text-white"><i class="fa fa-facebook-f"></i> facebook</button>
                       
                        </div>
                       
                    </div>
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
                                            login($('input[type=button]'));
                                            return false;    //<---- Add this line
                                        }
                                    });

                                    $(".radio-group__option").change(updateLog);
                                });
</script>
<script>
    function login(obj) {
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
        var login_type = $(":input[name=type]:checked").val();
        if (flag) {
            $.ajax({
                url: '<?= url('api/login') ?>',
                type: 'POST',
                data: $("#loginForm").serialize(),
                success: function (data) {
                    if (data.status == true && data.status_code == 200) {
                        $("#success").html(data.message);
                        $("#error").html("");
                        var sendData = {"user_id": data.data.id, "name": data.data.name, "image": data.data.image, "country_code": data.data.country_code, "mobile_number": data.data.mobile_number, "email": data.data.email, "token": data.data.token};
                        setSessionKeys(sendData);
                        location.replace('<?= url('home') ?>');
                    } else if (data.status == true && data.status_code == 201) {
                        $("#error").html(data.message);
                        if (login_type == 2) {
                            window.location.href = '<?= url('verification') ?>?country=' + $(":input[name=country_code]").val() + '&mobile=' + $(":input[name=mobile_number]").val() + '&with=' + data.data.user_id;
                        } else {
                            window.location.href = '<?= url('verification') ?>?email=' + $(":input[name=email]").val() + '&with=' + data.data.user_id;
                        }
                    } else {
                        errorReported(data);
                    }

                }
            });
        }
    }

    function updateLog() {
        var login_type = $(":input[name=type]:checked").val();
        $(".login_type").empty();
        var html = "";
        if (login_type == 1) {
            html = '<div class="form-group eml"><label class="eml">Email Address</label><input type="text" name="email" placeholder=" " class="mandatory"><p class="text-danger" id="emailError"></p></div>';
        } else {
            html = '<label class="phn">Phone Number</label>' +
                    '<div class="form-inline phn">' +
                    '<select class="select-number" name="country_code">' +
                    "<option value='966'>+966</option>" +
                    "<option value='222'>+222</option>" +
                    "<option value='91'>+91</option>" +
                    "</select>" +
                    '<input type="text" name="mobile_number" placeholder=" " class="text-number numberOnly mandatory">' +
                    "<p class='text-danger' id='mobile_numberError'></p>" +
                    "</div>";
        }
        $(".login_type").append(html);
    }


</script>