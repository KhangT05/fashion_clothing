<?php

namespace App\Repositories;

use App\Models\Sanpham;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository
{
    public function __construct(
        Sanpham $model
    ) {
        $this->model = $model;
    }
    public function delete($id)
    {
        $model = $this->model->find($id);
        $model->update([
            'trangthai' => 2,
            'deleted_at' => now()
        ]);
        return $model;
    }
    public function restore($id)
    {
        $model = $this->model->find($id);
        $model->update([
            'trangthai' => 1,
            'deleted_at' => null
        ]);
        return $model;
    }
    public function getTrangThai()
    {
        return $this->model->where('trangthai', 2)->paginate(10);
    }
}
