<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
</head>
<body>
    <h1>Trang chủ</h1>

    @auth
        <p>Xin chào <strong>{{ auth()->user()->first_name }}</strong>,</p>
        <p>Cảm ơn bạn đã quay lại trang web.</p>

        <form action="{{ route('auth.login.logout') }}" method="POST">
            @csrf
            <button type="submit">Đăng xuất</button>
        </form>
    @endauth

    @guest
        <p>Xin chào khách vãng lai,</p>
        <a href="{{ route('auth.login.index') }}">Đăng nhập</a>
    @endguest
</body>
</html>
