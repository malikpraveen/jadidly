@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Branch Management</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Branch Management</li>
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
                        <h5 class="card-title">Add Branch</h5>
                    </div>
                    <form method="post" id="addForm">
                        @csrf
                        <div class="card-body"> 
                            <div class="row">
                                <div class="col-md-6 mb-4 offset-3"> 
                                    <div class="col-md-12 mb-4">
                                        <label>Branch Name</label>
                                        <input type="text" class="form-control validate alphanum" name="branch_name" value="{{old('branch_name')}}" placeholder="Branch Name">
                                        <input name="parent_id" value="0" hidden>
                                        <p class="text-danger" id="branch_nameError">{{$errors->first('branch_name')}}</p>
                                    </div> 
                                    <div class="col-md-12 mb-4">
                                        <label>Branch Name (Ar)</label>
                                        <input type="text" class="form-control validate arabicinput" name="branch_name_ar" value="{{old('branch_name_ar')}}" placeholder="Branch Name (Ar)">
                                        <p class="text-danger" id="branch_name_arError">{{$errors->first('branch_name_ar')}}</p>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label>Contact Number</label>
                                        <input type="text" class="form-control validate numberOnly" name="contact_number" value="{{old('contact_number')}}" placeholder="Contact Number">
                                        <p class="text-danger" id="contact_numberError">{{$errors->first('contact_number')}}</p>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label>Branch Location</label>
                                        <input type="text" class="form-control validate" name="location" value="{{old('location')}}" placeholder="Branch Location">
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
                                                    <td><?= jddayofweek($i, 1) ?></td>
                                                    <td>
                                                        <input type="time" class="times_<?= $i ?>" onchange="markOpen(this, '<?= $i ?>');" name="open_time[]" placeholder="Open Time">
                                                        <input type="time" class="times_<?= $i ?>" onchange="markOpen(this, '<?= $i ?>');" name="close_time[]" placeholder="Close Time">

                                                    </td>    
                                                    <td>
                                                        <label><input class="closed_<?= $i ?>" checked type="checkbox" name="closed[]" value="1" onchange="openClose(this, '<?= $i ?>', 1);"> Closed</label>
                                                        <label><input class="open_<?= $i ?>" type="checkbox" name="closed[]" value="0" onchange="openClose(this, '<?= $i ?>', 0);"> Open</label>
                                                    </td>
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





            <div class="col-md-12 mt-4">
                <div class="card"> 
                    <div class="card-header">
                        <h5 class="card-title">Branch List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-image">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Branch Name (En)</th>
                                        <th>Branch Name (Ar)</th>
                                        <th>Contact No.</th>
                                        <th>Status</th> 
                                        <th>Action</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($branch)
                                    @foreach($branch as $key=>$b)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$b->branch_name}}</td>
                                        <td>{{$b->branch_name_ar}}</td>
                                        <td>{{$b->contact_number}}</td>
                                        <td>
                                            <div class="mytoggle">
                                                <label class="switch">
                                                    <input type="checkbox" onchange="changeCategoryStatus(this, '<?= $b->id ?>');" <?= ($b->status == 'open' ? 'checked' : '') ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </td> 
                                        <td>
                                            <a href="{{url("admin/edit-branch").'/'.base64_encode($b->id)}}" class="composemail-edit"><i class="fa fa-edit"></i></a>
                                            <a href="#show" class="composemail-edit" onclick="viewBranchDetails(this, '<?= $b->id ?>')"><i class="fa fa-eye"></i></a>
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
    <div class="modal bs-example-modal-new checkout-modal" id="details" style='background-color: #eeeeeea3;' data-keyboard='false' data-backdrop='static'tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <!-- Modal Content: begins -->
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header border-bottom-0">
                    <h4 class="text-white">Branch Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>

                </div>

                <!-- Modal Body -->  
                <div class="modal-body text-center">
                    <div class="body-message">
                        <!--<a href="#"><i class="fa fa-check confirm-booking-icon"></i></a>-->
                        <table class="table">
                            <tbody id="timing">
                                <tr>
                                    <th>Branch Name (english)</th>
                                    <td id="branch_name">Branch Name (english)</td>
                                </tr>
                                <tr>
                                    <th>Branch Name (arabic)</th>
                                    <td id="branch_name_ar">Branch Name (arabic)</td>
                                </tr>
                                <tr>
                                    <th>Contact Number</th>
                                    <td id="contact_number">Contact Number</td>
                                </tr>
                                <tr>
                                    <th>Branch Location</th>
                                    <td id="location">Branch Location</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td id="status">Active</td>
                                </tr>
                                <tr>
                                    <th>Working Days</th>
                                    <td style="word-break: break-word" id="working_days">Working Days</td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>Open Time</th>
                                    <th>Close Time</th>
                                </tr>
<!--                                <tr>
                                    <td>Working Days</td>
                                    <td>Open</td>
                                    <td>Close</td>
                                </tr>-->

                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-12 text-left">

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer border-top-0 text-center"> 
                </div>

            </div>
            <!-- Modal Content: ends -->

        </div>

    </div>
    @endsection
    <script>
        var branchs =<?= GuzzleHttp\json_encode($branch) ?>;
        function changeCategoryStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: "Branch status will be updated",
                icon: "warning",
                buttons: ["No", "Yes"],
                dangerMode: true,
            })
                    .then((willDelete) => {
                        if (willDelete) {
                            var checked = $(obj).is(':checked');
                            if (checked == true) {
                                var status = 'open';
                            } else {
                                var status = 'closed';
                            }
                            if (id) {
                                $.ajax({
                                    url: "<?= url('admin/change_status') ?>",
                                    type: 'post',
                                    data: 'id=' + id + '&type=branch' + '&action=' + status + '&_token=<?= csrf_token() ?>',
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

        function viewBranchDetails(obj, branch_id) {
            $("#working_days").html('');
            $(".timingRow").remove();
            var days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
            $(branchs).each(function (b, branch) {
                if (branch.id == branch_id) {
                    $("#branch_name").html(branch.branch_name);
                    $("#branch_name_ar").html(branch.branch_name_ar);
                    $("#contact_number").html(branch.contact_number);
                    $("#location").html(branch.location);
                    $("#working_days").html(branch.working_days);
                    $("#status").html((branch.status == 'open' ? 'Active' : 'Inactive'));
                    var timings = JSON.parse(branch.working_day_time);
                    $(days).each(function (i, ti) {
                        var day = ti;
                        var td = timings;
                        var tym = td[day];
                        if (tym) {
                            var html = "<tr class='timingRow'><td>" + day + "</td><td>" + tym.open_time + "</td><td>" + tym.close_time + "</td></tr>";
                            $("#timing").append(html);
                        }
                    });

                    $("#details").modal();
                }
            });
        }

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
