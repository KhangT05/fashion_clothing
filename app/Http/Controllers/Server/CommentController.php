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


        return view('server.pages.comment.index', compact('comments'));
    }

    public function delete($id)
    {

        return redirect()->back()->with('success', 'Đã xóa bình luận thành công!');
    }
}
