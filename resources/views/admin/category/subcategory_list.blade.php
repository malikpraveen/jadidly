@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Subcategory Management</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Subcategory Management</li>
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
                        <h5 class="card-title">Add A Subcategory </h5>
                    </div>
                    <form method="post" id="addForm" enctype="multipart/form-data" action="{{route('admin.category.store')}}">
                        @csrf
                        <div class="card-body"> 
                            <div class="row">

                                <div class="col-md-6 mb-3" id="level-1">
                                    <label>Category Name</label>
                                    <select class="form-control validate" name="parent_id" id="cat_1" onchange="getSubcategory(this, 2);">
                                        <option disabled="" selected>Select Category</option>
                                        @if($categories)
                                        @foreach($categories as $key=>$row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <p class="text-danger" id="parent_idError"></p>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <div class="selection-level-1" id="selection-level-1" style="display:none;">
                                        <label><input type="radio" value="0" checked="checked" onclick="showsubcat(this, 0, 2);" name="type1"> Add subcategory to this category</label>
                                        <br>
                                        <label><input type="radio" value="1" onclick="showsubcat(this, 1, 2);" name="type1"> Add subcategory to another subcategory level</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3" id="level-2" style="display:none;">
                                    <label id="level-2-label">Subcategory Name</label>
                                    <select class="form-control" name="cat_2" id="cat_2" onchange="getSubcategory(this, 3);">
                                        <option disabled="" selected>Select Subcategory</option>
                                    </select>
                                    <p class="text-danger" id="cat_2Error"></p>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <div class="selection-level-2" id="selection-level-2" style="display:none;">
                                        <label><input type="radio" value="0" checked="checked" onclick="showsubcat(this, 0, 3);" name="type2"> Add subcategory to this category</label>
                                        <br>
                                        <label><input type="radio" value="1" onclick="showsubcat(this, 1, 3);" name="type2"> Add subcategory to another subcategory level</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3" id="level-3" style="display:none;">
                                    <label id="level-3-label">Subcategory Name</label>
                                    <select class="form-control" name="cat_3" id="cat_3">
                                        <option disabled="" selected>Select Subcategory</option>
                                    </select>
                                    <p class="text-danger" id="cat_3Error"></p>
                                </div>
                                <div class="col-md-12 row"> 
                                    <div class="col-md-6 mb-3">
                                        <label>Subcategory Name (En)</label>
                                        <input type="text" class="form-control validate alphanum" name="category_name_en" placeholder="Subcategory Name (En)">
                                        <p class="text-danger" id="category_name_enError"></p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Subcategory Name (Ar)</label>
                                        <input type="text" class="form-control validate" name="category_name_ar" placeholder="Subcategory Name (Ar)">
                                        <p class="text-danger" id="category_name_arError"></p>
                                    </div>

                                    <div class="col-md-12">
                                        <p class="">(Preferred image dimension 200*200)</p>

                                        <div class="form-group titleeventimage">
                                            <div class="col-md-3 file-upload">
                                                <img id="blah1" src="{{ asset('assets/images/dummy.jpg')}}" alt="your image" />
                                                <label for="upload1"  class="file-upload__label text-small">Upload Icon</label>
                                                <input id="upload1" accept=".png" class="file-upload__input" type="file" name="category_image" onchange="readURL(this, 1); validImage(this, 200, 200);">
                                                <p class="text-danger" id="img_error"></p>
                                            </div> 
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
                                <div class="col-md-12 text-center"> 
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
                        <h5 class="card-title">Subcategory List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-image">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Category Name</th>
                                        <th>Subcategory Name</th>
                                        <th>Subcategory Name (Ar)</th>
                                        <th>Subcategory Icon</th>

                                        <th>Status</th> 
                                        <th>Action</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($subcategories)
                                    @foreach($subcategories as $key=>$subcategory)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$subcategory->category_name}}</td>
                                        <td>{{$subcategory->name}}</td>
                                        <td>{{$subcategory->name_ar}}</td>
                                        <td><img src="{{($subcategory->image?$subcategory->image:asset('assets/images/dummy.jpg'))}}"></td>
                                        <!--<td>10/02/20202 10:20AM</td>-->
                                        <td>
                                            <div class="mytoggle">
                                                <label class="switch">
                                                    <input type="checkbox" onchange="changeSubcategoryStatus(this, '<?= $subcategory->id ?>');" <?= ($subcategory->status == 'active' ? 'checked' : '') ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </td> 
                                        <td>
                                            <a href="{{url("admin/edit-subcategory").'/'.base64_encode($subcategory->id)}}" class="composemail-edit"><i class="fa fa-edit"></i></a>
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
        function changeSubcategoryStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: "Subcategory status will be updated",
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
            if ($(":input[name=category_image]").val() == "") {
                flag = false;
                $("#img_error").html("This field is required");
            } else {
                // var check = validImage(":input[name=category_image]" , 200 , 200);
                if (imgflag == true) {
                    //     flag = false;
                    //     $("#category_imageError").html("image dimensions are not valid");
                    // } else {
                    $("#img_error").html("");
                }
            }
            if (flag) {
                $("#submitButton").click();
//        $("#addForm").submit();
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
//                $("#level-" + level).css('display', 'block');
//                $("#cat_" + level).addClass('validate');
                                $("#selection-level-" + (parseInt(level) - 1)).css('display', 'block');
                                var scat = data.data;
                                $(scat).each(function (i, v) {
                                    html += "<option value='" + v.id + "'>" + v.name + "</option>";
                                });
                                $("#cat_" + level).append(html);
                            } else {
                                $("#selection-level-" + (parseInt(level) - 1)).css('display', 'none');
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

        function showsubcat(obj, action, level) {
            if (action == 1) {
                $("#level-" + level).css('display', 'block');
                $("#cat_" + level).addClass('validate');
            } else {
                $("#level-" + level).css('display', 'none');
                $("#cat_" + level).removeClass('validate');
                $("#level-" + parseInt(level + 1)).css('display', 'none');
                $("#cat_" + parseInt(level + 1)).removeClass('validate');
            }
        }

    </script>
    @endsection