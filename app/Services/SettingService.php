<?php

namespace App\Services;

use App\Repositories\SettingRepository;
use App\Services\BaseService;
use Illuminate\Http\Request;

class SettingService extends BaseService
{
    protected $repository;
    public function __construct(
        SettingRepository $repository
    ) {
        $this->repository = $repository;
    }
    protected function prepageModeldata(Request $request): self
    {
        return $this;
    }
}
