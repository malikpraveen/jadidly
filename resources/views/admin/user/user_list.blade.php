@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>User List</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> User List</li>
        </ol>
    </div>
    <div class="content">
        <div class="row mb-2">
            <div class="col-lg-12 col-md-12 col-sm-12">
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
        <form method="get">
            <div class="row mb-2">

                <div class="col-lg-4 col-xs-6 m-b-3">
                    <div class="form-inline">
                        <label class="col-md-3">From: </label>
                        <input type="date" name="start_date" value="{{old('start_date')}}" max="<?= date('Y-m-d') ?>" onchange="$('#end_date').attr('min', $(this).val());" class="form-control">
                    </div>
                </div>
                <div class="col-lg-4 col-xs-6 m-b-3">
                    <div class="form-inline">
                        <label class="col-md-3">To: </label>
                        <input type="date" name="end_date" id="end_date" value="{{old('end_date')}}" max="<?= date('Y-m-d') ?>" class="form-control">
                    </div>
                </div> 
                <div class="col-lg-4 col-xs-6 m-b-3">
                    <button class="btn btn-primary pt-2 pb-2">Search</button>
                    <a class="btn btn-primary pt-2 pb-2" href="{{url('admin/user-management')}}">Reset</a>
                </div>  

            </div>
        </form>
        <div class="card">
            <div class="card-body"> 
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>User Name</th> 
                                <th>Email Id</th> 
                                <th>Mobile No.</th> 
                                <th>Registration Date</th> 
                                <th>Status</th>
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @if($user_list)
                            @foreach($user_list as $k=>$user)
                            <tr>
                                <td>{{$k+1}}</td> 
                                <td>{{$user->name}}</td>
                                <td>{{($user->email?$user->email:'-')}}</td> 
                                <td>+{{$user->country_code.' '.$user->mobile_number}}</td>
                                <td>{{date('d M Y H:i:s',strtotime($user->created_at))}}</td>
                                <td>
                                    <?php if ($user->is_otp_verified == 'yes') { ?>
                                        <div class="mytoggle">
                                            <label class="switch">
                                                <input type="checkbox" <?= $user->status == 'active' ? 'checked' : '' ?> onchange="changeStatus(this,<?= $user->id ?>);"> <span class="slider round"></span> </label>
                                        </div>
                                        <?php
                                    } else {
                                        echo 'inactive';
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <a href="{{url('admin/user-detail/'.base64_encode($user->id))}}" class="composemail-edit">
                                        <i class="fa fa-eye"></i>
                                    </a>
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
    @endsection
    <script>
        function changeStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: "User status will be updated",
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
                                var status = 'blocked';
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
