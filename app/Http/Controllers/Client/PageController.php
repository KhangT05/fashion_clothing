<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Post;

class PageController extends Controller
{
    private function getSettingPublish($field)
    {
        $setting = Setting::where('publish', 1)->value($field);
        return $setting;
    }
    //Thông tin bán hàng
    public function salesInfo()
    {
        return view(
            'client.pages.statics.sales-info',
            [
                'title' => 'Thông tin bán hàng',
                'content' => $this->getSettingPublish('sales_info') ?? '',
            ]
        );
    }
    // Dịch vụ bán hàng
    public function saleService()
    {
        return view(
            'client.pages.statics.sales-service',
            [
                'title' => 'Giới thiệu',
                'content' => $this->getSettingPublish('sales_services') ?? '',
            ]
        );
    }
    // Chính sách vận chuyển
    public function sippingPolicy()
    {
        return view(
            'client.pages.statics.sipping-policy',
            [
                'title' => 'Giới thiệu',
                'content' => $this->getSettingPublish('shipping_policy') ?? '',
            ]
        );
    }
    // Chính sách đổi trả
    public function returnPolicy()
    {
        return view(
            'client.pages.statics.return-policy',
            [
                'title' => 'Giới thiệu',
                'content' => $this->getSettingPublish('return_policy') ?? '',
            ]
        );
    }
    // Chính sách bảo hành
    public function warrantyPolicy()
    {
        return view(
            'client.pages.statics.warranty-policy',
            [
                'title' => 'Giới thiệu',
                'content' => $this->getSettingPublish('warranty_policy') ?? '',
            ]
        );
    }
    // Trang giới thiệu
    public function aboutUs()
    {
        return view(
            'client.pages.statics.about-us',
            [
                'title' => 'Giới thiệu',
                'content' => $this->getSettingPublish('about_us') ?? '',
            ]
        );
    }
    // Chính sách bảo mật thông tin
    public function privacyPolicy()
    {
        return view(
            'client.pages.statics.privacy-policy',
            [
                'title' => 'Giới thiệu',
                'content' => $this->getSettingPublish('privacy_policy') ?? '',
            ]
        );
    }

    // === REQ 22 & 23: BLOG + TÌM KIẾM + PHÂN TRANG ===
    public function blog(Request $request)
    {
        // Khởi tạo query lấy bài viết đang active
        $query = Post::where('is_active', true);

        // Xử lý tìm kiếm (Req 23)
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where('title', 'LIKE', "%{$keyword}%");
        }

        // Sắp xếp bài mới nhất và Phân trang (Req 23 - mỗi trang 6 bài)
        $posts = $query->orderBy('created_at', 'desc')->paginate(6);

        return view('client.pages.blog.index', compact('posts'));
    }

    // Xem chi tiết bài viết (Tùy chọn thêm)
    public function blogDetail($id)
    {
        $post = Post::find($id);
        if (!$post) return abort(404);
        return view('client.pages.blog.detail', compact('post'));
    }
}
