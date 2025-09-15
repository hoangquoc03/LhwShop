<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ShopStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ShopStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ShopStore::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('store_code', 'like', '%' . $keyword . '%')
                ->orWhere('store_name', 'like', '%' . $keyword . '%');
            });
        }

        $dsShopStores = $query->paginate(5);

        return view('backend.shop_store.index', [
            'dsShopStores' => $dsShopStores
        ]);
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
            'store_code' => 'required|min:3|max:100',
            'store_name' => 'required|min:3|max:100',
            'description' => 'required|string|min:10',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ], [
            'store_code.required' => 'Mã Kho bắt buộc nhập.',
            'store_code.min' => 'Mã Kho phải từ 3 ký tự trở lên.',
            'store_code.max' => 'Mã Kho phải ít hơn 100 ký tự.',
            'store_name.required' => 'Văn bản Kho bắt buộc nhập.',
            'store_name.min' => 'Văn bản Kho phải từ 3 ký tự trở lên.',
            'store_name.max' => 'Văn bản Kho phải ít hơn 100 ký tự.',
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

        $post = new ShopStore();
        $post->store_code = $request->store_code;
        $post->store_name = $request->store_name;
        $post->description = $request->description;
        
        if ($request->hasFile('image')) {
            $path = $request->image;
            $newFileName = date('Ymd_His') . '_'.
            $path->getClientOriginalName();      
            $post->image = $newFileName;
            $path->storeAs('/uploads/stores/logo/', $newFileName,'public') ;
        }
        $post->save();

        toastify()->success('Thêm danh mục thành công');
        return redirect()->route('backend.ShopStore.index');
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
        $post = ShopStore::findOrFail($id);
        $post->store_code = $request->store_code;
        $post->store_name = $request->store_name;
        $post->description = $request->description;

        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists('/uploads/products/stores/logo/' . $post->image)) {
                Storage::disk('public')->delete('/uploads/stores/logo/' . $post->image);
            }

            $path = $request->file('image');
            $newFileName = date('Ymd_His') . '_' . $path->getClientOriginalName();
            $path->storeAs('/uploads/stores/logo/', $newFileName, 'public');
            $post->image = $newFileName;
        }

        $post->save();

        toastify()->success('Cập nhật kho thành công');
        return redirect()->route('backend.ShopStore.index');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $deletingModel = ShopStore::find($id);
        if($deletingModel != null){
            $filePath = '/uploads/stores/logo/'. $deletingModel->image;
            Storage::disk('public')->delete($filePath);
            $deletingModel->delete();
        }
        return redirect()->route('backend.ShopStore.index');
    }

    public function batchDelete(Request $request)
    {
        $listSelectedIds = $request->listSelectedIds;
        foreach($listSelectedIds as $id){
            $product = ShopStore::find($id);
            if ($product !== null) {
                $filePath = '/uploads/stores/logo/' . $product->image;
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                $product->delete();
            }
        }
        return response()->json([
            'status' =>'success',
            'message' => 'Xóa các hình ảnh thành công',
            'list_deleted_ids'=>$listSelectedIds
        ]);
    }
}