@extends('web.layout.master')
@section('content')
<!--Page Title-->
<section class="page-title" style="background-image:url(<?= asset('assetsFront/images/background/3.jpg') ?>)">
    <div class="auto-container text-center">
        <h2>My Booking</h2>
        <ul class="page-breadcrumb"> 
            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
        </ul>
    </div>
</section>
<!--End Page Title-->
<!-- News Section -->
<section class="news-section my-booking-section">
    <div class="auto-container">
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
        <!-- <div class="row mb-4">
            <div class="col-md-4 offset-md-4 mb-3">
                <select class="form-control">
                    <option>Request Status</option>
                    <option>Pending</option>
                    <option>Completed</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <div class="searchicon"> 
                <input type="text" name="" class="form-control">
                <i class="fa fa-search"></i>
                </div>
            </div>
        </div> -->
        <div class="row clearfix service-block-two">
            <div class="col-md-12">



                <div class="table-responsive">
                    <div class="table-outer service-cart">
                        <table class="cart-table w-100">
                            <thead class="cart-header">
                                <tr>
                                    <th>Booking Id</th>
                                    <th class="price">Booking Date & Time</th>
                                    <th class="price">Service Name</th>  
                                    <th class="price">Price</th>  
                                    <th class="price">Booking Status</th>  
                                    <th class="price">Action</th> 
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <tr> 
                                    <td style="background-color:#efefef" colspan="6">No Bookings Found</td>     
                                </tr> 
                            </tbody>
                        </table>  
                    </div>

                </div>
            </div>
        </div>

        <!--Styled Pagination-->
        <!-- <ul class="styled-pagination text-center">
            <li><a href="#" class="active">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#"><span class="fa fa-angle-right"></span></a></li>
        </ul>   -->              
        <!--End Styled Pagination-->
    </div>
</section>
<!-- End News Section -->
@endsection
<script src="{{asset('assetsFront/js/jquery.js')}}"></script>
<script>
$(document).ready(function () {
    $.ajax({
        headers: {'Authorization': 'Bearer <?= $user['token'] ?>'},
        url: '<?= url('/api/myBookings') ?>',
        type: 'GET',
        data: '',
        success: function (data) {
//            console.log(data);
            if (data.status == true && data.status_code == 200) {
                if (data.data.length > 0) {
                    $("#tableBody").empty();
                    var bookings = data.data;
                    $(bookings).each(function (i, booking) {
                        var html = '<tr><td class="sub-total">#' + booking.id + '</td>' +
                                '<td class="sub-total">' + booking.booking_datetime + '</td> ' +
                                '<td class="sub-total">' + booking.service_name + '</td> ' +
                                '<td class="sub-total">' + booking.amount + ' KWD</td> ' +
                                '<td class="sub-total ' + (booking.status == '0' || booking.status == '1' ? 'text-warning' : (booking.status == '3' || booking.status == '4' ? 'text-danger' : 'text-success')) + '">' + (booking.status == '0' ? 'Requested' : (booking.status == '1' ? 'In Process' : (booking.status == '2' ? 'Completed' : (booking.status == '3' ? 'Rejected' : 'Cancelled')))) + '</td>' +
                                '<td class="sub-total link-box"> <a href="<?= url('my-account/booking-detail') ?>/' + btoa(booking.id) + '" class="theme-btn btn-style-one"><span class="btn-title">View Detail</span></a> </td>' +
                                '</tr>';
                        $("#tableBody").append(html);
                    });


                }
            } else if (data.status_code == 401) {
                 sessionExpired(data);
            }
        }
    });


});
</script>