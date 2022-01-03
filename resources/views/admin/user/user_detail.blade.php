@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>User Detail</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> User Detail</li>
        </ol>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card pt-4 pb-4"> 
                    <div class="box-profile text-black"> <img class="profile-user-img img-responsive img-circle m-b-2" src="{{$user->image?$user->image:asset('assets/images/user.png')}}" alt="User profile picture">
                        <h3 class="profile-username text-center">{{$user->name}}</h3> 
                    </div> 
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-xs-6 m-b-3">
                <div class="card text-center">
                    <div class="card-body"><span class="info-box-icon bg-aqua"><i class="fa fa-phone"></i></span>
                        <div class="info-box-content"> <span class="info-box-number">Mobile Number</span> <span class="info-box-text">
                                +{{$user->country_code.' '.$user->mobile_number}} </span> </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xs-6 m-b-3">
                <div class="card text-center">
                    <div class="card-body"><span class="info-box-icon bg-red"><i class="fa fa-envelope"></i></span>
                        <div class="info-box-content"> <span class="info-box-number">Email Id</span> <span class="info-box-text">
                                {{$user->email?$user->email:'-'}}</span> </div>
                    </div>
                </div>
            </div>     
        </div>    
        <div class="row mb-2"> 
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Service Ordered</h5>
                    </div>
                    <div class="card-body"> 
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Booking Id</th>
                                        <th>Service Name</th> 
                                        <th>Service Category</th> 
                                        <th>Service Price</th> 
                                        <th>Order Date & Time</th> 
                                        <th>Status</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($services)
                                    @foreach($services as $booking)
                                    @if($booking['services'])
                                    @foreach($booking['services'] as $key=>$service)
                                    <tr>
                                        <td>{{$key+1}}</td> 
                                        <td><a href="<?=url('admin/booking-details/'. base64_encode($booking->id))?>" title='view booking'>#{{$service->booking_id}}</a></td> 
                                        <td><a href="<?=url('admin/service-detail/'. base64_encode($service->service_id))?>" title='view service'>{{$service->name}}</a></td>
                                        <td>{{$service->main_category}}</td> 
                                        <td>{{$service->price}} KWD</td>
                                        <td>{{date('d-m-Y h:i A',$booking->booking_datetime)}}</td>  
                                        <td>
                                            @if($booking->status == '0')
                                            <span class="text-warning">New</span>
                                            @else 
                                            @if($booking->status == '1')
                                            <span class="text-warning">In Process</span>
                                            @else 
                                            @if($booking->status == '2')
                                            <span class="text-success">Completed</span>
                                            @else 
                                            @if($booking->status == '3')
                                            <span class="text-danger">Rejected</span>
                                            @else 
                                            @if($booking->status == '4')
                                            <span class="text-danger">Cancelled</span>
                                            @endif
                                            @endif
                                            @endif
                                            @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                    @endif

                                    @endforeach

                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div> 
    </div> 
    @endsection