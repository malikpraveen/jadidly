@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Booking List</h1>
        <ol class="breadcrumb">
            <li><a href="<?=url('admin/home')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Booking List</li>
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
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Booking Id</th>
                                <th>User Name</th>   
                                <th>Booking Date & Time</th> 
                                <th>Amount</th>
                                <th>Payment Mode</th>
                                <th>Status</th>
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @if($bookings)
                            @foreach($bookings as $k=>$booking)
                            <tr>
                                <td>{{$k+1}}</td> 
                                <td>#{{$booking->id}}</td>
                                <td><a href="<?= url('admin/user-detail/' . base64_encode($booking->user_id)) ?>">{{$booking->username}}</td> 
                                <td>{{date('Y-m-d h:i A',$booking->booking_datetime)}}</td>
                                <td>{{$booking->amount}} KWD</td>
                                <td>{{$booking->payment_mode}}</td>
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
                                <td><a href="<?= url('admin/booking-details/' . base64_encode($booking->id)) ?>" class="composemail-edit">
                                        <i class="fa fa-eye"></i></a>
                                </td> 
                            </tr> 
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 
    @endsection