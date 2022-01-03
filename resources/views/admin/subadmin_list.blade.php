@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Sub Admin Management</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Sub Admin Management</li>
        </ol>
    </div>
    <div class="content"> 
        <div class="row mb-4">
            <div class="col-md-12">
                <a href="<?= url('admin/add-subadmin'); ?>" class="mybtns pull-right">Add a sub admin</a>
            </div>
        </div>
        <div class="row">  
            <div class="col-md-12">
                <div class="card"> 
                    <div class="card-header">
                        <h5 class="card-title">Sub admin List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-image">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Full Name</th>
                                        <th>Email Id</th>
                                        <th>Created on & at</th> 
                                        <th>Status</th> 
                                        <th>Action</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($admins)
                                    @foreach($admins as $k=>$admin)
                                    <tr>
                                        <td>{{$k+1}}</td>
                                        <td>{{$admin->name}}</td>
                                        <td>{{$admin->email}}</td>
                                        <td>{{$admin->created_at}}</td>
                                        <td>
                                            <div class="mytoggle">
                                                <label class="switch">
                                                    <input type="checkbox" onchange='changeCategoryStatus(this, "<?= $admin->id ?>");' <?= $admin->status == 'active' ? 'checked' : '' ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </td> 
                                        <td>
                                            <a href="<?= url('admin/edit-subadmin/' . base64_encode($admin->id)); ?>" class="composemail-edit"><i class="fa fa-edit"></i></a>
                                            <a href="<?= url('admin/subadmin-detail/' . base64_encode($admin->id)); ?>" class="composemail-edit"><i class="fa fa-eye"></i></a>
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
    <script>
        function changeCategoryStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: "Subadmin status will be updated",
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
                                    data: 'id=' + id + '&type=users' + '&action=' + status + '&_token=<?= csrf_token() ?>',
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
    @endsection