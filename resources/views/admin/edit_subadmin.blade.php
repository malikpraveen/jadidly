@extends('admin.layout.master')
@section('content')
<div class="content-wrapper">
    <div class="content-header sty-one">
        <h1>Edit sub admin</h1>
        <ol class="breadcrumb">
            <li><a href="<?= url('admin/home') ?>">Home</a></li>
            <li><i class="fa fa-angle-right"></i> Sub Admin Management</li>
        </ol>
    </div>
    <div class="content">
        <form method='post'>
            @csrf
            <div class="card">
                <div class="card-body">  

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="firstName1">Enter the Sub admin name</label>
                                <input class="form-control characterOnly" type="text" name="name" value="{{old('name')?old('name'):$admin->name}}">
                                <p class="text-danger" id="nameError"><?= $errors->first('name') ?></p>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="firstName1">Enter the email address</label>
                                <input class="form-control" type="email" name='email' value="{{old('email')?old('email'):$admin->email}}">
                                <p class="text-danger" id="emailError"><?= $errors->first('email') ?></p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="firstName1">Enter the password</label> 
                            <div class="form-group eyepassword">
                                <input class="form-control" id='password' type="password" name="password" value="{{old('password')}}" placeholder="••••••••">
                                <i class="fa fa-eye" onclick="showPassword(this, 'password');"></i>
                                <p class="text-danger" id="passwordError"><?= $errors->first('password') ?></p>
                            </div>
                        </div>
                    </div> 
                    <div class="row mt-3 mb-4">
                        <div class="col-md-12">
                            <div class="choose-food">
                                <div class="button-group-pills" data-toggle="buttons">
                                    @if($privilegde)
                                    @foreach($privilegde as $priv)
                                    <label class="btn btn-default <?= in_array($priv->id, $admin['permissions']) ? 'active' : '' ?>">
                                        <input type="checkbox" name="permission[]" <?= in_array($priv->id, $admin['permissions']) ? 'checked' : '' ?> value="{{$priv->id}}">
                                        <div>{{$priv->name}}</div>
                                    </label>  
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div> 

                </div>
            </div> 
            <div class="row mt-4 mb-3">
                <div class="col-md-12 text-center"> 
                    <button type="submit" name="submit" class="mybtns-upload">Add</button>  
                </div>
            </div> 
        </form>
    </div>
    @endsection
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script>
                                        $(function () {
                                            $(':input[type=password]').on('keypress', function (e) {
                                                if (e.which == 32)
                                                    return false;
                                            });
                                        });
    </script>