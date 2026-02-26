<?php

namespace App\Services;

use App\Repositories\CommentRepository;
use App\Services\BaseService;
use Illuminate\Http\Request;

class CommentService extends BaseService
{

    protected $repository;
    public function __construct(
        CommentRepository $repository
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
