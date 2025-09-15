@extends('frontend.master')
@section('title')
Đăng nhập
@endsection

@section('page-style')
<section class="login_box_area section-margin">
    <div class="container">
        <div class="row">
            <!-- Phần giới thiệu -->
            <div class="col-lg-6">
                <div class="login_box_img">
                    <div class="hover">
                        <h4>Mới đến với website của chúng tôi?</h4>
                        <p>Hãy đăng ký tài khoản để trải nghiệm các tính năng tuyệt vời và cập nhật thông tin mới nhất.</p>
                        <a class="button button-account" href="{{ route('frontend.register.index') }}">Tạo tài khoản</a>
                    </div>
                </div>
            </div>

            <!-- Form đăng nhập -->
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>Đăng nhập để tiếp tục</h3>
                    <form class="row login_form" action="{{ route('frontend.login.post') }}" method="POST" id="loginForm">
                        @csrf
                        <!-- Username -->
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Tên đăng nhập" 
                                   onfocus="this.placeholder=''" onblur="this.placeholder='Tên đăng nhập'" required>
                            @error('username')
                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" 
                                   onfocus="this.placeholder=''" onblur="this.placeholder='Mật khẩu'" required>
                            @error('password')
                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Checkbox lưu đăng nhập -->
                        <div class="col-md-12 form-group">
                            <div class="creat_account">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">Ghi nhớ đăng nhập</label>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-md-12 form-group">
                            <button type="submit" class="button button-login w-100">Đăng nhập</button>
                            <a href="#" class="d-block mt-2">Quên mật khẩu?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection