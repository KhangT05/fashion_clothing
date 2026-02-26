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

    function __construct( ContactService $ContactService){
        $this->ContactService = $ContactService;
    }

    public function index(Request $request): View
    {
        $filter = $request->only(['status', 'sort']);
        $filter['status'] ??= 1;
        $filter['sort'] ??= 'desc';
        $contacts = $this->ContactService->filterContact($filter);
        return view('server.pages.contacts.index', compact('contacts'));
    }

    public function update($id){
        $this->ContactService->updateContact($id);
        return redirect()->back()->with('success','Cập nhật thành công');
    }

    public function destroy($id){
        $this->ContactService->destroyContact($id);
        return redirect()->back()->with('success','Xóa thành công');
    }
}
