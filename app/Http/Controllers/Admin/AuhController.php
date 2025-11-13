<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Services\Implements\AuthService;

class AuhController extends Controller
{
    protected $authService;
    public function __construct(
        AuthService $authService
    ) {
        $this->authService = $authService;
    }
    public function index()
    {
        return view();
    }
    public function login(AuthRequest $request)
    {
        $respone = $this->authService->authenticate($request);
        dd($respone);
    }
}
