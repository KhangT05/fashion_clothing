<?php

namespace App\Http\Controllers\Server;
use App\Models\Binhluan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commentService;

    
    public function index()
{
    // Lấy bình luận kèm thông tin sản phẩm và người dùng (Eager Loading)
    $comments = Binhluan::with(['product', 'user'])
                ->orderBy('created_at', 'desc')
                ->paginate(10); // Phân trang 10 mục/trang

    return view('server.pages.comment.index', compact('comments'));
}

public function delete($id)
    {
        try {
            $comment = Binhluan::findOrFail($id);
            $comment->delete();

            return redirect()->back()->with('success', 'Đã xóa bình luận thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }
}
