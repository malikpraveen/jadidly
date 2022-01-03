@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Service Management</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Service Management</li>
        </ol>
    </div>
    <div class="content"> 
        <div class="row mb-4">
            <div class="col-md-12">
                <a href="{{url('admin/add-service')}}" class="mybtns pull-right">Add New Service</a>
            </div>
        </div>
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
                        <h5 class="card-title">Service List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-image">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Service Name</th>
                                        <th>Category Name</th> 
                                        <th>Status</th> 
                                        <th>Action</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($services)
                                    @foreach($services as $key=>$service)
                                    <?php
                                    $category = DB::table('categories')->where('id', $service->category_id)->get()->first();
                                    if ($category) {
                                        $service->category_name = $category->name;
                                        if ($category->parent_id) {
                                            $parent_1 = DB::table('categories')->where('id', $category->parent_id)->first();
                                            $service->category_name = $parent_1->name;
                                            if ($parent_1->parent_id) {
                                                $parent_2 = DB::table('categories')->where('id', $parent_1->parent_id)->first();
                                                $service->category_name = $parent_2->name;
                                                if ($parent_2->parent_id) {
                                                    $parent_3 = DB::table('categories')->where('id', $parent_2->parent_id)->first();
                                                    $service->category_name = $parent_3->name;
                                                }
                                            }
                                        }
                                    } else {
                                        $service->category_name = 'N/A';
                                    }
                                    ?>
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$service->name}}</td>
                                        <!--<td>{{!empty($service->getServiceCategory) ? $service->getServiceCategory->name : 'N/A'}}</td>-->
                                        <td>{{$service->category_name}}</td>
                                        <td>
                                            <div class="mytoggle">
                                                <label class="switch">
                                                    <input type="checkbox" onchange="changeServiceStatus(this, '<?= $service->id ?>');" <?= ($service->status == '1' ? 'checked' : '') ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </td> 
                                        <td>
                                            <a href="{{url('admin/edit-service').'/'.base64_encode($service->id)}}" class="composemail-edit"><i class="fa fa-edit"></i></a>
                                            <a href="{{url('admin/service-detail').'/'.base64_encode($service->id)}}" class="composemail-edit"><i class="fa fa-eye"></i></a>
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
        function changeServiceStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: "Service status will be updated",
                icon: "warning",
                buttons: ["No", "Yes"],
                dangerMode: true,
            })
                    .then((willDelete) => {
                        if (willDelete) {
                            var checked = $(obj).is(':checked');
                            if (checked == true) {
                                var status = 1;
                            } else {
                                var status = 0;
                            }
                            if (id) {
                                $.ajax({
                                    url: "<?= url('admin/service/change_service_status') ?>",
                                    type: 'post',
                                    data: 'id=' + id + '&action=' + status + '&_token=<?= csrf_token() ?>',
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