<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ShopPost;
use App\Models\AclUser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ShopPostController extends Controller
{
    public function __construct()
    {
        
    }
    public function index()
    {
        // if (!Auth::check()) {
        //     return redirect(route('auth.login.index'));
        // }

        // if(!Gate::allows('shop_posts::view')){
        //     abort(403);
        // }

        // Nếu có quyền thì load dữ liệu
        $lstPost = \App\Models\ShopPost::all();
        $lstUser = \App\Models\AclUser::all();
        $categories = \App\Models\ShopPostCategory::all();

        return view('backend.post.index', [
            'lstPost' => $lstPost,
            'categories' => $categories,
            'lstUser' => $lstUser,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_title' => 'required|min:3|max:100',
            'post_slug' => 'required|min:3|max:100',
            'post_content' => 'required|string|min:10',
            'post_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'post_category_id' => 'required|exists:shop_post_categories,id',
            'post_type' => 'required',
            'post_status' => 'required',
        ], [
            'post_title.required' => 'Tiêu đề bắt buộc nhập.',
            'post_title.min' => 'Tiêu đề phải từ 3 ký tự trở lên.',
            'post_title.max' => 'Tiêu đề phải ít hơn 100 ký tự.',
            'post_slug.required' => 'Slug bắt buộc nhập.',
            'post_slug.min' => 'Slug phải từ 3 ký tự trở lên.',
            'post_slug.max' => 'Slug phải ít hơn 100 ký tự.',
            'post_content.required' => 'Nội dung bài viết bắt buộc nhập.',
            'post_content.min' => 'Nội dung phải ít nhất 10 ký tự.',
            'post_image.required' => 'Ảnh bài viết bắt buộc nhập.',
            'post_image.image' => 'Tệp tải lên phải là hình ảnh.',
            'post_image.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png hoặc gif.',
            'post_image.max' => 'Ảnh không được vượt quá 2MB.',
            'post_type.required' => 'Vui lòng chọn loại bài viết.',
            'post_status.required' => 'Vui lòng chọn trạng thái.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $post = new ShopPost();
        $post->post_title = $request->post_title;
        $post->post_content = $request->post_content;
        $post->post_slug = $request->post_slug;
        $post->post_category_id = $request->post_category_id;
        
        
        if ($request->hasFile('post_image')) {
            $file = $request->file('post_image');
            $newFileName = date('Ymd_His') . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/posts/images', $newFileName, 'public');
            $post->post_image = $newFileName;
        }
        $post->post_type = $request->post_type;
        $post->post_status = $request->post_status;
        $post->user_id = $request->user_id;
        $post->save();

        toastify()->success('Thêm bài viết thành công');
        return redirect()->route('backend.post.index');
    }

    public function update($id, Request $request)
    {
        $post = ShopPost::findOrFail($id);
        $post->post_title = $request->post_title;
        $post->post_content = $request->post_content;
        $post->post_slug = $request->post_slug;
        $post->post_category_id = $request->post_category_id;
        
        
        if ($request->hasFile('post_image')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($post->post_image && Storage::disk('public')->exists('uploads/posts/images/' . $post->post_image)) {
                Storage::disk('public')->delete('uploads/posts/images/' . $post->post_image);
            }

            $file = $request->file('post_image');
            $newFileName = now()->format('Ymd_His') . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/posts/images', $newFileName, 'public');
            $post->post_image = $newFileName;
        }
        $post->post_type = $request->post_type;
        $post->post_status = $request->post_status;
        $post->user_id = $request->user_id;
        $post->save();

        toastify()->success('Cập nhật bài viết thành công');
        return redirect()->route('backend.post.index');
    }

    public function destroy($id)
    {
        $product = ShopPost::find($id);

        if (!$product) {
            return redirect()->route('backend.post.index')->with('error', 'Sản phẩm không tồn tại');
        }

        // Xóa các bản ghi liên quan (nếu có)
        $product->exportDetails()->delete();

        // Xóa ảnh nếu tồn tại
        $filePath = 'uploads/posts/images/' . $product->post_image;
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        // Xóa sản phẩm
        $product->delete();

        return redirect()->route('backend.post.index')->with('success', 'Xóa sản phẩm thành công');
    }
}