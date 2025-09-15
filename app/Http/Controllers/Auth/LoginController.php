<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers, ValidatesRequests;

    // Hiển thị form login
    public function index()
    {
        return view('auth.login.index');
    }

    // Xử lý login
    public function login(Request $request)
    {
        $this->validateLogin($request);
        $credentials = $this->credentials($request);

        // Chỉ login staff
        if (Auth::guard('staff')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        // Nếu login thất bại
        return back()->withErrors([
            $this->username() => 'Thông tin đăng nhập không đúng',
        ])->withInput();
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('staff')->logout(); // Chỉ logout staff
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Trường dùng để login
    public function username()
    {
        return 'username';
    }

    // Lấy credentials
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    // Validate dữ liệu login
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }
}