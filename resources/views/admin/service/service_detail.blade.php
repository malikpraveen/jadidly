@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Service Detail</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Service Detail</li>
        </ol>
    </div>
    <div class="content">
        <!--        <div class="row mb-3"> 
                   <div class="col-md-12">  
                       <a href="#" class="mybtns-edit pull-right"><i class="fa fa-edit"></i></a>
                         <div class="mytoggle pull-right mr-3">
                                       <label class="switch">
                                           <input type="checkbox" checked="">
                                           <span class="slider round"></span>
                                       </label>
                                   </div> 

                   </div>
               </div> -->
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
        <div class="card">
            <div class="card-body">  
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Service Images</label>
                    </div>
                    @if($service->images)
                    @foreach($service->images as $images)
                    <div class="col-lg-3 col-xs-6 b-r">
                        <a href="#"><img src="{{ ($images->image?$images->image:asset('assets/images/dummy.jpg'))}}" alt="user" class="img-responsive "></a>
                    </div>
                    @endforeach
                    @else
                    <div class="col-lg-3 col-xs-6 b-r">
                        <a href="#"><img src="{{ asset('assets/images/dummy.jpg')}}" alt="user" class="img-responsive "></a>
                    </div>
                    @endif
                </div> 
                <div class="row mt-4">
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Service Name</label>
                        <br>
                        <p class="text-muted">{{$service->name}}</p>
                    </div>
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Service Name (Ar)</label>
                        <br>
                        <p class="text-muted">{{$service->name_ar}}</p>
                    </div>

                </div>
                <!--                <div class="row mt-4">
                                    <div class="col-lg-6 col-xs-6 b-r"> <label>Service Sub- Category</label>
                                        <br>
                                        <p class="text-muted">{{$service->subcategory_name}}</p>
                                    </div>
                                    <div class="col-lg-6 col-xs-6 b-r"> <label>Service Price</label>
                                        <br>
                                        <p class="text-muted">{{$service->price}}</p>
                                    </div>
                                </div>-->
                <div class="row mt-4 mb-3">
                    <div class="col-lg-6 col-xs-6 b-r"> <label>Service Category</label>
                        <br>
                        <p class="text-muted">{{$service->category_name}}</p>
                    </div>
                    <div class="col-lg-6 col-xs-6 b-r"> <label><input disabled="" type="checkbox" name="" <?= ($service->is_pickup ? 'checked' : '') ?>> Pickup Available</label>
                    </div> 
                </div>
                <div class="row mt-4 mb-3">
                    <div class="col-lg-12 col-xs-12 b-r"> <label>Service Description (En)</label>
                        <br>
                        <p class="text-muted">{{$service->description}}</p>
                    </div>
                </div>
                <div class="row mt-4 mb-3">
                    <div class="col-lg-12 col-xs-12 b-r"> <label>Service Description (Ar)</label>
                        <br>
                        <p class="text-muted">{{$service->description_ar}}</p>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    @endsection
