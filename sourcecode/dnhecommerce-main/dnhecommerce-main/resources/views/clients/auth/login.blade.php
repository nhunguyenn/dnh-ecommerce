@extends('layouts.client')

@section('title', 'Login')

@section('content')
    <div class="body-content outer-top-xs" style="margin: 50px;">
        <div class="body-content">
            <div class="container" style="width: 500px;">
                <div class="sign-in-page">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 sign-in">
                            <h4 class="" style="padding-bottom: 20px;">ĐĂNG NHẬP</h4>
                            <p class="" >Xin chào, Vui lòng đăng nhập tài khoản.</p>
                            <form class="register-form outer-top-xs" role="form" method="post" action="{{ route('client.auth.handleLogin') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="info-title" for="email">Địa chỉ email <span>*</span></label>
                                    <input type="text" class="form-control unicase-form-control text-input" name="email" id="email">
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="password">Mật khẩu <span>*</span></label>
                                    <input type="password" class="form-control unicase-form-control text-input" name="password" id="password">
                                </div>
                                <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Login</button>
                                <div class="" style="text-align: center; padding-top: 10px;">
                                    <a href="{{ route('client.auth.register') }}">Bạn chưa có tài khoản?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
