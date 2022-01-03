@extends('web.layout.master')
@section('content')
<style>
    img{
        height: 150px;
    }


</style>
<style>
    .car_img{
        width: 130px;
        height: 100px;
        margin-bottom: 10px;
        /*background-color: #fff;*/
        border: 2px solid #393940;
    }
    /*
        img{
            height:100%;
        }*/

    .confirm-booking-icon {
        font-size: 30px!important;
        background: #2601a3;
        width: 50px;
        height: 50px;
        border-radius: 100%;
        color: white;
        line-height: 50px!important;
        margin-bottom: 20px;
    }
</style>

<!--Page Title-->
<section class="page-title" style="background-image:url(<?= asset('assetsFront/images/background/3.jpg') ?>)">
    <div class="auto-container text-center">
        <h2>Car Details</h2>
        <ul class="page-breadcrumb"> 
            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
        </ul>
    </div>
</section>
<!--End Page Title-->
<section class="about-us style-two service-background pb-0">


    <div class="auto-container">
        <div class="row clearfix">
            <!-- Content Column -->
            <div class="content-column col-lg-12 col-md-12 col-sm-12 order-2 content-side">
                <div class="inner-column">  
                    <div class="our-shop">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <a href="{{url('/my-account/add-car')}}" class="theme-btn btn-style-one pt-2 pb-2">Add New Car</a>
                            </div>
                            <div class="col-md-6">
                                <input type="search" name="" placeholder="Search" class="form-control">
                            </div>
                        </div>
                        <div class="row clearfix" id="carsDiv">
                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                <p>No cars found</p>
                            </div>
                            <!-- Product Block -->
                            <!--                            <div class="product-block col-lg-3 col-md-6 col-sm-12">
                                                            <div class="inner-box">
                                                                <div class="image-box">
                                                                    <figure class="image"><a href="#"><img src="/images/cars/1.jpg" alt=""></a></figure>
                                                                    <div class="btn-box">
                                                                        <a href="#"><span class="fa fa-edit"></span></a>
                                                                        <a href="#" class="dlt-car"><span class="fa fa-trash"></span></a>
                                                                    </div> 
                                                                </div>
                                                                <div class="content-box text-left">
                                                                    <h5><a href="#">Lamborghini</a></h5>
                            
                                                                    <div class="price">Vema SX(o) 16 CRDI</div>  
                            
                                                                    <p class="carbrand"><span>Lamborghini </span><span class="ml-3">2019</span></p> 
                                                                </div>
                                                            </div>
                                                        </div>-->
                        </div>

                        <!--Styled Pagination-->
                        <!--                        <ul class="styled-pagination text-center">
                                                    <li><a href="#" class="active">1</a></li>
                                                    <li><a href="#">2</a></li>
                                                    <li><a href="#">3</a></li>
                                                    <li><a href="#"><span class="fa fa-angle-right"></span></a></li>
                                                </ul>                -->
                        <!--End Styled Pagination-->
                    </div> 

                </div>
            </div>

        </div>
    </div>
</section>
<div class="modal bs-example-modal-new checkout-modal" style='background-color: #eeeeeea3;' data-keyboard='false' data-backdrop='static' id="successModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <!-- Modal Content: begins -->
        <div class="modal-content">

            <!-- Modal Header -->

            <div class="modal-header border-bottom-0">
                <h4>Edit Car</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>

            <!-- Modal Body -->  
            <div class="modal-body text-center">
                <div class="body-message">

                    <form id="carForm">
                        <p class='text-danger' id='error'></p>
                        <p class='text-success' id='success'></p>
                        <div class="row">
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label class="text-white">Car Brand</label>
                                    <select class="form-control mandatory" id="brand" name="brand_id" onchange="fetchCarList(this, 1)">
                                        <option value="">Select Brand</option>
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
                        <div class="row">
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
                        <div class="row text-left carimg">

                        </div>
                        <div class="row addcarimg">

                        </div>
                        <div class="form-group mt-4">
                            <input name="user_car_id" id="user_car_id" class="form-control" hidden value="0">
                            <input name="remove_image" id="remove_image" class="form-control" hidden value="0">
                            <button class="theme-btn btn-style-one w-100" type="button" onclick="updateCar(this);" name="submit-form"><span class="btn-title">Save Changes</span></button>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-top-0 text-center"> 
            </div>

        </div>
        <!-- Modal Content: ends -->

    </div>

</div>

<script src="{{asset('assetsFront/js/jquery.js')}}"></script>
<script>
                                var ispickup = 0;
                                var car_array = new Array();
                                var carlist = new Array();
                                var removeImage = new Array();
                                $(document).ready(function () {
                                    $.ajax({
                                        headers: {'Authorization': 'Bearer <?= $user['token'] ?>'},
                                        url: '<?= url('/api/myCars') ?>',
                                        type: 'GET',
                                        data: '',
                                        success: function (data) {
//            console.log(data);
                                            if (data.status == true && data.status_code == 200) {
                                                if (data.data.length > 0) {
                                                    car_array = data.data;
                                                    $("#carsDiv").empty();
                                                    $(data.data).each(function (i, car) {
                                                        var image;
                                                        if (car.images.length > 0) {
                                                            image = car.images[0]['file_path'];
                                                        } else {
                                                            image = car.brand_image;
                                                        }
                                                        var html = '<div class="product-block col-lg-3 col-md-6 col-sm-12">' +
                                                                '<div class="inner-box">' +
                                                                ' <div class="image-box">' +
                                                                ' <figure class="image"><a href="#"><img src="' + image + '" alt=""></a></figure>' +
                                                                '<div class="btn-box">' +
                                                                '<a href="#edit" onclick="editCar(' + car.id + ');"><span class="fa fa-edit"></span></a>' +
                                                                '<a href="#delete" onclick="deleteCar(this,' + car.id + ');" class="dlt-car"><span class="fa fa-trash"></span></a>' +
                                                                '</div> ' +
                                                                '</div>' +
                                                                ' <div class="content-box text-left pb-2">' +
                                                                '<h5><a href="#">' + car.brand_name + '</a></h5>' +
                                                                '<div class="price">' + car.car_name + '</div>  ' +
                                                                '<p class="carbrand"><span>' + car.model_name + ' </span><span class="ml-3">' + car.model_year + '</span></p> ' +
//                                                            '<a href="#" class="btn btn-primary w-100 mt-2">Select Car</a>' +
                                                                ' </div>' +
                                                                '</div>' +
                                                                '</div>';
                                                        $("#carsDiv").append(html);
                                                    });
                                                }
                                            } else if (data.status_code == 401) {
//                        logoutUser(this);
                                                sessionExpired(data);
                                            }
                                        }
                                    });

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
                                                        var html = '<option value="' + brand.id + '">' + brand.brand_name + '</option>';

                                                        if (i == 0) {
                                                            $("#car_name").empty();
                                                            if (cars.length > 0) {
                                                                $(cars).each(function (j, car) {
                                                                    var carhtml = '<option value="' + car.id + '">' + car.car_name + '</option>';
                                                                    var models = car.car_models;
                                                                    $("#car_name").append(carhtml);
                                                                    if (j == 0) {
                                                                        $("#model").empty();
                                                                        if (models.length > 0) {
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

                                                        if (cars.length > 0) {
                                                            $("#brand").append(html);
                                                        }
                                                    });
                                                }
                                            }
                                        }
                                    });
                                });


                                function deleteCar(obj, car_id) {
                                    var conf = confirm('Are you sure to delete this car?');
                                   
                                    if (conf) {
                                        $.ajax({
                                            headers: {'Authorization': 'Bearer <?= $user['token'] ?>'},
                                            url: '<?= url('/api/deleteCar') ?>',
                                            type: 'POST',
                                            data: 'user_car_id=' + car_id,
                                            success: function (data) {
                                                if (data.status == true && data.status_code == 200) {
                                                    $(obj).closest(".product-block").hide();
                                                    swal({
                                                        title: "Car Deleted!",
                                                        text: data.message,
                                                        icon: "success",
                                                        buttons: false,
                                                    });
                                                    setTimeout(function () {
                                                        location.reload();
                                                    }, 2000);
                                                } else {
                                                    errorReported(data);
                                                }
                                            }
                                        });
                                    } else {
                                        return false;
                                    }
                                }



                                function removeThisImage(obj, id) {
                                    var cnf = confirm('Are you sure to remove this image');
                                    if (cnf) {
                                        $(obj).closest(".imageDiv").remove();
                                        removeImage.push(id);
                                        var k = $(obj).attr('data-count');
                                        var html = '<div class="col-md-6 mb-2 image" id="img' + k + '">' +
                                                '<div class=" text-center">' +
                                                '<label for="carimg' + k + '"><img id="image' + k + '" src="<?= asset('/assetsFront/images/cars/car_dummy.png') ?>"></label>' +
                                                '<input type="file" accept="image/*" class="form-control" id="carimg' + k + '" name="files[]" onchange="readURL(this, ' + k + ')">' +
                                                '</div>' +
                                                '</div>';
                                        $(".addcarimg").append(html);
                                        $("#remove_image").val(toString(removeImage));
                                    }
                                }

                                function editCar(car) {
                                    $(car_array).each(function (i, c) {
                                        if (c.id == car) {
                                            var editcar = c;
                                            var images = c.images;

                                            $("#brand").val(editcar.brand_id);
                                            fetchCarList($("#brand"), 1);
                                            $("#car_name").val(editcar.car_id);
                                            $("#model").val(editcar.model_id);
                                            $("#model_year").val(editcar.model_year);
                                            $("#user_car_id").val(car);
                                            for (var j = 0, k = 1; j <= 5, k <= 6; j++, k++) {
                                                var html = "";
                                                var image_name = "";
                                                if (images[j]) {
                                                    var image = images[j]['file_path'].split('/');
                                                    image_name = image[image.length - 1];
                                                    html = '<div class="col-md-6 mb-2 imageDiv"><a href="' + images[j]['file_path'] + '" target="_blank"><img id="image' + k + '" src="' + images[j]['file_path'] + '"> ' + image_name + '</a><i class="fa fa-times text-danger" data-count="' + k + '" onclick="removeThisImage(this,' + images[j]['id'] + ');"></i></div>';
                                                    $(".carimg").append(html);
                                                } else {
                                                    html = '<div class="col-md-6 mb-2 image" id="img' + k + '">' +
                                                            '<div class=" text-center">' +
                                                            '<label for="carimg' + k + '"><img id="image' + k + '" src="<?= asset('/assetsFront/images/cars/car_dummy.png') ?>"></label>' +
                                                            '<input type="file" accept="image/*" class="form-control" id="carimg' + k + '" name="files[]" onchange="readURL(this, ' + k + ')">' +
                                                            '</div>' +
                                                            '</div>';
                                                    $(".addcarimg").append(html);
                                                }

                                            }
                                        }
                                    });
                                    $("#successModal").modal();
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


                                function updateCar(obj) {
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
                                            url: '<?= url('api/editCar') ?>',
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
//                        console.log(data);
                                                    swal({
                                                        title: "Details Updated!",
                                                        text: data.message,
                                                        icon: "success",
                                                        buttons: false,
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



</script>
@endsection
