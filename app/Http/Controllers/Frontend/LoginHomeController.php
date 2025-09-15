<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ShopCategory;
class LoginHomeController extends Controller
{
    public function index()
    {
        $categories = ShopCategory::all();

        return view('frontend.login.index', compact('categories'));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            $request->session()->regenerate(); // bảo mật session

            return redirect()->intended(route('frontend.home.index'));
        }

        return back()->withErrors([
            'username' => 'Thông tin đăng nhập không đúng',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('frontend.home.index');
    }
    protected function redirectTo()
    {
        return session('url.intended', route('cart.index'));
    }

}