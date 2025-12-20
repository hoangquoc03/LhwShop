<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\StoreCategoryIndexRequest;
use App\Http\Requests\ShopCategoryDestroyRequest;

class ShopCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StoreCategoryIndexRequest $request)
    {
        // Danh mục CHA + CON để hiển thị bảng
        $dsShopCategories = ShopCategory::all();
        return view('backend.shop_category.index', compact(
            'dsShopCategories'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categories_code' => 'required|min:3|max:100',
            'categories_text' => 'required|min:3|max:100',
            'description' => 'required|string|min:10',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'parent_id' => 'nullable|exists:shop_categories,id',
        ], [
            'categories_code.required' => 'Mã danh mục bắt buộc nhập.',
            'categories_code.min' => 'Mã danh mục phải từ 3 ký tự trở lên.',
            'categories_code.max' => 'Mã danh mục phải ít hơn 100 ký tự.',
            'categories_text.required' => 'Văn bản danh mục bắt buộc nhập.',
            'categories_text.min' => 'Văn bản danh mục phải từ 3 ký tự trở lên.',
            'categories_text.max' => 'Văn bản danh mục phải ít hơn 100 ký tự.',
            'description.required' => 'Mô tả bài viết bắt buộc nhập.',
            'description.min' => 'Mô tả phải ít nhất 10 ký tự.',
            'image.required' => 'Ảnh bài viết bắt buộc nhập.',
            'image.image' => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png hoặc gif.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $post = new ShopCategory();
        $post->categories_code = $request->categories_code;
        $post->categories_text = $request->categories_text;
        $post->description = $request->description;
        $post->parent_id = $request->parent_id;

        if ($request->hasFile('image')) {
            $path = $request->image;
            $newFileName = date('Ymd_His') . '_' .
                $path->getClientOriginalName();
            $post->image = $newFileName;
            $path->storeAs('/uploads/categories/logo', $newFileName, 'public');
        }
        $post->save();

        toastify()->success('Thêm danh mục thành công');
        return redirect()->route('backend.Category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $post = ShopCategory::findOrFail($id);
        $post->categories_code = $request->categories_code;
        $post->categories_text = $request->categories_text;
        $post->description = $request->description;
        if ($request->filled('image_url')) {
            $post->image = $request->image_url;
        }
        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists('uploads/categories/logo/' . $post->image)) {
                Storage::disk('public')->delete('uploads/categories/logo/' . $post->image);
            }

            $path = $request->file('image');
            $newFileName = date('Ymd_His') . '_' . $path->getClientOriginalName();
            $path->storeAs('uploads/categories/logo', $newFileName, 'public');
            $post->image = $newFileName;
        }

        $post->save();

        toastify()->success('Cập nhật danh mục thành công');
        return redirect()->route('backend.Category.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShopCategoryDestroyRequest $request, $id)
    {
        $deletingModel = ShopCategory::find($id);
        if ($deletingModel != null) {
            $filePath = 'uploads/categories/logo/' . $deletingModel->image;
            Storage::disk('public')->delete($filePath);
            $deletingModel->delete();
        }
        return redirect()->route('backend.Category.index');
    }
}
