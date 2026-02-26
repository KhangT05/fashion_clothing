<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Services\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $ContactService;

    function __construct(ContactService $ContactService)
    {
        $this->ContactService = $ContactService;
    }

    public function index(Request $request): View
    {
        return view('server.pages.contacts.index', compact('contacts'));
    }

    public function update(Request $request, $id)
    {
        $this->ContactService->save($request, $id);
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }
    public function destroy($id)
    {
        $this->ContactService->delete($id);
        return redirect()->back()->with('success', 'Xóa thành công');
    }
}
