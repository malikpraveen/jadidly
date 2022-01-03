@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Support Reason</h1>
        <ol class="breadcrumb">
            <li><a href="<?=url('admin/home')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Support Reason</li>
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
                        <h5 class="card-title">Edit Subject</h5>
                    </div>
                    <form method="post" id="addForm">
                        @csrf
                        <div class="card-body"> 
                            <div class="row">
                                <div class="col-md-6 mb-4 offset-3"> 
                                    <div class="col-md-12 mb-4">
                                        <label>Subject (En)</label>
                                        <input type="text" maxlength="250" class="form-control validate alphanum" value="{{old('subject_en')?old('subject_en'):$subject->subject_en}}" name="subject_en" placeholder="Subject (En)">
                                        <p class="text-danger" id="subject_enError">{{$errors->first('subject_en')}}</p>
                                    </div> 
                                    <div class="col-md-12 mb-4">
                                        <label>Subject (Ar)</label>
                                        <input type="text" maxlength="250" class="form-control validate arabicinput" value="{{old('subject_ar')?old('subject_ar'):$subject->subject_ar}}" name="subject_ar" placeholder="Subject (Ar)">
                                        <p class="text-danger" id="subject_arError">{{$errors->first('subject_ar')}}</p>
                                    </div>
                                </div>

                                <div class="col-md-12"> 
                                    <!--<button type="button" onclick="validate(this);" class="mybtns-upload">Submit</button>--> 
                                    <button type="submit" name="submit" id="submitButton" class="mybtns-upload">Submit</button> 
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div> 
        </div>
    </div>
    @endsection
