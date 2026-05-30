<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

class RoleService extends BaseService
{
    protected $repository;
    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }
    public function prepageModeldata(Request $request): self
    {
        $fillable = $this->repository->getFillable();
        $payload = $request->only($fillable);
        $this->modelData = $payload;
        return $this;
    }
}
