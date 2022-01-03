@extends('web.layout.master')
@section('content')
<style>
    .content-box{
        min-height: 200px; 
    }

</style>
<!--Page Title-->
<section class="page-title" style="background-image:url(<?= asset('/assetsFront/images/background/3.jpg') ?>)">
    <div class="auto-container text-center">
        <h2 id="category_name">Services</h2>
        <ul class="page-breadcrumb"> 
            <li id="quote">Listing All The Services Under Category</li>
        </ul>
    </div>
</section>
<!--End Page Title-->
<section class="about-us style-two service-background">


    <div class="auto-container">
        <div class="row clearfix">
            <!-- Content Column -->
            <div class="content-column col-lg-12 col-md-12 col-sm-12 order-2 content-side">
                <div class="inner-column"> 
                    <div class="our-shop">
                        <div class="row mb-3"> 
                            <!--                            <div class="col-md-6 offset-6">
                                                            <input type="search" name="" placeholder="Search" class="form-control">
                                                        </div>-->
                        </div>
                        <div class="row clearfix" id="serviceDiv">
                            <!-- Product Block -->
                            <!--                            <div class="product-block col-lg-4 col-md-6 col-sm-12">
                                                            <div class="inner-box">
                                                                <div class="image-box">
                                                                    <figure class="image"><a href="#"><img src="{{asset('assetsFront/images/cars/1.jpg')}}" alt=""></a></figure>
                                                                    <div class="btn-box"> 
                                                                        <a href="#" class="w-100 pl-3 pr-3" style="border-radius:2px">Add To Cart</a>
                                                                    </div> 
                                                                </div>
                                                                <div class="content-box text-left">
                                                                    <h5><a href="#">Car Inspaction</a></h5>
                                                                    <p class="cat"><span>Category Name :</span> Inspaction</p>
                                                                    <p class="cat"><span>Pickup :</span> Yes</p> 
                                                                    <div class="service-price"><span>Service Price :</span> 800 KWD</div>
                                                                    <p class="service-text">Lorem ipsum dolor sit, amet consectetur adipisicing elit. <a href="#" class="ml-3">View more</a> </p>   
                                                                </div>
                                                            </div>
                                                        </div>   -->
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
<section class="about-us style-two service-background pb-0 pt-0">


    <div class="auto-container">
        <div class="row clearfix">
            <!-- Content Column -->
            <div class="content-column col-lg-12 col-md-12 col-sm-12 order-2">
                <div class="inner-column"> 
                    <h3 class="include">Our services include:</h3> 
                    <div class="text-box"> 
                        <ul class="list-style-one mb-2">
                            <li>Collection of your vehicle from your door step</li>
                            <li>Send your vehicle to undergo the RTA’s technical test, mandatory for registration renewal</li>
                            <li>Arrange insurance policy as per your requirements</li>
                            <li>Handle and clear all traffic fines, a mandatory step ahead of renewing your registration</li>
                            <li>New car registration or registration renewal</li>
                            <li>Safely deliver your beloved vehicle back to you</li>
                        </ul>
                        <p>Forget about standing in long lines and wasting hours in the car registration renewal process.<br>
                            We will pick car from your door steps, renew your car registration and drop it off safely to you.<br>
                            Book a hassle-free appointment now.</p>
                    </div> 
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
<script src="{{asset('assetsFront/js/jquery.js')}}"></script>
<script>
var selectable = 0;
var cartCount = 0;
$(document).ready(function () {
    $.ajax({
        headers: {'Authorization': 'Bearer <?= Session::get('login_info')['token'] ?>'},
        url: '<?= url('/api/serviceList') ?>',
        type: 'POST',
        data: 'category_id=<?= $category_id ?>',
        success: function (data) {
            if (data.status == true && data.status_code == 200) {
                if (data.data.name) {
                    $("#category_name").html(data.data.name);
                    $("#quote").html("Listing All The Services Under " + data.data.name + " Category");
                    selectable = data.data.multiple_select;
                }
                if (data.data.service_list.length > 0) {
                    var service_list = data.data.service_list;
                    $(service_list).each(function (i, service) {
                        var images = service.service_images['0'];
                        var html = '<div class="product-block col-lg-4 col-md-6 col-sm-12">' +
                                '<div class="inner-box">' +
                                '<div class="image-box">' +
                                '<figure class="image"><a href="#"><img src="' + images['image'] + '" alt=""></a></figure>' +
                                '<div class="btn-box"> ';
                        if (service.is_cart == 1) {
                            cartCount++;
                            html += '<a href="#' + service.name + '" class="w-100 pl-3 pr-3 rfc" style="border-radius:2px" onclick="removeFromCart(this,' + service.id + ')">Remove From Cart</a>';
                        } else {
                            html += '<a href="#' + service.name + '" class="w-100 pl-3 pr-3 adtc" style="border-radius:2px" onclick="addToCart(this,' + service.id + ')">Add To Cart</a>';
                        }
                        html += "</div>" +
                                "</div>" +
                                '<div class="content-box text-left">' +
                                '<h5 class="hideClass"><a href="#">' + service.name + '</a></h5>' +
                                '<p class="cat hideClass"><span>Category Name :</span> ' + service.service_category.name + '</p>' +
                                '<p class="cat hideClass"><span>Pickup :</span> ' + (service.is_pickup == 1? 'Yes' : 'No') + '</p> ' +
                                '<div class="service-price hideClass"><span>Service Price :</span> ' + service.price + ' KWD</div>' +
                                '<p class="service-text hideClass">' + (service.description).substring(0, 65) + '.. <a href="#this" onclick="showMore(this,1);" class="ml-3">Show more</a> </p>' +
                                '<p class="showClass" style="display:none">' + (service.description) + ' <a href="#this" onclick="showMore(this,2);" class="ml-3">Show less</a> </p>' +
                                "</div>" +
                                "</div>" +
                                "</div>";
                        $("#serviceDiv").append(html);
                    });
                    if (selectable == 0 && cartCount > 0) {
                        $(".adtc").hide();
                    }
                }

            } else {
//                window.location.href = "<?= url('/login') ?>";
            }
        }
    });
});
function showMore(obj, type) {
    var parent = $(obj).closest(".content-box");
    if (type == 1) {

        parent.find(".hideClass").css('display', 'none');
        parent.find(".showClass").css('display', 'block');
    } else {
        parent.find(".showClass").css('display', 'none');
        parent.find(".hideClass").css('display', 'block');
    }
}

function addToCart(obj, service_id) {
    $.ajax({
        headers: {'Authorization': 'Bearer <?= Session::get('login_info')['token'] ?>'},
        url: '<?= url('/api/addToCart') ?>',
        type: 'POST',
        data: 'service_id=' + service_id,
        success: function (data) {
//            if (data.error) {
//                alert(data.error);
//            } else {
//                alert(data.message);
//            }
            if (data.status == true && data.status_code == 200) {
                swal({
                    title: "Added to cart!",
                    text: data.message,
                    icon: "success",
                    buttons: false,
                    timer: 2000
                });
                $(obj).html('Remove From Cart');
                $(obj).attr('onclick', 'removeFromCart(this,' + service_id + ')');
            } else {
                errorReported(data);
            }
            if (selectable == 0) {
                $(".adtc").not($(obj)).hide();
            }
        }
    });
}

function removeFromCart(obj, service_id) {
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
                                $(obj).html('Add To Cart');
                                $(obj).attr('onclick', 'addToCart(this,' + service_id + ')');
                                if (selectable == 0) {
                                    $(".adtc").not($(obj)).show();
                                }
                            }else{
                                errorReported(data);
                            }


                        }
                    });
                } else {
                    return false;
                }
            })
}
</script>
