@extends('web.layout.master')
@section('content')
<!--Page Title-->
<section class="page-title" style="background-image:url(<?= asset('assetsFront/images/background/3.jpg') ?>)">
    <div class="auto-container text-center">
        <h2>Edit Profile</h2>
        <ul class="page-breadcrumb"> 
            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
        </ul>
    </div>
</section>
<!--End Page Title-->

<!-- Services Section -->
<section class="services-section bg-white">
    <div class="auto-container"> 
        <div class="contact-form-two"> 
            <form id="profileForm" method="post" enctype="multipart/form-data">
                <div class="row clearfix">
                    <div class="col-md-4 offset-md-4 form-group">
                        <div class="user-img1 text-center">
                            <img class="imgUp" src="{{$user['image']?$user['image']:asset('assetsFront/images/dummy.png')}}">
                            <i class="fa fa-camera" onclick="$('#imgLable').click();"></i>
                            <label id="imgLable" for="profileImg"></label>
                            <input type="file" hidden="" name="image" id="profileImg" accept="image/*" class="uploadFile">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 form-group offset-md-3">
                        <input type="text" name="name" class="mandatory" placeholder="Name" required="" value="{{$user['name']}}">
                        <p class='text-danger' id='nameError'></p>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 form-group offset-md-3">
                        <input type="email" name="email" placeholder="Email" readonly="readonly" value='{{isset($user['email'])?$user['email']:''}}'>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 form-group offset-md-3">
                        <input type="text" class="numberOnly mandatory" readonly="readonly" name="country_code" placeholder="Mobile Number" required="" value="{{isset($user['country_code']) && $user['country_code']?$user['country_code']:''}}">
<!--                        <select class="select-number mandatory" readonly="readonly" name='country_code'>
                            <option value='' selected disabled="">Select Country</option>
                            <option value='<?= $user['country_code'] ?>' <?= isset($user['country_code']) && $user['country_code'] ? 'selected' : '' ?>><?= '+' . $user['country_code'] ?></option>
                            <option value='222' <?= isset($user['country_code']) && ($user['country_code'] == '222') ? 'selected' : '' ?>>+222</option>
                            <option value='91' <?= isset($user['country_code']) && ($user['country_code'] == '91') ? 'selected' : '' ?>>+91</option>
                        </select>-->
                        <p class='text-danger' id='country_codeError'></p>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 form-group">
                        <input type="text" class="numberOnly mandatory" readonly="readonly" name="mobile_number" placeholder="Mobile Number" required="" value="{{isset($user['mobile_number']) && $user['mobile_number']?$user['mobile_number']:''}}">
                        <p class='text-danger' id='mobile_numberError'></p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 form-group offset-md-3">
                        <p class='text-danger' id='error'></p>
                        <button class="theme-btn btn-style-one w-100" type="button" name="submit-form" onclick="updateProfile(this);"><span class="btn-title">Update</span></button>
                    </div>
                </div> 
            </form>
        </div>

    </div>
</section>
<!--End Services Section -->

@endsection

<script>
    function updateProfile(obj) {
        var myForm = $("#profileForm")[0];
        var formData = new FormData(myForm);
//        formData.append('name', $(":input[name=name]").val());
//        formData.append('country_code', $(":input[name=country_code]").val());
//        formData.append('mobile_number', $(":input[name=mobile_number]").val());
//        formData.append('image', $("#profileImg")[0].files[0]);
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
                url: '<?= url('/api/updateProfile') ?>',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    if (data.status == true && data.status_code == 200) {
                        $("#error").html("");
                        var sendData = {"user_id": "<?= $user['user_id'] ?>", "name": data.data.name, "image": data.data.image, "country_code": data.data.country_code, "mobile_number": data.data.mobile_number, "email": data.data.email, "token": "<?= $user['token'] ?>"};
                        setSessionKeys(sendData);
                        swal({
                            title: data.message,
                            text: "Your profile has been updated successfully",
                            icon: "success",
                            buttons: false,
                        });
                        setTimeout(function () {
                            window.location.href = "<?= url('/my-account/profile') ?>";
                        }, 2000);

//                        window.location.href = "<?= url('/my-account/profile') ?>";
                    } else if (data.status_code == 401) {
                         sessionExpired(data);
                    } else {
                         errorReported(data);
                    }
                }
            });
        }
    }
</script>