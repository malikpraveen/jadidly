@extends('admin.layout.master2')
@section('content')
<div class="car-login">
    <div class="row" style='width:100%';> 
        <div class="col-md-12 text-center">
            <div class="login-form-section text-center">
                <div class="login-logo"><img src="{{asset('assets/images/logo_color.png')}}" alt="logo"></div> 
                <h5>You are not authorized to access this page. <a href='<?=url('admin/home')?>'>Click here to redirect on Dashboard</a></h5>
            </div>
        </div>
    </div>
</div>
@endsection