@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Additional Charges</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Additional Charges</li>
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
            </div> 





            <div class="col-md-12 mt-4">
                <div class="card"> 
                    <div class="card-header">
                        <h5 class="card-title">All Additional Charges Applicable</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-image">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Title</th>
                                        <th>Charge</th> 
                                        <th>Action</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($charges)
                                    @foreach($charges as $key=>$charge)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{str_replace('_',' ',$charge->type)}} </td>
                                        <td>{{$charge->charges}} KWD</td>
                                        <td>
                                            <a href="#details" onclick="editCharges(this, '<?= $charge->id ?>');" class="composemail-edit"><i class="fa fa-edit"></i></a>
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
    <div class="modal bs-example-modal-new checkout-modal" id="details" style='background-color: #eeeeeea3;' data-keyboard='false' data-backdrop='static'tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <!-- Modal Content: begins -->
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header border-bottom-0">
                    <h4 class="text-white">Update Charges</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>

                </div>

                <!-- Modal Body -->  
                <div class="modal-body">
                    <div class="body-message">

                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <input type="text" class="form-control" name="charges" value="0" id="amount">
                                <p class="text-danger" id="amountError"></p>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-success" id="saveBtn" onclick="">Save</button>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger" id="cancelBtn">Cancel</button>
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
        var allList =<?= \GuzzleHttp\json_encode($charges) ?>;
        function update(obj, id) {
            var amount = $("#amount").val();
            var isValid = checkPrice($("#amount"));
            if (isValid) {
                $("#amountError").html("");
                swal({
                    title: "Are you sure?",
                    text: "Amount will be updated",
                    icon: "warning",
                    buttons: ["No", "Yes"],
                    dangerMode: true,
                })
                        .then((willDelete) => {
                            if (willDelete) {

                                if (id) {




                                    $.ajax({
                                        url: "<?= url('admin/update_amount') ?>",
                                        type: 'post',
                                        data: 'id=' + id + '&action=' + amount + '&_token=<?= csrf_token() ?>',
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
            } else {
                $("#amountError").html("Charges must be a valid number");
            }
        }

        function editCharges(obj, id) {
            $("#amount").val('0');
            $(allList).each(function (b, charges) {
                if (charges.id == id) {
                    $("#amount").val(charges.charges);
                }
                $("#saveBtn").attr('onclick', 'update(this,"' + id + '")');
            });
            $("#details").modal();
        }

    </script>
