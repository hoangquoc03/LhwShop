<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
class StoreProductImgIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // if(!Auth::check()){
        //     return false;
        // }
        // if(!Gate::allows('shop_product_img::view')){
        //     abort(404);
        // }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // public function rules(): array
    // {
    //     return [
    //         'product_id'=>'required',
    //         'image'=>'required',
    //     ];
    // }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,string> 
//      */
//     public function messages(): array
//     {
//         // return [
//         //     'product_id.required'=>'Mã sản phẩm bắt buộc nhập',
//         //     'image.required'=>'Ảnh sản phẩm bắt buộc chọn',
//         // ];
//     }
}