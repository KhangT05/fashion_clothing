<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Services\ContactService;
use App\Http\Requests\Client\Contact\StoreContactRequest;
use App\Services\SettingService;

class ContactController extends Controller
{
    protected $contactService;
    protected $settingService;
    public function __construct(
        SettingService $settingService,
        ContactService $contactService
    ) {
        $this->contactService = $contactService;
        $this->settingService = $settingService;
    }
    public function index(): View
    {
        $settings = $this->settingService->show('publish', 1);
        return view('client.pages.contact.index', compact(
            'settings'
        ));
    }

    public function send(StoreContactRequest $request)
    {
        $this->contactService->save($request);
        return redirect()->route('contact')->with('success', 'Gửi tin nhắn thành công');
    }
}
