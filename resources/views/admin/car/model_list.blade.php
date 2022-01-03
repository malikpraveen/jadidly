@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Model Management</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Car Management</li>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Add a Model</h5>
                    </div>
                    <div class="card-body">  
                        <form method="post" id="brandForm" enctype="multipart/form-data" action="{{route('admin.model.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label>Select Brand Name</label>
                                    <select class="form-control" name="brand_id" onchange="getCarList(this);">
                                        @if($brands)
                                        @foreach($brands as $brand)
                                        <option value="{{$brand->id}}" <?= old('brand_id') == $brand->id ? 'selected' : '' ?>>{{$brand->brand_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <p class="text-danger"><?= $errors->first('brand_id'); ?></p>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label>Select Car</label>
                                    <select class="form-control" name="car_id" id="carlist">
                                        @if($brands)
                                        @foreach($brands as $key=>$brand)
                                        @if($key == 0 && $brand->brand_cars)
                                        @foreach($brand->brand_cars as $cars)
                                        <option value="{{$cars->id}}" <?= old('car_id') == $cars->id ? 'selected' : '' ?>>{{$cars->car_name}}</option>
                                        @endforeach
                                        @endif
                                        @endforeach
                                        @endif
                                    </select>
                                    <p class="text-danger"><?= $errors->first('car_id'); ?></p>
                                </div>  
                                <div class="col-md-6 mb-4">  
                                    <label>Model Name (en)</label>
                                    <input type="text" name="model_name" value="{{old('model_name')}}" class="form-control">
                                    <p class="text-danger"><?= $errors->first('model_name'); ?></p>
                                </div>
                                <div class="col-md-6 mb-4">  
                                    <label>Model Name (ar)</label>
                                    <input type="text" name="model_name_ar" value="{{old('model_name_ar')}}" class="form-control"> 
                                    <p class="text-danger"><?= $errors->first('model_name_ar'); ?></p>
                                </div>
                                <!--                            <div class="col-md-6"> 
                                                                <label for="validationCustom01">Model Icon</label>
                                                                <input type="file" id="input-file-now-custom-1" class="dropify"/> 
                                                            </div>-->

                                <div class=" col-md-12 text-right mt-4 mb-4"> 
                                    <button class="mybtns">Submit</button>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div> 
            </div>
        </div>
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Model List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-image">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th> 
                                    <th>Brand Name</th> 
                                    <th>Car Name</th> 
                                    <th>Model Name(en)</th> 
                                    <th>Model Name(ar)</th> 
                                    <!--<th>Model icon</th>-->    
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($models)
                                @foreach($models as $key=>$model)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$model->brand_name}}</td>
                                    <td>{{$model->car_name}}</td>
                                    <td>{{$model->model_name}}</td>
                                    <td>{{$model->model_name_ar}}</td>
                                    <!--<td><img src="common/images/dummy.jpg"></td>-->
                                    <td>
                                        <div class="mytoggle">
                                            <label class="switch">
                                                <input type="checkbox" onchange="changeStatus(this,<?= $model->id ?>);" <?= $model->status == 'active' ? 'checked' : '' ?>>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{url('admin/edit-model/'.base64_encode($model->id))}}" class="composemail-edit"><i class="fa fa-edit"></i></a>
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
    @endsection
    <script>
        function getCarList(obj) {
            $("#carlist").empty();
            var brand_id = $(obj).val();
            var brandlist =<?= json_encode($brands) ?>;
            $(brandlist).each(function (i, v) {
                var html = "";
                if (v.id == brand_id) {
                    var carlist = v.brand_cars;

                    if (carlist) {
                        $(carlist).each(function (j, val) {
                            html += "<option value='" + val.id + "'>" + val.car_name + "</option>";
                        });
                    }
                }
                $("#carlist").append(html);
            });
        }
    </script>
    <script>
        function changeStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: "Model status will be updated",
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
                                    url: "<?= url('admin/cars/change_status') ?>",
                                    type: 'post',
                                    data: 'id=' + id + '&action=' + status + '&type=model_names' + '&_token=<?= csrf_token() ?>',
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