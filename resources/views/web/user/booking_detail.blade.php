@extends('web.layout.master')
@section('content')
<style>
    .cancellation-alert{
        position: relative;
        padding: 20px;
        border-radius: 4px;
        /*border: 5px solid #d2d3da;*/
        box-shadow: 0 0 30px rgb(0 0 0 / 10%);
        border-bottom: 5px outset #413afbe0;
    }

    .cancellation-alert p{
        margin-bottom: 0px !important;
    }
</style>
<!--Page Title-->
<section class="page-title" style="background-image:url(<?= asset('assetsFront/images/background/3.jpg') ?>)">
    <div class="auto-container text-center">
        <h2>Booking Detail</h2>
        <ul class="page-breadcrumb"> 
            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
        </ul>
    </div>
</section>
<!--End Page Title-->


<!-- Contact Page Section -->
<section class="contact-section-two project-detail">
    <div class="auto-container lower-content">

        @if($booking->cancellation_request_id)
        <div class="row mb-4" style="padding: 0px 20px;">
            @if($booking->cancellation_request_status == 2)
            <div class="col-md-12 cancellation-alert">
                <p> Your cancellation request has been rejected by admin. In case of any query kindly contact admin.</p>
            </div>
            @else
            <div class="col-md-12 cancellation-alert">
                <p> You have requested to cancel this booking. Admin will review your request and your request status will be updated to you soon.</p>
                <button class="btn btn-danger float-right" type="button" onclick="cancelRequest(this, '<?= $booking->cancellation_request_id ?>', '<?= $booking->id ?>');">Cancel Request</button>
            </div>
            @endif
        </div>
        @endif

        <div class="row">

            @if(isset($booking->cardetails) && $booking->cardetails)
            <div class="product-block col-lg-4 col-md-12 col-sm-12 mb-4 pt-0"> 
                <div class="inner-box">
                    <div class="image-box">
                        <figure class="image"><a href="#"><img src="{{$booking->cardetails->images && isset($booking->cardetails->images[0]->file_path) && $booking->cardetails->images[0]->file_path?$booking->cardetails->images[0]->file_path:$booking->cardetails->brand_image}}" alt=""></a></figure> 
                    </div>
                    <div class="content-box">
                        <h5><a href="#">{{$booking->cardetails->model_name.' ('.$booking->cardetails->model_year.')'}}</a></h5>
                        <div class='price'>{{$booking->cardetails->car_name}}</div>
                        <p class="carbrand"><span>{{$booking->cardetails->brand_name}}</span></p>
                    </div>
                </div> 
            </div> 
            @endif
            <div class="info-column col-lg-4  col-md-12 col-sm-12 mb-4">
                <div class="inner-column mt-0">
                    <h3 class="mb-0">Service Type</h3>
                    <p></p>
                    <ul class="project-info clearfix">
                        @if($booking->services)
                        @foreach($booking->services as $service)
                        <?php $category = $service->main_category; ?>
                        <li> 
                            <span class="icon fa fa-wrench"></span>
                            <strong>{{$service->name}} <span class='float-right text-muted'>{{$service->amount}} KWD</span></strong> 
                        </li>
                        @endforeach
                        @endif

                        <li>
                            <span class="icon fa fa-car"></span>
                            <strong>Service Category</strong>
                            <p>{{isset($category) && $category ?$category:'N/A'}}</p>
                        </li>
                        <li>
                            <span class="icon fa fa-folder"></span>
                            <strong>Booking Id</strong>
                            <p>#{{$booking->id}}</p>
                        </li>
                        <li>
                            <span class="icon fa fa-users"></span>
                            <strong>Branch</strong>
                            <p>{{$booking->branch}}</p>
                        </li>
                        <li>
                            <span class="icon fa fa-phone"></span>
                            <strong>Contact Number</strong>
                            <p>{{($booking->branch_number?$booking->branch_number:'-')}}</p>
                        </li>
                        @if($booking->pickup_location)
                        <li>
                            <span class="icon fa fa-map-pin text-danger"></span>
                            <strong>Pickup Location</strong>
                            <p>{{$booking->pickup_location}}</p>
                        </li>
                        @endif
                        @if($booking->pickup_location)
                        <li>
                            <span class="icon fa fa-map-pin text-success"></span>
                            <strong>Dropoff Location</strong>
                            <p>{{$booking->dropoff_location}}</p>
                        </li>
                        @endif
                        <li>
                            <span class="icon fa fa-toggle-on"></span>
                            <strong>Service Status</strong>
                            @if($booking->status == '0')
                            <p class="text-warning">New</p>
                            @else 
                            @if($booking->status == '1')
                            <p class="text-warning">In Process</p>
                            @else 
                            @if($booking->status == '2')
                            <p class="text-success">Completed</p>
                            @else 
                            @if($booking->status == '3')
                            <p class="text-danger">Rejected</p>
                            @else 
                            @if($booking->status == '4')
                            <p class="text-danger">Cancelled</p>
                            @endif
                            @endif
                            @endif
                            @endif
                            @endif
                        </li>
                        @if($booking->status == '3' || $booking->status == '4')
                        <li>
                            <span class="icon fa fa-sticky-note"></span>
                            <strong>{{$booking->status == '3'?'Reject':'Cancel'}} Reason</strong>
                            <p>{{$booking->cancel_reason}}</p>
                        </li>
                        @endif
                    </ul>
                </div> 
            </div>
            <div class="info-column col-lg-4  col-md-12 col-sm-12 mb-4">
                <div class="inner-column mt-0">
                    <h3 class="mb-0">Payment Information</h3>
                    @if($booking->pickup_location)
                    <p></p>
                    @endif
                    <ul class="project-info clearfix">
                        <li>
                            <span class="icon fa fa-calendar-alt"></span>
                            <strong>For Date & Time</strong>
                            <p>{{date('d-m-Y h:i A',$booking->booking_datetime)}}</p>
                        </li>
                        <li>
                            <span class="icon fa fa-shopping-cart"></span>
                            <strong>Service Cost (inclusive all taxes)</strong>
                            <p class="">{{$booking->price}} KWD</p>
                        </li>
                        <!--                        <li>
                                                    <span class="icon fa fa-tag"></span>
                                                    <strong>Tax</strong>
                                                    <p>{{$booking->tax}} KWD</p>
                                                </li>-->
                        <li>
                            <span class="icon fa fa-certificate"></span>
                            <strong>Discount</strong>
                            <p class="text-danger">{{$booking->discount}} KWD</p>
                        </li>

                        @if($booking->pick_drop_charge)
                        <li>
                            <span class="icon fa fa-truck"></span>
                            <strong>Pickup & Dropoff Charges</strong>
                            <p class="">{{$booking->pick_drop_charge}} KWD</p>
                        </li>
                        @endif
                        <li>
                            <span class="icon fa fa-paper-plane"></span>
                            <strong>Total Cost</strong>
                            <p>{{$booking->amount}} KWD</p>
                        </li> 
                        <li>
                            <span class="icon fa fa-money"></span>
                            <strong>Payment Status</strong>
                            <p>{{$booking->payment_status == '1'?'Paid':($booking->payment_status == '2'?'Failed':'Pending')}}</p>
                        </li> 
                        <li>
                            <span class="icon fa fa-credit-card-alt"></span>
                            <strong>Payment Method</strong>
                            <p>{{ucwords($booking->payment_mode)}}</p>
                        </li> 

                    </ul>
                </div>

            </div>

        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="text-center"> 
                    @if($booking->payment_status != '1' && ($booking->status == '0'||$booking->status == '1'||$booking->status == '2'))
                    <a href="#" class="theme-btn btn-style-one" onclick='pay(this, "<?= $booking->id ?>");'><span class="btn-title">Pay</span></a>
                    @endif
                    @if($booking->status == 0 && ($booking->cancellation_request_id == 0 || ($booking->cancellation_request_id && ($booking->cancellation_request_status != 0 && $booking->cancellation_request_status != 1))))
                    <!--                    <a href="#xampleModal" onclick="openCancelModal(this);" class="theme-btn btn-style-one" data-toggle="modal" data-target="#exampleModal">
                                            Cancel
                                        </a>-->
                    <a href="#xampleModal" onclick="openCancelModal(this);" class="theme-btn btn-style-one">
                        Cancel
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Contact Page Section -->

<!-- Modal -->
<div class="modal" id="exampleModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <h4>Reason for cancellation</h4>
                    <p>Please tell us reason of cancellation. This information is only used to improve our service</p>
                    <ul class="mt-4" id="reasonList">
                    </ul>
                    <p class="text-danger" style="font-size:14px;" id="reasonError"></p>
                    <p class="text-success" style="font-size:14px;" id="reasonSuccess"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="theme-btn btn-style-one" onclick="cancelBooking(this, '<?= $booking->id ?>')">Confirm</button>
                <button type="button" id="closeModal" class="theme-btn btn-style-one" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal bs-example-modal-new checkout-modal" id="successModal" style='background-color: #eeeeeea3;' data-keyboard='false' data-backdrop='static'tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <!-- Modal Content: begins -->
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header border-bottom-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload();"> <span aria-hidden="true">&times;</span></button>

            </div>

            <!-- Modal Body -->  
            <div class="modal-body text-center">
                <div class="body-message">
                    <a href="#"><i class="fa fa-money confirm-booking-icon"></i></a>

                    <h4 class="text-dark">Payment Received!</h4>
                    <p>We have received your payment successfully.</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-top-0 text-center"> 
            </div>

        </div>
        <!-- Modal Content: ends -->

    </div>

</div>

@endsection
<script src="{{asset('assetsFront/js/jquery.js')}}"></script>
<script>
                    function openCancelModal(obj) {
//                        var conf = confirm("Are you sure to cancel this booking?");
//                        if (conf) {
//                            getCancelReasons(obj);
//                            $("#exampleModal").modal();
//                            return true;
//                        } else {
//                            return false;
//                        }

                        swal({
                            title: "Are you sure?",
                            text: "Your booking will be cancelled",
                            icon: "warning",
                            buttons: ["No", "Yes"],
                            dangerMode: true,
                        })
                                .then((willDelete) => {
                                    if (willDelete) {
                                        getCancelReasons(obj);
                                        $("#exampleModal").modal();
                                    } else {
                                        return false;
                                    }
                                });
                    }

                    function cancelBooking(obj, booking_id) {
                        var reason = $(":input[name=reason_id]:checked").val();
                        if (reason) {
                            $("#reasonError").html('');
                            $("#reasonSuccess").html('');
                            $.ajax({
                                headers: {'Authorization': 'Bearer <?= Session::get('login_info')['token'] ?>'},
                                url: '<?= url('/api/cancelBooking') ?>',
                                type: 'POST',
                                data: 'booking_id=' + booking_id + '&reason_id=' + reason,
                                success: function (data) {
                                    if (data.status == true && data.status_code == 200) {
                                        $("#reasonSuccess").html(data.message);
                                        $("#closeModal").click();
                                        swal({
                                            title: "Booking Cancelled!",
                                            text: data.message,
                                            icon: "success",
                                            buttons: false,
                                        });
                                        setTimeout(function () {
                                            location.reload();
                                        }, 2000);
//                                        location.reload();
                                    } else if (data.status_code == 401) {
//                        logoutUser(this);
                                        sessionExpired(data);
                                    } else {
                                        errorReported(data);
                                    }
                                }
                            });

                        } else {
                            $("#reasonSuccess").html('');
                            $("#reasonError").html('Reason is required field');
                        }
                    }

                    function getCancelReasons(obj) {
                        $.ajax({
                            url: '<?= url('/api/adminSettings') ?>',
                            type: 'GET',
                            data: '',
                            success: function (data) {
                                if (data.status == true && data.status_code == 200) {
                                    if (data.data.cancel_reasons.length > 0) {
                                        $("#reasonList").empty();
                                        var reasons = data.data.cancel_reasons;
                                        $(reasons).each(function (i, reason) {
                                            var html = '<li><input type="checkbox" name="reason_id" value="' + reason.reason_id + '" class="mr-2">' + reason.reason + '</li>';
                                            $("#reasonList").append(html);
                                        });


                                    }
                                }
                            }
                        });
                    }


                    function pay(obj, booking_id) {
                        $.ajax({
                            headers: {'Authorization': 'Bearer <?= Session::get('login_info')['token'] ?>'},
                            url: '<?= url('/api/updatePaymentStatus') ?>',
                            type: 'POST',
                            data: 'booking_id=' + booking_id + '&payment_status=1',
                            success: function (data) {
                                if (data.status == true && data.status_code == 200) {
//                                    $("#successModal").modal();
                                    swal({
                                        title: "Payment Received!",
                                        text: data.message,
                                        icon: "success",
                                        buttons: false,
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

                    function cancelRequest(obj, r_id, b_id) {
                        $.ajax({
                            headers: {'Authorization': 'Bearer <?= Session::get('login_info')['token'] ?>'},
                            url: '<?= url('/api/cancelCancellationRequest') ?>',
                            type: 'POST',
                            data: 'booking_id=' + b_id + '&request_id=' + r_id,
                            success: function (data) {
                                if (data.status == true && data.status_code == 200) {
                                    swal({
                                        title: "Request Cancelled!",
                                        text: data.message,
                                        icon: "success",
                                        buttons: false,
                                    });
                                    setTimeout(function () {
                                        location.reload();
                                    }, 2000);
//                                        location.reload();
                                } else if (data.status_code == 401) {
//                        logoutUser(this);
                                    sessionExpired(data);
                                } else {
                                    errorReported(data);
                                }
                            }
                        });
                    }

</script>