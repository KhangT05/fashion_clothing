<?php

namespace App\Services;

use App\Models\BienThe;
use App\Repositories\BienTheRepository;
use App\Services\BaseService;
use Illuminate\Http\Request;

class BienTheService extends BaseService
{
    protected $repository;

    public function __construct(
        BienTheRepository $repository
    ) {
        $this->repository = $repository;
    }
    protected function prepageModeldata(Request $request): self
    {
        return $this;
    }
}
