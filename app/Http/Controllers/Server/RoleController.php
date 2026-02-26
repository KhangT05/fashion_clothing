<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Http\Requests\Server\Role\StoreRoleRequest;
use App\Http\Requests\Server\Role\UpdateRoleRequest;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    protected $roleService;
    public function __construct(
        RoleService $roleService
    ) {
        $this->roleService = $roleService;
    }
    public function index(Request $request): View
    {
        $roles = $this->roleService->pagination($request);
        return view('server.pages.roles.index', compact(
            'roles'
        ));
    }
    public function create(): View
    {
        return view('server.pages.roles.save');
    }
    public function store(StoreRoleRequest $request)
    {
        $role = $this->roleService->save($request);
        // dd($role);
        // if($result['success']){

        // }
        return redirect()->route('roles.index')->with('success', 'Tạo vai trò mới thành công');
    }
    public function show($id)
    {
        dd($id);
    }
    public function edit($id): View
    {
        $roles = $this->roleService->findById($id);
        return view('server.pages.roles.update', compact(
            'roles'
        ));
    }
    public function update(UpdateRoleRequest $request, $id)
    {
        $this->roleService->save($request, $id);
        return redirect()->route('roles.index')->with('success', 'Cập nhật vai trò thành công');
    }
    public function delete($id)
    {
        $result = $this->roleService->trash($id);
        return redirect()->route('roles.index')->with('success', 'Xóa record thành công');
    }
    public function restore($id)
    {
        $result = $this->roleService->delete($id);
        return redirect()->route('roles.index')->with('success', 'Khôi phục record thành công');
    }
    public function trash($id)
    {
        $result = $this->roleService->trash($id);
        return redirect()->route('roles.index')->with('success', 'Xóa record thành công');
    }
}
