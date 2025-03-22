<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khôi phục mật khẩu</title>
    <style>
        /* Reset CSS cho email */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        table {
            border-spacing: 0;
            width: 100%;
        }

        /* Thiết lập kiểu dáng cho email */
        .email-container {
            width: 100%;
            background-color: #f7f7f7;
            padding: 40px 0;
        }

        .email-content {
            background-color: #ffffff;
            border-radius: 8px;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            color: #333333;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #666666;
            line-height: 1.5;
            text-align: center;
        }

        a {
            display: inline-block;
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 4px;
            margin-top: 20px;
            text-align: center;
        }

        a:hover {
            background-color: #45a049;
        }

        .footer {
            font-size: 12px;
            color: #888888;
            text-align: center;
            margin-top: 30px;
        }

        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-content">
            <h1>Chào {{ $user->name }},</h1>
            <p>Bạn đã yêu cầu khôi phục mật khẩu. Vui lòng nhấn vào liên kết dưới đây để đặt lại mật khẩu:</p>
            <a href="{{ url('http://127.0.0.1:8000/password/reset/' . urlencode($user->email) . '/' . $token) }}">Khôi phục mật khẩu</a>
            <p>Chúc bạn một ngày tốt lành!</p>
        </div>
        <div class="footer">
            <p>Nếu bạn không yêu cầu thay đổi mật khẩu, vui lòng bỏ qua email này.</p>
            <p>© 2025 Công ty XYZ</p>
        </div>
    </div>
</body>
</html>
