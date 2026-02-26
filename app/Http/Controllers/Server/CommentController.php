<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Services\CommentService;

class CommentController extends Controller
{
    protected $commentService;
    public function __construct(
        CommentService $commentService
    ) {
        $this->commentService = $commentService;
    }

    public function index()
    {
        $comment = $this->commentService->show('publish', 1);
        return view('server.pages.comment.index', compact('comments'));
    }

    public function delete($id)
    {
        $result = $this->commentService->delete($id);
        return redirect()->back()->with('success', 'Đã xóa bình luận thành công!');
    }
}
