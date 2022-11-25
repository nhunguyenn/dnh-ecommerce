@extends('layouts.client')

@section('title', 'Register')

@section('content')
<div class="body-content outer-top-xs" style="margin: 50px;">
    <div class="body-content">
        <div class="container" style="width: 500px;">
            <div class="sign-in-page">
                <div class="row">
                    <div class="col-md-12 col-sm-12 create-new-account">
                        <h4 class="checkout-subtitle" style="padding-bottom: 20px;">ĐĂNG KÝ TÀI KHOẢN MỚI</h4>
                        <p class="text title-tag-line">Nếu bạn chưa có tài khoản vui lòng đăng ký tại đây!</p>
                        <form class="register-form outer-top-xs" role="form" method="post" action="{{ route('client.auth.handleRegister') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="info-title" for="name">Họ và Tên <span>*</span></label>
                                <input type="text" class="form-control unicase-form-control text-input" name="name" id="name">
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="gender">Giới tính <span>*</span></label>
                                <select class="form-control" name="gender">
                                    <option value="0">Nam</option>
                                    <option value="1">Nữ</option>
                                    <option value="2">Khác</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="specific_address">Địa chỉ cụ thể <span>*</span></label>
                                <input type="text" class="form-control unicase-form-control text-input" name="specific_address" id="specific_address">
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="phone">Số điện thoại <span>*</span></label>
                                <input type="text" class="form-control unicase-form-control text-input" name="phone" id="phone">
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="email">Địa chỉ email <span>*</span></label>
                                <input type="email" class="form-control unicase-form-control text-input" name="email" id="email">
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="password">Mật khẩu <span>*</span></label>
                                <input type="password" class="form-control unicase-form-control text-input" name="password" id="password">
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="password">Xác nhận mật khẩu <span>*</span></label>
                                <input type="password" class="form-control unicase-form-control text-input" name="password" id="password">
                            </div>
                            <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Đăng ký</button>
                            <div class="" style="text-align: center; padding-top: 10px;">
                                <a href="{{ route('client.auth.login') }}">Bạn đã có tài khoản?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
