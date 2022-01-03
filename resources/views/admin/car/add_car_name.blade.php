@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Car Management</h1>
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
                        <h5 class="card-title">Add New Car</h5>
                    </div>
                    <div class="card-body"> 
                        <form method="post" id="brandForm" enctype="multipart/form-data" action="{{route('admin.car.store')}}">
                            @csrf
                            <div class="row pt-4 pb-4">
                                <div class="col-md-6 offset-3">
                                    <div class="col-md-12 mb-4">
                                        <label>Select Brand Name</label>
                                        <select class="form-control" name="brand_id">
                                            @if($brands)
                                            @foreach($brands as $brand)
                                            <option value="{{$brand->id}}" <?= old('brand_id') == $brand->id ? 'selected' : '' ?>>{{$brand->brand_name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <p class="text-danger"><?= $errors->first('brand_id'); ?></p>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label>Car Name(en)</label>
                                        <input type="text" name="car_name" value="{{old('car_name')}}" class="form-control">
                                        <p class="text-danger"><?= $errors->first('car_name'); ?></p>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label>Car Name(ar)</label>
                                        <input type="text" name="car_name_ar" value="{{old('car_name_ar')}}" class="form-control">
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
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Car List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-image">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr.No.</th> 
                                        <th>Brand</th>
                                        <th>Car Name (En)</th> 
                                        <th>Car Name (Ar)</th>      

                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($cars)
                                    @foreach($cars as $key=>$car)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$car->brand_name}}</td>
                                        <td>{{$car->car_name}}</td>
                                        <td>{{$car->car_name_ar}}</td>
                                        <td>
                                            <div class="mytoggle">
                                                <label class="switch">
                                                    <input type="checkbox"  onchange="changeStatus(this,<?= $car->id ?>);" <?= $car->status == 'active' ? 'checked' : '' ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{url('admin/edit-car/'.base64_encode($car->id))}}" class="composemail-edit"><i class="fa fa-edit"></i></a>
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
        function changeStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: "Car status will be updated",
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
                                    data: 'id=' + id + '&action=' + status + '&type=brand_cars' + '&_token=<?= csrf_token() ?>',
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