<?php

namespace App\Services;

use App\Models\ThuongHieu;
use App\Repositories\ThuongHieuRepository;
use App\Services\BaseService;
use Illuminate\Http\Request;

class ThuongHieuService extends BaseService
{
    protected $repository;
    public function __construct(
        ThuongHieuRepository $repository
    ) {
        $this->repository = $repository;
    }
    protected function prepageModeldata(Request $request): self
    {
        return $this;
    }
}
