<?php

namespace App\Services\Interface;

use App\Http\Requests\AuthRequest;

interface AuthServiceInterface
{
    public function authenticate(AuthRequest $request);
}
