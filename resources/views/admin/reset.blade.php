@extends('admin.layout.master2')

@section('content')
<div class="car-login">
    <div class="row"> 
        <div class="col-md-6">
            <div class="login-car-img">
                <img src="{{asset('assets/images/car2.jpg')}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="login-form-section">
                <div class="login-logo"><img src="{{asset('assets/images/logo_color.png')}}" alt="logo"></div> 
                <form method="POST" action="{{url('admin/resetPassword')}}" class="card-body" tabindex="500">
                    {{csrf_field()}}
                    <h4 class="forgot-heading">Reset Password</h4>
                    <p class="forgot-para">Reset Your Password</p>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" value="{{old('password')}}" class="form-control sty1" placeholder="New Password">
                        <input type="hidden" name="userid" class="form-control" value="{{$id}}">
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                        @if ($errors->has('confirm_password'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('confirm_password') }}</strong>
                        </span>
                        @endif
                    </div>   
                    <div>
                        <div class="col-xs-4">
                            <button type="submit" class="btn-block btn-flat loginbth">Submit</button>
                        </div>
                    </div>
                </form>  
            </div>
        </div>
    </div>
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