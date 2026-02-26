<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\Server\User\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $users = $this->userService->pagination($request);
        return view('server.pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('server.pages.users.save', ['config' => 'create']);
    }

    public function store(StoreUserRequest $request)
    {
        if ($this->userService->save($request)) {
            return redirect()->route('users.index')->with('success', 'Thêm mới thành viên thành công');
        }
        return redirect()->route('users.index')->with('error', 'Có lỗi xảy ra, vui lòng thử lại');
    }

    public function edit($id)
    {
        $user = User::find($id);
        if (!$user) return redirect()->route('users.index')->with('error', 'Thành viên không tồn tại');

        return view('server.pages.users.save', ['user' => $user, 'config' => 'update']);
    }

    public function update(StoreUserRequest $request, $id)
    {
        if ($this->userService->save($request, $id)) {
            return redirect()->route('users.index')->with('success', 'Cập nhật thành viên thành công');
        }
        return redirect()->route('users.index')->with('error', 'Có lỗi xảy ra');
    }

    public function destroy($id)
    {
        if ($id == Auth::id()) {
            return redirect()->route('users.index')->with('error', 'Bạn không thể khóa tài khoản của chính mình!');
        }

        if ($id == 3) {
            return redirect()->route('users.index')->with('error', 'Không thể khóa tài khoản Super Admin!');
        }
        if ($this->userService->delete($id)) {
            return redirect()->route('users.index')
                ->with('success', 'Đã chuyển thành viên sang trạng thái ngừng hoạt động!');
        }
        return redirect()->route('users.index')->with('error', 'Có lỗi xảy ra, vui lòng thử lại');
    }

    public function restore($id)
    {
        if ($this->userService->restore($id)) {
            return redirect()->route('users.index')
                ->with('success', 'Đã mở khóa tài khoản thành công! Người dùng có thể đăng nhập lại.');
        }
        return redirect()->route('users.index')->with('error', 'Có lỗi xảy ra, vui lòng thử lại');
    }
}
