@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Employee Detail</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Booking Detail</li>
        </ol>
    </div>
    <div class="content"> 
        <div class="card">
            <div class="card-body">
                 <div class="row">
                        <div class="col-md-12 mb-3">
                           <label><h3><strong> Profile Image</strong></h3></label>
                       </div>
                       @if($employee_details)
                       @foreach($employee_details as $employee_detail)
                      <div class="col-lg-3 col-xs-6 b-r">
                      
                      <img src="{{($employee_detail->image?$employee_detail->image:asset('assets/images/dummy.jpg'))}}">
                       </div>
                      @endforeach
                      @else
                      <div class="col-lg-3 col-xs-6 b-r">
                        <img src="{{ asset('assets/images/dummy1.jpg')}}" alt="user" class="img-responsive ">
                      </div>
                      @endif
                  </div> 
                
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
                    
                    <div class="col-lg-6 col-xs-6 b-r"> <h4>Employee Id ={{$employee_detail->id}}</h4>
                   
                        <!--<p class="text-muted"></p>-->
                    </div>
                   
                   
                </div>
                
                <div class="row mt-4">
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Sr no.</label>
                        <br>
                        <p class="text-muted">{{$employee_detail->id}}</p>
                    </div>
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Branch name</label>
                        <br>
                        <p class="text-muted">{{$employee_detail->branch_id}}</p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Employee Name</label>
                        <br>
                        <p class="text-muted">{{$employee_detail->employee_name}}</p>
                    </div>
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Country Code</label>
                        <br>
                        <p class="text-muted">{{$employee_detail->country_code}}</p>
                    </div>
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Mobile Number</label>
                        <br>
                        <p class="text-muted">{{$employee_detail->mobile_number}}</p>
                    </div>
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Email</label>
                        <br>
                        <p class="text-muted">{{$employee_detail->email}}</p>
                    </div>
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Local Address</label>
                        <br>
                        <p class="text-muted">{{$employee_detail->local_address}}</p>
                    </div>
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Nationality</label>
                        <br>
                        <p class="text-muted">{{$employee_detail->nationality}}</p>
                    </div>
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Age</label>
                        <br>
                        <p class="text-muted">{{$employee_detail->age}}</p>
                    </div>
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Gender</label>
                        <br>
                        <p class="text-muted">{{$employee_detail->gender}}</p>
                    </div>
                    

                </div>
               
      

            </div>
        </div> 
    
        <div class="card">

            <div class="card-body">
                <h3><strong>Id Proof Image</strong></h3>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="product-block pt-0">
                            <div class="inner-box">
                                <div class="row mt-4">

                                    <!--<div class="image-box">-->
                                   
                                    <div class="col-md-3">
                                        <figure class="image">
                                        <img src="{{($employee_detail->image?$employee_detail->id_image_front:asset('assets/images/dummy.jpg'))}}"> 
                                        </figure>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <figure class="image">
                                        <img src="{{($employee_detail->image?$employee_detail->id_image_back:asset('assets/images/dummy.jpg'))}}"> 
                                        </figure>
                                    </div>
                                    
                                    <!--</div>-->

                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
       
       
    </div>
   
    @endsection