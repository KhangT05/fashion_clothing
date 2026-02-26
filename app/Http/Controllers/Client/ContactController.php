<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Services\ContactService;
use App\Services\SettingService;
use Illuminate\Http\Request;
use App\Http\Requests\Client\Contact\StoreContactRequest;
class ContactController extends Controller
{
    protected $SettingService;
    protected $ContactService;
    public function __construct(SettingService $settingService, ContactService $contactService)
    {
        $this->SettingService = $settingService;
        $this->ContactService = $contactService;
        // throw new \Exception('Not implemented');
    }
    public function index(): View
    {
        $settings = $this->SettingService->index();
        return view('client.pages.contact.index', compact('settings'));
    }

    public function send(StoreContactRequest $request)
    {
        $this->ContactService->sendContact($request);
        return redirect()->route('contact')->with('success','Gửi tin nhắn thành công');
    }
}
