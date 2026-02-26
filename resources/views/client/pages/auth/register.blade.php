<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Trang đăng ký</title>
    <link href="{{ asset('server/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('server/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('server/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('server/css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <h3>Đăng ký to 23WebC</h3>
            <p>Tạo tài khoản để thực hiện các chức năng.</p>
            <form class="m-t" role="form" action="{{ route('auth.register') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Tên đăng nhập </label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('name') }}" placeholder="Nhập tên tài khoản" name="name" required="">
                </div>
                @error('name')
                    <div class="alert alert-danger">*{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="Nhập email" required="" value="{{ old('email') }}">
                </div>
                @error('email')
                    <div class="alert alert-danger">*{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Nhập mật khẩu" required="">
                </div>
                @error('password')
                    <div class="alert alert-danger">*{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <div class="checkbox i-checks"><label> <input type="checkbox"><i></i> Đồng ý với các điều khoản và
                            chính sách
                        </label></div>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Đăng ký</button>

                <p class="text-muted text-center"><small>Bạn đã có tài khoản?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="{{ route('login') }}">Đăng nhập</a>
            </form>
            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; {{ now()->year }}</small>
            </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
</body>

</html>
