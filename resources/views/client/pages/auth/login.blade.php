<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Trang đăng nhập</title>
    <link href="{{ asset('server/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('server/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('server/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('server/css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6">
                <h2 class="font-bold">Welcome to 23WebC</h2>
                <h3>Nền tảng thương mại điện tử của CĐ KTCT</h3>
                <p style="margin-top: 30px; font-size: 16px; opacity: 0.9;">
                    Đăng nhập để truy cập vào hệ thống quản trị và bắt đầu quản lý doanh nghiệp của bạn.
                </p>
            </div>
            <div class="col-md-6">
                <div class="ibox-content">
                    <form class="m-t" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label class="text-center">Email</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Nhập email"
                                required="" value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <div class="alert alert-danger">*{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                            <label>Mật khẩu</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Nhập mật khẩu"
                                required="">
                        </div>
                        @error('password')
                            <div class="alert alert-danger">*{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-primary block full-width m-b">Đăng nhập</button>
                        <p class="text-muted text-center">
                            <small>Do not have an account?</small>
                        </p>
                        <a class="btn btn-sm btn-white btn-block" href="{{ route('auth.register') }}">Create an
                            account</a>
                    </form>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-6">
                Copyright Example Company
            </div>
            <div class="col-md-6 text-right">
                <small>&copy;{{ now()->year }}</small>
            </div>
        </div>
    </div>

</body>

</html>
