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
            <form method="POST" action="{{url('admin/checkOTP')}}" class="card-body" tabindex="500">
                            {{csrf_field()}}
                <h4 class="forgot-heading">OTP Verification</h4>
                <p class="forgot-para">Please Enter the OTP</p>
                <div class="form-group has-feedback mb-1">
                    <input type="text" name="otp" class="form-control" placeholder="">
                    @if ($errors->has('otp'))
                        <div class="help-block">
                            <strong class="text-danger">{{ $errors->first('otp') }}</strong>
                        </div>
                    @endif
                    <input type="hidden" name="user_id" value="{{$id}}" class="form-control" placeholder="">
                </div>
                <a href="#" class="text-dark"><!-- 00:05 min --> <span class="pull-right">Resend OTP</span></a>  
                <div>
                    <div class="col-xs-4 m-t-1">
                        <button type="submit" class="btn-block btn-flat loginbth">Submit</button>
                    </div>
                </div>
            </form>  
                </div>
                </div>
            </div>
        </div>
@endsection