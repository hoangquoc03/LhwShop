<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopPaymentType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class ShopPaymentTypeController extends Controller
{
    public function index(){
        $dsShopPaymentType = ShopPaymentType::all();
        return view('backend.shop_payment_type.index')
        ->with('dsShopPaymentType',$dsShopPaymentType);
    }
    
    public function destroy($id){
        $deletingModel = ShopPaymentType::find($id);
        if($deletingModel != null){
            $filePath = '/uploads/payments/logo/'. $deletingModel->image;
            Storage::disk('public')->delete($filePath);
            $deletingModel->delete();
        }
        return redirect(route('backend.ShopPaymentType.index'));
    }
    
    public function store(Request $request){
        // kiểm tra tính hợp lệ của dữ liệu gửi đến

        $validator = Validator::make($request->all(),[
            'payment_code' =>'required|min:3|max:50',
            'payment_name' =>'required|min:3|max:50',
            'description' =>'required|min:3|max:50',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ],[
            'payment_code.required' =>'Tên nhóm bắt buộc nhập.',
            'payment_code.min' =>'Tên nhóm phải từ 3 ký tự trở lên.',
            'payment_code.max' =>'Tên nhóm phải ít hơn 50 ký tự.',
            'payment_name.required' =>'Tên khóa bắt buộc nhập.',
            'payment_name.min' =>'Tên khóa phải từ 3 ký tự trở lên.',
            'payment_name.max' =>'Tên khóa phải ít hơn 50 ký tự.',
            'description.required' =>'Tên giá trị bắt buộc nhập.',
            'description.min' =>'Tên giá trị phải từ 3 ký tự trở lên.',
            'description.max' =>'Tên giá trị phải ít hơn 50 ký tự.',
            'image.required' => 'Ảnh bài viết bắt buộc nhập.',
            'image.image' => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png hoặc gif.',
        ]);
        if($validator->fails()){
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }

        $newModel = new ShopPaymentType();
        $newModel->payment_code = $request->payment_code;
        $newModel->payment_name = $request->payment_name;
        $newModel->description = $request->description;

        if ($request->hasFile('image')) {
            $path = $request->image;
            $newFileName = date('Ymd_His') . '_'.
            $path->getClientOriginalName();      
            $newModel->image = $newFileName;
            $path->storeAs('/uploads/payments/logo/', $newFileName,'public') ;
        }
        $newModel->save();
        toastify()->success('Thêm thành công');
        return redirect(route('backend.ShopPaymentType.index'));
    }
    
    public function update($id,Request $request){
        $editModel = ShopPaymentType::find($id);
        $editModel->payment_code = $request->payment_code;
        $editModel->payment_name = $request->payment_name;
        $editModel->description = $request->description;
        if ($request->hasFile('image')) {
            if ($editModel->image && Storage::disk('public')->exists('/uploads/suppliers/logo/' . $editModel->image)) {
                Storage::disk('public')->delete('/uploads/payments/logo/' . $editModel->image);
            }

            $path = $request->file('image');
            $newFileName = date('Ymd_His') . '_' . $path->getClientOriginalName();
            $path->storeAs('/uploads/payments/logo', $newFileName, 'public');
            $editModel->image = $newFileName;
        }
        $editModel->save();
        toastify()->success('Cập nhật thành công');
        return redirect(route('backend.ShopPaymentType.index'));
    }
}