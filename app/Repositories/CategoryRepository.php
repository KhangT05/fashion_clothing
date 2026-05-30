<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository
{
    public function __construct(
        Category $model
    ) {
        $this->model = $model;
    }

    //13-01-2006 Hào thêm phân trang
    public function paginate($perpage = 10)
    {
        return Category::orderBy('publish', 'desc')->paginate($perpage);
    }

    public function search($keyword)
    {
        return $this->model
            ->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            })
            ->paginate(10);
    }

    public function destroy($id)
    {
        return Category::where('id', $id)->update([
            'publish' => 0
        ]);
    }

    public function createCategory($payload)
    {
        return $this->model->create($payload)->fresh();
    }

    public function updateCategory($id, $payload = [])
    {
        $model = $this->model->findOrFail($id);
        $model->update($payload);
        return $model;
    }
    public function getTrangThai()
    {
        return $this->model->where('publish', 1)->get();
    }
}
