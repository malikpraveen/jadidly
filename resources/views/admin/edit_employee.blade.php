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
                        <h5 class="card-title">Update Employee</h5>
                    </div>
                    <form method="post" id="addForm" enctype="multipart/form-data" action="{{route('admin.employee.update',[base64_encode($employee->id)])}}" >
                        @csrf
                        <div class="card-body"> 
                            <div class="row">
                                <div class="col-md-6 mb-4 offset-3"> 
                                


                                    <div class="col-md-12 mb-4" id="level-1">
                                       <label>Branch Name</label>
                                       <select class="form-control validate" name="cat_1" id="cat_1" onchange="getSubcategory(this, 2);">
                                          <option disabled="" selected>Select Branch</option>
                                            @if($branch)
                                            @foreach($branch as $key=>$row)
                                           
                                           <option value="{{$row->id}}"<?= $employee->branch_id == $row->id ? 'selected' : '' ?>>{{$row->branch_name}}</option>
                                            @endforeach
                                           @endif
                                      </select>
                                         <p class="text-danger" id="cat_1Error"></p>
                                   </div>

                      
                             

                                    <div class="col-md-12 mb-4">
                                        <label>Employee Name</label>
                                        <input type="text" name="employee_name" value="{{old('employee_name')?old('employee_name'):$employee->employee_name}}" class="form-control">
                                        <p class="text-danger" id="employee_nameError"></p>
                                    </div>

              
                                  <div class="col-md-12 mb-4">
                                     <label >Mobile Number</label>
                                     <div class="form-inline phn">
                                         <select class="select-number" name='country_code' >
                
                                              <!-- <option value="{{old('country_code')}}" @if (old('country_code') == "{{$employee->country_code}}") {{ 'selected' }} @endif>{{$employee->country_code}}</option> -->
                                                <option value="91" @if (old('country_code') == 91) {{ 'selected' }} @endif>91</option>
                                                <option value="222" @if (old('country_code') == 222) {{ 'selected' }} @endif>266</option>
                                                <option value="966" @if (old('country_code') == 966) {{ 'selected' }} @endif>966</option>

                                         </select>
                                           <input type="text"  value="{{old('mobile_number')?old('mobile_number'):$employee->mobile_number}}" class="form-control validate alphanum" name="mobilenumber">
                                          
                                       </div>
                                        <p class="text-danger" id="mobilenumberError"></p>

                                    </div>

                                     

                        
                                    <div class="col-md-12 mb-4">
                                        <label>Email</label>
                                        <input type="text" class="form-control validate alphanum" name="email" value="{{old('email')?old('email'):$employee->email}}">
                                        <p class="text-danger" id="emailError"></p>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label>Local Address</label>
                                        <input type="text" class="form-control validate" name="localaddress"  value="{{old('local_address')?old('local_address'):$employee->local_address}}">
                                        <p class="text-danger" id="localaddressError"></p>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label>Nationality</label>
                                        <input type="text" class="form-control validate" name="nationality" value="{{old('nationality')?old('nationality'):$employee->nationality}}">
                                        <p class="text-danger" id="nationalityError"></p>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label>Age</label>
                                        <input type="text" class="form-control validate" name="age" value="{{old('age')?old('age'):$employee->age}}">
                                        <p class="text-danger" id="ageError"></p>
                                    </div>

                                   
                                    <div class="col-md-12 ">
                                      <label> Gender: </label>  <br>  
                                       <input type="radio"  name="gender" value="male" @if(old('gender') == 'male' || $employee->gender == 'male') checked @endif  /> Male        
                                       <br>  
                                        <input type="radio"  name="gender" value="female"  @if(old('gender') == 'female' || $employee->gender == 'female') checked @endif  /> Female 
                                        <p class="text-danger" id="genderError"></p>
                                    </div>


                                    <div class="col-md-12">
                                        <p class="">(Preferred image dimension 200*200)</p>

                                        <div class="form-group titleeventimage">
                                            <div class="file-upload">
                                                <img id="blah1" src="{{$employee->image?$employee->image: asset('assets/images/dummy1.jpg')}}" alt="your image" />
                                                <label for="upload1"  class="file-upload__label text-small">Upload Icon</label>
                                                <input id="upload1" accept="image/*" class="file-upload__input " type="file" name="category_image" onchange="readURL(this, 1); validImage(this, 700, 400);">
                                                <p class="text-danger" id="category_imageError"></p>
                                            </div> 
                                        </div>
                                    </div>

                                

     
                            <div class="col-md-12 mb-4">
                                <label for="lastName1">Upload id images</label>
                                <span class="">(Preferred image dimension 740*440)</span>
                                <div class="form-group row titleeventimage">

                                    <div class=" file-upload mr-1">
                                        <img id="blah2" src="{{$employee->id_image_front?$employee->id_image_back: asset('assets/images/dummy.jpg')}}" alt="your image" />
                                        <label for="upload2"  class="file-upload__label">Front Image</label>
                                        <input id="upload2" accept="image/*" class="file-upload__input " type="file" name="images1" onchange="readURL(this, 2);validImage(this, 740, 440);">
                                        <div class="text-danger" id="images1Error"></div>
                                    </div>
                                    <div class="file-upload ">
                                        <img id="blah3" src="{{$employee->id_image_back?$employee->id_image_back: asset('assets/images/dummy.jpg')}}"  alt="your image" />
                                        <label for="upload3" class="file-upload__label"> Back Image</label>
                                        <input id="upload3" accept="image/*" class="file-upload__input " type="file" name="images2" onchange="readURL(this, 3);validImage(this, 740, 440);">
                                        <div class="text-danger" id="images2Error"></div>
                                    </div>
                                </div>
                            </div>
                           
                    </div>

                                        

                                 <div class="col-md-12"> 
                                     
                                  <button type="button" onclick="validate(this);" class="mybtns-upload">Submit</button> 
                                    <!-- <button type="submit" hidden="" id="submitButton" class="mybtns-upload">Submit</button>  -->
                                </div>
                          </div>
                       </div>
                        
                </form>
           </div>
     </div>
 @endsection 

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
                    $("#" + name + "Error").html("");
                }
            });
           

            if (flag) {
                $("#addForm").submit();
                //$("#submitButton").click();
            } else {
                return false;
            }
        }
 </script>
