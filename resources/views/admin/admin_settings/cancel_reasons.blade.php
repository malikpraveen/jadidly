@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Cancellation Reason</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
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
                        <h5 class="card-title">Add A Reason</h5>
                    </div>
                    <form method="post" id="addForm">
                        @csrf
                        <div class="card-body"> 
                            <div class="row">
                                <div class="col-md-6 mb-4 offset-3"> 
                                    <div class="col-md-12 mb-4">
                                        <label>Reason (En)</label>
                                        <input type="text" class="form-control validate alphanum" maxlength="250" name="reason_en" value="{{old('reason_en')}}" placeholder="Reason (En)">
                                        <input name="parent_id" value="0" hidden>
                                        <p class="text-danger" id="reason_enError">{{$errors->first('reason_en')}}</p>
                                    </div> 
                                    <div class="col-md-12 mb-4">
                                        <label>Reason (Ar)</label>
                                        <input type="text" class="form-control validate arabicinput" maxlength="250" name="reason_ar" value="{{old('reason_ar')}}" placeholder="Reason (Ar)">
                                        <p class="text-danger" id="reason_arError">{{$errors->first('reason_ar')}}</p>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label><input type="radio" name="type" value="admin"> Admin</label>
                                        <label><input type="radio" name="type" value="user" checked> User</label>
                                        <p class="text-danger" id="typeError">{{$errors->first('type')}}</p>
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





            <div class="col-md-12 mt-4">
                <div class="card"> 
                    <div class="card-header">
                        <h5 class="card-title">Reason List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-image">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Reason (En)</th>
                                        <th>Reason (Ar)</th>
                                        <th>Status</th> 
                                        <th>Action</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($reasons)
                                    @foreach($reasons as $key=>$reason)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$reason->reason}}</td>
                                        <td>{{$reason->reason_ar}}</td>
                                        <td>
                                            <div class="mytoggle">
                                                <label class="switch">
                                                    <input type="checkbox" onchange="changeCategoryStatus(this, '<?= $reason->id ?>');" <?= ($reason->status == 'active' ? 'checked' : '') ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </td> 
                                        <td>
                                            <a href="{{url("admin/edit-cancel-reason").'/'.base64_encode($reason->id)}}" class="composemail-edit"><i class="fa fa-edit"></i></a>
                                            <!--<a href="#" class="composemail-edit"><i class="fa fa-trash"></i></a>-->
                                        </td> 
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    <script>
        function changeCategoryStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: "Reason status will be updated",
                icon: "warning",
                buttons: ["No", "Yes"],
                dangerMode: true,
            })
                    .then((willDelete) => {
                        if (willDelete) {
                            var checked = $(obj).is(':checked');
                            if (checked == true) {
                                var status = 'active';
                            } else {
                                var status = 'inactive';
                            }
                            if (id) {
                                $.ajax({
                                    url: "<?= url('admin/change_status') ?>",
                                    type: 'post',
                                    data: 'id=' + id + '&type=reason' + '&action=' + status + '&_token=<?= csrf_token() ?>',
                                    success: function (data) {
                                        if (data.error_code == "200") {
                                            data.title = "Success!";
                                            successMessage(data);
                                        } else {
                                            errorOccured(data);
                                        }
                                    }
                                });
                            } else {
                                var data = {message: "Something went wrong"};
                                errorOccured(data);
                            }
                        } else {
                            var checked = $(obj).is(':checked');
                            if (checked == true) {
                                $(obj).prop('checked', false);
                            } else {
                                $(obj).prop('checked', true);
                            }
                            return false;
                        }
                    });
        }
    </script>
