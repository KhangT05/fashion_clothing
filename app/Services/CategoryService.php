<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Services\BaseService;
use Illuminate\Http\Request;

class CategoryService extends BaseService
{
    protected $repository;
    protected $with = ['product'];
    public function __construct(
        CategoryRepository $repository
    ) {
        $this->repository = $repository;
    }
    protected function perpageModelData(Request $request): self
    {
        return $this->initialBasicData($request);
    }
    public function initialBasicData(Request $request)
    {
        $fillable = $this->repository->getFillable();
        $payload = $request->only($fillable);
        $this->modelData = $payload;
        return $this;
    }
}
