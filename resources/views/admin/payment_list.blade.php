@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Payment Management</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Payment Management</li>
        </ol>
    </div>
    <div class="content">
        <div class="row mb-2">
            <div class="col-lg-3 col-xs-6 m-b-3">
                <div class="form-inline">
                    <label>From: </label>
                    <input type="date" name="" class="form-control">
                </div>
            </div>
            <div class="col-lg-3 col-xs-6 m-b-3">
                <div class="form-inline">
                    <label>To: </label>
                    <input type="date" name="" class="form-control">
                </div>
            </div> 
            <div class="col-lg-3 col-xs-6 m-b-3">
                <button class="btn btn-primary pt-2 pb-2">Search</button>
            </div>     
        </div>
        <div class="card">
            <div class="card-body"> 
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>User Name</th>  
                                <th>Date & Time</th> 
                                <th>Amount</th>
                                <th>Booking Id</th>
                                <th>Status</th> 
                            </tr>
                        </thead>
                        <tbody>
<!--                            <tr>
                                <td>01</td> 
                                <td>Pavan Jain</td> 
                                <td>01/02/2020 10:20AM</td>
                                <td>100 USD</td>
                                <td>COD</td>
                                <td><span class="text-warning">Pending</span></td>  
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<!--        <div class="row mb-2 mt-3">
            <div class="col-lg-3 col-xs-6 m-b-3">
                <div class="form-group"> 
                    <input type="text" name="" class="form-control">
                </div>
            </div>
            <div class="col-lg-3 col-xs-6 m-b-3">
                <div class="form-group"> 

                    <button class=" btn btn-primary pt-2 pb-2">Amount</button>
                </div>
            </div>
        </div>-->
    </div> 
    @endsection