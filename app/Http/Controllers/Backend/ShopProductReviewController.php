<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopProductReview;
use App\Models\ShopProduct;
use App\Models\ShopCustomer;
use Illuminate\Support\Facades\Validator;

class ShopProductReviewController extends Controller
{
    public function index(Request $request)
    {
        $dsShopProducts = ShopProduct::all();
        $dsShopCustomer = ShopCustomer::all();

        $query = ShopProductReview::with(['product', 'customer']); 

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->whereHas('product', function ($q2) use ($keyword) {
                    $q2->where('product_name', 'like', '%' . $keyword . '%');
                })
                ->orWhereHas('customer', function ($q3) use ($keyword) {
                    $q3->where('first_name', 'like', '%' . $keyword . '%')
                    ->orWhere('last_name', 'like', '%' . $keyword . '%');
                });
            });
        }

        $dsProductReview = $query->paginate(2);

        return view('backend.shop_product_review.index')
            ->with('dsShopProducts', $dsShopProducts)
            ->with('dsShopCustomer', $dsShopCustomer)
            ->with('dsProductReview', $dsProductReview);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating'      => 'required|numeric|min:1|max:5', // số sao đánh giá
            'comment'     => 'nullable|string|max:1000',     // bình luận
            'product_id'  => 'required|exists:shop_products,id',
            'customer_id' => 'required|exists:shop_customers,id',
        ], [
            'rating.required' => 'Vui lòng nhập đánh giá.',
            'rating.numeric'  => 'Đánh giá phải là số.',
            'rating.min'      => 'Đánh giá tối thiểu là 1 sao.',
            'rating.max'      => 'Đánh giá tối đa là 5 sao.',

            'comment.string'  => 'Bình luận không hợp lệ.',
            'comment.max'     => 'Bình luận không được vượt quá 1000 ký tự.',

            'product_id.required' => 'Vui lòng chọn sản phẩm.',
            'product_id.exists'   => 'Sản phẩm không tồn tại.',

            'customer_id.required' => 'Vui lòng chọn khách hàng.',
            'customer_id.exists'   => 'Khách hàng không tồn tại.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $review = new ShopProductReview();
        $review->rating      = $request->rating;
        $review->comment     = $request->comment;
        $review->product_id  = $request->product_id;
        $review->customer_id = $request->customer_id;
        $review->save();

        toastify()->success('Thêm đánh giá thành công');
        return redirect()->route('backend.ShopProductReview.index');
    }

    public function update(Request $request, string $id)
    {
        // Validate dữ liệu
        $request->validate([
            'rating'      => 'required|numeric|min:1|max:5',
            'comment'     => 'nullable|string|max:1000',
            'product_id'  => 'required|exists:shop_products,id',
            'customer_id' => 'required|exists:shop_customers,id',
        ], [
            'rating.required' => 'Vui lòng nhập đánh giá.',
            'rating.numeric'  => 'Đánh giá phải là số.',
            'rating.min'      => 'Đánh giá tối thiểu là 1 sao.',
            'rating.max'      => 'Đánh giá tối đa là 5 sao.',

            'comment.string'  => 'Bình luận không hợp lệ.',
            'comment.max'     => 'Bình luận không được vượt quá 1000 ký tự.',

            'product_id.required' => 'Vui lòng chọn sản phẩm.',
            'product_id.exists'   => 'Sản phẩm không tồn tại.',

            'customer_id.required' => 'Vui lòng chọn khách hàng.',
            'customer_id.exists'   => 'Khách hàng không tồn tại.',
        ]);

        // Lấy bản ghi
        $review = ShopProductReview::find($id);
        if (!$review) {
            toastify()->error('Không tìm thấy đánh giá cần cập nhật');
            return redirect()->route('backend.ShopProductReview.index');
        }

        // Cập nhật dữ liệu
        $review->rating      = $request->rating;
        $review->comment     = $request->comment;
        $review->product_id  = $request->product_id;
        $review->customer_id = $request->customer_id;
        $review->save();

        toastify()->success('Cập nhật đánh giá thành công');
        return redirect()->route('backend.ShopProductReview.index');
    }

    public function destroy(string $id)
    {
        $review = ShopProductReview::find($id);

        if (!$review) {
            toastify()->error('Không tìm thấy đánh giá để xóa');
            return redirect()->route('backend.ShopProductReview.index');
        }

        $review->delete();

        toastify()->success('Đã xóa đánh giá thành công');
        return redirect()->route('backend.ShopProductReview.index');
    }

    public function batchDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            toastify()->error('Vui lòng chọn ít nhất một đánh giá để xóa');
            return redirect()->route('backend.ShopProductReview.index');
        }

        ShopProductReview::whereIn('id', $ids)->delete();

        toastify()->success('Đã xóa các đánh giá được chọn');
        return redirect()->route('backend.ShopProductReview.index');
    }

}