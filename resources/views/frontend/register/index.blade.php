@extends('frontend.master')
@section('title')
Đăng ký
@endsection

@section('page-style')
<section class="blog-banner-area" id="category">
    <div class="container h-100">
        <div class="blog-banner">
            <div class="text-center">
                <h1>Đăng ký tài khoản</h1>
                <nav aria-label="breadcrumb" class="banner-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.home.index') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Đăng ký</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="login_box_area section-margin">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login_box_img">
                    <div class="hover">
                        <h4>Đã có tài khoản?</h4>
                        <p>Đăng nhập ngay để trải nghiệm đầy đủ các tính năng của chúng tôi.</p>
                        <a class="button button-account" href="{{ route('frontend.login.index') }}">Đăng nhập</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login_form_inner register_form_inner">
                    <h3>Tạo tài khoản</h3>
                    <form id="frmRegister" class="row login_form" action="{{ route('frontend.register.register') }}" method="POST" id="register_form">
                        @csrf
                        <!-- Họ -->
                        <div class="col-md-6 form-group">
                            <input type="text" class="form-control" name="first_name" placeholder="Họ" value="{{ old('first_name') }}">
                            @error('first_name')
                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tên -->
                        <div class="col-md-6 form-group">
                            <input type="text" class="form-control" name="last_name" placeholder="Tên" value="{{ old('last_name') }}">
                            @error('last_name')
                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" name="username" placeholder="Tên đăng nhập" value="{{ old('username') }}">
                            @error('username')
                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-12 form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
                            @error('email')
                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 form-group">
                            <input type="password" class="form-control" name="password1" placeholder="Mật khẩu">
                            @error('password1')
                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6 form-group">
                            <input type="password" class="form-control" name="password2" placeholder="Xác nhận mật khẩu">
                            @error('password2')
                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Giới tính -->
                        <div class="col-md-12 form-group">
                            <select class="form-control" name="gender">
                                <option value="" disabled selected>Chọn giới tính</option>
                                <option value="0" {{ old('gender') == '0' ? 'selected' : '' }}>Nam</option>
                                <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>Nữ</option>
                                <option value="2" {{ old('gender') == '2' ? 'selected' : '' }}>Khác</option>
                            </select>
                            @error('gender')
                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Điều khoản -->
                        <div class="col-md-12 form-group">
                            <div class="creat_account">
                                <input type="checkbox" id="terms" name="terms" {{ old('terms') ? 'checked' : '' }}>
                                <label for="terms">Tôi đồng ý với <a href="#">Điều khoản và Điều kiện</a></label>
                            </div>
                            @error('terms')
                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="col-md-12 form-group">
                            <button type="submit" class="button button-register w-100">Đăng ký</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('user.js')
<script>
$(function(){
    $('#frmRegister').validate({
        rules:{
            first_name :{
                required:true,
                minlength:2,
                maxlength:20
            },
            last_name :{
                required:true,
                minlength:2,
                maxlength:20
            },
            username :{
                required:true,
                minlength:2,
                maxlength:20,
                remote: {
                    url: "{{ route('frontend.register.check-username') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}"
                    }
                }
            },
            email:{
                required:true,
                email:true,
                maxlength:50,
                remote: {
                    url: "{{ route('frontend.register.check-email') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}"
                    }
                }
            },
            terms: {
                required: true
            }
        },
        messages:{
            first_name: {
                required: 'Vui lòng nhập họ.',
                minlength: 'Họ phải có ít nhất 2 ký tự.',
                maxlength: 'Họ không được vượt quá 20 ký tự.'
            },
            last_name: {
                required: 'Vui lòng nhập tên.',
                minlength: 'Tên phải có ít nhất 2 ký tự.',
                maxlength: 'Tên không được vượt quá 20 ký tự.'
            },
            username: {
                required: 'Vui lòng nhập tên người dùng.',
                minlength: 'Tên người dùng phải có ít nhất 2 ký tự.',
                maxlength: 'Tên người dùng không được vượt quá 20 ký tự.',
                remote: 'Tên người dùng đã tồn tại.'
            },
            email: {
                required: 'Vui lòng nhập email.',
                email: 'Email không hợp lệ.',
                maxlength: 'Email không được vượt quá 50 ký tự.',
                remote: 'Email đã tồn tại.'
            },
            terms: {
                required: 'Bạn phải chấp nhận Điều khoản và Điều kiện.'
            }
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            error.addClass("text-red-600 text-sm mt-1 block"); 
            error.insertAfter(element);
        },
        highlight: function (element) {
            $(element).addClass("border-red-600 ring-red-600 ring-1"); 
        },
        unhighlight: function (element) {
            $(element).removeClass("border-red-600 ring-red-600 ring-1");
        }
    });
});

</script>
@endsection