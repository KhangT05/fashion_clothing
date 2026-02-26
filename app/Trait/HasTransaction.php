<?php

namespace App\Trait;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait HasTransaction
{
    public function beginTransaction(): self
    {
        DB::beginTransaction();
        return $this;
    }
    public function commit(): self
    {
        DB::commit();
        return $this;
    }
    public function rollBack()
    {
        DB::rollBack();
    }
    public function checkExistsId(?int $id = null): self
    {
        if ($this->model != $this->repository->findById($id)) {
            throw new ModelNotFoundException('Không tồn tại record này');
        }
        return $this;
    }
    public function beforeSave(): self
    {
        return $this;
    }
    public function afterSave(): self
    {
        return $this;
    }
    public function saveModel(?int $id = 0)
    {
        $this->model = ($id) ?
            $this->repository->update($id, $this->modelData) :
            $this->repository->create($this->modelData);
        if (!$this->model) {
            throw new ModelNotFoundException('Không tồn tại record này!');
        }
        $this->result = $this->model;
        return $this;
    }
    public function handleRelation(Request $request): self
    {
        $relations = $this->repository->getRelationable();
        if (count($relations)) {
            foreach ($relations as $relation) {
                if ($request->has($relation)) {
                    $this->model->{$relation}()->sync($request->{$relation});
                }
            }
        }
        return $this;
    }
    public function beforeDelete(int $id = 0): self
    {
        if (!$this->model = $this->repository->findById($id)) {
            throw new ModelNotFoundException('Không tồn tại record này');
        }
        return $this;
    }
    public function afterDelete(int $id = 0): self
    {
        return $this;
    }
    public function performDelete(int $id)
    {
        $this->repository->delete($id);
        return $this;
    }
    public function beforeRestore(int $id): self
    {
        if (!$this->model = $this->repository->findById($id)) {
            throw new ModelNotFoundException('Không tồn tại record này');
        }
        return $this;
    }
    public function afterRestore(int $id = 0): self
    {
        return $this;
    }
    public function performRestore(int $id)
    {
        $this->repository->restore($id);
        return $this;
    }
}
