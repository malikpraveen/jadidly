@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Cancellation Reason</h1>
        <ol class="breadcrumb">
            <li><a href="<?=url('admin/home')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Cancellation Reason</li>
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
                        <h5 class="card-title">Edit Reason</h5>
                    </div>
                    <form method="post" id="addForm">
                        @csrf
                        <div class="card-body"> 
                            <div class="row">
                                <div class="col-md-6 mb-4 offset-3"> 
                                    <div class="col-md-12 mb-4">
                                        <label>Reason (En)</label>
                                        <input type="text" maxlength="250" class="form-control validate alphanum" value="{{old('reason_en')?old('reason_en'):$reason->reason}}" name="reason_en" placeholder="Reason (En)">
                                        <input name="parent_id" value="0" hidden>
                                        <p class="text-danger" id="reason_enError">{{$errors->first('reason_en')}}</p>
                                    </div> 
                                    <div class="col-md-12 mb-4">
                                        <label>Reason (Ar)</label>
                                        <input type="text" maxlength="250" class="form-control validate arabicinput" value="{{old('reason_ar')?old('reason_ar'):$reason->reason_ar}}" name="reason_ar" placeholder="Reason (Ar)">
                                        <p class="text-danger" id="reason_arError">{{$errors->first('reason_ar')}}</p>
                                    </div>

                                </div>

                                <div class="col-md-12"> 
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
    