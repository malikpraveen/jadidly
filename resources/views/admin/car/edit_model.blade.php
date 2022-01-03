@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Edit Model</h1>
        <ol class="breadcrumb">
            <li><a href="<?=url('admin/home')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Edit Model</li>
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
                        <h5 class="card-title">Edit Model</h5>
                    </div>
                    <div class="card-body">  
                        <form method="post" id="brandForm" action="{{route('admin.model.update',[base64_encode($model->id)])}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label>Select Brand Name</label>
                                    <select class="form-control" name="brand_id" onchange="getCarList(this);">
                                        @if($brands)
                                        @foreach($brands as $brand)
                                        <option value="{{$brand->id}}" <?= old('brand_id') == $brand->id ? 'selected' : ($model->brand_id == $brand->id ? 'selected' : '') ?>>{{$brand->brand_name}}</option>
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
                                        @if($brand->id == $model->brand_id && $brand->brand_cars)
                                        @foreach($brand->brand_cars as $cars)
                                        <option value="{{$cars->id}}" <?= old('car_id') == $cars->id ? 'selected' : ($model->car_id == $cars->id ? 'selected' : '') ?>>{{$cars->car_name}}</option>
                                        @endforeach
                                        @endif
                                        @endforeach
                                        @endif
                                    </select>
                                    <p class="text-danger"><?= $errors->first('car_id'); ?></p>
                                </div>  
                                <div class="col-md-6 mb-4">  
                                    <label>Model Name (en)</label>
                                    <input type="text" name="model_name" value="{{old('model_name')?old('model_name'):$model->model_name}}" class="form-control">
                                    <p class="text-danger"><?= $errors->first('model_name'); ?></p>
                                </div>
                                <div class="col-md-6 mb-4">  
                                    <label>Model Name (ar)</label>
                                    <input type="text" name="model_name_ar" value="{{old('model_name_ar')?old('model_name_ar'):$model->model_name_ar}}" class="form-control"> 
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
            var confirm_chk = confirm('Are you sure to change status?');
            if (confirm_chk) {
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
                                alert(data.message);
                                location.reload();
                            } else {
                                alert(data.message);
                            }
                        }
                    });
                } else {
                    alert("Something went wrong");
                }
            } else {
                return false;
            }
        }
    </script>