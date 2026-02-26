<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Services\BaseService;
use Exception;
use Illuminate\Http\Request;

class OrderService extends BaseService
{
    protected $repository;
    protected $with = ['user', 'chiTiet'];
    public function __construct(OrderRepository $repository)
    {
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
