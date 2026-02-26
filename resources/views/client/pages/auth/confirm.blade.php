<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Xin chào {{ $user->name }},</h2>

        <p>Cảm ơn bạn đã đăng ký tài khoản. Vui lòng xác nhận địa chỉ email của bạn bằng cách nhấp vào nút bên dưới:</p>

        <a href="{{ route('auth.active.email', ['email' => $user->email]) }}" class="button">Xác nhận Email</a>

        <p>Hoặc copy link sau vào trình duyệt:</p>
        {{-- <p>{{ $verificationUrl }}</p> --}}

        <p>Link này sẽ hết hạn sau 24 giờ.</p>

        <div class="footer">
            <p>Nếu bạn không tạo tài khoản này, vui lòng bỏ qua email này.</p>
        </div>
    </div>
</body>

</html>
