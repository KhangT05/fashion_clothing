<?php

namespace App\Repositories;

use App\Models\Slide;
use App\Repositories\BaseRepository;

class SlideRepository extends BaseRepository
{
    public function __construct(
        Slide $model
    ) {
        $this->model = $model;
    }
    public function delete($id)
    {
        $model = $this->model->find($id);
        $model->update([
            'trangthai' => 2,
        ]);
        return $model;
    }
    public function restore($id)
    {
        $model = $this->model->find($id);
        $model->update([
            'trangthai' => 1,
        ]);
        return $model;
    }
}
