@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>
            Help & Support</h1> 
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Help & Support Management</li>
        </ol>
    </div>
    <div class="content"> 
        <div class="card">
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
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Full Name</th>
                                <th>Email Id</th>
                                <th>Mobile Number</th>
                                <th>Date & Time</th> 
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($query)
                            @foreach($query as $k=>$q)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$q->username}}</td>
                                <td>{{$q->email}}</td>
                                <td>{{$q->mobile}}</td>
                                <td>{{date('d M Y h:iA',strtotime($q->created_at))}}</td>
                                <td><?= $q->status ? '<span class="text-success">Replied</span>' : '<span class="text-danger">Not replied</span>' ?> </td> 
                                <td><a href="{{url('admin/help-n-support-detail/'.base64_encode($q->id))}}" class="composemail-edit"><i class="fa fa-eye"></i></a></td>
                            </tr> 
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>


    <!--    <div class="modal fade modal-design" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label >Full Name</label>
                                <input type="text" class="form-control">
                            </div>
                            <label >Mobile Number</label>
                            <div class="input-group mb-3">  
                                <div class="input-group-append ">
                                    <select aria-invalid="false" class="valid">
                                        <option>+222</option>
                                        <option>+999</option>
                                        <option>+111</option>
                                    </select>
                                </div>
                                <input type="text" class="form-control br-tl-3  br-bl-3" placeholder="">
                            </div>
                            <div class="form-group">
                                <label >Password</label>
                                <input type="text" class="form-control">
                            </div>
                            <a class="composemail-edit mt-4 pull-right">Add</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>-->
    @endsection