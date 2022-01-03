@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Brand Management</h1>
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
            <div class="col-md-6 offset-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Add New Brand</h5>
                    </div>
                    <div class="card-body">  
                        <form method="post" id="brandForm" enctype="multipart/form-data" action="{{route('admin.brand.store')}}">
                            @csrf
                            <div class="row">  
                                <div class="col-md-12"> 
                                    <label>Brand name (En)</label>
                                    <input type="text" name="brand_name" value="{{old('brand_name')}}" class="form-control"> 
                                    <p class="text-danger"><?= $errors->first('brand_name'); ?></p>
                                    <div class="md-4 mt-4"> 
                                        <label>Brand name (Ar)</label>
                                        <input type="text" name="brand_name_ar" value="{{old('brand_name_ar')}}" class="form-control">
                                        <p class="text-danger"><?= $errors->first('brand_name_ar'); ?></p>
                                    </div>
                                    <div class="md-4 mt-4"> 
                                        <label for="validationCustom01">Brand Icon</label>
                                        <span class="text-muted">(Preferred image dimension 200*200)</span>
                                        <input data-default-file="{{old('image')}}" type="file" accept=".png" name="image" value="{{old('image')}}" id="input-file-now-custom-1" class="dropify" onchange="validImage(this, 200, 200);"/>  
                                        <p class="text-danger" id="img_error"><?= $errors->first('image'); ?></p>
                                    </div> 
                                </div>
                            </div>  

                            <div class="text-right mt-4 mb-4"> 
                                <button type="submit" id="submitButton" class="mybtns">Submit</button>
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
                        <h5 class="card-title">Brand List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-image">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr.No.</th> 
                                        <th>Brand Name (En)</th> 
                                        <th>Brand Name (Ar)</th>
                                        <th>Brand icon</th>      

                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($brands)
                                    @foreach($brands as $key=>$brand)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$brand->brand_name}}</td>
                                        <td>{{$brand->brand_name_ar}}</td>
                                        <td><img src="{{$brand->image?$brand->image:asset('assets/images/dummy-icon.jpg')}}"></td>
                                        <td>
                                            <div class="mytoggle">
                                                <label class="switch">
                                                    <input type="checkbox" <?= $brand->status == 'active' ? 'checked' : '' ?> onchange="changeStatus(this,<?= $brand->id ?>);">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{url('admin/edit-brand/'.base64_encode($brand->id))}}" class="composemail-edit"><i class="fa fa-edit"></i></a>
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
                text: "Brand status will be updated",
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
                                    data: 'id=' + id + '&action=' + status + '&type=brands' + '&_token=<?= csrf_token() ?>',
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