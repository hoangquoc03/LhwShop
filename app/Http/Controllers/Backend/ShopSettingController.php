<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopSetting;
use Illuminate\Support\Facades\Validator;
class ShopSettingController extends Controller
{
    public function index(){
        if(!Gate::allows('shop_posts::view')){
            return response()->view('errors.404', [], 404);
        }
        $dsShopSetting = ShopSetting::all();
        return view('backend/shop_setting/index')
        ->with('dsShopSetting',$dsShopSetting);
    }
    
    public function destroy($id){
        ShopSetting::destroy($id);
        toastify()->success('Đã xóa thành công');
        return redirect(route('backend.shop_setting.index'));
    }
    
    public function store(Request $request){
        // kiểm tra tính hợp lệ của dữ liệu gửi đến

        $validator = Validator::make($request->all(),[
            'group' =>'required|min:3|max:50',
            'key' =>'required|min:3|max:50',
            'value' =>'required|min:3|max:50',
        ],[
            'group.required' =>'Tên nhóm bắt buộc nhập.',
            'group.min' =>'Tên nhóm phải từ 3 ký tự trở lên.',
            'group.max' =>'Tên nhóm phải ít hơn 50 ký tự.',
            'key.required' =>'Tên khóa bắt buộc nhập.',
            'key.min' =>'Tên khóa phải từ 3 ký tự trở lên.',
            'key.max' =>'Tên khóa phải ít hơn 50 ký tự.',
            'value.required' =>'Tên giá trị bắt buộc nhập.',
            'value.min' =>'Tên giá trị phải từ 3 ký tự trở lên.',
            'value.max' =>'Tên giá trị phải ít hơn 50 ký tự.',
        ]);
        if($validator->fails()){
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }

        $newModel = new ShopSetting();
        $newModel->group = $request->group;
        $newModel->key = $request->key;
        $newModel->value = $request->value;
        $newModel->description = $request->description;
        $newModel->save();
        toastify()->success('Thêm thành công');
        return redirect(route('backend.shop_setting.index'));
    }
    
    public function update($id,Request $request){
        $editModel = ShopSetting::find($id);
        $editModel->group = $request->group;
        $editModel->key = $request->key;
        $editModel->value = $request->value;
        $editModel->description = $request->description;
        $editModel->save();
        toastify()->success('Cập nhật thành công');
        return redirect(route('backend.shop_setting.index'));
    }
}