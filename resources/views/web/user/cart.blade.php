@extends('web.layout.master')
@section('content')

<!--Page Title-->
<section class="page-title" style="background-image:url(<?= asset('assetsFront/images/background/3.jpg') ?>)">
    <div class="auto-container text-center">
        <h2>Cart</h2>
        <ul class="page-breadcrumb"> 
            <li>Add Services To Cart You Want To Book</li>
        </ul>
    </div>
</section>
<!--End Page Title-->
<!--Cart Section-->
<section class="cart-section my-cart">
    <div class="auto-container">
        <!--Cart Outer-->
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-8 text-center" id="serviceDiv"> 
                <img width="50%" alt="Your cart is empty" src="https://cdn3.iconfinder.com/data/icons/taxi-line-set/64/taxi-19-512.png">
                <!--                <div class="product-block pt-0">
                                    <div class="inner-box"> 
                                        <a href="#" class="servicetrash-btn">
                                            <i class="fa fa-times"></i>
                                        </a>
                                        <div class="image-box">
                                            <figure class="image"><a href="#"><img src="/images/cars/1.jpg" alt=""></a></figure> 
                                        </div>
                                        <div class="content-box">
                                            <h5><a href="#">Engine Repair</a></h5>
                                            <p class="cat"><span>Category Name :</span> Engine Repair</p>
                                            <p class="service-text">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                                            <div class="price"><span>Service Price :</span> 500 KWD</div>
                                        </div>
                                    </div>
                                </div>-->

            </div> 
            <div class="col-md-6 col-lg-4 col-sm-4">
                <ul class="totals-table">
                    <li><h3>Cart Total</h3></li>
                    <li class="clearfix total"><span class="col">Total Service</span><span class="col price" id="service_count">00</span></li>
                    <li class="clearfix total"><span class="col">Total Cost</span><span class="col price " id="total_cost">0 KWD</span></li>
                    <li class="clearfix total"><span class="col">Discount</span><span class="col price text-danger" id="discount">0 KWD</span></li>
                    <!--<li class="clearfix total"><span class="col">Tax</span><span class="col" id="tax">0 KWD</span></li>-->
                    <li class="clearfix total"><span class="col">Pickup & Dropoff charges</span><span class="col" id="pickup">0 KWD</span></li>
                    <li class="clearfix total"><span class="col">Total Amount</span><span class="col price text-blue" id="total">0 KWD</span></li>
                    <li class="text-center btn-box"><a href="#cartisempty" id="checkoutBtn" class="theme-btn btn-style-one w-100">Checkout</a></li>
                </ul> 
            </div>
        </div> 
    </div>
</div>



<script src="{{asset('assetsFront/js/jquery.js')}}"></script>
<script>
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
//                $("#tax").html(data.data.tax + ' KWD');
                $("#pickup").html(data.data.pickup_charges + ' KWD');
                $("#total").html(data.data.total_paybale_amount + ' KWD');
                $("#service_count").html(data.data.service_count);

                if (data.data.services.length > 0) {
                    $("#serviceDiv").empty();
                    var service_list = data.data.services;
                    $(service_list).each(function (i, service) {
                        var images = service.service_images['0'];
                        var html = '<div class="product-block pt-0">' +
                                '<div class="inner-box">' +
                                '<a href="#" onclick="removeFromCart(this,' + service.id + ')" class="servicetrash-btn">' +
                                '<i class="fa fa-times"></i>' +
                                '</a>' +
                                '<div class="image-box">' +
                                '<figure class="image"><a href="#"><img src="' + images['image'] + '" alt=""></a></figure>' +
                                "</div>" +
                                '<div class="content-box">' +
                                '<h5><a href="#">' + service.name + '</a></h5>' +
                                '<p class="cat hideClass"><span>Category Name :</span><a href="' + window.location.origin + '/subcategory-list/' + btoa(service.main_category) + '"> ' + service.service_category.name + '</a></p>' +
                                '<p class="service-text hideClass">' + (service.description).substring(0, 35) + '.. </p>' +
//                                '<p class="showClass" style="display:none">' + (service.description) + ' <a href="#this" onclick="showMore(this,2);" class="ml-3">Show less</a> </p>' +
                                '<div class="price hideClass"><span>Service Price :</span> ' + service.price + '  KWD</div>' +
                                "</div>" +
                                "</div>" +
                                "</div>";
                        $("#serviceDiv").append(html);
                    });

                    $("#checkoutBtn").attr('href', '<?= url('/my-account/checkout-order') ?>');
                }

            } else {
//                window.location.href = "<?= url('/login') ?>";
            }
        }
    });
});


function removeFromCart(obj, service_id) {
//    var conf = confirm('Are you sure to remove this product from your cart?');
//    if (conf) {
    swal({
        title: "Are you sure?",
        text: "The service will be removed from your cart",
        icon: "warning",
        buttons: ["No", "Yes"],
        dangerMode: true,
    })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        headers: {'Authorization': 'Bearer <?= Session::get('login_info')['token'] ?>'},
                        url: '<?= url('/api/removeFromCart') ?>',
                        type: 'POST',
                        data: 'service_id=' + service_id,
                        success: function (data) {
//                            if (data.error) {
//                                alert(data.error);
//                            } else {
//                                alert(data.message);
//                            }
                            if (data.status == true && data.status_code == 200) {
                                swal({
                                    title: "Service Removed!",
                                    text: data.message,
                                    icon: "success",
                                    buttons: false,
                                    timer: 2000
                                });
//                                                    setTimeout(function () {
//                                                        location.reload();
//                                                    }, 2000);
                                $(obj).closest(".product-block").remove();
                            } else {
                                errorReported(data);
                            }

                        }
                    });
                    var all = $(".product-block");
                    if (all.length - 1 > 0) {
                        resetCartValues();
                    } else {
                        $("#serviceDiv").append('<img width="50%" alt="Your cart is empty" src="https://cdn3.iconfinder.com/data/icons/taxi-line-set/64/taxi-19-512.png">');
                        location.reload();
                    }
                } else {
                    return false;
                }
            })
        }

        function resetCartValues() {
            $.ajax({
                headers: {'Authorization': 'Bearer <?= Session::get('login_info')['token'] ?>'},
                url: '<?= url('/api/myCart') ?>',
                type: 'GET',
                data: '',
                success: function (data) {
                    if (data.status == true && data.status_code == 200) {
//                        $("#tax").html(data.data.tax + ' KWD');
                        $("#pickup").html(data.data.pickup_charges + ' KWD');
                        $("#total_cost").html(data.data.total_cost + ' KWD');
                        $("#discount").html((data.data.total_discount > 0 ? data.data.total_discount + ' KWD' : data.data.total_discount));
                        $("#total").html(data.data.total_paybale_amount + ' KWD');
                        $("#service_count").html(data.data.service_count);

                    }
                }
            });
        }
</script>
@endsection