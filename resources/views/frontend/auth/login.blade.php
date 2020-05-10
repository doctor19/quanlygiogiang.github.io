@extends('frontend.layouts.app')

@section('content')
<div class="login-box" style="width:410px">
    <!-- <div class="login-logo">
        <a href="../../index2.html"><b>Admin</b>LTE</a>
    </div> -->
    <!-- /.login-logo -->
    <div class="login-box-body" style="width: 380px;">
        <p class="login-box-msg"><b>Đăng Nhập Hệ Thống</b></p>
        @include('includes.error')
        <form action="{{route('post.login')}}" method="post">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="email" placeholder="Địa chỉ email" value="{{ old('email') }}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password" placeholder="Mật khẩu">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                        <input type="checkbox" name="remember"> Ghi nhớ
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng Nhập</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
            <!-- <a href="#">I forgot my password</a><br>
            <a href="register.html" class="text-center">Register a new membership</a> -->
    </div>
        <!-- /.login-box-body -->
</div>
@endsection
