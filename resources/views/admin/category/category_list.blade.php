@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Category Management</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Category Management</li>
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
                        <h5 class="card-title">Add A Category</h5>
                    </div>
                    <form method="post" id="addForm" enctype="multipart/form-data" action="{{route('admin.category.store')}}">
                        @csrf
                        <div class="card-body"> 
                            <div class="row">
                                <div class="col-md-6 mb-4 offset-3"> 
                                    <div class="col-md-12 mb-4">
                                        <label>Category Name (En)</label>
                                        <input type="text" class="form-control validate alphanum" name="category_name_en" placeholder="Category Name (En)">
                                        <input name="parent_id" value="0" hidden>
                                        <p class="text-danger" id="category_name_enError"></p>
                                    </div> 
                                    <div class="col-md-12 mb-4">
                                        <label>Category Name (Ar)</label>
                                        <input type="text" class="form-control validate arabicinput" name="category_name_ar" placeholder="Category Name (Ar)">
                                        <p class="text-danger" id="category_name_arError"></p>
                                    </div>
                                    <div class="col-md-12">
                                        <p class="">(Preferred image dimension 200*200)</p>
                                    </div>
                                    <div class="form-group titleeventimage">

                                        <div class="col-md-5 file-upload">
                                            <img id="blah1" src="{{ asset('assets/images/dummy.jpg')}}" alt="your image" />
                                            <label for="upload1"  class="file-upload__label">Upload Icon</label>
                                            <input id="upload1" accept=".png" class="file-upload__input" type="file" name="category_image" onchange="readURL(this, 1); validImage(this, 200, 200);">
                                            <p class="text-danger" id="img_error"></p>
                                        </div> 

                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <div class="" >
                                            <label><input type="radio" value="0" checked="checked" name="multiselect"> Single selection service</label>
                                            <br>
                                            <label><input type="radio" value="1" name="multiselect"> Multiple selection service</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12"> 
                                    <button type="button" onclick="validate(this);" class="mybtns-upload">Submit</button> 
                                    <button type="submit" hidden="" id="submitButton" class="mybtns-upload">Submit</button> 
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div> 





            <div class="col-md-12 mt-4">
                <div class="card"> 
                    <div class="card-header">
                        <h5 class="card-title">Category List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-image">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Category Name (En)</th>
                                        <th>Category Name (Ar)</th>
                                        <th>Category Icon</th>
                                        <th>Status</th> 
                                        <th>Action</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($categories)
                                    @foreach($categories as $key=>$category)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$category->name}}</td>
                                        <td>{{$category->name_ar}}</td>
                                        <td><img src="{{($category->image?$category->image:asset('assets/images/dummy.jpg'))}}"></td>
                                        <!--<td>10/02/20202 10:20AM</td>-->
                                        <td>
                                            <div class="mytoggle">
                                                <label class="switch">
                                                    <input type="checkbox" onchange="changeCategoryStatus(this, '<?= $category->id ?>');" <?= ($category->status == 'active' ? 'checked' : '') ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </td> 
                                        <td>
                                            <a href="{{url("admin/edit-category").'/'.base64_encode($category->id)}}" class="composemail-edit"><i class="fa fa-edit"></i></a>
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
        function validate(obj) {
            var flag = true;
            var formData = $("#addForm").find(".validate:input").not(':input[type=button]');
            $(formData).each(function () {
                var element = $(this);
                var val = element.val();
                var name = element.attr("name");
                if (val == "" || val == "0" || val == null) {
                    $("#" + name + "Error").html("This field is required");
                    flag = false;
                } else {

                }
            });
            if ($(":input[name=category_image]").val() == "") {
                flag = false;
                $("#img_error").html("This field is required");
            } else {
                if (imgflag == true) {
                    $("#img_error").html("");
                }

            }
            if (flag) {
                $("#submitButton").click();
            } else {
                return false;
            }
        }

        function changeCategoryStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: "Category status will be updated",
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
                                    url: "<?= url('admin/category/change_category_status') ?>",
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
