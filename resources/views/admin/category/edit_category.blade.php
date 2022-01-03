@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Edit Category</h1>
        <ol class="breadcrumb">
            <li><a href="<?=url('admin/home')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i>Edit Category</li>
        </ol>
    </div>
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Category</h5>
                    </div>
                    <form method="post" id="addForm" enctype="multipart/form-data" action="{{route('admin.category.update',[base64_encode($category->id)])}}">
                        @csrf
                        <div class="card-body"> 
                            <div class="row">
                                <div class="col-md-6 mb-4 offset-3"> 
                                    <div class="col-md-12 mb-4">
                                        <label>Category Name (En)</label>
                                        <input type="text" class="form-control validate alphanum" name="category_name_en" value='{{$category->name}}' placeholder="Category Name (En)">
                                        <input name="parent_id" value="0" hidden>
                                        <p class="text-danger" id="category_name_enError"></p>
                                    </div> 
                                    <div class="col-md-12 mb-4">
                                        <label>Category Name (Ar)</label>
                                        <input type="text" class="form-control validate" name="category_name_ar" value='{{$category->name_ar}}' placeholder="Category Name (Ar)">
                                        <p class="text-danger" id="category_name_arError"></p>
                                    </div>
                                    <div class="col-md-12">
                                        <p class="">(Preferred image dimension 200*200)</p>
                                    </div>
                                    <div class="form-group titleeventimage">
                                        <div class="col-md-5 file-upload">
                                            <img id="blah1" src="{{$category->image?$category->image: asset('assets/images/dummy.jpg')}}" alt="your image" />
                                            <label for="upload1"  class="file-upload__label">Upload Icon</label>
                                            <input id="upload1" accept=".png" class="file-upload__input" type="file" name="category_image" onchange="readURL(this, 1);validImage(this, 200, 200);">
                                            <p class="text-danger" id="img_error"></p>
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
                    $("#" + name + "Error").html("");
                }
            });
            if ($(":input[name=category_image]").val()) {
                if (imgflag == true) {
                    $("#img_error").html("");
                }
            }

            if (flag) {
//                $("#addForm").submit();
                $("#submitButton").click();
            } else {
                return false;
            }
        }

        function changeCategoryStatus(obj, id) {
            var confirm_chk = confirm('Are you sure to change category status?');
            if (confirm_chk) {
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
