<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\ShopProductPost;
use App\Models\ShopProduct;
use App\Models\ShopProductPost as ModelsShopProductPost;
use Database\Seeders\ShopProductPostsSeeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ShopProductPostController extends Controller
{
    public function index(Request $request)
    {
        $dsShopProducts = ShopProduct::all();

        $query = ModelsShopProductPost::with('product');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                  ->orWhere('content', 'like', '%' . $keyword . '%')
                  ->orWhereHas('product', function ($sub) use ($keyword) {
                      $sub->where('product_name', 'like', '%' . $keyword . '%');
                  });
            });
        }

        $dsShopProducPosts = $query->paginate(10);

        return view('backend.product_posts.index', compact('dsShopProducts', 'dsShopProducPosts'));
    }

    /**
     * Hiển thị form tạo biến thể
     */
    public function create()
    {
        
    }

    /**
     * Lưu biến thể mới
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'          => 'required|string|max:255',
            'content'        => 'required|string|max:255',
            'image'          => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product_id'     => 'required|exists:shop_products,id',
        ],[
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.max'      => 'Tiêu đề không được vượt quá 255 ký tự.',
            'content.required'=> 'Nội dung là bắt buộc.',
            'content.max'    => 'Nội dung không được vượt quá 255 ký tự.',
            'image.required' => 'Hình ảnh là bắt buộc.',
            'image.image'    => 'Tệp phải là hình ảnh.',
            'image.mimes'    => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'image.max'      => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'product_id.required' => 'Sản phẩm áp dụng là bắt buộc.',
            'product_id.exists'   => 'Sản phẩm được chọn không tồn tại.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $productPost = new ModelsShopProductPost();
        $productPost->title = $request->input('title');
        $productPost->content = $request->input('content');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $newFileName = date('Ymd_His') . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/posts', $newFileName, 'public');
            $productPost->image = $newFileName;
        }
        $productPost->product_id = $request->input('product_id');
        $productPost->save();
        toastify()->success('Thêm bài đăng về sản phẩm thành công');
        return redirect()->route('backend.ProductPost.index');
    }

    /**
     * Hiển thị form chỉnh sửa biến thể
     */
    

    /**
     * Cập nhật biến thể
     */
    public function update(Request $request, $id)
    {
        $product = ModelsShopProductPost::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title'          => 'required|string|max:255',
            'content'        => 'required|string|max:255',
            'image'          => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product_id'     => 'required|exists:shop_products,id',
        ],[
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.max'      => 'Tiêu đề không được vượt quá 255 ký tự.',
            'content.required'=> 'Nội dung là bắt buộc.',
            'content.max'    => 'Nội dung không được vượt quá 255 ký tự.',
            'image.required' => 'Hình ảnh là bắt buộc.',
            'image.image'    => 'Tệp phải là hình ảnh.',
            'image.mimes'    => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'image.max'      => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'product_id.required' => 'Sản phẩm áp dụng là bắt buộc.',
            'product_id.exists'   => 'Sản phẩm được chọn không tồn tại.',
        ]);
        // cập nhật dữ liệu
        $product->title = $request->title;
        $product->content = $request->content;
        $product->product_id = $request->product_id;
        // Xử lý ảnh nếu có upload mới
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($product->image && Storage::disk('public')->exists('uploads/posts/' . $product->image)) {
                Storage::disk('public')->delete('uploads/posts/' . $product->image);
            }

            $file = $request->file('image');
            $newFileName = now()->format('Ymd_His') . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/posts/', $newFileName, 'public');
            $product->image = $newFileName;
        }

        $product->save();

        toastify()->success('Cập nhật bài đăng về sản phẩm thành công');
        return redirect()->route('backend.ProductPost.index');
    }

    /**
     * Xóa biến thể
     */
    public function destroy($id)
    {
        $product = ModelsShopProductPost::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại'], 404);
        }

        // Nếu có quan hệ cần xóa
        if (method_exists($product, 'exportDetails')) {
            $product->exportDetails()->delete();
        }

        // Xóa ảnh nếu tồn tại
        $filePath = 'uploads/posts/' . $product->image;
        if ($product->image && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $product->delete();

        return response()->json(['success' => true, 'message' => 'Xóa bài đăng về sản phẩm thành công']);
    }

}