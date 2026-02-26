<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class BaseRepository
{
    protected $model;
    public function __construct(
        Model $model
    ) {
        $this->model = $model;
    }
    public function pagination(array $specs = [])
    {
        return $this->model
            ->orderBy($specs['sort'][0], $specs['sort'][1])
            ->withRelations($specs['with'])
            ->Keyword($specs['keyword'])
            ->Simple($specs['filter']['simple'])
            ->Complex($specs['filter']['complex'])
            ->when(
                $specs['type'],
                fn($q) => $q->get(),
                fn($q) => $q->paginate($specs['perpage'])
            )
        ;
    }
    public function index()
    {
        return $this->model->all();
    }
    public function create(array $payload = []): Model | null
    {
        return $this->model->create($payload)->fresh();
    }
    public function find($id)
    {
        return $this->model->find($id)->exists();
    }
    public function update(int $id, array $payload = []): Model
    {
        $result = $this->findById($id);
        if (!$result) {
            throw new ModelNotFoundException('Record này không tồn tại');
        }
        $result->update($payload);
        return $result;
    }
    public function trash(int $id = 0)
    {
        $model = $this->findById($id);
        return $model->delete();
    }
    public function findById(int $id = 0, array $relation = [], array $column = ['*']): Model | null
    {
        return $this->model->select($column)->with($relation)->find($id);
    }
    public function findByField(string $field, $value, array $relation = [], array $column = ['*']): Model |null
    {
        return $this->model->select($column)->with($relation)->where($field, $value)->first();
    }
    public function findByFields(array $conditions,  array $relation = [], array $column = ['*']): Model |null
    {
        $query = $this->model->select($column)->with($relation);
        foreach ($conditions  as $field => $val) {
            $query->where($field, $val);
        }
        return $query->get();
    }
    public function getFillable(): array
    {
        return $this->model->getFillable();
    }
    public function getRelationable()
    {
        return $this->model->relationable;
    }
    // public function attach($id, string $relation, $field)
    // {
    //     $record = $this->find($id);
    //     if (!$record) {
    //         throw new ModelNotFoundException('Không tồn tại record này');
    //     }
    //     return $record->$relation()->attach();
    // }
    // public function detach()
    // {
    //     return $this->model->detach();
    // }
    public function delete($id)
    {
        $model = $this->findById($id);
        $model->update([
            'publish' => 2,
            'deleted_at' => now()
        ]);
        return $model;
    }
    public function restore($id)
    {
        $model = $this->findById($id);
        $model->update([
            'publish' => 1,
            'deleted_at' => null
        ]);
        return $model;
    }
}
