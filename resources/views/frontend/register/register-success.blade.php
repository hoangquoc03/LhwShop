@extends('frontend.master')
@section('title')
Đăng ký thành công
@endsection

@section('page-style')
<section class="register_success_area section-margin py-5 bg-gray-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg rounded-lg border-0">
                    <div class="card-body text-center p-5">
                        

                        <!-- Tiêu đề -->
                        <h2 class="text-2xl font-bold text-gray-800 mb-3"> Đăng ký thành công!</h2>

                        <!-- Nội dung -->
                        <p class="text-gray-600 mb-2">
                            Xin chào <span class="font-semibold text-gray-900">{{ $newUser->first_name }} {{ $newUser->last_name }}</span>,
                        </p>
                        <p class="text-gray-600 mb-2">Tài khoản của bạn đã được tạo thành công.</p>
                        <p class="text-gray-600 mb-4">
                            Vui lòng kiểm tra email:
                            <span class="font-semibold text-blue-600">{{ $newUser->email }}</span>
                            và nhấn vào liên kết để kích hoạt tài khoản.
                        </p>

                        <!-- Nút mở Gmail -->
                        <a href="https://mail.google.com" target="_blank"
                           class="btn btn-primary px-4 py-2 rounded-lg shadow">
                            📧 Mở Gmail để kích hoạt
                        </a>

                        <!-- Quay lại trang chủ -->
                        <div class="mt-3">
                            @if($newUser->status == 1)
                                <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:text-gray-700">
                                    ← Quay lại trang chủ
                                </a>
                            @else
                                <span class="text-sm text-gray-400">
                                    ← Quay lại trang chủ (chỉ khi bạn đã kích hoạt)
                                </span>
                            @endif
                        </div>

                    </div>
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