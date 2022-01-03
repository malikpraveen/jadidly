@extends('admin.layout.master')

@section('content')

<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Employee Management</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Employee Management</li>
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
                        <h5 class="card-title">Add Employee</h5>
                    </div>
                    <form method="post" id="addForm" enctype="multipart/form-data" action="{{route('admin.employee.submit')}}" >
                        @csrf
                        <div class="card-body"> 
                            <div class="row">
                                <div class="col-md-6 mb-4 offset-3"> 
                                


                                    <div class="col-md-12 mb-4" id="level-1">
                                       <label>Branch Name</label>
                                       <select class="form-control validate" name="cat_1" id="cat_1" onchange="getSubcategory(this, 2);">
                                          <option disabled="" selected>Select Branch</option>
                                            @if($branch_name)
                                            @foreach($branch_name as $key=>$row)
                                           <option value="{{$row->id}}">{{$row->branch_name}}</option>
                                            @endforeach
                                           @endif
                                      </select>
                                         <p class="text-danger" id="cat_1Error"></p>
                                   </div>

                      
                                    <div class="col-md-12 mb-4">
                                        <label>Employee Name</label>
                                        <input type="text" class="form-control validate alphanum" name="employee_name"  placeholder="Employee Name">
                                        <p class="text-danger" id="employee_nameError"></p>
                                    </div> 

              
                                    <div class="col-md-12 mb-4">
                                     <label >Mobile Number</label>
                                     <div class="form-inline phn">
                                         <select class="select-number" name='country_code'>
                                            <option value='966'>+966</option>
                                              <option value='222'>+222</option>
                                             <option value='91'>+91</option>
                                         </select>
                                           <input type="text" placeholder="enter number " class="form-control validate alphanum" name="mobilenumber">
                                          
                                       </div>
                                       <p class='text-danger' id='mobilenumberError'></p>

                                     </div>

                                     

                        
                                    <div class="col-md-12 mb-4">
                                        <label>Email</label>
                                        <input type="text" class="form-control validate alphanum" name="email"  placeholder="Enter Email">
                                        <p class="text-danger" id="emailError"></p>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label>Local Address</label>
                                        <input type="text" class="form-control validate" name="localaddress"  placeholder="enter local address">
                                        <p class="text-danger" id="localaddressError"></p>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label>Nationality</label>
                                        <input type="text" class="form-control validate" name="nationality"  placeholder="enter local address">
                                        <p class="text-danger" id="nationalityError"></p>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label>Age</label>
                                        <input type="text" class="form-control validate" name="age"  placeholder="enter age">
                                        <p class="text-danger" id="ageError"></p>
                                    </div>

                                   
                                    <div class="col-md-12 ">
                                      <label> Gender: </label>  <br>  
                                       <input type="radio"  name="gender" value="male" /> Male        
                                       <br>  
                                        <input type="radio"  name="gender" value="female" /> Female 
                                        <p class="text-danger" id="genderError"></p>
                                    </div>


                                    <div class="col-md-12">
                                    <label for="lastName1">Upload Profile Image</label>
                                    <span class="">(Preferred image dimension 200*200)</span>

                                        <div class="form-group titleeventimage">
                                            <div class="col-md-5 file-upload">
                                                <img id="blah1" src="{{ asset('assets/images/dummy.jpg')}}" alt="your image" />
                                                <label for="upload1"  class="file-upload__label ">Upload Icon</label>
                                                <input id="upload1" accept=".png" class="file-upload__input validate " type="file" name="category_image" onchange="readURL(this, 1); validImage(this, 200, 200);">
                                                <p class="text-danger" id="category_imageError"></p>
                                            </div> 
                                        </div>
                                    </div>

                                

     
                            <div class="col-md-12 mb-4">
                                <label for="lastName">Upload id images</label>
                                <span class="">(Preferred image dimension 740*440)</span>
                                <div class="form-group row titleeventimage">

                                    <div class="col-md-5 file-upload mr-1">
                                        <img id="blah2" src="{{ asset('assets/images/dummy.jpg')}}" alt="your image" />
                                        <label for="upload2"  class="file-upload__label">Front Image</label>
                                        <input id="upload2" accept="image/*" class="file-upload__input validate" type="file" name="images1" onchange="readURL(this, 2);validImage(this, 740, 440);">
                                        <div class="text-danger" id="images1Error"></div>
                                    </div>
                                    <div class="col-md-5 file-upload ">
                                        <img id="blah3" src="{{ asset('assets/images/dummy.jpg')}}"  alt="your image" />
                                        <label for="upload3" class="file-upload__label"> Back Image</label>
                                        <input id="upload3" accept="image/*" class="file-upload__input validate " type="file" name="images2" onchange="readURL(this, 3);validImage(this, 740, 440);">
                                        <div class="text-danger" id="images2Error"></div>
                                    </div>
                                </div>
                            </div>
                           
                    </div>

                                        

                                 <div class="col-md-12"> 
                                     
                                     <button type="button" onclick="validate(this);" class="mybtns-upload">Submit</button>
                                     <!-- <button type="submit" hidden name="submit" id="submitButton" class="mybtns-upload">Submit</button>  -->
                                </div>
                          </div>
                       </div>
                        
                </form>
           </div>
     </div> 





            <div class="col-md-12 mt-4">
                <div class="card"> 
                    <div class="card-header">
                        <h5 class="card-title">Employee List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-image">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Branch name </th>
                                         <th>employee name </th>
                                         <th>Country Code </th>
                                        <th>Mobile Number</th>
                                        <th>Email</th> 
                                        <th>Local address</th> 
                                        <th>Nationality </th>
                                        <th>Age </th>
                                        <th>Gender</th>
                                        <th>Image </th>
                                        <th>Id Image Front </th>
                                        <th>Id Image Back </th>
                                        <th>Status</th> 
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($employees_data)
                                    @foreach($employees_data as $key=>$employee_data)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                       
                                        <td>{{$employee_data->branch_name}}</td>
                                        
                                        <td>{{$employee_data->employee_name}}</td>
                                        <td>{{$employee_data->country_code}}</td>
                                        <td>{{$employee_data->mobile_number}}</td>
                                        <td>{{$employee_data->email}}</td>
                                        <td>{{$employee_data->local_address}}</td>
                                        <td>{{$employee_data->nationality}}</td>
                                        <td>{{$employee_data->age}}</td>
                                        <td>{{$employee_data->gender}}</td>
                                        <td><img src="{{($employee_data->image?$employee_data->image:asset('assets/images/dummy1.jpg'))}}"></td>
                                        <td><img src="{{($employee_data->id_image_front?$employee_data->id_image_front:asset('assets/images/dummy.jpg'))}}"></td>
                                        <td><img src="{{($employee_data->id_image_back?$employee_data->id_image_back:asset('assets/images/dummy.jpg'))}}"></td>
                                        
                                        <td>
                                           <div class="mytoggle">
                                                <label class="switch">
                                                    <input type="checkbox" onchange="changeemployeeStatus(this, '<?= $employee_data->id ?>');" <?= ($employee_data->status == 'active' ? 'checked' : '') ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </td> 
                                        <td>
                                            
                                        <a href="{{url("admin/edit_employee_list").'/'.base64_encode($employee_data->id)}}" class="composemail-edit"><i class="fa fa-edit"></i></a>
                                           
                                            <a href="<?= url('admin/employee_details/' . base64_encode($employee_data->id)) ?>" class="composemail-edit"><i class="fa fa-eye"></i></a>
                                        
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
                    <h4 class="text-white">Employee Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>

                </div>

                <!-- Modal Body -->  
                <div class="modal-body text-center">
                    <div class="body-message">
                        <!--<a href="#"><i class="fa fa-check confirm-booking-icon"></i></a>-->
                        <table class="table">
                            <tbody >
                                <tr>
                                    <th>Branch Name </th>
                                    <td id="branch_name">Branch Name </td>
                                </tr>
                                <tr>
                                    <th>Employee Name </th>
                                    <td id="employee_name">Employee Nam</td>
                                </tr>
                                <tr>
                                    <th>Country Code</th>
                                    <td id="country_code">Country Code</td>
                                </tr>
                                <tr>
                                    <th>Mobile Number</th>
                                    <td id="mobile_number">Mobile Number</td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td id="email">Email</td>
                                </tr>
                                <tr>
                                    <th>Local Address</th>
                                    <td id="local_address">Local Address</td>
                                </tr>
                                <tr>
                                    <th>Nationality</th>
                                    <td id="nationality">Nationality</td>
                                </tr>
                                <tr>
                                    <th>Age</th>
                                    <td id="age">Age</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td id="gender">Gender</td>
                                </tr>
                                <tr>
                                    <th>Image</th>
                                    <td id="image">Image</td>
                                </tr>
                                <tr>
                                    <th>Id Image Front</th>
                                    <td id="id_image_front">Id Image Front</td>
                                </tr>
                                <tr>
                                    <th>Id Image Back</th>
                                    <td id="id_image_back">Id Image Back</td>
                                </tr>
                                 <tr>
                                    <th>Status</th>
                                    <td id="status">Active</td>
                                </tr>
                                
 

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
   

    
    <script>
         function validate(obj) {
            $(".text-danger").html('');
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

                }
            });

            // if ($(":input[name=category_image]").val() == "") {
            //     flag = false;
            //     $("#img_error").html("This field is required");
            // } else {
            //     if (imgflag == true) {
            //         $("#img_error").html("");
            //     }

            // }
           
            if (flag) {
                $("#addForm").submit();
            } else {
                return false;
            }

            
        }


    function changeemployeeStatus(obj, id) {
            swal({
                title: "Are you sure?",
                text: "Category status will be updated",
                icon: "warning",
                buttons: ["No", "Yes"],
                dangerMode: true,
            })
                    .then((willDelete) => {
                        if (willDelete) {
                            var checked = $(obj).is(':checked');
                            if (checked == true) {
                                var status = 'active';
                            } else {
                                var status = 'inactive';
                            }
                            if (id) {
                                $.ajax({
                                    url: "<?= url('admin/change_employee_status') ?>",
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


  


</script>
@endsection




