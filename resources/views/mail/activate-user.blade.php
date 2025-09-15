<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kích hoạt tài khoản</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f9fafb; padding: 20px;">
    <table width="100%" style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; padding: 20px;">
        <tr>
            <td align="center">
                <h2 style="color:#111827;">Xin chào {{ $newUser->first_name }} {{ $newUser->last_name }} 👋</h2>
                <p style="color:#374151; font-size: 16px;">
                    Cảm ơn bạn đã đăng ký tài khoản tại <strong>LHWShop</strong>.
                </p>
                <p style="color:#374151; font-size: 16px;">
                    Vui lòng nhấn vào nút bên dưới để kích hoạt tài khoản:
                </p>
                <a href="{{ $activationUrl }}"
                   style="display:inline-block; margin-top:20px; padding:12px 24px; background:#2563eb; color:#fff; text-decoration:none; border-radius:6px; font-weight:bold;">
                   Kích hoạt tài khoản
                </a>
                <p style="margin-top:30px; font-size:14px; color:#6b7280;">
                    Nếu bạn không tạo tài khoản này, vui lòng bỏ qua email.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
