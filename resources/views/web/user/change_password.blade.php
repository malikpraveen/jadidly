@extends('web.layout.master')
@section('content')
<section class="page-title" style="background-image:url(<?= asset('assetsFront/images/background/3.jpg') ?>)">
    <div class="auto-container text-center">
        <h2>Change Password</h2>
        <ul class="page-breadcrumb">
            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
        </ul>
    </div>
</section>
<!--End Page Title-->
<section class="services-section bg-white">
    <div class="auto-container">
        <div class="contact-form-two">
            <form id="changePassword">
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-12 form-group offset-md-3">
                        <div class="eyepassword">
                            <input type="password" placeholder="Current Password" name="current_password" required="" class="mandatory">
                            <p class='text-danger' id='current_passwordError'></p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 form-group offset-md-3">
                        <div class="eyepassword">
                            <input type="password" placeholder="New Password" name="new_password" required="" class="mandatory">
                            <p class='text-danger' id='new_passwordError'></p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 form-group offset-md-3">
                        <div class="eyepassword">
                            <input type="password" name="confirm_password" class="mandatory"  id="password" placeholder="Confirm Password" required=""> <i class="fa fa-eye-slash" onclick="showPassword(this, 'password')"></i>
                            <p class='text-danger' id='confirm_passwordError'></p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 form-group offset-md-3">
                        <p class='text-danger' id='error'></p>
                        <button class="theme-btn btn-style-one w-100" type="button" onclick="changePassword(this);" name="submit-form"><span class="btn-title">Save</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
<script>
    function changePassword(obj) {
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
                headers: {'Authorization': 'Bearer <?= $user['token'] ?>'},
                url: '<?= url('/api/changePassword') ?>',
                type: 'POST',
                data: $("#changePassword").serialize(),
                success: function (data) {
                    if (data.status == true && data.status_code == 200) {
                        $("#error").html("");
                        swal({
                            title: data.message,
                            text: "Your password has been updated successfully",
                            icon: "success",
                            buttons: false,
//                            dangerMode: true,
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 2000);

                    } else if (data.status_code == 401) {
//                        logoutUser(this);
                        sessionExpired(data);
                    } else {
                        errorReported(data);
                    }
                }
            });
        }
    }
</script>