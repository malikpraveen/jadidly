@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Sub Admin Detail</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Sub Admin Management</li>
        </ol>
    </div>
    <div class="content"> 
        <div class="card">
            <div class="card-body"> 
                <div class="row">
                    <!--                    <div class="col-lg-6">
                                            <label>Sr. No.</label>
                                            <p>{{$admin->id}}</p> 
                                        </div>-->
                    <div class="col-lg-6">
                        <label>Full Name</label>
                        <p>{{$admin->name}}</p> 
                    </div>
                    <div class="col-lg-6">
                        <label>Email Id</label>
                        <p>{{$admin->email}} </p> 
                    </div>
                </div>
                <div class="row mt-4">

                    <div class="col-lg-6">
                        <label>Password</label>
                        <p>{{$admin->pass_key}}</p> 
                    </div>
                </div> 
                <div class="row mt-4">
                    <div class="col-md-12">
                        @if($admin['permissions'])
                        @foreach($admin['permissions'] as $permission)
                        <button type="button" class="btn btn-rounded btn-primary mb-4">{{$permission->name}}</button> 
                        @endforeach
                        @endif
                    </div>
                </div>  
            </div> 
        </div>
    </div> 
    @endsection