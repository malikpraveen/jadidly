@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Add New Service</h1>
        <ol class="breadcrumb">
            <li><a href="<?=url('admin/home')?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Add New Service</li>
        </ol>
    </div>
    <div class="content">
        <div class="card">
            <div class="card-body">
                <form method="post" id="addForm" enctype="multipart/form-data" action="{{route('admin.service.store')}}">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstName1">Service Name (En) </label>
                                <input class="form-control validate alphanum" type="text" name="service_name_en">
                                <p class="text-danger" id="service_name_enError"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstName1">Service Name (Ar) </label>
                                <input class="form-control validate" type="text" name="service_name_ar">
                                <p class="text-danger" id="service_name_arError"></p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3" id="level-1">
                            <label>Category Name</label>
                            <select class="form-control validate" name="cat_1" id="cat_1" onchange="getSubcategory(this, 2);">
                                <option disabled="" selected>Select Category</option>
                                @if($categories)
                                @foreach($categories as $key=>$row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                                @endif
                            </select>
                            <p class="text-danger" id="cat_1Error"></p>
                        </div>
                        <div class="col-md-6 mb-3" id="level-2" style="display:none;">
                            <label id="level-2-label">Subcategory Name</label>
                            <select class="form-control" name="cat_2" id="cat_2" onchange="getSubcategory(this, 3);">
                                <option disabled="" selected>Select Subcategory</option>
                            </select>
                            <p class="text-danger" id="cat_2Error"></p>
                        </div>
                        <div class="col-md-6 mb-3" id="level-3" style="display:none;">
                            <label id="level-3-label">Subcategory Name</label>
                            <select class="form-control" name="cat_3" id="cat_3" onchange="getSubcategory(this, 4);">
                                <option disabled="" selected>Select Subcategory</option>
                            </select>
                            <p class="text-danger" id="cat_3Error"></p>
                        </div> 
                        <div class="col-md-6 mb-3" id="level-4" style="display:none;">
                            <label id="level-4-label">Subcategory Name</label>
                            <select class="form-control" name="cat_4" id="cat_4">
                                <option disabled="" selected>Select Subcategory</option>
                            </select>
                            <p class="text-danger" id="cat_4Error"></p>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstName1">Price</label>
                                <input class="form-control validate pricevalue" name="price" type="text">
                                <p class="text-danger" id="priceError"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label for="firstName1"><input type="checkbox" value="1" name="is_pickup"> Pickup Available</label>

                            </div>
                        </div>
<!--                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstName1">Pickup & Dropoff Charges</label>
                                <input id="charges" class="form-control validate pricevalue" disabled value="0" name="pickup_charges" type="text">
                                <p class="text-danger" id="pickup_chargesError"></p>
                            </div>
                        </div>-->
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="lastName1">Upload Service images</label>
                                <span class="">(Preferred image dimension 740*440)</span>
                                <div class="form-group row titleeventimage">

                                    <div class="col-sm-3 file-upload">
                                        <img id="blah1" src="{{ asset('assets/images/dummy.jpg')}}" alt="your image" />
                                        <label for="upload1"  class="file-upload__label">Upload Image</label>
                                        <input id="upload1" accept="image/*" class="file-upload__input" type="file" name="images[]" onchange="readURL(this, 1);validImage(this, 740, 440);">
                                        <p class="text-danger" id="upload1Error"></p>
                                    </div>
                                    <div class="col-sm-3 file-upload">
                                        <img id="blah2" src="{{ asset('assets/images/dummy.jpg')}}"  alt="your image" />
                                        <label for="upload2" class="file-upload__label">Upload Image</label>
                                        <input id="upload2" accept="image/*" class="file-upload__input" type="file" name="images[]" onchange="readURL(this, 2);validImage(this, 740, 440);">
                                        <p class="text-danger" id="upload2Error"></p>
                                    </div>
                                    <div class="col-sm-3 file-upload">
                                        <img id="blah3" src="{{ asset('assets/images/dummy.jpg')}}"  alt="your image" />
                                        <label for="upload3" class="file-upload__label">Upload Image</label>
                                        <input id="upload3" accept="image/*" class="file-upload__input" type="file" name="images[]" onchange="readURL(this, 3);validImage(this, 740, 440);">
                                        <p class="text-danger" id="upload3Error"></p>
                                    </div>
                                    <div class="col-sm-3 file-upload">
                                        <img id="blah4" src="{{ asset('assets/images/dummy.jpg')}}"  alt="your image" />
                                        <label for="upload4" class="file-upload__label">Upload Image</label>
                                        <input id="upload4" accept="image/*" class="file-upload__input" type="file" name="images[]" onchange="readURL(this, 4);validImage(this, 740, 440);">
                                        <p class="text-danger" id="upload4Error"></p>
                                    </div>
                                </div>
                                <p class="text-danger" id="imageError"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="firstName1">Service Description(En)</label>
                                <textarea class="form-control validate" cols="3" maxlength="250" name="description" rows="3"></textarea>
                                <p class="text-danger" id="descriptionError"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="firstName1">Service Description(Ar)</label>
                                <textarea class="form-control validate" cols="3" maxlength="250" name="description_ar" rows="3"></textarea>
                                <p class="text-danger" id="description_arError"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12"> 
                            <!--<a href="#" type="submit" class="mybtns pull-right">Submit</a>-->
                            <button type="button" onclick="validate(this);" class="mybtns pull-right">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <script>
//        function getSubcategory(obj) {
//            $("#subcategoryList").empty();
//            var html = "<option disabled='' selected>Select Sub-Category</option>";
//            if ($(obj).val() != null && $(obj).val()) {
//                $.ajax({
//                    url: "<?= url('admin/category/getSubcategory') ?>",
//                    type: 'post',
//                    data: 'id=' + $(obj).val() + '&_token=<?= csrf_token() ?>',
//                    success: function (data) {
//                        if (data.error_code == "200") {
//                            if (data.data) {
//                                var scat = data.data;
//                                $(scat).each(function (i, v) {
//                                    html += "<option value='" + v.id + "'>" + v.name + "</option>";
//                                });
//                            }
//                        } else {
//
//                        }
//                        $("#subcategoryList").append(html);
//                    }
//                });
//            }
//        }

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
                                var scat = data.data;
                                $(scat).each(function (i, v) {
                                    html += "<option value='" + v.id + "'>" + v.name + "</option>";
                                });
                                $("#cat_" + level).append(html);
                            } else {
                                for (var i = level; i <= 4; i++) {
                                    $("#level-" + i).css('display', 'none');
                                    $("#cat_" + i).removeClass('validate');
                                }

                            }
                        } else {
                            for (var i = level; i <= 4; i++) {
                                $("#level-" + i).css('display', 'none');
                                $("#cat_" + i).removeClass('validate');
                            }
                        }

                    }
                });
            }
        }

    </script>

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
                    if (name == 'price') {
                        var isValid = checkPrice(element);
                        if (isValid) {
                            $("#" + name + "Error").html("");
                        } else {
                            flag = false;
                            $("#" + name + "Error").html("Price must be a valid number");
                        }
                    }
//                    else if (name == 'pickup_charges') {
//                        var isValid = checkPrice(element);
//                        if (isValid) {
//                            $("#" + name + "Error").html("");
//                        } else {
//                            flag = false;
//                            $("#" + name + "Error").html("Pickup Charges must be a valid number");
//                        }
//                    }
                    else {
                        $("#" + name + "Error").html("");
                    }

                }
            });
            var imgCount = 0;
            var formImages = $(".file-upload__input");
            if (formImages) {
                $(formImages).each(function () {
                    if ($(this).val()) {
                        // var check = validImage(this , 740 , 440);
                        // if (imgflag == false) {
                        //     $("#" + $(this).attr('id') + "Error").html("image dimensions are not valid");
                        // } else {
                        imgCount++;
                        // }
                    }
                });
            }
            if (imgCount == 0) {
                $("#imageError").html("Image is required");
                flag = false;
            } else {
                $("#imageError").html("");
            }

            if (flag) {

                $("#addForm").submit();
            } else {
                return false;
            }
        }

//        function pickupCharges(obj){
//            if($(obj).is(':checked') == false){
//                $("#charges").attr('disabled','disabled');
//                $("#pickup_chargesError").html('');
//                $("#charges").removeClass('validate');
//            }else{
//                $("#charges").removeAttr('disabled');
//                $("#charges").addClass('validate');
//            }
//        }
    </script>
    @endsection