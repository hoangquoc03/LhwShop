@extends('auth/master')
@section('title')
Đăng kí
@endsection
@section('main-content')
<main class="bg-gray-50 dark:bg-gray-900">
      

    <div class="flex flex-col items-center justify-center px-6 pt-8 mx-auto md:h-screen pt:mt-0 dark:bg-gray-900" bis_skin_checked="1">
        <a href="/" class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
            <img src="https://flowbite-admin-dashboard.vercel.app/images/logo.svg" class="mr-4 h-11" alt="FlowBite Logo">
            <span>Rocket Pro</span>  
        </a>
        <!-- Card -->
        <div class="w-full max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800" bis_skin_checked="1">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Đăng ký
            </h2>
            <form action="{{ route('auth.register.register') }}" id="frmRegister" method="post" class="mt-8 space-y-6">
                @csrf
                
                <!-- Họ -->
                <div>
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Họ</label>
                    <input type="text" name="first_name" placeholder="Họ của bạn" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        id="first_name" value="{{ old('first_name') }}">
                    @error('first_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tên -->
                <div>
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên</label>
                    <input type="text" name="last_name" placeholder="Tên của bạn" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        id="last_name" value="{{ old('last_name') }}">
                    @error('last_name' )
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tên người dùng -->
                <div>
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên người dùng</label>
                    <input type="text" name="username" maxlength="150" autofocus="" placeholder="Tên người dùng" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        id="id_username" value="{{ old('username') }}">
                    @error('username' )
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror    
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Địa chỉ email</label>
                    <input type="email" name="email" maxlength="254" placeholder="Địa chỉ email" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        id="id_email" value="{{ old('email') }}">
                    @error('email' )
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror 
                </div>

                <!-- Mật khẩu -->
                <div>
                    <label for="password1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mật khẩu</label>
                    <input type="password" name="password1" autocomplete="new-password" placeholder="Mật khẩu" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        id="id_password1">
                    @error('password1')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Xác nhận mật khẩu -->
                <div>
                    <label for="password2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Xác nhận mật khẩu</label>
                    <input type="password" name="password2" autocomplete="new-password" placeholder="Xác nhận mật khẩu" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        id="id_password2">
                    @error('password2')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Giới tính -->
                <div>
                    <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Giới tính</label>
                    <select name="gender" id="gender" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="" disabled selected>Chọn giới tính</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                    @error('gender')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Điều khoản -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox"
                            class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="font-medium text-gray-900 dark:text-white">
                            Tôi chấp nhận <a href="#" class="text-primary-700 hover:underline dark:text-primary-500">Điều khoản và Điều kiện</a>
                        </label>
                    </div>
                </div>
                @error('terms')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <!-- Submit -->
                                
                {{-- <form action="{{ route('auth.register.register') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full px-5 py-3 text-base font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Tạo tài khoản
                    </button>
                </form> --}}
                <button type="submit"
                        class="w-full px-5 py-3 text-base font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Tạo tài khoản
                </button>

                <!-- Liên kết -->
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    <a href="{{ route('login') }}" class="text-primary-700 hover:underline dark:text-primary-500">Đăng nhập</a>
                    &nbsp; • &nbsp;
                    <a href="https://docs.appseed.us/products/rocket/django-pro/" target="_blank" class="text-primary-700 hover:underline dark:text-primary-500">Tài liệu</a>
                </div>
            </form>
        </div>
    </div>


</main>
@endsection

@section('custom.js')
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
                    maxlength:20
                },
                email:{
                    required:true,
                    minlength:3,
                    maxlength:50
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
                    maxlength: 'Tên người dùng không được vượt quá 20 ký tự.'
                },
                email: {
                    required: 'Vui lòng nhập email.',
                    minlength: 'Email phải có ít nhất 3 ký tự.',
                    maxlength: 'Email không được vượt quá 50 ký tự.'
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