@extends('web.layout.master')
@section('content')
<section class="services-section register-renew login-section">
    <div class="auto-container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="row">
                    <div class="col-md-5">
                        <div class="sec-title mb-3">
                            <h2>Get in touch!</h2>   
                        </div>
                        <form id="queryForm">
                            <div class="row">
                                <div class="col-md-12"> 
                                    <input type="text" name="name" placeholder="Name" class="form-control mandatory">  
                                    <p id="nameError" class="text-danger"></p>
                                </div>
                                <div class="col-md-12 mt-4"> 
                                    <input type="text" name="email" placeholder="Email Address" class="form-control mandatory">  
                                    <p id="emailError" class="text-danger"></p>
                                </div>
                            </div>
                            <div class="row mt-4 pb-4"> 
                                <div class="col-md-12"> 
                                    <select class="form-control mandatory" name='subject' id="subjects">
                                        <option value=''>Select Subject</option>
                                    </select>
                                    <p id="subjectError" class="text-danger"></p>
                                </div>
                                <div class="col-md-12 mt-4"> 
                                    <textarea cols="6" rows="6" name="details" maxlength="200" class="form-control mandatory" placeholder="Message"></textarea> 
                                    <p id="detailsError" class="text-danger"></p>
                                    <label class="text-white">* All fields are required.</label>
                                </div>
                            </div>    

                            <div class="form-group mt-2">
                                <button class="theme-btn btn-style-one w-100" type="button" name="submit-form" onclick="sendQuery(this)"><span class="btn-title">Submit</span></button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-7 border-left pl-4 col-12">
                        <div class="sec-title mb-2">
                            <h2>Address & Directions</h2>  
                            <p class="text-white mb-2">Renew My Car Registration</p>
                            <a href="#">jadidly123@gmail.com</a> 
                            <p>8am to 11PM,7 Days a Week</p>
                        </div>
                        <div class="row">
                            <div class="col-md-12"> 
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.129290966581!2d77.3752745151445!3d28.62588689113235!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce48911f00007%3A0xfa5ca415b2c01868!2sTechGropse%20Pvt.%20Ltd%20%7C%20Web%20%26%20Mobile%20App%20Development%20%7C%20Digital%20Marketing%20Services!5e0!3m2!1sen!2sin!4v1591942630561!5m2!1sen!2sin" height="380" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>  
                            </div> 
                        </div>    

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<script src="{{asset('assetsFront/js/jquery.js')}}"></script>
<script>

                                    $(document).ready(function () {
                                        $.ajax({
                                            url: '<?= url('/api/subjectList') ?>',
                                            type: 'GET',
                                            data: '',
                                            success: function (data) {
                                                if (data.status == true && data.status_code == 200) {
                                                    if (data.data.length > 0) {
//                    $("#subjects").empty();
                                                        var subjects = data.data;
                                                        $(subjects).each(function (i, subject) {
                                                            var html = '<option value="' + subject.id + '">' + subject.subject + '</option>';
                                                            $("#subjects").append(html);
                                                        });
                                                    }
                                                }
                                            }
                                        });
                                    });
                                    function sendQuery(obj) {
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
                                                headers: {'Authorization': 'Bearer <?= isset(Session::get('login_info')['token'])?Session::get('login_info')['token']:'' ?>'},
                                                url: '<?= url('api/contactUs') ?>',
                                                type: 'POST',
                                                data: $("#queryForm").serialize(),
                                                success: function (data) {
                                                    if (data.status == true && data.status_code == 200) {
                                                        $("#success").html(data.message);
                                                        $("#error").html("");
                                                        swal({
                                                            title: "Query Submitted!",
                                                            text: data.message,
                                                            icon: "success"
                                                        });
                                                        setTimeout(function () {
                                                            location.reload();
                                                        }, 2000);
                                                    } else {
                                                        errorReported(data);
                                                    }

                                                }
                                            });
                                        }
                                    }



                                    function addMoreImage(obj) {
                                        var allImage = $(".image:visible");
                                        if (allImage.length == 5) {
                                            $(obj).hide();
                                        }
                                        var c = (parseInt(allImage.length) + 1);
                                        $("#img" + c).css('display', 'block');
                                    }
</script>