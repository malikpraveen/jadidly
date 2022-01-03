@extends('web.layout.master')
@section('content')
<style>
    .pickup{
        display:none
    }
    #carsDiv img{
        height: 150px;
    }
</style>
<!--Page Title-->
<section class="page-title" style="background-image:url(<?= asset('assetsFront/images/background/3.jpg') ?>)">
    <div class="auto-container text-center">
        <h2>Checkout</h2>
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
                                <h3 class="text-dark">Select car</h3>
                            </div>
                            <!--                            <div class="col-md-6">
                                                            <input type="search" name="" placeholder="Search" class="form-control">
                                                        </div>-->
                        </div>

                        <div class="row clearfix"  id="carsDiv">
                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                <a href="{{url('/my-account/add-car')}}" class="theme-btn btn-style-one">Add Car</a>
                            </div>
                            <!--                                                        <div class="product-block col-lg-3 col-md-6 col-sm-12">
                                                                                        <div class="inner-box">
                                                                                            <div class="image-box">
                                                                                                <figure class="image"><a href="#"><img src="{{asset('assetsFront/images/cars/1.jpg')}}" alt=""></a></figure>
                                                                                                <div class="btn-box">
                                                                                                    <a href="#"><span class="fa fa-edit"></span></a>
                                                                                                    <a href="#" class="dlt-car"><span class="fa fa-trash"></span></a>
                                                                                                </div> 
                                                                                            </div>
                                                                                            <div class="content-box text-left pb-2">
                                                                                                <h5><a href="#">Lamborghini</a></h5>
                                                        
                                                                                                <div class="price">Vema SX(o) 16 CRDI</div>  
                                                        
                                                                                                <p class="carbrand"><span>Lamborghini </span><span class="ml-3">2019</span></p> 
                                                                                                <a href="#" class="btn btn-primary w-100 mt-2">Select Car</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>-->

                        </div>
                        <input type="hidden" name="user_car_id" id="car_id" class="mandatory" value="0">
                        <p class="text-danger" id="user_car_idError"></p>

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


<section class="cart-section pb-0" style="padding-top: 30px;">
    <div class="auto-container">   
        <div class="row">
            <div class="column pull-left col-lg-12 col-md-12 col-sm-12">
                <div class="shipping-block">
                    <div class="inner-box p-0 border-0"> 
                        <h3 class='pickup'>Pickup Available Add Address</h3> 
                        <!-- Shipping Form -->
                        <div class="shipping-form  mt-3 mb-4 pickup">
                            <!--Shipping Form-->
                            <!--<form >-->
                            <div class="row clearfix">
                                <div class="form-group col-md-6 col-sm-12 location">
                                    <i class="fa fa-map-marker"></i>
                                    <input type="text" name="pickup_location" placeholder="Pickup Location" required="">
                                    <p class="text-danger" id="pickup_locationError"></p>
                                </div>

                                <div class="form-group col-md-6 col-sm-12 location"> 
                                    <input type="text" name="dropoff_location" placeholder="Drop Location" required="">
                                    <i class="fa fa-map-marker"></i>
                                    <p class="text-danger" id="dropoff_locationError"></p>
                                </div> 

                            </div>
                            <!--</form>-->

                            <label for="firstName1"><input type="checkbox" value="1" name="is_pickup" onchange="setPickupLoc(this);"> No need of pickup</label>
                        </div>
                        <!-- Shipping Form -->
                        <div class="shipping-form  mt-3 mb-4">
                            <!--Shipping Form-->
                            <form>
                                <div class="row clearfix">
                                    <div class="col-md-4 col-sm-12">
                                        <h3 class="mb-3">Appointment Date</h3> 

                                        <input type="date" name="date" id="date" min="<?= date('Y-m-d') ?>" placeholder="Number" onchange="getBranchList(this);" class="form-control type-number mandatory" style="width: 100%;">
                                        <!--</select>-->
                                        <p class="text-danger" id="dateError"></p>
                                        <!--<input type="time" name="time" id="time" placeholder="Number" class="form-control type-number mandatory" style="width: 30%">-->


                                    </div> 
                                    <div class="form-group col-md-8 col-sm-12">
                                        <h3 class="mb-3">Select Branch & Time</h3> 
                                        <div class="form-inline"> 
                                            <select class="form-control select-number w-100 mandatory" name="branch_id" id="branch_list" onchange="getTimeSlots(this);" style="width: 70% !important;">
                                                <option selected disabled>Select Branch</option>
                                            </select> 
                                            <select class="form-control select-number w-100 mandatory" name="time" id="time" style="width: 30% !important;">
                                                <option selected disabled>Select Time</option>
                                            </select>
                                            <p class="text-danger" id="timeError"></p>
                                        </div> 
                                    </div>

                                    <!--                                    <div class="form-group col-md-12 col-sm-12 text-center">
                                                                            <a href="#" class="theme-btn btn-style-one">Continue</a>
                                                                        </div>  -->
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div> 
        </div>
    </div>
</section>
<!--Cart Section-->
<section class="cart-section pt-0">
    <div class="auto-container">  
        <div class="row payment">
            <div class="col-md-6 col-lg-8">
                <ul class="totals-table">
                    <li><h3>Payment Information</h3></li>
                    <li class="clearfix total"><span class="col">Total Service Cost</span><span class="col price" id='total_cost'>0 KWD</span></li>

                    <li class="clearfix total"><span class="col">Discount</span><span class="col price text-danger" id='discount'>0 KWD</span></li>
                    <li class="clearfix total" id="pickingCharge"><span class="col">Pickup & Dropoff charges</span><span class="col price" id='pickup'>0 KWD</span></li>
                    <!--<li class="clearfix total"><span class="col">Tax</span><span class="col price" id="tax">0 KWD</span></li>-->
                    <li class="clearfix total"><span class="col">Total Cost</span><span class="col price text-blue" id='total'>0 KWD</span></li>
                </ul> 
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="payment-box payment-select">
                    <div class="upper-box border-bottom-0">
                        <!--Payment Options-->
                        <div class="payment-options">
                            <ul>  
                                <li class="cash-payment">
                                    <div class="radio-option">
                                        <input type="radio" name="method" id="payment-3" value="cash" checked="">
                                        <label for="payment-3"><strong>Cash on Delivery</strong></label>
                                    </div>
                                </li>
                                <li class="online-payment">
                                    <div class="radio-option">
                                        <input type="radio" name="method" id="payment-4" value="online">
                                        <label for="payment-4"><strong>Online</strong> </label> 
                                    </div>
                                </li>
                            </ul>
                            <p class="text-danger" id="methodError"></p>
                        </div>
                    </div>
                    <div class="lower-box text-center">
                        <a href="#book" class="theme-btn btn-style-one w-100" onclick="bookService(this);"><span class="btn-title">Book</span></a>

                        <!--<a href="#" class="theme-btn btn-style-one w-100" data-toggle="modal" data-target=".bs-example-modal-new"><span class="btn-title">Book</span></a>-->
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>



<div class="modal bs-example-modal-new checkout-modal" id="successModal" style='background-color: #eeeeeea3;' data-keyboard='false' data-backdrop='static'tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <!-- Modal Content: begins -->
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header border-bottom-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.replace('<?= url('my-account/my-bookings') ?>');"> <span aria-hidden="true">&times;</span></button>

            </div>

            <!-- Modal Body -->  
            <div class="modal-body text-center">
                <div class="body-message">
                    <a href="#"><i class="fa fa-check confirm-booking-icon"></i></a>

                    <h4 class="text-dark">Thanks for Booking</h4>
                    <p>Our Service provider will contact you soon</p>
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
                    var offer_id = 0;
                    var count = 0;
                    var total_amount = 0;
                    var pickup_charge = 0;
                    $(document).ready(function () {
                        $.ajax({
                            headers: {'Authorization': 'Bearer <?= Session::get('login_info')['token'] ?>'},
                            url: '<?= url('/api/myCart') ?>',
                            type: 'GET',
                            data: '',
                            success: function (data) {
                                if (data.status == true && data.status_code == 200) {
                                    $("#total_cost").html(data.data.total_cost + ' KWD');
                                    $("#discount").html((data.data.total_discount > 0 ? data.data.total_discount + ' KWD' : data.data.total_discount + ' KWD'));
                                    $("#total").html(data.data.total_paybale_amount + ' KWD');
//                                    $("#tax").html(data.data.tax + ' KWD');
                                    $("#pickup").html(data.data.pickup_charges + ' KWD');
                                    $("#service_count").html(data.data.service_count);
                                    total_amount = data.data.total_paybale_amount;
                                    pickup_charge = data.data.pickup_charges;
                                    count = data.data.service_count;
                                    offer_id = data.data.offer_id;
                                    if (data.data.services.length > 0) {
                                        $("#serviceDiv").empty();
                                        var service_list = data.data.services;
                                        $(service_list).each(function (i, service) {
                                            if (service.is_pickup == 1) {
                                                ispickup = 1;
                                                $(".pickup").css('display', 'block');
                                                $(".pickup input").addClass('mandatory');
                                            }
                                        });

                                        $("#checkoutBtn").attr('href', window.location.origin + '/my-account/checkout-order');
                                    } else {
                                        window.location.href = "<?= url('/my-account/my-cart') ?>";
                                    }

                                } else if (data.status_code == 401) {
                                    window.location.href = "<?= url('/login') ?>";
                                }
                            }
                        });

                        $.ajax({
                            headers: {'Authorization': 'Bearer <?= $user['token'] ?>'},
                            url: '<?= url('/api/myCars') ?>',
                            type: 'GET',
                            data: '',
                            success: function (data) {
//                                console.log(data);
                                if (data.status == true && data.status_code == 200) {
                                    if (data.data.length > 0) {
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
                                                    '<a href="<?= url('my-account/my-cars') ?>"><span class="fa fa-edit"></span></a>' +
                                                    '<a href="<?= url('my-account/my-cars') ?>" class="dlt-car"><span class="fa fa-trash"></span></a>' +
                                                    '</div> ' +
                                                    '</div>' +
                                                    ' <div class="content-box text-left pb-2">' +
                                                    '<h5><a href="#">' + car.brand_name + '</a></h5>' +
                                                    '<div class="price">' + car.car_name + '</div>  ' +
                                                    '<p class="carbrand"><span>' + car.model_name + ' </span><span class="ml-3">' + car.model_year + '</span></p> ' +
                                                    '<a href="#select" class="btn btn-primary w-100 mt-2 select_button" onclick="selectCar(this,' + car.id + ')">Select Car</a>' +
                                                    ' </div>' +
                                                    '</div>' +
                                                    '</div>';
                                            $("#carsDiv").append(html);
                                        });
                                    }
                                } else if (data.status_code == 401) {
                                    logoutUser();
                                }
                            }
                        });
                    });

</script>
<script>
    function bookService(obj) {
        var flag = true;
        $(".mandatory").each(function (i, v) {
            var elem = $(this);
            var valu = elem.val();
            if (valu == null || valu == '' || valu == 0) {
                flag = false;
                if (elem.attr('name') == 'user_car_id') {
                    $("#" + elem.attr('name') + 'Error').html('Car selection is required.');
                } else if (elem.attr('name') == 'date' || elem.attr('name') == 'time') {
                    $("#timeError").html('This field is required.');
                } else {
                    $("#" + elem.attr('name') + 'Error').html('This field is required.');
                }
            } else {
                $("#" + elem.attr('name') + 'Error').html('');
            }

        });

        var payment_method = $(":input[name=method]:checked").length;
        if (payment_method == 0) {
            $("#methodError").html('This field is required.');
        } else {
            $("#methodError").html('');
        }
        if (flag) {
            swal({
                title: "Continue Booking?",
                text: "Your request with " + count + " services will be sent to admin. Selected booking time is " + $("#time").val() + " on " + $("#date").val(),
                icon: "warning",
                buttons: ["No", "Yes"],
                dangerMode: true,
            })
                    .then((willDelete) => {
                        if (willDelete) {
                            $(".preloader").css('display', 'block');
                            var user_car_id = $("#car_id").val();
                            var branch_id = $("#branch_list").val();
                            var booking_date = $("#date").val();
                            var booking_time = $("#time").val();
                            payment_method = $(":input[name=method]:checked").val();
                            var price = ($("#total_cost").text()).replace("KWD", "");
                            var discount = ($("#discount").text()).replace("KWD", "");
//                            var tax = ($("#tax").text()).replace("KWD", "");
                            var tax = 0;
                            if (ispickup) {
                                var pickup = ($("#pickup").text()).replace("KWD", "");
                            } else {
                                var pickup = 0;
                            }
                            var total_amount = ($("#total").text()).replace("KWD", "");
                            var pickup_location = $(":input[name=pickup_location]").val();
                            var dropoff_location = $(":input[name=dropoff_location]").val();
                            var formData = new FormData();
                            formData.append('user_car_id', user_car_id);
                            formData.append('branch_id', branch_id);
                            formData.append('booking_date', booking_date);
                            formData.append('booking_time', booking_time);
                            formData.append('payment_mode', payment_method);
                            formData.append('price', price);
                            formData.append('offer_id', offer_id);
                            formData.append('discount', discount);
                            formData.append('tax', tax);
                            formData.append('pick_drop_charge', pickup);
                            formData.append('total_amount', total_amount);
                            formData.append('is_pickup', ispickup);
                            formData.append('pickup_location', pickup_location);
                            formData.append('dropoff_location', dropoff_location);
//                console.log(formData);
                            $.ajax({
                                headers: {'Authorization': 'Bearer <?= $user['token'] ?>'},
                                url: '<?= url('/api/bookService') ?>',
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                cache: false,
                                success: function (data) {
                                    $(".preloader").css('display', 'none');
//                    console.log(data);
                                    if (data.status == true && data.status_code == 200) {
                                        $("#successModal").modal();
                                        setTimeout(function () {
                                            location.replace('<?= url('my-account/my-bookings') ?>');
                                        }, 2000);
                                    } else {
                                        errorReported(data);
                                    }
                                }
                            });
                        } else {
                            return false;
                        }
                    });
        }
    }

    function selectCar(obj, car_id) {
        $("#car_id").val(car_id);
        $(".select_button").html('Select Car');
        $(obj).html('Selected');
    }
    var branches = new Array();
    function getBranchList(obj) {
        $("#branch_list").empty();
        $("#branch_list").append('<option selected disabled>Select Branch</option>');
        $(".preloader").css('display', 'block');
        $.ajax({
            headers: {'Authorization': 'Bearer <?= $user['token'] ?>'},
            url: '<?= url('/api/branchList') ?>',
            type: 'POST',
            data: 'booking_date=' + $(obj).val(),
            success: function (data) {

                $(".preloader").css('display', 'none');
                if (data.status == true && data.status_code == 200) {
                    branches = data.data;
                    $(branches).each(function (j, branch) {
                        var html = '<option value="' + branch.id + '">' + branch.branch_name + '</option>';
                        $("#branch_list").append(html);
                    });
                }
            }
        });
    }


    function getTimeSlots(obj) {
        $("#time").empty();
        $("#time").append('<option selected disabled>Select Time</option>');
        var branch_id = $(obj).val();
        $(branches).each(function (j, branch) {
            if (branch_id == branch.id) {
                var timings = branch.working_day_time;
                $(timings).each(function (k, times) {
                    var html = '<option>' + times + '</option>';
                    $("#time").append(html);
                });

            }
        });
    }

    function setPickupLoc(obj) {
        if ($(obj).is(':checked') == true) {
            $(".location :input").removeClass('mandatory');
            $(".location .text-danger").html('');
            $("#pickingCharge").css('display', 'none');
            $("#total").html((total_amount - pickup_charge) + ' KWD');
            ispickup = 0;
        } else {
            $(".location :input").addClass('mandatory');
            $("#pickingCharge").css('display', 'block');
            $("#total").html(total_amount + ' KWD');
            ispickup = 1;
        }
    }
</script>
@endsection