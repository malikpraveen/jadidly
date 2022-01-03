@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Help & Support Detail</h1> 
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Help & Support Management</li>
        </ol>
    </div>
    <div class="content"> 

        <div class="card"> 
            <div class="card-body"> 
                <div class="row">
                    <div class="col-lg-3 col-xs-4">
                        <div class="major-cat">
                            <strong>Full Name</strong>
                            <p class="text-muted">{{$query->username}}</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-4">
                        <div class="major-cat">
                            <strong>Email Id</strong> 
                            <p class="text-muted">{{$query->email}}</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-xs-4">
                        <div class="major-cat">
                            <strong>Mobile Number</strong>
                            <p class="text-muted">{{$query->mobile}}</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-4">
                        <div class="major-cat">
                            <strong>Date & Time</strong>
                            <p class="text-muted">{{date('d M Y h:iA',strtotime($query->created_at))}}</p>
                        </div>
                    </div>
                </div> 
                <div class="row mt-4">
                    <div class="col-lg-12 col-xs-12 b-r">
                        <div class="major-cat">
                            <strong>Title</strong>
                            <p class="text-muted">{{$query->subject}}</p>
                        </div>
                    </div> 
                    <div class="col-lg-12 col-xs-12 mt-4 b-r">
                        <div class="major-cat">
                            <strong>Message</strong>
                            <p class="text-muted">{{$query->details}}</p>
                        </div>
                    </div> 
                </div>
                @if($query->images)
                <div class="row mt-4">
                    @foreach($query->images as $k=>$images)
                    <div class="col-lg-3 col-xs-3 b-r">
                        <div class="help-support-img property-zoom-image">
                            <img id="image_<?= $k ?>" style="height: 130px;" src="{{$images->image}}"> 
                            <a href="#viewmessege" onclick="viewImg(this,<?= $k ?>);" data-direction="finish" data-toggle="modal" class=" my-zoom-btn"><i class="fa fa-eye"></i></a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                @if($query->reply)
                <div class="row mt-4">
                    <div class="col-lg-12 col-xs-12 b-r">
                        <div class="major-cat">
                            <strong>Your Reply</strong>
                            <p>{{$query->reply}}</p>
                        </div>
                    </div> 
                </div>
                @else
                <div class="row mt-4">
                    <div class="col-lg-12 col-xs-12 b-r">
                        <div class="major-cat">
                            <strong>Write Here</strong>
                            <textarea class="form-control" name="reply"></textarea>
                            <p class="text-danger" id="error"></p>
                        </div>
                    </div> 
                </div>
                @endif
                <div class="row mt-4">
                    <div class="col-lg-12 col-xs-12 b-r">
                        <div class="help-support-img pull-right"> 
                            <a href="{{url('admin/help-n-support')}}" class="composemail block-user">Go Back</a>
                            <a style="cursor:default;" onclick="sendReply(this,<?= $query->id ?>)" class="composemail block-user">Reply</a>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade model-design" id="viewmessege" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLongTitle"></h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">×</span>

                    </button>

                </div>

                <div class="modal-body pl-0 pr-0 pt-0">

                    <div class="pl-0 pr-0 text-center"> 
                        <div class="doc-img">
                            <img id="showimg" src="{{asset('assets/images/dummy.jpg')}}">
                        </div>
                        <button data-direction="finish" class="composemail mt-4 mr-4  pull-right" data-dismiss="modal" aria-label="Close">Close</button> 


                    </div>

                </div>

            </div>

        </div>

    </div>
    @endsection
    <script>
        function viewImg(obj, count) {
            $("#showimg").attr('src', $("#image_" + count).attr('src'));
        }

        function sendReply(obj, id) {
            if (id) {
                var reply = $(":input[name=reply]").val();
                if (reply) {
                    $.ajax({
                        url: "<?= url('admin/query/reply/') ?>/" + id,
                        type: 'post',
                        data: 'reply=' + reply + '&_token=<?= csrf_token() ?>',
                        success: function (data) {
//                            if (data.error_code == "200") {
//                                alert(data.message);
//                                location.reload();
//                            } else {
//                                $("#error").html(data.message);
////                            alert(data.message);
//                            }
                            if (data.error_code == "200") {
                                data.title = "Success!";
                                successMessage(data);
                            } else {
                                errorOccured(data);
                            }
                        }
                    });
                } else {
                    $("#error").html("Message field is required");
                }
            } else {
                var data = {message: "Something went wrong"};
                errorOccured(data);
            }
        }
    </script>