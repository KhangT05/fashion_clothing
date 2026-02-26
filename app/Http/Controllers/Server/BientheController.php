<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Http\Requests\Server\Attribute\StoreAttributeRequest;
use App\Http\Requests\Server\Attribute\UpdateAttributeRequest;
use App\Services\BienTheService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BientheController extends Controller
{
    protected $bientheService;
    public function __construct(
        BienTheService $bientheService
    ) {
        $this->bientheService = $bientheService;
    }
    public function index(Request $request): View
    {
        $attributes = $this->bientheService->pagination($request);
        return view('server.pages.attributes.index', compact(
            'attributes'
        ));
    }
    public function create(): View
    {
        return view('server.pages.Attributes.save');
    }
    public function store(StoreAttributeRequest $request)
    {
        $attributes = $this->bientheService->save($request);
        // dd($Attribute);
        // if($result['success']){

        // }
        return redirect()->route('attributes.index')->with('success', 'Tạo vai trò mới thành công');
    }
    public function show($id)
    {
        dd($id);
    }
    public function edit($id): View
    {
        $attributes = $this->bientheService->findById($id);
        return view('server.pages.attributes.update', compact(
            'attributes'
        ));
    }
    public function update(UpdateAttributeRequest $request, $id)
    {
        $this->bientheService->save($request, $id);
        return redirect()->route('attributes.index')->with('success', 'Cập nhật vai trò thành công');
    }
    public function delete($id)
    {
        $result = $this->bientheService->trash($id);
        return redirect()->route('attributes.index')->with('success', 'Xóa record thành công');
    }
    public function restore($id)
    {
        $result = $this->bientheService->delete($id);
        return redirect()->route('attributes.index')->with('success', 'Khôi phục record thành công');
    }
    public function trash($id)
    {
        $result = $this->bientheService->trash($id);
        return redirect()->route('attributes.index')->with('success', 'Xóa record thành công');
    }
}
