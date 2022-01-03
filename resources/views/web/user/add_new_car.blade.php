@extends('web.layout.master')
@section('content')
<style>
    .car_img{
        width: 130px;
        height: 100px;
        margin-bottom: 10px;
        /*background-color: #fff;*/
        border: 2px solid #393940;
    }

    img{
        height:100%;
    }

    .confirm-booking-icon {
        font-size: 15px!important;
        background: #2601a3;
        width: 25px;
        height: 25px;
        border-radius: 100%;
        color: white;
        line-height: 25px!important;
        margin-bottom: 20px;
    }
</style>
<section class="services-section register-renew login-section ">
    <div class="auto-container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="sec-title text-center">
                    <h2>Add New Car</h2>   
                </div>
                <form id="carForm">
                    <div class="row">
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label class="text-white">Car Brand</label>
                                
                                <select class="form-control mandatory" id="brand" name="brand_id" onchange="fetchCarList(this, 1)">
                                <option value="" >Select Brand</option> 
                                </select> 
                                <p class="text-danger" id="brand_idError"></p>
                            </div>
                        </div>
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label class="text-white">Car Name</label>
                                <select class="form-control mandatory" name="car_id" id="car_name" onchange="fetchCarList(this, 2)">
                                    <option value="">Select Name</option>
                                </select> 
                                <p class="text-danger" id="car_idError"></p>
                            </div>
                        </div> 
                    </div>
                    <div class="row mt-4 pb-4">
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label class="text-white">Model</label>
                                <select class="form-control mandatory" name="model_id" id="model">
                                    <option value="">Select Model</option>
                                </select> 
                                <p class="text-danger" id="model_idError"></p>
                            </div>
                        </div>
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label class="text-white">Model Year</label>
                                <input name="model_year" id="model_year" class="form-control mandatory" placeholder="Model Year">
                                <p class="text-danger" id="model_yearError"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 pb-4">
                        <div class="col-md-2 image" id="img1"> 
                            <div class="car_img text-center">
                                <label for="carimg1"><img id="image1" src="{{asset('/assetsFront/images/cars/car_dummy.png')}}"></label>
                                <input type="file" accept="image/*" id="carimg1" name="files[]" hidden onchange="readURL(this, '1')">
                            </div>
                        </div>
                        <div class="col-md-2 image" id="img2" style='display:none'> 
                            <div class="car_img text-center">
                                <label for="carimg2"><img id="image2" src="{{asset('/assetsFront/images/cars/car_dummy.png')}}"></label>
                                <input type="file" accept="image/*" id="carimg2" name="files[]" hidden onchange="readURL(this, '2')">
                            </div>
                        </div>
                        <div class="col-md-2 image"  id="img3" style='display:none'> 
                            <div class="car_img text-center">
                                <label for="carimg3"><img id="image3" src="{{asset('/assetsFront/images/cars/car_dummy.png')}}"></label>
                                <input type="file" accept="image/*" id="carimg3" name="files[]" hidden onchange="readURL(this, '3')">
                            </div>
                        </div>
                        <div class="col-md-2 image" id="img4" style='display:none'> 
                            <div class="car_img text-center">
                                <label for="carimg4"><img id="image4" src="{{asset('/assetsFront/images/cars/car_dummy.png')}}"></label>
                                <input type="file" accept="image/*" id="carimg4" hidden name="files[]" onchange="readURL(this, '4')">
                            </div>
                        </div>
                        <div class="col-md-2 image" id="img5" style='display:none'> 
                            <div class="car_img text-center">
                                <label for="carimg5"><img id="image5" src="{{asset('/assetsFront/images/cars/car_dummy.png')}}"></label>
                                <input type="file" accept="image/*" id="carimg5" hidden name="files[]" onchange="readURL(this, '5')">
                            </div>
                        </div>
                        <div class="col-md-2 image" id="img6" style='display:none'> 
                            <div class="car_img text-center">
                                <label for="carimg6"><img id="image6" src="{{asset('/assetsFront/images/cars/car_dummy.png')}}"></label>
                                <input type="file" accept="image/*" id="carimg6" hidden name="files[]" onchange="readURL(this, '6')">
                            </div>
                        </div>
                        <div class="col-md-2 text-center" > 
                            <div class="body-message" style="margin: auto;">
                                <a style="float: left;" href="#addmore" onclick="addMoreImage(this);"><i class="fa fa-plus confirm-booking-icon"></i></a>
                            </div>
                        </div>
                    </div>


                    <div class="form-group mt-4">
                        <button class="theme-btn btn-style-one w-100" type="button" onclick="addCar(this);" name="submit-form"><span class="btn-title">Submit</span></button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
@endsection
<script src="{{asset('assetsFront/js/jquery.js')}}"></script>
<script>
                            var carlist = new Array();
                            $(document).ready(function () {
                                $.ajax({
                                    url: '<?= url('/api/adminSettings') ?>',
                                    type: 'GET',
                                    data: '',
                                    success: function (data) {
                                        if (data.status == true && data.status_code == 200) {
                                            if (data.data.brand_list.length > 0) {
                                                $("#brand").empty();
                                                var brands = data.data.brand_list;
                                                carlist = brands;
                                                $(brands).each(function (i, brand) {

                                                    var cars = brand.cars;
                                                    $('#brand').append('<option hidden >Select Brand</option>');
                                                   var html = '<option value="' + brand.id + '">'+ brand.brand_name + '</option>';

                                                    if (i == 0) {
                                                        $("#car_name").empty();
                                                        if (cars.length > 0) {
                                                            $(cars).each(function (j, car) {
                                                                $('#car_name').append('<option hidden >Select Car Varient</option>');
                                                                var carhtml = '<option value="' + car.id + '">'  + car.car_name + '</option>';
                                                                var models = car.car_models;
                                                                $("#car_name").append(carhtml);
                                                                if (j == 0) {
                                                                    $("#model").empty();
                                                                    if (models.length > 0) {
                                                                        $(models).each(function (k, model) {
                                                                            $('#model').append('<option value="" hidden >Select Car Model</option>');
                                                                            var modelhtml = '<option value="' + model.id + '">' + model.model_name + '</option>';
                                                                            $("#model").append(modelhtml);
                                                                        });
                                                                    } else {
                                                                        var modelhtml = '<option value="" selected disabled>No models</option>';
                                                                        $("#model").append(modelhtml);
                                                                        $("#model").removeClass('mandatory');
                                                                    }
                                                                }
                                                            });

                                                        }
                                                    }

                                                    if (cars.length > 0) {
                                                        $("#brand").append(html);
                                                    }
                                                });
                                            }
                                        }
                                    }
                                });
                            });
                            function addCar(obj) {
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
                                var myForm = $("#carForm")[0];
                                var formData = new FormData(myForm);
                                if (flag) {
                                    $.ajax({
                                        headers: {'Authorization': 'Bearer <?= Session::get('login_info')['token'] ?>'},
                                        url: '<?= url('api/addCar') ?>',
                                        type: 'POST',
//                                        data: $("#carForm").serialize(),
                                        enctype: 'multipart/form-data',
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        cache: false,
                                        success: function (data) {
                                            if (data.status == true && data.status_code == 200) {
                                                $("#success").html(data.message);
                                                $("#error").html("");
//                                                console.log(data);
//                                                location.replace("<?= url('/my-account/my-cars') ?>");

                                                swal({
                                                    title: "Car Added!",
                                                    text: data.message,
                                                    icon: "success",
                                                    buttons: false,
                                                });
                                                setTimeout(function () {
                                                    location.replace("<?= url('/my-account/my-cars') ?>");
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

                            function fetchCarList(obj, type) {
                                if (type == 1) {
                                    var brand_id = $(obj).val();
                                    $(carlist).each(function (i, brand) {

                                        if (brand.id == brand_id) {
                                            $("#car_name").empty();
                                            $("#model").empty();
                                            var cars = brand.cars;

                                            if (cars.length > 0) {
                                                $(cars).each(function (j, car) {
                                                    var carhtml = '<option value="' + car.id + '">' + car.car_name + '</option>';
                                                    var models = car.car_models;
                                                    $("#car_name").append(carhtml);
                                                    if (j == 0) {
                                                        if (models.length > 0) {
                                                            $("#model").addClass('mandatory');
                                                            $(models).each(function (k, model) {
                                                                var modelhtml = '<option value="' + model.id + '">' + model.model_name + '</option>';
                                                                $("#model").append(modelhtml);
                                                            });
                                                        } else {
                                                            var modelhtml = '<option value="" selected disabled>No models</option>';
                                                            $("#model").append(modelhtml);
                                                            $("#model").removeClass('mandatory');
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                    });
                                } else {
                                    var brand_id = $("#brand").val();
                                    var car_id = $("#car_name").val();
                                    $(carlist).each(function (i, brand) {

                                        if (brand.id == brand_id) {
//                                            $("#car_name").empty();
                                            $("#model").empty();
                                            var cars = brand.cars;
//                                            if (cars.length > 0) {
                                            $(cars).each(function (j, car) {
                                                if (car.id == car_id) {
//                                                        var carhtml = '<option value="' + car.id + '">' + car.car_name + '</option>';
                                                    var models = car.car_models;
//                                                        $("#car_name").append(carhtml);
//                                                        if (j == 0) {
                                                    if (models.length > 0) {
                                                        $("#model").addClass('mandatory');
                                                        $(models).each(function (k, model) {
                                                            var modelhtml = '<option value="' + model.id + '">' + model.model_name + '</option>';
                                                            $("#model").append(modelhtml);
                                                        });
                                                    } else {
                                                        var modelhtml = '<option value="" selected disabled>No models</option>';
                                                        $("#model").append(modelhtml);
                                                        $("#model").removeClass('mandatory');
                                                    }
//                                                        }
                                                }
                                            });
//                                            }
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