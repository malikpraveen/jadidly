@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Booking Detail</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Booking Detail</li>
        </ol>
    </div>
    <div class="content"> 
        <div class="card">
            <div class="card-body">
                @if(session()->has('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('success') }}
                </div>
                @else 
                @if(session()->has('error'))  
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('error') }}
                </div>
                @endif 
                @endif
                <div class="row mt-4">
                    <div class="col-lg-6 col-xs-6 b-r"> <h4>Booking Id #{{$booking->id}}</h4>
                        <!--<p class="text-muted"></p>-->
                    </div>
                    <div class="col-lg-6 col-xs-6 b-r text-right"> 
                        @if($booking->status != 2 && $booking->status != 3 && $booking->status != 2)
                        <button class="btn btn-success" type="button" onclick="bookingResponse(this, '<?= $booking->id ?>', '2')">Completed</button>
                        <!--<button class="btn btn-danger" type="button" onclick="bookingResponse(this, '<?= $booking->id ?>', 3)">Reject</button>-->
                        @endif
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-6 col-xs-6 b-r"> <label>User Name</label>
                        <br>
                        <p class="text-muted">{{$booking->username}}</p>
                    </div>
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Email ID</label>
                        <br>
                        <p class="text-muted">{{$booking->email}}</p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Mobile Number</label>
                        <br>
                        <p class="text-muted">{{$booking->mobile}}</p>
                    </div>
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Booking Date & Time</label>
                        <br>
                        <p class="text-muted">{{date('Y-m-d h:i A',$booking->booking_datetime)}}</p>
                    </div>

                </div>
                <div class="row mt-4">

                    <div class="col-lg-6 col-xs-6 b-r"> <label>Branch</label>
                        <br>
                        <p class="text-muted">{{$booking->branch}}</p>
                    </div>
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Pickup Address (If Pickup Required)</label>
                        <br>
                        <p class="text-muted">{{$booking->pickup_location}}</p>
                    </div>


                </div>
                <div class="row mt-4">
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Drop Off Address (If Pickup Required)</label>
                        <br>
                        <p class="text-muted">{{$booking->dropoff_location}}</p>
                    </div>
                    <div class="col-lg-6 col-xs-6 b-r"> <label>No. of Services Booked</label>
                        <br>
                        <p class="text-muted">{{count($booking->services)}}</p>
                    </div>


                </div>
                <div class="row mt-4">
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Service Cost</label>
                        <br>
                        <p class="text-muted">{{$booking->price}} KWD</p>
                    </div>
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Discount</label>
                        <br>
                        <p class="text-muted">{{$booking->discount}} KWD</p>
                    </div>

                </div>
                @if($booking->pick_drop_charge > 0)
                <div class="row mt-4">
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Pickup Charges</label>
                        <br>
                        <p class="text-muted">{{$booking->pick_drop_charge}} KWD</p>
                    </div>
                    <!--                    <div class="col-lg-6 col-xs-6 b-r"> <label>Tax</label>
                                            <br>
                                            <p class="text-muted">{{$booking->tax}} KWD</p>
                                        </div>-->
                    <!--                </div>
                                    <div class="row mt-4">-->

                    <div class="col-lg-6 col-xs-6 b-r"> <label>Total Booking Amount</label>
                        <br>
                        <p class="text-muted">{{$booking->amount}} KWD</p>
                    </div>

                </div>
                <div class="row mt-4">
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Mode Of Payment</label>
                        <br>
                        <p class="text-muted">{{ucwords($booking->payment_mode)}}</p>
                    </div> 
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Booking Status</label>

                        <br>
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
                        <p class="text-muted">{{$booking->cancel_reason}}</p>
                        @else 
                        @if($booking->status == '4')
                        <p class="text-danger">Cancelled</p>
                        <p class="text-muted">{{$booking->cancel_reason}}</p>
                        @endif
                        @endif
                        @endif
                        @endif
                        @endif  
                    </div>                    
                </div> 
                @else
                <div class="row mt-4">
                    <!--                    <div class="col-lg-6 col-xs-6 b-r"> <label>Tax</label>
                                            <br>
                                            <p class="text-muted">{{$booking->tax}} KWD</p>
                                        </div>-->
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Total Booking Amount</label>
                        <br>
                        <p class="text-muted">{{$booking->amount}} KWD</p>
                    </div>
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Mode Of Payment</label>
                        <br>
                        <p class="text-muted">{{$booking->payment_mode}}</p>
                    </div> 
                </div>
                <div class="row mt-4">

                    <div class="col-lg-6 col-xs-6 b-r"> <label>Booking Status</label>
                        <br>
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
                        <p class="text-muted">{{$booking->cancel_reason}}</p>
                        @else 
                        @if($booking->status == '4')
                        <p class="text-danger">Cancelled</p>
                        <p class="text-muted">{{$booking->cancel_reason}}</p>
                        @endif
                        @endif
                        @endif
                        @endif
                        @endif
                    </div>                    
                </div>  
                @endif


            </div>
        </div> 
        @if($booking->cardetails)
        <?php
        $car = $booking->cardetails;
        if ($car->images && isset($car->images[0])) {
            $images = $car->images;
            $image = $images[0]['file_path'];
        } else {
            $images = [];
            array_push($images, ['file_path' => $car->brand_image]);

//            $images = $car->images;
        }
//        echo '<pre>';print_r($images);die;
        ?>
        <div class="card">

            <div class="card-body">
                <h4><strong>Car Details</strong></h4>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="product-block pt-0">
                            <div class="inner-box">
                                <div class="row mt-4">

                                    <!--<div class="image-box">-->
                                    @foreach($images as $image)
                                    <div class="col-md-3">
                                        <figure class="image">
                                            <!--<a href="#car">-->
                                            <img style="width:200px;height:180px;" src="{{$image['file_path']}}" alt="">
                                            <!--</a>-->
                                        </figure>
                                    </div>
                                    @endforeach
                                    <!--</div>-->

                                </div>
                                <div class="content-box"> 
                                    <h5><a>{{$car->car_name.' ('.$car->model_year.')'}}</a></h5>
                                    <p class="cat hideClass"><a>{{$car->model_name}}</a></p>
                                    <p class="service-text hideClass">{{$car->brand_name}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endif
        <div class="card">

            <div class="card-body">
                <h4><strong>Booked Services</strong></h4>
                <div class="row mt-4">

                    @if($booking->services)
                    @foreach($booking->services as $service)
                    <div class="col-md-12">
                        <div class="product-block pt-0">
                            <div class="inner-box">
                                <div class="image-box">
                                    <figure class="image"><a href="{{url('admin/service-detail/'.base64_encode($service->service_id))}}"><img style="width:200px;height:180px;" src="{{$service->image}}" alt=""></a></figure>
                                </div>
                                <div class="content-box"> 
                                    <h5><a href="{{url('admin/service-detail/'.base64_encode($service->service_id))}}">{{$service->name}}</a></h5>
                                    <p class="cat hideClass"><span>Category Name :</span><a>{{$service->main_category}}</a></p>
                                    <p class="service-text hideClass">{{$service->description}} </p>
                                    <div class="price hideClass"><span>Service Price :</span>{{$service->price}} KWD</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif

                </div>
            </div>

        </div>
    </div>
    <script>
        function bookingResponse(obj, id, type) {
            if (type == 3) {
                swal({
                    title: "Are you sure?",
                    text: "Booking will be cancelled if you continue",
                    icon: "warning",
                    buttons: ["No", "Yes"],
                    dangerMode: true,
                })
                        .then((willDelete) => {
                            if (willDelete) {
                                $("#rejectReason").modal();
                            } else {
                                return false;
                            }
                        });
            } else {
                sendResponse(id, type, '');
            }
        }

        function continueToReject(obj, id) {
            var reason = $("#reject_reason").val();
            if (reason) {
                $("#reasonError").html('');
                sendResponse(id, '3', reason);
            } else {
                $("#reasonError").html('Reason is required field');
            }
        }

        function sendResponse(id, status, reason) {
            $.ajax({
                url: '<?= url('admin/booking/action') ?>',
                type: 'POST',
                data: 'id=' + id + '&status=' + status + '&reason=' + reason + '&_token=<?= csrf_token() ?>',
                success: function (data) {
//                    alert(data.message);
                    data.title = "Action Report!";
                    if (status == '3') {
                        $("#reasonError").html(data.message);
                        $("#rejectReason").modal('close');
                    }
                    if (data.error_code == 200) {
                        successMessage(data);
//                        location.reload();
                    } else {
                        errorOccured(data);
                    }
                }
            });
        }
    </script>
    @endsection