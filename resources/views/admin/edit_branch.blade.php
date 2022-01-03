@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Edit Branch</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i>Branch Management</li>
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
                        <h5 class="card-title">Edit Branch</h5>
                    </div>
                    <form method="post" id="addForm">
                        @csrf
                        <div class="card-body"> 
                            <div class="row">
                                <div class="col-md-6 mb-4 offset-3"> 
                                    <div class="col-md-12 mb-4">
                                        <label>Branch Name</label>
                                        <input type="text" class="form-control validate alphanum" name="branch_name" value="{{old('branch_name')?old('branch_name'):$branch->branch_name}}" placeholder="Branch Name">
                                        <input name="parent_id" value="0" hidden>
                                        <p class="text-danger" id="branch_nameError">{{$errors->first('branch_name')}}</p>
                                    </div> 
                                    <div class="col-md-12 mb-4">
                                        <label>Branch Name (Ar)</label>
                                        <input type="text" class="form-control validate arabicinput" name="branch_name_ar" value="{{old('branch_name_ar')?old('branch_name_ar'):$branch->branch_name_ar}}" placeholder="Branch Name (Ar)">
                                        <p class="text-danger" id="branch_name_arError">{{$errors->first('branch_name_ar')}}</p>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label>Contact Number</label>
                                        <input type="text" class="form-control validate numberOnly" name="contact_number" value="{{old('contact_number')}}" value="{{old('contact_number')?old('contact_number'):$branch->contact_number}}" placeholder="Contact Number">
                                        <p class="text-danger" id="contact_numberError">{{$errors->first('contact_number')}}</p>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label>Branch Location</label>
                                        <input type="text" class="form-control validate" name="location" value="{{old('location')?old('location'):$branch->location}}" placeholder="Branch Location">
                                        <p class="text-danger" id="locationError">{{$errors->first('location')}}</p>
                                    </div>
                                </div>
                                <div class="col-md-8 mb-4 offset-2"> 
                                    <p class="text-danger" id="timeError"></p>
                                    <div class="col-md-12 mb-4">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Working Days</th>
                                                    <th>Timings</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for($i=0;$i<=6;$i++)
                                                <tr>
                                                    <td><?php echo $day = jddayofweek($i, 1); ?></td>
                                                    @if(in_array(jddayofweek($i, 1),$branch->working_days))
                                                    <td>
                                                        <input type="time" class="times_<?= $i ?> validate" value="<?= $branch->working_day_time->$day->open_time ?>" name="open_time[]" onchange="markOpen(this, '<?= $i ?>');" placeholder="Open Time">
                                                        <input type="time" class="times_<?= $i ?> validate" value="<?= $branch->working_day_time->$day->close_time ?>" name="close_time[]" onchange="markOpen(this, '<?= $i ?>');" placeholder="Close Time">

                                                    </td>    
                                                    <td>
                                                        <label><input class="closed_<?= $i ?>"  type="checkbox" name="closed[]" value="1" onchange="openClose(this, '<?= $i ?>', 1);"> Closed</label>
                                                        <label><input class="open_<?= $i ?>" checked type="checkbox" name="closed[]" value="0" onchange="openClose(this, '<?= $i ?>', 0);"> Open</label>
                                                    </td>
                                                    @else
                                                    <td>
                                                        <input type="time" class="times_<?= $i ?>" name="open_time[]" onchange="markOpen(this, '<?= $i ?>');" placeholder="Open Time">
                                                        <input type="time" class="times_<?= $i ?>" name="close_time[]" onchange="markOpen(this, '<?= $i ?>');" placeholder="Close Time">

                                                    </td>    
                                                    <td>
                                                        <label><input class="closed_<?= $i ?>" checked type="checkbox" name="closed[]" value="1" onchange="openClose(this, '<?= $i ?>', 1);"> Closed</label>
                                                        <label><input class="open_<?= $i ?>" type="checkbox" name="closed[]" value="0" onchange="openClose(this, '<?= $i ?>', 0);"> Open</label>
                                                    </td>
                                                    @endif
                                                </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12"> 
                                    <button type="button" name="submitbtn" onclick="validate(this);"class="mybtns-upload">Submit</button> 
                                    <button type="submit" hidden name="submit" id="submitButton" class="mybtns-upload">Submit</button> 
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
        function openClose(obj, count, type) {
            if ($(obj).is(':checked')) {
                if (type == 1) {
                    $(".times_" + count).val('');
                    $(".times_" + count).removeClass('validate');
                    $(".open_" + count).prop('checked', '');
                } else {
                    $(".times_" + count).addClass('validate');
                    $(".closed_" + count).prop('checked', '');
                }
            } else {
                if (type == 1) {
                    $(".times_" + count).addClass('validate');
                    $(".open_" + count).prop('checked', 'true');
                } else {
                    $(".times_" + count).removeClass('validate');
                    $(".closed_" + count).prop('checked', 'true');
                }
            }
        }

        function validate(obj) {
            $(".text-danger").html('');
            var flag = true;
            var formData = $("#addForm").find(".validate:input");
            $(formData).each(function () {
                var element = $(this);
                var val = element.val();
                var name = element.attr("name");
                if (val == "" || val == "0" || val == null) {
                    if (name == 'open_time[]' || name == 'close_time[]') {
                        $("#timeError").html("Time for open days is required field");
                    } else {
                        $("#" + name + "Error").html("This field is required");
                    }
                    flag = false;
                } else {

                }
            });
            if (flag) {
                $("#submitButton").click();
            } else {
                return false;
            }
        }

        function markOpen(obj, count) {
            if ($(obj).val()) {
                $(".times_" + count).addClass('validate');
                $(".open_" + count).prop('checked', 'true');
                $(".closed_" + count).prop('checked', '');
            }
        }
    </script>
