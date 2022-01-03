
@extends('admin.layout.master2')

@section('content')
<div class="container-fluid login-cover-section">
    <div class="car-login">
        <div class="row"> 
            <div class="col-md-6">
                <div class="login-car-img">
                    <img src="{{asset('assets/images/car2.jpg')}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="login-form-section">
                    @if(session()->has('block'))
                  <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  {{ session()->get('block') }}
                  </div>
              @endif
                    <div class="login-logo"><img src="{{asset('assets/images/logo_color.png')}}" alt="logo"></div> 
                    <form class="form-box" id="sign_in" method="POST" action="{{ url('admin/dologin') }}" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control sty1" name="email" placeholder="test: admin@jadidly.com"  value="{{ old('email') }}" autofocus>
                            @if ($errors->has('email'))
                            <div class="help-block">
                              <strong class="text-danger">{{ $errors->first('email') }}</strong>
                          </div>
                          @endif
                      </div>
                      <div class="form-group has-feedback eyepassword">
                        <input type="password" id="myInputPass" class="form-control sty1" name="password" value="{{ old('password') }}" placeholder="test: admin">
                        <i class="fa fa-eye" id="togglePass1" onclick="showPassword(this,'myInputPass');"></i>
                        @if ($errors->has('password'))
                        <div class="help-block">
                          <strong class="text-danger">{{ $errors->first('password') }}</strong>
                      </div>
                      @endif
                  </div> 
                  <a href="{{url('admin/forgot-password')}}" class="text-dark">Forgot Password ?</a>
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
</div> 
<script>
  function showPassword(obj, id) {
        if ($('#' + id).attr('type') == 'text') {
            $('#' + id).attr('type', 'password');
            $(obj).removeClass('fa-eye-slash');
            $(obj).addClass('fa-eye');
        } else {
            $('#' + id).attr('type', 'text');
            $(obj).removeClass('fa-eye');
            $(obj).addClass('fa-eye-slash');
        }
    }
</script>
@endsection
