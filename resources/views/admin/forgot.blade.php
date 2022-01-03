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
    <form class="form-box" id="sign_in" method="POST" action="{{ url('admin/forget') }}" autocomplete="off">
                        {{ csrf_field() }}
        <h4 class="forgot-heading">Forgot Password</h4>
        <p class="forgot-para">Enter the Registered email Id</p>
        <div class="form-group has-feedback">
            <input type="text" class="form-control sty1" name="email" value="{{old('email')}}" placeholder="Email Address">
            @if ($errors->has('email'))
                            <div class="help-block">
                              <strong class="text-danger">{{ $errors->first('email') }}</strong>
                          </div>
                          @endif
        </div>  
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