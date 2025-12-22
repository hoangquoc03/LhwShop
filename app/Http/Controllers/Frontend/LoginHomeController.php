<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ShopCategory;
use Laravel\Socialite\Facades\Socialite;

use App\Models\ShopCustomer;

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
            $request->session()->regenerate();

            return redirect()->intended(route('frontend.home.index'));
        }

        return back()->withErrors([
            'username' => 'Thông tin đăng nhập không đúng',
        ])->withInput();
    }
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            // ✅ BẮT BUỘC với ngrok
            $facebookUser = Socialite::driver('facebook')->stateless()->user();

            $email = $facebookUser->getEmail()
                ?? $facebookUser->getId() . '@facebook.local';

            $customer = ShopCustomer::firstOrCreate(
                ['email' => $email],
                [
                    'username' => $facebookUser->getName() ?? 'Facebook User',
                    'password' => bcrypt(Str::random(16)),

                    // 🔥 BỔ SUNG FULL CỘT NOT NULL (QUAN TRỌNG)
                    'first_name' => $facebookUser->getName() ?? 'Facebook',
                    'last_name'  => 'User',
                    'gender'     => 1,
                    'birthday'   => now()->subYears(20),
                    'avatar'     => $facebookUser->getAvatar() ?? '',
                    'code'       => Str::uuid(),
                    'company'    => '',
                    'phone'      => '',
                    'billing_address'  => '',
                    'shipping_address' => '',
                    'city'       => '',
                    'state'      => '',
                    'postal_code' => '',
                    'country'    => '',
                    'remember_token' => Str::random(10),
                    'activate_code'  => Str::random(20),
                    'status'     => 1,
                ]
            );

            // ✅ Login & giữ session
            Auth::guard('customer')->login($customer);
            request()->session()->regenerate();

            // ✅ THÀNH CÔNG → về trang chủ
            return redirect('/');
        } catch (\Exception $e) {
            // ❌ Nếu còn lỗi sẽ thấy ngay
            dd('FACEBOOK LOGIN FAIL', $e->getMessage());
        }
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
