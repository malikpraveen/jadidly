@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Dashboard</h1>
<!--        <ol class="breadcrumb">
            <li> <a href="#">Home</a> </li>
            <li> <i class="fa fa-angle-right"></i> Dashboard</li>
        </ol>-->
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-4 col-xs-6 m-b-3">
                <div class="card text-center">
                    <div class="card-body">
                        <a href="{{url('admin/user-management')}}">
                            <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                            <div class="info-box-content"> <span class="info-box-number"><?= $total_users ?></span> <span class="info-box-text">
                                    Total Users </span> 
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6 m-b-3">
                <div class="card text-center">
                    <div class="card-body">
                        <a href="{{url('admin/booking-management')}}">
                            <span class="info-box-icon bg-red"><i class="fa fa-car"></i></span>
                            <div class="info-box-content"> <span class="info-box-number"><?= $total_bookings ?></span> <span class="info-box-text">
                                    Total Booking </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6 m-b-3">
                <div class="card text-center">
                    <div class="card-body"><span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>
                        <div class="info-box-content"> <span class="info-box-number"><?= $total_earning ?> KWD</span> <span class="info-box-text">Total Earning</span></div>
                    </div>
                </div>
            </div>    
        </div>
        <div class="card">
            <div class="row">
                <div class="col-xl-12">
                    <div class="info-box">
                        <div class="card-header mb-4">
                            <h5 class="card-title">New Registered Users</h5>
                        </div>

                        <div class="card-body"> 
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>User Name</th> 
                                            <th>Email Id</th> 
                                            <th>Registration Date</th> 
                                            <!--<th>Status</th>-->
                                            <th >Action</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($users)
                                        @foreach($users as $k=>$user)
                                        <tr>
                                            <td>{{$k+1}}</td> 
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email?$user->email:'-'}}</td> 
                                            <td>{{date('d/M/Y h:iA',strtotime($user->created_at))}}</td>
        <!--                                            <td>
                                                <div class="mytoggle">
                                                    <label class="switch">
                                                        <input type="checkbox" <?= $user->status == 'active' ? 'checked' : '' ?>> <span class="slider round"></span> </label>
                                                </div>
                                            </td>-->
                                            <td class="text-center"><a href="{{url('admin/user-detail/'.base64_encode($user->id))}}" class="composemail-edit">
                                                    <i class="fa fa-eye"></i></a></td> 
                                        </tr>
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
    </div>

    @endsection