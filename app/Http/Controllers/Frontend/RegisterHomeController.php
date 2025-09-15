<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopCustomer;
use Ramsey\Uuid\Uuid;
use App\Mail\ActivateUserMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isNull;
use Illuminate\Support\Facades\Hash;
use App\Models\ShopCategory;

class RegisterHomeController extends Controller
{
    public function index()
    {
        $categories = ShopCategory::all();
        return view('frontend.register.index', compact('categories'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:2|max:20',
            'last_name'  => 'required|string|min:2|max:20',
            'username'   => 'required|string|min:2|max:20|unique:shop_customers,username',
            'email'      => 'required|email|max:50|unique:shop_customers,email',
            'password1'  => 'required|string|min:6|same:password2',
            'password2'  => 'required|string|min:6',
            'gender'     => 'required|in:0,1,2',
            'terms'      => 'accepted'
        ], [
            'first_name.required' => 'Họ không được bỏ trống.',
            'first_name.min'      => 'Họ phải có ít nhất 2 ký tự.',
            'first_name.max'      => 'Họ không được vượt quá 20 ký tự.',

            'last_name.required'  => 'Tên không được bỏ trống.',
            'last_name.min'       => 'Tên phải có ít nhất 2 ký tự.',
            'last_name.max'       => 'Tên không được vượt quá 20 ký tự.',

            'username.required'   => 'Tên đăng nhập không được bỏ trống.',
            'username.min'        => 'Tên đăng nhập phải có ít nhất 2 ký tự.',
            'username.max'        => 'Tên đăng nhập không được vượt quá 20 ký tự.',
            'username.unique'     => 'Tên đăng nhập đã tồn tại.',

            'email.required'      => 'Email không được bỏ trống.',
            'email.email'         => 'Email không hợp lệ.',
            'email.max'           => 'Email không được vượt quá 50 ký tự.',
            'email.unique'        => 'Email đã tồn tại.',

            'password1.required'  => 'Mật khẩu không được bỏ trống.',
            'password1.min'       => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password1.same'      => 'Mật khẩu xác nhận không khớp.',

            'password2.required'  => 'Xác nhận mật khẩu không được bỏ trống.',
            'password2.min'       => 'Xác nhận mật khẩu phải có ít nhất 6 ký tự.',

            'gender.required'     => 'Bạn phải chọn giới tính.',
            'gender.in'           => 'Giới tính không hợp lệ.',

            'terms.accepted'      => 'Bạn phải chấp nhận Điều khoản và Điều kiện.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Chuyển giới tính sang số để lưu DB
        $gender = match($request->gender) {
            '0' => 0,
            '1' => 1,
            default => 2,
        };

        // Lưu vào bảng shop_customers
        $newUser = ShopCustomer::create([
            'username'    => $request->username,
            'password'    => $request->password1, // hash mật khẩu
            'last_name'   => $request->last_name,
            'first_name'  => $request->first_name,
            'gender'      => $gender,
            'email'       => $request->email,
            'activate_code' => (string) Uuid::uuid4(),
            'status'      => 0,
            'created_at'  => now(),
        ]);

        // Gửi mail kích hoạt
        Mail::to($newUser->email)->send(new ActivateUserMail($newUser));

        // Chuyển tới trang thông báo đăng ký thành công
        return redirect()
            ->route('frontend.register.register-success')
            ->with('newUser', $newUser);
    }

    // Trang thông báo đăng ký thành công
    public function registerSuccess()
    {
        $sessionUser = session('newUser');

        if (!$sessionUser) {
            return redirect()->route('frontend.register.index')
                            ->withErrors('Không tìm thấy thông tin người dùng.');
        }

        // Lấy user mới nhất từ DB theo id
        $newUser = ShopCustomer::find($sessionUser->id);

        return view('frontend.register.register-success', compact('newUser'));
    }


    // Kích hoạt tài khoản qua link email
    public function activeUser(Request $request)
    {
        $token = $request->query('token');

        $user = ShopCustomer::where('activate_code', $token)->first();

        if (!$user) {
            return redirect()->route('frontend.login.index')->withErrors([
                'account' => 'Liên kết kích hoạt không hợp lệ hoặc đã được sử dụng.'
            ]);
        }

        $user->status = 1;
        $user->activate_code = null; // reset code để tránh dùng lại
        $user->save();

        session()->put('newUser', $user);

        return redirect()->route('frontend.register.register-success');
    }


    public function checkUsername(Request $request){
        $exists = ShopCustomer::where('username', $request->username)->exists();
        return response()->json(!$exists); // true nếu hợp lệ, false nếu đã tồn tại
    }

    public function checkEmail(Request $request){
        $exists = ShopCustomer::where('email', $request->email)->exists();
        return response()->json(!$exists); // true nếu hợp lệ, false nếu đã tồn tại
    }

}