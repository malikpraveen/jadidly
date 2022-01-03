@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Booking Cancellation Request List</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Booking Cancellation Management</li>
        </ol>
    </div>
    <div class="content">

        <div class="card">
            <div class="card-body">
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
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr.no.</th>
                                <th>Booking Id</th>
                                <th>User Name</th>   
                                <th>Booking Date & Time</th> 
                                <th>Amount</th>
                                <th>Reason</th>
                                <th>Booking Status</th>
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @if($bookings)
                            @foreach($bookings as $k=>$booking)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td><a href="<?= url('admin/booking-request-details/' . base64_encode($booking->id)) ?>" class="composemail-edit">booking#{{$booking->booking_id}}</a></td>
                                <td><a href="<?= url('admin/user-detail/' . base64_encode($booking->user_id)) ?>">{{$booking->username}}</td> 
                                <td>{{date('Y-m-d h:i A',$booking->booking_datetime)}}</td>
                                <td>{{$booking->amount}} KWD</td>
                                <td>{{$booking->reason}}</td>
                                <td>
                                    @if($booking->status == '0')
                                    <span class="text-warning">New</span>
                                    @else 
                                    @if($booking->status == '1')
                                    <span class="text-warning">In Process</span>
                                    @else 
                                    @if($booking->status == '2')
                                    <span class="text-success">Completed</span>
                                    @else 
                                    @if($booking->status == '3')
                                    <span class="text-danger">Rejected</span>
                                    @else 
                                    @if($booking->status == '4')
                                    <span class="text-danger">Cancelled</span>
                                    @endif
                                    @endif
                                    @endif
                                    @endif
                                    @endif
                                </td> 
                                <td>
                                    @if($booking->request_status == '0')
                                    <button class="btn btn-primary mb-1" title="accept" type="button" onclick="actionRequest(this, 1, '<?= $booking->id ?>');"><i class="fa fa-check"></i></button><br>
                                    <button class="btn btn-danger" title="reject" type="button" onclick="actionRequest(this, 2, '<?= $booking->id ?>');"><i class="fa fa-times"></i></button>
                                    @else 
                                    @if($booking->request_status == '1')
                                    <span class="text-success">Accepted</span>
                                    @else
                                    @if($booking->request_status == '2')
                                    <span class="text-danger">Rejected</span>
                                    @else
                                    @if($booking->request_status == '3')
                                    <span class="text-danger">Request cancelled by user</span>
                                    @endif
                                    @endif
                                    @endif
                                    @endif
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
    @endsection
    <script>
        function actionRequest(obj, status, id) {
            if (status == 1) {
                swal({
                    title: "Are you sure?",
                    text: "Booking will be cancelled if you continue",
                    icon: "warning",
                    buttons: ["No", "Yes"],
                    dangerMode: true,
                })
                        .then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    url: '<?= url('admin/request/action') ?>',
                                    type: 'POST',
                                    data: 'id=' + id + '&status=' + status + '&_token=<?= csrf_token() ?>',
                                    success: function (data) {
//                    alert(data.message);
                                        data.title = "Action Report!";
                                        if (status == '3') {
                                            $("#reasonError").html(data.message);
                                            $("#rejectReason").modal('close');
                                        }
                                        if (data.error_code == 200) {
                                            successMessage(data);
//                        location.reload();
                                        } else {
                                            errorOccured(data);
                                        }
                                    }
                                });
                            } else {
                                return false;
                            }
                        });
            } else {
                $.ajax({
                    url: '<?= url('admin/request/action') ?>',
                    type: 'POST',
                    data: 'id=' + id + '&status=' + status + '&_token=<?= csrf_token() ?>',
                    success: function (data) {
//                    alert(data.message);
                        data.title = "Action Report!";
                        if (status == '3') {
                            $("#reasonError").html(data.message);
                            $("#rejectReason").modal('close');
                        }
                        if (data.error_code == 200) {
                            successMessage(data);
//                        location.reload();
                        } else {
                            errorOccured(data);
                        }
                    }
                });
            }
        }
    </script>