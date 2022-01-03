@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Edit Brand</h1>
        <ol class="breadcrumb">
            <li><a href="<?=url('admin/home')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Edit Brand</li>
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
            <div class="col-md-6 offset-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Brand</h5>
                    </div>
                    <div class="card-body">  
                        <form method="post" id="brandForm" enctype="multipart/form-data" action="{{route('admin.brand.update',[base64_encode($brand->id)])}}">
                            @csrf
                            <div class="row">  
                                <div class="col-md-12"> 
                                    <label>Brand name (En)</label>
                                    <input type="text" name="brand_name" value="{{old('brand_name')?old('brand_name'):$brand->brand_name}}" class="form-control"> 
                                    <p class="text-danger"><?= $errors->first('brand_name'); ?></p>
                                    <div class="md-4 mt-4"> 
                                        <label>Brand name (Ar)</label>
                                        <input type="text" name="brand_name_ar" value="{{old('brand_name_ar')?old('brand_name_ar'):$brand->brand_name_ar}}" class="form-control">
                                        <p class="text-danger"><?= $errors->first('brand_name_ar'); ?></p>
                                    </div>
                                    <div class="md-4 mt-4"> 
                                        <label for="validationCustom01">Brand Icon</label>
                                        <span class="text-muted">(Preferred image dimension 200*200)</span>
                                        <input data-default-file="{{$brand->image}}" type="file" accept=".png" name="image" value="{{old('image')}}" id="input-file-now-custom-1" class="dropify" onchange="validImage(this, 200, 200);"/>  
                                        <p class="text-danger" id="img_error"><?= $errors->first('image'); ?></p>
                                    </div> 
                                </div>
                            </div>  

                            <div class="text-right mt-4 mb-4"> 
                                <button type="submit" id="submitButton" class="mybtns">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>  
    </div>
    @endsection
    