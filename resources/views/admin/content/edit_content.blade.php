@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Edit Content</h1>
        <ol class="breadcrumb">
            <li><a href="<?=url('admin/home')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Edit Content</li>
        </ol>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
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
            </div>
        </div>
        <div class="card">
            <form method='post' action="{{route('admin.content.update')}}">
                @csrf
                <div class="card-body">   
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="firstName1">About Us (English)</label>
                                <textarea class="form-control" name="about_us" cols="6" rows="6" placeholder="add about us">{{$about_us->text_en}}</textarea>
                                <p class="text-danger">{{$errors->first('about_us')}}</p>
                            </div>
                        </div>
                    </div> 
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="firstName1">About Us (Arabic)</label>
                                <textarea class="form-control" name="about_us_ar" cols="6" rows="6" placeholder="أضف عنا">{{$about_us->text_ar}}</textarea>
                                <p class="text-danger">{{$errors->first('about_us_ar')}}</p>
                            </div>
                        </div>
                    </div> 
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="firstName1">Privacy & Policies (English)</label>
                                <textarea class="form-control" name="privacy_policy" cols="6" rows="6" placeholder="add privacy policy">{{$privacy_policy->text_en}}</textarea>
                                <p class="text-danger">{{$errors->first('privacy_policy')}}</p>
                            </div>
                        </div>
                    </div>  
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="firstName1">Privacy & Policies (Arabic)</label>
                                <textarea class="form-control" name="privacy_policy_ar" cols="6" rows="6" placeholder="أضف سياسة الخصوصية">{{$privacy_policy->text_ar}}</textarea>
                                <p class="text-danger">{{$errors->first('privacy_policy_ar')}}</p>
                            </div>
                        </div>
                    </div>  
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="firstName1">Terms & Conditions (English)</label>
                                <textarea class="form-control" name="terms_conditions" cols="6" rows="6" placeholder="add terms & condition">{{$terms_conditions->text_en}}</textarea>
                                <p class="text-danger">{{$errors->first('terms_conditions')}}</p>
                            </div>
                        </div>
                    </div> 
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="firstName1">Terms & Conditions (Arabic)</label>
                                <textarea class="form-control" name="terms_conditions_ar" cols="6" rows="6" placeholder="أضف الشروط والشرط">{{$terms_conditions->text_ar}}</textarea>
                                <p class="text-danger">{{$errors->first('terms_conditions_ar')}}</p>
                            </div>
                        </div>
                    </div> 
                    <div class="row mt-4">
                        <div class="col-md-12"> 
                            <button type="submit" class="mybtns pull-right">Save Content</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endsection