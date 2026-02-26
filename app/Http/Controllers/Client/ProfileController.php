<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment; // Model đánh giá của bạn
use App\Models\User;
use App\Models\Province;
use App\Models\Ward;

class ProfileController extends Controller
{
    // Req 30: Hiển thị 6 thông tin cá nhân
    public function index()
    {
        $user = Auth::user();
        $provinces = Province::orderBy('name', 'ASC')->get();
        return view('client.pages.profile.index', compact('user', 'provinces'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        // Validate đơn giản
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric',
            // Thêm validate cho địa chỉ (nếu bắt buộc)
            'province_id' => 'nullable|integer',
            'ward_id'     => 'nullable|integer',
        ]);

        $user->update($request->only([
            'name',
            'phone',
            'birthday',
            'gender',
            'province_id',
            'ward_id'
        ]));
        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    // Req 33: Sản phẩm đã đánh giá
    public function reviews()
    {
        $reviews = Comment::where('user_id', Auth::id())
            ->with('sanpham') // Load sản phẩm để hiển thị tên/ảnh
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('client.pages.profile.reviews.index', compact('reviews'));
    }

    public function getWards($province_id)
    {
        // 1. Tìm Tỉnh dựa vào ID người dùng chọn
        $province = Province::find($province_id);

        if ($province) {
            // 2. Lấy danh sách Xã có cùng province_code với Tỉnh đó
            // (Dựa trên ảnh database bạn gửi: wards nối với provinces qua province_code)
            $wards = Ward::where('province_code', $province->province_code)
                ->orderBy('name', 'ASC')
                ->get();

            // 3. Trả về dữ liệu dạng JSON cho JavaScript đọc
            return response()->json($wards);
        }

        return response()->json([]);
    }
}
