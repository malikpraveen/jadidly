@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Edit Service</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Edit Service</li>
        </ol>
    </div>
    <div class="content">
        <div class="card">
            <div class="card-body">
                <form method="post" id="addForm" enctype="multipart/form-data" action="{{route('admin.service.update',[base64_encode($service->id)])}}">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstName1">Service Name (En) </label>
                                <input class="form-control validate alphanum" type="text" name="service_name_en" value="{{$service->name}}">
                                <p class="text-danger" id="service_name_enError"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstName1">Service Name (Ar) </label>
                                <input class="form-control validate" type="text" name="service_name_ar" value="{{$service->name_ar}}">
                                <p class="text-danger" id="service_name_arError"></p>
                            </div>
                        </div>
                        @foreach($category_level as $level=>$category)
                        <div class="col-md-6 mb-3" id="level-<?= $level + 1 ?>">
                            <label id="level-4-label">Subcategory Name</label>
                            <select class="form-control" name="cat_<?= $level + 1 ?>" id="cat_<?= $level + 1 ?>"  <?= $level + 1 == $levels ? '' : 'disabled' ?> onchange="getSubcategory(this, '<?= $level + 2 ?>');">
                                <option disabled="" selected>Select Subcategory</option>
                                @if($level+1 == $levels)
                                @foreach($category->siblings as $sibling)
                                <option value="<?= $sibling->id ?>" <?= $sibling->id == $category->id ? 'selected' : '' ?> >{{$sibling->name}}</option>
                                @endforeach
                                @else
                                <option value="<?= $category->id ?>" selected>{{$category->name}}</option>
                                @endif
                            </select>
                            <p class="text-danger" id="cat_<?= $level + 1 ?>Error"></p>
                        </div>
                        @endforeach
                        @if($levels<4)
                        @for($j=$levels+1;$j<=4;$j++)
                        <div class="col-md-6 mb-3" id="level-<?= $j ?>" style="display:<?= $j > $levels ? 'none' : 'block' ?>">
                            <label id="level-4-label">Subcategory Name</label>
                            <select class="form-control" name="cat_<?= $j ?>" id="cat_<?= $j ?>"  <?php if ($j < 4) { ?>onchange="getSubcategory(this, '<?= $j + 1 ?>');"<?php } ?>>
                                <option disabled="" selected>Select Subcategory</option>
                            </select>
                            <p class="text-danger" id="cat_<?= $j ?>Error"></p>
                        </div>
                        @endfor
                        @endif
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstName1">Price</label>
                                <input class="form-control validate" name="price" type="text" value="{{$service->price}}">
                                <p class="text-danger" id="priceError"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label for="firstName1"><input type="checkbox" value="1" <?= $service->is_pickup ? 'checked' : '' ?> name="is_pickup"> Pickup Available</label>

                            </div>
                        </div>
<!--                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstName1">Pickup & Dropoff Charges</label>
                                <input id="charges" class="form-control validate pricevalue" <?= $service->is_pickup ? '' : 'disabled' ?> value="{{$service->pickup_charges}}" name="pickup_charges" type="text">
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
                                    @for($i=1;$i<=4;$i++)
                                    <div class="col-sm-3 file-upload">
                                        <img id="blah<?= $i ?>" src="{{ isset($service->images[$i-1]) && $service->images[$i-1]['image']?$service->images[$i-1]['image']:asset('assets/images/dummy.jpg')}}" alt="your image" />
                                        <label for="upload<?= $i ?>" class="file-upload__label">Upload Image</label>
                                        <input id="upload<?= $i ?>" accept="image/*" class="file-upload__input" type="file" name="images[]" onchange="readURL(this, <?= $i ?>);" onchange="setHeightWidth(this);">
                                        <p class="text-danger" id="upload<?= $i ?>Error"></p>
                                    </div>
                                    @endfor
                                    <!--                                    <div class="col-sm-3 file-upload">
                                                                            <img id="blah2" src="{{ asset('assets/images/dummy.jpg')}}"  alt="your image" />
                                                                            <label for="upload2" class="file-upload__label">Upload Image</label>
                                                                            <input id="upload2" class="file-upload__input" type="file" name="images[]" onchange="readURL(this, 2);" onchange="setHeightWidth(this);">
                                                                            <p class="text-danger" id="upload2Error"></p>
                                                                        </div>
                                                                        <div class="col-sm-3 file-upload">
                                                                            <img id="blah3" src="{{ asset('assets/images/dummy.jpg')}}"  alt="your image" />
                                                                            <label for="upload3" class="file-upload__label">Upload Image</label>
                                                                            <input id="upload3" class="file-upload__input" type="file" name="images[]" onchange="readURL(this, 3);" onchange="setHeightWidth(this);">
                                                                            <p class="text-danger" id="upload3Error"></p>
                                                                        </div>
                                                                        <div class="col-sm-3 file-upload">
                                                                            <img id="blah4" src="{{ asset('assets/images/dummy.jpg')}}"  alt="your image" />
                                                                            <label for="upload4" class="file-upload__label">Upload Image</label>
                                                                            <input id="upload4" class="file-upload__input" type="file" name="images[]" onchange="readURL(this, 4);" onchange="setHeightWidth(this);">
                                                                            <p class="text-danger" id="upload4Error"></p>
                                                                        </div>-->
                                </div>
                                <p class="text-danger" id="imageError"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="firstName1">Service Description(En)</label>
                                <textarea class="form-control validate" cols="3" name="description" rows="3">{{$service->description}}</textarea>
                                <p class="text-danger" id="descriptionError"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="firstName1">Service Description(Ar)</label>
                                <textarea class="form-control validate" cols="3" name="description_ar" rows="3">{{$service->description_ar}}</textarea>
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
    @endsection
    <script>
        var _URL = window.URL || window.webkitURL;
        var height;
        var width;
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

            if (flag) {
                $("#addForm").submit();
            } else {
                return false;
            }
        }


//        function pickupCharges(obj) {
//            if ($(obj).is(':checked') == false) {
//                $("#charges").attr('disabled', 'disabled');
//                $("#pickup_chargesError").html('');
//                $("#charges").removeClass('validate');
//            } else {
//                $("#charges").removeAttr('disabled');
//                $("#charges").addClass('validate');
//            }
//        }
    </script>