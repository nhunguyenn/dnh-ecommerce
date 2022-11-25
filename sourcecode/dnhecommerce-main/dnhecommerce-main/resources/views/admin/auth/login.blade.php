<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/bower_components/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a><b>ĐĂNG NHẬP HỆ THỐNG</b></a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Vui lòng đăng nhập hệ thống trước khi sử dụng!</p>
            <form action="{{ route('admin.auth.handleLogin') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="email" placeholder="Vui lòng địa chỉ email!">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Vui lòng nhập mật khẩu!">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('assets/admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/iCheck/icheck.min.js') }}"></script>
</body>

</html>
