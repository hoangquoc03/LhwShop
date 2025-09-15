<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
class StoreProductIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // if(!Auth::check()){
        //     return false;
        // }
        // if(!Gate::allows('shop_product::view')){
        //     abort(403);
        // }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'product_name'        => 'required|min:3|max:100',
            // 'standard_cost'       => 'required|min:3|max:17',
            // 'list_price'          => 'required|min:3|max:17',
            // 'quantity_per_unit'   => 'required|min:1|max:17',
            // 'discontinued'        => 'required|boolean',
            // 'is_featured'         => 'required|boolean',
            // 'is_new'              => 'required|boolean',
            // 'short_description'   => 'required|string|min:10',
            // 'image'               => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            // 'category_id'         => 'required|exists:shop_categories,id',
            // 'supplier_id'         => 'required|exists:shop_suppliers,id',
        ];
    }
    // public function messages(): array
    // {
    //     return [
    //         'product_name.required'      => 'Tên sản phẩm là bắt buộc.',
    //         'product_name.min'           => 'Tên sản phẩm phải từ 3 ký tự trở lên.',
    //         'product_name.max'           => 'Tên sản phẩm không được vượt quá 100 ký tự.',

    //         'standard_cost.required'     => 'Giá tiêu chuẩn là bắt buộc.',
    //         'standard_cost.min'          => 'Giá tiêu chuẩn phải từ 3 ký tự trở lên.',
    //         'standard_cost.max'          => 'Giá tiêu chuẩn không được vượt quá 17 ký tự.',

    //         'list_price.required'        => 'Giá bán là bắt buộc.',
    //         'list_price.min'             => 'Giá bán phải từ 3 ký tự trở lên.',
    //         'list_price.max'             => 'Giá bán không được vượt quá 17 ký tự.',

    //         'quantity_per_unit.required' => 'Số lượng mỗi đơn vị là bắt buộc.',
    //         'quantity_per_unit.min'      => 'Số lượng phải ít nhất 1 ký tự.',
    //         'quantity_per_unit.max'      => 'Số lượng không được vượt quá 17 ký tự.',

    //         'discontinued.required'      => 'Trạng thái ngừng kinh doanh là bắt buộc.',
    //         'discontinued.boolean'       => 'Giá trị ngừng kinh doanh không hợp lệ.',

    //         'is_featured.required'       => 'Trường sản phẩm nổi bật là bắt buộc.',
    //         'is_featured.boolean'        => 'Giá trị sản phẩm nổi bật không hợp lệ.',

    //         'is_new.required'            => 'Trường sản phẩm mới là bắt buộc.',
    //         'is_new.boolean'             => 'Giá trị sản phẩm mới không hợp lệ.',

    //         'short_description.required' => 'Mô tả ngắn là bắt buộc.',
    //         'short_description.min'      => 'Mô tả ngắn phải ít nhất 10 ký tự.',

    //         'image.required'             => 'Ảnh sản phẩm là bắt buộc.',
    //         'image.image'                => 'Tệp tải lên phải là hình ảnh.',
    //         'image.mimes'                => 'Ảnh phải có định dạng: jpg, jpeg, png hoặc gif.',
    //         'image.max'                  => 'Kích thước ảnh tối đa là 2MB.',
    //         'category_id.required'     => 'Danh mục là bắt buộc.',
    //         'category_id.exists'       => 'Danh mục không tồn tại.',

    //         'supplier_id.required'     => 'Nhà cung cấp là bắt buộc.',
    //         'supplier_id.exists'       => 'Nhà cung cấp không tồn tại.',
    //     ];
    // }
}