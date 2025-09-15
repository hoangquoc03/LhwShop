<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use App\Models\AclUser;
use App\Models\ShopCustomer;
use Ramsey\Uuid\Uuid;
use App\Mail\ActivateUserMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isNull;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    public function index(){
        return view('auth/register/index');
    }
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:2|max:20',
            'last_name'  => 'required|string|min:2|max:20',
            'username'   => 'required|string|min:2|max:20|unique:acl_users,username|unique:shop_customers,username',
            'email'      => 'required|email|max:50|unique:acl_users,email|unique:shop_customers,email',
            'password1'  => 'required|string|min:6|same:password2',
            'password2'  => 'required|string|min:6',
            'gender'     => 'required|in:male,female,other',
            'terms'      => 'accepted'
        ], [
            'username.unique' => 'Tên người dùng đã tồn tại.',
            'email.unique'    => 'Email đã tồn tại.',
            'password1.same'  => 'Mật khẩu xác nhận không khớp.',
            'password1.min'   => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password2.min'   => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'terms.accepted'  => 'Bạn phải chấp nhận Điều khoản và Điều kiện.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $gender = match($request->gender) {
            'male' => 0,
            'female' => 1,
            default => 2,
        };

        // Lưu vào bảng acl_users
        $newUser = AclUser::create([
            'username'    => $request->username,
            'password'    => $request->password1,
            'last_name'   => $request->last_name,
            'first_name'  => $request->first_name,
            'gender'      => $gender,
            'email'       => $request->email,
            'active_code' => (string) Uuid::uuid4(),
            'status'      => 0,
            'created_at'  => now(),
        ]);

        // Gửi mail kích hoạt
        Mail::to($newUser->email)->send(new ActivateUserMail($newUser));

        return redirect()
            ->route('auth.register.register-success')
            ->with('newUser', $newUser);
    }

    public function registerSuccess() {
        $newUser = session('newUser');
        if (!$newUser) {
            return redirect()->route('auth.register.index')->withErrors('Không tìm thấy thông tin người dùng.');
        }
        return view('auth.register.register-success', compact('newUser'));
    }   
    public function activeUser(Request $request)
    {
        $username = $request->query('username');
        $activeCode = $request->query('activeCode');

        $user = AclUser::where([
            'username'    => $username,
            'active_code' => $activeCode
        ])->first();

        if (!$user) {
            return redirect()->route('login')->withErrors([
                'account' => 'Liên kết kích hoạt không hợp lệ hoặc đã được sử dụng.'
            ]);
        }

        $user->status = 1;
        $user->active_code = null; // reset code để tránh dùng lại
        $user->save();

        // cập nhật session để register-success hiển thị đúng
        session()->put('newUser', $user);

        return redirect()->route('auth.register.register-success');
    }

}