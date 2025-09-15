<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopSupplier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\ShopSupplierDestroyRequest;
use App\Http\Requests\StoreSupplierIndexRequest;
class ShopSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StoreSupplierIndexRequest $request)
    {
        $dsShopSuppliers = ShopSupplier::all();
        return view('backend.shop_supplier.index')
        ->with('dsShopSuppliers',$dsShopSuppliers);
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
            'supplier_code' => 'required|min:3|max:100',
            'supplier_text' => 'required|min:3|max:100',
            'description' => 'required|string|min:10',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ], [
            'supplier_code.required' => 'Mã danh mục bắt buộc nhập.',
            'supplier_code.min' => 'Mã danh mục phải từ 3 ký tự trở lên.',
            'supplier_code.max' => 'Mã danh mục phải ít hơn 100 ký tự.',
            'supplier_text.required' => 'Văn bản danh mục bắt buộc nhập.',
            'supplier_text.min' => 'Văn bản danh mục phải từ 3 ký tự trở lên.',
            'supplier_text.max' => 'Văn bản danh mục phải ít hơn 100 ký tự.',
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

        $post = new ShopSupplier();
        $post->supplier_code = $request->supplier_code;
        $post->supplier_text = $request->supplier_text;
        $post->description = $request->description;
        
        if ($request->hasFile('image')) {
            $path = $request->image;
            $newFileName = date('Ymd_His') . '_'.
            $path->getClientOriginalName();      
            $post->image = $newFileName;
            $path->storeAs('/uploads/suppliers/logo', $newFileName,'public') ;
        }
        $post->save();

        toastify()->success('Thêm danh mục thành công');
        return redirect()->route('backend.Supplier.index');
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
        $post = ShopSupplier::findOrFail($id);
        $post->supplier_code = $request->supplier_code;
        $post->supplier_text = $request->supplier_text;
        $post->description = $request->description;

        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists('/uploads/suppliers/logo/' . $post->image)) {
                Storage::disk('public')->delete('/uploads/suppliers/logo/' . $post->image);
            }

            $path = $request->file('image');
            $newFileName = date('Ymd_His') . '_' . $path->getClientOriginalName();
            $path->storeAs('/uploads/suppliers/logo', $newFileName, 'public');
            $post->image = $newFileName;
        }

        $post->save();

        toastify()->success('Cập nhật danh mục thành công');
        return redirect()->route('backend.Supplier.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShopSupplierDestroyRequest $request, $id)
    {
        $deletingModel = ShopSupplier::find($id);
        if($deletingModel != null){
            $filePath = '/uploads/suppliers/logo/'. $deletingModel->image;
            Storage::disk('public')->delete($filePath);
            $deletingModel->delete();
        }
        return redirect()->route('backend.Supplier.index');
    }
}