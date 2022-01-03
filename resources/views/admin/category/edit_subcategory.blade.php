@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Edit Subcategory</h1>
        <ol class="breadcrumb">
            <li><a href="<?=url('admin/home')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i>Edit Subcategory</li>
        </ol>
    </div>
    <div class="content"> 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Subcategory </h5>
                    </div>
                    <form method="post" id="addForm" enctype="multipart/form-data" action="{{route('admin.category.update',[base64_encode($category->id)])}}">
                        @csrf
                        <div class="card-body"> 
                            <div class="row">
                                <div class="col-md-12 float-right"><p class="text-right"><?= $parent_name && $second_parent_name ? $parent_name . '&#171; ' . $second_parent_name . ($third_parent_name ? '&#171; ' . $third_parent_name : '') : '' ?></p></div>
                                <div class="col-md-6 mb-3" id="level-3" >
                                    <label>Category Name</label>
                                    <select class="form-control validate" name="cat_3" id="cat_3">
                                        <option disabled="" selected>Select Category</option>
                                        @if($first_level_cat)
                                        @foreach($first_level_cat as $key=>$row)
                                        <option value="{{$row->id}}" <?= $category->parent_id == $row->id ? 'selected' : '' ?>>{{$row->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <p class="text-danger" id="cat_3Error"></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Subcategory Name (En)</label>
                                    <input type="text" class="form-control validate alphanum" value='{{$category->name}}' name="category_name_en" placeholder="Subcategory Name (En)">
                                    <p class="text-danger" id="category_name_enError"></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Subcategory Name (Ar)</label>
                                    <input type="text" class="form-control validate" value='{{$category->name_ar}}' name="category_name_ar" placeholder="Subcategory Name (Ar)">
                                    <p class="text-danger" id="category_name_arError"></p>
                                </div>
                                <div class="col-md-12">
                                    <p class="">(Preferred image dimension 200*200)</p>
                                    <div class="form-group titleeventimage">
                                        <div class="col-md-3 file-upload">
                                            <img id="blah1" src="{{$category->image?$category->image: asset('assets/images/dummy.jpg')}}" alt="your image" />
                                            <label for="upload1"  class="file-upload__label">Upload Icon</label>
                                            <input id="upload1" accept=".png" class="file-upload__input" type="file" name="category_image" onchange="readURL(this, 1);validImage(this, 200, 200);">
                                            <p class="text-danger" id="img_error"></p>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-md-12 text-center"> 
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
    <script>
        function changeSubcategoryStatus(obj, id) {
            var confirm_chk = confirm('Are you sure to change subcategory status?');
            if (confirm_chk) {
                var checked = $(obj).is(':checked');
                if (checked == true) {
                    var status = 1;
                } else {
                    var status = 0;
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
    </script>
    <script>
        function getSubcategory(obj, level) {
            var selected = $(obj).val();
            $("#cat_" + level).empty();
            var html = "<option disabled='' value='' selected>Select " + $(obj).find(":selected").text() + " Sub category</option>";
            if (selected != null && selected != "") {
                $.ajax({
                    url: "<?= url('admin/category/getSubcategory') ?>",
                    type: 'post',
                    data: 'id=' + selected + '&_token=<?= csrf_token() ?>',
                    success: function (data) {
                        if (data.error_code == "200") {
                            if (data.data.length > 0) {
                                $("#level-" + level).css('display', 'block');
                                $("#cat_" + level).addClass('validate');
//                                $("#selection-level-" + (parseInt(level) - 1)).css('display', 'block');
                                var scat = data.data;
                                $(scat).each(function (i, v) {
                                    html += "<option value='" + v.id + "'>" + v.name + "</option>";
                                });
                                $("#cat_" + level).append(html);
                            } else {
//                                $("#selection-level-" + (parseInt(level) - 1)).css('display', 'none');
                                $("#level-" + level).css('display', 'none');
                                $("#cat_" + level).removeClass('validate');
                            }
                        } else {
                            $("#level-" + level).css('display', 'none');
                            $("#cat_" + level).removeClass('validate');
                        }

                    }
                });
            }
        }


    </script>
    @endsection