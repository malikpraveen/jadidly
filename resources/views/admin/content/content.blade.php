@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Content Management</h1>
        <ol class="breadcrumb">
            <li><a href="<?=url('admin/home')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Content Management</li>
        </ol>
    </div>
    <div class="content">
        <div class="row mb-2"> 
            <div class="col-lg-12 col-xs-6">
                <a href="{{url('admin/edit-content')}}" class="composemail pull-right"><i class="fa fa-edit"></i></a>
            </div>     
        </div>
        <div class="card">
            <div class="card-body">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title text-bold f-18"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">About Us</a> </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="">
                            <div class="panel-body">{{$about_us->text_en}}</div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title text-bold f-18"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Privacy Policies</a> </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="">
                            <div class="panel-body">{{$privacy_policy->text_en}}</div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title text-bold f-18"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Terms & Condition</a> </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false">
                            <div class="panel-body">{{$terms_conditions->text_en}}</div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    @endsection