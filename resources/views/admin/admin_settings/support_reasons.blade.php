@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Support Reason</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Support Reason</li>
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
                        <h5 class="card-title">Add A Subject</h5>
                    </div>
                    <form method="post" id="addForm">
                        @csrf
                        <div class="card-body"> 
                            <div class="row">
                                <div class="col-md-6 mb-4 offset-3"> 
                                    <div class="col-md-12 mb-4">
                                        <label>Subject (En)</label>
                                        <input type="text" maxlength="250" class="form-control validate alphanum" name="subject_en" value="{{old('subject_en')}}" placeholder="Subject (En)">

                                        <p class="text-danger" id="subject_enError">{{$errors->first('subject_en')}}</p>
                                    </div> 
                                    <div class="col-md-12 mb-4">
                                        <label>Subject (Ar)</label>
                                        <input type="text" maxlength="250" class="form-control validate arabicinput" name="subject_ar" value="{{old('subject_ar')}}" placeholder="Subject (Ar)">
                                        <p class="text-danger" id="subject_arError">{{$errors->first('subject_ar')}}</p>
                                    </div>
                                </div>

                                <div class="col-md-12"> 
                                    <!--<button type="button" onclick="validate(this);" class="mybtns-upload">Submit</button>--> 
                                    <button type="submit" name="submit" id="submitButton" class="mybtns-upload">Submit</button> 
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div> 





            <div class="col-md-12 mt-4">
                <div class="card"> 
                    <div class="card-header">
                        <h5 class="card-title">Subject List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-image">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Subject (En)</th>
                                        <th>Subject (Ar)</th>
                                        <th>Status</th> 
                                        <th>Action</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($subjects)
                                    @foreach($subjects as $key=>$subject)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$subject->subject_en}}</td>
                                        <td>{{$subject->subject_ar}}</td>
                                        <td>
                                            <div class="mytoggle">
                                                <label class="switch">
                                                    <input type="checkbox" onchange="changeCategoryStatus(this, '<?= $subject->id ?>');" <?= ($subject->status ? 'checked' : '') ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </td> 
                                        <td>
                                            <a href="{{url("admin/edit-support-reason").'/'.base64_encode($subject->id)}}" class="composemail-edit"><i class="fa fa-edit"></i></a>
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
        function changeCategoryStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: "Subject status will be updated",
                icon: "warning",
                buttons: ["No", "Yes"],
                dangerMode: true,
            })
                    .then((willDelete) => {
                        if (willDelete) {
                            var checked = $(obj).is(':checked');
                            if (checked == true) {
                                var status = '1';
                            } else {
                                var status = '0';
                            }
                            if (id) {
                                $.ajax({
                                    url: "<?= url('admin/change_status') ?>",
                                    type: 'post',
                                    data: 'id=' + id + '&type=subject' + '&action=' + status + '&_token=<?= csrf_token() ?>',
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
                            return false;
                        }
                    });
        }
    </script>
