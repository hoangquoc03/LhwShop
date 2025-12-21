<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopProduct;
use App\Models\ShopSupplier;
use App\Models\ShopProductImage;
use App\Http\Requests\ShopProductImgDestroyRequest;
use App\Http\Requests\StoreProductImgIndexRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ShopProductImgController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dsShopProducts = ShopProduct::all();
        $dsShopSupplier = ShopSupplier::all();

        $query = ShopProductImage::with('product'); // load quan hệ product (nếu có)

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->whereHas('product', function ($q) use ($keyword) {
                $q->where('product_name', 'like', '%' . $keyword . '%');
            });
        }

        $dsProductImg = $query->paginate(100);

        return view('backend.product_img.index')
            ->with('dsShopProducts', $dsShopProducts)
            ->with('dsShopSupplier', $dsShopSupplier)
            ->with('dsProductImg', $dsProductImg);
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
    public function store(StoreProductImgIndexRequest $request)
    {

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/products/img', $filename, 'public');

                ShopProductImage::create([
                    'product_id' => $request->product_id,
                    'image' => $filename,
                ]);
            }
        }
        toastify()->success('Thêm hình ảnh sản phẩm thành công');
        return redirect()->route('backend.ProductImg.index')
            ->with('success', 'Cập nhật ảnh thành công');
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
        $product = ShopProductImage::findOrFail($id);

        // Nếu cho phép thay đổi product_id thì giữ lại dòng dưới, còn không thì bỏ đi
        $product->product_id = $request->product_id;

        // Nếu có file mới thì xử lý
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists('uploads/products/img/' . $product->image)) {
                Storage::disk('public')->delete('uploads/products/img/' . $product->image);
            }

            $file = $request->file('image');
            $newFileName = now()->format('Ymd_His') . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/products/img', $newFileName, 'public');
            $product->image = $newFileName;
        }

        $product->save();
        toastify()->success('Cập nhập thành công');
        return redirect()->route('backend.ProductImg.index')
            ->with('success', 'Cập nhật ảnh thành công');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = ShopProductImage::find($id);
        if ($product !== null) {
            $filePath = 'uploads/products/img/' . $product->image;
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $product->delete();
        }
        return redirect()->route('backend.ProductImg.index');
    }

    public function batchDelete(Request $request)
    {
        $listSelectedIds = $request->listSelectedIds;
        foreach ($listSelectedIds as $id) {
            $product = ShopProductImage::find($id);
            if ($product !== null) {
                $filePath = 'uploads/products/img/' . $product->image;
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                $product->delete();
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Xóa các hình ảnh thành công',
            'list_deleted_ids' => $listSelectedIds
        ]);
    }
}
