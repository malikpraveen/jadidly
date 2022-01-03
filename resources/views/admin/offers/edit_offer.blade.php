@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Edit Management</h1>
        <ol class="breadcrumb">
            <li><a href="<?=url('admin/home')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Offer Management</li>
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
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Offer</h5>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body"> 
                            <div class="row">
                                <div class="col-md-12 mb-2"> 
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label>Offer Name</label>
                                            <input type="text" class="form-control" name="name" value="{{old('name')?old('name'):$offer->name}}" placeholder="">
                                            <p class="text-danger"><?= $errors->first('name'); ?></p>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label>Offer Name (Ar)</label>
                                            <input type="text" class="form-control" name="name_ar" value="{{old('name_ar')?old('name_ar'):$offer->name_ar}}" placeholder="">
                                            <p class="text-danger"><?= $errors->first('name_ar'); ?></p>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label>Select Category</label>
                                            <select class="form-control" name="category_id">
                                                <option value="" selected disabled=""></option>
                                                @if($category_list)
                                                @foreach($category_list as $category)
                                                <option value="{{$category->id}}" <?= old('category_id') ? (old('category_id') == $category->id ? 'selected' : '') : ($offer->category_id == $category->id ? 'selected' : '') ?>>{{$category->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <p class="text-danger"><?= $errors->first('category_id'); ?></p>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label>Offer Discount (%)</label>
                                            <input type="text" min="1" max="100" class="form-control" value="{{old('percentage')?old('percentage'):$offer->percentage}}" name="percentage" placeholder="">
                                            <p class="text-danger"><?= $errors->first('percentage'); ?></p>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label>Description</label>
                                            <textarea class="form-control" name="description" placeholder="">{{old('description')?old('description'):$offer->description}}</textarea>
                                            <p class="text-danger"><?= $errors->first('description'); ?></p>
                                        </div> 
                                        <div class="col-md-6 mb-4">
                                            <label>Description (Ar)</label>
                                            <textarea class="form-control" name="description_ar" placeholder="">{{old('description_ar')?old('description_ar'):$offer->description_ar}}</textarea>
                                            <p class="text-danger"><?= $errors->first('description_ar'); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 offset-3">
                                        <label for="validationCustom01">Banner Image (preferred image of aspect ration 12:5)</label>
                                        <input type="file" id="input-file-now-custom-1" data-show-remove="false" name="image" data-default-file="{{$offer->image}}" class="dropify" />  
                                        <p class="text-danger"><?= $errors->first('image'); ?></p>
                                    </div> 
                                </div>  
                            </div>
                        </div>
                        <div class="row  mb-4 text-center">
                            <div class="col-md-12"> 
                                <button type="submit" name="submit" class="mybtns-upload">Submit</button> 
                            </div>
                        </div>
                    </form>
                </div>
            </div> 

        </div>
    </div>
    @endsection