@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Offer Management</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Offer Management</li>
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
                        <h5 class="card-title">Add A Offer</h5>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body"> 
                            <div class="row">
                                <div class="col-md-12 mb-2"> 
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label>Offer Name</label>
                                            <input type="text" class="form-control mandate" name="name" value="{{old('name')}}" placeholder="">
                                            <p class="text-danger" id="nameError"><?= $errors->first('name'); ?></p>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label>Offer Name (Ar)</label>
                                            <input type="text" class="form-control mandate" name="name_ar" value="{{old('name_ar')}}" placeholder="">
                                            <p class="text-danger" id="name_arError"><?= $errors->first('name_ar'); ?></p>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label>Select Category</label>
                                            <select class="form-control mandate" name="category_id">
                                                <option value="" selected disabled=""></option>
                                                @if($category_list)
                                                @foreach($category_list as $category)
                                                <option value="{{$category->id}}" <?= old('category_id') == $category->id ? 'selected' : '' ?>>{{$category->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <p class="text-danger" id="category_idError"><?= $errors->first('category_id'); ?></p>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label>Offer Discount (%)</label>
                                            <input type="text" min="1" max="100" class="form-control mandate numberOnly" value="{{old('percentage')?old('percentage'):''}}" name="percentage" placeholder="">
                                            <p class="text-danger" id="percentageError"><?= $errors->first('percentage'); ?></p>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label>Description</label>
                                            <textarea class="form-control mandate" maxlength="200" name="description" placeholder="">{{old('description')}}</textarea>
                                            <p class="text-danger" id="descriptionError"><?= $errors->first('description'); ?></p>
                                        </div> 
                                        <div class="col-md-6 mb-4">
                                            <label>Description (Ar)</label>
                                            <textarea class="form-control mandate" maxlength="200" name="description_ar" placeholder="">{{old('description_ar')}}</textarea>
                                            <p class="text-danger" id="description_arError"><?= $errors->first('description_ar'); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 offset-3">
                                        <label for="validationCustom01">Banner Image (preferred image of aspect ration 12:5)</label>
                                        <input type="file" id="input-file-now-custom-1" name="image" class="dropify mandate" />  
                                        <p class="text-danger" id="imageError"><?= $errors->first('image'); ?></p>
                                    </div> 
                                </div>  
                            </div>
                        </div>
                        <div class="row  mb-4 text-center">
                            <div class="col-md-12"> 
                                <button type="button" onclick="checkbeforeadd(this);" name="submit" class="mybtns-upload">Submit</button> 
                                <button type="submit"  id="submitBtn" hidden name="submit" class="mybtns-upload">Submit</button> 
                            </div>
                        </div>
                    </form>
                </div>
            </div> 





            <div class="col-md-12 mt-4">
                <div class="card"> 
                    <div class="card-header">
                        <h5 class="card-title">Offer List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-image">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Offer Name</th>
                                        <th>Category Name</th>
                                        <th>Banner Image</th>
                                        <th>Added on & at</th> 
                                        <th>Offer Percent</th> 
                                        <th>Status</th> 
                                        <th>Action</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($offers)
                                    @foreach($offers as $key=>$offer)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$offer->name}}</td>
                                        <td>{{$offer->category_name}}</td>
                                        <td><img src="{{$offer->image?$offer->image:asset('assets/images/dummy.jpg')}}"></td>
                                        <td>{{date('d-m-Y h:i A',strtotime($offer->created_at))}}</td>
                                        <td class='text-primary'>{{$offer->percentage}}%</td>
                                        <td>
                                            <div class="mytoggle">
                                                <label class="switch">
                                                    <input onchange="changeCategoryStatus(this, '<?= $offer->id ?>');" type="checkbox" <?= $offer->status == 'active' ? 'checked' : '' ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </td> 
                                        <td>
                                            <a href="<?= url('admin/edit-offer/' . base64_encode($offer->id)) ?>" class="composemail-edit"><i class="fa fa-edit"></i></a>
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
        function checkbeforeadd(obj) {
            var flag = 1;
            var allInput = $(".mandate");
            $(allInput).each(function (i, v) {
                if ($(v).val() == "" || $(v).val() == 0) {
                    flag = 0;
                    $("#" + ($(v).attr('name')) + "Error").html("This field is required");
                } else {
                    $("#" + ($(v).attr('name')) + "Error").html("");
                }
            });
            if (flag) {
//                var conf = confirm('Any active offer on this category will be turned off and will not be available for users to apply. Continue?');
//                if (conf) {
                swal({
                    title: "Are you sure to continue?",
                    text: "Any active offer on this category will be turned off and will not be available for users to apply.",
                    icon: "warning",
                    buttons: ["No", "Yes"],
                    dangerMode: true,
                })
                        .then((willDelete) => {
                            if (willDelete) {
                                $("#submitBtn").click();
                                return true;
                            } else {
                                return false;
                            }
                        });
            }
        }
    </script>
    <script>
        function changeCategoryStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: "Offer status will be updated",
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
                                    data: 'id=' + id + '&type=offer' + '&action=' + status + '&_token=<?= csrf_token() ?>',
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