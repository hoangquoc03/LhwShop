<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ShopStore;
use App\Models\ShopCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class ShopCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ShopCustomer::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', '%' . $keyword . '%')
                ->orWhere('username', 'like', '%' . $keyword . '%');
            });
        }

        $dsShopCustomers = $query->paginate(5);

        return view('backend.shop_customer.index', [
            'dsShopCustomers' => $dsShopCustomers
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
        // Validate dữ liệu nhập vào cho khách hàng
        $validator = Validator::make($request->all(), [
            'username'    => 'required|string|min:3|max:100|unique:shop_customers,username',
            'last_name'   => 'required|string|min:1|max:100',
            'first_name'  => 'required|string|min:1|max:100',
            'gender'      => 'required|integer|in:0,1', // 0 = Nữ, 1 = Nam
            'email'       => 'required|email|unique:shop_customers,email',
            'phone'       => 'required|string|max:20|unique:shop_customers,phone',
            'avatar'      => 'nullable|image|max:2048',
            'status'      => 'required|integer|in:0,1'
        ], [
            'username.required' => 'Tên đăng nhập là bắt buộc.',
            'username.unique'   => 'Tên đăng nhập đã tồn tại.',
            'last_name.required' => 'Họ là bắt buộc.',
            'first_name.required'=> 'Tên là bắt buộc.',
            'gender.required'    => 'Giới tính là bắt buộc.',
            'gender.in'          => 'Giới tính không hợp lệ.',
            'email.required'     => 'Email là bắt buộc.',
            'email.email'        => 'Email không hợp lệ.',
            'email.unique'       => 'Email đã tồn tại.',
            'phone.required'     => 'Số điện thoại là bắt buộc.',
            'phone.unique'       => 'Số điện thoại đã tồn tại.',
            'avatar.image'       => 'Ảnh đại diện phải là file ảnh.',
            'avatar.max'         => 'Ảnh đại diện không được vượt quá 2MB.',
            'status.required'    => 'Trạng thái là bắt buộc.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Tạo khách hàng mới
        $customer = new ShopCustomer();
        $customer->username   = $request->username;
        $customer->last_name  = $request->last_name;
        $customer->first_name = $request->first_name;
        $customer->gender     = $request->gender;
        $customer->email      = $request->email;
        $customer->phone      = $request->phone;
        $customer->status     = $request->status;

        // Xử lý avatar
        if ($request->hasFile('avatar')) {
            $fileName = time() . '_' . $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->storeAs('uploads/customers/avatar/', $fileName, 'public');
            $customer->avatar = 'uploads/customers/avatar/' . $fileName;
        } else {
            // Nếu không upload avatar → gán mặc định
            $customer->avatar = 'uploads/users/avatar/avatar-default-nam.jpg';
        }

        $customer->save();

        toastify()->success('Thêm khách hàng thành công');
        return redirect()->route('backend.ShopCustomer.index');
    }



    /**
     * Display the specified resource.
     */
    public function show(ShopStore $shopStore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShopStore $shopStore)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = ShopCustomer::findOrFail($id);

        // Validate dữ liệu
        $validator = Validator::make($request->all(), [
            'username'    => 'required|string|min:3|max:100|unique:shop_customers,username,' . $customer->id,
            'last_name'   => 'required|string|min:1|max:100',
            'first_name'  => 'required|string|min:1|max:100',
            'gender'      => 'required|integer|in:0,1',
            'email'       => 'required|email|unique:shop_customers,email,' . $customer->id,
            'phone'       => 'required|string|max:20|unique:shop_customers,phone,' . $customer->id,
            'avatar'      => 'nullable|image|max:2048',
            'status'      => 'nullable|integer|in:0,1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cập nhật dữ liệu
        $customer->username   = $request->username;
        $customer->last_name  = $request->last_name;
        $customer->first_name = $request->first_name;
        $customer->gender     = $request->gender;
        $customer->email      = $request->email;
        $customer->phone      = $request->phone;
        $customer->status     = $request->status ?? $customer->status;

        // Xử lý avatar
        if ($request->hasFile('avatar')) {
            $fileName = time() . '_' . $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->storeAs('uploads/customers/avatar/', $fileName, 'public');
            $customer->avatar = 'uploads/customers/avatar/' . $fileName;
        } elseif (!$customer->avatar) {
            // Nếu chưa từng có avatar thì gán ảnh mặc định
            $customer->avatar = 'uploads/users/avatar/avatar-default-nam.jpg';
        }

        $customer->save();

        toastify()->success('Cập nhật khách hàng thành công');
        return redirect()->route('backend.ShopCustomer.index');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $customer = ShopCustomer::find($id);

        if ($customer) {
            // Xóa avatar nếu tồn tại và không phải ảnh mặc định
            if ($customer->avatar && $customer->avatar !== 'uploads/users/avatar/avatar-default-nam.jpg') {
                if (Storage::disk('public')->exists($customer->avatar)) {
                    Storage::disk('public')->delete($customer->avatar);
                }
            }

            // Xóa khách hàng
            $customer->delete();
        }

        return redirect()->route('backend.ShopCustomer.index');
    }

    public function batchDelete(Request $request)
    {
        $listSelectedIds = $request->listSelectedIds ?? [];

        foreach ($listSelectedIds as $id) {
            $customer = ShopCustomer::find($id);

            if ($customer) {
                // Xóa avatar nếu tồn tại và không phải ảnh mặc định
                if ($customer->avatar && $customer->avatar !== 'uploads/users/avatar/avatar-default-nam.jpg') {
                    if (Storage::disk('public')->exists($customer->avatar)) {
                        Storage::disk('public')->delete($customer->avatar);
                    }
                }

                $customer->delete();
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Xóa khách hàng thành công',
            'list_deleted_ids' => $listSelectedIds
        ]);
    }
}