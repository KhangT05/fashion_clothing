<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Services\ContactService;
use App\Http\Requests\Client\Contact\StoreContactRequest;

class ContactController extends Controller
{
    protected $contactService;
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
        // throw new \Exception('Not implemented');
    }
    public function index(): View
    {
        return view('client.pages.contact.index');
    }

    public function send(StoreContactRequest $request)
    {
        $this->contactService->save($request);
        return redirect()->route('contact')->with('success', 'Gửi tin nhắn thành công');
    }
}
