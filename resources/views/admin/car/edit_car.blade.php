@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Edit Car Name</h1>
        <ol class="breadcrumb">
            <li><a href="<?=url('admin/home')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Edit Car Name</li>
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
                    <div class="card-body"> 
                        <form method="post" id="brandForm" action="{{route('admin.car.update',[base64_encode($car->id)])}}">
                            @csrf
                            <div class="row pt-4 pb-4">
                                <div class="col-md-6 offset-3">
                                    <div class="col-md-12 mb-4">
                                        <label>Select Brand Name</label>
                                        <select class="form-control" name="brand_id">
                                            @if($brands)
                                            @foreach($brands as $brand)
                                            <option value="{{$brand->id}}" <?= old('brand_id') == $brand->id?'selected': ($car->brand_id == $brand->id ? 'selected' : '' )?>>{{$brand->brand_name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <p class="text-danger"><?= $errors->first('brand_id'); ?></p>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label>Car Name(en)</label>
                                        <input type="text" name="car_name" value="{{old('car_name')?old('car_name'):$car->car_name}}" class="form-control">
                                        <p class="text-danger"><?= $errors->first('car_name'); ?></p>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label>Car Name(ar)</label>
                                        <input type="text" name="car_name_ar" value="{{old('car_name_ar')?old('car_name_ar'):$car->car_name_ar}}" class="form-control">
                                        <p class="text-danger"><?= $errors->first('car_name_ar'); ?></p>
                                    </div>  
                                </div> 
                            </div>
                            <div class="row mb-4 mt-2"> 
                                <div class="col-md-6 offset-3 text-center"> 
                                    <button type="submit" class="mybtns-upload">Submit</button>  
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
                        data: 'id=' + id + '&action=' + status + '&type=brand_cars' + '&_token=<?= csrf_token() ?>',
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